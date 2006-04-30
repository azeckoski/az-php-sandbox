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

$PK = $_REQUEST["pk"]; // grab the pk
$edit = $_REQUEST["edit"]; // grab the edit status
$type = $_REQUEST["type"]; // grab the proposal type

//echo $type;
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

$error = false; // preset the error flag to no errors
$allowed = false; // assume user is NOT allowed unless otherwise shown

// this allows us to use this page as an edit for admins or
// to add/edit/delete for normal users (don't forget to handle the errors flag)
// NOTE: make sure the permission check below is looking for the right permission

// to add/edit/delete for normal users don't forget to handle the errors 

// NOTE: make sure the permission check below is looking for the right permission

if (!$PK) {
	// no PK set so we must be adding a new item
	$Message = "";
}
 else { 
	// pk is set, see if it is valid for this user
	$check_sql = "select pk, users_pk from conf_proposals where pk='$PK'";
	$result = mysql_query($check_sql) or die("check query failed($check_sql): ".mysql_error());
	if (mysql_num_rows($result) > 0) {
		$row = mysql_fetch_assoc($result);
		if ( ($row['users_pk'] != $User->pk) && !$User->checkPerm("admin_conference")) {
			// this item is not owned by current user and current user is not an admin
			$error = true;
			$Message = "You may not access someone else's conference proposal entry " .
				"unless you have the (admin_conference) permission.";
		} else if ($_REQUEST["delete"]) {
	 
	// entry is owned by current user or they are an admin
	
		// if delete was passed then wipe out this item and related items
		$delete_sql = "delete from conf_proposals where pk='$PK'";
		$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): ".mysql_error());
         
         //now delete the topic ranking for this proposal
		$delete_sql = "delete from proposals_audiences where proposals_pk='$PK'";
		$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): ".mysql_error());
		
		//now delete the topic ranking for this proposal
		$delete_sql = "delete from proposals_topics where proposals_pk='$PK'";
		$result = mysql_query($delete_sql) or die("delete query failed ($delete_sql): ".mysql_error());
		// NOTE: Don't forget to handle the deletion below as needed
		$Message = "Deleted item ($PK) and related data";
	} 

	else if ($_REQUEST["edit"]) {  //user is reviewing this proposal and may make edit 
			
			// First get the requested proposal for this  users for the current conf 
			// (maybe limit this using a search later on)
			
			$filter_edits_sql = " and CP.pk=$PK "; //the pk of the proposal requested by user
			
			//$filter_users_sql = "and CP.users_pk='$User->pk' ";
			
			$sql = "select U1.firstname, U1.lastname, U1.email, U1.institution, " .
				"U1.firstname||' '||U1.lastname as fullname,  " .
				"CP.* from conf_proposals CP left join users U1 on U1.pk = CP.users_pk " .
				"where CP.confID = '$CONF_ID' "  . 
				$filter_users_sql . $filter_edits_sql . $sqlsorting . $mysql_limit;
			
				//print "SQL=$sql<br/>";
			$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
			$items = array();	
			
			// put all of the query results into an array first
			while($row=mysql_fetch_assoc($result)) { $items[$row['pk']] = $row; }
				//	echo "<pre>",print_r($items),"</pre><br/>";
	
			
			// add in the audiences rankings
			$sql = "select PA.pk, PA.proposals_pk, R.role_name, R.pk,  PA.choice from proposals_audiences PA " .
				"join conf_proposals CP on CP.pk = PA.proposals_pk and confID='$CONF_ID' " .
				"join roles R on R.pk = PA.roles_pk where PA.proposals_pk=$PK order by R.pk asc";
			
			$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
			$audience_items = array();
			while($row=mysql_fetch_assoc($result)) {
				$audience_items[$row['proposals_pk']][$row['pk']] = $row;
				}
				//	echo "audience:<pre>",print_r($audience_items),"</pre><br/>";
					
			// add in the topics rankings
			$sql = "select PT.pk, PT.proposals_pk, T.topic_name, T.pk, PT.choice from proposals_topics PT " .
			"join conf_proposals CP on CP.pk = PT.proposals_pk and confID='$CONF_ID' " .
			" join topics T on T.pk = PT.topics_pk where PT.proposals_pk=$PK order by T.pk asc";
			$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
			$topics_items = array();
			while($row=mysql_fetch_assoc($result)) {
				$topics_items[$row['proposals_pk']][$row['pk']] = $row;
			
			
			}
				//echo "<pre>",print_r($topics_items),"</pre><br/>";
			
				foreach ($items as $item) {
			// these add an array to each proposal item which contains the relevant topics/audiences
			$items[$item['pk']]['audiences'] = $audience_items[$item['pk']];
			$items[$item['pk']]['topics'] = $topics_items[$item['pk']];
			
			//echo "<pre>",print_r($items[$item['pk']]['audiences'] ),"</pre><br/>";
			//echo "<pre>",print_r($items[$item['pk']]['topics'] ),"</pre><br/>";
		
			}
				
		
			foreach ($items as $_POST) {
			 // set $items to $_POST for form processing
			 $_POST[$item['pk']]=$items[$item['pk']];
			 }
			 
			if ($type=="demo"){
			  $Message = "<div style='text-align: left; padding: 5px; background: #ffcc33; color:#000;'><strong>Editing Technical Demo: </strong>" 
			   . $_POST['title'] . "<br/><strong>Submitted by: </strong>".	 $item['firstname'] ." " . $item['lastname']."</div><div><br/></div>";
			 }
			 else { 
			 $Message = "<div style='text-align: left; padding: 5px; background: #ffcc33; color:#000;'><strong>Editing Presentation: </strong>"  
			 . $_POST['title'] . "<br/><strong>Submitted by: </strong>".	 $item['firstname'] ." " . $item['lastname'] ."</div><div><br/></div>";
			 }

			 
		// get the dates when a presenter cannot be available
		$conflict=$_POST['conflict'];
		if (preg_match("/Tue/", $conflict)) {	$_POST['conflict_tue']="Tue";  }
		if (preg_match("/Wed/", $conflict)) { $_POST['conflict_wed']="Wed";}
		if (preg_match("/Thu/", $conflict)) {	$_POST['conflict_thu']="Thu"; }
		if (preg_match("/Fri/", $conflict)) {	$_POST['conflict_fri']="Fri"; }
		
	   } else {
		// PK does not match, invalid PK set to this page
		$error = true;
		$Message = "Invalid item proposal number: Item does not exist";
	}
 }
 }
	 //end edit info
 
 
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
	//get topic results
	
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
		$track=$_POST['track'];
		$url=$_POST['URL'];
		$PK=$_POST['editPK'];
		
		$type=$_POST['type'];
		$layout=$_POST['layout'];
		$length=$_POST['length'];
		$conflict = trim($_POST['conflict_tue'] ." ". $_POST['conflict_wed'] ." ". $_POST['conflict_thu'] ." ". $_POST['conflict_fri']);
		$approved=$_POST['approved'];
		if ($PK)  {  //this proposal has been edited
			  // update proposal information  --all data except role and topic data
			$proposal_sql="UPDATE conf_proposals" .
					" set  `type`='$type', `title`='$title' , `abstract`='$abstract', `desc`='$desc' ," .
						" `speaker`='$speaker' , `URL` ='$url', `bio`='$bio' , `layout`='$layout', " .
						"`length`='$length' , `conflict`='$conflict' ," .
						" `co_speaker`='$co_speaker' , `co_bio`='$co_bio', `approved`='$approved', `track`='$track'  where pk= '$PK'   ";
						
			$result = mysql_query($proposal_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
				"registration form submission. Please try to submit the registration again. " .
				"If you continue to have problems, please report the problem to the " .
				"<a href='mailto:$HELP_EMAIL'>sakaiproject.org webmaster</a>." );
	
			
		
		}  // finished handling proposal edits

	//return to previous anchor row
	header("Location:proposals_results.php#anchor$PK");
	
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

<div id="cfp">
  <form name="form1" id="form1" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
   <input type="hidden" name="save" value="1" />
   <input type="hidden" name="new" value="<?php $_POST['new']?>" />
   	<table width="100%"  cellpadding="0" cellspacing="0">
   
<tr>
	<td valign="top" colspan="2" style="padding:0px;">
		<div id="requiredMessage"></div>
	</td>
</tr>
  <?php if ($type!="demo") { ?>
<tr>
    <td colspan=2>
    		<div><strong> Proposal for Conference Presentation </strong></div>
         <div>Select the most appropriate Presentation Topic Areas, Intend Audiences, and Format for your presentation from the options provided below.
         	 Please note that these classifications and titles will be used by the program commitee for the proposal review and conference
          	planning process, and may not be the classifications or titles used for the final conference program. 
         </div>
    </td>
</tr><?php } ?>
<tr>
	<td valign="top" colspan="2" style="padding:0px;"><div id="requiredMessage"></div>
	</td>
</tr>
<tr>
 	<td> <?php if ($type!="demo") { ?>
 		<img id="titleImg" src="/accounts/ajax/images/required.gif" width="16" height="16" /><strong>Presentation Title</strong><br/>
 	    <?php } else  { ?>
 	    	<img id="titleImg" src="/accounts/ajax/images/required.gif" width="16" height="16" /><strong>Product or Tool Name</strong><br/>
 	    	<?php } ?>
  	</td>
   	<td><input type="text" name="title" size="40" maxlength="75" value="<?= $_POST['title'] ?>" /> <br/>(75 max chars)
    	 <input type="hidden" id="titleValidate" value="<?= $vItems['title'] ?>" /><span id="titleMsg"></span>
   	</td>
 </tr>
 <?php if ($type!="demo") { ?>
 <tr>
	<td colspan=2><strong>Select/change track for this proposal:  </strong> 
	
		<select name="track" title="conference tracks">
			<option value="<?= $_POST['track'] ?>" selected><?= $_POST['track'] ?></option>
			<option value="Community">Community</option>
			<option value="Faculty">Faculty</option>
			<option value="Implementors">Implementation</option>
			<option value="Technology">Technology</option>
			<option value="Technology">Mixed Audiences</option>
			<option value="Tool Overview">Tool Overview</option>
			
		</select>
		</td>

 </tr> 
 <tr>
	<td><strong>Proposal Status: </strong> </td>
	<td><input name="type" type="radio" value="approved" <?php if ($_POST['approved']=="Y") { echo "checked"; } ?> /> Approved &nbsp;&nbsp;&nbsp;&nbsp;
			<input name="type" type="radio" value="approved" <?php if ($_POST['approved']=="N") { echo "checked"; } ?> /> Not Approved <br/>
		
		
		</td>

 </tr>
 <?php } ?>
 
 <tr>
    <td colspan=2><img id="abstractImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
    		<?php if ($type1!="demo") {?> 
    		<strong>Presentation Summary </strong> ( 50 word max.)  <br/> This summary will appear on the conference program. <br/>
    		<?php } else { ?>
    			<strong>Demo  Description </strong> ( 50 word max.)  <br/> This  will appear on the conference program. <br/>
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
  </tr><?php } ?>
<tr>
    <td><img id="speakerImg" src="/accounts/ajax/images/required.gif" width="16" height="16" /><strong>Presenter's name* </strong></td>
    <td>(lead presenter and main contact for this proposal)<br/>
    		<input type="text" name="speaker" size="40" value="<?= $_POST['speaker']  ?>" maxlength="100"/>
    		 <input type="hidden" id="speakerValidate" value="<?= $vItems['speaker'] ?>" /><span id="speaker"></span>
    </td>
</tr>

<?php if ($type!="demo") {?>
<tr>
    <td colspan=2><img id="bioImg" src="/accounts/ajax/images/required.gif" width="16" height="16" /><strong>Brief Text Bio* </strong><br/>
      	(for primary presenter only - for online and print program. (50 word max.)<br/><br/>
      	<textarea name="bio" cols="75" rows="4" ><?= $_POST['bio']  ?></textarea>
     	<input type="hidden" id="bioValidate" value="<?= $vItems['bio'] ?>" /><span id="bio"></span>
    </td>
</tr>	<?php } ?>

<tr>
   <td><strong><br/>Co-Presenters</strong><br/>(if any)</td>
   <td>  
      <div id="co_presenters">  List the names of your co-presenters, one name per line. 
       <textarea name="co_speaker" cols="60" rows="4"><?= $_POST['co_speaker']  ?></textarea><br/>
     </div>
   </td>
</tr>
<!--
<tr>
   <td colspan=2><strong>Co-Presenter bio(s)</strong><br/>Short bios for other presenters (200 word max.)</span><br/><br/><textarea name="co_bio" cols="75" rows="4"><?= $_POST['co_bio']  ?></textarea>
   </td>
</tr>
-->
<tr>
    <td><strong>Project URL </strong></td>
    <td>http://www.example.com<br/><input type="text" name="URL" size="35" value="<?= $_POST['URL']  ?>" maxlength="100" /></td>
</tr>     
		 <?php           
		 if ($type!="demo") {
		 //populate form with topic information

		 //TODO:
		 // bring the topics and audiences code back in - not worried about not using it
		 // when editing the proposals at this date - it does not affec the ability to add
		 // this file is only used when editing   

		?>
 
  
 <tr>
    <td nowrap='y'>
		<img id="typeImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
    	<strong>Presentation Format</strong>
    </td>
    <td>
		<div class=small>see sidebar for <a href="#getformat">format descriptions</a></div><br/>
			<input name="type" type="radio" value="discussion" <?php if ($_POST['type']=="discussion") { echo "checked"; } ?> /> Discussion <br/>
			<input name="type" type="radio" value="lecture" <?php if ($_POST['type']=="lecture") { echo "checked"; } ?> /> Lecture <br/>
			<input name="type" type="radio" value="panel" <?php if ($_POST['type']=="panel") { echo "checked"; } ?> /> Panel <br/>
			<input name="type" type="radio" value="workshop" <?php if ($_POST['type']=="workshop") { echo "checked"; } ?> /> Workshop (How-to) <br/><br/>
		<input type="hidden" id="typeValidate" value="<?= $vItems['type'] ?>" />
		<span id="typeMsg"></span>
	</td>
  </tr>

  <tr>
     <td><img id="layoutImg" src="/accounts/ajax/images/required.gif" width="16" height="16" /><strong>Room setup desired* </strong></td>
     <td> <input type="hidden" id="layoutValidate" value="<?= $vItems['layout'] ?>" /><span id="layout"></span>
		<div class=small>We will do our best to accomodate your request</div><br/>
          <input name="layout" type="radio" value="class" <?php if ($_POST['layout']=="class") { echo "checked"; } ?> /> <strong>classroom </strong>(rows of narrow tables w/chairs)<br/>
          <input name="layout" type="radio" value="theater" <?php if ($_POST['layout']=="theater") { echo "checked"; } ?> /> <strong>theater </strong>(rows of chairs only)<br/>
          <input name="layout" type="radio" value="conference" <?php if ($_POST['layout']=="conference") { echo "checked"; } ?> /> <strong>conference</strong> (roundtables or conference room setup)<br/>
     </td>
  </tr>
  <tr>
     <td><img id="lengthImg" src="/accounts/ajax/images/required.gif" width="16" height="16" />
     	<strong>Presentation Length* </strong></td>
     <td><input type="hidden" id="lengthValidate" value="<?= $vItems['length'] ?>" /><span id="length"></span>
		<div class=small>Times are not guaranteed. We will do our best to match each session with an appropriate time block</div><br/>
          <input name="length" type="radio" value="30" <?php if ($_POST['length']=="30") { echo "checked"; } ?> /> 30 minutes  <br/>
          <input name="length" type="radio" value="60" <?php if ($_POST['length']=="60") { echo "checked"; } ?> /> 60 minutes  <br/>
          <input name="length" type="radio" value="90" <?php if ($_POST['length']=="90") { echo "checked"; } ?> /> 90 minutes  <br/>
          <input name="length" type="radio" value="120" <?php if ($_POST['length']=="120") { echo "checked"; } ?> /> 120 minutes  <br/><br/>
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
    <?php 	}
   	?>
    <tr>
        <td >&nbsp;</td>
        <td style="padding-top: 5px;">
         <?php if ($edit) {  //currently editing a proposal   
         ?>
          Click on <strong>Save Changes</strong> to save your current changes.<br/> 	<input type="hidden" name="editPK" value="<?= $PK ?>" />
          <br/><input id="submitbutton" type="submit" name="submit" value="Save Changes" />
         <?php } else {   //this is a new proposal 
     	?>
  	      	Click on <strong>Add this proposal</strong> to submit this proposal item and continue with the submission process.<br/>
                <br/> <input id="submitbutton" type="submit" name="submit" value="Add this proposal" />
       <?php  } ?>
    		
          <br/>
          <br/>
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
<!--    <div id=gettrack class="componentheading">Conference Tracks</div>
    <div class="contentheading"> Teaching, Learning, and Assessment </div>
    <div class="contentpaneopen">The Teaching, Learning, and Assessment track will offer opportunities to share experiences with and plans for using Sakai or OSP for teaching and learning. These sessions will include presentations on the impact of OSP (or portfolios in general) on teaching practices; discussions regarding the value of a Collaborative Learning Environment (CLE) and its integrated toolset for students and the learning process; assessment management systems for tracking student progress toward learning goals; online learning using Sakai/OSP; and supporting reflective practices.</div>
    <div class="contentheading"> Management & Campus Implementation </div>
    <div class="contentpaneopen">This track highlights issues of concern to those managing current or upcoming pilot implementations; campus impact and implications; project assessment implications; training; coordination and leadership; and institutional change. This is appropriate for implementations of Sakai, OSP, or any interest regarding other strategies for integration of Sakai tools.</div>
    <div class="contentheading"> Research and Collaboration </div>
    <div class="contentpaneopen">The Research and Collaboration track will focus on using the Sakai Collaboration and Learning Environment (CLE) and its tools such as OSP or Melete, can be used to support research collaborations. We are looking for existing examples, current or upcoming projects, uses cases, and plans.</div>
    <div class="contentheading"> Sakai Foundation, Community Source & Governance </div>
    <div class="contentpaneopen">These sessions will focus on the transition from the current organization to the Sakai Foundation as the operational, governance, and legal framework for Sakai and OSPI. Issues and process around open and community source licensing and copyright will also be covered here.</div>
    <div class="contentheading"> Technology and User Interface</div>
    <div class="contentpaneopen">The Technology and User Interface track will offer sessions, panels, and round-tables that cover features and requirements; technical challenges and lessons learned for installing and implementing Sakai and integrated tools such as OSP, Samigo, and Melete; contributing code; tech support; commercial tech support; future releases; usability, user-interface design, and user-testing.</div>
    <div id=barRight> </div>
    <br/>
    <br/>-->
    <div id=getformat class="componentheading">Presentation Formats</div>
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