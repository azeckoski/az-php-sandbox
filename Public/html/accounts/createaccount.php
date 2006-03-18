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
<!-- // INCLUDE THE HEADER -->
<?php include 'include/header.php';  ?>

<?= $Message ?>

<?php if (!$created) { ?>

<div class="required" id="requiredMessage"></div>
<form name="adminform" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;">
<input type="hidden" name="save" value="1" />

<table border="0" class="padded">
<tr>
<td width="50%" valign="top">

<!-- Column One -->
<fieldset><legend>Personal</legend>
<table border="0" class="padded">
	<tr>
		<td class="account"><b>Username:</b></td>
		<td nowrap="y">
			<img id="usernameImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="username" size="40" maxlength="50"/>
			<input type="hidden" id="usernameValidate" value="<?= $vItems['username'] ?>"/>
			<span id="usernameMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Password:</b></td>
		<td nowrap="y">
			<img id="password1Img" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="password" name="password1" maxlength="50"/>
			<input type="hidden" id="password1Validate" value="<?= $vItems['password1'] ?>"/>
			<span id="password1Msg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Confirm pwd:</b></td>
		<td nowrap="y">
			<img id="password2Img" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="password" name="password2" maxlength="50"/>
			<input type="hidden" id="password2Validate" value="<?= $vItems['password2'] ?>"/>
			<span id="password2Msg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>First name:</b></td>
		<td nowrap="y">
			<img id="firstnameImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="firstname" value="<?= $USER['firstname'] ?>" size="30" maxlength="50"/>
			<input type="hidden" id="firstnameValidate" value="<?= $vItems['firstname'] ?>" />
			<span id="firstnameMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Last name:</b></td>
		<td nowrap="y">
			<img id="lastnameImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="lastname" value="<?= $USER['lastname'] ?>" size="30" maxlength="50"/>
			<input type="hidden" id="lastnameValidate" value="<?= $vItems['lastname'] ?>" />
			<span id="lastnameMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Email:</b></td>
		<td nowrap="y">
			<img id="emailImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="email" value="<?= $USER['email'] ?>" size="50" maxlength="50"/>
			<input type="hidden" id="emailValidate" value="<?= $vItems['email'] ?>" />
			<span id="emailMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Institution:</b></td>
		<td nowrap="y">
			<img id="institution_pkImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<select name="institution_pk">
				<option value=""> --Select Your Organization-- </option>
				<?= generate_partner_dropdown($USER['institution_pk']) ?>
			</select>
			<input type="hidden" id="institution_pkValidate" value="<?= $vItems['institution_pk'] ?>" />
			<span id="institution_pkMsg"></span>
		</td>
	</tr>

</table>
</fieldset>

<div style="margin:6px;"></div>
<input type="submit" value="Create Account"/>

</td>
<td width="50%" valign="top">

<!-- Column Two -->
<fieldset><legend>Location</legend>
<table border="0" class="padded">
	<tr>
		<td class="account"><b>Address:</b></td>
		<td nowrap="y">
			<img id="addressImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<textarea name="address" cols="40" rows="3"><?php echo $USER['address'];?></textarea>
			<input type="hidden" id="addressValidate" value="<?= $vItems['address'] ?>"/>
			<span id="addressMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>City:</b></td>
		<td nowrap="y">
			<img id="cityImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="city" value="<?= $USER['city'] ?>" size="40" maxlength="50">
			<input type="hidden" id="cityValidate" value="<?= $vItems['city'] ?>"/>
			<span id="cityMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>State:</b></td>
		<td nowrap="y">
			<img id="stateImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<select name="state">
<?php	$selectItem = $USER['state'];
		if ($selectItem) { echo "<option value='$selectItem'>$selectItem</option>"; }
		require 'include/state_select.php';
?>
				<option value="">&nbsp;</option>
				<option value="-other-">Other (Not Listed)</option>
			</select>
			<input style="display:none;" type="text" id="stateOther" value="<?= $USER['state'] ?>" size="25" maxlength="50" />
			<input type="hidden" id="stateValidate" value="<?= $vItems['state'] ?>" />
			<span id="stateMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Zipcode:</b></td>
		<td nowrap="y">
			<img id="zipcodeImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="zipcode" value="<?= $USER['zipcode'] ?>" size="10" maxlength="10"/>
			<input type="hidden" id="zipcodeValidate" value="<?= $vItems['zipcode'] ?>" />
			<span id="zipcodeMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Country:</b></td>
		<td nowrap="y">
			<img id="countryImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<select name="country">
<?php	$selectItem = $USER['country'];
		if ($selectItem) { echo "<option value='$selectItem'>$selectItem</option>"; }
		require 'include/country_select.php';
?>
				<option value="">&nbsp;</option>
				<option value="-other-">Other (Not Listed)</option>
			</select>
			<input style="display:none;" type="text" id="countryOther" value="<?= $USER['country'] ?>" size="25" maxlength="50" />
			<input type="hidden" id="countryValidate" value="<?= $vItems['country'] ?>" />
			<span id="countryMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Phone:</b></td>
		<td nowrap="y">
			<img id="phoneImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="phone" value="<?= $USER['phone'] ?>" size="15" maxlength="15"/>
			<input type="hidden" id="phoneValidate" value="<?= $vItems['phone'] ?>" />
			<span id="phoneMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Fax:</b></td>
		<td nowrap="y">
			<img id="faxImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="fax" value="<?= $USER['fax'] ?>" size="15" maxlength="15"/>
			<input type="hidden" id="faxValidate" value="<?= $vItems['fax'] ?>" />
			<span id="faxMsg"></span>
		</td>
	</tr>

</table>
</fieldset>


</td>
</tr>
</table>

</form>

<span style="font-size:9pt;">
	<b>Note:</b> <i>Your user information is private and will only be used in this system.<br/>
	It will not be given to anyone else. Passwords are not stored as plain text in the database.</i>
</span>
<br/>

<?php } ?>

<?php include 'include/footer.php'; // Include the FOOTER ?>