<?php
/*
 * file: edit_user.php
 * Created on Mar 3, 2006 11:07:11 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * Allows admins to edit users
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Admin User Edit";
$Message = "Edit the information below to adjust the account.<br/>";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
if (!$USER["admin_accounts"]) {
	$allowed = 0;
	$Message = "Only admins with <b>admin_accounts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}

$PK = $_REQUEST["pk"];
if (!$PK) {
	print "You cannot come here without a user pk set!<br/>";
	print "<a href='admin.php'>Go back</a>";
	exit;
}


// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['username'] = "required:nospaces:uniquesql;username;users;pk;$USER_PK";
$vItems['email'] = "required:email:uniquesql;email;users;pk;$USER_PK";
$vItems['password1'] = "password";
$vItems['password2'] = "password";
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
if ($_POST["save"] && $allowed) {

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

	if ($errors == 0) {
		// write the new values to the DB
		$passChange = "";
		if (strlen($PASS1) > 0) {
			$passChange = " password=PASSWORD('$PASS1'), ";
		}

		$permsSql = "";
		if ($_REQUEST["admin_accounts"]) {
			$permsSql .= " admin_accounts = '1', ";
		} else {
			$permsSql .= " admin_accounts = '0', ";
		}
		if ($_REQUEST["admin_insts"]) {
			$permsSql .= " admin_insts = '1', ";
		} else {
			$permsSql .= " admin_insts = '0', ";
		}
		if ($_REQUEST["admin_reqs"]) {
			$permsSql .= " admin_reqs = '1', ";
		} else {
			$permsSql .= " admin_reqs = '0', ";
		}

		$sqledit = "UPDATE users set email='$email', " . $passChange . $permsSql .
			"firstname='$firstname', lastname='$lastname', username='$username'," .
			"institution_pk='$institution_pk', address='$address', city='$city', " .
			"state='$state', zipcode='$zipcode', country='$country', phone='$phone', " .
			"fax='$fax' where pk='$USER_PK'";

		$result = mysql_query($sqledit) or die('Update query failed: ' . mysql_error());
		$Message = "<b>Updated user information</b><br/>";

		// set or unset the voting rep (this has to happen before the rep set)
		if ($_REQUEST["setrepvote"]) {
			// set this user as the rep for the currently selected institution
			$instrepsql = "UPDATE institution set repvote_pk='$PK' where pk='$INSTITUTION_PK'";
			$result = mysql_query($instrepsql) or die('Institution update query failed: ' . mysql_error());
			$Message .= "<b>Set this user as a voting rep.</b><br/>";
		} else {
			// UNset this user as the rep for the currently selected institution
			$instrepsql = "UPDATE institution set repvote_pk = null where pk='$INSTITUTION_PK' and repvote_pk='$PK'";
			$result = mysql_query($instrepsql) or die('Institution update query failed: ' . mysql_error());
			//$Message .= "<b>Unset this user as a voting rep.</b><br/>";
		}

		// set or unset the inst rep if needed
		if ($_REQUEST["setrep"]) {
			// set this user as the rep for the currently selected institution
			$instrepsql = "UPDATE institution set rep_pk='$PK' where pk='$INSTITUTION_PK'";
			$result = mysql_query($instrepsql) or die('Institution update query failed: ' . mysql_error());
			$Message .= "<b>Set this user as an institutional rep.</b><br/>";
			
			// now also set the voting rep if it is not set for this inst
			$check_rep_sql="select repvote_pk from institution where pk = '$INSTITUTION_PK'";
			$result = mysql_query($check_rep_sql) or die('Query failed: ' . mysql_error());	
			$checkRep = mysql_fetch_row($result);
			mysql_free_result($result);
			
			if (!$checkRep[0]) {
				$instrepsql = "UPDATE institution set repvote_pk='$PK' where pk='$INSTITUTION_PK'";
				$result = mysql_query($instrepsql) or die('Institution update query failed: ' . mysql_error());
				$Message .= "<b>Auto set this user as a voting rep also.</b><br/>";
			}
		} else {
			// UNset this user as the rep for the currently selected institution
			$instrepsql = "UPDATE institution set rep_pk = null where pk='$INSTITUTION_PK' and rep_pk='$PK'";
			$result = mysql_query($instrepsql) or die('Institution update query failed: ' . mysql_error());
			//$Message .= "<b>Unset this user as an institutional rep.</b><br/>";
		}
	}
}

// get the authenticated user information
$authsql = "SELECT * FROM users WHERE pk = '$PK'";
$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());
$thisUser = mysql_fetch_assoc($result);
	
// get if this user is an institutional rep or voting rep
$check_rep_sql="select rep_pk, repvote_pk from institution where pk = '$INSTITUTION_PK'";
$result = mysql_query($check_rep_sql) or die('Query failed: ' . mysql_error());	
$checkRep = mysql_fetch_assoc($result);
mysql_free_result($result);


// set the header links
$EXTRA_LINKS = "<br><span style='font-size:9pt;'><a href='admin.php'>Users admin</a> - " .
	"<a href='admin_insts.php'>Institutions admin</a></span>";
?>

<!-- // INCLUDE THE HTML HEAD -->
<?php include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<!-- // INCLUDE THE HEADER -->
<?php include $ACCOUNTS_PATH.'include/header.php';  ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $ACCOUNTS_PATH.'include/footer.php';
		exit;
	}
?>


<div class="required" id="requiredMessage"></div>
<form name="adminform" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;">
<input type="hidden" name="pk" value="<?= $PK ?>">
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
			<input type="text" name="username" value="<?= $thisUser['username'] ?>" size="40" maxlength="50"/>
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
			<input type="text" name="firstname" value="<?= $thisUser['firstname'] ?>" size="30" maxlength="50"/>
			<input type="hidden" id="firstnameValidate" value="<?= $vItems['firstname'] ?>" />
			<span id="firstnameMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Last name:</b></td>
		<td nowrap="y">
			<img id="lastnameImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="lastname" value="<?= $thisUser['lastname'] ?>" size="30" maxlength="50"/>
			<input type="hidden" id="lastnameValidate" value="<?= $vItems['lastname'] ?>" />
			<span id="lastnameMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Email:</b></td>
		<td nowrap="y">
			<img id="emailImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="email" value="<?= $thisUser['email'] ?>" size="50" maxlength="50"/>
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
				<?= generate_partner_dropdown($thisUser['institution_pk']) ?>
			</select>
			<input type="hidden" id="institution_pkValidate" value="<?= $vItems['institution_pk'] ?>" />
			<span id="institution_pkMsg"></span>
		</td>
	</tr>

</table>
</fieldset>

<div style="margin:6px;"></div>
<input type="submit" value="Save Information"/>

</td>
<td width="50%" valign="top">

<!-- Column Two -->
<fieldset><legend>Location</legend>
<table border="0" class="padded">
	<tr>
		<td class="account"><b>Address:</b></td>
		<td nowrap="y">
			<img id="addressImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<textarea name="address" cols="40" rows="3"><?php echo $thisUser['address'];?></textarea>
			<input type="hidden" id="addressValidate" value="<?= $vItems['address'] ?>"/>
			<span id="addressMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>City:</b></td>
		<td nowrap="y">
			<img id="cityImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="city" value="<?= $thisUser['city'] ?>" size="40" maxlength="50">
			<input type="hidden" id="cityValidate" value="<?= $vItems['city'] ?>"/>
			<span id="cityMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>State:</b></td>
		<td nowrap="y">
			<img id="stateImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<select name="state">
<?php	$selectItem = $thisUser['state'];
		if ($selectItem) { echo "<option value='$selectItem'>$selectItem</option>"; }
		require $ACCOUNTS_PATH.'include/state_select.php';
?>
				<option value="">&nbsp;</option>
				<option value="-other-">Other (Not Listed)</option>
			</select>
			<input style="display:none;" type="text" id="stateOther" value="<?= $thisUser['state'] ?>" size="25" maxlength="50" />
			<input type="hidden" id="stateValidate" value="<?= $vItems['state'] ?>" />
			<span id="stateMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Zipcode:</b></td>
		<td nowrap="y">
			<img id="zipcodeImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="zipcode" value="<?= $thisUser['zipcode'] ?>" size="10" maxlength="10"/>
			<input type="hidden" id="zipcodeValidate" value="<?= $vItems['zipcode'] ?>" />
			<span id="zipcodeMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Country:</b></td>
		<td nowrap="y">
			<img id="countryImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<select name="country">
<?php	$selectItem = $thisUser['country'];
		if ($selectItem) { echo "<option value='$selectItem'>$selectItem</option>"; }
		require $ACCOUNTS_PATH.'include/country_select.php';
?>
				<option value="">&nbsp;</option>
				<option value="-other-">Other (Not Listed)</option>
			</select>
			<input style="display:none;" type="text" id="countryOther" value="<?= $thisUser['country'] ?>" size="25" maxlength="50" />
			<input type="hidden" id="countryValidate" value="<?= $vItems['country'] ?>" />
			<span id="countryMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Phone:</b></td>
		<td nowrap="y">
			<img id="phoneImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="phone" value="<?= $thisUser['phone'] ?>" size="15" maxlength="15"/>
			<input type="hidden" id="phoneValidate" value="<?= $vItems['phone'] ?>" />
			<span id="phoneMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Fax:</b></td>
		<td nowrap="y">
			<img id="faxImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" name="fax" value="<?= $thisUser['fax'] ?>" size="15" maxlength="15"/>
			<input type="hidden" id="faxValidate" value="<?= $vItems['fax'] ?>" />
			<span id="faxMsg"></span>
		</td>
	</tr>

</table>
</fieldset>


</td>
</tr>
</table>



<span style="font-size:9pt;">
	<b>Note:</b> <i>To change the password, enter the new values in the fields above.<br/>
	To leave your password at it's current value, leave the password fields blank.</i>
</span>

<table width="100%">
<tr>
<td valign="top" width="50%">

<fieldset><legend>Status</legend>
<table border="0" class="padded">
	<tr>
		<td class="account"><b>Activated:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="activated" tabindex="9" value="1" <?php
				if ($thisUser["activated"]) { echo " checked='Y' "; }
			?>>
			<i> - account is active (inactive accounts cannot login)</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Inst Rep:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="setrep" tabindex="10" value="1" <?php
				if ($checkRep["rep_pk"] == $PK) { echo " checked='Y' "; }
			?>>
			<i> - user is the representative for the listed institution</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Vote Rep:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="setrepvote" tabindex="11" value="1" <?php
				if ($checkRep["repvote_pk"] == $PK) { echo " checked='Y' "; }
			?>>
			<i> - user is the voting rep for the listed institution</i>
		</td>
	</tr>
</table>
</fieldset>

</td>
<td valign="top" width="50%">
	
<fieldset><legend>Permissions</legend>
<table>
	<tr>
		<td class="account"><b>Accounts:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="admin_accounts" tabindex="12" value="1" <?php
				if ($thisUser["admin_accounts"]) { echo " checked='Y' "; }
			?>>
			<i> - user has admin access to accounts</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Institutions:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="admin_insts" tabindex="13" value="1" <?php
				if ($thisUser["admin_insts"]) { echo " checked='Y' "; }
			?>>
			<i> - user has admin access to institutions</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Requirements:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="admin_reqs" tabindex="14" value="1" <?php
				if ($thisUser["admin_reqs"]) { echo " checked='Y' "; }
			?>>
			<i> - user has admin access to req voting</i>
		</td>
	</tr>
</table>

</td>
</tr>
</table>
</fieldset>

</form>


<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>