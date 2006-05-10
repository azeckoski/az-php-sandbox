<?php
/*
 * file: schedule.php
 * Created on May 09, 8:00 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Scheduling";
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


// fetch the conference rooms
$sql = "select * from conf_rooms where confID = '$CONF_ID'";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_rooms = array();
while($row=mysql_fetch_assoc($result)) { $conf_rooms[$row['pk']] = $row; }

// fetch the conference timeslots
$sql = "select * from conf_timeslots where confID = '$CONF_ID'";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_timeslots = array();
while($row=mysql_fetch_assoc($result)) { $conf_timeslots[$row['pk']] = $row; }

// fetch the conf sessions
$sql = "select * from conf_sessions where confID = '$CONF_ID' order by ordering";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_sessions = array();
while($row=mysql_fetch_assoc($result)) { $conf_sessions[$row['pk']] = $row; }

// fetch the proposals that have sessions assigned
$sql = "select CP.pk, CP.title, CP.length from conf_proposals CP " .
		"join conf_sessions CS on CS.proposals_pk = CP.pk " .
		"where CP.confID = '$CONF_ID'";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_proposals = array();
while($row=mysql_fetch_assoc($result)) { $conf_proposals[$row['pk']] = $row; }


// now put these together into a 3D array
$timeslots = array();
foreach($conf_timeslots as $conf_timeslot) {
	$rooms = array();
	if ($conf_timeslot['type'] != 'event') {
		// we don't need all the rooms inserted for rows that don't use them
		$rooms['0'] = '0'; // placeholder
	} else {
		foreach($conf_rooms as $conf_room) {
			// TODO - insert the session PKs array in the table here
			$sessions = array();
			foreach($conf_sessions as $conf_session) {
				if ($conf_session['timeslots_pk'] == $conf_timeslot['pk'] &&
					$conf_session['rooms_pk'] == $conf_room['pk']) {
						$sessions[$conf_session['pk']] = $conf_session;
				}
			}
			$rooms[$conf_room['pk']] = $sessions;
		}
	}
	$timeslots[$conf_timeslot['pk']] = $rooms;
}


echo "<pre>",print_r($timeslots),"</pre>"; 

// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
$CSS_FILE2 = $TOOL_URL."/include/schedule.css";
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


<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>"/>

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
		<td nowrap="y"><b style="font-size:1.1em;">Info:</b></td>
		<td nowrap="y" colspan="5">
			<div style="float:left;">
				<strong><?= $CONF_NAME ?></strong>
				(<?= date($SHORT_DATE_FORMAT,strtotime($CONF_START_DATE)) ?> - <?= date($SHORT_DATE_FORMAT,strtotime($CONF_END_DATE)) ?>)
			</div>
			<div style="float:right; padding-right: 30px;">
		</td>
	</tr>

	</table>
</div>

<table border="0" cellspacing="0" width="100%">

<?php
// create the grid
$line = 0;
$last_date = 0;
foreach ($timeslots as $timeslot_pk=>$rooms) {
	$line++;

	$timeslot = $conf_timeslots[$timeslot_pk];
	
	$current_date = date('D, M d',strtotime($timeslot['start_time']));
	if ($line == 1 || $current_date != $last_date) {
		// next date, print the header again
		echo "<tr>";
		echo "<td class='time_header'>$current_date</td>\n";
		foreach($conf_rooms as $conf_room) {
			$type = "schedule_header";
			if ($conf_room['BOF'] == 'Y') { $type = "bof_header"; }
			echo "<td class='$type' nowrap='Y'>".$conf_room['title']."</td>\n";
		}
		echo "</tr>\n\n";
	}
	$last_date = $current_date;

	$linestyle = "event";
	switch ($timeslot['type']) {
		case "break": $linestyle = "break"; break;
		case "bof": $linestyle = "bof"; break;
		case "lunch": $linestyle = "lunch"; break;
		case "coffee": $linestyle = "coffee"; break;
		case "keynote": $linestyle = "keynote"; break;
		case "special": $linestyle = "keynote"; break;
		case "closed": $linestyle = "closed"; break;
		default: $linestyle = "event";
	}
?>
<tr class="<?= $linestyle ?>">
	<td class="time" nowrap='Y'>
		<?= date('g:i a',strtotime($timeslot['start_time'])) ?>
	</td>


<?php	
	if ($timeslot['type'] != "event") {
		echo "<td align='center' colspan='".count($conf_rooms)."'>".$timeslot['title']."</td>";
	} else {
		// print the grid selector
		foreach ($rooms as $room_pk=>$room) { ?>
	<td class="grid">
<?php
	// session check here
	$total_length = 0; // TODO - check length used
	if (is_array($room)) {
		$counter = 0;
		foreach ($room as $session_pk=>$session) {
			$counter++;

			$gridclass = "grid_event_odd";
			if (($line % 2) == 0) { $gridclass = "grid_event_even"; }

			$proposal = $conf_proposals[$session['proposals_pk']];
			$total_length += $proposal['length'];
			echo "<div class='$gridclass'>".$proposal['title'].
				"&nbsp;<a href='add_session.php?delete=1&amp;pk=".$session_pk."'>x</a>" .
				"</div>";
		}
	}
?>
		<a href="add_session.php?room=<?= $room_pk ?>&amp;time=<?= $timeslot_pk ?>">+</a>
	</td>
<?php	}
	}
?>
</tr>

<?php 
} ?>

</table>
</form>

<?php include $TOOL_PATH.'include/admin_footer.php'; ?>
