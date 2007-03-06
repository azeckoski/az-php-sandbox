<?php
/*
 * Created on March 13, 2006 by @author aaronz
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
$AUTH_MESSAGE = "You must login to register or submit a proposal for the $CONF_NAME conference. If you do not have an account, please create one.";
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// bring in inst and conf data
require 'include/getInstConf.php';

$error = false;
$showRegistration=true;

// get the passed message if there is one
if($_GET['msg']) {
	$Message .= "<br/>" . $_GET['msg'];
}

if ($User->checkPerm("admin_conference")) {
	$REG_START_DATE="2006/08/01 8:00"; //only admins can see this before start date
}

// check for date restrictions
if(strtotime($CONF_END_DATE) < time()) {
	$Message = "This conference registration period has passed.<br>" .
			"Ended on " . date($DATE_FORMAT,strtotime($CONF_END_DATE));
	$error = true;
} elseif (strtotime($REG_START_DATE) > time()) {
	$Message = "This conference registration period has not yet begun.<br>" .
			"Begins on " . date($DATE_FORMAT,strtotime($REG_START_DATE));
	$error = true;
}

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['primaryRole'] = "required";
$vItems['secondaryRole'] = "";
$vItems['institution'] = "required";
$vItems['address1'] = "required:focus";
$vItems['city'] = "required";
$vItems['state'] = "required:namespaces";
$vItems['zipcode'] = "zipcode";
$vItems['country'] = "required:namespaces";
$vItems['phone'] = "required:phone";
$vItems['fax'] = "phone";
$vItems['confHotel'] = "required";
$vItems['jasig'] = "required";
$vItems['shirt'] = "required";
$vItems['delegate'] = "email";
$vItems['attending_tue'] ="required";
$vItems['attending_wed'] ="required";
$vItems['attending_thu'] ="required";
$vItems['attending_fri'] ="required";


// writing data and other good things happen here
$completed = false;
$thisUser = $User;
if ($_POST['save'] && !$error) { // saving the form

	// DO SERVER SIDE VALIDATION
	$errors = 0;
	$validationOutput = ServerValidate($vItems, "return");
	if ($validationOutput) {
		$errors++;
		$Message = "<fieldset><legend>Validation Errors</legend>".
			"<span style='color:red;'>Please fix the following errors:</span><br/>".
			$validationOutput."</fieldset>";
	}

	// get the post variables - USER
	$thisUser->primaryRole = $_POST["primaryRole"];
	$thisUser->secondaryRole = $_POST["secondaryRole"];
	$thisUser->address = $_POST["address"];
	$thisUser->city = $_POST["city"];
	$thisUser->state = $_POST["state"];
	$thisUser->zipcode = $_POST["zipcode"];
	$thisUser->country = $_POST["country"];
	$thisUser->phone = $_POST["phone"];
	$thisUser->fax = $_POST["fax"];

	if (!$isPartner && $_POST["institution"]) {
		$thisUser->institution = $_POST["institution"];
		$thisUser->institution_pk = 1;
	}

	// get the post variables - CONF
	$shirt = mysql_real_escape_string($_POST["shirt"]);
	$special = mysql_real_escape_string($_POST["special"]);
	$confHotel = mysql_real_escape_string($_POST["confHotel"]);
	$jasig = mysql_real_escape_string($_POST["jasig"]);
	$publishInfo = mysql_real_escape_string($_POST["publish"]);
	$delegate = mysql_real_escape_string($_POST["delegate"]);
	$expectations = mysql_real_escape_string($_POST["expectations"]);
	$attending = trim($_POST['attending_tue'] ." ". $_POST['attending_wed'] ." ". $_POST['attending_thu'] ." ". $_POST['attending_fri']);

//$attending=serialize($_POST['attending']); //takes the data from a post operation...
//$attending = implode(' ',$_POST['attending']).' ';

if (!$publishInfo) { $publishInfo = 'Y'; }

if (!$attending){
	$errors=1;
	$Message="Please tell us if which days you will be attending";
}
	// SAVE THE CURRENT DATA IN THE DATABASE
	if ($errors == 0) {
		// update the user information first
		$thisUser->save();

		// write the data to the database
		$new_req = false;
		if (!$isRegistered) { // no conference record for this user and this conference
			// calculate the fee
			$fee = 0;
			$activated = 'Y';
			if (!$isPartner) {
				$activated = 'N';
				if ($jasig == 'Y') {
					$fee = 345;
				} else {
					$fee = 395;
				}
			}

			// insert a new entry for the conference
			$confsql = "INSERT INTO conferences (confID, attending, shirt, special, confHotel, jasig, " .
				"publishInfo, date_created, fee, delegate, expectations, activated, " .
				"users_pk) VALUES " .
				"('$CONF_ID', '$attending','$shirt', '$special', '$confHotel', '$jasig', " .
				"'$publishInfo', NOW(), '$fee', '$delegate', '$expectations', '$activated', " .
				"'$thisUser->pk')";
			$result = mysql_query($confsql) or die('Conf insert query failed: ('.$confsql.')' . mysql_error());
			$new_req = true;
		} else {
			// update the existing entry
			$confsql = "UPDATE conferences SET attending='$attending', shirt='$shirt', special='$special', " .
				"confHotel='$confHotel', jasig='$jasig', expectations='$expectations', " .
				"delegate='$delegate', publishInfo='$publishInfo' WHERE " .
				"users_pk='$thisUser->pk' and confID='$CONF_ID'";
			$result = mysql_query($confsql) or die('Conf update query failed: ('.$confsql.')' . mysql_error());
		}
		
		// refresh the CONF arrays in case anything changed and to get the new conf data
		// for the newly created registration

		// get the new conf info for this user
		$conf_sql = "select * from conferences where users_pk='$thisUser->pk' and confID='$CONF_ID'";
		$result = mysql_query($conf_sql) or die('Conf fetch query failed: ' . mysql_error());
		$CONF = mysql_fetch_assoc($result); // first result is all we care about

		// registration complete (not including payment)
		$completed = true;

		// to payment page IF they have not already paid (no transID)
		if (!$isPartner && !$CONF['transID']) {
			header("Location:payment.php");  //begin VerisignPayment process
			print "Beginning versign payment process...<br/>";
			print "<a href='payment.php'>Continue if not redirected<a/>";
			exit();
		}
	}
}

// add in the help link
//$EXTRA_LINKS = " - <a style='font-size:9pt;' href='$HELP_LINK' target='_HELP'>Help</a><br/>";
//$EXTRA_MESSAGE = "<br/><span style='font-size:8pt;'>Technical problems? Please contact <a href='mailto:$HELP_EMAIL'>$HELP_EMAIL</a></span><br/>";
?>
<?php require $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<!-- // INCLUDE THE HEADER -->
<?php require '../include/header.php';  ?>
<?php require 'include/registration_LeftCol.php';  ?>


<table width="100%" class="blog" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><div class="componentheading"> Conference Registration</div></td>
  </tr>
</table>

<?php echo $Message; ?>
<?php
	// this should never happen but just in case
	if (!$User->institution_pk) {
		print "<b style='color:red;'>Fatal Error: You must use the My Account link to set " .
			"your institution before you can fill out your conference registration.</strong>";
	} else if ($completed) {
		// registration complete
		// draw confirmation page or send to payment page
		if ($isPartner || $CONF['transID']) {
			// draw the confirmation page
			$SEND_EMAIL = $new_req;
			require 'include/member_confirmation.php';
			// send the registration email if this is a new registration
			if ($new_req) {
				require 'include/email_confirmation.php';
			}
		}
	} else if ($isRegistered) {
		if ($isPartner || (!$isPartner && $CONF['transID'])) {
			// already registered and not a partner that has not paid
			require 'include/member_confirmation.php';
		}
	} else if ($error) {
		// do nothing except stop the user from loading the form
		?>
			 <div style="padding:110px 0px;"></div> <!-- SPACER -->
    <?
	} else { // show registration form
?>

<!-- start of the form td -->
<div> <!-- start form section -->
<form name="form1" id="form1" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
<input type="hidden" name="save" value="1" />
<table width="500"  cellpadding="0" cellspacing="0">

<tr>
	<td valign="top" colspan="2" style="padding:0px;">
		<div id="requiredMessage"></div>
	</td>
</tr>

<tr>
	<td colspan=2>
		<strong>Verify personal information:</strong><br />
		<div style="padding-left: 40px;">
<?php
	// get info for verification
	echo "<strong>Name:</strong> $thisUser->firstname $thisUser->lastname <br />";
	echo "<strong>Email:</strong> $thisUser->email <br />";
	echo "<strong>Institution:</strong> $thisUser->institution <br />";
?>
		<div style="margin:10px;"></div>
<?php
	if ($isPartner) {  // this means the user is in a partner inst 
?>
	<strong><?= $Inst->name ?> is a Sakai Partner Organization</strong> (registration fee is waived)
	<input type="hidden" name="memberType" value="1" />
<?php } else { // this is a member institution ?>
	<strong><?= $User->institution ?> is not a Sakai Partner Organization</strong>&nbsp;
	<input type="hidden" name="memberType" value="2" />
	<br/>
      <div style="margin:10px;"></div>
      <strong>Registration Fee:</strong> $395 per person. <br />
      <em>If you are also attending the JA-SIG/uPortal conference, your fee will be $345</em><br />
      <div style="margin:6px;"></div>
      Visa, Mastercard, and American express accepted<br />
      <img src="<?= $TOOL_URL ?>/include/images/ccards.jpg" width="121" height="30"/>
<?php } ?>
	<div style="margin:10px;"></div>
	If the above information is wrong, use 
	<a href="<?= $ACCOUNTS_URL ?>/<?= $ACCOUNTS_PAGE ?>" >My Account</a>
	to correct it <strong>before</strong> registering
		</div>
	</td>
</tr>

<?php require('include/registration_form.php'); ?>

<?php if ($isPartner) { ?>
    <tr>
      <td colspan=2><div align=center>
          <input id="submitbutton" type="submit" name="submit_MemberReg" value="Save my registration" />
        </div></td>
    </tr>
<?php  } else { ?>
    <tr>
      <td colspan=2><div align=center>
          <input id="submitbutton" type="submit" name="submit_NonMemberReg" value="Save and continue" />
        </div></td>
    </tr>
<?php  } ?>
  </table>
</form>
<!--end of unique form info for form1 -->
</div> <!-- end cfp -->
<?php } ?>

<?php require '../include/footer.php'; // Include the FOOTER ?>
