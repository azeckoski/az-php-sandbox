<?php
/* delete_session.php
 * Created on May 10, 2006 by @author az - Aaron Zeckoski
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech 
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Delete Session";
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
		"Try out this one instead: <a href='$TOOL_URL/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}


// remove this session so we can put this proposal somewhere else
if ($_REQUEST['pk'] && $allowed) {
	$session_pk = $_REQUEST['pk'];

	if ($_REQUEST['confirm']) {
		$sql = "DELETE from conf_sessions where pk = '$session_pk'";
		$result = mysql_query($sql) or die("Sessions remove failed ($sql): " . mysql_error());
		$Message = "Removed proposal from timeslot/room";
		if ($Message) {
			$msg = "?msg=".$Message;
		}
		// redirect to the schedule page
		header('location:schedule.php'.$msg);
		exit;
	} else {
		$Message = "<div style='border:3px solid #9999FF;padding:3px;text-align:center;'>" .
			"Are you sure you want to remove this session?<br/>" .
			"<a href='".$_SERVER['PHP_SELF']."?confirm=1&amp;pk=".$session_pk."'>yes</a> " .
			"&nbsp; <a href='schedule.php'>no</a></div>";
	}
} else {
	$Message = "ERROR: Delete session failed! No pk found!";
}


// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
$DATE_FORMAT = "M d, Y h:i A";

// set header links
$EXTRA_LINKS = 
	"<br/><span style='font-size:9pt;'>" .
	"<a href='index.php'>Admin:</a> " .
	"<a href='attendees.php'>Attendees</a> - " .
	"<a href='proposals.php'>Proposals</a> - " .
	"<a href='check_in.php'>Check In</a> - " .
	"<a href='schedule.php'><strong>Schedule</strong></a> " .
	"</span>";
?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript">
<!--
// -->
</script>
<?php include $TOOL_PATH.'include/admin_header.php'; ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		echo $Message;
		include $TOOL_PATH.'include/admin_footer.php';
		exit;
	}
?>

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
		<td nowrap="y"><b style="font-size:1.1em;">Info:</b></td>
		<td nowrap="y">
			<div style="float:left;">
				<strong><?= $CONF_NAME ?></strong>
				(<?= date($SHORT_DATE_FORMAT,strtotime($CONF_START_DATE)) ?> - <?= date($SHORT_DATE_FORMAT,strtotime($CONF_END_DATE)) ?>)
			</div>
			<div style="float:right; padding-right: 30px;">
		</td>
		<td nowrap="y">
			<strong>Room:</strong> <?= $conf_room['title'] ?>
		</td>
		<td nowrap="y">
			<strong>Timeslot:</strong> <?= date('D, M d, g:i a',strtotime($conf_timeslot['start_time'])) ?>
		</td>
	</tr>

	</table>
</div>

<?= $Message ?>

<?php include $TOOL_PATH.'include/admin_footer.php'; ?>
