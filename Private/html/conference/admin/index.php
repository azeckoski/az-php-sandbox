<?php
/*
 * file: admin.php
 * Created on Mar 3, 2006 9:45:03 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Conference Control";
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("admin_conference")) {
	$allowed = 0;
	$Message = "Only admins with <b>admin_conference</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}

// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";

// set header links
$EXTRA_LINKS = 
	"<br/><span style='font-size:9pt;'>" .
	"<a href='index.php'><strong>Admin:</strong></a> " .
	"<a href='attendees.php'>Attendees</a> - " .
	"<a href='proposals.php'>Proposals</a> - " .
	"<a href='check_in.php'>Check In</a> - " .
	"<a href='schedule.php'>Schedule</a> " .
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
// -->
</script>
<?php include $TOOL_PATH.'include/admin_header.php'; ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $TOOL_PATH.'include/admin_footer.php';
		exit;
	}
?>

<table>

    <tr>
      <td valign="top"><a href="attendees.php">Attendees</a></td>
      <td>This allows an admin to view the current list of conference attendees for <?= $CONF_NAME ?> (<?= $CONF_ID ?>)</td>
    </tr>

    <tr>
      <td valign="top"><a href="proposals.php">Proposals</a></td>
      <td>This allows an admin to view and vote on the current list of conference proposals for <?= $CONF_NAME ?> (<?= $CONF_ID ?>)</td>
    </tr>

</table>  

<?php include $TOOL_PATH.'include/admin_footer.php'; // Include the FOOTER ?>