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
  	case "Pedagogy": $filter_track_sql = " and track='Pedagogy' "; break;
 	case "Implementation": $filter_track_sql = " and track='Implementation' "; break;
 	case "Technology": $filter_track_sql = " and track='Technology' "; break;
 	case "Tool Carousel": $filter_track_sql = " and track='Tool Carousel' "; break;
  	case "Multiple Audiences": $filter_track_sql = " and track='Multiple Audiences' "; break;
 	case "BOF": $filter_track_sql = " and track='BOF' "; break;
 	case "Demo": $filter_track_sql = " and track='Demo' "; break;
	case "Poster": $filter_track_sql = " and track='Poster' "; break;
		case ""; // show all items
		$filter_track = $filter_track_default;
		$filter_track_sql = "";
		break;
}

// SubTrack Filter
$filter_sub_track_default = "show all subtracks";
$filter_sub_track = "";
if ($_REQUEST["filter_sub_track"] && (!$_REQUEST["clearall"]) ) { $filter_sub_track = $_REQUEST["filter_sub_track"]; }

$special_filter = "";
$filter_sub_track_sql = "";
switch ($filter_sub_track){
   	case "OSP": $filter_sub_track_sql = " and sub_track='OSP' "; break;
  	case "Cool Commercial Offerings": $filter_sub_track_sql = " and sub_track='Cool Commercial Offerings' "; break;
 	case "User Experience": $filter_sub_track_sql = " and sub_track='User Experience' "; break;
 	case "Library": $filter_sub_track_sql = " and sub_track='Library' "; break;
 	case "Cool New Tools": $filter_sub_track_sql = " and sub_track='Cool New Tools' "; break;
 	
		case ""; // show all items
		$filter_sub_track = $filter_sub_track_default;
		$filter_sub_track_sql = "";
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
		"CP.type, CP.length from conf_proposals CP " .
		"join conf_sessions CS on CS.proposals_pk = CP.pk " .
		"where CP.confID = '$CONF_ID'" . $sqlsearch . 
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
$CSS_FILE2 = $TOOL_URL."/include/schedule.css";

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

		// create a blank line if after first one
		if ($line > 1) {
	//		echo "<tr><td>&nbsp;</td></tr>\n";
		}

		// print date header
	//	echo "<tr>\n";
	//	echo "<td class='list_date_header' nowrap='y' colspan='12'>" .
	//			"Conference day $conference_day - " .
	//			date('l, M j, Y',strtotime($timeslot['start_time'])) .
	//			"</td>\n";
	//	echo "</tr>\n\n";
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

if ( $conf_proposal['pk']==$proposal['pk']) {
	
	

		

				if ( ($count==5) || ($count==10) || ($count==15) ){
				echo "</div>";
			}  	if ($count==15) {
				echo "</div>";
				$page++;
				$count=0;
			} 
		$trackclass = str_replace(" ","_",strtolower($proposal['track']));
		$count++;
if ($count==1)  {
echo "<div class='page'><div class='pageheader'><strong>Sakai Atlanta Conference Session Details</strong><span class=list_legend> ( Page $page )</span><br/>" .
			"<span class='list_legend'><strong>Special Interest: </strong>" .
			"<span><img src='../include/images/book06.gif' alt='' height=17 /> - Library </span>" .
			"<span><img src='../include/images/coolToolicon.gif' alt='' height=16 /> - Cool New Tool </span>" .
			"<span><img src='../include/images/coolCommercialToolicon.gif' alt='' height=16 /> - Cool Commercial Tool </span>" .
			"<span><img src='../include/images/people_icon.jpg' alt='' height=17/> - User Experience </span>" .
				"<span><img src='../include/images/ospiNEWicon2.jpg' alt='' height=15 /> - OSP (Open Source Portfolio) </span></span></div>" ;

} 
 if (($count==1) || ($count==6)|| ($count==11)   ){
	echo "<div class='column'>";
}
	
echo "<div class=list>";
				
		//echo $count;
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
							case "Cool New Tools": $image_file = "coolToolicon.gif' height=17 width=17"; break;
							case "Cool Commercial Offerings": $image_file = "coolCommercialToolicon.gif' height=17 width=17"; break;
							case "User Experience": $image_file = "people_icon.jpg' height=17 width=17"; break;
							case "Library": $image_file = "book06.gif' height=17 width=17"; break;
							
	}
						echo "<img style='padding: 2px 5px 0px 0px;' src='../include/images/" .$image_file ." align='left' alt=''  />";
						
					}
					?><div class='list_time'>
						<?php echo $current_date .". ". $start_time ." <em>to</em> " . $end_time; ?>
					  -- <?= $conf_room['title'] ?>
					</div>
			<div class="list_event_speaker" >
					<strong>Speaker:</strong>
						<?= htmlspecialchars($proposal['speaker']); ?>
<?php
				if (trim($proposal['co_speaker'])) {
					echo " with " . htmlspecialchars(trim($proposal['co_speaker']));
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
}
?>
	</div>
	</div></div><div><strong>LEGEND</strong></div>
	</body>
</html>
