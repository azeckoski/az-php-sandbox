<?php

/*USER Editing page
 * Created on March 16, 2006 by @author aaronz
 * Modified from code by Susan Hardin (shardin@umich.edu)
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * updated for educonference.com Feb 2007 by Susan Hardin
 */

// TODO
//add a warning prior to deleting a proposal
?>
<?php

require_once '../include/tool_vars.php';

$PAGE_NAME = "Call for Proposals";

$ACTIVE_MENU = "HOME"; //for managing active links on multiple menus
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
					$delete_sql = "delete from conf_proposals where pk='$PK'";
					$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): " . mysql_error());

					//now delete the audiences for this proposal
					$delete_sql = "delete from proposals_audiences where proposals_pk='$PK'";
					$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): " . mysql_error());

					//now delete the topic ranking for this proposal
					$delete_sql = "delete from proposals_topics where proposals_pk='$PK'";
					$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): " . mysql_error());
					// NOTE: Don't forget to handle the deletion below as needed

					$msg = "BLUE:Deleted proposal entitled <strong>$title</strong>.";
					$PK = 0; // clear the PK
				} else {
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
} //end edit info

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
$sql = "select CP.* from conf_proposals CP " .
"join conf_sessions CS on CS.proposals_pk = CP.pk " .
"where CP.confID = '$CONF_ID'" . $sqlsearch .
$filter_type_sql . $filter_days_sql . $filter_track_sql . $sqlsorting . $mysql_limit;

$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_proposals = array ();
while ($row = mysql_fetch_assoc($result)) {
	$conf_proposals[$row['pk']] = $row;
}

//TO DO
// fetch the submitted document info for papers submitted

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

$vItems['type'] = "required";

//for the authors on Paper submissions
$vItems['auth1_first'] = "required";
$vItems['auth1_last'] = "required";
$vItems['auth1_org'] = "required";
$vItems['auth1_email'] = "required:email";
$vItems['auth2_email'] = "email";
$vItems['auth3_email'] = "email";
$vItems['auth4_email'] = "email";

$vItems['userfile'] = "required";

//echo "<pre>",print_r($_POST),"</pre>";

if ($_POST['save']) {
	// DO SERVER SIDE VALIDATION
	$errors = 0;
	$validationOutput = ServerValidate($vItems, "return");
	if ($validationOutput) {
		$errors++;
		$Message = "<fieldset><legend>Validation Errors</legend>" .
		"<b style='color:red;'><strong>Please fix the following errors:</strong></b><br/>" .
		$validationOutput . "</fieldset>";
	}
	
	//upload file to the server - if necessary
	if (isset ($_FILES['userfile']) && ($_FILES['userfile']['size'] > 0)) { //this is a new proposal
		// set the file upload directory
		$uploadDir = $FILE_UPLOAD_PATH;
		
		//get the file information
			$fileName = $_FILES['userfile']['name'];
			$tmpName = $_FILES['userfile']['tmp_name'];
			$fileSize = $_FILES['userfile']['size'];
			$fileType = $_FILES['userfile']['type'];
 		
		 // the check to see if the file exists already 
			    $filePath = $uploadDir . $fileName;
			
			  if (file_exists($filePath))
		      {
		 		$msg.="<div style='color:red;'><strong>UPLOAD ERROR: </strong>A file by that name already exists on the server." .
		 				" <br/> Please change the file name then try to upload the file again.<br/><br/></div>"	;
		       $errors++;
		  
		      }
		      if (($fileType=="application/pdf") || ($fileType=="application/msword") ) {
		      	
		      } else {
		      	$errors++;
		      	$msg.="<div style='color:red;'><strong>UPLOAD ERROR: </strong>Only PDF (.pdf)  or MSWORD (.doc) files are accepted file uploads.<br/><br/></div>"	;
		      }
				  // move the files to the specified directory
				// if the upload directory is not writable or
				// something else went wrong $result will be false
			    $result    = move_uploaded_file($tmpName, $filePath);
				if (!$result) {
					$msg.= "Error uploading file, please try again.";
					$error++;
				}   else {
				$file_Uploaded=true;
				}
				
		
			    if(!get_magic_quotes_gpc())
			    {
			        $fileName  = addslashes($fileName);
			        $filePath  = addslashes($filePath);
			  		}  
			  		
		}    //done checking the file upload
			
			
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
		$num_posters = $_POST['posters'];
		$paper_url = mysql_real_escape_string($_POST['paper_url']);

		$auth1_first = mysql_real_escape_string($_POST['auth1_first']);
		$auth1_last = mysql_real_escape_string($_POST['auth1_last']);
		$auth1_org = mysql_real_escape_string($_POST['auth1_org']);
		$auth1_email = mysql_real_escape_string($_POST['auth1_email']);
		$auth2_first = mysql_real_escape_string($_POST['auth2_first']);
		$auth2_last = mysql_real_escape_string($_POST['auth2_last']);
		$auth2_org = mysql_real_escape_string($_POST['auth2_org']);
		$auth2_email = mysql_real_escape_string($_POST['auth2_email']);
		$auth3_first = mysql_real_escape_string($_POST['auth3_first']);
		$auth3_last = mysql_real_escape_string($_POST['auth3_last']);
		$auth3_org = mysql_real_escape_string($_POST['auth3_org']);
		$auth3_email = mysql_real_escape_string($_POST['auth3_email']);
		$auth4_first = mysql_real_escape_string($_POST['auth4_first']);
		$auth4_last = mysql_real_escape_string($_POST['auth4_last']);
		$auth4_org = mysql_real_escape_string($_POST['auth4_org']);
		$auth4_email = mysql_real_escape_string($_POST['auth4_email']);
		$author_other = mysql_real_escape_string($_POST['author_other']);
		$type = $_POST['type'];
		$layout = $_POST['layout'];
		$length = $_POST['plength'];

		$conflict = trim($_POST['conflict_tue'] . " " . $_POST['conflict_wed'] . " " . $_POST['conflict_thu'] . " " . $_POST['conflict_fri']);

		$msg = "";
		if ($PK) { //this proposal has been edited
			// update proposal information  --all data except role and topic data
			$proposal_sql = "UPDATE conf_proposals" .
			" set  `title`='$title' , `abstract`='$abstract',   `desc`='$desc', `length`='$length', `type`='$type', `layout`='$layout', " .
			" `URL` ='$url', `bio`='$bio'," .
			"`auth1_first`='$auth1_first' ,  `auth1_last`='$auth1_last' ,   `auth1_org`='$auth1_org' ,   `auth1_email`='$auth1_email' , " .
			" `auth2_first`='$auth2_first' , `auth2_last`='$auth2_last' , `auth2_org`='$auth2_org' ,   `auth2_email`='$auth2_email' , " .
			" `auth3_first`='$auth3_first' ,  `auth3_last`='$auth3_last' ,`auth3_org`='$auth3_org' ,   `auth3_email`='$auth3_email' , " .
			" `auth4_first`='$auth4_first' ,  `auth4_last`='$auth4_last' , `auth4_org`='$auth4_org' ,   `auth4_email`='$auth4_email' ," .
			" `author_other`='$author_other' , " .
			"`wiki_url` ='$wiki_url', `poster`='$num_posters' where pk= '$PK'   ";

			$result = mysql_query($proposal_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
			" form submission. Please try to submit the form again. " .
			"If you continue to have problems, please report the problem to the " .
			"<a href='mailto:$HELP_EMAIL'>webmaster</a>.");
			
			$msg .= "BLUE:Saved changes to $type entitled <strong>$title</strong>.";
			
			if ($file_Uploaded) {   //a file is replacing a previously uploaded file
			$paper_sql = "UPDATE conf_proposals set `paper_url`='$fileName'  where pk= '$PK'";
			$result = mysql_query($paper_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the form submission. ");
			$msg .= "<br/>File <strong>$fileName </strong>uploaded successfully"; 
				
			}

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

			//if timeslot was selected for a BOF-  update the conf_sessions table
			$bof_timeslot = $_POST['bof_selection'];
			if ($bof_timeslot) { //user selected a timeslot for the BOF
				$update_session_sql = "update conf_sessions set proposals_pk = '$PK' where pk='$bof_timeslot' ";
				$result = mysql_query($update_session_sql) or die("delete query failed ($update_session_sql): " . mysql_error());

			}

		} else { //this is a new  proposal so add this to the conf_proposals table

			switch ($type) {
				case "demo" : $track = "Demo"; $approved = "Y"; break;
				case "poster" : $track = "Poster";$approved = "Y"; break;
				case "BOF" :$track = "BOF";$approved = "Y";$length = "60";break;
				case "paper" :	$approved = "N";
				default : $track = "";
			}
			
			$count_sql = "select * from conf_proposals where confID='$CONF_ID' ";
			$result = mysql_query($count_sql) or die('count query failed: ' . mysql_error());
			$num_rows = mysql_num_rows($result);
			$proposal_num=$num_rows+1;

			//first add presentation information into --all data except role and topic data
			$proposal_sql = "INSERT INTO `conf_proposals` ( " .
			"`date_created` , `confID` , `users_pk` , `type`,`title`, `abstract`, " .
			" `desc` ,  `URL` , `bio` , `layout` , `length` , `conflict` , " .
			" `auth1_first` , `auth1_last` , `auth1_org` , `auth1_email` ," .
			" `auth2_first` , `auth2_last`, `auth2_org` , `auth2_email` , " .
			"`auth3_first` , `auth3_last`, `auth3_org` ,  `auth3_email` , " .
			"`auth4_first` , `auth4_last`, `auth4_org` ,  `auth4_email` , " .
			"`author_other`," .
			" `approved`, `track`, `wiki_url`, `paper_url`, `poster`, `num`)
						VALUES ( NOW() , '$CONF_ID', '$User->pk', '$type', '$title', '$abstract', " .
			"'$desc',  '$url', '$bio' , '$layout' , '$length', '$conflict' ," .
			"'$auth1_first', '$auth1_last', '$auth1_org', '$auth1_email'," .
			" '$auth2_first',  '$auth2_last', '$auth2_org', '$auth2_email'," .
			" '$auth3_first',  '$auth3_last', '$auth3_org', '$auth3_email', " .
			" '$auth4_first',  '$auth4_last', '$auth4_org', '$auth4_email'," .
			"'$author_other', " .
			"'$approved', '$track', '$wiki_url', '$paper_url', '$num_posters', '$proposal_num')";

			$result = mysql_query($proposal_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
			"proposal form submission. Please try to submit the form again. " .
			"If you continue to have problems, please report the problem to the " .
			"<a href='mailto:$HELP_EMAIL'>webmaster</a>.");

			$PK = mysql_insert_id(); //get this proposal_pk
			
			//now update the conf_session table if they selected a timeslot for the BOF
			//if timeslot was selected for a BOF-  update the conf_sessions table
			$bof_timeslot = $_POST['bof_selection'];
			if ($bof_timeslot) { //user selected a timeslot for the BOF
				$update_session_sql = "update conf_sessions set proposals_pk = '$PK' where pk='$bof_timeslot' ";
				$result = mysql_query($update_session_sql) or die("delete query failed ($update_session_sql): " . mysql_error());

			}
			
			
			$msg .= "BLUE:Created new $type entitled $title.";
			
			if ($file_Uploaded) {   //a file is replacing a previously uploaded file
			$paper_sql = "UPDATE conf_proposals set `paper_url`='$fileName'  where pk= '$PK'";
			$result = mysql_query($paper_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the form submission. ");
			$msg .= "<br/>File <strong>$fileName </strong>uploaded successfully"; 
				
			}
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
		}
		
		 // finished handling new proposal submission
	

		// redirect back to the index page
		header("Location:index.php?msg=$msg");

	}
}
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
		$_POST['plength'] = $_POST['length'];

		$Message = "<div class='status'><strong>Editing: </strong>" . $_POST['title'] . "<br/><strong>Submitted by: </strong>" . $item['firstname'] . " " . $item['lastname'] . "</div><div><br/></div>";

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

//get the proposal type
switch ($type) {
	case "paper" : $typeheader = "Call for Papers";	$current_type = "Paper"; $header_MSG = "$PAPER_MSG"; break;
	case "poster" : $typeheader = "Call for Posters"; $current_type = "Poster"; $header_MSG = "$_POSTER_MSG"; break;
	case "demo" : $typeheader = "Call for Demos"; $current_type = "Demo"; $header_MSG = "$DEMO_MSG"; break;
	case "BOF" : $typeheader = "Birds of a Feather (BOF) meetings"; $current_type = "BOF"; $header_MSG = "$BOF_MSG"; break;
	default :	$typeheader = "Call for Presentation Proposals"; $current_type = "Presentation"; $header_MSG = "$PRESENT_MSG";	break;
}

$CSS_FILE = $ACCOUNTS_URL . '/include/accounts.css';

// top header links
$EXTRA_LINKS = "<span class='extralinks'>";
	$EXTRA_LINKS .= "<a  class='active' href='$ACCOUNTS_URL/index.php' title='Sakai accounts home'><strong>Home</strong></a>:";

$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/registration/index.php'>Register</a>" .
"<a  href='$CONFADMIN_URL/proposals/index.php'>Call for Proposals</a>" ;
if ($SCHEDULE) { 
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
		 }
	
	$EXTRA_LINKS.="</span>";



// INCLUDE THE HTML HEAD
include $ACCOUNTS_PATH . 'include/top_header.php';
?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<!-- // INCLUDE THE HEADER -->
<?php
 // INCLUDE THE HEADER
include $ACCOUNTS_PATH . '/include/header.php';
?>
<div id="maincontent">
<?php include 'include/proposals_LeftCol.php'?>

	
<?php  if ($msg ) { echo $msg; } ?> 

<?php  if ($Message ) { echo $Message; } ?> 
<?php

// Put in footer and stop the rest of the page from loading if not allowed -AZ
if (!$allowed) {
	echo "<a href='index.php'>Back to Proposals</a>";
	include $ACCOUNTS_PATH . 'include/footer.php';
	exit;
}
?>
<table width="100%"  cellpadding="0" cellspacing="0">
 	<tr>
	   <td>
	   </td>
	</tr>
  

	<?php

if ($is_scheduled) { //already approved and on the main schedule
?>
  	<tr>  
	 <td class="scheduled">
	 	<div><strong>This session has been scheduled - please see the <a href="../admin/schedule.php">master schedule </a> for details. </strong>
			</div>	
	    <br/> 
	   </td>
	 </tr> 
	<? }  ?>
		    
	</table>


<div id="cfp">
  <form name="form1" id="form1" method="post"  enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF'] ?>">
   <input type="hidden" name="save" value="1" />
   <input type="hidden" name="pk" value="<?= $PK ?>" />
   
   <input type="hidden" name="type" value="<?= $type ?>" />

   	<table width="100%"  cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" colspan="2" style="padding:0px;">
			<div id="requiredMessage"></div>
		</td>
	</tr>
	<?php if($header_MSG) { ?>
  	<tr>
    <td colspan="2">
    		<div><strong><?=$current_type ?> </strong></div>
    		<div class="form_row"><?php echo $header_MSG; ?></div>
    </td>
	</tr>
	<?php } ?>
<?php

	if ($type == "BOF") {
		if (!$is_scheduled) { //show the list of open bof rooms
?>
		<tr><td colspan="2">
       <div>  <?= $BOF_INSTRUCTIONS ?></div>
	   <div align=center><br/>
			<select name="bof_selection">
			<option value=""> -- select a room/time --</option> 
			<?php

			foreach ($timeslots as $timeslot_pk => $rooms) {
				$line++;
				$timeslot = $conf_timeslots[$timeslot_pk];

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
	   <?php } ?>
<?php } ?>
	
<tr>
	 	<td style="width:15em;">
	 		<img id="titleImg" alt="valid indicator" src="/accounts/ajax/images/blank.gif" width="16" height="16" />
	 		<strong><?= $current_type ?> Title</strong>
	  	</td>
	   	<td>
	   		<input type="text" name="title" size="50" maxlength="200" value="<?= $_POST['title'] ?>" /> <br/>(100 max chars)
	    	<input type="hidden" id="titleValidate" value="<?= $vItems['title'] ?>" />
	    	<span id="titleMsg"></span>
	   	</td>
	</tr>

<tr>
    <td colspan="2"><img id="abstractImg" alt="valid indicator" src="/accounts/ajax/images/blank.gif" width="16" height="16" />
		<?php if (($current_type=="BOF") || ($current_type=="Demo") || ($current_type=="Poster")) { ?>
		<strong><?=$current_type ?> Summary</strong> ( 50 word max.)  <br/>
		<?php } else  if ($current_type=="Paper") { ?>
		<strong><?=$current_type ?> Abstract</strong> ( 500 words max.)  <br/>
		This will appear on the conference program.<br/>
		<?php } else { ?>
			<strong><?=$current_type ?> Abstract</strong> ( 50 word max.)  <br/>
		This will appear on the conference program.<br/>
		
			<?php }  ?>
			
<?php			$_POST['abstract']= stripslashes($_POST['abstract']);?>
   		<textarea name="abstract" cols="75" rows="6"><?= $_POST['abstract'] ?></textarea>
       	<input type="hidden" id="abstractValidate" value="<?= $vItems['abstract'] ?>" />
       	<span id="abstractMsg"></span>
       	<br/>
    </td>
</tr>

	
	<tr>
	<td colspan="2">
	<?php

			//user is editing so no need to show the description
			if ($current_type == "Presentation") {
?>	<img id="descImg" src="/accounts/ajax/images/blank.gif" alt="valid indicator" width="16" height="16" />
		<strong>Presentation Description: </strong>( 150 word max.)	
		<br/>This description is used by the review committee for a more in-depth review of your proposal. <br/>
		<textarea name="desc" cols="75" rows="6" ><?= $_POST['desc']  ?></textarea>
		<input type="hidden" id="descValidate" value="<?= $vItems['desc'] ?>" />
		<span id="descMsg"></span>
	<?php } else if ($current_type=="Paper") { ?>
	<strong>Additional  Comments: </strong> ( 150 word max.)	
		<br/> <br/>
		<textarea name="desc" cols="75" rows="6" ><?= $_POST['desc']  ?></textarea>
	<?php }  ?>
	</td>
	</tr>


<?php if ($current_type == "Poster") { ?>
 	<tr>
	<td colspan="2">
		<img id="postersImg" alt="required" src="/accounts/ajax/images/blank.gif" width="16" height="16" /> <strong>How many posters will you present on this topic?</strong>
	<input type="text" name="posters" size="3" value="<?= $_POST['poster']  ?>" /> 
	<br/><br/><?= $_POSTER_REQS ?>
		<input type="hidden" id="postersValidate" value="<?= $vItems['posters'] ?>" />
		<span id="postersMsg"></span>
	</td>
	</tr>
 	
<?php } ?>

	
	<tr>
		<td class="account" colspan="2"  style="border-bottom:0;">
		<?php if ($current_type == "Paper")  {  ?>
				<div><strong>Author </strong>(and primary contact for this paper)</div>
				<?php } else  if ($current_type == "Poster")  { ?>
					<div><strong>Presenter </strong>(and primary contact for this proposal)</div>
					<?php }  else { ?>
							<div><strong>Speaker </strong>(and primary contact for this proposal)</div>
					<?php } ?>
			<table>
			<tr>
				<td class="account">
				<div><strong>First/Given Name:</strong><br/>
					<img id="auth1_firstImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
					<input type="text" name="auth1_first" value="<?= $_POST['auth1_first'] ?>" size="30" maxlength="50"/>
					<input type="hidden" id="auth1_firstValidate" value="<?= $vItems['auth1_first'] ?>" />
					<span id="auth1_firstMsg"></span></div>
				<div><br/><strong>Organization:</strong><br/>
					<img id="auth1_orgImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
					<input type="text" name="auth1_org" value="<?= $_POST['auth1_org'] ?>" size="30" maxlength="50"/>
					<input type="hidden" id="auth1_orgValidate" value="<?= $vItems['auth1_org'] ?>" />
					<span id="auth1_orgMsg"></span></div>
					
			
				</td>
			
				<td class="account">
				<div><strong>Last/Family name:</strong><br/>
					<img id="auth1_lastImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
					<input type="text" name="auth1_last" value="<?= $_POST['auth1_last'] ?>" size="30" maxlength="50"/>
					<input type="hidden" id="auth1_lastValidate" value="<?= $vItems['auth1_last'] ?>" />
					<span id="auth1_lastMsg"></span></div>
				<div><br/><strong>Email:</strong><br/>
					<img id="auth1_emailImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
					<input type="text" name="auth1_email" value="<?= $_POST['auth1_email'] ?>" size="40" maxlength="50"/>
					<input type="hidden" id="auth1_emailValidate" value="<?= $vItems['auth1_email'] ?>" />
					<span id="auth1_emailMsg"></span></div>
				</td>
			</tr>
		</table>
	</td>
	</tr> 
	<?php if (($current_type=="Paper") || ($current_type=="Presentation")) { ?> 
		<tr>
		<td class="account" colspan="2"  style="border-bottom:0;">
			<?php if ($current_type == "Paper")  {  ?>
				<div><strong>Co-Author </strong></div>
				<?php } else { ?>
					<div><strong>Co-Speaker </strong></div>
					<?php }  ?>
			<table>
			<tr>
				<td class="account">
				<div><strong>First/Given Name:</strong><br/>
					<input type="text" name="auth2_first" value="<?= $_POST['auth2_first'] ?>" size="30" maxlength="50"/>
				</div>
				<div><br/><strong>Organization:</strong><br/>
					<input type="text" name="auth2_org" value="<?= $_POST['auth2_org'] ?>" size="30" maxlength="50"/>
				</div>
					
			
				</td>
			
				<td class="account">
				<div><strong>Last/Family name:</strong><br/>
							<input type="text" name="auth2_last" value="<?= $_POST['auth2_last'] ?>" size="30" maxlength="50"/>
			</div>
			<div><br/><strong>Email:</strong><br/>
					<input type="text" name="auth2_email" value="<?= $_POST['auth2_email'] ?>" size="40" maxlength="50"/>
						<input type="hidden" id="auth2_emailValidate" value="<?= $vItems['auth2_email'] ?>" />
					<span id="auth2_emailMsg"></span></div>
			
				</td>
			</tr>
		</table>
	</td>
	</tr>
		
		<tr>
		<td class="account" colspan="2"  style="border-bottom:0;">
			<?php if ($current_type == "Paper")  {  ?>
				<div><strong>Co-Author </strong></div>
				<?php } else { ?>
					<div><strong>Co-Speaker </strong></div>
					<?php }  ?>
			<table>
			<tr>
				<td class="account">
				<div><strong>First/Given Name:</strong><br/>
					<input type="text" name="auth3_first" value="<?= $_POST['auth3_first'] ?>" size="30" maxlength="50"/>
				</div>
				<div><br/><strong>Organization:</strong><br/>
					<input type="text" name="auth3_org" value="<?= $_POST['auth3_org'] ?>" size="30" maxlength="50"/>
				</div>
					
			
				</td>
			
				<td class="account">
				<div><strong>Last/Family name:</strong><br/>
							<input type="text" name="auth3_last" value="<?= $_POST['auth3_last'] ?>" size="30" maxlength="50"/>
			</div>
			<div><br/><strong>Email:</strong><br/>
					<input type="text" name="auth3_email" value="<?= $_POST['auth3_email'] ?>" size="40" maxlength="50"/>
					<input type="hidden" id="auth3_emailValidate" value="<?= $vItems['auth3_email'] ?>" />
					<span id="auth3_emailMsg"></span></div>
				
				</td>
			</tr>
		</table>
	</td>
	</tr>
				
		<tr>
		<td class="account" colspan="2"  style="border-bottom:0;">
			<?php if ($current_type == "Paper")  {  ?>
				<div><strong>Co-Author </strong></div>
				<?php } else { ?>
					<div><strong>Co-Speaker </strong></div>
					<?php }  ?>
			<table>
			<tr>
				<td class="account">
				<div><strong>First/Given Name:</strong><br/>
					<input type="text" name="auth4_first" value="<?= $_POST['auth4_first'] ?>" size="30" maxlength="50"/>
				</div>
				<div><br/><strong>Organization:</strong><br/>
					<input type="text" name="auth4_org" value="<?= $_POST['auth4_org'] ?>" size="30" maxlength="50"/>
				</div>
					
			
				</td>
			
				<td class="account">
				<div><strong>Last/Family name:</strong><br/>
							<input type="text" name="auth4_last" value="<?= $_POST['auth4_last'] ?>" size="30" maxlength="50"/>
			</div>
			<div><br/><strong>Email:</strong><br/>
					<input type="text" name="auth4_email" value="<?= $_POST['auth4_email'] ?>" size="40" maxlength="50"/>
						<input type="hidden" id="auth4_emailValidate" value="<?= $vItems['auth4_email'] ?>" />
					<span id="auth4_emailMsg"></span></div>
			
				</td>
			</tr>
		</table>
	</td>
	</tr>
		
	
	<tr>
	   <td><?php if ($current_type=="Paper"){ ?> 
		<strong><br/>Use this space for additional Author(s)</strong><br/>(if any) 
		<?php } else if ($current_type=="Presentation"){ ?> 
		<strong><br/>Use this space for additional Speakers(s)</strong><br/>(if any) 
		<?php } ?>
		</td>
	   <td>  
	     (i.e.  John Doe, Jane Smith,  Mike Jones ).<br/>
	      <textarea name="author_other" cols="40" rows="4"><?= $_POST['author_other']  ?></textarea><br/>
	     </td>
	</tr>
	
	<?php }  ?>
<?php  
 if ($current_type == "Paper") {
		if ($_POST['paper_url']) {   ?>
<tr> 
      <td><strong>Your Paper</strong>
         </td>
      <td><strong>File Name: </strong><a href="<?=$PAPER_LOC?><?=$_POST['paper_url']?>"> <?=$_POST['paper_url']?><br/>   
      </td>
    </tr>	
<?php  } ?>
 <tr> 
      <td>	

<?php if (!$_POST['paper_url']) {  ?>	  <img id="userfileImg" src="/accounts/ajax/images/blank.gif" alt="valid indicator" width="16" height="16" />
	  <strong>Add a Paper </strong><br/>
	<?php } else { ?>
	<strong>Upload a different paper <br/></strong><br/>
	<?php }?>
	
	  </td>
      <td>
       <?php if (!$item['paper_url']) {  ?>
       	    	   <div>Only PDF (.pdf) and MSWORD (.doc) files are accepted. <strong> Max.= 2MB</strong>	</div>
       	    	   <input type="hidden" name="MAX_FILE_SIZE" value="2000000" /><input name="userfile" type="file" class="box" id="userfile" />
	   <input type="hidden" id="userfileValidate" value="<?= $vItems['userfile'] ?>" />
       	 	<span id="userfileMsg"></span>
       <?php }   else  { ?>
       	 (this will replace the current paper)<br/> 	
       <input type="hidden" name="MAX_FILE_SIZE" value="2000000" /><input name="update_userfile" type="file" class="box" id="update_userfile" />
       	 <?php } ?>
      </td>
    </tr>
    <?php }  ?>
<?php if ($current_type=="Presentation"){ ?>
	<tr>
	    <td colspan="2">
	    	<img id="bioImg" src="/accounts/ajax/images/blank.gif" alt="valid indicator" width="16" height="16" />
	    	<strong>Brief Text Bio</strong>
	    	<br/>
	      	(for primary presenter only - for online and print program. (50 word max.)<br/><br/>
	      	<textarea name="bio" cols="75" rows="4" ><?= $_POST['bio']  ?></textarea>
	     	<input type="hidden" id="bioValidate" value="<?= $vItems['bio'] ?>" />
	     	<span id="bioMsg"></span>
	    </td>
	</tr>

<?php }  ?>


	
<?php if ($current_type!="BOF") { ?>
	<tr>
	    <td><strong>Project/Organization <br/>web page </strong></td>
	    <td>use format:  http://www.example.com<br/><input type="text" name="URL" size="35" value="<?= $_POST['URL']  ?>" maxlength="100" /></td>
	</tr>
<?php  	} else {  ?>
	<tr>
	    <td><strong>BOF wiki page URL </strong></td>
	    <td>http://www.example.com<br/><input type="text" name="wiki_url" size="35" value="<?= $_POST['wiki_url']  ?>" maxlength="255" /></td>
	</tr>
<?php } ?>

<?php

						if ($current_type == "Presentation") {
							if (!$PK) { //user is editing so no need to show the rest of this info
?>
<tr>
   <td colspan="2">
     <div id="topicInfo">
		<div>
			<img id="topicImg" src="/accounts/ajax/images/blank.gif" alt="valid indicator" width="16" height="16" />
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
				</div>
				<div class="topic_type_header">TOPIC AREAS</div>
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
			     <span><input name="<?= $itemID ?>" type="radio" value="" <?php if (!$list_items['choice']) { echo "checked='checked' "; }?> />&nbsp;&nbsp;&nbsp;</span>
			     <span><input name="<?= $itemID ?>" type="radio" value="1" <?php if ($list_items['choice']=="1") { echo "checked='checked' "; }?> />&nbsp;&nbsp;&nbsp;</span>
			     <span><input name="<?= $itemID ?>" type="radio" value="2" <?php if ($list_items['choice']=="2") { echo "checked='checked' "; }?> />&nbsp;&nbsp;&nbsp;</span>
			     <span><input name="<?= $itemID ?>" type="radio" value="3" <?php if ($list_items['choice']=="3") { echo "checked='checked' "; }?> />&nbsp;&nbsp;&nbsp;&nbsp;</span>
			    </div>
				<div class="topic_type"><?= $list_items['topic_name'] ?></div>
			 </div>
	<?php } ?>
		</div> <!-- end topic -->
	</div> <!-- end topic info -->
  </td>
</tr>
<tr>
    <td colspan="2">
      <div id="audienceInfo">
		<div>
			<img id="audienceImg" src="/accounts/ajax/images/blank.gif" alt="valid indicator" width="16" height="16" />
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
				</div>
				<div class="topic_type_header">AUDIENCE</div>
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
			     <span><input name="<?= $itemID ?>" type="radio" value="" <?php if (!$list_items['choice']) { echo "checked='checked' "; }?> />&nbsp;&nbsp;&nbsp;</span>
			     <span><input name="<?= $itemID ?>" type="radio" value="1" <?php if ($list_items['choice']=="1") { echo "checked='checked' "; }?> />&nbsp;&nbsp;&nbsp;</span>
			     <span><input name="<?= $itemID ?>" type="radio" value="2" <?php if ($list_items['choice']=="2") { echo "checked='checked' "; }?> />&nbsp;&nbsp;&nbsp;</span>
			     <span><input name="<?= $itemID ?>" type="radio" value="3" <?php if ($list_items['choice']=="3") { echo "checked='checked' "; }?> />&nbsp;&nbsp;&nbsp;&nbsp;</span>
			    </div>
				<div class="topic_type"><?= $list_items['role_name'] ?></div>
			 </div>
	<?php } ?>
		</div> <!-- end audience -->
  	</div>   <!-- end audienceinfo-->
   </td>
 </tr>

<?php

		}
		if ($P_FORMAT) {
?>
 <tr>
    <td>
    	<img id="typeImg" src="/accounts/ajax/images/blank.gif" alt="valid indicator" width="16" height="16" />
    	<strong>Presentation Format</strong>
    </td>
    <td>
		<div class="small">see sidebar for <a href="#format_desc">format descriptions</a></div><br/>
          <input name="type" type="radio" value="discussion" <?php if ($_POST['type']=="discussion") { echo "checked='checked' "; } ?> /> Discussion <br/>
          <input name="type" type="radio" value="lecture" <?php if ($_POST['type']=="lecture") { echo "checked='checked' "; } ?> /> Lecture <br/>
          <input name="type" type="radio" value="panel" <?php if ($_POST['type']=="panel") { echo "checked='checked' "; } ?> /> Panel <br/>
          <input name="type" type="radio" value="workshop" <?php if ($_POST['type']=="workshop") { echo "checked='checked' "; } ?> /> Workshop (How-to) <br/>
	     <input name="type" type="radio" value="carousel" <?php if ($_POST['type']=="carousel") { echo "checked='checked' "; } ?> /> Tool Carousel (in-depth tool demo) <br/>
		<input type="hidden" id="typeValidate" value="<?= $vItems['type'] ?>" />
		<span id="typeMsg"></span>
   	 </td>
  </tr>
<?php

										}

										//add presentation format option
										if ($P_LAYOUT) {
?>
  <tr>
     <td>
     	<img id="layoutImg" src="/accounts/ajax/images/blank.gif"  alt="valid indicator" width="16" height="16" />
     	<strong>Room setup desired</strong>
     </td>
     <td>
		<div class="small">We will do our best to accomodate your request</div><br/>
          <input name="layout" type="radio" value="class" <?php if ($_POST['layout']=="class") { echo "checked='checked' "; } ?> /> <strong>classroom </strong>(rows of narrow tables w/chairs)<br/>
          <input name="layout" type="radio" value="theater" <?php if ($_POST['layout']=="theater") { echo "checked='checked' "; } ?> /> <strong>theater </strong>(rows of chairs only)<br/>
          <input name="layout" type="radio" value="conference" <?php if ($_POST['layout']=="conference") { echo "checked='checked' "; } ?> /> <strong>conference</strong> (roundtables or conference room setup)<br/>
		<input type="hidden" id="layoutValidate" value="<?= $vItems['layout'] ?>" />
		<span id="layoutMsg"></span>
     </td>
  </tr>

<?php

										}

										//add presentation length  
										if ($P_LENGTH) {
?>
  <tr>
     <td>
     	<img id="plengthImg" src="/accounts/ajax/images/blank.gif" alt="valid indicator" width="16" height="16" />
     	<strong>Presentation Length</strong>
     </td>
     <td>
		<div class="small">Times are not guaranteed. We will do our best to match each session with an appropriate time block</div><br/>
          <input name="plength" type="radio" value="40" <?php if ($_POST['plength']=="40") { echo "checked='checked' "; } ?> /> 40 minutes  <br/>
          <input name="plength" type="radio" value="90" <?php if ($_POST['plength']=="90") { echo "checked='checked' "; } ?> /> 90 minutes  <br/>
		<input type="hidden" id="plengthValidate" value="<?= $vItems['plength'] ?>" />
		<span id="plengthMsg"></span>
     </td>
  </tr>


<?php

										}
									
								}
?>
	<?php
 //add speaker availability
								if ($AVAILABLE) {
?>
  <tr>
     <td><strong>Availability</strong></td>
     <td><div class="small"> Please check the days that the presenter(s)<br/>CANNOT present due to a travel conflict</div>
        <br/> <strong> I am NOT available:</strong><br/>
		<?=$not_available ?> <br/>
     </td>
  </tr>
 
 

<?php  }  ?>
    <tr>
        <td colspan="2" style="border-bottom:0;">
        <blockquote style="width:60%">Click on <strong>SUBMIT</strong>
         to save and submit the paper or proposal. &nbsp;  Once sucessfully submitted, 
         a link to this proposal will appear in the left column.  
         You will then be able to click on the title of your proposal and edit it 
         if necessary.</blockquote></td>
     
      </tr>
        <tr>
        <td >&nbsp;</td>
        <td style="padding-top: 5px;">  
		<br/><br/>	<input id="submitbutton" type="submit" name="submit" value="SUBMIT" />
			<br/>
        </td>
      </tr>
    </table>
  </form>

</div>
<!-- end cfp -->

         <div class="padding50"></div> <!-- SPACER -->

</td></tr></table>
</div>
<?php

									include $ACCOUNTS_PATH . '/include/footer.php';
?>
