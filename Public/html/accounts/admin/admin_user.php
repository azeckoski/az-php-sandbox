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
if (!$User->checkPerm("admin_accounts")) {
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
$vItems['username'] = "required:nospaces:uniquesql;username;users;pk;$PK";
$vItems['email'] = "required:email:uniquesql;email;users;pk;$PK";
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
if ($_POST["save"] && $allowed) {

	$username = mysql_real_escape_string($_POST["username"]);
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
	$activated = mysql_real_escape_string($_POST["activated"]);
	if (!$activated) { $activated = 0; }

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
		$institutionSql = " institution=NULL, ";
		if (!is_numeric($institution_pk)) {
			// assume someone is using the other institution, Other MUST be pk=1
			$institutionSql = " institution='$institution_pk', ";
			$institution_pk = 1;
		}

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

		$sqledit = "UPDATE users set email='$email', " . $passChange . $permsSql . $institutionSql .
			"firstname='$firstname', lastname='$lastname', username='$username'," .
			"primaryRole='$primaryRole', secondaryRole='$secondaryRole'," .
			"institution_pk='$institution_pk', address='$address', city='$city', " .
			"state='$state', zipcode='$zipcode', country='$country', phone='$phone', " .
			"fax='$fax', activated='$activated' where pk='$PK'";

		$result = mysql_query($sqledit) or die("Update query failed ($sqledit): " . mysql_error());
		$Message = "<b>Updated user information</b><br/>";

		// set or unset the voting rep (this has to happen before the rep set)
		if ($_REQUEST["setrepvote"]) {
			// set this user as the rep for the currently selected institution
			$instrepsql = "UPDATE institution set repvote_pk='$PK' where pk='$institution_pk'";
			$result = mysql_query($instrepsql) or die('Institution update query failed: ' . mysql_error());
			$Message .= "<b>Set this user as a voting rep.</b><br/>";
		} else {
			// UNset this user as the rep for the currently selected institution
			$instrepsql = "UPDATE institution set repvote_pk = null where pk='$institution_pk' and repvote_pk='$PK'";
			$result = mysql_query($instrepsql) or die('Institution update query failed: ' . mysql_error());
			//$Message .= "<b>Unset this user as a voting rep.</b><br/>";
		}

		// set or unset the inst rep if needed
		if ($_REQUEST["setrep"]) {
			// set this user as the rep for the currently selected institution
			$instrepsql = "UPDATE institution set rep_pk='$PK' where pk='$institution_pk'";
			$result = mysql_query($instrepsql) or die('Institution update query failed: ' . mysql_error());
			$Message .= "<b>Set this user as an institutional rep.</b><br/>";
			
			// now also set the voting rep if it is not set for this inst
			$check_rep_sql="select repvote_pk from institution where pk = '$institution_pk'";
			$result = mysql_query($check_rep_sql) or die('Query failed: ' . mysql_error());	
			$checkRep = mysql_fetch_row($result);
			mysql_free_result($result);
			
			if (!$checkRep[0]) {
				$instrepsql = "UPDATE institution set repvote_pk='$PK' where pk='$institution_pk'";
				$result = mysql_query($instrepsql) or die('Institution update query failed: ' . mysql_error());
				$Message .= "<b>Auto set this user as a voting rep also.</b><br/>";
			}

		} else {
			// UNset this user as the rep for the currently selected institution
			$instrepsql = "UPDATE institution set rep_pk = null where pk='$institution_pk' and rep_pk='$PK'";
			$result = mysql_query($instrepsql) or die('Institution update query failed: ' . mysql_error());
			//$Message .= "<b>Unset this user as an institutional rep.</b><br/>";
		}
	}
}

// get the information for this user
$authsql = "SELECT * FROM users WHERE pk = '$PK'";
$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());
$thisUser = mysql_fetch_assoc($result);
	
// get if this user is an institutional rep or voting rep
$check_rep_sql="select rep_pk, repvote_pk from institution where pk = '$institution_pk'";
$result = mysql_query($check_rep_sql) or die('Query failed: ' . mysql_error());	
$checkRep = mysql_fetch_assoc($result);
mysql_free_result($result);


// top header links
$EXTRA_LINKS = "<br/><span style='font-size:9pt;'>";
$EXTRA_LINKS .= "<a href='index.php'>Admin</a>: ";
if ($USE_LDAP) {
	$EXTRA_LINKS .=	"<a href='admin_ldap.php'>LDAP</a> - ";
}
$EXTRA_LINKS .= "<a href='admin_users.php'><strong>Users</strong></a> - " .
	"<a href='admin_insts.php'>Institutions</a> - " .
	"<a href='admin_perms.php'>Permissions</a>" .
	"</span>";

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
<input type="hidden" name="pk" value="<?= $PK ?>" />
<input type="hidden" name="save" value="1" />

<?php
	$submitButtonName = "Save Information";
	require $ACCOUNTS_PATH.'include/user_form.php';
?>

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
				if ($thisUser["activated"]) { echo " checked='y' "; }
			?>/>
			<i> - account is active (inactive accounts cannot login)</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Inst Rep:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="setrep" tabindex="10" value="1" <?php
				if ($checkRep["rep_pk"] == $PK) { echo " checked='y' "; }
			?>/>
			<i> - user is the representative for the listed institution</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Vote Rep:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="setrepvote" tabindex="11" value="1" <?php
				if ($checkRep["repvote_pk"] == $PK) { echo " checked='y' "; }
			?>/>
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
				if ($thisUser["admin_accounts"]) { echo " checked='y' "; }
			?>/>
			<i> - user has admin access to accounts</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Institutions:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="admin_insts" tabindex="13" value="1" <?php
				if ($thisUser["admin_insts"]) { echo " checked='y' "; }
			?>/>
			<i> - user has admin access to institutions</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Requirements:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="admin_reqs" tabindex="14" value="1" <?php
				if ($thisUser["admin_reqs"]) { echo " checked='y' "; }
			?>/>
			<i> - user has admin access to req voting</i>
		</td>
	</tr>
</table>
</fieldset>

</td>
</tr>
</table>

</form>


<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>