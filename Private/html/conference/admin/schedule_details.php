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
if ((!$User->checkPerm("admin_conference")) && (!$User->checkPerm("registration_dec2006"))  && (!$User->checkPerm("proposals_dec006"))  ){
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
$filter_track_sql = "";
if ($filter_track && ($filter_track != $filter_track_default)) {
	$filter_track_sql = " and track='$filter_track' ";
} else {
	$filter_track = $filter_track_default;
}

// SubTrack Filter
$filter_sub_track_default = "show all subtracks";
$filter_sub_track = "";
if ($_REQUEST["filter_sub_track"] && (!$_REQUEST["clearall"]) ) { $filter_sub_track = $_REQUEST["filter_sub_track"]; }

$special_filter = "";
$filter_sub_track_sql = "";
switch ($filter_sub_track){
   	case "OSP": $filter_sub_track_sql = " and sub_track='OSP' "; break;
  	case "Cool Commercial Tool": $filter_sub_track_sql = " and sub_track='Cool Commercial Tool' "; break;
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
		"where CP.confID = '$CONF_ID' and CP.track!='unavailable'" . $sqlsearch . 
	$filter_type_sql .  $filter_days_sql . $filter_track_sql.  $filter_sub_track_sql . $sqlsorting . $mysql_limit;

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



if ( ($User->checkPerm("admin_accounts")) || ($User->checkPerm("admin_conference")) ) {
// top header links for admins
	$EXTRA_LINKS = "<span class='extralinks'>" ;
	$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a class='active'  href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
	$EXTRA_LINKS .="</span>";
} else {
// set header links
$EXTRA_LINKS = "<span class='extralinks'>" ;
	
$EXTRA_LINKS.="<a  href='$ACCOUNTS_URL/index.php'><strong>Home</strong></a>:";
		
$EXTRA_LINKS.=	"<a href='$CONFADMIN_URL/registration/index.php'>Register</a>" .
		"<a  href='$CONFADMIN_URL/proposals/index.php'>Call for Proposals</a>" ;
		
	if ($SCHEDULE_PUBLISHED) { 
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a class='active' href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
		 }  else {
		 		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/draft_schedule.php'>Schedule</a>";	
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

<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>"/>


<div style="background:#fff;border:0px solid #ccc;padding:3px;margin-bottom:10px;">
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
			    <?php foreach ($track_list as $key => $value ) { ?>
	        	<option value="<?=$value?>"><?=$value?></option>
	        	<?php } ?>	
	       	<option value="show all tracks">show all tracks</option>
		</select>
		
			&nbsp;
		&nbsp;
		<strong>SubTrack:</strong>
		<select name="filter_sub_track" title="Filter the items by subtrack">
			<option value="<?= $filter_sub_track ?>" selected><?= $filter_sub_track ?></option>
		<option value="OSP">OSP</option>
			<option value="Cool Commercial Tool">Cool Commercial Tool</option>
			<option value="User Experience">User Experience</option>
			<option value="Library">Library</option>
			<option value="Cool New Tools">Cool New Tools</option>
			<option value="show all subtracks">show all subtracks</option>
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

<table border="0" cellspacing="0" style='font-size:1em; width:100%;height:100%;'>

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
				<td valign=top width="100">
					<div class='list_event_header <?= $trackclass ?>'>
						<?= $proposal['track'] ?>
					<?php		if($proposal['sub_track']) { 
						echo "<div class='grid_event_header $trackclass'>" ."(" .$proposal['sub_track'] .")";
						echo "</div>\n";
					
				}?>
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
				
					if ($proposal['wiki_url']) { /* a project URL was provided */
						echo "<br/><br/><a href='".$proposal['wiki_url']."'>" .
							"<strong>related wiki page: </strong>"  .
							"<img src='../include/images/arrow.png' border=0 /></a><br/><br/>";
					} 



				//echo "</div>\n";
				echo "</div></td></tr>";
			}
		}
		
	}
  }
} 
?>

</table>
</form>

<div class="padding50"></div>

<?php include $ACCOUNTS_PATH.'include/footer.php'; // INCLUDE THE footer ?>
