<?php
/*
 * file: admin_insts.php
 * Created on Mar 5, 2006 8:26:54 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Admin Institutions";

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
	$Message = "Only admins with <b>admin_accounts</b> or <b>admin_insts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = true;
}


// delete an item
if ($_REQUEST["itemdel"] && $allowed) {
	$itemPK = $_REQUEST["itemdel"];
	$delItem = new Institution($itemPK);
	if (!$delItem->delete()) {
		$Message = "Error: Could not remove item: ".$delItem->Message;
	}
}


// create an empty institution object for searching
$opInst = new Institution();

// get the search
$searchtext = "";
if ($_REQUEST["searchtext"]) { $searchtext = $_REQUEST["searchtext"]; }

// sorting
$sortorder = "name";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }

// show all
if ($_REQUEST["showall"]) { $searchtext = "*"; }

$totalItems = $opInst->getInstsBySearch("*","","pk",true,"db"); // get count of items
$output = "";
$items = array();
if ($searchtext) { // no results without doing a search
	$returnItems = "pk,name,type,rep_pk,repvote_pk";
	$search = $searchtext;
	if (strpos($searchtext,"=") === false) { // there is not a specific search
		$search = "name=*$searchtext*,type=$searchtext*";
	}
	$items = $opInst->getInstsBySearch($search,$sortorder,$returnItems);
	$output = "Returned ". count($items)." items out of " . $totalItems['count'];
} else { // end use ldap check
	$output = "Total insts: $totalItems[count] - No search text entered...";
	if (!$USE_LDAP) {
		$output .= "(<b>LDAP is disabled!</b>)";
	}
}


// Do an LDIF export
if ($_REQUEST["ldif"] && $allowed) {
	$date = date("Ymd-Hi",time());
	$filename = "institutions-" . $date . ".ldif";
	header("Content-type: text/plain; charset=utf-8");
	header("Content-disposition: attachment; filename=$filename\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0");

	// get everything except the "other" inst
	$allItems = $opInst->getInstsBySearch("*","pk","*");
	$items_count = count($allItems);

	echo "# LDIF export of institutions on $date - includes $items_count items\n";
	echo "# Use the following command to insert this export into ldap:\n";
	echo "# ldapadd -x -D \"cn=Manager,dc=sakaiproject,dc=org\" -W -c -f $filename\n";
	echo "# Use the following command to modify ldap using this export:\n";
	echo "# ldapmodify -x -D \"cn=Manager,dc=sakaiproject,dc=org\" -W -c -f $filename\n";
	echo "\n";
	foreach ($allItems as $itemrow) {
		echo "# Institution: $itemrow[name]\n";
		echo "dn: iid=$itemrow[pk],ou=institutions,dc=sakaiproject,dc=org\n";
		echo "objectClass: sakaiInst\n";
		echo "iid: $itemrow[pk]\n";
		echo "o: $itemrow[name]\n";
		echo "instType: $itemrow[type]\n";
		if ($itemrow['city']) { echo "l: $itemrow[city]\n"; }
		if ($itemrow['state']) { echo "st: $itemrow[state]\n"; }
		if ($itemrow['zipcode']) { echo "postalCode: $itemrow[zipcode]\n"; }
		if ($itemrow['country']) { echo "c: $itemrow[country]\n"; }
		if ($itemrow['rep_pk']) { echo "repUid: $itemrow[rep_pk]\n"; }
		if ($itemrow['repvote_pk']) { echo "voteUid: $itemrow[repvote_pk]\n"; }
		echo "\n"; // blank line to separate entries
	}
	exit();
} // END LDIF


// Do the export as requested by the user
if ($_REQUEST["export"] && $allowed) {
	$date = date("Ymd-Hi",time());
	$filename = "institutions-" . $date . ".csv";
	header("Content-type: text/x-csv");
	header("Content-disposition: attachment; filename=$filename\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0");

	$exportItems = $opInst->getInstsBySearch($search,$sortorder,"*");
	$fields = $opInst->getFields();

	$line = 0;
	foreach ($exportItems as $item) {
		$line++;
		if ($line == 1) {
			echo "\"Institutions Export:\",\n";
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


// Use the user pks to get the user info for these users
$userPks = array();
foreach ($items as $item) {
	// this should produce a nice unique list of user pks
	$userPks[$item['rep_pk']] = $item['rep_pk'];
	$userPks[$item['repvote_pk']] = $item['repvote_pk'];
}
unset($userPks['']); // get rid of the empty one
$userInfo = $User->getUsersByPkList($userPks, "pk,username");

//echo "<pre>",print_r($userInfo),"</pre><br/>";

// top header links
$EXTRA_LINKS = "<span class='extralinks'>" .
	"<a href='admin_users.php'>Users</a>" .
	"<a class='active'  href='admin_insts.php'>Institutions</a>" .
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
	var response = window.confirm("Are you sure you want to remove this institution (id="+itempk+")?");
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
	</td>

	<td nowrap="y" align="right">
		<input class="filter" type="submit" name="showall" value="Show All" title="Display all items" />
		<input class="filter" type="submit" name="ldif" value="LDIF" title="Export an LDIF (ldap) file of all institutions" />
		<input class="filter" type="submit" name="export" value="Export" title="Export results based on current filters" />
        <input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>"
        	size="20" title="Enter search text here" />
        <script type="text/javascript">document.adminform.searchtext.focus();</script>
        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements" />
	</td>

	</tr>
	</table>
</div>

<table border="0" cellspacing="0" width="100%">
<tr class='tableheader'>
<td>&nbsp;</td>
<td><a href="javascript:orderBy('name');">Name</a></td>
<td><a href="javascript:orderBy('type');">Type</a></td>
<td>InstRep</td>
<td>VoteRep</td>
<td align="center"><a title="Add a new institution" href="admin_inst.php">+ add new</a></td>
</tr>

<?php
$line = 0;
foreach ($items as $item) {
	$line++;

	// display normally
	$rowstyle = "";
	if ($item["type"] == "non-member") {
		$rowstyle = " style = 'color:red;' ";
	} else if (!$item["rep_pk"]) {
		$rowstyle = " style = 'color:#FF8000;' ";
	}

	$linestyle = "oddrow";
	if ($line % 2 == 0) {
		$linestyle = "evenrow";
	} else {
		$linestyle = "oddrow";
	}
?>

<tr class="<?= $linestyle ?>" <?= $rowstyle ?> >
	<td class="line" align="center"><?= $line ?>&nbsp;</td>
	<td class="line"><?= $item["name"] ?></td>
	<td class="line"><?= $item["type"] ?></td>
	<td class="line" align="left">
<?php 
if ($item["rep_pk"]) {
	$username = $userInfo[$item["rep_pk"]]['username'];
	$short_name = $username;
	if (strlen($username) > 12) {
		$short_name = substr($username,0,9) . "...";
	}
	echo "<label title='$username ($item[rep_pk])'>$short_name</label>";
} else {
	echo "<i>none</i>";
} ?>
	</td>
	<td class="line" align="left">
<?php 
if ($item["repvote_pk"]) {
	$username = $userInfo[$item["repvote_pk"]]['username'];
	$short_name = $username;
	if (strlen($username) > 12) {
		$short_name = substr($username,0,9) . "...";
	}
	echo "<label title='$username ($item[repvote_pk])'>$short_name</label>";
} else {
	echo "<i>none</i>";
} ?>
	</td>
	<td class="line" align="center" style="color:black;">
		<a title="Modify this institution" href="admin_inst.php?pk=<?= $item['pk']?>">edit</a> | 
		<a title="Delete this institution" href="javascript:itemdel('<?= $item['pk'] ?>')">del</a>
	</td>
</tr>

<?php } ?>

</table>
</form>
</div>
</div>
<div class="padding50">&nbsp;  </div>

<div class="padding50">&nbsp;  </div>



<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>
