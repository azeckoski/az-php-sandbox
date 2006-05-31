<?php
/*
 * file: schedule_details.php
 * Created on May 09, 8:00 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Schedule Detailed View";
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated - not required
//require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// THIS PAGE IS ACCESSIBLE BY ANYONE
// Make sure user is authorized for admin perms
$isAdmin = false; // assume user is NOT allowed unless otherwise shown
$hide_bof_rooms = false; // flag to hide the BOF rooms
if (!$User->checkPerm("admin_conference")) {
	$isAdmin = false;
	$hide_bof_rooms = true;
} else {
	$isAdmin = true;
	$hide_bof_rooms = false;
}

//opening up the bof room viewing one week before the conference
$hide_bof_rooms = false;

// get the passed message if there is one
if($_GET['msg']) {
	$Message = "<div class='message'>".$_GET['msg']."</div>";
}

// hide BOF rooms
if($_REQUEST['hbr']) {
	$hide_bof_rooms = true;
}
// show BOF rooms
if($_REQUEST['sbr']) {
	$hide_bof_rooms = false;
}

// Day  Filter
$filter_days_default = "show all days";
$filter_days = "";
if ($_REQUEST["filter_days"] && (!$_REQUEST["clearall"]) ) { $filter_days = $_REQUEST["filter_days"]; }

$special_filter = "";
$filter_days_sql = "";
switch ($filter_days){
   	case "Tuesday": $filter_days_sql = " and day ='Tuesday' "; break;
  	case "Wednesday": $filter_days_sql = " and day ='Wednesday' "; break;
  	case "Thursday": $filter_days_sql = " and day ='Thursday' "; break;
  	case "Friday": $filter_days_sql = " and day ='Friday' "; break;
  	case ""; // show all items
		$filter_days = $filter_days_default;
		$filter_days_sql = "";
		break;
}
// Track Filter
$filter_track_default = "show all tracks";
$filter_track = "";
if ($_REQUEST["filter_track"] && (!$_REQUEST["clearall"]) ) { $filter_track = $_REQUEST["filter_track"]; }

$special_filter = "";
$filter_track_sql = "";
switch ($filter_track){
   	case "Community": $filter_track_sql = " and track='Community' "; break;
  	case "Faculty": $filter_track_sql = " and track='Faculty' "; break;
 	case "Implementation": $filter_track_sql = " and track='Implementation' "; break;
 	case "Technical": $filter_track_sql = " and track='Technical' "; break;
 	case "Multiple Audiences": $filter_track_sql = " and track='Multiple Audiences' "; break;
 	case "Tool Overview": $filter_track_sql = " and track='Tool Overview' "; break;
 	case "BOF": $filter_track_sql = " and track='BOF' "; break;
 	case ""; // show all items
		$filter_track = $filter_track_default;
		$filter_track_sql = "";
		break;
}
  

?>
<?php
  
  


//get only the technical demo information for the Tech Demo filter
$sql = "select U1.firstname, U1.lastname, U1.email, U1.institution, " .
	"U1.firstname||' '||U1.lastname as fullname, CV.vote, " .
	"CP.* from conf_proposals CP left join users U1 on U1.pk = CP.users_pk " .
	"left join conf_proposals_vote CV on CV.conf_proposals_pk = CP.pk " .
	"and CV.users_pk='$User->pk' " .
	"where CP.confID = '$CONF_ID'" . $sqlsorting . $mysql_limit;

//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$items = array();

// put all of the query results into an array first
while($row=mysql_fetch_assoc($result)) { $items[$row['pk']] = $row; }

//echo "<pre>",print_r($items),"</pre>"; 


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
$sql = "select CP.pk, CP.title, CP.abstract, CP.track, CP.speaker, CP.co_speaker, CP.bio, CP.URL, CP.wiki_url, " .
		"CP.type, CP.length from conf_proposals CP " .
		"join conf_sessions CS on CS.proposals_pk = CP.pk " .
		"where CP.confID = '$CONF_ID'" . $sqlsearch . 
	$filter_type_sql .  $filter_days_sql . $filter_track_sql. $sqlsorting . $mysql_limit;

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


//echo "<pre>",print_r($timeslots),"</pre>"; 

// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
$CSS_FILE2 = "../include/proposals.css";
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


<?= $Message ?>


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
<?php 
if ($User && $isAdmin) {
	include $TOOL_PATH.'include/admin_header.php';
} else {
	echo "</head><body>";
}
?>

<?= $Message ?>


<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>"/>

<!--
<div style="text-align:center;font-style:italic;font-size:.8em;border:2px solid red;">
<strong>Tentative Draft Schedule:</strong> Times and sessions may change and new sessions may be added<br/>
Check back closer to the conference for the final schedule, contact <a href="mailto:wendemm@gmail.com">Wende Morgaine</a> with questions
</div>
-->

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
		<td nowrap="y"><b style="font-size:1.1em;">Conference schedule:</b></td>
		<td nowrap="y" colspan="5">
		<div style="float:left; padding-right: 30px;"><a href="schedule.php"><strong>Table View <img src="../include/images/arrow.gif" border=0 height=9 width=9/></a>
			</div>	<div style="float:left;">
				<strong><a href="<?= $CONF_URL ?>"><?= $CONF_NAME ?></a></strong>
<?php $confDateFormat = "g:i a, l, M j, Y"; ?>
				(<?= date($confDateFormat,strtotime($CONF_START_DATE)) ?> - <?= date($confDateFormat,strtotime($CONF_END_DATE)) ?>)
			</div>
			
		</td>
	</tr>

	</table>
</div>


<div style="background:#ECECEC;border:1px solid #ccc;padding:3px;margin-bottom:10px;">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
	<td nowrap="y">
	<strong>Filters:</strong>&nbsp;&nbsp;
	</td>
	<td nowrap="y" style="font-size:0.9em;">
	<?php 
	
	//TODO  fix the filter by day
	/*
	 * 
	 *	 		<strong>By Day:</strong>
	 *		<select name="filter_days" title="Filter the items by day">
	 *			<option value="<?= $filter_days ?>" selected><?= $filter_days ?></option>
	 *		<option value="Tuesday">Tuesday</option>
	 *		<option value="Wednesday">Wednesday</option>
	 *		<option value="Thursday">Thursday</option>
	 *		<option value="Friday">Friday</option>
	 *		<option value="show all days">show all days</option>
	 *	</select>
	 *		&nbsp;
	 *	&nbsp;
	 */
	 
		
		?>
		
		<strong>Track:</strong>
		<select name="filter_track" title="Filter the items by track">
			<option value="<?= $filter_track ?>" selected><?= $filter_track ?></option>
			<option value="Community">Community</option>
			<option value="Faculty">Faculty</option>
			<option value="Implementation">Implementation</option>
			<option value="Technical">Technical</option>
			<option value="Multiple Audiences">Multiple Audiences</option>
			<option value="Tool Overview">Tool Overview</option>			
			<option value="BOF">BOF</option>
			

			<option value="show all tracks">show all tracks</option>
		</select>
		
			&nbsp;
		
	    <input class="filter" type="submit" name="filter" value="Filter" title="Apply the current filter settings to the page">
		&nbsp;&nbsp;&nbsp;
		<?= count($conf_proposals) ?> sessions shown &nbsp;&nbsp;&nbsp;
	
<input class="filter" type="submit" name="clearall" value="Clear Filters" title="Reset all filters" />
       </td>
	</tr>
	</table>
</div>

<table border="0" cellspacing="0" style='font-size:.9em; width:100%;height:100%;'>

<?php
// create the list
$line = 0;
$last_date = 0;
$conference_day = 0;
foreach ($timeslots as $timeslot_pk=>$rooms) {
	$line++;

	$timeslot = $conf_timeslots[$timeslot_pk];

	// HANDLE HEADER
	$current_date = date('M d',strtotime($timeslot['start_time']));
	if ($line == 1 || $current_date != $last_date) {
		// next date
		$conference_day++;

		// create a blank line if after first one
		if ($line > 1) {
			echo "<tr><td>&nbsp;</td></tr>\n";
		}

		// print date header
		echo "<tr>\n";
		echo "<td class='list_date_header' nowrap='y' colspan='12'>" .
				"Conference day $conference_day - " .
				date('l, M j, Y',strtotime($timeslot['start_time'])) .
				"</td>\n";
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
		case "demo": $linestyle = "demo"; break;
		default: $linestyle = "event";
	}


	// print the list
	foreach ($rooms as $room_pk=>$room) {

		$conf_room = $conf_rooms[$room_pk];
		if ($conf_room && $conf_room['BOF'] == 'Y' && $hide_bof_rooms) { continue; }

		// TODO - try to get the sessions to fill the cells
		// session check here
		$total_length = 0;

		if (is_array($room)) {
			$counter = 0;

			foreach ($room as $session_pk=>$session) {
				$counter++;
		
				$proposal = $conf_proposals[$session['proposals_pk']];
				if ($proposal){
					$total_length += $proposal['length'];
		
					//get the start and end time for this timeslot
					$start_date = date('D, M j',strtotime($timeslot['start_time']) );
					$start_time=date('g:i A',strtotime($timeslot['start_time']) );				 
					$end_time=date('g:i A',strtotime($timeslot['start_time']) + (( $proposal['length'] ) *60));

					if ($counter >1) {	 //more than one session in this room block

						$start_time=date('g:i A',strtotime($timeslot['start_time']) + (( $proposal['length'] + 10) *60));
						//must calculate both previous session and length of this curent session plus break to get end time
						$end_time=date('g:i A',strtotime($timeslot['start_time']) + (($proposal['length'] * 2 +10) *60));
						//print the break block	

					}
					$trackclass = str_replace(" ","_",strtolower($proposal['track']));
					$typeclass = str_replace(" ","_",strtolower($proposal['type']));
?>
						
			<tr class='list'>
				<td valign=top>
					<div class='list_event_header <?= $trackclass ?>'>
						<?= $proposal['track'] ?>
					</div>
					<div style="padding:5px;">
						<?= $start_date ?>
					</div>
					<div class='list_time'>
						<?php echo $start_time ." <em>to</em> " .$end_time; ?>
					</div>
					<div class="list_room">
						<?= $conf_room['title'] ?>
					</div>
				</td>

				<td valign="top" class='list_event_speaker'>
					<div class='<?= $typeclass ?>' style="padding:3px;">
					<strong>
						<?= ucwords($proposal['type']) ?>:
<?php
				
						echo htmlspecialchars($proposal['title']);
					
?>
<?php if ($isAdmin) { /* let the admins link to the edit page */ ?>
						&nbsp;[<a href="edit_proposal.php?pk=<?=$proposal['pk']?>&amp;edit=1&amp;location=2">edit</a>]
<?php } ?>
					</strong>
					</div><br/>
				<strong>Speakers:</strong>
						<?= htmlspecialchars($proposal['speaker']); ?>
<?php
				if (trim($proposal['co_speaker'])) {
					echo " with " . htmlspecialchars(trim($proposal['co_speaker']));
				}

				if (trim($proposal['bio'])) {
					echo "<br/><br/><strong>Bio: </strong>" . htmlspecialchars(trim($proposal['bio']));
				}
?>
				</td>
				<td width="30%" class='list_event_text'>
					<div>
						<span style='color:#000;'>
							<strong>Abstract: </strong>
						</span>
<?php
				if (!$proposal['abstract']) {
					echo " not available";
				} else {
					echo nl2br(trim(htmlspecialchars($proposal['abstract'])));
				}

				if($proposal['type']=="BOF") {
					  if ($proposal['wiki_url']) { /* a project URL was provided */
					  	$url=$proposal['wiki_url'];
						echo"<div align=left><br/><strong> Wiki Page: </strong><a href=\"$url\"><img src=\"../include/images/arrow.png\" border=0 width=10px height=10px title=\"visit project site\"></a><br/><br/></div>";
					}
				}

				//echo "</div>\n";
				echo "</div></td>\n</td></tr>";
			}
		}
		echo "</td></tr>";
	}
  }
} 
?>

</table>
</form>


<?php include $TOOL_PATH.'include/admin_footer.php'; ?>
