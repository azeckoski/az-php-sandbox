<?php
/*
 * Created on March 16, 2006 by @author aaronz
 * Modified from code by Susan Hardin (shardin@umich.edu)
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
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


// get the passed message if there is one
$borderColor = "white";
$backgroundColor="white";


if($_GET['msg']) {
	$msg = $_GET['msg'];

	if (preg_match("/^([A-Z]+):/",$msg, $matches)) {
		$msg = preg_replace("/^([A-Z]+):/","",$msg);
	
	    if ($matches[0] == "GREEN:") {
			$borderColor = "darkgreen";
			$backgroundColor="lightgreen";
	    }
	    elseif ($matches[0] == "YELLOW:") {
			$borderColor = "darkyellow";
			$backgroundColor="lightyellow";
	    }
	    elseif ($matches[0] == "RED:") {
			$borderColor = "darkred";
			$backgroundColor="lightred";
	    }
	}

	$Message = 
	"<div style='margin-bottom:18px;background-color:$backgroundColor;border:2px solid $borderColor;padding:3px;font-weight:bold;'>$msg</div>";
}




// check for date restrictions
if(strtotime($CONF_END_DATE) < time()) {
	$Message = "This Call for Proposal period has passed.<br>" .
			"Ended on " . date($DATE_FORMAT,strtotime($CONF_END_DATE));
	$error = true;
} elseif (strtotime($CFP_START_DATE) > time()) {
	$Message = "This Call for Proposal period has not yet begun.<br>" .
			"Call for Proposals will be accepted starting on " . date($DATE_FORMAT,strtotime($CFP_START_DATE));
	$error = true;
	if (($User->pk) && $User->checkPerm("admin_conference")) {
			// this item is not owned by current user and current user is not an admin
			$error = false;
	}
}

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['type'] = "required";


// writing data and other good things happen here
$completed = false;
if ($_POST['save']) { // saving the form

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
		//all required information provided
		$type=$_POST['type'];
		header("Location: edit_proposal.php?type=$type");
	}
}

?>


<!-- // INCLUDE THE HTML HEAD -->
<?php include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<!-- // INCLUDE THE HEADER -->
<?php include '../include/header.php';  ?>
<?php include 'include/proposals_LeftCol.php';  ?>

<?= $Message ?>

<?php
	// this should never happen but just in case
	if (!$User->institution_pk) {
		print "<b style='color:red;'>Fatal Error: You must use the My Account link to set " .
			"your institution before you can fill out your conference registration.</strong>";
	}
	else if ($error) {
		// do nothing except stop the user from loading the form
	?>	 <div style="padding:110px 0px;"></div> <!-- SPACER -->
	<?php  } else { // show registration form
	?>
		<table width="100%" class="blog" cellpadding="0" cellspacing="0">
	  <tr>
	    <td valign="top"><div class="componentheading">Call for Proposals - Add a New Proposal</div></td>
	  </tr>
	<!--  <tr>
		  <td height="25" bgcolor="#ffffff" style=" border-top: 5px solid #FFFFFF;">
		  	<span class="pathway">
		  		<img src="../include/images/arrow.png" height="12" width="12" alt="arrow" />
		  		<span class="activestep">Start &nbsp; &nbsp; &nbsp;</span>
		  		<img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />Proposal Details &nbsp; &nbsp; &nbsp; 
		  	 	</span>
		  	 
		  </td>
	  </tr> -->
	</table>

	<div id="cfp"><!-- start form section -->
	<form name="form1" id="form1" method="post" action="<?= $_SERVER['PHP_SELF'] ?>" >
	  <input type="hidden" name="save" value="1" />
	   <input type="hidden" name="new" value="" />
	  <table width="100%" cellpadding="0" cellspacing="0">
	   <tr>
	      <td valign="top" colspan="3" style="padding:0px;">
	      	<div id="requiredMessage"></div>
	      </td>
	   </tr>
	   <tr valign="top">
	      <td colspan="3" style="border:0; padding-bottom:0px;">
	        	<img id="typeImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" /><strong>Choose the type of proposal to be submitted</strong>
			<input type="hidden" id="typeValidate" value="<?= $vItems['type'] ?>" /><span id="typeMsg"></span>
		 </td>
	   </tr>
	   <tr>
	     <td colspan=3 valign="top">
	      	<div><input name="type" type="radio" value="presentation" <?php if ($_POST['type']=="presentation") echo "checked" ?> />&nbsp;&nbsp;<strong>Conference Presentation</strong>
				<div style="padding: 0px 40px;">
				<!-- <strong>Please Note:</strong>  At this time our schedule cannot accomodate any new presentations.  This option is available only for those who need to submit/resubmit a presentation as requested by the conference committe.
				-->	 
					Presentations will take place at the conference hotel, during the conference's 
					normal daytime schedule for June 12-14. You may choose from the following presentation types: Panel, Workshop, Discussion/Roundtable, Lecture/Presentation or Tool Carousel. <br/><br/>
				
				
				</div>
			</div>
			
		
				<!--			<div> <input name="type" type="radio" value="BOF" <?php if ($_POST['type']=="BOF") echo "checked" ?> />  &nbsp;&nbsp;<strong>Birds of a Feather (BOF) meetings</strong><span style="color:red"><strong>&nbsp;&nbsp; NEW! </strong></span><br/>
				<div style="padding: 0px 40px;">
					BOFs are self-formed meetings set up by any conference attendee to discuss a Sakai-related topic during the conference. BOFs may take place during the main conference sessions, as well as before or after the normal conference scheduled session - based on room availablity.
				<br/><br/>
				</div>
			</div>-->
				
				<div><input name="type" type="radio" value="demo" <?php if ($_POST['type']=="demo") echo "checked" ?> />&nbsp;&nbsp;<strong>Technology Demo</strong><br/>
					<div style="padding: 0px 40px;">
				 	Technology Demos will take place on Wednesday evening, June 13th.<br/><br/>
				
				<!-- <br/><strong> PLEASE NOTE:</strong>  We have filled our space/equipment allocations for 
					the technical demos.  However, you may still submit
					a Tech Demo Proposal-  we will put your name on the demo
					 list,  but Can Not guarantee a space at this time. 
					  Please check with the registration desk when you arrive. 
					   If more space becomes available or others cancel their demo, 
					   we may be able to accomodate you at the last minute.
					[<a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=173&amp;Itemid=523" target=blank>more information</a>]<br/><br/> 
				--> </div>
			</div>
				<div>
	      	<input name="type" type="radio" value="poster" <?php if ($_POST['type']=="poster") echo "checked" ?> />&nbsp;&nbsp;<strong>Poster session</strong><span style="color:red"><strong>&nbsp;&nbsp; </strong></span><br/>
					<div style="padding: 0px 40px;">
				 	Posters will be displayed during the conference in the main dining/gathering hall.  &nbsp;Posters will also be displayed during the 
				 	Technical Demonstrations on Wednesday evening, June 13th.  <br/><br/> 
				
			</div>
	
	        
			
		</td>
	   </tr>
     <tr>
	     <td colspan=3 style="text-align:center;">
			   	<input type="submit" name="submit" value="Continue" />
		     </td>
		 </tr>
      </table>
   </form>
</div> <!-- end cfp -->
	
     <?  }  ?>    <div style="margin:16px;"></div> <!-- SPACER -->


	
<?php include '../include/footer.php'; // Include the FOOTER ?>
