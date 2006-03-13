<?php
/*
 * file: admin.php
 * Created on Mar 3, 2006 9:45:03 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Admin Accounts Control";
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

// set header links
$EXTRA_LINKS = "<br><span style='font-size:9pt;'>";
if ($USE_LDAP) {
	$EXTRA_LINKS .=	"<a href='admin_users.php'>Users admin</a> - ";
}
$EXTRA_LINKS .= "<a href='admin_ldap.php'>LDAP admin</a> - " .
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

<table>
<?php if ($USE_LDAP) { ?>
    <tr>
      <td valign="top"><a href="admin_ldap.php">LDAP Control</a></td>
      <td>This allows control of LDAP user accounts and related properties<br>
      Edit the user to set them as an institutional rep or voting rep and to control admin privileges<br>
      LDAP accounts should be used instead of internal accounts
      </td>
    </tr>
<?php } ?>
    <tr>
      <td valign="top"><a href="admin_users.php">Users Control</a></td>
      <td>This allows control of internal user accounts and related properties<br>
      Edit the user to set them as an institutional rep or voting rep and to control admin privileges
      </td>
    </tr>
    <tr>
      <td valign="top"><a href="admin_insts.php">Institutional Control</a></td>
      <td>This allows control of instituions<br>
      Edit the institution to change the name, abbreviation, or type
      </td>
    </tr>
</table>  

<?php include 'include/footer.php'; // Include the FOOTER ?>