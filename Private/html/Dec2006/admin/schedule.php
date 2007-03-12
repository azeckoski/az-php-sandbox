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
//opening up the bof viewing to all a week before the conference
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

// fetch the conference rooms
$sql = "select * from conf_rooms where confID = '$CONF_ID'";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_rooms = array();
while($row=mysql_fetch_assoc($result)) { $conf_rooms[$row['pk']] = $row; }

// fetch the conference timeslots
$sql = "select * from conf_timeslots where confID = '$CONF_ID' order by ordering";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_timeslots = array();
while($row=mysql_fetch_assoc($result)) { $conf_timeslots[$row['pk']] = $row; }

// fetch the conf sessions
$sql = "select * from conf_sessions where confID = '$CONF_ID' order by ordering";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_sessions = array();
while($row=mysql_fetch_assoc($result)) { $conf_sessions[$row['pk']] = $row; }

// fetch the proposals that have sessions assigned
$sql = "select CP.pk, CP.title, CP.abstract, CP.track, CP.sub_track, CP.speaker, CP.co_speaker, CP.URL, CP.wiki_url, CP.podcast_url, CP.slides_url," .
		"CP.type, CP.length from conf_proposals CP " .
		"join conf_sessions CS on CS.proposals_pk = CP.pk " .
		"where CP.confID = '$CONF_ID' and CP.approved='Y'";
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
		"(<em>" .
		"<a href='schedule.php'>Table</a>, " .
		"<a href='schedule_details.php'>List</a>" .
		"</em>) - " .
	"<a href='volunteers.php'>Volunteers</a> " .
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
<?php 
if ($User && $isAdmin) {
	include $TOOL_PATH.'include/admin_header.php';
} else {
	echo "</head><body>";
}
?>

<?= $Message ?>

<div style="padding: 10px;">
<div style="text-align: left; padding: 5px 50px; font-style:normal; font-size:.9em; border:2px solid red;">
<img src='../include/template/images/officialAtlantaSakaiLogo_sm.png' height=52 width=60 border=0 align=left alt="atlanta logo"  /><strong>Sakai Atlanta Conference podcasts and presentation materials: </strong><br/>  Click on the speaker icons <img src='../include/images/soundIcon-1.jpg' border=0 height=15 width=17  alt="speaker icon" /> &nbsp; or the presentation icons <img src='../include/images/pptIcon.jpg' border=0 height=13 width=15  alt="presentation icon" />&nbsp;  below to quickly access a session's presentation media. <br/><br/>Click on the session title to view sessions notes or comments (if provided by session presenters).  
</div></div>


<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>"/>

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
		<td nowrap="y"><b style="font-size:1.1em;">Conference schedule:</b></td>
		<td nowrap="y" colspan="5">
			<div style="float:left; padding-right: 30px;"><a href="schedule_details.php"><strong>List View  <img src="../include/images/arrow.gif" border=0 height=9 width=9 alt="link image"/></strong></a>
			</div><div style="float:left;">
				<strong><a href="<?= $CONF_URL ?>"><?= $CONF_NAME ?></a></strong>
<?php $confDateFormat = "g:i a, l, M j, Y"; ?>
				(<?= date($confDateFormat,strtotime($CONF_START_DATE)) ?> - <?= date($confDateFormat,strtotime($CONF_END_DATE)) ?>)
			</div>
			
		</td>
	</tr>

	</table>
</div>

<table border="0" cellspacing="0" style='width:100%;height:100%;'>

<?php
// create the grid
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
			echo "<tr><td style='page-break-before: always;'>&nbsp;</td></tr>\n";
		}

		// print date header
		echo "<tr>\n";
		echo "<td class='date_header' nowrap='y' colspan='" .
				(count($conf_rooms) + 1) . "'>" .
				"Conference day $conference_day - " .
				date('l, M j, Y',strtotime($timeslot['start_time'])) .
				"</td>\n";
		echo "</tr>\n\n";
		
		// print the room header
		echo "<tr>";
		echo "<td class='time_header' nowrap='y'>$current_date</td>\n";
		foreach($conf_rooms as $conf_room) {
			$type = "schedule_header";
			if ($conf_room['BOF'] == 'Y') {
				if ($hide_bof_rooms) { continue; }
				$type = "bof_header";
			}
			echo "<td class='$type' nowrap='y'>".$conf_room['title']."</td>\n";
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
	<td class="time" nowrap='y'>
<?php 
	if (($timeslot['type']!="lunch") && ($timeslot['type']!="break") ){ 
?>
		
		 <?=  date('g:i a',strtotime($timeslot['start_time'])) ?>
		 -<br/>
		<?= date('g:i a',strtotime($timeslot['start_time']) + ($timeslot['length_mins']*60)) ?>
<?php } else { ?>
	&nbsp;
<?php } ?>	
	</td>


<?php
	if ($timeslot['type'] != "event") {
		if (($timeslot['type']=="lunch") || ($timeslot['type']=="break") ){ 
			
			echo "<td align='center' colspan='".count($conf_rooms)."'>" .
					"<div style='font-size:.9em; padding: 3px;'>";
				if ($isAdmin) { echo 	"<br/>"; }
				echo "<strong>".$timeslot['title'].":</strong> <span style='font-size:.9em;'>" .
					 date('l',strtotime($timeslot['start_time'])) . ", " .
					date('g:i a',strtotime($timeslot['start_time'])) . " - " .
					date('g:i a',strtotime($timeslot['start_time']) + ($timeslot['length_mins']*60)) .
					"</span></div></td>";
			    
		} else {
			echo "<td align='center' colspan='".count($conf_rooms)."'>" .
					"<div style='font-size:.9em;  padding: 3px;'>";
			if ($isAdmin) {	echo 	"<br/>"; }
			echo "<strong>".$timeslot['title']."</strong>" .
					"</div></td>";
		}
	} else {
		// print the grid selector
		foreach ($rooms as $room_pk=>$room) {

			$conf_room = $conf_rooms[$room_pk];
			if ($conf_room && $conf_room['BOF'] == 'Y' && $hide_bof_rooms) { continue; }

			// TODO - try to get the sessions to fill the cells
			echo "<td valign='top' class='grid' style='height:10%;'>";
			// try tables instead of divs
			echo "<table style='width:100%;height:100%;' cellpadding='0' cellspacing='0'>";
				
			// session check here
			$total_length = 0;
			if (is_array($room)) {
				$counter = 0;

				foreach ($room as $session_pk=>$session) {
					$counter++;
					//get the starttime for this timeslot
					$start_time1=date('g:i',strtotime($timeslot['start_time']) );
					
					//clear any previous time set for second timeslot 
					$start_time2="";
					  
					$proposal = $conf_proposals[$session['proposals_pk']];
					$end_time1=date('g:i',strtotime($timeslot['start_time']) + (($proposal['length']) *60));
				
					$total_length += $proposal['length'];
                     if (!$proposal==NULL) { //do not show the empty bof spaces as sessions
                     	
					//echo "<div class='grid_event'>\n";
					
					if ($counter >1){	 //more than one session in this room block
						$break_time="10 min. ";
						$start_time2=date('g:i',strtotime($timeslot['start_time']) + (( $proposal['length'] + 10) *60));
						$end_time2=date('g:i',strtotime($start_time2) + (( $proposal['length']) *60));

					//print the break block	
?>
				<tr>
					<td valign='top'>
						<div class='grid_event break'><?php echo $break_time;?> break</div>
					</td>
				</tr>
<?php
					}
					
					echo "<tr><td valign='top' class='grid_event'>";
					if  ($start_time2) {  //there is a second session so print that start time
						echo "&nbsp;<strong> "  . $start_time2 . " - " .$end_time2 ."</strong>&nbsp;";
					
						} else { 
						//	echo "<strong> "  . $conf_room['title'] ." " .  $start_time1 ."</strong>";
							echo "&nbsp;<strong> "  . $start_time1 . " - " .$end_time1 ."</strong>&nbsp;";
					
							
					}
					if($proposal['track']) { 
						$trackclass = str_replace(" ","_",strtolower($proposal['track']));
						echo "<div class='grid_event_header $trackclass'>".$proposal['track'];
						echo "</div>\n";
					}
					if($proposal['sub_track']) { 
						echo "<div class='grid_event_header $trackclass'>" ."(" .$proposal['sub_track'] .")";
						echo "</div>\n";
					}

					if($proposal['type']=="BOF") { //don't list the type on the schedule
						$typeclass = "";
					} else if($proposal['type']) {
					 	$typeclass = "";
						$typeclass = str_replace(" ","_",strtolower($proposal['type']));
						echo "<div class='grid_event_type $typeclass'>- ".$proposal['type']." -</div>\n";
					}
					
					if ($isAdmin) { //let the admins link to the edit page
?>
						<div> ( <a href="edit_proposal.php?pk=<?=$proposal['pk']?>&amp;edit=1&amp;location=1">edit </a>) </div>
<?php 
						
					}

					echo "<div class='grid_event_text $typeclass'>";
					echo "<label title=\"".str_replace("\"","'",htmlspecialchars($proposal['abstract']))."\">";
					if ($proposal['wiki_url']) { /* a wiki URL was provided */
						echo "<a href='".$proposal['wiki_url']."'>" .
							htmlspecialchars($proposal['title']) . "</a>";
					} else {
						echo "<strong>"  .htmlspecialchars($proposal['title']) . "</strong>";
					}
					echo "</label>";

					if ($isAdmin) {
						echo "&nbsp;<a href='delete_session.php?pk=".$session_pk ."&amp;type=" .$proposal['type'] ." '>x</a>";
					}
					echo "</div>\n";

					if($proposal['speaker']) {
						echo "<div class='grid_event_speaker'>".
							htmlspecialchars($proposal['speaker'])."</div>\n";
					echo "<div class='grid_event_speaker'>".
							htmlspecialchars($proposal['co_speaker'])."</div>\n";
				}
				echo "<div style='text-align:left;'>";
				
				if ($proposal['slides_url']) { /* a wiki URL was provided */
						echo "<a href='".$proposal['slides_url']."' title='download presentation materials'>" .
							"<img src='../include/images/pptIcon.jpg' border=0 height=13 width=15 style='padding: 7px 10px;' alt='link to presentation' /></a>";
					}
				if ($proposal['podcast_url']) { /* a wiki URL was provided */
						echo "<a href='".$proposal['podcast_url'] ."' title='listen to the podcast'>" .
							"<img src='../include/images/soundIcon-1.jpg' alt='link to podcast' border=0 height=15 width=17 style='padding: 5px 10px;'  /></a>";
					}
					echo "</div>";
				 
                     }
					//echo "</div>\n";
				}
				
			}
			echo "</table>";
			
			// time check here
			$remaining_time = $timeslot['length_mins'] - $total_length;
			if ($remaining_time > 0 && $isAdmin) {
				echo "<span  class='remaining'>$remaining_time</span>";
				echo "&nbsp;<a href='add_session.php?room=$room_pk&amp;time=$timeslot_pk'>+</a><br/>";
			}
			
			echo "</td>";
			
		}
		
		echo "</tr>";
	}
	
} 
?>

</table>
</form>

<?php if($isAdmin) { ?>
<br/>
<div class="right">
<div class="rightheader">How to use the scheduling grid</div>
<div style="padding:3px;">
<div style="padding:3px 0px;"><span class="schedule_header">Rooms</span> are shown across the top of the grid, 
<span class="bof_header">BOF rooms</span> are indicated.</div>
<div>The numbers in each <span class="event">event cell</span> indicate
the unused time available in that cell.</div>
<div>When no more time remains in an event timeslot, the number and + will not be shown.</div>
<div>
<ul>
<li><strong>Adding sessions to the schedule:</strong> Clicking on the 
<strong><a href="" class="grid" style="font-size:1.1em;">+</a></strong> will take you to 
a screen with a list of the currently approved proposals.</li>
<li><strong>Removing sessions form the schedule:</strong> 
Clicking on the <strong><a href="" class="grid" style="font-size:1.1em;">x</a></strong>
to the right of a session title will take you to a delete confirmation screen.
</li>
</ul>
</div>
</div>
</div>
<?php } ?>


<?php include $TOOL_PATH.'include/admin_footer.php'; ?>