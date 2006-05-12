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

// First get the list of proposals and related users for the current conf 
// (maybe limit this using a search later on)
$sql = "select U1.firstname, U1.lastname, U1.email, U1.institution, " .
	"U1.firstname||' '||U1.lastname as fullname,  " .
	"CP.* from conf_proposals CP left join users U1 on U1.pk = CP.users_pk " .
	"join conf_sessions CS on CS.proposals_pk = CP.pk " .
		"join users U2 on U2.pk = CP.users_pk " .
	"where CP.confID =  '$CONF_ID' ";
	$filter_type_sql . $filter_items_sql . $sqlsorting . $mysql_limit;

//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
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
			// TODO - insert the session PKs array in the table here
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



?>

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
<?php include $TOOL_PATH.'include/admin_header.php'; ?>

<?= $Message ?>



<?php
// create the grid
$line = 0;
$last_date = 0;
foreach ($timeslots as $timeslot_pk=>$rooms) {
	$line++;

	$timeslot = $conf_timeslots[$timeslot_pk];
	
	$current_date = date('D, F d',strtotime($timeslot['start_time']));
	if ($line == 1 || $current_date != $last_date) {
	// next date, print the header again
	
		foreach($conf_rooms as $conf_room) {
			$type = "schedule_header";
			if ($conf_room['BOF'] == 'Y') { $type = "bof_header"; }
			
		}
		
	}
	$last_date = $current_date;

?>


<?php	
	if ($timeslot['type'] != "event") {
		} else {
		// print the grid selector
		foreach ($rooms as $room_pk=>$room) { ?>
	
<?php
		// session check here
		$total_length = 0;
		if (is_array($room)) {
			$counter = 0;
			foreach ($room as $session_pk=>$session) {
				$counter++;
	
				$gridclass = "grid_event";
				//if (($counter % 2) == 0) { $gridclass = "grid_event_even"; }
	
				$proposal = $conf_proposals[$session['proposals_pk']];

				$trackclass = "";
				if($proposal['track']) {
					$trackclass = str_replace(" ","_",strtolower($proposal['track']));
				}

				$total_length += $proposal['length'];
	//for email
	
$msg ="The draft schedule for the Sakai Vancouver conference Presentation is now available at https://www.sakaiproject.org/conference/admin/schedule.php .  Your session details are shown below. \r\n";
	$msg .="Please email Wende Morgaine at wendemm@gmail.com with any corrections or comments regarding this information.  \r\n";
	 
	 	 $msg.="\r\nThank You\r\n      Susan Hardin\r\nwww.sakaiproject.org webmaster\r\n";
	 	
	 	 
 $this_email=$proposal['email'];
	 
	$mgs.="------------------------------------\r\n";
	$msg.="Proposal submitted by: "	. $proposal['firstname'] . ' ' .$proposal['lastname'] ."($this_email)"."\r\n";

	$msg.="Title: " . $proposal['title'] ."\r\n";
	$msg.="Scheduled Date is: " . $current_date . ": " .date('g:i a',strtotime($timeslot['start_time']))."\r\n";
	$msg.="Session Length: " . $proposal['length'] ." minutes"."\r\n";
	$msg.="Session Type: " . $proposal['type']."\r\n";
	$msg.="Track: " . $proposal['track']."\r\n\r\n";
	echo $msg;
	echo "<br/><br/>";
	
// This is a better set of mail headers -AZ
ini_set(SMTP, $MAIL_SERVER);
$headers  = 'From: ' . $HELP_EMAIL . "\n";
$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
$headers .= 'Reply-To: ' . 'wendemm@gmail.com' . "\n";
$headers .= 'MIME-Version: 1.0' ."\n";
$headers .= 'Content-type: text/plain; charset=ISO-8859-1' ."\n";
$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";
	
			
//set up mail for the speaker
$recipient = $this_email;
$subject= "Your Sakai Conference Presentation schedule";
//send the mail to attendee
mail($recipient, $subject, $msg, $headers);

		
//set up mail for the susan
$recipient = "shardin@umich.edu";
$subject= "Your Sakai Conference Presentation schedule";
//send the mail to attendee
//mail($recipient, $subject, $msg, $headers);
}
		}


?>
	
<?php 
		}
?>


<?php 
	}
} ?>
