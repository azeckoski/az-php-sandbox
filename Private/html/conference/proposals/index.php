<?php
/*
 * Created on March 16, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Registration";
$Message = "";

// connect to database
require '../sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
$AUTH_MESSAGE = "You must login to register for the $CONF_NAME conference. If you do not have an account, please create one.";
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';





// get the passed message if there is one
if($_GET['msg']) {
	$Message .= "<br/>" . $_GET['msg'];
}


// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['type'] = "required";


// writing data and other good things happen here
$completed = false;
if ($_POST['save']) { // saving the form
	$errors = 0;

	// DO SERVER SIDE VALIDATION
	$validationOutput = ServerValidate($vItems, "return");
	if ($validationOutput) {
		$errors++;
		$Message = "<fieldset><legend>Validation Errors</legend>".$validationOutput."</fieldset>";
	}

	// get the post variables - USER
	$address1 = mysql_real_escape_string($_POST["address1"]);
	$city = mysql_real_escape_string($_POST["city"]);
	$state = mysql_real_escape_string($_POST["state"]);
	$zip = mysql_real_escape_string($_POST["zip"]);
	$country = mysql_real_escape_string($_POST["country"]);
	$phone = mysql_real_escape_string($_POST["phone"]);
	$fax = mysql_real_escape_string($_POST["fax"]);

	// get the post variables - CONF
	$otherInst = mysql_real_escape_string($_POST["otherInst"]);
	$title = mysql_real_escape_string($_POST["title"]);
	$shirt = mysql_real_escape_string($_POST["shirt"]);
	$special = mysql_real_escape_string($_POST["special"]);
	$hotelInfo = mysql_real_escape_string($_POST["hotelInfo"]);
	$jasig = mysql_real_escape_string($_POST["jasig"]);
	$contactInfo = mysql_real_escape_string($_POST["publish"]);
	$delegate = mysql_real_escape_string($_POST["delegate"]);
	$expectations = mysql_real_escape_string($_POST["expectations"]);

	// other vars
	$institution = $INST['name'];
	$activated = "";
	
	// SAVE THE CURRENT DATA IN THE DATABASE
	if ($errors == 0) {
		// write the data to the database
		
		// update the user information first
		$usersql = "UPDATE users SET address='$address1', city='$city', state='$state', " .
			"zipcode='$zip', country='$country', phone='$phone', fax='$fax' where pk='$USER_PK'";
		$result = mysql_query($usersql) or die('User update query failed: ('.$usersql.')' . mysql_error());

		$new_req = false;
		if (!$isRegistered) { // no conference record for this user and this conference
			// calculate the fee
			$fee = 0;
			if (!$isPartner) {
				if ($jasig == 'Y') {
					$fee = 345;
				} else {
					$fee = 395;
				}
			}

			// insert a new entry for the conference
			$confsql = "INSERT INTO sakaiConf_all (confID, institution, otherInst, " .
				"title, shirt, special, hotelInfo, jasig, contactInfo, " .
				"fee, delegate, expectations, activated, users_pk) VALUES " .
				"('$CONF_ID', '$institution', '$otherInst', " .
				"'$title', '$shirt', '$special', '$hotelInfo', '$jasig', '$contactInfo', " .
				"'$fee', '$delegate', '$expectations', '$activated', $USER_PK)";
			$result = mysql_query($confsql) or die('Conf insert query failed: ('.$confsql.')' . mysql_error());
			$new_req = true;
		} else {
			// update the existing entry
			$confsql = "UPDATE sakaiConf_all SET institution='$institution', " .
				"otherInst='$otherInst', shirt='$shirt', special='$special', " .
				"hotelInfo='$hotelInfo', jasig='$jasig', expectations='$expectations', " .
				"title='$title', delegate='$delegate', contactInfo='$contactInfo' WHERE " .
				"users_pk='$USER_PK' and confID='$CONF_ID'";
			$result = mysql_query($confsql) or die('Conf update query failed: ('.$confsql.')' . mysql_error());
		}
		
		// refresh the USER and CONF arrays in case anything changed and to get the new conf data
		// for the newly created registration

		// get updated user information
		$user_sql = "select * from users where pk='$USER_PK'";
		$result = mysql_query($user_sql) or die('User fetch query failed: ' . mysql_error());
		$USER = mysql_fetch_assoc($result); // first result is all we care about
		
		// get the new conf info for this user
		$conf_sql = "select * from sakaiConf_all where users_pk='$USER_PK' and confID='$CONF_ID'";
		$result = mysql_query($conf_sql) or die('Conf fetch query failed: ' . mysql_error());
		$CONF = mysql_fetch_assoc($result); // first result is all we care about

		// registration complete (not including payment)
		$completed = true;

		// to payment page IF they have not already paid (no transID)
		if (!$isPartner && !$CONF['transID']) {
			header("Location:payment.php");  //begin VerisignPayment process
			exit();
		}
	}
}





if (isset($_POST[submit])) {
	session_start();
	
	$_SESSION['firstname']= $_POST['firstname'];
	$_SESSION['lastname']=$_POST['lastname'];
	$_SESSION['email1']=$_POST['email1'];
	
	
	include_once('includes/validate.php');
		
	if ($validated) {
		//all required information provided
		
		//create the database entry for this user
		include ('includes/submit_contact.inc.php');
		
		//finished with the database entry stuff - no errors
		
		//set presentation and demo values to 0 since none have been submitted yet
			
		$_SESSION['num_pres']='0';
		$_SESSION['num_demo']='0';
		
		//if presentation is selected, go to presentation page 
		if ($_POST['type']=="presentation") {
			header("Location: presentation.php");
		}
		
		//if demo is selected, go to demo page 
		if ($_POST['type']=="demo") {
			header("Location: demo.php");
		}
	}
}
?>


<!-- // INCLUDE THE HTML HEAD -->
<?php include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<!-- // INCLUDE THE HEADER -->
<?php include '../include/header.php';  ?>


<table width="100%" class="blog" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><div class="componentheading">Call for Proposals -- Submission Form</div></td>
  </tr>
  <tr>
	  <td height="25" bgcolor="#ffffff" style=" border-top: 5px solid #FFFFFF;">
	  	<span class="pathway"> <img src="../include/images/arrow.png" height="12" width="12" alt="arrow" />
	  	<span class="activestep">
	  	Start &nbsp; &nbsp; &nbsp;</span> <img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />
	  	Proposal Details &nbsp; &nbsp; &nbsp; <img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />
	  	Contact Information&nbsp; &nbsp; &nbsp; <img src="../include/images/arrow.png" height="8" width="8" alt="arrow" /> Confirmation
	  	</span>
	  </td>
  </tr>
</table>


<!-- //show form -->
<div id=cfp>
     <div>
     	<a style="color: #336699; font-weight: bold;" href="http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=170&Itemid=519" target=blank> PROPOSAL SUBMISSION GUIDELINES </a><br />
      <br />
    </div>

<?php echo $Message; ?>

  <!-- start form section -->
  <form id=form1 name="form1" method="post" action="<?php echo $_SERVER[PHP_SELF]; ?>">
    <table width="500px"  cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top" colspan="2" style="padding:0px;">
        	<div id="requiredMessage"></div>
        </td>
      </tr>

      <tr valign="top">
        <td colspan="2" style="border:0; padding-bottom:0px;">
        	<img id="typeImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
        	<strong>Select the type of proposal to be submitted:</strong>
			<input type="hidden" id="typeValidate" value="<?= $vItems['type'] ?>"/>
			<span id="typeMsg"></span>
            </td>
      </tr>

      <tr>
        <td valign="top" width="50%">
        	<input name="type" type="radio" value="presentation" <?php if ($_POST['type']=="presentation") echo "checked" ?> />
        	&nbsp;&nbsp;<strong>Conference Presentation</strong>
			<div style="padding:0px 10px;">
				Presentation formats include: panel, workshop, discussion, and lecture. 
				Presentations will take place at the conference hotel, during the conference's 
				daytime schedule for May 30 through June 2nd.
			</div>
		</td>
        <td valign="top" width="50%">
        	<input name="type" type="radio" value="demo" <?php if ($_POST['type']=="demo") echo "checked" ?> />
        	&nbsp;&nbsp;<strong>Technology Demo</strong>
			<div style="padding:0px 10px;">
				Technology Demos will take place on Thursday, June 1st. 
				[<a href="http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=173&Itemid=523" target=blank>more information</a>]
			</div>
		</td>
      </tr>

      <tr>
        <td colspan=2 style="text-align:center;">
        	<input type="submit" name="submit" value="continue" />
        </td>
      </tr>
    </table>

  </form>
</div>
<!-- end cfp -->
<!-- start  spacer  -->
<div><br />
  <br />
  <br />
  <br />
</div>
<!-- end  spacer  -->
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
    <div class="componentheading">More Info...</div>
    <div class="contentheading" width="100%">What will you need to provide?</div>
    <div class="contentpaneopen">
     <div><a href="http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=170&Itemid=519" target=blank> PROPOSAL SUBMISSION GUIDELINES </a><br />
      <br />
    </div><p>Preview a <a href="http://sakaiproject.org/vancouver/sakai_vancouverCFP.pdf" title="not available yet...">sample proposal form</a> and instructions for completing this Call for Proposal submission process. </p>
    </div>
    
    <div class="contentheading" width="100%">Review Previous Conference Sessions</div>
    <div class="contentpaneopen"><a title="" href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=161&amp;Itemid=497" target="blank"> 
    <img style="margin: 0px 10px 0px 0px;" width="100" height="61" border="1" title="" alt="" src="../include/images/agenda.gif"><br>
      </a> Review the sessions offered at the Sakai Austin Conference (December 2005)<br>
    </div>
  </div>
  <!--end rightcol -->
</div>
<!-- end outerright -->

<?php include '../include/footer.php'; // Include the FOOTER ?>
