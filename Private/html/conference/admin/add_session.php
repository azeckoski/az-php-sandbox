<?php
/* add_session.php
 * Created on May 10, 2006 by @author az - Aaron Zeckoski
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech 
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Add Session";
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

$roomPk = 0;
$timeslotPk = 0;
$conf_room = array();
$conf_timeslot = array();
$mins_used = 0;
$mins_left = 0;
if (!$_REQUEST['room'] || !$_REQUEST['time']) {
	$allowed = false;
	$Message = "Error: room and time must be set.<br/><a href='schedule.php'>Go Back</a>";
} else {
	$roomPk = $_REQUEST['room'];
	$timeslotPk = $_REQUEST['time'];

	// fetch the room and time for the PKs
	$sql = "select * from conf_rooms where pk = '$roomPk'";
	$result = mysql_query($sql) or die("Room query failed ($sql): " . mysql_error());
	$conf_room = mysql_fetch_assoc($result);

	$sql = "select * from conf_timeslots where pk = '$timeslotPk'";
	$result = mysql_query($sql) or die("Timeslot query failed ($sql): " . mysql_error());
	$conf_timeslot = mysql_fetch_assoc($result);

	// find remaining time in this slot and room
	$sql = "select sum(CP.length) as mins_used from conf_proposals CP " .
		"join conf_sessions CS on CS.proposals_pk = CP.pk and " .
		"CS.rooms_pk='$roomPk' and CS.timeslots_pk='$timeslotPk'" .
		"where CP.confID = 'Jun2006'";
	$result = mysql_query($sql) or die("Sessions fetch query failed ($sql): " . mysql_error());
	$conf_sessions = array();
	$row=mysql_fetch_assoc($result);
	$mins_used = $row['mins_used'];
	$mins_left = $conf_timeslot['length_mins'] - $mins_used;
}


// adding
if ($_REQUEST['add'] && $allowed) {

	// write the new value to the sessions table
	if ($_REQUEST['proposals_pk']) {
		$proposalPk = $_REQUEST['proposals_pk'];

		$sql = "select * from conf_proposals where pk = '$proposalPk'";
		$result = mysql_query($sql) or die("Proposals fetch query failed ($sql): " . mysql_error());
		$proposal = mysql_fetch_assoc($result);

		// check for existing sessions in this timeslot
		// and check for this proposal in another slot already
		$sql = "select CS.*, CP.length from conf_sessions CS " .
			"join conf_proposals CP on CP.pk = CS.proposals_pk and CP.pk = '$proposalPk' " .
			"where CS.timeslots_pk = '$timeslotPk'";
		$result = mysql_query($sql) or die("Sessions fetch query failed ($sql): " . mysql_error());
		$conf_sessions = array();
		while($row=mysql_fetch_assoc($result)) { $conf_sessions[$row['pk']] = $row; }

		//echo "<pre>",print_r($conf_sessions),"</pre>";

		$new = true;
		$order = 0; // TODO - figure out ordering
		$error = false;
		if (count($conf_sessions) > 0) {
			$found_session = 0;
			$time_used = 0;
			foreach ($conf_sessions as $key=>$conf_session) {
				// check for this proposal in another timeslot
				if ($conf_session['proposals_pk'] == $proposalPk) {
					if ($conf_session['timeslots_pk'] == $timeslotPk) {
						// this session already exists in this timeslot
						$error = true;
						$Message = "Warning: This session already exists in this timeslot.";
						break;
					} else {
						// this session exists in another timeslot
						$found_session = $conf_session['pk']; // store the session pk
						continue;
					}
				}

				// count up the total time used in this slot
				$time_used += $conf_session['length'];
			}

			// do the length check
			echo "time_used: $time_used >= length:".$conf_timeslot['length_mins']."<br/>";
			if ($time_used >= $conf_timeslot['length_mins']) {
				$error = true;
				$Message = "Error: No more time remaining in this timeslot. You have to remove current proposals from this slot before you can add more.";
			}

			// do the session removal from the other timeslot
			if ($found_session > 0) {
				// remove this session so we can put this proposal somewhere else
				$sql = "DELETE from conf_sessions where pk = '$found_session'";
				$result = mysql_query($sql) or die("Sessions remove failed ($sql): " . mysql_error());
				$Message = "Moved proposal to new timeslot/room";
			}
		}

		if (!$error) {
			// update sql
			$sql = "UPDATE conf_sessions SET rooms_pk=$roomPk, timeslots_pk=$timeslotPk, " .
					"proposals_pk=$proposalPk, ordering=$order, title='' " .
					"WHERE pk = '$sessionPk'";
			if ($new) {
				// insert sql
				$sql = "INSERT INTO conf_sessions" .
					"(date_created, confID, rooms_pk, timeslots_pk, proposals_pk, ordering, title) " .
					"VALUES(NOW(), '$CONF_ID', '$roomPk', '$timeslotPk', '$proposalPk', $order, '')";
			}
			$result = mysql_query($sql) or die("Sessions query failed ($sql): " . mysql_error());
			if (mysql_affected_rows() > 0) {
				$Message = "Created new session for proposal";
				if ($Message) {
					$msg = "?msg=".$Message;
				}
				// redirect to the schedule page
				header('location:schedule.php'.$msg);
				exit;
			} else {
				$Message = "Error: Could not insert sessions record!";
			}
		}
	}
}

// fetch the proposals
$sql = "select CP.*, CS.pk as sessions_pk, CT.start_time from conf_proposals CP " .
	"left join conf_sessions CS on CS.proposals_pk = CP.pk " .
	"left join conf_timeslots CT on CT.pk = CS.timeslots_pk " .
	"where CP.confID = '$CONF_ID' and CP.approved='Y' and CP.type != 'demo'" .
	"order by type desc, length, title";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_proposals = array();
while($row=mysql_fetch_assoc($result)) { $conf_proposals[$row['pk']] = $row; }

//echo "<pre>",print_r($conf_proposals),"</pre>";


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

function setConfProposal(pk) {
	document.adminform.proposals_pk.value = pk;
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
<input type="hidden" name="room" value="<?= $roomPk ?>"/>
<input type="hidden" name="time" value="<?= $timeslotPk ?>"/>
<input type="hidden" name="proposals_pk" value=""/>

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
		<td nowrap="y">
			<strong>Remaining:</strong> <?= $mins_left ?>
		</td>
	</tr>

	</table>
</div>

<table border="0" cellspacing="0" width="100%">

<?php
$line = 0;
$last = 0;
foreach ($conf_proposals as $proposal_pk=>$conf_proposal) {
	$line++;

	$linestyle = "oddrow";
	if (($line % 2) == 0) { $linestyle = "evenrow"; } else { $linestyle = "oddrow"; }

	$disabled = "";
	if ($conf_proposal['sessions_pk']) {
		$disabled = "disabled='Y'";
		$linestyle = "session_exists";
	}
	
	if ($conf_proposal['length'] > $mins_left) {
		$disabled = "disabled='Y'";
	}

	$current = $conf_proposal['type'];
	if ($line == 1 || $current != $last) {
		// next item, print the header again
?>
		<tr>
			<td class='time_header'><?= $current ?></td>
			<td class='schedule_header'>Title</td>
			<td class='schedule_header'>Track</td>
			<td class='schedule_header'>Length</td>
			<td class='schedule_header'></td>
		</tr>
<?php
	}
	$last = $current;
?>
	<tr class="<?= $linestyle ?>">
		<td class="grid">
			<input type="submit" <?= $disabled ?> name="add" value="add" onClick="setConfProposal('<?= $conf_proposal['pk'] ?>');" />
		</td>
		<td class="proposal_title">
			<label title="<?= mysql_real_escape_string($conf_proposal['abstract']) ?>">
				<?= $conf_proposal['title'] ?>
			</label>
		</td>
		<td class="session_date">
			<?= $conf_proposal['track'] ?>
		</td>
		<td class="grid">
			<?= $conf_proposal['length'] ?>
		</td>
		<td class="session_date">
<?php
			if ($conf_proposal['start_time']) {
				echo date('D, M d, g:i a',strtotime($conf_proposal['start_time']));
			} else {
				echo "--";
			}
?>
		</td>
	</tr>
<?php
} // end foreach
?>

</table>
</form>

<br/>
<div class="right">
<div class="rightheader">How to use the add session page</div>
<div style="padding:3px;">
<li>This page contains a full listing of all approved proposals</li>
<li>Click the add button to create a session in the Room and Timeslot indicated at the top of the page</li>
<li>Note that the time remaining in this timeslot is indicated in the upper right</li>
<li>If a proposal is longer than the time remaining in this timeslot then the add button will be disabled</li>
<li>If a proposal has already been added to a timeslot then the add button will be disabled and 
the <span class="session_exists">style will be different</span></li>
</div>
</div>
<?php include $TOOL_PATH.'include/admin_footer.php'; ?>
