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
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
$AUTH_MESSAGE = "You must login to register or submit a proposal for the $CONF_NAME conference. If you do not have an account, please create one.";
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// bring in inst and conf data
require '../registration/include/getInstConf.php';

// get the passed message if there is one
if($_GET['msg']) {
	$Message .= "<br/>" . $_GET['msg'];
}

$PK = $_REQUEST["pk"]; // grab the pk
$type = $_REQUEST['type']; // grab the proposal type
if (!$type) { $type = "demo"; } // default type if not specified
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
	$result = mysql_query($check_sql) or die("check query failed ($check_sql): ".mysql_error());
	if (mysql_num_rows($result) > 0) {
		$row = mysql_fetch_assoc($result);
		if ( ($row['users_pk'] != $User->pk) && !$User->checkPerm("admin_conference")) {
			// this item is not owned by current user and current user is not an admin
			$error = true;
			$allowed = false;
			$Message = "You may not access someone else's conference proposal entry " .
				"unless you have the (admin_conference) permission.";
		} else {
			$allowed = true;
			// entry is owned by current user or they are an admin
			if ($_REQUEST["delete"]) {
				// if delete was passed then wipe out this item and related items
				$delete_sql = "delete from conf_proposals where pk='$PK'";
				$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): ".mysql_error());
		
				//now delete the audiences for this proposal
				$delete_sql = "delete from proposals_audiences where proposals_pk='$PK'";
				$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): ".mysql_error());
		
				//now delete the topic ranking for this proposal
				$delete_sql = "delete from proposals_topics where proposals_pk='$PK'";
				$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): ".mysql_error());
				// NOTE: Don't forget to handle the deletion below as needed
				$Message = 
					"<div style='border:2px solid darkgreen;padding:3px;background:lightgreen;font-weight:bold;'>" .
					"Deleted item ($PK) and related data</div>";
				$PK = 0; // clear the PK
				$allowed = false; // don't load the rest of the page
			}
		}
	} else {
		// PK does not match, invalid PK set to this page
		$error = true;
		$Message = "Invalid item PK ($PK): Item does not exist";
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

	if(mysql_num_rows($result) > 0) {
		// update the type
		$type = $item['type'];

		// refer to the item array by name $_POST (this might not be a good idea) -AZ
		foreach($item as $key=>$value) {
			$_POST[$key] = $value;
		}

		if ($type=="demo") {
			$Message = "<div style='text-align: left; padding: 5px; background: #ffcc33; color:#000;'><strong>Editing Technical Demo: </strong>" 
			. $_POST['title'] . "<br/><strong>Submitted by: </strong>".	 $item['firstname'] ." " . $item['lastname']."</div><div><br/></div>";
		} else {
			$Message = "<div style='text-align: left; padding: 5px; background: #ffcc33; color:#000;'><strong>Editing Presentation: </strong>"  
			. $_POST['title'] . "<br/><strong>Submitted by: </strong>".	 $item['firstname'] ." " . $item['lastname'] ."</div><div><br/></div>";
		}

		// get the dates when a presenter cannot be available
		$conflict=$_POST['conflict'];
		if (preg_match("/Tue/", $conflict)) { $_POST['conflict_tue']="Tue";  }
		if (preg_match("/Wed/", $conflict)) { $_POST['conflict_wed']="Wed";}
		if (preg_match("/Thu/", $conflict)) { $_POST['conflict_thu']="Thu"; }
		if (preg_match("/Fri/", $conflict)) { $_POST['conflict_fri']="Fri"; }
	} else {
		$Message = "ERROR: Could not get information for: $PK";
	}
}


 
// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['title'] = "required";
$vItems['abstract'] = "required";
$vItems['desc'] = "required";
$vItems['speaker'] = "required";
$vItems['bio'] = "required";
$vItems['type'] = "required";
$vItems['layout'] = "required";
$vItems['length'] = "required";


//echo "<pre>",print_r($_POST),"</pre>";

if ($_POST['save']) { 
// DO SERVER SIDE VALIDATION
	$errors = 0;
	$validationOutput = ServerValidate($vItems, "return");
	if ($validationOutput) {
		$errors++;
		$Message = "<fieldset><legend>Validation Errors</legend>".
			"<b style='color:red;'>Please fix the following errors:</b><br/>".
			$validationOutput."</fieldset>";
	}

	if ($errors == 0) {
	// saving the form

		$title=mysql_real_escape_string($_POST['title']);
		$abstract=mysql_real_escape_string($_POST['abstract']);
		$desc=mysql_real_escape_string($_POST['desc']);
		$speaker=mysql_real_escape_string($_POST['speaker']);
		$bio=mysql_real_escape_string($_POST['bio']);
		$co_speaker=mysql_real_escape_string($_POST['co_speaker']);
		$co_bio=mysql_real_escape_string($_POST['co_bio']);
		$url=$_POST['URL'];
		$PK=$_POST['editPK'];
		
		$type=$_POST['type'];
		$layout=$_POST['layout'];
		// NOTE: You cannot use length as an identifier, it is a reserved word in AJAX -AZ
		$length=$_POST['Length'];
		$conflict = trim($_POST['conflict_tue'] ." ". $_POST['conflict_wed'] ." ". $_POST['conflict_thu'] ." ". $_POST['conflict_fri']);
		
		
		if ($PK)  {  //this proposal has been edited
			// update proposal information  --all data except role and topic data
			$proposal_sql="UPDATE conf_proposals" .
					" set  `type`='$type', `title`='$title' , `abstract`='$abstract', `desc`='$desc' ," .
						" `speaker`='$speaker' , `URL` ='$url', `bio`='$bio' , `layout`='$layout', " .
						"`length`='$length' , `conflict`='$conflict' ," .
						" `co_speaker`='$co_speaker' , `co_bio`='$co_bio' where pk= '$PK'   ";
						
			$result = mysql_query($proposal_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
				"registration form submission. Please try to submit the registration again. " .
				"If you continue to have problems, please report the problem to the " .
				"<a href='mailto:$HELP_EMAIL'>sakaiproject.org webmaster</a>." );
				
			//TODO
			//How do you update the topics and audiences without having duplicate entries in the 
			//propsals_audiences tables
					
		} else {  //this is a new  proposal so add this to the conf_proposals table
		
			//first add presentation information into --all data except role and topic data
			$proposal_sql="INSERT INTO `conf_proposals` ( `date_created` , `confID` , `users_pk` , `type`, " .
					"`title` , `abstract` , `desc` , `speaker` , `URL` , `bio` , `layout` , `length` ," .
					" `conflict` , `co_speaker` , `co_bio` , `approved` )
				VALUES ( NOW() , '$CONF_ID', '$User->pk', '$type', '$title', '$abstract', " .
				"'$desc', '$speaker', '$url', '$bio' , '$layout' , '$length', '$conflict' ," .
				" '$co_speaker' , '$co_bio' , 'N' )";
			
			$result = mysql_query($proposal_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
				"registration form submission. Please try to submit the registration again. " .
				"If you continue to have problems, please report the problem to the " .
				"<a href='mailto:$HELP_EMAIL'>sakaiproject.org webmaster</a>." );
				
			$proposal_pk=mysql_insert_id(); //get this proposal_pk
			
			if ($type="demo") {  // send the user an email confirmation for this demo
				$email_sql="Select * from `conf_proposals` WHERE pk='$proposal_pk' ";
				$email_result= mysql_query($email_sql);
				while($demo=mysql_fetch_array($email_result)) {	
				$title=$demo["title"];
				$abstract=$demo["abstract"];
				$speaker=$demo["speaker"];
				$url=$demo["URL"];
				}
				 //send confirmation email message
				//require ('../include/send_demoEmail.php');
				
			} 
			 else {  //this is a presentation proposal so we need to add topics and proposal info 
							
				//get audience information for the proposal_audiences table
				$audience_sql="select pk,role_name from roles order by role_order";
				$result = mysql_query($audience_sql) or die(mysql_error());
				
				 while($audience_items=mysql_fetch_array($result)) {
				 $audience_pk=$audience_items['pk'];
			     $audienceID="audience_" .$audience_pk;
				
			 	if ($_POST[$audienceID] > 0){ // - only get $audience_items with values above 0
					$audience_choice=$_POST[$audienceID];
					$insert_audience_sql="INSERT INTO `proposals_audiences` ( `pk` , `date_created` ,  `proposals_pk` , `roles_pk` , `choice` )
						VALUES ('', NOW(), '$proposals_pk', '$audience_pk', '$audience_choice')";
					$audience_result = mysql_query($insert_audience_sql) or die("Error:<br/>" . mysql_error() . "problem entering role" );
					}
			 }
					
			//get topic information for the proposal_topics table
			$topic_sql="select pk, topic_name from topics order by topic_order";
			$result = mysql_query($topic_sql) or die(mysql_error());
				
			while($topic_items=mysql_fetch_array($result)) {
			$topic_pk=$topic_items['pk'];
			$topicID="topic_" . $topic_pk;
			
			 if ($_POST[$topicID] > 0) { // - only get topics with values greater than 0
				$topic_choice=$_POST[$topicID];
				$insert_topic_sql="INSERT INTO `proposals_topics` ( `pk` , `date_created` , `proposals_pk` , `topics_pk` , `choice` )
				VALUES('', NOW(),  '$proposals_pk', '$topic_pk', '$topic_choice') " ;				
				$topic_result = mysql_query($insert_topic_sql) or die("Error:<br/>" . mysql_error() . "problem entering topic" );
				}
			}
			//TODO
			//test confirmation email message against recent changes
			//require ('../include/send_proposalEmail.php'); 
		  }
		}  // finished handling new proposal submission
		header("Location:index2.php");
	}
}
?>

<!-- // INCLUDE THE HTML HEAD -->
<?php include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<!-- // INCLUDE THE HEADER -->
<?php include '../include/header.php'; ?>

<table width="100%"  cellpadding="0" cellspacing="0">
 <tr>
    <td><div class="componentheading">Call for Proposals</div></td>
  </tr>
  <tr>
	  <td height="25" bgcolor="#ffffff" style=" border-top: 5px solid #FFFFFF;">
	 <?php if ($Message) {  echo $Message;  }
	 else {  ?>
    <span class="pathway">
	 	<img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />Start &nbsp; &nbsp; &nbsp;
	  		<img src="../include/images/arrow.png" height="12" width="12" alt="arrow" /><span class="activestep">Proposal Details &nbsp; &nbsp; &nbsp;</span> 
	  		<img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />Contact Information&nbsp; &nbsp; &nbsp; 
	  		<img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />Confirmation  		
	  	</span>
	 <?php }	?>
	   </td>
  </tr>
</table>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		echo "<a href='index.php'>Back to Proposals</a>";
		include $ACCOUNTS_PATH.'include/footer.php';
		exit;
	}
?>

<div id="cfp">
  <form name="form1" id="form1" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
   <input type="hidden" name="save" value="1" />
   <input type="hidden" name="pk" value="<?= $PK ?>" />
   <input type="hidden" name="type" value="<?= $type ?>" />


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
					Technology Demos will take place on Thursday, June 1st. 
					[<a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=173&amp;Itemid=523" target=blank>more information</a>]
				</div>
    </td>
</tr>

<?php } else { ?>

<tr>
    <td colspan=2>
    		<div><strong> Proposal for Conference Presentation </strong></div>
         <div>Select the most appropriate Presentation Topic Areas, Intend Audiences, and Format for your presentation from the options provided below.
         	 Please note that these classifications and titles will be used by the program commitee for the proposal review and conference
          	planning process, and may not be the classifications or titles used for the final conference program. 
         </div>
    </td>
</tr>
<?php } ?>

<tr>
	<td valign="top" colspan="2" style="padding:0px;"><div id="requiredMessage"></div>
	</td>
</tr>

<tr>
 	<td>
<?php if ($type == "demo") { ?>
 	    <img id="titleImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
 	    <strong>Product or Tool Name</strong>
<?php } else  { ?>
 		<img id="titleImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
 		<strong>Presentation Title</strong>
<?php } ?>
  	</td>
   	<td><input type="text" name="title" size="40" maxlength="75" value="<?= $_POST['title'] ?>" /> <br/>(75 max chars)
    	 <input type="hidden" id="titleValidate" value="<?= $vItems['title'] ?>" /><span id="titleMsg"></span>
   	</td>
 </tr>

 <tr>
    <td colspan=2><img id="abstractImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
<?php if ($type == "demo") {?>
		<strong>Demo  Description </strong> ( 50 word max.)  <br/>
		This will appear on the conference program.
<?php } else { ?>
    	<strong>Presentation Summary </strong> ( 50 word max.)  <br/>
    	This summary will appear on the conference program.
<?php } ?>
   		<br/><textarea name="abstract" cols="75" rows="6"><?= $_POST['abstract'] ?></textarea>
       	<input type="hidden" id="abstractValidate" value="<?= $vItems['abstract'] ?>" /><span id="abstract"></span> <br/>
    </td>
</tr>

<?php if ($type!="demo") {?> 
<tr>
   <td colspan=2><img id="descImg" src="/accounts/ajax/images/required.gif" width="16" height="16" /> <strong>Presentation Description: </strong>( 150 word max.)
     <br/>This description is used by the program committee for a more in-depth review of your session. <br/>
   	 <textarea name="desc" cols="75" rows="6" ><?= $_POST['desc']  ?></textarea>
   	 <input type="hidden" id="descValidate" value="<?= $vItems['desc'] ?>" /><span id="desc"></span>
    </td>
  </tr>
<?php } ?>

<tr>
    <td nowrap="y">
    	<img id="speakerImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
    	<strong>Presenter's name</strong>
    </td>
    <td>(lead presenter and main contact for this proposal)<br/>
    		<input type="text" name="speaker" size="40" value="<?= $_POST['speaker']  ?>" maxlength="100"/>
    		 <input type="hidden" id="speakerValidate" value="<?= $vItems['speaker'] ?>" /><span id="speaker"></span>
    </td>
</tr>

<?php if ($type!="demo") {?>
<tr>
    <td colspan=2>
    	<img id="bioImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
    	<strong>Brief Text Bio</strong>
    	<br/>
      	(for primary presenter only - for online and print program. (50 word max.)<br/><br/>
      	<textarea name="bio" cols="75" rows="4" ><?= $_POST['bio']  ?></textarea>
     	<input type="hidden" id="bioValidate" value="<?= $vItems['bio'] ?>" /><span id="bio"></span>
    </td>
</tr>
<?php } ?>

<tr>
   <td><strong><br/>Co-Presenters</strong><br/>(if any)</td>
   <td>  
      <div id="co_presenters">  List the names of your co-presenters, one name per line. 
       <textarea name="co_speaker" cols="60" rows="4"><?= $_POST['co_speaker']  ?></textarea><br/>
     </div>
   </td>
</tr>

<tr>
    <td><strong>Project URL </strong></td>
    <td>http://www.example.com<br/><input type="text" name="URL" size="35" value="<?= $_POST['URL']  ?>" maxlength="100" /></td>
</tr>

<?php if ($type!="demo") { ?>
<tr>
   <td colspan=2>
     <div id="topicInfo">
		<div>
			<img id="topicImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
    		<strong>Topic Areas </strong>
    		<input type="hidden" id="topicValidate" value="<?= $vItems['topic'] ?>" />
    		<span id="topic"></span>
     	</div>
     	<div>Although in the last Call for Proposals (for the 4th Sakai conference in Austin) presenters were asked to categorize their proposal 
	          within one of five tracks, for the Vancouver conference, presenters are being asked to rank the relevance of their proposal to a list of
	          topic areas. Once the deadline for submitting proposals has passed, the Vancouver Program Committee will review all the proposals and see 
	          which topic areas have emerged as most relevant for the Sakai community.  Those topic areas will become the tracks for the 5th Sakai 
	          conference (part of Community Source Week) in Vancouver.<br/><br/>Rank <strong>at least one</strong> of the topics below on their
	          relationship to your proposed presentation. <br/><br/>
	     </div>

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
		
		while($list_items=mysql_fetch_array($result)) {
			$itemID = "topic_" . $list_items['pk'];
?>
		<div class="list_row">
			<div class="topic_vote">
		     <span><input name="<?= $itemID ?>" type="radio" value="" <?php if (!$list_items['choice']) { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;</span>
		     <span><input name="<?= $itemID ?>" type="radio" value="1" <?php if ($list_items['choice']=="1") { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;</span>
		     <span><input name="<?= $itemID ?>" type="radio" value="2" <?php if ($list_items['choice']=="2") { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;</span>
		     <span><input name="<?= $itemID ?>" type="radio" value="3" <?php if ($list_items['choice']=="3") { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;&nbsp;</span>
		    </div>
			<div class="topic_type"><?= $list_items['topic_name'] ?></div>
		 </div>
<?php } /* demo */ ?>
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
			<span id="audience"></span>
	    </div>
        <div> Please indicate your intended audience by selecting an interest level <strong>for at least one </strong>of the audience groups listed below. 
           For example, a session on your campus implementation might be of high interest to Implementors and of medium 
           interest to Senior Administration, etc. <br/><br/>
        </div>

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
		
		while($list_items=mysql_fetch_array($result)) {
			$itemID = "audience_" . $list_items['pk'];
?>
		<div class="list_row">
			<div class="topic_vote">
		     <span><input name="<?= $itemID ?>" type="radio" value="" <?php if (!$list_items['choice']) { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;</span>
		     <span><input name="<?= $itemID ?>" type="radio" value="1" <?php if ($list_items['choice']=="1") { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;</span>
		     <span><input name="<?= $itemID ?>" type="radio" value="2" <?php if ($list_items['choice']=="2") { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;</span>
		     <span><input name="<?= $itemID ?>" type="radio" value="3" <?php if ($list_items['choice']=="3") { echo "checked"; }?> />&nbsp;&nbsp;&nbsp;&nbsp;</span>
		    </div>
			<div class="topic_type"><?= $list_items['role_name'] ?></div>
		 </div>
<?php } ?>
  	</div>   <!-- end audienceinfo-->
   </td>
 </tr>

 <tr>
    <td>
    	<img id="typeImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" />
    	<strong> Presentation Format</strong>
    </td>
    <td>
		<div class=small>see sidebar for <a href="#getformat">format descriptions</a></div><br/>
          <input name="type" type="radio" value="discussion" <?php if ($_POST['type']=="discussion") { echo "checked"; } ?> /> Discussion <br/>
          <input name="type" type="radio" value="lecture" <?php if ($_POST['type']=="lecture") { echo "checked"; } ?> /> Lecture <br/>
          <input name="type" type="radio" value="panel" <?php if ($_POST['type']=="panel") { echo "checked"; } ?> /> Panel <br/>
          <input name="type" type="radio" value="workshop" <?php if ($_POST['type']=="workshop") { echo "checked"; } ?> /> Workshop (How-to) <br/>
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
     	<img id="LengthImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" />
     	<strong>Presentation Length</strong>
     </td>
     <td>
		<div class="small">Times are not guaranteed. We will do our best to match each session with an appropriate time block</div><br/>
          <input name="Length" type="radio" value="30" <?php if ($_POST['length']=="30") { echo "checked"; } ?> /> 30 minutes  <br/>
          <input name="Length" type="radio" value="60" <?php if ($_POST['length']=="60") { echo "checked"; } ?> /> 60 minutes  <br/>
          <input name="Length" type="radio" value="90" <?php if ($_POST['length']=="90") { echo "checked"; } ?> /> 90 minutes  <br/>
          <input name="Length" type="radio" value="120" <?php if ($_POST['length']=="120") { echo "checked"; } ?> /> 120 minutes  <br/>
		<input type="hidden" id="LengthValidate" value="<?= $vItems['length'] ?>" />
		<span id="LengthMsg"></span>
     </td>
  </tr>

  <tr>
     <td><strong>Availability</strong></td>
     <td><div class=small> Please check the days that the presenter(s)<br/>CANNOT present due to a travel conflict</div>
        <br/> <strong> I am NOT available:</strong><br/>
          <input name="conflict_tue" type="checkbox" value="Tue" <?php if ($_POST['conflict_tue']=="Tue") { echo "checked"; } ?> /> Tuesday, May 30 <br/>
          <input name="conflict_wed" type="checkbox" value="Wed" <?php if ($_POST['conflict_wed']=="Wed")  { echo "checked"; } ?> /> Wednesday, May 31 <br/>
          <input name="conflict_thu" type="checkbox" value="Thu" <?php if ($_POST['conflict_thu']=="Thu")  { echo "checked"; } ?> /> Thursday, May 1 <br/>
          <input name="conflict_fri" type="checkbox" value="Fri" <?php if ($_POST['conflict_fri']=="Fri") { echo "checked"; } ?> /> Friday, May 2 <br/>
        <br/>
     </td>
  </tr>
<?php 	} ?>
    <tr>
        <td >&nbsp;</td>
        <td style="padding-top: 5px;">
			<input id="submitbutton" type="submit" name="submit" value="Save Proposal" />
			<br/>
        </td>
      </tr>
    </table>
  </form>

</div>
<!-- end cfp -->
</div>
<!-- end  content_main  -->
</div>
<!-- end container-inner -->
</div>
<!--end of outer left -->
<!-- start outerright -->
<div id=outerright>
  <!-- start of rightcol_top -->
  <!-- end of rightcol_top-->
  <!--end rightcol -->
  <div id=rightcol>

<?php 
	$sql = "select CP.title, CP.pk from conf_proposals CP " .
		"where CP.users_pk='$User->pk' and CP.confID = '$CONF_ID'";
	//print "SQL=$sql<br/>";
	$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());

	if(mysql_num_rows($result) > 0) {
		// print the nice header
?>
	<div style="padding:3px; margin:0px;border:2px solid black;background:white;">
		<div class="componentheading"><strong>Your&nbsp;Proposals:</strong></div>
<?php
	while($item=mysql_fetch_assoc($result)) {
?>
	<li><a href="edit_proposal.php?pk=<?= $item['pk'] ?>&amp;edit=1" title="Edit this proposal" ><?=  $item['title'] ?></a>
		[<a style="color:red;" href="edit_proposal.php?pk=<?= $item['pk'] ?>&amp;delete=1" 
			title="Delete this proposal"
			onClick="return confirm('Are you sure you want to delete this proposal?');" >X</a>]
	</li>
<?php
		} // end while
		echo "<li>[ <a title='Create a new proposal' href='index.php'>new proposal</a> ]</li>";
		echo "</div>";
	} // end if
?>
	<br/>
    <div id="getformat" class="componentheading">Presentation Formats</div>
    <div class="contentheading"> Discussion </div>
    <div class="contentpaneopen"> This type of session involves a very brief presentation of a topic and immediately opens for discussion of the topic by attendees.</div>
    <div class="contentheading"> Lecture </div>
    <div class="contentpaneopen">This type of session consists mostly of presenting information to the attendees. Sufficient time for follow-up questions must be included. </div>
    <div class="contentheading"> Panel </div>
    <div class="contentpaneopen">This type of session typically brings together panelists from diverse background to address a topic from multiple points of view.</div>
    <div class="contentheading"> Workshop (How-to) </div>
    <div class="contentpaneopen"> This type of session is highly interactive, relaying skills as well as information to attendees.</div>
    <div class="contentheading"> Showcase/Poster </div>
    <div class="contentpaneopen"> Please note that we will <strong>not</strong> be soliciting proposals for Showcase/Poster sessions using this call for proposals form. We do, however, encourage you to create a poster that showcases your campus implementation or toolset. You can use the template we will provide (sometime in March) or use your own design. We will provide more details in March. </div>
  </div>

  <!--end rightcol -->
</div>
<!-- end outerright -->

</div><!-- end containerbg -->

<?php include '../include/footer.php'; // Include the FOOTER ?>