<?php
/*
 * file: createaccount.php
 * Created on Mar 01, 2006 10:21:01 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Create Account";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require 'include/check_authentic.php';

// if logged in, kick over to my account instead
if ($USER_PK) {
	header('location:'.$ACCOUNTS_URL.'/myaccount.php');
	exit;
}

$Message = "<a href='login.php'>Login if you already have an account</a> -- " .
	"If you need to create an account, enter your information below.<br/>";


// bring in the form validation code
require 'ajax/validators.php';

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['username'] = "required:nospaces:uniquesql;username;users";
$vItems['email'] = "required:email:uniquesql;email;users";
$vItems['password1'] = "required:password";
$vItems['password2'] = "required:password";
$vItems['firstname'] = "required:focus";
$vItems['lastname'] = "required";
$vItems['institution_pk'] = "required";
$vItems['address'] = "";
$vItems['city'] = "namespaces";
$vItems['state'] = "namespaces";
$vItems['zipcode'] = "zipcode";
$vItems['country'] = "namespaces";
$vItems['phone'] = "phone";
$vItems['fax'] = "phone";

// this matters when the form is submitted
$created = false;
if ($_POST["save"]) {

	$username = mysql_real_escape_string($_POST["username"]);
	$email = mysql_real_escape_string($_POST["email"]);
	$PASS1 = mysql_real_escape_string($_POST["password1"]);
	$PASS2 = mysql_real_escape_string($_POST["password2"]);
	$firstname = mysql_real_escape_string($_POST["firstname"]);
	$lastname = mysql_real_escape_string($_POST["lastname"]);
	$institution_pk = mysql_real_escape_string($_POST["institution_pk"]);
	$address = mysql_real_escape_string($_POST["address"]);
	$city = mysql_real_escape_string($_POST["city"]);
	$state = mysql_real_escape_string($_POST["state"]);
	$zipcode = mysql_real_escape_string($_POST["zipcode"]);
	$country = mysql_real_escape_string($_POST["country"]);
	$phone = mysql_real_escape_string($_POST["phone"]);
	$fax = mysql_real_escape_string($_POST["fax"]);

	// DO SERVER SIDE VALIDATION
	$errors = 0;
	$validationOutput = ServerValidate($vItems, "return");
	if ($validationOutput) {
		$errors++;
		$Message = "<fieldset><legend>Validation Errors</legend>".
			"<span style='color:red;'>Please fix the following errors:</span><br/>".
			$validationOutput."</fieldset>";
	}
	
	// Check for password match
	if ((strlen($PASS1) > 0 || strlen($PASS2) > 0) && ($PASS1 != $PASS2)) {
		$Message .= "<span class='error'>Error: Passwords do not match</span><br/>";
		$errors++;
	}

	$username = strtolower($username); // lowercase the username

	if ($errors == 0) {
		// write the new values to the DB
		$sqledit = "INSERT INTO users (username,password,firstname,lastname,email,institution_pk," .
				"address,city,state,zipcode,country,phone,fax) values " .
				"('$username',PASSWORD('$PASS1'),'$firstname','$lastname','$email','$institution_pk'," .
				"'$address','$city','$state','$zipcode','$country','$phone','$fax')";

		$result = mysql_query($sqledit) or die('User creation failed: ' . mysql_error());
		$userPk = mysql_insert_id();

		$Message = "<b>New user account created</b><br/>" .
			"An email has been sent to $EMAIL.<br/>" .
			"Use the link in the email to activate your account.<br/>";
		$created = true;

		// log account creation
		writeLog($TOOL_SHORT,$_SERVER["REMOTE_ADDR"],"created account: $USERNAME ($EMAIL) " .
				"$LASTNAME,$FIRSTNAME inst=$INSTITUTION_PK");
		
		// bring in the activation email sending form
		include ("include/activation_email.php");
	}
}
?>

<!-- // INCLUDE THE HTML HEAD -->
<?php include 'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<script type="text/javascript">
<!--
window.onload = doFocus;

function doFocus() {
	document.adminform.username.focus();
}
// -->
</script>
<!-- // INCLUDE THE HEADER -->
<?php include 'include/header.php';  ?>

<?= $Message ?>

<?php if (!$created) { ?>

<div class="required" id="requiredMessage"></div>
<form name="adminform" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;">
<input type="hidden" name="save" value="1" />

<?php 
	$submitButtonName = "Create Account";
	require 'include/user_form.php';
?>

</form>

<span style="font-size:9pt;">
	<b>Note:</b> <i>Your user information is private and will only be used in this system.<br/>
	It will not be given to anyone else. Passwords are not stored as plain text in the database.</i>
</span>
<br/>

<?php } ?>

<?php include 'include/footer.php'; // Include the FOOTER ?>