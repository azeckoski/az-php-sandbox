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
if (!$User->checkPerm("admin_conference") && !$User->checkPerm("proposals_Dec2006")) {
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
$CONF_ID="Jun2007";
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
$CSS_FILE2 = "../include/schedule.css";
$DATE_FORMAT = "M d, Y h:i A";

if ( ($User->checkPerm("admin_accounts")) || ($User->checkPerm("admin_conference")) || ($User->checkPerm("proposals_dec2006")) || ($User->checkPerm("registration_dec2006"))   ) {
// top header links for admins
	$EXTRA_LINKS = "<span class='extralinks'>" ;
	$EXTRA_LINKS .= "<a class='active' href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
	$EXTRA_LINKS .="</span>";
} else {
// set header links
$EXTRA_LINKS = "<span class='extralinks'>" ;
	
$EXTRA_LINKS.="<a  href='$ACCOUNTS_URL/index.php'><strong>Home</strong></a>:";
		
$EXTRA_LINKS.=	"<a href='$CONFADMIN_URL/registration/index.php'>Register</a>" .
		"<a  href='$CONFADMIN_URL/proposals/index.php'>Call for Proposals</a>" ;
		
	if ($SCHEDULE_PUBLISHED) { 
		$EXTRA_LINKS .= "<a class='active' href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
		 }  else {
		 		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/draft_schedule.php'>Schedule</a>";
			//header('Location:draft_schedule.php');
		 	
		 }
		
		
	$EXTRA_LINKS .="</span>";
	
}
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

<?php include $ACCOUNTS_PATH.'include/header.php'; // INCLUDE THE HEADER ?>


<?= $Message ?>
<?php
echo "<div class='page'><div class='pageheader'><strong>Sakai Atlanta Conference Session Details</strong><span class=program_legend> ( Page $page )</span>" .
			"" ;
	
		
			echo "<div class='program_legend'><div class='graphic_legend'><strong>Special Interest: </strong>" .
			"<span><img src='../include/images/book06.gif' alt='' height=17 /> - Library </span>" .
			"<span><img src='../include/images/coolToolicon.gif' alt='' height=16 /> - Cool New Tool </span>" .
			"<span><img src='../include/images/coolCommercialToolicon.gif' alt='' height=16 /> - Cool Commercial Tool </span>" .
			"<span><img src='../include/images/people_icon.jpg' alt='' height=17/> - User Experience </span>" .
				"<span><img src='../include/images/ospiNEWicon2.jpg' alt='' height=15 /> - OSP (Open Source Portfolio) </span></div>" .
				"<div class='color_legend'><strong>Color Legend: </strong><span class='technology'>Technology</span>" .
				"<span class='other'>Multiple Audiences</span><span class='implementation'>Implementation</span><span class='research'>Research</span><span class='tool_carousel'>Tool Carousel</span>" .
				"<span class='pedagogy'>Teaching &amp; Learning</span><span class='user_experience'>User Experience</span></div></div>" ;
	
echo "</div>";
?>
<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>"/>

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
			echo "<td class='$type' width=12%  nowrap='y'>".$conf_room['title']."</td>\n";
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
					"<div style='font-size:1em; padding: 3px;'>";
				if ($isAdmin) { echo 	"<br/>"; }
				echo "<strong>".$timeslot['title'].":</strong> <span style='font-size:1em;'>" .
					 date('l',strtotime($timeslot['start_time'])) . ", " .
					date('g:i a',strtotime($timeslot['start_time'])) . " - " .
					date('g:i a',strtotime($timeslot['start_time']) + ($timeslot['length_mins']*60)) .
					"</span></div></td>";
			    
		} else {
			echo "<td align='center' colspan='".count($conf_rooms)."'>" .
					"<div style='font-size:1em;  padding: 3px;'>";
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
					$start_time1="";
					$start_time2="";
					$start_time3="";
					
				foreach ($room as $session_pk=>$session) {
					$counter++;
				  if ($counter=="1") {	//get the starttime for this timeslot
					$start_time1=date('g:i',strtotime($timeslot['start_time']) );
					
					//clear any previous time set for second and 3rd timeslots
				 
					$proposal = $conf_proposals[$session['proposals_pk']];
					$end_time1=date('g:i',strtotime($timeslot['start_time']) + (($proposal['length']) *60));
						$total_length += $proposal['length'];
            	
				  }
				 if (!$proposal==NULL) { //do not show the empty bof spaces as sessions
                     	
					//echo "<div class='grid_event'>\n";
                 	if ($counter>1){	 //more than one session in this room block
				  
					$breaktime="5 min";
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
						//	echo "<strong> "  . $conf_room['title'] ." " .  $start_time1 ."</strong>";
							echo "&nbsp;<strong> "  . $start_time1 . " - " .$end_time1 ."</strong>&nbsp;&nbsp;( " .$proposal['length'] ." min. )";
					
							
					}
					if($proposal['track']) { 
						if ($proposal['track'] =="Teaching & Learning") {
						echo "<div class='grid_event_header pedagogy'>".$proposal['track'];
						echo "</div>\n";
						} else 	if ($proposal['track'] =="Other") {
						echo "<div class='grid_event_header other'>Multiple Audiences</div>\n";
						
						}
						 else if ($proposal['track']=="unavailable") {
							//do not print the type information
						}  else {
						$trackclass = str_replace(" ","_",strtolower($proposal['track']));
						echo "<div class='grid_event_header $trackclass'>".$proposal['track'];
						echo "</div>\n";
					}
					}
					if($proposal['sub_track']) { 
						$image_file="";
								switch ($proposal['sub_track']) {
							case "OSP": $image_file = "ospiNEWicon2.jpg' height=15"; break;
							case "Cool New Tools": $image_file = "coolToolicon.gif' height=17 width=17"; break;
							case "Cool Commercial Tool": $image_file = "coolCommercialToolicon.gif' height=17 width=17"; break;
							case "User Experience": $image_file = "people_icon.jpg' height=17 width=17"; break;
							case "Library": $image_file = "book06.gif' height=17 width=17"; break;
							
	}
						echo "<img style='padding: 2px 5px 0px 0px;' src='../include/images/" .$image_file ." align='left' alt=''  />";
						
					}

					if($proposal['type']=="BOF") { //don't list the type on the schedule
						$typeclass = "";
					} else if($proposal['type']) {
					 	$typeclass = "";
						$typeclass = str_replace(" ","_",strtolower($proposal['type']));
						if ($proposal['track']=="unavailable") {
							//do not print the type information
						}  //else echo "<div class='grid_event_type $typeclass'>- ".$proposal['type']." -</div>\n";
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
					echo "<div class='grid_event_cospeaker'>".
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


<?php include $ACCOUNTS_PATH.'include/footer.php'; ?>
