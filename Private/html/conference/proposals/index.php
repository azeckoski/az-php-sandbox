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

$ACTIVE_MENU="HOME";  //for managing active links on multiple menus
$Message = "";

// connect to database
require '../sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
$AUTH_MESSAGE = "<strong>LOGIN REQUIRED: </strong><br/>You must login to register or submit a proposal for this event." .
		" <br/>If you do not have an account, please <a href='$ACCOUNTS_URL/createaccount.php'>create one</a>.";
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';


// get the passed message if there is one
$borderColor = "#336699";
$backgroundColor="white";
$color="#660000";

if($_GET['msg']) {
	$msg = $_GET['msg'];

	if (preg_match("/^([A-Z]+):/",$msg, $matches)) {
		$msg = preg_replace("/^([A-Z]+):/","",$msg);
	
	    if ($matches[0] == "BLUE:") {
			$borderColor = "darkgreen";
			$backgroundColor="lightblue";
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
	"<div style='width:50%; text-align:left;color:$color; padding: 3px 10px; background-color:$backgroundColor;border:1px dotted $borderColor;font-weight:normal; '>$msg</div>";
}


// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['p_type'] = "required";


if ($_POST['save']) { // saving the form

	// DO SERVER SIDE VALIDATION
	$errors = 0;
	if (!$_POST['p_type']) {
		$errors++;
	}
	$validationOutput = ServerValidate($vItems, "return");
	if ($validationOutput) {
		$errors++;
		$Message = "<fieldset><legend>Validation Errors</legend>".
			"<b style='color:red;'>Please fix the following errors:</b><br/>".
			$validationOutput."</fieldset>";
	}

	if ($errors == 0 ) {
		
		//all required information provided
		$type=$_POST['p_type'];
		header("Location:edit_proposal.php?type=$type");
	}
}

?>


<?php 


$CSS_FILE = $ACCOUNTS_URL.'/include/accounts.css';


// top header links
$EXTRA_LINKS = "<span class='extralinks'>";
	$EXTRA_LINKS .= "<a  href='$ACCOUNTS_URL/index.php' title='Sakai accounts home'><strong>Home</strong></a>:";

$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/registration/index.php'>Register</a>" .
"<a class='active'  href='$CONFADMIN_URL/proposals/index.php'>Call for Proposals</a>" ;
if ($SCHEDULE) { 
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
		 }
	
	$EXTRA_LINKS.="</span>";

	
	
 // INCLUDE THE HTML HEAD
include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<?php  // INCLUDE THE HEADER
include $ACCOUNTS_PATH.'/include/header.php';  ?>
<div id="maincontent">
<?php include 'include/proposals_LeftCol.php'?>

<?php  if ($Message ) { echo "<div>".  $Message ."</div><br/>"; } ?> 

	

	<div id="cfp"><!-- start form section -->
	<form name="form1" id="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>" >
	  <input type="hidden" name="save" value="1" />
	   <input type="hidden" name="new" value="" />
	  <table width="100%" cellpadding="0" cellspacing="0">
	   <tr>
	      <td valign="top" colspan="3" style="padding:0px;">
	      	<div id="requiredMessage"></div>
	            </td>
	   </tr>
	   
	    	
	  
	  
	   <tr>
	     <td colspan="3" valign="top">
	       	<div>	 <img id="p_typeImg" src="/accounts/ajax/images/blank.gif"  alt="validation indicator" width="16" height="16" />
			 Select the type of proposal to be submitted: </div><br/><input type="hidden" id="p_typeValidate" value="<?= $vItems['p_type'] ?>" /><span id="p_typeMsg"></span>
		
	   	
	     <?php 
	     if ($SUBMIT_POSTER) { ?>
	     	<div>
	       	
			<input name="p_type" type="radio" value="poster" <?php if ($_POST['p_type']=="poster") echo "checked" ?> />&nbsp;&nbsp;
			<strong>Submit a Poster session</strong><br/>
				<div class="form_row">
				 <?php echo $POSTER_MSG; ?>
			</div></div>
			 <?php } 
			  if ($SUBMIT_BOF) { ?>
			 					<div>
			 	   <input name="p_type" type="radio" value="BOF" <?php if ($_POST['p_type']=="BOF") echo "checked" ?> />  &nbsp;&nbsp;
				 <strong>Submit a Birds of a Feather (BOF) meetings</strong></span><br/>
						<div class="form_row">
				<?php echo $BOF_MSG; ?>
				</div>
			</div>
			<?php } 
			  if ($SUBMIT_DEMO) { ?>	
				<div>
					<input name="p_type" type="radio" value="demo" <?php if ($_POST['p_type']=="demo") echo "checked" ?> />&nbsp;&nbsp;
					<strong>Submit a Technology Demo</strong><br/>
						<div class="form_row">
				 <?php echo $DEMO_MSG; ?>
				
			 </div>
			</div>
			 <?php } 
			  if ($SUBMIT_PRES) { ?>
			<div>
				<input name="p_type" type="radio" value="presentation" <?php if ($_POST['p_type']=="presentation") echo "checked" ?> />&nbsp;&nbsp;
				<strong>Submit a Conference Presentation</strong>
					<div class="form_row">
				<?php echo $PRESENT_MSG; ?>
				</div>
				</div>
			 <?php } 
			  if ($SUBMIT_PAPER) { ?>
				<div>
				<input name="p_type" type="radio" value="paper" <?php if ($_POST['p_type']=="paper") echo "checked" ?> />&nbsp;&nbsp;<strong>Submit a Paper</strong>
				<div class="form_row">
				<?php echo $PAPER_MSG; ?>
				</div>
				</div>
				
			
	        <?php } ?>
	        
			
		</td>
	   </tr>
     <tr><td style="text-align:center; border-bottom:0;"> </td>
	     <td style="border-bottom:0;">
			   	<input id="submitbutton" type="submit" name="submit" value="Continue" />
		     </td>
		 </tr>
      </table>
   </form><br/><br/><br/>
</div> <!-- end cfp -->
	<!-- SPACER -->

</td></tr></table>
</div>
<?php include $ACCOUNTS_PATH.'/include/footer.php'; // Include the FOOTER ?>
