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
		"where CP.confID = '$CONF_ID' and approved='Y' and track!='unavailable'";
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
$CSS_FILE2 = $TOOL_URL."/include/print_scheduleTabloidWidecss.css";

$DATE_FORMAT = "M d, Y h:i A";


?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>

<?php 
	echo "</head><body>";

?>
 <table border='0' cellspacing='0' cellpadding="2" style='width:100%;height:100%;'>
 <tr><td colspan=5 align=left valign=top style='font-size: 1.8em; font-weight:200;'><img style='padding:0px 30px;' src='../include/images/amsterdamWebnLogo3.png' height=150 align=left  alt='' /><strong><br/>7th Sakai Conference<br/> Amsterdam, The Netherlands <br/>June 12-15, 2007</strong></td>

 <tr><td colspan=5><div style="height:250px; margin: 10px; border: 1px dotted #336699; font-size: 1.3em;"><br/><br/>&nbsp;Special notes/reminders maybe a map to the rooms:</div></td></tr>	<tr><td class='date_header page' nowrap='y' colspan='4'>Pre-Conference - Monday, Jun 11, 2007</td></tr>
	<tr><td class='time_header' nowrap='y'>Jun 12</td><td class='schedule_header' nowrap='y'>Matterhorn 1</td><td class='schedule_header' nowrap='y'>Matterhorn 2</td><td class='schedule_header' nowrap='y'>Matterhorn 3</td></tr>
	
	<tr class="event">
	<td class="time" nowrap='y'>
		09:05 - 
		12:40
	</td>
       		
 		
		     <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr><td  class='grid_event_med'> 					<div class='grid_event_header techincal'>Programmer's Cafe</div><div class='session_time'>&nbsp;<strong> 09:05 - 12:40</strong>&nbsp; &nbsp;<br/></div><div class='grid_event_text' style="text-align:left"><div>
<strong>Full Day Workshop</strong>(part 1)<br/><br/>
We will be doing a more hands-on workshop this time (by popular
demand) and will be writing a function tool (similar to Vancouver) in RSF.<br/><br/>
There will be short special sessions after lunch.
1) Developer involvement in Sakai (Peter Knoop)
2)  Licensing issues in Sakai development (TBD) (maybe)
<br/><br/>
There will also be a combined Designer/Developer session at the end of the
day.   </div></div><div class='grid_event_speakerDay1'></div></table></td>       		
		     <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr><td  class='grid_event_med'> 					<div class='grid_event_header implementation'>Introduction to Sakai</div><div class='session_time'>&nbsp;<strong>09:05 - 12:40</strong>&nbsp; &nbsp;<br/></div><div class='grid_event_text '><div><strong>title here...</strong></div></div><div class='grid_event_speakerDay1'>TBA</div></table></td>       		
		    <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr><td  class='grid_event_med'> 					<div class='grid_event_header user_experience'>U-Camp</div><div class='session_time'>&nbsp;<strong>09:05 - 12:40</strong>&nbsp; &nbsp;<br/></div><div class='grid_event_text '><div><strong>title here...</strong></div></div><div class='grid_event_speakerDay1'>TBA</div></table></td>       		
		    </tr>
		    
<tr class="coffee">
	<td class="time" nowrap='y'>
		12:30 - 
		13:40	
	</td>
<td align='center' colspan='3'><div style='padding: 3px; '><strong>LUNCH - box lunch provided</strong></div></td></tr>

	<tr class="event">
	<td class="time" nowrap='y'>
		13:40  - 
		18:40	
	</td>
       		
	    <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr><td  class='grid_event_med'> 					<div class='grid_event_header techincal'>Programmer's Cafe</div><div class='session_time'>&nbsp;<strong> 09:00 - 17:00</strong>&nbsp; &nbsp;<br/></div><div class='grid_event_text' style="text-align:left"><div><strong>Full Day Workshop</strong>(part 2)<br/><br/>
Continuation of the Programmers' Cafe with a combined Designer/Developer session at the end of the
day.  We will be bringing
together the U-Camp attendees and the Programmers Cafe attendees and talking
about Designers and Developers working together to improve the Sakai user
experience. Practical tips and examples will be presented to help both
groups work together more closely and to assist developers without the
benefit of a local UI expert. We hope this will result in questions,
discussion, and new friendships and alliances. </div></div><div class='grid_event_speakerDay1'>TBA</div></table></td>       		
		    <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr><td  class='grid_event_med'> 					<div class='grid_event_header pedagogy'>Introduction to OSP</div><div class='session_time'>&nbsp;<strong>09:05 - 12:40</strong>&nbsp; &nbsp;<br/></div><div class='grid_event_text '><div><strong>title here...</strong></div></div><div class='grid_event_speakerDay1'>TBA</div></table></td>       		
		    <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr><td  class='grid_event_med'> 					<div class='grid_event_header user_experience'>U-Camp</div><div class='session_time'>&nbsp;<strong>09:05 - 12:40</strong>&nbsp; &nbsp;<br/></div><div class='grid_event_text '><div><strong>title here...</strong></div></div><div class='grid_event_speakerDay1'>TBA</div></table></td>       		
		</tr>

</table>
<table border='0' cellspacing='0' cellpadding="2" style='width:100%;height:100%;'>
 
 <tr><td><div style="height:90px;">&nbsp;</div></td></tr>	<tr><td class='date_header page' nowrap='y' colspan='4'>Post-Conference - Friday, Jun 15, 2007</td></tr>
	<tr><td class='time_header' nowrap='y'>Jun 12</td><td class='schedule_header' nowrap='y'><strong>LOCATION: </strong> Universiteit van Amsterdam</td><td class='schedule_header' nowrap='y'><strong>LOCATION: </strong> TBA</td></tr>
	
	<tr class="event">
	<td class="time" nowrap='y'>
		09:00 - 
		15:00
	</td>
       		
 		
		    <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr><td  class='grid_event_long'> 					<div class='grid_event_header implementation'>OSP Post-Conference Workshop</div><div class='session_time'>&nbsp;<strong> 09:00 - 15:00</strong>&nbsp; &nbsp;<br/></div><div class='grid_event_text '><div style="text-align:left;"><strong>OSP post conference meeting</strong><br/><br/>
This day long meeting is being hosted by Universiteit van Amsterdam<br/>
Time: 	9am - 3pm	<br/>
Location:	Universiteit van Amsterdam, Herengracht 182, room 007	<br/>
Features:	Wireless (and probably wired also) Beamer, Whiteboard, Flipover and Lunch.
</div></div><div class='grid_event_speakerDay1'>TBA</div></table></td>       		
		   <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr><td  class='grid_event_long'> 					<div class='grid_event_header implementation'>TBA</div><div class='session_time'>&nbsp;<strong> 09:00 - 15:00</strong>&nbsp; &nbsp;<br/></div><div class='grid_event_text '><div><strong>Other post-conference meetings...
TBA
</strong></div></div><div class='grid_event_speakerDay1'>TBA</div></table></td>     </tr>
		    
<tr style='page-break-before:always;'><td colspan=8><hr /></td></tr>
</table>


<table border='0' cellspacing='0' cellpadding="2" style='width:100%;height:100%;'>
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
    
	echo "
<tr><td colspan=4 align=left valign=top style='font-size: 1.1em; font-weight:200;'>" .
		
			"<img style='padding:0px 30px;' src='../include/images/amsterdamWebnLogo3.png' height=60 align=left  alt='' />" .
			"<strong><br/>7th Sakai Conference<br/> " .
		"Amsterdam, The Netherlands <br/>June 12-15, 2007</strong></td><td colspan=4>" ;
echo "<div class='program_legend'><div class='graphic_legend'><strong>Special Interest: </strong>" .
			"<span><img src='../include/images/book06.gif' alt='' height=17 /> - Library </span>" .
			"<span><img src='../include/images/coolToolicon.gif' alt='' height=16 /> - Cool New Tool </span>" .
		
				"<span><img src='../include/images/ospiNEWicon2.jpg' alt='' height=15 /> - Open Source Portfolio </span></div>" .
				"</div>" ;
				"</div>" .
		" </td></tr>";
						
				   }
		// create a blank line if after first one
	?> 
	<?php
		if ($line > 1) {
			echo "<tr style='page-break-after:always;'><td colspan=8>&nbsp;</td></tr>";
		}
        else {
		// print date header
		echo "<tr>";
		echo "<td class='date_header page' nowrap='y' colspan='" .
				(count($conf_rooms) + 1) . "'>" .
				"Conference Day $conference_day - " .
				date('l, M j, Y',strtotime($timeslot['start_time'])) .
				"</td>";
		echo "</tr>";
        }
		// print the room header
		echo "<tr>";
		echo "<td class='time_header' nowrap='y'>$current_date</td>";
		foreach($conf_rooms as $conf_room) {
			$type = "schedule_header";
			if ($conf_room['BOF'] == 'Y') {
				if ($hide_bof_rooms) { continue; }
				$type = "bof_header";
			}
			echo "<td class='$type' nowrap='y'>".$conf_room['title']."</td>";
		}
		echo "</tr>";
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
		<?=  date('H:i',strtotime($timeslot['start_time'])) ?>
		 - 
		<?= date('H:i',strtotime($timeslot['start_time']) + ($timeslot['length_mins']*60)) ?>
<?php } else { ?>
	&nbsp;
<?php } ?>	
	</td>


<?php
	if ($timeslot['type'] != "event") {   // this block is a break, keynote, or other special event
		if (($timeslot['type']=="lunch") || ($timeslot['type']=="break") ){ 
			
			echo "<td align='center' colspan='".count($conf_rooms)."'>" .
					"<div>";
				if ($isAdmin) { echo 	"<br/>"; }
				echo "".$timeslot['title'].": <span>" .
					date('H:i',strtotime($timeslot['start_time'])) . " - " .
					date('H:i',strtotime($timeslot['start_time']) + ($timeslot['length_mins']*60)) .
					"</span></div></td>";
			    
		} else {  
			echo "<td align='center' colspan='".count($conf_rooms)."'>" .
					"<div style='padding: 3px; '>";
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
	// session check here
			$total_length = 0;
			if (is_array($room)) {
				$counter = 0;
					$start_time1="";
					$start_time2="";
					$start_time3="";
					
				foreach ($room as $session_pk=>$session) {
					$counter++;
					$proposal = $conf_proposals[$session['proposals_pk']];
						$total_length += $proposal['length'];
				  if ($counter=="1") {	//get the starttime for this timeslot
					$start_time1=date('H:i',strtotime($timeslot['start_time']) );
					
					//clear any previous time set for second and 3rd timeslots
				 
					$proposal = $conf_proposals[$session['proposals_pk']];
					$end_time1=date('H:i',strtotime($timeslot['start_time']) + (($proposal['length']) *60));
						$total_length += $proposal['length'];
            	
				  }
				 if (!$proposal==NULL){ //do not show the empty bof spaces as sessions
                     	
					//echo "<div class='grid_event'>";
                 	if ($counter>1){	 //more than one session in this room block
				  
					$breaktime="5 min";
					//print the break block	
?>
				<tr>
					<td valign='top' style="line-height:5px;">&nbsp;
					</td>
				</tr>
<?php
					}
					
				  
					if ( $proposal['length']=='90') {
					
					echo "<tr><td class='grid_event_long' >" ;
						
						
					} else  if ( $proposal['length']=='30')  {
					echo "<tr><td  class='grid_event_short'> ";
					}
					else  if ( $proposal['length']=='60')  {
					echo "<tr><td  class='grid_event_med'>";
					}
					//	echo $proposal['length'];
				
					?>
					<?php
				
					if($proposal['track']) { 
					  
					   $trackclass = str_replace(" ","_",strtolower($proposal['track']));
					   
					   if ($proposal['track']=="Other") {
					   	echo "<div class='grid_event_header $trackclass'>"."Multiple Audiences";
					
					echo "</div>";
						
					   } else {
					   	
					    		 if ($proposal['track']=="Teaching & Learning") {
					   	$trackclass="pedagogy";
					   }
					   	
						echo "<div class='grid_event_header $trackclass'>".$proposal['track'];
					echo "</div>";
					
					}
					}
					   
					

					if($proposal['type']=="BOF") { //don't list the type on the schedule
						$typeclass = "";
					}
					
						
					if  ($counter=="2") {  //there is a second session so print that start time
					$break_time="5 min. ";
						$proposal = $conf_proposals[$session['proposals_pk']];
				
						$start_time2=date('g:i',strtotime($timeslot['start_time']) + (($total_length + 5) *60));
						$end_time2=date('g:i',strtotime($start_time2) + (( $proposal['length']) *60));	
						echo "&nbsp;<strong> "  . $start_time2 . " - " .$end_time2 ."</strong>&nbsp; &nbsp;( " .$proposal['length'] ." min. )";
						$total_length += $proposal['length'] +5;
            	
					
						}
					else	if  ($counter=="3") {  //there is a second session so print that start time
							$break_time="5 min. ";
					$proposal = $conf_proposals[$session['proposals_pk']];
				
						$start_time3=date('g:i',strtotime($timeslot['start_time']) + (($total_length + 5) *60));
						$end_time3=date('g:i',strtotime($start_time3) + (( $proposal['length']) *60));
							$total_length += $proposal['length'];
            	
				echo "&nbsp;<strong> "  . $start_time3 . " - " .$end_time3 ."</strong>&nbsp;&nbsp;( " .$proposal['length'] ." min. )";
					
							
						} else { 
							echo "<div class='session_time'>&nbsp;<strong> "  . $start_time1 . " - " .$end_time1."</strong>&nbsp; &nbsp;";
							echo "<br/>(" .$conf_room['title'] .") " .$proposal['length'] ." min.";
							echo "</div>"; 
					
							
					}
					echo "<div class='grid_event_text $typeclass'>";
					
					//echo "<label title=\"".str_replace("\"","'",htmlspecialchars($proposal['abstract']))."\">";
					
					if($proposal['sub_track']) { 
						//echo "<br/> (" .$proposal['sub_track'] .")";
						$image_file="";
						switch ($proposal['sub_track']) {
								case "OSP": $image_file = "ospiNEWicon.jpg"; $width="width=12"; break;
							case "Cool New Tool": $image_file = "coolToolicon.gif"; $width="height=17 width=17"; break;
							case "Cool Commercial Tool": $image_file = "coolCommercialToolicon.gif"; $width="height=17 width=17"; break;
							case "User Experience": $image_file = "people_icon.jpg"; $width="height=17 width=17"; break;
							case "Library": $image_file = "book06.gif"; $width="height=17 width=17"; break;
						
	}
						?>
						<img style="padding: 0px 4px 0px 0px;" src="../include/images/<?=$image_file?>" <?=$width?> align="left" alt="img" />
						
			<?php		}
						echo "<div><strong>"  .htmlspecialchars($proposal['title']) . "</strong></div>";
					
					//echo "</label>";

					
					echo "</div>";
					
					
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
