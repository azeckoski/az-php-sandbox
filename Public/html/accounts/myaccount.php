<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "My Account";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require 'include/check_authentic.php';

// login if not autheticated
require 'include/auth_login_redirect.php';

// bring in the form validation code
require 'ajax/validators.php';

// Define the array of items to validate and the validation strings
$vItems = array();
//$vItems['username'] = "required:nospaces:uniquesql;username;users;pk;$User->pk";
$vItems['email'] = "required:email:uniquesql;email;users;pk;$User->pk";
$vItems['password1'] = "password";
$vItems['password2'] = "password";
$vItems['firstname'] = "required:focus";
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
if ($_POST["save"]) {

	//$user->username = $_POST["username"];
	$User->email = $_POST["email"];
	$User->firstname = $_POST["firstname"];
	$User->lastname = $_POST["lastname"];
	$User->primaryRole = $_POST["primaryRole"];
	$User->secondaryRole = $_POST["secondaryRole"];
	$User->institution_pk = $_POST["institution_pk"];
	$User->address = $_POST["address"];
	$User->city = $_POST["city"];
	$User->state = $_POST["state"];
	$User->zipcode = $_POST["zipcode"];
	$User->country = $_POST["country"];
	$User->phone = $_POST["phone"];
	$User->fax = $_POST["fax"];

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
		if (strlen($PASS1) > 0) {
			$User->password = $PASS1;
		}

		// handle the other institution stuff in a special way
		if (!is_numeric($User->institution_pk)) {
			// assume someone is using the other institution, Other MUST be pk=1
			$User->institution = $User->institution_pk;
			$User->institution_pk = 1;
		}

		$User->save(); // save the new values
		$Message = "<b>Updated user information</b><br/>";
	}
}
?>
<?php include 'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<?php include 'include/header.php';  ?>

<?= $Message ?>

<div class="required" id="requiredMessage"></div>
<form name="adminform" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;">
<input type="hidden" name="save" value="1" />

<?php
	$thisUser = $User->toArray();
	$disableUsername = true;
	$submitButtonName = "Save Information";
	require $ACCOUNTS_PATH.'include/user_form.php';
?>

</form>

<span style="font-size:9pt;">
	<b>Note:</b> <i>To change your password, enter the new values in the fields above.<br/>
	To leave your password at its current value, leave the password fields blank.</i>
</span>
<br/>

<?php include 'include/footer.php'; // Include the FOOTER ?>