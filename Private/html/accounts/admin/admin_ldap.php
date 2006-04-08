<?php
/* admin_ldap.php
 * Created on Apr 7, 2006 by @author az - Aaron Zeckoski
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech 
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Users Control";
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

// top header links
$EXTRA_LINKS = "<br/><span style='font-size:9pt;'>" .
	"<a href='index.php'>Admin</a>: " .
	"<a href='admin_ldap.php'><strong>LDAP</strong></a> - " .
	"<a href='admin_users.php'>Users</a> - " .
	"<a href='admin_insts.php'>Institutions</a> - " .
	"<a href='admin_perms.php'>Permissions</a>" .
	"</span>";

?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript">
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

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $ACCOUNTS_PATH.'include/footer.php';
		exit;
	}
?>

<a href="<?= $ACCOUNTS_URL ?>/ldapadmin/index.php">Access the phpLDAPAdmin tool</a><br/>


<?php include $ACCOUNTS_PATH.'include/footer.php'; ?>