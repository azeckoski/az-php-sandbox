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
if ($User->pk) {
	header('location:'.$ACCOUNTS_URL.'/myaccount.php');
	exit;
}

$Message = "<a href='login.php'>Login if you already have an account</a> -- " .
	"If you need to create an account, enter your information below.<br/>";


// bring in the form validation code
require 'ajax/validators.php';

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['username'] = "required:nospaces:focus:uniquesql;username;users";
$vItems['email'] = "required:email:uniquesql;email;users";
$vItems['password1'] = "required:password";
$vItems['password2'] = "required:password";
$vItems['firstname'] = "required";
$vItems['lastname'] = "required";
$vItems['primaryRole'] = "required";
$vItems['secondaryRole'] = "";
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

	$newUser->username = $_POST["username"];
	$newUser->email = $_POST["email"];
	$newUser->firstname = $_POST["firstname"];
	$newUser->lastname = $_POST["lastname"];
	$newUser->primaryRole = $_POST["primaryRole"];
	$newUser->secondaryRole = $_POST["secondaryRole"];
	$newUser->institution_pk = $_POST["institution_pk"];
	$newUser->address = $_POST["address"];
	$newUser->city = $_POST["city"];
	$newUser->state = $_POST["state"];
	$newUser->zipcode = $_POST["zipcode"];
	$newUser->country = $_POST["country"];
	$newUser->phone = $_POST["phone"];
	$newUser->fax = $_POST["fax"];

	$PASS1 = mysql_real_escape_string($_POST["password1"]);
	$PASS2 = mysql_real_escape_string($_POST["password2"]);

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

	if ($errors == 0) {
		
		// handle the other institution stuff in a special way
		if (!is_numeric($newUser->institution_pk)) {
			// assume someone is using the other institution, Other MUST be pk=1
			$newUser->institution = $newUser->institution_pk;
			$newUser->institution_pk = 1;
		}
		
		$newUser->save(); // save the new values

		$Message = "<b>New user account created</b><br/>" .
			"An email has been sent to $newUser->email.<br/>" .
			"Use the link in the email to activate your account.<br/>";
		$created = true;

		// log account creation
		writeLog($TOOL_SHORT,$_SERVER["REMOTE_ADDR"],"created account: $newUser->username ($newUser->email) " .
				"$newUser->lastname,$newUser->firstname: inst=$newUser->institution_pk");
		
		// bring in the activation email sending form
		require 'include/activation_email.php';
	}
}
?>
<?php require 'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<?php require 'include/header.php';  ?>

<?= $Message ?>

<?php if (!$created) { ?>

<div class="required" id="requiredMessage"></div>
<form name="adminform" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;">
<input type="hidden" name="save" value="1" />

<?php
	$thisUser = array();
	$submitButtonName = "Create Account";
	require $ACCOUNTS_PATH.'include/user_form.php';
?>

</form>

<span style="font-size:9pt;">
	<b>Note:</b> <i>Your user information is private and will only be used in this system.<br/>
	It will not be given to anyone else. Passwords are not stored as plain text in the database.</i>
</span>
<br/>

<?php } ?>

<?php require 'include/footer.php'; // Include the FOOTER ?>