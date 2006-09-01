<?php
/*
 * Created on May 19, 2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
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


// Comment this out if the server is different from the one for accounts
require_once ($ACCOUNTS_PATH.'sql/mysqlconnect.php');

// Sakai Web mySQL server
// Uncomment these if the server is not the same as the one for accounts
/**
$dbhost = "localhost";
$dbname = "sakai";
$dbuser = "root";
$dbpass = "mujoIII";
/**/

// connect to the DB
// Uncomment these if the server is not the same as the one for accounts
/**
$db = mysql_connect("$dbhost", "$dbuser", "$dbpass");
if (!$db) {
   die("Unable to connect to DB ($dbhost): " . mysql_error());
}
if (!mysql_select_db("$dbname", $db)) {
   die("Unable to select $dbname: " . mysql_error());
}
**/

// fetch the conference rooms
$sql = "select * from conf_rooms where confID = 'Jun2006'";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_rooms = array();
while($row=mysql_fetch_assoc($result)) { $conf_rooms[$row['pk']] = $row; }

// fetch the conference timeslots
$sql = "select * from conf_timeslots where confID = 'Jun2006'";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_timeslots = array();
while($row=mysql_fetch_assoc($result)) { $conf_timeslots[$row['pk']] = $row; }

// fetch the conf sessions
$sql = "select * from conf_sessions where confID = 'Jun2006' order by ordering";
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
	"where CP.confID =  'Jun2006' ";
	$filter_type_sql . $filter_items_sql . $sqlsorting . $mysql_limit;

//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$conf_proposals = array();
while($row=mysql_fetch_assoc($result)) { $conf_proposals[$row['pk']] = $row; }


// First get the list of proposals and related users for the current conf 
// (maybe limit this using a search later on)
$sql = "select U1.firstname, U1.lastname, U1.email, U1.institution, " .
	"U1.firstname||' '||U1.lastname as fullname, CV.vote, " .
	"CP.* from conf_proposals CP left join users U1 on U1.pk = CP.users_pk " .
	"left join conf_proposals_vote CV on CV.conf_proposals_pk = CP.pk " .
	"and CV.users_pk='$User->pk' " .
	"where CP.confID = 'Jun2006'" . $sqlsearch . 
	$filter_type_sql . $filter_items_sql . $filter_status_sql . $filter_track_sql. $sqlsorting . $mysql_limit;

//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$items = array();

// put all of the query results into an array first
while($row=mysql_fetch_assoc($result)) { $items[$row['pk']] = $row; }


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

<table cellspacing=5 cellpadding=5>

<?php foreach ($items as $item) { // loop through all of the proposal items
 if ($item['type']== "demo")  { ?>



<?php }   }  ?>
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
			
		$num=0;
		// print the grid selector
		foreach ($rooms as $room_pk=>$room) { 
			
			
		?>
	
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
	
//$msg ="The draft schedule for the Sakai Vancouver conference Presentation is now available at https://www.sakaiproject.org/conference/admin/schedule.php .  Your session details are shown below. \r\n";
	$msg ="Thank you for your participation in the Sakai Vancouver Conference.\r\n\r\n  To help us plan our space usage for the Atlanta conference, we would like to gather more information on how well our space was used during the Vancouver conference.  Please reply to this message (to mmiles@umich.edu) with your answers to the questions below.     \r\n\r\n";

	 	 
 $this_email=$proposal['email'];
	 
	$msg .="------------------------------------\r\n";
	$msg.="Proposal submitted by: "	. $proposal['firstname'] . ' ' .$proposal['lastname'] ."($this_email)"."\r\n";

	$msg.="Title: " . $proposal['title'] ."\r\n";
	$msg.="Date: " . $current_date . ": " .date('g:i',strtotime($timeslot['start_time']))."\r\n";
	$msg.="Length: " . $proposal['length'] ." minutes"."\r\n";
	$msg.="Type: " . $proposal['type']."\r\n";
	$msg.="Track: " . $proposal['track']."\r\n";
	 $msg .="------------------------------------\r\n\r\n";
	
	 
	$msg .="1. Was the room too crowded (standing room only),  just full (all seats taken), or half filled? \r\n\r\n";
	$msg .="2. Was the time slot long enough for your presentation? \r\n\r\n";
	$msg .="3. If you happened to have taken note of the number of people attending your session, please provide that information. (an estimate is ok) \r\n\r\n";
	$msg .="4. Do you have any suggestions/comments regarding your session which will may help us to provide speakers or  attendees a better experience in Atlanta? \r\n\r\n";
	
 	
	 $msg .="\r\nThank you for your efforts in helping us to make each conference  a rewarding experience for all. \r\n\r\n  " .
	 		"    Mary Miles\r\n Sakai Conference Coordinator \r\n";
	
?>
<?php
if ((!$proposal['type']="demo") || (!$proposal['type']="BOF")) {
	echo "no<br/>";
	
	 }
	else {
	
	echo $proposal['pk'];
	echo $msg;
	
	echo "<br/><br/><br/>";
	}

?>



	<?php
// This is a better set of mail headers -AZ
ini_set(SMTP, $MAIL_SERVER);
$headers  = 'From: ' . $HELP_EMAIL . "\n";
$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
$headers .= 'Reply-To: ' . 'mmiles@umich.edu' . "\n";
$headers .= 'MIME-Version: 1.0' ."\n";
$headers .= 'Content-type: text/plain; charset=ISO-8859-1' ."\n";
$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";
	
			
//set up mail for the speaker
//$recipient = $this_email;
//$recipient - "shardin@umich.edu";
//$subject= "Your past Sakai Vancouver Conference Presentation";
//send the mail to attendee
//mail($recipient, $subject, $msg, $headers);

		
//set up mail for the susan
$recipient = "shardin@umich.edu";
$subject= "$this_email Your Sakai Conference Presentation schedule";
//send the mail to attendee
mail($recipient, $subject, $msg, $headers);

}

		}


?>
	
<?php 
		}
		
?>


<?php 
	}
} echo "</table>";
?>


<?php include $TOOL_PATH.'include/admin_footer.php'; ?>


