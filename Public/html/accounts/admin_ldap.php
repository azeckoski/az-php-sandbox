<?php
/*
 * file: admin_ldap.php
 * Created on Mar 8, 2006 10:52:28 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once ("tool_vars.php");

$PAGE_NAME = "Admin Accounts Control";
$Message = "";

// connect to database
require "mysqlconnect.php";

// check authentication
require "check_authentic.php";

// login if not autheticated
require "auth_login_redirect.php";

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
if (!$USER["admin_accounts"]) {
	$allowed = 0;
	$Message = "Only admins with <b>admin_accounts</b> or <b>admin_insts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}

// set header links
$EXTRA_LINKS = "<br><span style='font-size:9pt;'><a href='admin_users.php'>Users admin</a> - " .
	"LDAP admin - " .
	"<a href='admin_insts.php'>Institutions admin</a></span>";
?>

<? include 'top_header.php'; // INCLUDE THE HTML HEAD ?>
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
// -->
</script>
<? include 'header.php'; // INCLUDE THE HEADER ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include 'footer.php';
		exit;
	}
?>

<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>">

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>

	<td nowrap="y" width="5%"><b style="font-size:1.1em;">Search:&nbsp;</b></td>
	<td nowrap="y" align="left">
		Enter search text to the right
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

Info here

<?php include 'footer.php'; // Include the FOOTER ?>