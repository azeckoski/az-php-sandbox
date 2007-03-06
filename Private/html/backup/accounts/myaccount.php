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
//$vItems['username'] = "required:nospaces:uniquesql;username;users;pk;$USER_PK";
$vItems['email'] = "required:email:uniquesql;email;users;pk;$USER_PK";
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

	//$username = mysql_real_escape_string($_POST["username"]);
	$email = mysql_real_escape_string($_POST["email"]);
	$PASS1 = mysql_real_escape_string($_POST["password1"]);
	$PASS2 = mysql_real_escape_string($_POST["password2"]);
	$firstname = mysql_real_escape_string($_POST["firstname"]);
	$lastname = mysql_real_escape_string($_POST["lastname"]);
	$primaryRole = mysql_real_escape_string($_POST["primaryRole"]);
	$secondaryRole = mysql_real_escape_string($_POST["secondaryRole"]);
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

	if ($errors == 0) {
		// write the new values to the DB
		$Message = "Edit the information below to adjust your account.<br/>";
		$passChange = "";
		if (strlen($PASS1) > 0) {
			$passChange = " password=PASSWORD('$PASS1'), ";
		}

		// handle the other institution stuff in a special way
		$otherInstSql = " otherInst=NULL, ";
		if (!is_numeric($institution_pk)) {
			// assume someone is using the other institution, Other MUST be pk=1
			$otherInstSql = " otherInst='$institution_pk', ";
			$institution_pk = 1;
		}

		$sqledit = "UPDATE users set email='$email', " . $passChange .
			"firstname='$firstname', lastname='$lastname', " . $otherInstSql .
			"primaryRole='$primaryRole', secondaryRole='$secondaryRole'," .
			"institution_pk='$institution_pk', address='$address', city='$city', " .
			"state='$state', zipcode='$zipcode', country='$country', phone='$phone', " .
			"fax='$fax' where pk='$USER_PK'";

		$result = mysql_query($sqledit) or die('Update query failed: ' . mysql_error());
		$Message = "<b>Updated user information</b><br/>";

		// get new values from the USERS table
		$sqlusers = "select * from users where pk = '$USER_PK'";
		$result = mysql_query($sqlusers) or die('User query failed: ' . mysql_error());
		$USER = mysql_fetch_assoc($result);
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
	$thisUser = $USER;
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