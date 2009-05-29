<?php
/* add_session.php
 * Created on May 20, 2006 by @author az - Aaron Zeckoski
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech 
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Volunteers Tracking";
$ACTIVE_MENU="SCHEDULE";  //for managing active links on multiple menus

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


// fetch the proposals
$sql = "select CP.*, CS.pk as sessions_pk, CS.convenor_pk, CS.recorder_pk, CT.start_time, CR.title as room_title, " .
	"CONCAT(U1.firstname,' ',U1.lastname) as convenor, U1.email as convenor_email, " .
	"CONCAT(U2.firstname,' ',U2.lastname) as recorder, U2.email as recorder_email " .
	"from conf_proposals CP " .
	"join conf_sessions CS on CS.proposals_pk = CP.pk " .
	"left join users U1 on U1.pk = CS.convenor_pk " .
	"left join users U2 on U2.pk = CS.recorder_pk " .
	"join conf_timeslots CT on CT.pk = CS.timeslots_pk and CT.start_time is not null " .
	"left join conf_rooms CR on CR.pk = CS.rooms_pk " .
	"where CP.confID = '$CONF_ID' and CP.approved='Y' and CP.type != 'demo' " .
	"and CP.type != 'bof' order by start_time, track";
//echo "$sql<br/>";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_proposals = array();
while($row=mysql_fetch_assoc($result)) { $conf_proposals[$row['pk']] = $row; }

//echo "<pre>",print_r($conf_proposals),"</pre>";


// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
$CSS_FILE2 = $TOOL_URL."/include/schedule.css";
$DATE_FORMAT = "M d, Y h:i A";
// set header links

// set header links
$EXTRA_LINKS = "<span class='extralinks'>" ;
	if ($SCHEDULE) { 
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view )</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>"; }
if ($VOLUNTEER) { 
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/volunteer.php'>Volunteer</a>"; 
			$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/volunteers.php'>Convener List</a>"; 
	
	
		}
	$EXTRA_LINKS .="</span>";

?>

<?php // INCLUDE THE HEADER 
include $ACCOUNTS_PATH.'include/top_header.php'; ?>
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
<?php  // INCLUDE THE HEADER
include $ACCOUNTS_PATH.'include/header.php';  ?>

<div id="maindata">
<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $ACCOUNTS_PATH.'include/footer.php';
		exit;
	}
?>


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
				<strong style="color:red; font-size: .9em;">TOOL UNDER CONSTRUCTION</strong>
				<em>Scroll down for instructions</em>&nbsp;
			</div>
		</td>
	</tr>

	</table>
</div>


<div class="colorkey">
	<div class="colorkeyheader">Color Key</div>
	<div style="padding:3px;">
		<b style="font-size:1.1em;">Key:</b>

		<div class="convenor_exists" style='display:inline;'>&nbsp;Covenor set&nbsp;</div>
		&nbsp;
		<div class="oddrow" style='display:inline;'>&nbsp;No Convenor&nbsp;</div>
		
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

	if (!$conf_proposal['convenor_pk']) {
		//$linestyle = "no_convenor";
	} else {
		$linestyle = "convenor_exists";
	}

	// make it easy for someone to tell they are a convenor or recorder
	/*if ($User->pk) {
	*	if ($conf_proposal['convenor_pk'] == $User->pk) {
	*		$linestyle = "convenor_user";
	*	} else if ($conf_proposal['recorder_pk'] == $User->pk) {
	*		$linestyle = "recorder_user";
	*	}
	*}
	*/
	

	//$current = $conf_proposal['type'];
	$current = date('D, M d',strtotime($conf_proposal['start_time']));
	if ($line == 1 || $current != $last) {
		// next item, print the header again
?>
		<tr>
			<td class='time_header'><?= $current ?></td>
			<td class='schedule_header'>Convenor</td>
			<!-- <td class='schedule_header'>Recorder</td> --> 
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
		<td valign="middle" class="small_centered">
<?php
	if ($conf_proposal['convenor_pk']) { echo "<strong>Conv</strong>"; } else { echo "NC"; }
	//echo ", ";
	//if ($conf_proposal['recorder_pk']) { echo "<strong>Rec</strong>"; } else { echo "NR"; }
?>
		</td>
		<td class="small_centered">
<?php
	if($conf_proposal['convenor_pk'])
		echo "<label title='".$conf_proposal['convenor']." - ".$conf_proposal['convenor_email']."'>".$conf_proposal['convenor']."</label>";
	else
		echo "<em>None</em>";
?>
		</td>
	
		<td class="small_text">
			<label title="<?= stripslashes($conf_proposal['abstract']) ?>">
				<?= $conf_proposal['title'] ?>
			</label>
		</td>
		<td >
			<?= $conf_proposal['track'] ?>
		</td>
		<td nowrap='y'>
			<?= $conf_proposal['room_title'] ?>
		</td>
		<td class="small_centered" valign="middle">
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
<li><strong>Convenor responsibilities</strong></li>
<ul>
<li><strong>Introductions</strong> - Introduce the presenters for each session.</li> 
<li><strong>Timekeeping</strong> - Attempt to start the session they are convening on time.  It is also the responsibility of the Session Convenor to end the session on time.  (It often works well to signal the presenter(s) when they have 5 minutes left and then assertively end the session on time.)</li> 
<li><strong>Evaluations</strong> - Distribute session evaluations to attendees at the beginning of the session and encourage attendees to put their completed evaluations in the Evaluation Collection Boxes at the door.  The convenor should pick up any completed session evaluations from the box and bring them to the registration table after the session is over.</li> 
</ul>
<li><strong>Recorder responsibilities</strong></li>
<ul>
<li><strong>Recording audio</strong> - Bring their own iPods (or check out an iPod from the registration table if available) and record the entire session.</li> 
<li><strong>Posting recording</strong> - Immediately following the session, recorders will take their iPod to the registration table and Sakai staff or volunteers will download the session recording and post it to the appropriate session page in confluence.</li>
</ul>
</ul>
</div>
</div>
</div>
<?php include $ACCOUNTS_PATH.'include/footer.php'; ?>
