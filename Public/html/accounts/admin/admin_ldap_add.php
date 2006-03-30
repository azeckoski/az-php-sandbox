<?php
/*
 * file: admin_ldap_add.php
 * Created on Mar 8, 2006 11:00:45 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "LDAP user control";
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// Load User and Inst PROVIDERS
require $ACCOUNTS_PATH.'include/providers.php';

// check authentication (populates curUser object is authed)
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

// top header links
$EXTRA_LINKS = "<br/><span style='font-size:9pt;'>";
$EXTRA_LINKS .= "<a href='index.php'>Admin</a>: ";
if ($USE_LDAP) {
	$EXTRA_LINKS .=	"<a href='admin_ldap.php'><strong>LDAP</strong></a> - ";
}
$EXTRA_LINKS .= "<a href='admin_users.php'>Users</a> - " .
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

<?php
$PK = $_REQUEST["pk"]; // if editing/removing this will be set
if ($PK) {
	$Message = "Edit the information below to adjust the account.<br/>";
}

// create the user object from provider
$ldapUser = new User($PK);

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

	$ldapUser->username = $_POST["username"];
	$ldapUser->email = $_POST["email"];
	$ldapUser->firstname = $_POST["firstname"];
	$ldapUser->lastname = $_POST["lastname"];
	$ldapUser->institution = $_POST["otherInst"];
	$ldapUser->institution_pk = $_POST["institution_pk"];
	$ldapUser->primaryRole = $_POST["primaryRole"];
	$ldapUser->secondaryRole = $_POST["secondaryRole"];
	$ldapUser->address = $_POST["address"];
	$ldapUser->city = $_POST["city"];
	$ldapUser->state = $_POST["state"];
	$ldapUser->zipcode = $_POST["zipcode"];
	$ldapUser->country = $_POST["country"];
	$ldapUser->phone = $_POST["phone"];
	$ldapUser->fax = $_POST["fax"];

	$PASS1 = $_POST["password1"];
	$PASS2 = $_POST["password2"];

	// set permissions without removing existing ones 
	// (this way perms added from other systems are preserved)
	$ldapUser->sakaiPerm = array(); // clear first
	if (is_array($_POST["perms"])) {
		$perms_sql="select perm_name from permissions";
		$perm_result = mysql_query($perms_sql) or die("Query failed ($perms_sql): " . mysql_error());	
		while($row = mysql_fetch_assoc($perm_result)) {
			$perm = $row['perm_name'];
			if (in_array($perm,$_POST["perms"])) {
				$ldapUser->addPerm($perm);
			} else {
				$ldapUser->removePerm($perm);
			}
		}
	}

	if ($_POST["active"]) { $ldapUser->addPerm("active"); }

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
		$ldapUser->setPassword($_POST["password1"]);

		// TODO - REP STUFF
		if($_POST["instrep"]) { }
		if($_POST["voterep"]) { }

		// write the values to LDAP
		if (!$ldapUser->save()) {
			$Message = "Error: Could not save: ".$ldapUser->Message;
		} else {
			$Message = "<strong>Saved user information</strong>";
		}
	}
}

// get the list of permissions
$perms_sql="select * from permissions";
$perm_result = mysql_query($perms_sql) or die("Query failed ($perms_sql): " . mysql_error());	


echo $ldapUser, "<br/>";

$thisUser = $ldapUser->toArray();

?>

<?= $Message ?>

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


<table width="60%">
<tr>
<td valign="top">

<fieldset><legend>Permissions</legend>
<table border="0" class="padded">
	<tr>
		<td class="account"><b>Activated:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="active" tabindex="9" value="1" <?php
				if ($ldapUser->active) { echo " checked='y' "; }
			?>/>
			<i> - account is active (inactive accounts cannot login)</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Inst Rep:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="instrep" tabindex="10" value="1" <?php
				if ($ldapUser->isRep) { echo " checked='y' "; }
			?>/>
			<i> - user is the representative for the listed institution</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Vote Rep:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="voterep" tabindex="11" value="1" <?php
				if ($ldapUser->isVoteRep) { echo " checked='y' "; }
			?>/>
			<i> - user is the voting rep for the listed institution</i>
		</td>
	</tr>

	<tr>
		<td colspan="2" class="account"><br/><b>Permissions:</b></td>
	</tr>

<?php while($row = mysql_fetch_assoc($perm_result)) { ?>
	<tr>
 		<td class="account"><strong><?= $row['perm_name'] ?>:</strong></td>
		<td class="checkbox">
			<input type="checkbox" name="perms[]" value="<?= $row['perm_name'] ?>" <?php
				if ($ldapUser->checkPerm($row['perm_name'])) { echo " checked='y' "; }
			?>/>
			<i>- <?= $row['perm_description'] ?></i>
		</td>
	</tr>
<?php } ?>

</table>
</fieldset>

</td>
</tr>
</table>

</form>

<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>