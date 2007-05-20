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


?>
<?php
  
  


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
$sql = "select CP.pk, CP.title, CP.abstract, CP.track, CP.sub_track, CP.speaker, CP.co_speaker, CP.bio, CP.URL, CP.wiki_url, " .
		"CP.type, CP.length, CP.print from conf_proposals CP " .
		"join conf_sessions CS on CS.proposals_pk = CP.pk " .
		"where CP.confID = '$CONF_ID' and CP.track!='Unavailable'" . $sqlsearch . 
	$filter_type_sql .  $filter_days_sql . $filter_track_sql.  "order by CP.title" . $mysql_limit;

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

$CSS_FILE2 = $TOOL_URL."/include/print_scheduleDetails.css";

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
<?php 
if ($User && $isAdmin) {
	include $TOOL_PATH.'include/admin_header.php';
} else {
	echo "</head><body>";
}
?>






<?php
// create the list
$line = 0;
$last_date = 0;
$conference_day = 0;

$count=0;
$page=1;
				
				
echo "<div class=box>";
foreach ($conf_proposals as $conf_proposal){
foreach ($timeslots as $timeslot_pk=>$rooms) {
	$line++;

	$timeslot = $conf_timeslots[$timeslot_pk];

	// HANDLE HEADER
	$current_date = date('D',strtotime($timeslot['start_time']));
	if ($line == 1 || $current_date != $last_date) {
		// next date
		$conference_day++;

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
			
	
	// session check here
			if (is_array($room)) {
			$counter = 0;
			$total_length = 0;
				$start_time1="";
					$start_time2="";
					$start_time3="";
	$session_info= "";
			foreach ($room as $session_pk=>$session) {
				$counter++;
				$proposal = $conf_proposals[$session['proposals_pk']];
			if ($counter =="1") {
							$total_length += $proposal['length'];
				$start_time1=date('H:i',strtotime($timeslot['start_time']) );
				$end_time1=date('H:i',strtotime($timeslot['start_time']) + ($total_length *60));
				
			
							$session_info=  "<div class='session_time'>$current_date .". ". &nbsp;<strong> "  . $start_time1 . " - " .$end_time1."</strong>&nbsp; &nbsp;";
						$session_info.=   $conf_room['title'] ."  " ." ( " .$proposal['length'] ." min. )" ;
						
					$session_info.=  "</div>"; 
					
							
					
            	
				}
				
					
					if  ($counter=="2") {  //there is a second session so print that start time
						
						$start_time2=date('H:i',strtotime($timeslot['start_time']) + (($total_length + 5) *60));
						$end_time2=date('H:i',strtotime($start_time2) + (( $proposal['length']) *60));	
						$session_info=  "<div class='session_time'>$current_date .". ". &nbsp;<strong> "  . $start_time2 . " - " .$end_time2 ."</strong>&nbsp; &nbsp;";
							$session_info.=   $conf_room['title'] ."  " ." ( " .$proposal['length'] ." min. )" ;
						$session_info.=  "</div>"; 
						
						$total_length += $proposal['length']+ (5);
						}
						if  ($counter=="3") {  //there is a second session so print that start time
						
							$start_time3=date('H:i',strtotime($timeslot['start_time']) + (($total_length + 5) *60));
						$end_time3=date('H:i',strtotime($start_time3) + (( $proposal['length']) *60));
				
					
				$session_info= "<div class='session_time'>$current_date .". ". &nbsp;<strong> "  . $start_time3 . " - " .$end_time3 ."</strong>&nbsp;&nbsp;";
							$session_info .=   $conf_room['title'] ."  " ." ( " .$proposal['length'] ." min. )" ;
							$session_info .=  "</div>"; 
							
							
						}

if ( $conf_proposal['pk']==$proposal['pk']) {

			
					$typeclass = str_replace(" ","_",strtolower($proposal['type']));
	//do not print BOFs or proposals not intended to be printed in program
if (($proposal['type']=='BOF') || ($proposal['print']=='N')) { continue; }

		

				if ( ($count==10) || ($count==20) ){
				echo "</div>";
			}  	if ($count==20) {
				echo "</div>";
				$page++;
				$count=0;
			} 
		$trackclass = str_replace(" ","_",strtolower($proposal['track']));
		$count++;
if ($count==1)  {
	
	
echo "<div class='page'><div class='pageheader'><strong>Sakai Amsterdam Conference Session Details-</strong><span class=program_legend> ( Page $page )</span>" .
			"" ;
	if ($page==1) {
		
		
			echo "<div class='program_legend'><div class='graphic_legend'><strong>Special Interest: </strong>" .
			"<span><img src='../include/images/book06.gif' alt='' height=17 /> - Library </span>" .
			"<span><img src='../include/images/coolToolicon.gif' alt='' height=16 /> - Cool New Tool </span>" .
		
				"<span><img src='../include/images/ospiNEWicon2.jpg' alt='' height=15 /> - OSP (Open Source Portfolio) </span></div>" .
				"<div class='color_legend'><strong>Color Legend: </strong><span class='technology'>Technology</span>" .
				"<span class='other'>Multiple Audiences</span><span class='implementation'>Implementation</span><span class='research'>Research</span><span class='tool_carousel'>Tool Carousel</span>" .
				"<span class='pedagogy'>Teaching &amp; Learning</span><span class='user_experience'>User Experience</span></div></div>" ;
		} 
echo "</div>";

} 
 if (($count==1) || ($count==11)  ){
	echo "<div class='column'>";
}
echo "<div class=list>";
				
		//echo $count;
				if ($proposal['track'] =="Teaching & Learning") {
					$trackclass="pedagogy";
				}
			
					?>

	<div class='list_event_type <?=$trackclass?>' >
			<?php
			if (!$proposal['title']){
				echo "MISSING";
			}else {
				 echo htmlspecialchars($proposal['title']); 
			}?>
			
					</div>
						
						<?php
				
					if($proposal['sub_track']) { 
						$image_file="";
								switch ($proposal['sub_track']) {
							case "OSP": $image_file = "ospiNEWicon2.jpg' height=15"; break;
							case "Cool New Tool": $image_file = "coolToolicon.gif' height=17 width=17"; break;
						//	case "Cool Commercial Tool": $image_file = "coolCommercialToolicon.gif' height=17 width=17"; break;
							case "User Experience": $image_file = "people_icon.jpg' height=17 width=17"; break;
							case "Library": $image_file = "book06.gif' height=17 width=17"; break;
							
	}
						echo "<img style='padding: 2px 5px 0px 0px;' src='../include/images/" .$image_file ." align='left' alt=''  />";
						
					}
					?><div class='list_time'>
						<?php
						 echo  $session_info;
							?>
					</div>
			<div class="list_event_speaker" >
					<strong>Speaker:</strong>
						<?= htmlspecialchars($proposal['speaker']); ?>
<?php
				if (trim($proposal['co_speaker'])) {
					echo ", " . htmlspecialchars(trim($proposal['co_speaker']));
				}

				
?>				</div>
				<div class="list_event_text" >
				
<?php
				if (!$proposal['abstract']) {
					echo " not available";
				} else {
					echo nl2br(trim(htmlspecialchars($proposal['abstract'])));
				}
			
				echo "</div>";
				
			echo "</div>";
		
			
			
				
			
}
			}
			}
		
	
	
	
	}
		
	}
  }

?>
	</div>
	</div></div>
	</body>
</html>
