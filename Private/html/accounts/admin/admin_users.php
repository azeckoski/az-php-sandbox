<?php
/*
 * file: admin_users.php
 * Created on Apr 3, 2006 10:52:28 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Users Control";

$ACTIVE_MENU="ACCOUNTS";  //for managing active links on multiple menus
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = false; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("admin_accounts")) {
	$allowed = false;
	$Message = "Only admins with <b>admin_accounts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = true;
}


// delete an item
if ($_REQUEST["itemdel"] && $allowed) {
	$itemPK = $_REQUEST["itemdel"];
	$delUser = new User($itemPK);
	if (!$delUser->delete()) {
		$Message = "Error: Could not remove user: ".$delUser->Message;
	}
}


// do the checkbox actions (perms)
if($allowed && $_POST['userPk'] && is_array($_POST['userPk']) ) {
	$changedPerms = 0;
	foreach( $_POST['userPk'] as $userPk) {
		if ($_POST['perm']) {
			// changing perms for someone
			$opUser = new User($userPk);
			if ($_POST['add_perm']) {
				$opUser->addPerm($_POST['perm']);
			} else if ($_POST['remove_perm']) {
				$opUser->removePerm($_POST['perm']);
			}
			if($opUser->save()) { $changedPerms++; }
		}
	}
	if ($changedPerms > 0) {
		if ($_POST['add_perm']) {
			$Message = "<strong>Added ".$_POST['perm']." permission for $changedPerms users</strong>";
		} else if ($_POST['remove_perm']) {
			$Message = "<strong>Removed ".$_POST['perm']." permission for $changedPerms users</strong>";
		}
	}
}


// get the search
$searchtext = "";
if ($_REQUEST["searchtext"]) { $searchtext = $_REQUEST["searchtext"]; }

// sorting
$sortorder = "username";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }

// show all
if ($_REQUEST["showall"]) { $searchtext = "*"; }

$totalItems = $User->getUsersBySearch("*","","pk",true,"db"); // get count of users
$output = "";
$items = array();
if ($searchtext) { // no results without doing a search
	$returnItems = "pk,username,fullname,email,institution,userStatus,sakaiPerm";
	$search = $searchtext;
	if (strpos($searchtext,"=") === false) { // there is not a specific search
		$search = "username=$searchtext*,firstname=$searchtext*,lastname=$searchtext*," .
				"email=$searchtext*,institution=*$searchtext*,fullname=$searchtext";
	}
	$items = $User->getUsersBySearch($search,$sortorder,$returnItems);
	$output = "Number of entries returned: " . count($items);
} else { // end use ldap check
	$output = "Total users: $totalItems[count] - No search text entered...";
	if (!$USE_LDAP) {
	//	$output .= "(<b>LDAP is disabled!</b>)";
	}
}

//echo "<pre>",print_r($items),"</pre><br/>";



// Do the export as requested by the user
if ($_REQUEST["export"] && $allowed) {
	$date = date("Ymd-Hi",time());
	$filename = "institutions-" . $date . ".csv";
	header("Content-type: text/x-csv");
	header("Content-disposition: attachment; filename=$filename\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0");

	$exportItems = $User->getUsersBySearch($search,$sortorder,"*");
	$items_count = count($exportItems);
	$fields = $User->getFields();

	$line = 0;
	foreach ($exportItems as $item) {
		$line++;
		if ($line == 1) {
			echo "\"Users Export:\",\n";
			echo join(',', $fields) . "\n"; // add header line
		}

		$exportRow = array();
		foreach ($fields as $name) {
			$value = str_replace("\"", "\"\"", $item[$name]); // fix for double quotes
			$exportRow[] = '"' . $value . '"'; // put quotes around each item
		}
		echo join(',', $exportRow) . "\n";
	}
	echo "\n\"Exported on:\",\"" . date($DATE_FORMAT,time()) . "\"\n";

	exit;
} // END EXPORT


// Do an LDIF export
if ($_REQUEST["ldif"] && $allowed) {
	$date = date("Ymd-Hi",time());
	$filename = "users-" . $date . ".ldif";
	header("Content-type: text/plain; charset=utf-8");
	header("Content-disposition: attachment; filename=$filename\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0");

	$allItems = $User->getUsersBySearch("*","pk","*",false,"db");
	$items_count = count($allItems);

	echo "# LDIF export of users on $date - includes $items_count items\n";
	echo "# Note that password CAN NOT transfer so users will have to reset them\n";
	echo "# Use the following command to insert this export into ldap:\n";
	echo "# ldapadd -x -D \"cn=Manager,dc=sakaiproject,dc=org\" -W -c -f $filename\n";
	echo "# Use the following command to modify ldap using this export:\n";
	echo "# ldapmodify -x -D \"cn=Manager,dc=sakaiproject,dc=org\" -W -c -f $filename\n";
	echo "\n";
	foreach ($allItems as $itemrow) {
		// generate LDIF export, do UTF-8 encoding as needed
		echo "# User: $itemrow[pk] - $itemrow[username]\n";
		echo "dn: uid=$itemrow[pk],ou=users,dc=sakaiproject,dc=org\n";
		echo "objectClass: top\n";
		echo "objectClass: person\n";
		echo "objectClass: organizationalPerson\n";
		echo "objectClass: inetOrgPerson\n";
		echo "objectClass: sakaiAccount\n";
		echo "uid: $itemrow[pk]\n";
		echo "userPassword: {MD5}wEzZhXMc+aSKrvl2hq+S2g==\n";

		// had to encrypt all of these entries
		$itemrow['firstname'] = mb_convert_encoding($itemrow['firstname'],"UTF-8","auto");
		$itemrow['lastname'] = mb_convert_encoding($itemrow['lastname'],"UTF-8","auto");
		$fullname = mb_convert_encoding($itemrow['firstname']." ".$itemrow['lastname'],"UTF-8","auto");
		echo "cn:: ".base64_encode($fullname)."\n";
		echo "givenname:: ".base64_encode($itemrow['firstname'])."\n";
		echo "sn:: ".base64_encode($itemrow['lastname'])."\n";
		echo "sakaiUser: $itemrow[username]\n";

		// convert the string of perms to mutiple lines
		$permArray = explode(":",trim($itemrow['sakaiPerms']));
		if (is_array($permArray)) {
			foreach ($permArray as $value) {
				if ($value) {
					echo "sakaiPerm: $value\n";
				}
			}
		}
		// convert the string of status to mutiple lines
		$permArray = explode(":",trim($itemrow['userStatus']));
		if (is_array($permArray)) {
			foreach ($permArray as $value) {
				if ($value) {
					echo "userStatus: $value\n";
				}
			}
		}
		echo "mail: $itemrow[email]\n";
		echo "iid: $itemrow[institution_pk]\n";
		if ($itemrow['institution']) {
			if (is_utf8($itemrow['institution']))
				echo "o:: ".base64_encode($itemrow['institution'])."\n";
			else
				echo "o: $itemrow[institution]\n";
		}
		if ($itemrow['primaryRole']) { echo "primaryRole: $itemrow[primaryRole]\n"; }
		if ($itemrow['secondaryRole']) { echo "secondaryRole: $itemrow[secondaryRole]\n"; }
		if ($itemrow['phone']) { echo "telephoneNumber: $itemrow[phone]\n"; }
		if ($itemrow['fax']) { echo "facsimileTelephoneNumber: $itemrow[fax]\n"; }
		if ($itemrow['address']) {
			$itemrow['address'] = preg_replace("/[\r\n]/s","\n",trim($itemrow['address']));
			echo "postalAddress:: ".base64_encode($itemrow['address'])."\n";
		}
		if ($itemrow['city']) {
			if (is_utf8($itemrow['city']))
				echo "l:: ".base64_encode($itemrow['city'])."\n";
			else
				echo "l: $itemrow[city]\n";
		}
		if ($itemrow['state']) {
			if (is_utf8($itemrow['state']))
				echo "st:: ".base64_encode($itemrow['state'])."\n";
			else
				echo "st: $itemrow[state]\n";
		}
		if ($itemrow['zipcode']) { echo "postalCode: $itemrow[zipcode]\n"; }
		if ($itemrow['country']) {
			if (is_utf8($itemrow['country']))
				echo "c:: ".base64_encode($itemrow['country'])."\n";
			else
				echo "c: $itemrow[country]\n";
		}
		echo "\n"; // blank line to separate entries
	}
	exit();
}

// top header links
$EXTRA_LINKS = "<span class='extralinks'>" .
	"<a class='active' href='admin_users.php'>Users</a>" .
	"<a href='admin_insts.php'>Institutions</a>" .
	"<a href='admin_perms.php'>Permissions</a>" .
	"<a href='admin_roles.php'>Roles</a>" .
	"</span>";

?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript">
<!--
function orderBy(newOrder) {
	if (document.adminform.sortorder.value == newOrder) {
		if (newOrder.match("^.* desc$")) {
			document.adminform.sortorder.value = newOrder.replace(" desc","");
		} else {
			document.adminform.sortorder.value = newOrder;
		}
	} else {
		document.adminform.sortorder.value = newOrder;
	}
	document.adminform.submit();
	return false;
}

function itemdel(itempk) {
	var response = window.confirm("Are you sure you want to remove this user (id="+itempk+")?");
	if (response) {
		document.adminform.itemdel.value = itempk;
		document.adminform.submit();
		return false;
	}
}
// -->
</script>
<?php include $ACCOUNTS_PATH.'include/header.php'; ?>

<div id="maincontent">
<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $ACCOUNTS_PATH.'include/footer.php';
		exit;
	}
?>
<div id="maindata">

<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>" />
<input type="hidden" name="itemdel" value="" />

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>

	<td nowrap="y" width="5%"><b style="font-size:1.1em;">Search:&nbsp;</b></td>
	<td nowrap="y" align="left">
		<?= $output ?>
	</td>

	<td nowrap="y" align="left">
		<strong>Perms:</strong>
<?php
	// get the list of permissions
	$perms_sql="select * from permissions";
	$perm_result = mysql_query($perms_sql) or die("Query failed ($perms_sql): " . mysql_error());	
	echo "<select name='perm'>\n";
	while($row = mysql_fetch_assoc($perm_result)) {
		echo "<option title=\"$row[perm_description]\" value=\"$row[perm_name]\">$row[perm_name]</option>\n";
	}
	echo "</select>\n";
?>
		<input class="filter" type="submit" name="add_perm" value="Add" title="Assign this permission to multiple users"/>
		<input class="filter" type="submit" name="remove_perm" value="Remove" title="Remove this permission from multiple users"/>
	</td>

	<td nowrap="y" align="right" width="10%">
		<input class="filter" type="submit" name="showall" value="Show All" title="Display all items" tabindex="3" />
		<!--<input class="filter" type="submit" name="ldif" value="LDIF" title="Export an LDIF (ldap) file of all users" tabindex="4" />
		--><input class="filter" type="submit" name="export" value="Export" title="Export results based on current search" tabindex="5" />
		&nbsp;
	</td>

	<td nowrap="y" align="right" width="10%">
        <input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>"
        	size="20" title="Enter search text here"  tabindex="1" />
        <input class="filter" type="submit" name="search" value="Search" title="Search the users" tabindex="2" />
	</td>

	</tr>
	</table>
</div>

<table border="0" cellspacing="0" width="100%">
<tr class='tableheader'>
<td></td>
<td></td>
<td><a href="javascript:orderBy('username');">username</a></td>
<td><a href="javascript:orderBy('lastname');">Name</a></td>
<td><a href="javascript:orderBy('email');">Email</a></td>
<td><a href="javascript:orderBy('institution');">Institution</a></td>
<td align="center"><a title="Add a new user" href="admin_user.php">+ add new user</a></td>
</tr>

<?php
$line = 0;
foreach ($items as $item) {
	$line++;
	$printInst = $item['institution'];
	if (strlen($printInst) > 38) {
		$printInst = substr($printInst,0,35) . "...";
	}

	$rowstyle = "";
	if (strpos($item['userStatus'],"active") === false) {
		$rowstyle = " style = 'color:red;' ";
	} else if (strpos($item['sakaiPerm'],"admin_accounts") !== false) {
		$rowstyle = " style = 'color:darkgreen;' ";
	} else if (strpos($item['sakaiPerm'],"admin_insts") !== false) {
		$rowstyle = " style = 'color:darkblue;' ";
	}
	
	$linestyle = "oddrow";
	if ($line % 2 == 0) {
		$linestyle = "evenrow";
	} else {
		$linestyle = "oddrow";
	}
?>
<tr class="<?= $linestyle ?>" <?= $rowstyle ?> >
	<td class="line" align="center"><em><?= $line ?>&nbsp;</em></td>
	<td class="line" align="center">
		<input type="checkbox" name="userPk[]" value="<?= $item['pk'] ?>" />
	</td>
	<td class="line"><?= $item['username'] ?></td>
	<td class="line"><?= $item['fullname'] ?></td>
	<td class="line"><?= $item['email'] ?></td>
	<td class="line"><?= $printInst ?></td>
	<td class="line" align="center" style="color:black;">
		<a title="Edit this user" href="admin_user.php?pk=<?= $item['pk'] ?>">edit</a> |
		<a title="Delete this user" href="javascript:itemdel('<?= $item['pk'] ?>')">del</a>
	</td>
</tr>
<?php } /* end for loop */ ?>

</table>

</form>

<script type="text/javascript">
<!--
	document.adminform.searchtext.focus();
// -->
</script>
</div>

</div>
<div class="padding50">&nbsp;  </div>

<div class="padding50">&nbsp;  </div>


<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>