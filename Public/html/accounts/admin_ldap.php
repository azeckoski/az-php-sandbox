<?php
/*
 * file: admin_ldap.php
 * Created on Mar 8, 2006 10:52:28 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Admin LDAP Control";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require 'include/check_authentic.php';

// login if not autheticated
require 'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
if (!$USER["admin_accounts"]) {
	$allowed = 0;
	$Message = "Only admins with <b>admin_accounts</b> or <b>admin_insts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}


// delete ldap item
if ($_REQUEST["ldapdel"]) {
	$LDAP_PK = $_REQUEST["ldapdel"];
	$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT);
	if ($ds) {
		$admin_bind=@ldap_bind($ds, $LDAP_ADMIN_DN, $LDAP_ADMIN_PW);
		if ($admin_bind) {
			// DN FORMAT: uid=#,ou=users,dc=sakaiproject,dc=org
			$user_dn = "uid=$LDAP_PK,ou=users,dc=sakaiproject,dc=org";
			$delresult = ldap_delete($ds,$user_dn);
			if ($delresult) {
				$output = "Removed ldap user<br>";
			} else {
				$output = "Failed to remove ldap user<br>";
			}
			// TODO - clean up inst rep and vote rep
		} else {
			$output ="ERROR: Read bind to ldap failed";
		}
		ldap_close($ds); // close connection
	} else {
	   $output = "<h4>CRITICAL Error: Unable to connect to LDAP server</h4>";
	}	
}


// get the search
$searchtext = "";
if ($_REQUEST["searchtext"]) { $searchtext = $_REQUEST["searchtext"]; }

$output = "Enter search text to the right";
if ($USE_LDAP && $searchtext) {
	$ds=ldap_connect($LDAP_SERVER,$LDAP_PORT);  // must be a valid LDAP server!
	if ($ds) {
		$reporting_level = error_reporting(E_ERROR); // suppress warning messages
		$read_bind=ldap_bind($ds, $LDAP_READ_DN, $LDAP_READ_PW); // do bind as read user
		if ($read_bind) {
			// Searching for (sakaiUser=username)
			$attribs = array("cn","givenname","sn","uid","sakaiuser","mail","dn","o","sakaiperm");
		   	$sr=ldap_search($ds, "ou=users,dc=sakaiproject,dc=org", "sakaiUser=$searchtext", $attribs); // expect sr=array
	
			$output = "Number of ldap entries returned: " . ldap_count_entries($ds, $sr);
			$info = ldap_get_entries($ds, $sr); // $info["count"] = items returned

		} else {
			$output ="ERROR: Read bind to ldap failed";
		}
		ldap_close($ds); // close connection
		error_reporting($reporting_level); // reset error reporting
					
	} else {
	   $output = "<h4>CRITICAL Error: Unable to connect to LDAP server</h4>";
	}
} else { // end use ldap check
	$output = "No seach text entered...";
	if (!$USE_LDAP) {
		$output = "<b>LDAP is disabled!</b>";
	}
}


// set header links
$EXTRA_LINKS = "<br><span style='font-size:9pt;'><a href='admin_users.php'>Users admin</a> - " .
	"LDAP admin - " .
	"<a href='admin_insts.php'>Institutions admin</a></span>";
?>

<?php include 'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<script>
<!--
function orderBy(newOrder) {
	if (document.adminform.sortorder.value == newOrder) {
		document.adminform.sortorder.value = newOrder + " desc";
	} else {
		document.adminform.sortorder.value = newOrder;
	}
	document.adminform.submit();
	return false;
}

function ldapdel(itempk) {
	var response = window.confirm("Are you sure you want to remove this user (id="+itempk+") from ldap?");
	if (response) {
		document.adminform.ldapdel.value = itempk;
		document.adminform.submit();
		return false;
	}
}
// -->
</script>
<?php include 'include/header.php'; // INCLUDE THE HEADER ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include 'include/footer.php';
		exit;
	}
?>

<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>">
<input type="hidden" name="ldapdel" value="">

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>

	<td nowrap="y" width="5%"><b style="font-size:1.1em;">Search:&nbsp;</b></td>
	<td nowrap="y" align="left">
		<?= $output ?>
	</td>

	<td nowrap="y" align="left">
		<a href="admin_ldap_add.php">Add user to ldap</a>
	</td>

	<td nowrap="y" align="right">
        <input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>"
        	length="20" title="Enter search text here">
        <script>document.adminform.searchtext.focus();</script>
        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements">
	</td>

	</tr>
	</table>
</div>

<table border="0" cellspacing="0" width="100%">
<tr class='tableheader'>
<td><a href="javascript:orderBy('username');">username</a></td>
<td><a href="javascript:orderBy('lastname');">Name</a></td>
<td><a href="javascript:orderBy('email');">Email</a></td>
<td><a href="javascript:orderBy('institution');">Institution</a></td>
<td align="center">Rep</td>
<td align="center"><a href="javascript:orderBy('date_created');">Date</a></td>
</tr>

<?php 
for ($line=0; $line<$info["count"]; $line++) { 
	if (strlen($row["institution"]) > 38) {
		$row["institution"] = substr($row["institution"],0,35) . "...";
	}

	$rowstyle = "";
	if ($not_activated) {
		$rowstyle = " style = 'color:red;' ";
	} else if ($admin_reqs) {
		$rowstyle = " style = 'color:darkgreen;' ";
	} else if ($admin_insts) {
		$rowstyle = " style = 'color:darkblue;' ";
	} else if ($admin_accounts) {
		$rowstyle = " style = 'color:#330066;' ";
	}
	
	$linestyle = "oddrow";
	if ($line % 2 == 0) {
		$linestyle = "evenrow";
	} else {
		$linestyle = "oddrow";
	}
?>
<tr id="<?= $linestyle ?>" <?= $rowstyle ?> >
	<td class="line"><?= $info[$line]["sakaiuser"][0] ?></td>
	<td class="line"><?= $info[$line]["givenname"][0] ?> <?= $info[$line]["sn"][0] ?></td>
	<td class="line"><?= $info[$line]["mail"][0] ?></td>
	<td class="line"><?= $info[$line]["o"][0] ?></td>
	<td class="line" align="center"></td>
	<td class="line" align="center">
		<a href="admin_ldap_add.php?pk=<?= $info[$line]["uid"][0] ?>">edit</a> |
		<a href="javascript:ldapdel('<?= $info[$line]["uid"][0] ?>')">del</a>
	</td>
</tr>
<?php } // end for loop ?>

</table>

</form>

<?php include 'include/footer.php'; // Include the FOOTER ?>