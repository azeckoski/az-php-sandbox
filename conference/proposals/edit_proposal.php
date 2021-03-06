<?php

/*
 * Created on March 16, 2006 by @author aaronz
 * Modified from code by Susan Hardin (shardin@umich.edu)
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */

// TODO
// figure out the audience and  topic display code
// add proper validation to this code
//add a warning prior to deleting a proposal
?>
<?php

require_once '../include/tool_vars.php';

$PAGE_NAME = "Call for Proposals";
$Message = "";

// connect to database
require '../sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH . 'include/check_authentic.php';

// login if not autheticated
$AUTH_MESSAGE = "You must login to register or submit a proposal for the $CONF_NAME conference. If you do not have an account, please create one.";
require $ACCOUNTS_PATH . 'include/auth_login_redirect.php';

// bring in the form validation code
require $ACCOUNTS_PATH . 'ajax/validators.php';

// bring in inst and conf data
require '../registration/include/getInstConf.php';

// get the passed message if there is one
if ($_GET['msg']) {
	$Message .= "<br/>" . $_GET['msg'];
}

$CSS_FILE = $ACCOUNTS_URL.'/include/accounts.css';

$PK = $_REQUEST["pk"]; // grab the pk
$type = $_REQUEST["type"]; // grab the proposal type
$error = false; // preset the error flag to no errors
$allowed = false; // assume user is NOT allowed unless otherwise shown

// this allows us to use this page as an edit for admins or
// to add/edit/delete for normal users (don't forget to handle the errors flag)
// NOTE: make sure the permission check below is looking for the right permission
if (!$PK) {
	// no PK set so we must be adding a new item
	$Message = "";
	$allowed = true;
} else {
	// pk is set, see if it is valid for this user
	$check_sql = "select pk, users_pk from conf_proposals where pk='$PK'";
	$result = mysql_query($check_sql) or die("check query failed ($check_sql): " . mysql_error());
	if (mysql_num_rows($result) > 0) {
		$row = mysql_fetch_assoc($result);
		if (($row['users_pk'] != $User->pk) && !$User->checkPerm("admin_conference")) {
			// this item is not owned by current user and current user is not an admin
			$error = true;
			$allowed = false;
			$Message = "You may not access someone else's conference proposal entry " .
			"unless you have the (admin_conference) permission.";
		} else {
			$allowed = true;
			// entry is owned by current user or they are an admin
			if ($_REQUEST["delete"]) {
				// get the title for this proposal for clarity of display and to confirm it exists
		        $select_sql = "select title from conf_proposals where pk='$PK'";
		        $result = mysql_query($select_sql) or die("title select failed ($select_sql): " . mysql_error());			        

				if (mysql_num_rows($result) > 0) {
					$row = mysql_fetch_assoc($result);
					$title = $row['title'];
		        
					// if delete was passed then wipe out this item and related items
					//DO NOT DELETE - just mark as deleted
					$delete_sql = "update conf_proposals set `approved`='D' where pk='$PK'";
					$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): " . mysql_error());

					//now delete the audiences for this proposal
					//$delete_sql = "delete from proposals_audiences where proposals_pk='$PK'";
					//$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): " . mysql_error());
	
					//now delete the topic ranking for this proposal
					//$delete_sql = "delete from proposals_topics where proposals_pk='$PK'";
					//$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): " . mysql_error());
					// NOTE: Don't forget to handle the deletion below as needed
	
					$msg = "GREEN:Deleted proposal entitled $title.";
					$PK = 0; // clear the PK
				}
				else { 
					$msg = "RED:Can't delete proposal $PK because it doesn't seem to exist.";
					$PK = 0; // clear the PK				
				}
				// redirect to the index page
				header("Location:index.php?msg=$msg");
			}
		}

	} else {
		// PK does not match, invalid PK set to this page
		$error = true;
		$Message = "Invalid item PK ($PK): Item does not exist";
	}
}

// fetch the conference rooms
$sql = "select * from conf_rooms where confID = '$CONF_ID'";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_rooms = array ();
while ($row = mysql_fetch_assoc($result)) {
	$conf_rooms[$row['pk']] = $row;
}

// fetch the conference timeslots
$sql = "select * from conf_timeslots where confID = '$CONF_ID'";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_timeslots = array ();
while ($row = mysql_fetch_assoc($result)) {
	$conf_timeslots[$row['pk']] = $row;
}

// fetch the conf sessions
$sql = "select * from conf_sessions where confID = '$CONF_ID' order by ordering";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_sessions = array ();
while ($row = mysql_fetch_assoc($result)) {
	$conf_sessions[$row['pk']] = $row;
}

// fetch the proposals that have sessions assigned
$sql = "select CP.pk, CP.title, CP.abstract, CP.track, CP.speaker, CP.co_speaker, CP.bio, " .
"CP.type, CP.length, CP.approved, CP.URL, CP.wiki_url from conf_proposals CP " .
"join conf_sessions CS on CS.proposals_pk = CP.pk " .
"where CP.confID = '$CONF_ID'" . $sqlsearch .
$filter_type_sql . $filter_days_sql . $filter_track_sql . $sqlsorting . $mysql_limit;

$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_proposals = array ();
while ($row = mysql_fetch_assoc($result)) {
	$conf_proposals[$row['pk']] = $row;
}

// now put these together into a 3D array
$timeslots = array ();
foreach ($conf_timeslots as $conf_timeslot) {
	$rooms = array ();
	if ($conf_timeslot['type'] != 'event') {
		// we don't need all the rooms inserted for rows that don't use them
		$rooms['0'] = '0'; // placeholder
	} else {
		foreach ($conf_rooms as $conf_room) {
			$sessions = array ();
			foreach ($conf_sessions as $conf_session) {

				if ($conf_session['timeslots_pk'] == $conf_timeslot['pk'] && $conf_session['rooms_pk'] == $conf_room['pk']) {
					$sessions[$conf_session['pk']] = $conf_session;
					if ($conf_session['proposals_pk'] == $PK) {
						$is_scheduled = true;
						if ($conf_session['proposals_pk'] == NULL) {
							$is_scheduled = false;

						}
						//get the current schedule information for this session

						$this_session_pk = $conf_session['pk'];
						$this_room_pk = $conf_session['rooms_pk'];
						$this_room_name = $conf_room['title'];
						$this_timeslot_pk = $conf_timeslot['pk'];
						$this_start_time = date('D, M d, g:i a', strtotime($conf_timeslot['start_time']));
						$this_end_time = date('g:i a', strtotime($conf_timeslot['start_time']) + ($conf_timeslot['length_mins'] * 60));
						$this_room_size = $conf_room['capacity'];

					}

				}

				$rooms[$conf_room['pk']] = $sessions;

			}

		}
	}
	$timeslots[$conf_timeslot['pk']] = $rooms;

}

//echo "<pre>",print_r($conf_session['proposals_pk'] ),"</pre><br/>";

//echo "<pre>",print_r($items),"</pre><br/>";
// Define the array of items to validate and the validation strings
$vItems = array ();
$vItems['title'] = "required";
$vItems['abstract'] = "required";
$vItems['desc'] = "required";
$vItems['speaker'] = "required";
$vItems['bio'] = "required";
$vItems['type'] = "required";
$vItems['layout'] = "required";
$vItems['plength'] = "required";
$vItems['audience'] = "required:multirad;1";
$vItems['topic'] = "required:multirad;1";

$vItems['posters'] = "required";

//echo "<pre>",print_r($_POST),"</pre>";

if ($_POST['save']) {
	// DO SERVER SIDE VALIDATION
	$errors = 0;
	$validationOutput = ServerValidate($vItems, "return");
	if ($validationOutput) {
		$errors++;
		$Message = "<fieldset><legend>Validation Errors</legend>" .
		"<b style='color:red;'>Please fix the following errors:</b><br/>" .
		$validationOutput . "</fieldset>";
	}

	if ($errors == 0) {
		// saving the form

		$title = mysql_real_escape_string($_POST['title']);
		$abstract = mysql_real_escape_string($_POST['abstract']);
		$desc = mysql_real_escape_string($_POST['desc']);
		$speaker = mysql_real_escape_string($_POST['speaker']);
		$bio = mysql_real_escape_string($_POST['bio']);
		$co_speaker = mysql_real_escape_string($_POST['co_speaker']);
		$co_bio = mysql_real_escape_string($_POST['co_bio']);
		$url = mysql_real_escape_string($_POST['URL']);
		$wiki_url = mysql_real_escape_string($_POST['wiki_url']);
		$num_posters=$_POST['posters'];

		$type = $_POST['type'];
		$layout = $_POST['layout'];
		// NOTE: You cannot use length as an identifier, it is a reserved word in AJAX -AZ
		$length = $_POST['plength'];
		if ($type == "BOF") {
			$approved = "Y";
			$length = "60";
		}
		
		$conflict = trim($_POST['conflict_tue'] . " " . $_POST['conflict_wed'] . " " . $_POST['conflict_thu'] . " " . $_POST['conflict_fri']);

		$msg = "";
		if ($PK) { //this proposal has been edited
			// update proposal information  --all data except role and topic data
			$proposal_sql = "UPDATE conf_proposals" .
			" set  `title`='$title' , `abstract`='$abstract', " .
			" `speaker`='$speaker' , `URL` ='$url', `bio`='$bio',"  .
			" `co_speaker`='$co_speaker' ,  `wiki_url` ='$wiki_url', `poster`='$num_posters' where pk= '$PK'   ";

			$result = mysql_query($proposal_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
			" form submission. Please try to submit the form again. " .
			"If you continue to have problems, please report the problem to the " .
			"<a href='mailto:$HELP_EMAIL'>sakaiproject.org webmaster</a>.");

			$msg = "GREEN:Saved changes to $type entitled $title.";
			//TODO
			//add a cutoff date for editing proposal information such as Topics and Audiences
			//note:  no longer allowing edits of Topics and Audiences 
			//this is better handled by an editing cutoff date 
			
			//now delete the audiences for this proposal
			//$delete_sql = "delete from proposals_audiences where proposals_pk='$PK'";
			//$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): " . mysql_error());
	
			//now delete the topics for this proposal
			//$delete_sql = "delete from proposals_topics where proposals_pk='$PK'";
			//$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): " . mysql_error());


			//now update the conf_session table if they selected a timeslot for the BOF
			//if timeslot was selected for a BOF-  update the conf_sessions table
			$bof_timeslot = $_POST['bof_selection'];
			if ($bof_timeslot) { //user selected a timeslot for the BOF
				$update_session_sql = "update conf_sessions set proposals_pk = '$PK' where pk='$bof_timeslot' ";
				$result = mysql_query($update_session_sql) or die("delete query failed ($update_session_sql): " . mysql_error());

			}

		} else { //this is a new  proposal so add this to the conf_proposals table

			$track = ""; // tracks are determined after the voting process - except for Demos and BOFs
			if ($type == "demo") {
				$track = "Demo";
			} else
			if ($type == "poster") {
				$track = "Poster";
			} else
				if ($type == "BOF") {
					$track = "BOF";
				}
			$approved = "";
			if ($type == "demo") {
				$approved = "Y";
			} else
				if ($type == "poster") {
				$approved = "Y";
			} else
				if ($type == "BOF") {
					$approved = "Y";
					$length = "60";
				}
				
					$count_sql = "select * from conf_proposals where confID='$CONF_ID' ";
			$result = mysql_query($count_sql) or die('count query failed: ' . mysql_error());
			$num_rows = mysql_num_rows($result);
			$proposal_num=$num_rows+1;
				

			//first add presentation information into --all data except role and topic data
			$proposal_sql = "INSERT INTO `conf_proposals` ( `date_created` , `confID` , `users_pk` , `type`, " .
			"`title` , `abstract` , `desc` , `speaker` , `URL` , `bio` , `layout` , `length` ," .
			" `conflict` , `co_speaker` , `co_bio` , `approved`, `track`, `wiki_url`, `poster`, `order_num`)
							VALUES ( NOW() , '$CONF_ID', '$User->pk', '$type', '$title', '$abstract', " .
			"'$desc', '$speaker', '$url', '$bio' , '$layout' , '$length', '$conflict' ," .
			" '$co_speaker' , '$co_bio' , '$approved', '$track', '$wiki_url', '$num_posters', '$proposal_num')";

			$result = mysql_query($proposal_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
			"registration form submission. Please try to submit the registration again. " .
			"If you continue to have problems, please report the problem to the " .
			"<a href='mailto:$HELP_EMAIL'>sakaiproject.org webmaster</a>.");

			$PK = mysql_insert_id(); //get this proposal_pk

			//now update the conf_session table if they selected a timeslot for the BOF
			//if timeslot was selected for a BOF-  update the conf_sessions table
			$bof_timeslot = $_POST['bof_selection'];
			if ($bof_timeslot) { //user selected a timeslot for the BOF
				$update_session_sql = "update conf_sessions set proposals_pk = '$PK' where pk='$bof_timeslot' ";
				$result = mysql_query($update_session_sql) or die("delete query failed ($update_session_sql): " . mysql_error());

			}
			$msg = "GREEN:Created new $type entitled $title.";
		// go through all the POST values and add any topics or audience items
		// to the appropriate tables
		foreach (array_keys($_POST) as $key) {
			if ($_POST[$key] == "") {
				continue;
			} // skip blank values

			$check = strpos($key, 'audience_');
			$check2 = strpos($key, 'topic_');
			if ($check !== false && $check == 0) {
				$itemPk = substr($key, 9);
				$newValue = $_POST[$key];

				$insert_sql = "INSERT INTO `proposals_audiences` " .
				"(`date_created` , `proposals_pk` , `roles_pk` , `choice` )" .
				"VALUES (NOW(), '$PK', '$itemPk', '$newValue')";
				$result = mysql_query($insert_sql) or die("Query failed ($insert_sql): " . mysql_error());

			} else
				if ($check2 !== false && $check2 == 0) {
					$itemPk = substr($key, 6);
					$newValue = $_POST[$key];

					$insert_sql = "INSERT INTO `proposals_topics` " .
					"(`date_created` , `proposals_pk` , `topics_pk` , `choice` ) " .
					"VALUES(NOW(), '$PK', '$itemPk', '$newValue')";
					$result = mysql_query($insert_sql) or die("Query failed ($insert_sql): " . mysql_error());
				}
		}

		} // finished handling new proposal submission

		
		// redirect back to the index page
		header("Location:index.php?msg=$msg");
	}
}



// top header links
$EXTRA_LINKS = "<span class='extralinks'>";
	$EXTRA_LINKS .= "<a  href='$ACCOUNTS_URL/index.php' title='Sakai accounts home'><strong>Home</strong></a>:";

$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/registration/index.php'>Register</a>" .
"<a class='active'  href='$CONFADMIN_URL/proposals/index.php'>Call for Proposals</a>" ;
if ($SCHEDULE_PUBLISHED) { 
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
			$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/volunteer.php'>Volunteer</a>";
	
		 }  else {
		 		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/draft_schedule.php'>Schedule</a>";
	
		 	
		 }
	
	$EXTRA_LINKS.="</span>";

include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<?php  // INCLUDE THE HEADER
include $ACCOUNTS_PATH.'/include/header.php';  ?>
<div id="maincontent">
<?php include 'include/proposals_LeftCol.php'?>


<?php

// if a PK was supplied, we are editing
if ($PK) {
	$sql = "select U1.firstname, U1.lastname, U1.email, U1.institution, " .
	"U1.firstname||' '||U1.lastname as fullname,  " .
	"CP.* from conf_proposals CP left join users U1 on U1.pk = CP.users_pk " .
	"where CP.confID = '$CONF_ID' and CP.pk=$PK";
	$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
	$item = mysql_fetch_assoc($result); // put first item into an array

	if (mysql_num_rows($result) > 0) {
		// update the type
		$type = $item['type'];

		// refer to the item array by name $_POST (this might not be a good idea) -AZ
		foreach ($item as $key => $value) {
			$_POST[$key] = $value;
		}
		
		$_POST['plength']= $_POST['length']; //changed for proper validation
		
		if ($type == "demo") {
			$Message = "<tr><td><div style='text-align: left; padding: 5px; background: #ffcc33; color:#000;'><strong>Editing Technical Demo: </strong>" . $_POST['title'] . "<br/><strong>Submitted by: </strong>" . $item['firstname'] . " " . $item['lastname'] . "</div><div><br/></div></td></tr>";
		} else
		if ($type == "poster") {
			$Message = "<tr><td><div style='text-align: left; padding: 5px; background: #ffcc33; color:#000;'><strong>Editing Poster Session: </strong>" . $_POST['title'] . "<br/><strong>Submitted by: </strong>" . $item['firstname'] . " " . $item['lastname'] . "</div><div><br/></div></td></tr>";
		} else
			if ($type == "BOF") {
				$Message = "<tr><td><div style='text-align: left; padding: 5px; background: #ffcc33; color:#000;'><strong>Editing BOF session: </strong>" . $_POST['title'] . "<br/><strong>Submitted by: </strong>" . $item['firstname'] . " " . $item['lastname'] . "</div><div><br/></div></td></tr>";
			} else {
				$Message = "<tr><td><div style='text-align: left; padding: 5px; background: #ffcc33; color:#000;'><strong>Editing Presentation: </strong>" . $_POST['title'] . "<br/><strong>Submitted by: </strong>" . $item['firstname'] . " " . $item['lastname'] . "</div><div><br/></div></td></tr>";
			}

		// get the dates when a presenter cannot be available
		$conflict = $_POST['conflict'];
		if (preg_match("/Tue/", $conflict)) {
			$_POST['conflict_tue'] = "Tue";
		}
		if (preg_match("/Wed/", $conflict)) {
			$_POST['conflict_wed'] = "Wed";
		}
		if (preg_match("/Thu/", $conflict)) {
			$_POST['conflict_thu'] = "Thu";
		}
		if (preg_match("/Fri/", $conflict)) {
			$_POST['conflict_fri'] = "Fri";
		}
	} else {
		$Message = "ERROR: Could not get information for: $PK";
	}
}
?>

<table width="100%"  cellpadding="0" cellspacing="0">
   <?php

if ($Message) {
	echo $Message;

}

if ($is_scheduled) {
?>
  <tr>
	  
	 <td height="25" bgcolor="#ffffff" style=" border-top: 5px solid #FFFFFF;">
	 	 <div style="background: #fff; border: 1px solid orange; padding:10px;">  	 
			<div><strong>This session has been scheduled - please see the <a href="../admin/schedule.php">master schedule </a> for details. </strong>
			 <br/></div>
			</div>			
	    <br/>
	     </td>
  </tr> 
		<?

}
if ($Message) {
?>	    
	
  
  <?php } ?>
	   
</table>

<?php

	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		echo "<a href='index.php'>Back to Proposals</a>";
		include $ACCOUNTS_PATH . 'include/footer.php';
		exit;
	}
?>

<div id="cfp">
  <form name="form1" id="form1" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
   <input type="hidden" name="save" value="1" />
   <input type="hidden" name="pk" value="<?= $PK ?>" />


   	<table width="100%"  cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" colspan="2" style="padding:0px;">
			<div id="requiredMessage"></div>
		</td>
	</tr>

<?php if ($type=="demo") { ?>
  	<tr>
    <td colspan=2>
    		<div><strong> Technical Demo Proposal </strong></div>
    		<div style="padding:0px 10px;">
					Technology Demos will take place on Wednesday evening, June 13th. <br/><br/>
					<blockquote>
<p><strong>We will provide the following for your demonstration:</strong></p></blockquote>
<blockquote>
<ul>
<li>One 6-foot table, 2 chairs <br />
</li>
<li>One projection screen and projector</li>
<li>One power strip <br />
</li>
<li>A small sign with the title of your demonstration<br />

<br />
</li></ul></blockquote>
<blockquote>
<p><strong>You will need to provide the following (if needed):</strong></p></blockquote>
<blockquote>
<ul>
<li>Additional power strips and/or Eruopean power adapters  </li>

<li>Pre-printed material to hand out.&nbsp;&nbsp; Copy services are not provided by the conference.&nbsp;&nbsp; You will need to arrange with the hotel or a local company to provide printed material.&nbsp; <br />

</li></ul></blockquote>
				<!--	[<a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=173&amp;Itemid=523" target=blank>more information</a>]
				-->
				</div>
    </td>
</tr>

<?php

} else
if ($type=="poster") { ?>
  	<tr>
    <td colspan=2>
    		<div><strong> Poster Session </strong></div>
    		<div style="padding:0px 10px;">
				<!--	[<a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=173&amp;Itemid=523" target=blank>more information</a>]
				-->
				</div>
    </td>
</tr>

<?php

} else
	if ($type == "BOF") {
?>
 	<tr>
    <td colspan=2>
    		<div><strong>Birds of a Feather (BOF) session </strong></div>
    		<div style="padding:0px 10px;">
					BOFs may take place at any time during the conference. 
					We have a limited group of rooms and timeslots which you may choose from. 
					 When rooms are filled, we will do our best to locate 
					'community areas' within the hotel where you may gather for impromptu BOFS.   <br/><br />
					We encourage you to create a BOF wiki pages in our <a href="http://bugs.sakaiproject.org/confluence/display/CONF07/BOF-Birds+of+a+Feather+meetings" target=blank>Conference Wiki</a> 
					then enter your BOF's wiki page's URL into this form so we can easily link to your BOF page from our main schedule. <br/><br/>
					
				</div>
			
    </td>
</tr>
<?php

		if (!$is_scheduled) { //show the list of open bof rooms
		if ($ACCEPT_BOF) {
?>

<tr><td colspan=2>
       
      <div><strong>Select a room/timeslot: </strong><br/><br/>
       Please select the room that has a capacity which best matches
      your expected BOF group size. Contact Mary Miles at mmiles@sakaifoundation.org 
      if you cannot find a timeslot or room that fits your group's needs.<br/><br/>
      <strong>NOTE:   </strong>You may submit this form without selecting a timeslot.  You may return later and select from the available rooms.<br/>
<br/><strong>Special Timeslot: </strong> Thursday, December 7th from 4:30 -5:30 pm.  <br/> These 60 minute blocks must be scheduled manually by our staff.  To reserve a BOF meeting room during this timeslot, please contact shardin@umich.edu.        </div>
 		<div align=center><br/>
 		<?php

			// create the grid
			$line = 0;
			$last_date = 0;
			$conference_day = 0;
?>
 		
		<select name="bof_selection">
		<option value=""> -- select a room/time --</option> 
		<?php

			foreach ($timeslots as $timeslot_pk => $rooms) {
				$line++;
				$timeslot = $conf_timeslots[$timeslot_pk];

				//
				foreach ($rooms as $room_pk => $room) {

					$conf_room = $conf_rooms[$room_pk];

					if (is_array($room)) {
						$counter = 0;
						foreach ($room as $session_pk => $session) {
							$counter++;

							$bof_session_check = $conf_proposals[$session['proposals_pk']];

							if ($bof_session_check == 0) { //get only the list of open BOF slots
								echo "<option value=" . $session['pk'] . ">" .
								date('l', strtotime($timeslot['start_time'])) . " " .
								date('g:i a', strtotime($timeslot['start_time'])) . " - " .
								date('g:i a', strtotime($timeslot['start_time']) + ($timeslot['length_mins'] * 60)) .
								" " . $conf_room['title'] . " (capacity: " . $conf_room['capacity'] . ")" . "</option>";
							}
						}
					}
				}
			}
?>
		</select>
				</div>
	 
		</td>
	</tr>
	   <?php } 
		}?>
<?php } else {
	if(!$PK)  {  //user is editing so no need to show this info
	
 ?>
<tr>
    <td colspan=2>	
   <?php  if (strtotime($CFP_END_DATE) < time()) {  ?>
   	
  <!-- <div style="padding:5px; border: 1px solid #ffcc33; background:#fff;"><strong><span style="color:#660000;">Please Note:</span></strong>  At this time our schedule cannot accomodate any new presentations.  This option is available only for those who need to submit/resubmit a presentation as requested by the conference committe.
		</div>	-->
   <?php } ?>
    	<div><strong> Proposal for Conference Presentation </strong></div>
         <div>Select the most appropriate Presentation Topic Areas, Intend Audiences, and Format for your presentation from the options provided below.
         	 Please note that these classifications and titles will be used by the program commitee for the proposal review and conference
          	planning process, and may not be the classifications or titles used for the final conference program. 
         </div>
    </td>
</tr>
<?php }
	} ?>

<tr>
	<td valign="top" colspan="2" style="padding:0px;"><div id="requiredMessage"></div>
	</td>
</tr>

<tr>
 	<td style="width:15em;">
<?php if ($type == "demo") { ?>
 	    <img id="titleImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
 	    <strong>Product or Tool Name</strong>
<?php } else  if ($type == "BOF") { ?>
 	    <img id="titleImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
 	    <strong>BOF Title</strong>

<?php } else  if ($type == "poster") { ?>
 	    <img id="titleImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
 	    <strong>Poster Title/Topic</strong>
<?php } else  { ?>
 		<img id="titleImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
 		<strong>Presentation Title</strong>
<?php } ?>
  	</td>
   	<td>
   		<input type="text" name="title" size="40" maxlength="75" value="<?= $_POST['title'] ?>" /> <br/>(75 max chars)
    	<input type="hidden" id="titleValidate" value="<?= $vItems['title'] ?>" />
    	<span id="titleMsg"></span>
   	</td>
</tr>

<tr>
    <td colspan=2><img id="abstractImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
<?php if ($type == "demo") {?>
		<strong>Demo Description</strong> ( 50 word max.)  <br/>
		This will appear on the conference program.
<?php } else if ($type == "poster") {?>
		<strong>Poster Description</strong> ( 50 word max.)  <br/>
		This will appear on the conference program.
<?php } else if ($type == "BOF") {?>
		<strong>Description </strong> ( 50 word max.)  <br/>
<?php } else { ?>
    	<strong>Presentation Summary </strong> ( 50 word max.)  <br/>
    	This summary will appear on the conference program.
<?php } ?>
   		<br/>
   		<textarea name="abstract" cols="75" rows="6"><?= $_POST['abstract'] ?></textarea>
       	<input type="hidden" id="abstractValidate" value="<?= $vItems['abstract'] ?>" />
       	<span id="abstractMsg"></span>
       	<br/>
    </td>
</tr>

<?php if (($type!="demo") && ($type!="BOF") && ($type!="poster")) { 
?>
	<tr>
	<td colspan=2>
		<img id="descImg" src="/accounts/ajax/images/required.gif" width="16" height="16" /> <strong>Presentation Description: </strong>( 150 word max.)
		<br/>This description is used by the program committee for a more in-depth review of your session. <br/>
		<textarea name="desc" cols="75" rows="6" ><?= $_POST['desc']  ?></textarea>
		<input type="hidden" id="descValidate" value="<?= $vItems['desc'] ?>" />
		<span id="descMsg"></span>
	</td>
</tr>
<?php 
} ?>

<?php if ($type == "poster") { ?>
 	<tr>
	<td colspan=2>
		<img id="postersImg" src="/accounts/ajax/images/required.gif" width="16" height="16" /> <strong>How many posters will you present on this topic?</strong>
	<input type="text" name="posters" size="3" value="<?= $_POST['poster']  ?>" /> <br/><br/>	<strong>Please Note:</strong>   We will provide one easel/stand for each poster you plan to submit.
				 	The maximum poster size we can accomodate is 24 x 36 inches. You may bring more than one poster for a given topic. However, if you plan to present on multiple projects or topics, please complete a separate submission form for each additional topic. <br/><br/>
				 	  <strong>Poster Designs: </strong> You may design your own poster or use the simple PowerPoint poster template we will provide sometime in March, once we have an official conference logo. <br/>
				
		<input type="hidden" id="postersValidate" value="<?= $vItems['posters'] ?>" />
		<span id="postersMsg"></span>
	</td>
</tr>
 	
<?php } ?>
 	
 

<tr>
    <td nowrap="y">
    	<img id="speakerImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
    	<strong>Presenter's name</strong>
    </td>
    <td>
    	(lead presenter and main contact for this proposal)<br/>
    	<input type="text" name="speaker" size="40" value="<?= $_POST['speaker']  ?>" maxlength="100"/>
		<input type="hidden" id="speakerValidate" value="<?= $vItems['speaker'] ?>" />
		<span id="speakerMsg"></span>
    </td>
</tr>

<?php if (($type!="demo") && ($type!="BOF") && ($type!="poster")){?>
<tr>
    <td colspan=2>
    	<img id="bioImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
    	<strong>Brief Text Bio</strong>
    	<br/>
      	(for primary presenter only - for online and print program. (50 word max.)<br/><br/>
      	<textarea name="bio" cols="75" rows="4" ><?= $_POST['bio']  ?></textarea>
     	<input type="hidden" id="bioValidate" value="<?= $vItems['bio'] ?>" />
     	<span id="bioMsg"></span>
    </td>
</tr>
<?php } ?>

<tr>
   <td><strong><br/>Co-Presenters</strong><br/>(if any)</td>
   <td>  
      <div id="co_presenters">  List the names of your co-presenters, one name per line. <br/>
       <textarea name="co_speaker" cols="40" rows="4"><?= $_POST['co_speaker']  ?></textarea><br/>
     </div>
   </td>
</tr>

<?php if ($type!="BOF") { ?>
<tr>
    <td><strong>Project URL </strong></td>
    <td>http://www.example.com<br/><input type="text" name="URL" size="35" value="<?= $_POST['URL']  ?>" maxlength="100" /></td>
</tr>
<?php

		} else {
?>
	
<tr>
    <td><strong>BOF wiki page URL </strong></td>
    <td>http://www.example.com<br/><input type="text" name="wiki_url" size="" value="<?= $_POST['wiki_url']  ?>" maxlength="255" /></td>
</tr>

<?php

		} //bof check
?>

<?php if (($type!="demo") && ($type!="BOF") && ($type!="poster")){ 
	if(!$PK)  {  //user is editing so no need to show the rest of this info
	?>
<tr>
   <td colspan=2>
     <div id="topicInfo">
		<div>
			<img id="topicImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
    		<strong>Topic Areas </strong>
    		<input type="hidden" id="topicValidate" value="<?= $vItems['topic'] ?>" />
     	</div>
     	<div>Presenters are asked to categorize their proposal by ranking the relevance of their proposal to a list of
	          topic areas. Once the deadline for submitting proposals has passed, the Conference Program Committee will review all the proposals and see 
	          which topic areas or tracks have emerged as most relevant for the Sakai community for this conference.  <br/><br/>
	     </div>

   		<div id="topicMsg"></div>

		<div id="topic">
			<div class="list_header">
				<div class="topic_vote_header">
		   		 	<span>&nbsp;n/a&nbsp;&nbsp;&nbsp;</span>
		   		 	<span>low&nbsp;&nbsp;</span>
		   		 	<span>med&nbsp;&nbsp;</span>
					<span>high&nbsp;&nbsp;&nbsp;</span>
					<span class="topic_type_header">TOPIC AREAS</span>
				</div>
				
			</div>
		     
	<?php
	
			//populate form with topic information
			$list_sql = "select PT.pk, PT.proposals_pk, T.topic_name, T.pk, PT.choice from topics T " .
			"left join proposals_topics PT on PT.topics_pk = T.pk and PT.proposals_pk='$PK' " .
			"order by T.topic_order";
			$result = mysql_query($list_sql) or die(mysql_error());
	
			while ($list_items = mysql_fetch_array($result)) {
				$itemID = "topic_" . $list_items['pk'];
	?>
			<div class="list_row">
				<div class="topic_vote">
			     <span><input name="<?= $itemID ?>" type="radio" value="" <?php if (!$list_items['choice']) { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;</span>
			     <span><input name="<?= $itemID ?>" type="radio" value="1" <?php if ($list_items['choice']=="1") { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;</span>
			     <span><input name="<?= $itemID ?>" type="radio" value="2" <?php if ($list_items['choice']=="2") { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;</span>
			     <span><input name="<?= $itemID ?>" type="radio" value="3" <?php if ($list_items['choice']=="3") { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;&nbsp;</span>
			  <span class="topic_type"><?= $list_items['topic_name'] ?></span>
			    </div>
				
			 </div>
	<?php } ?>
		</div> <!-- end topic -->
	</div> <!-- end topic info -->
  </td>
</tr>
<tr>
    <td colspan=2>
      <div id="audienceInfo">
		<div>
			<img id="audienceImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
			<strong>Intended Audience(s)</strong>
			<input type="hidden" id="audienceValidate" value="<?= $vItems['audience'] ?>" />
	    </div>
        <div> Please indicate your intended audience by selecting an interest level <strong>for at least one </strong>of the audience groups listed below. 
           For example, a session on your campus implementation might be of high interest to Implementors and of medium 
           interest to Senior Administration, etc. <br/><br/>
        </div>

		<div id="audienceMsg"></div>
		<div id="audience">
			<div class="list_header">
				<div class="topic_vote_header">
		   		 	<span>&nbsp;n/a&nbsp;&nbsp;&nbsp;</span>
		   		 	<span>low&nbsp;&nbsp;</span>
		   		 	<span>med&nbsp;&nbsp;</span>
					<span>high&nbsp;&nbsp;&nbsp;</span>
					<span class="topic_type_header">AUDIENCE</span>
				</div>
				
			</div>
	
			<?php
	
				//populate form with audience information
				$list_sql = "select PA.pk, PA.proposals_pk, R.role_name, R.pk, PA.choice from roles R " .
				"left join proposals_audiences PA on PA.roles_pk = R.pk and PA.proposals_pk='$PK' " .
				"order by R.role_order";
				$result = mysql_query($list_sql) or die(mysql_error());
	
				while ($list_items = mysql_fetch_array($result)) {
					$itemID = "audience_" . $list_items['pk'];
	?>
			<div class="list_row">
				<div class="topic_vote">
			     <span><input name="<?= $itemID ?>" type="radio" value="" <?php if (!$list_items['choice']) { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;</span>
			     <span><input name="<?= $itemID ?>" type="radio" value="1" <?php if ($list_items['choice']=="1") { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;</span>
			     <span><input name="<?= $itemID ?>" type="radio" value="2" <?php if ($list_items['choice']=="2") { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;</span>
			     <span><input name="<?= $itemID ?>" type="radio" value="3" <?php if ($list_items['choice']=="3") { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;&nbsp;</span>
			     <span class="topic_type"><?= $list_items['role_name'] ?></span>
			    </div>
				
			 </div>
	<?php } ?>
		</div> <!-- end audience -->
  	</div>   <!-- end audienceinfo-->
   </td>
 </tr>

 <tr>
    <td>
    	<img id="typeImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" />
    	<strong>Presentation Format</strong>
    </td>
    <td>
		<div class=small>see sidebar for <a href="#format_desc">format descriptions</a></div><br/>
          <input name="type" type="radio" value="discussion" <?php if ($_POST['type']=="discussion") { echo "checked"; } ?> /> Discussion <br/>
          <input name="type" type="radio" value="lecture" <?php if ($_POST['type']=="lecture") { echo "checked"; } ?> /> Lecture <br/>
          <input name="type" type="radio" value="panel" <?php if ($_POST['type']=="panel") { echo "checked"; } ?> /> Panel <br/>
          <input name="type" type="radio" value="workshop" <?php if ($_POST['type']=="workshop") { echo "checked"; } ?> /> Workshop (How-to) <br/>
	     <input name="type" type="radio" value="carousel" <?php if ($_POST['type']=="carousel") { echo "checked"; } ?> /> Tool Carousel (in-depth tool demo) <br/>
		<input type="hidden" id="typeValidate" value="<?= $vItems['type'] ?>" />
		<span id="typeMsg"></span>
   	 </td>
  </tr>

  <tr>
     <td>
     	<img id="layoutImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" />
     	<strong>Room setup desired</strong>
     </td>
     <td>
		<div class=small>We will do our best to accomodate your request</div><br/>
          <input name="layout" type="radio" value="class" <?php if ($_POST['layout']=="class") { echo "checked"; } ?> /> <strong>classroom </strong>(rows of narrow tables w/chairs)<br/>
          <input name="layout" type="radio" value="theater" <?php if ($_POST['layout']=="theater") { echo "checked"; } ?> /> <strong>theater </strong>(rows of chairs only)<br/>
          <input name="layout" type="radio" value="conference" <?php if ($_POST['layout']=="conference") { echo "checked"; } ?> /> <strong>conference</strong> (roundtables or conference room setup)<br/>
		<input type="hidden" id="layoutValidate" value="<?= $vItems['layout'] ?>" />
		<span id="layoutMsg"></span>
     </td>
  </tr>


  <tr>
     <td>
     	<img id="plengthImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" />
     	<strong>Presentation Length</strong>
     </td>
     <td>
		<div class="small">Times are not guaranteed. We will do our best to match each session with an appropriate time block</div><br/>
          <input name="plength" type="radio" value="30" <?php if ($_POST['plength']=="30") { echo "checked"; } ?> /> 30 minutes  <br/>
          <input name="plength" type="radio" value="60" <?php if ($_POST['plength']=="60") { echo "checked"; } ?> /> 60 minutes  <br/>
		<input type="hidden" id="plengthValidate" value="<?= $vItems['plength'] ?>" />
		<span id="plengthMsg"></span>
     </td>
  </tr>

  <tr>
     <td>	<img id="plengthImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" />
     <strong>Availability</strong></td>
     <td><div class=small> Please check the days that the presenter(s)<br/>CANNOT present due to a travel conflict</div>
        <br/> <strong> I am NOT available:</strong><br/>
          <input name="conflict_tue" type="checkbox" value="Tue" <?php if ($_POST['conflict_tue']=="Tue") { echo "checked"; } ?> /> Tuesday, June 12 <br/>
          <input name="conflict_wed" type="checkbox" value="Wed" <?php if ($_POST['conflict_wed']=="Wed")  { echo "checked"; } ?> /> Wednesday, June 13 <br/>
          <input name="conflict_thu" type="checkbox" value="Thu" <?php if ($_POST['conflict_thu']=="Thu")  { echo "checked"; } ?> /> Thursday, June 14 <br/>
        <!--  <input name="conflict_fri" type="checkbox" value="Fri" <?php if ($_POST['conflict_fri']=="Fri") { echo "checked"; } ?> /> Friday, May 2 <br/>
        --> 
        <input type="hidden" id="multiCheckValidate" value="required:multiple;2"/>
	<input type="hidden" id="multiCheckRename" value="one:two:three:four"/>
        
        <br/>
     </td>
  </tr>

<?php

	}
	} else { /* is demo check */
?>
	<tr>
        <td >&nbsp;</td>
        <td><input type="hidden" name="type" value="<?= $type ?>" /></td</tr>
<?php } ?>

    <tr>
        <td >&nbsp;</td>
        <td style="padding-top: 5px;">
		<?php if (!$PK) {  ?>
				<input id="submitbutton" type="submit" name="submit" value="Submit Proposal" />
				
				<?php } else { ?>
					<input id="submitbutton" type="submit" name="submit" value="Save Changes" />
				
					<?php }  ?>
			<br/>
        </td>
      </tr>
    </table>
  </form>

</div>
<!-- end cfp -->


</td></tr></table>
</div>
<?php

	
include $ACCOUNTS_PATH.'include/footer.php'; 
?>
