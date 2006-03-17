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
//$vItems['username'] = "required:name:uniquesql;username;users;pk;$USER_PK";
$vItems['email'] = "required:email:uniquesql;email;users;pk;$USER_PK";
$vItems['password1'] = "password";
$vItems['password2'] = "password";
$vItems['firstname'] = "required:focus";
$vItems['lastname'] = "required";
$vItems['institution_pk'] = "required";
$vItems['address'] = "required";
$vItems['city'] = "required";
$vItems['state'] = "required:namespaces";
$vItems['zip'] = "zipcode";
$vItems['country'] = "required:namespaces";
$vItems['phone'] = "required:phone";
$vItems['fax'] = "phone";

// this matters when the form is submitted
if ($_POST["save"]) {

	$email = mysql_real_escape_string($_POST["email"]);
	$PASS1 = mysql_real_escape_string($_POST["password1"]);
	$PASS2 = mysql_real_escape_string($_POST["password2"]);
	$firstname = mysql_real_escape_string($_POST["firstname"]);
	$lastname = mysql_real_escape_string($_POST["lastname"]);
	$institution_pk = mysql_real_escape_string($_POST["institution_pk"]);
	$address = mysql_real_escape_string($_POST["address"]);
	$city = mysql_real_escape_string($_POST["city"]);
	$state = mysql_real_escape_string($_POST["state"]);
	$zip = mysql_real_escape_string($_POST["zip"]);
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

		$sqledit = "UPDATE users set email='$email', " . $passChange .
			"firstname='$firstname', lastname='$lastname', " .
			"institution_pk='$institution_pk' address='$address1', city='$city', " .
			"state='$state', zipcode='$zip', country='$country', phone='$phone', " .
			"fax='$fax' where pk='$USER_PK'";

		$result = mysql_query($sqledit) or die('Update query failed: ' . mysql_error());
		$Message = "<b>Updated user information</b><br/>";

		// get new values from the USERS table
		$sqlusers = "select * from users where pk = '$USER_PK'";
		$result = mysql_query($sqledit) or die('User query failed: ' . mysql_error());
		$USER = mysql_fetch_assoc($result);
	}
}
?>

<!-- // INCLUDE THE HTML HEAD -->
<?php include 'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<!-- // INCLUDE THE HEADER -->
<?php include 'include/header.php';  ?>

<?= $Message ?>

<div id="requiredMessage"></div>
<form name="adminform" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;">
<input type="hidden" name="save" value="1">
<table border="0" class="padded">
	<tr>
		<td class="account"><b>Username:</b></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $USER['username'] ?></td>
	</tr>

	<tr>
		<td class="account"><b>Password:</b></td>
		<td nowrap="y">
			<img id="password1Img" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="password" name="password1" tabindex="2" maxlength="50">
			<input type="hidden" id="password1Validate" value="<?= $vItems['password1'] ?>"/>
			<span id="password1Msg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Confirm pwd:</b></td>
		<td nowrap="y">
			<img id="password2Img" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="password" name="password2" tabindex="3" maxlength="50">
			<input type="hidden" id="password2Validate" value="<?= $vItems['password2'] ?>"/>
			<span id="password2Msg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>First name:</b></td>
		<td nowrap="y">
			<img id="firstnameImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="firstname" tabindex="4" value="<?= $USER['firstname'] ?>" size="30" maxlength="50"/>
			<input type="hidden" id="firstnameValidate" value="<?= $vItems['firstname'] ?>" />
			<span id="firstnameMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Last name:</b></td>
		<td nowrap="y">
			<img id="lastnameImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="lastname" tabindex="5" value="<?= $USER['lastname'] ?>" size="30" maxlength="50"/>
			<input type="hidden" id="lastnameValidate" value="<?= $vItems['lastname'] ?>" />
			<span id="lastnameMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Email:</b></td>
		<td nowrap="y">
			<img id="emailImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="email" tabindex="6" value="<?= $USER['email'] ?>" size="50" maxlength="50"/>
			<input type="hidden" id="emailValidate" value="<?= $vItems['email'] ?>" />
			<span id="emailMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Institution:</b></td>
		<td nowrap="y">
			<img id="institution_pkImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<select name="institution_pk" tabindex="7">
				<option value=""> --Select Your Organization-- </option>
				<?= generate_partner_dropdown($USER['institution_pk']) ?>
			</select>
			<input type="hidden" id="institution_pkValidate" value="<?= $vItems['institution_pk'] ?>" />
			<span id="institution_pkMsg"></span>
		</td>
	</tr>

	<tr>
		<td colspan="2">
			<input type="submit" name="account" value="Save information" tabindex="8">
		</td>
	</tr>
</table>
</form>

<span style="font-size:9pt;">
	<b>Note:</b> <i>To change your password, enter the new values in the fields above.<br/>
	To leave your password at it's current value, leave the password fields blank.</i>
</span>
<br/>

<?php include 'include/footer.php'; // Include the FOOTER ?>