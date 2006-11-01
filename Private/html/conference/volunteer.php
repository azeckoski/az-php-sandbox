<?php
/* add_session.php
 * Created on May 20, 2006 by @author az - Aaron Zeckoski
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech 
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Volunteer";
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
//require $ACCOUNTS_PATH.'include/auth_login_redirect.php';


// adding volunteer
if ($_REQUEST['sessions_pk'] && $User->pk) {
	$error = false;
	$sessionPk = $_REQUEST['sessions_pk'];

	if ($_REQUEST['C'] || $_REQUEST['R']) {
		// adding a volunteer for this session

		$sql = "select * from conf_sessions where pk = '$sessionPk'";
		$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
		$conf_session = mysql_fetch_assoc($result);
		if (empty($conf_session)) {
			echo "FATAL ERROR: Invalid session pk: $sessionPk <br/>";
			echo "<a href='$_SERVER[PHP_SELF]'>BACK</a><br/>";
			exit;
		}

		$volunteer_sql = "";
		if ($_REQUEST['C'] && !$conf_session['convenor_pk']) {
			$volunteer_sql = "convenor_pk = '$User->pk'";
			$Message = "convenor (".$User->fullname.") added to session";
		} else if ($_REQUEST['R'] && !$conf_session['recorder_pk']) {
			$volunteer_sql = "recorder_pk = ".$User->pk;
			$Message = "Recorder (".$User->fullname.") added to session";
		} else {
			// can only add a convenor or recorder if one is not already set
			$error = true;
		}

		if (!$error) {
			// update sql
			$sql = "UPDATE conf_sessions SET $volunteer_sql WHERE pk = '$sessionPk'";
			$result = mysql_query($sql) or die("Sessions query failed ($sql): " . mysql_error());
			if (mysql_affected_rows() <= 0) {
				$Message = "Error: Could not insert volunteer!";
			}
		}
	} else if ($_REQUEST['NC'] || $_REQUEST['NR']) {
		// removing the volunteer from a session
		$volunteer_sql = "";
		if ($_REQUEST['NC']) {
			$volunteer_sql = "convenor_pk = null";
			$Message = "convenor removed from session";
		} else if ($_REQUEST['NR']) {
			$volunteer_sql = "recorder_pk = null";
			$Message = "Recorder removed from session";
		} else {
			// can only add a convenor or recorder if one is not already set
			$error = true;
		}

		if (!$error) {
			// update sql
			$sql = "UPDATE conf_sessions SET $volunteer_sql WHERE pk = '$sessionPk'";
			$result = mysql_query($sql) or die("Sessions query failed ($sql): " . mysql_error());
			if (mysql_affected_rows() <= 0) {
				$Message = "Error: Could not remove volunteer!";
			}
		}
	}
}

// fetch the proposals
$sql = "select CP.*, CS.timeslots_pk, CS.pk as sessions_pk, CS.convenor_pk, CS.recorder_pk, " .
	"CT.start_time, CR.title as room_title from conf_proposals CP " .
	"join conf_sessions CS on CS.proposals_pk = CP.pk " .
	"join conf_timeslots CT on CT.pk = CS.timeslots_pk and CT.start_time is not null " .
	"left join conf_rooms CR on CR.pk = CS.rooms_pk " .
	"where CP.confID = '$CONF_ID' and CP.approved='Y' and CP.type != 'demo' " .
	"and CP.type != 'BOF' order by start_time, track";
//echo "$sql<br/>"; 
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_proposals = array();
while($row=mysql_fetch_assoc($result)) { $conf_proposals[$row['pk']] = $row; }

//echo "<pre>",print_r($conf_proposals),"</pre>";

// fetch the list of sessions for this user to stop time conflicts
$user_conf_sessions = array();
if ($User->pk) {
	$sql = "select distinct(timeslots_pk) as pk from conf_sessions " .
			"where (recorder_pk = '$User->pk' or convenor_pk='$User->pk') " .
			"and confID='$CONF_ID'";
	$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
	while($row=mysql_fetch_assoc($result)) { $user_conf_sessions[$row['pk']] = $row; }
	//echo "<pre>",print_r($user_conf_sessions),"</pre>";
}


// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
$CSS_FILE2 = $TOOL_URL."/include/schedule.css";
$DATE_FORMAT = "M d, Y h:i A";

// set header links
$EXTRA_LINKS = 
	"<br/><span style='font-size:9pt;'>" .
	"<a href='registration/'>Registration</a> - " .
	"<a href='proposals/'>Proposals</a> - " .
	"<a href='volunteer.php'><strong>Volunteer</strong></a> " .
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

function setSessions(pk) {
	document.adminform.sessions_pk.value = pk;
}
// -->
</script>
<?php include $TOOL_PATH.'include/admin_header.php'; ?>

<?= $Message ?>


<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sessions_pk" value=""/>

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
		<td nowrap="y"><b style="font-size:1.1em;">Info:</b></td>
		<td nowrap="y">
			<div style="float:left;">
				<strong><?= $CONF_NAME ?></strong>
				(<?= date($SHORT_DATE_FORMAT,strtotime($CONF_START_DATE)) ?> - <?= date($SHORT_DATE_FORMAT,strtotime($CONF_END_DATE)) ?>)
			</div>
		</td>

		<td nowrap="y">
			<div style="float:right;">
				<em>Helpful instructions available at the bottom of this page</em>&nbsp;
			</div>
		</td>
	</tr>

	</table>
</div>

<div class="colorkey">
	<div class="colorkeyheader">Color Key</div>
	<div style="padding:3px;">
		<b style="font-size:1.1em;">Key:</b> 
	<?php if($User->pk) { ?>
		<div class="convenor_user" style='display:inline;'>&nbsp;You are the convenor&nbsp;</div>
		&nbsp;
		<div class="recorder_user" style='display:inline;'>&nbsp;You are the recorder&nbsp;</div>
		&nbsp;
	<?php } ?>
		<div class="convenor_exists" style='display:inline;'>&nbsp;Convenor set&nbsp;</div>
		&nbsp;
		<div class="recorder_exists" style='display:inline;'>&nbsp;Recorder set&nbsp;</div>
		&nbsp;
		<div class="recorder_convenor_exist" style='display:inline;'>&nbsp;Covenor and Recorder set&nbsp;</div>
		&nbsp;
	</div>
</div>

<table border="0" cellspacing="0" width="100%">

<?php
$line = 0;
$last = 0;
foreach ($conf_proposals as $proposal_pk=>$conf_proposal) {
	$line++;

	$linestyle = "oddrow";
	if (($line % 2) == 0) { $linestyle = "evenrow"; } else { $linestyle = "oddrow"; }

	$disabledN = "";
	if (strtotime($CONF_START_DATE) < time()) {
		// cannot unvolunteer after the conference start date
		$disabledN = "disabled='y'";
	}

	$disabledR = "";
	$disabledC = "";
	// cannot volunteer for something that someone else already volunteered for
	if ($conf_proposal['recorder_pk'] && $conf_proposal['convenor_pk']) {
		$disabledC = "disabled='y'";
		$disabledR = "disabled='y'";
		$linestyle = "recorder_convenor_exist";
	} else if ($conf_proposal['recorder_pk']) {
		$disabledR = "disabled='y'";
		$linestyle = "recorder_exists";
	} else if ($conf_proposal['convenor_pk']) {
		$disabledC = "disabled='y'";
		$linestyle = "convenor_exists";
	}

	// make it easy for someone to tell they are a convenor or recorder
	if ($User->pk) {
		if ($conf_proposal['convenor_pk'] == $User->pk) {
			$linestyle = "convenor_user";
		} else if ($conf_proposal['recorder_pk'] == $User->pk) {
			$linestyle = "recorder_user";
		}
		if (array_key_exists($conf_proposal['timeslots_pk'],$user_conf_sessions) &&
			$conf_proposal['length'] > 45) {
			$disabledC = "disabled='y'";
			$disabledR = "disabled='y'";	
		}
	}

	//$current = $conf_proposal['type'];
	$current = date('D, M d',strtotime($conf_proposal['start_time']));
	if ($line == 1 || $current != $last) {
		// next item, print the header again
?>
		<tr>
			<td class='time_header'><?= $current ?></td>
			<td class='schedule_header'>Title</td>
			<td class='schedule_header'>Track</td>
			<td class='schedule_header'>Room</td>
			<td class='schedule_header'>Length</td>
			<td class='schedule_header'>Scheduled</td>
		</tr>
<?php
	}
	$last = $current;
?>
	<tr class="<?= $linestyle ?>">
		<td valign="middle" align="center">
<?php if (!$User->pk) { ?>
			<label title="Login to enable the volunteer buttons" style="font-size:.8em;">
<?php
	if ($conf_proposal['convenor_pk']) { echo "<strong>Conv</strong>"; } else { echo "NC"; }
	echo ", ";
	if ($conf_proposal['recorder_pk']) { echo "<strong>Rec</strong>"; } else { echo "NR"; }
?>
			</label>
<?php } else if ($conf_proposal['convenor_pk'] == $User->pk) { ?>
			<label title="Remove yourself as a volunteer to convene this session">
				<span style="font-size:.7em;">Convenor</span>
				<input class="filter" type="submit" <?= $disabledN ?> name="NC" value="X" onClick="setSessions('<?= $conf_proposal['sessions_pk'] ?>');" />
			</label>
<?php } else if ($conf_proposal['recorder_pk'] == $User->pk) { ?>
			<label title="Remove yourself as a volunteer to record this session">
				<span style="font-size:.7em;">Recorder</span>
				<input class="filter" type="submit" <?= $disabledN ?> name="NR" value="X" onClick="setSessions('<?= $conf_proposal['sessions_pk'] ?>');" />
			</label>
<?php } else { ?>
			<label title="Volunteer to convene this session">
				<input class="filter" type="submit" <?= $disabledC ?> name="C" value="Conv" onClick="setSessions('<?= $conf_proposal['sessions_pk'] ?>');" />
			</label>
		<!---	<label title="Volunteer to record this session">
				<input class="filter" type="submit" <?= $disabledR ?> name="R" value="Rec" onClick="setSessions('<?= $conf_proposal['sessions_pk'] ?>');" />
			</label>
		-->
<?php } ?>
		</td>
		<td class="small_text">
			<label title="<?= mysql_real_escape_string($conf_proposal['abstract']) ?>">
				<?= $conf_proposal['title'] ?>
			</label>
		</td>
		<td class="small_centered">
			<?= $conf_proposal['track'] ?>
		</td>
		<td class="small_centered" nowrap='y'>
			<?= $conf_proposal['room_title'] ?>
		</td>
		<td class="grid">
			<?= $conf_proposal['length'] ?>
		</td>
		<td class="session_date" nowrap='y'>
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
<div class="definitions">
<div class="defheader">How to use the volunteer page</div>
<div style="padding:3px;">
<ul style="margin:2px 20px;">
<li>This page contains a full listing of all sessions that need to be convened or recorded. Sessions are listed by dates in the order they will occur.</li>
<li>You must be logged in to volunteer yourself, if you do not see any buttons on the page then login using the <strong>login</strong> link in the upper right.</li>
<li>Click the <strong>Conv</strong> button to the left of a session volunteer to convene it</li>
<li><strong>Convenor responsibilities</strong></li>
<ul>
<li><strong>Introductions</strong> - Introduce the presenters for each session.</li> 
<li><strong>Timekeeping</strong> - Attempt to start the session they are convening on time.  It is also the responsibility of the Session Convenor to end the session on time.  (It often works well to signal the presenter(s) when they have 5 minutes left and then assertively end the session on time.)</li> 
<li><strong>Evaluations</strong> - Distribute session evaluations to attendees at the beginning of the session and encourage attendees to put their completed evaluations in the Evaluation Collection Boxes at the door.  The convenor should pick up any completed session evaluations from the box and bring them to the registration table after the session is over.</li> 
</ul>
<!--
<li>Click the <strong>Rec</strong> button to the left of a session volunteer to record it</li>
<li><strong>Recorder responsibilities</strong></li>
<ul>
<li><strong>Recording audio</strong> - Bring their own iPods (or check out an iPod from the registration table if available) and record the entire session.</li> 
<li><strong>Posting recording</strong> - Immediately following the session, recorders will take their iPod to the registration table and Sakai staff or volunteers will download the session recording and post it to the appropriate session page in confluence.</li>
</ul>  -->
<li>Click the <strong>X</strong> button to the left of a session remove yourself as a volunteer for it</li>
</ul>
</div>
</div>
<?php include $TOOL_PATH.'include/admin_footer.php'; ?>
