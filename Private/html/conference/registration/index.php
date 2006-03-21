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
$AUTH_MESSAGE = "You must login to register for the $CONF_NAME conference. If you do not have an account, please create one.";
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// bring in inst and conf data
require 'include/getInstConf.php';

// get the passed message if there is one
if($_GET['msg']) {
	$Message .= "<br/>" . $_GET['msg'];
}


// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['primaryRole'] = "required:focus";
$vItems['secondaryRole'] = "";
$vItems['otherInst'] = "required";
$vItems['address1'] = "required";
$vItems['city'] = "required";
$vItems['state'] = "required:namespaces";
$vItems['zip'] = "zipcode";
$vItems['country'] = "required:namespaces";
$vItems['phone'] = "required:phone";
$vItems['fax'] = "phone";
$vItems['confHotel'] = "required";
$vItems['jasig'] = "required";
$vItems['shirt'] = "required";
$vItems['delegate'] = "email";


// writing data and other good things happen here
$completed = false;
if ($_POST['save']) { // saving the form

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
	$address1 = mysql_real_escape_string($_POST["address1"]);
	$city = mysql_real_escape_string($_POST["city"]);
	$state = mysql_real_escape_string($_POST["state"]);
	$zip = mysql_real_escape_string($_POST["zip"]);
	$country = mysql_real_escape_string($_POST["country"]);
	$phone = mysql_real_escape_string($_POST["phone"]);
	$fax = mysql_real_escape_string($_POST["fax"]);
	$otherInst = mysql_real_escape_string($_POST["otherInst"]);
	$primaryRole = mysql_real_escape_string($_POST["primaryRole"]);
	$secondaryRole = mysql_real_escape_string($_POST["secondaryRole"]);

	// get the post variables - CONF
	$shirt = mysql_real_escape_string($_POST["shirt"]);
	$special = mysql_real_escape_string($_POST["special"]);
	$confHotel = mysql_real_escape_string($_POST["confHotel"]);
	$jasig = mysql_real_escape_string($_POST["jasig"]);
	$publishInfo = mysql_real_escape_string($_POST["publish"]);
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
			"zipcode='$zip', country='$country', phone='$phone', fax='$fax', " .
			"otherInst='$otherInst', primaryRole='$primaryRole', secondaryRole='$secondaryRole' " .
			"where pk='$USER_PK'";
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
			$confsql = "INSERT INTO conferences (confID, shirt, special, confHotel, jasig, " .
				"publishInfo, fee, delegate, expectations, activated, users_pk) VALUES " .
				"('$CONF_ID', '$shirt', '$special', '$confHotel', '$jasig', " .
				"'$publishInfo', '$fee', '$delegate', '$expectations', '$activated', $USER_PK)";
			$result = mysql_query($confsql) or die('Conf insert query failed: ('.$confsql.')' . mysql_error());
			$new_req = true;
		} else {
			// update the existing entry
			$confsql = "UPDATE conferences SET shirt='$shirt', special='$special', " .
				"confHotel='$confHotel', jasig='$jasig', expectations='$expectations', " .
				"delegate='$delegate', publishInfo='$publishInfo', date_modified=NOW() WHERE " .
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
		$conf_sql = "select * from conferences where users_pk='$USER_PK' and confID='$CONF_ID'";
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

// add in the help link
//$EXTRA_LINKS = " - <a style='font-size:9pt;' href='$HELP_LINK' target='_HELP'>Help</a><br/>";
//$EXTRA_MESSAGE = "<br/><span style='font-size:8pt;'>Technical problems? Please contact <a href='mailto:$HELP_EMAIL'>$HELP_EMAIL</a></span><br/>";
?>
<?php require $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<!-- // INCLUDE THE HEADER -->
<?php require '../include/header.php';  ?>


<table width="100%" class="blog" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><div class="componentheading">Sakai Conference Registration</div></td>
  </tr>
</table>

<?php echo $Message; ?>

<?php
	// this should never happen but just in case
	if (!$USER['institution_pk']) {
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
	} else { // show registration form
?>

<!-- start of the form td -->
<div id=cfp> <!-- start form section -->
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
	echo "<strong>Name:</strong> " . $USER['firstname'] . " " . $USER['lastname'] . "<br />";
	echo "<strong>Email:</strong> " . $USER['email'] . "<br />";
	echo "<strong>Institution:</strong> " . $INST['name'] . "<br />";
?>
		<div style="margin:10px;"></div>
<?php
	if ($isPartner) {  // this means the user is in a partner inst 
?>
	<strong><?= $INST['name'] ?> is a Sakai Partner Organization</strong> (registration fee is waived)
	<input type="hidden" name="memberType" value="1" />
	<input type="hidden" name="institution" value="<?= $INST['name'] ?>" />
<?php } else { // this is a member institution ?>
	<strong><?= $USER['otherInst'] ?> is not a Sakai Partner Organization</strong>&nbsp;
	<input type="hidden" name="memberType" value="2" />
	<br/>
      <div style="margin:10px;"></div>
      <strong>Registration Fee:</strong> $395 per person. <br />
      <em>If you are also attending the JA-SIG/uPortal conference, your fee will be $345</em><br />
      <div style="margin:6px;"></div>
      Visa, Mastercard, and American express accepted<br />
      <img src="<?= $TOOL_PATH ?>/include/images/ccards.jpg" width="121" height="30"/>
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

<?php } // end show reg form ?>

<?php require '../include/outer_right.php'; // Include right column ?>

<?php require '../include/footer.php'; // Include the FOOTER ?>
