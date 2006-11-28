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
$hide_bof_rooms = true;

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
$sql = "select CP.pk, CP.title, CP.abstract, CP.track, CP.sub_track, CP.speaker, CP.co_speaker, CP.URL, CP.wiki_url," .
		"CP.type, CP.length from conf_proposals CP " .
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
$CSS_FILE2 = $TOOL_URL."/include/print_schedule.css";
$DATE_FORMAT = "M d, Y h:i A";


?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>

<?php 
	echo "</head><body>";

?>


<table border="0" cellspacing="0" cellpadding="2" style='width:100%;height:100%;'>

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
 if ($conference_day ==1) {
				   		
	echo "<tr><td colspan=10 align=center valign=top>" .
			"<div style='border: 1px solid #ccc; padding: 10px 0px;'> " .
			"<div class='page'>" .
			"<div class='pageheader'>" .
			"<img style='padding:0px 30px;' src='../../../accounts/include/images/atlantaBadgeLogo.png' height=70 align=left  alt='' /> <strong>6th Sakai Conference with OSPI " .
		"Atlanta, Georgia, December 5-8, 2006</strong><br/><br/></div>" .
		"<div class='program_legend'><div class='graphic_legend'><strong>Special Interest: </strong>" .
			"<span><img src='../include/images/book06.gif' alt='' height=17 /> - Library </span>" .
			"<span><img src='../include/images/coolToolicon.gif' alt='' height=16 /> - Cool New Tool </span>" .
			"<span><img src='../include/images/coolCommercialToolicon.gif' alt='' height=16 /> - Cool Commercial Tool </span>" .
			"<span><img src='../include/images/people_icon.jpg' alt='' height=17/> - User Experience </span>" .
				"<span><img src='../include/images/ospiNEWicon2.jpg' alt='' height=15 /> - OSP (Open Source Portfolio) </span></div>" .
				"<div class='color_legend'><strong>Color Legend: </strong><span class='technology'>Technology</span>" .
				"<span class='community'>Community</span><span class='multiple_audiences'>Multiple Audiences</span>" .
				"<span class='implementation'>Implementation</span><span class='tool_carousel'>Tool Carousel</span>" .
				"<span class='pedagogy'>Pedagogy</span></div>" .
				"</div>" .
				"</div></div>" .
		" </td></tr>";
						
				   }
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
	
	
// this is the beginning of the timeblocks
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
	if ($timeslot['type'] != "event") {   // this block is a break, keynote, or other special event
		if (($timeslot['type']=="lunch") || ($timeslot['type']=="break") ){ 
			
			echo "<td align='center' colspan='".count($conf_rooms)."'>" .
					"<div style='font-size:.9em; padding: 3px;'>";
				if ($isAdmin) { echo 	"<br/>"; }
				echo "<strong>".$timeslot['title'].":</strong> <span style='font-size:.9em;'>" .
					date('g:i a',strtotime($timeslot['start_time'])) . " - " .
					date('g:i a',strtotime($timeslot['start_time']) + ($timeslot['length_mins']*60)) .
					"</span></div></td>";
			    
		} else {  
			echo "<td align='center' colspan='".count($conf_rooms)."'>" .
					"<div style='font-size:.9em;  padding: 3px; '>";
			if ($isAdmin) {	echo 	"<br/>"; }
			echo "<strong>".$timeslot['title']."</strong>" .
					"</div></td>";
		}
	} else {  //this grid is for speaker sessions 
		// print the grid selector
		foreach ($rooms as $room_pk=>$room) {

			$conf_room = $conf_rooms[$room_pk];
			if ($conf_room && $conf_room['BOF'] == 'Y' && $hide_bof_rooms) { continue; }
            ?>
       		
		    <?php
		    //this is a rooms timeslot'
			// TODO - try to get the sessions to fill the cells
			echo "<td  class='grid'>";	
			
					
		   // try tables instead of divs
			echo "<table border=0 cellpadding='0' cellspacing='0'>";
				
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
                     
if ($proposal['type']=='BOF') { continue; }	
					//echo "<div class='grid_event'>";
					
					if ($counter >1){	 //more than one session in this room block
						$break_time="10 min. ";
						$start_time2=date('g:i',strtotime($timeslot['start_time']) + (( $proposal['length'] + 10) *60));
						$end_time2=date('g:i',strtotime($start_time2) + (( $proposal['length']) *60));

					//print the break block	
?>
				
<?php
					}
					
				  
					if ($total_length=='90') {
						if ($conference_day==1){
						echo "<tr><td  class='grid_event_longDay1'>'";
					
					} else {
						
					echo "<tr><td  class='grid_event_long'>'";
						}
						
					} else {
					echo "<tr><td  class='grid_event_short'>";
					}
					?>
					<?php
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

					if($proposal['type']=="BOF") { //don't list the type on the schedule
						$typeclass = "";
					} else if($proposal['type']) {
					 	$typeclass = "";
						$typeclass = str_replace(" ","_",strtolower($proposal['type']));
							echo "<div class='grid_event_type $typeclass'>- ".$proposal['type']." -</div>\n";
						}
					else {
							echo "<div class='grid_event_type $typeclass'>- ".$proposal['type']." -</div>\n";
						
					}
					if ($conference_day ==1) {
						echo "<div class='grid_event_textDay1 $typeclass'>";
					
					} else {
						
					
					echo "<div class='grid_event_text $typeclass'>";
					}
					echo "<label title=\"".str_replace("\"","'",htmlspecialchars($proposal['abstract']))."\">";
					
					if($proposal['sub_track']) { 
						//echo "<br/> (" .$proposal['sub_track'] .")";
						$image_file="";
						switch ($proposal['sub_track']) {
							case "OSP": $image_file = "ospiNEWicon.jpg' width=14"; break;
							case "Cool New Tools": $image_file = "coolToolicon.gif' height=14 width=14"; break;
							case "Cool Commercial Tool": $image_file = "coolCommercialToolicon.gif' height=14 width=14"; break;
							case "User Experience": $image_file = "people_Icon.jpg' height=14 width=14 "; break;
							case "Library": $image_file = "book06.gif' height=14 width=14"; break;
							
	}
						echo "<img style='padding: 0px 0px 10px 0px;' src='../include/images/" .$image_file ." align='left' alt=''/>";
						
					}
						echo "<strong>"  .htmlspecialchars($proposal['title']) . "</strong>";
					
					echo "</label>";

					
					echo "</div>\n";
					
					
					 if ($conference_day ==1) {
					 	if($proposal['speaker']) {
						echo "<div class='grid_event_speakerDay1'>".
							htmlspecialchars($proposal['speaker']);
					
					if ($proposal['co_speaker']) {
						echo ", ". htmlspecialchars($proposal['co_speaker']);
						
					} 
					echo "</div>";
					
				}
					 }
					 else {

					if($proposal['speaker']) {
						echo "<div class='grid_event_speaker'>".
							htmlspecialchars($proposal['speaker']);
					
					if ($proposal['co_speaker']) {
						echo ", ". htmlspecialchars($proposal['co_speaker']);
						
					} 
					echo "</div>";
					
				}
					 }
				 
                     }
					
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
</body></html>
