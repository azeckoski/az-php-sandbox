<?php
/*
 * file: admin_user.php
 * Created on Apr 5, 2006 11:00:45 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "User control";
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication (populates curUser object is authed)
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = false; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("admin_accounts")) {
	$allowed = false;
	$Message = "Only admins with <b>admin_accounts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = true;
}


// top header links
$EXTRA_LINKS = "<br/><span style='font-size:9pt;'>" .
	"<a href='index.php'>Admin</a>: " .
	"<a href='admin_users.php'><strong>Users</strong></a> - " .
	"<a href='admin_insts.php'>Institutions</a> - " .
"<a href='admin_perms.php'>Permissions</a> - <a href='admin_roles.php'>Roles</a>" .
	"</span>";

?>
<?php include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<!-- // INCLUDE THE HEADER -->
<?php include $ACCOUNTS_PATH.'include/header.php';  ?>


<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		echo $Message;
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
$opUser = new User($PK);
if ($PK && !$opUser->pk) {
	$allowed = false;
	$Message = "ERROR: User cannot be obtained from pk = $PK";
} else {
	$opUser->repCheck();
}

// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['username'] = "required:nospaces:uniqueuserp;username;$PK";
$vItems['email'] = "required:email:uniqueuserp;email;$PK";
$vItems['password1'] = "password";
$vItems['password2'] = "password:match;password1";
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

	$opUser->username = $_POST["username"];
	$opUser->email = $_POST["email"];
	$opUser->firstname = $_POST["firstname"];
	$opUser->lastname = $_POST["lastname"];
	$opUser->institution = $_POST["institution"];
	$opUser->institution_pk = $_POST["institution_pk"];
	$opUser->primaryRole = $_POST["primaryRole"];
	$opUser->secondaryRole = $_POST["secondaryRole"];
	$opUser->address = $_POST["address"];
	$opUser->city = $_POST["city"];
	$opUser->state = $_POST["state"];
	$opUser->zipcode = $_POST["zipcode"];
	$opUser->country = $_POST["country"];
	$opUser->phone = $_POST["phone"];
	$opUser->fax = $_POST["fax"];

	$PASS1 = $_POST["password1"];
	$PASS2 = $_POST["password2"];

	// set permissions without removing existing ones 
	// (this way perms added from other systems are preserved)
	$opUser->sakaiPerm = array(); // clear first
	if (is_array($_POST["perms"])) {
		$perms_sql="select perm_name from permissions";
		$perm_result = mysql_query($perms_sql) or die("Query failed ($perms_sql): " . mysql_error());	
		while($row = mysql_fetch_assoc($perm_result)) {
			$perm = $row['perm_name'];
			if (in_array($perm,$_POST["perms"])) {
				$opUser->addPerm($perm);
			} else {
				$opUser->removePerm($perm);
			}
		}
	}

	if ($_POST["active"]) {
		$opUser->addStatus("active");
	} else {
		$opUser->removeStatus("active");
	}

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
		// set password
		if (strlen($PASS1) > 0) {
			$opUser->setPassword($_POST["password1"]);
		}

		// handle the other institution stuff in a special way
		if (!is_numeric($opUser->institution_pk)) {
			// assume someone is using the other institution, Other MUST be pk=1
			$opUser->institution = $opUser->institution_pk;
			$opUser->institution_pk = 1;
		}

		// Set vote rep if checked - have to set the vote rep first
		if($_POST["voterep"]) {
			$opUser->setVoteRep(true);
		} else {
			$opUser->setVoteRep(false);
		}

		// Set the inst rep if checked
		if($_POST["instrep"]) {
			$opUser->setRep(true);
		} else {
			$opUser->setRep(false);
		}

		// save the current user
		if (!$opUser->save()) {
			$Message = "Error: Could not save: ".$opUser->Message;
		} else {
			$Message = "<strong>Saved user information</strong>";
			if (!$PK) {
				// added a new user
				echo "Created new user: $opUser->username<br/>" .
					"<a href='$_SERVER[PHP_SELF]?pk=$opUser->pk'>Edit this user</a> " .
					"or <a href='admin_users.php'>Go to Users page</a>";
				include $ACCOUNTS_PATH.'include/footer.php';
				exit;
			}
		}
	}
}

//echo $opUser, "<br/>"; // for testing
$thisUser = $opUser->toArray(); // put the user data into an array for easy access

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
				if ($opUser->active) { echo " checked='y' "; }
			?>/>
			<i> - account is active (inactive accounts cannot login)</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Inst Rep:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="instrep" tabindex="10" value="1" <?php
				if ($opUser->isRep) { echo " checked='y' "; }
			?>/>
			<i> - user is the representative for the listed institution</i>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Vote Rep:</b></td>
		<td class="checkbox">
			<input type="checkbox" name="voterep" tabindex="11" value="1" <?php
				if ($opUser->isVoteRep) { echo " checked='y' "; }
			?>/>
			<i> - user is the polling rep for the listed institution</i>
		</td>
	</tr>

	<tr>
		<td colspan="2" class="account"><br/><b>Permissions:</b></td>
	</tr>

<?php 
	// get the list of permissions
	$perms_sql="select * from permissions";
	$perm_result = mysql_query($perms_sql) or die("Query failed ($perms_sql): " . mysql_error());	
	while($row = mysql_fetch_assoc($perm_result)) { ?>
	<tr>
 		<td class="account"><strong><?= $row['perm_name'] ?>:</strong></td>
		<td class="checkbox">
			<input type="checkbox" name="perms[]" value="<?= $row['perm_name'] ?>" <?php
				if ($opUser->checkPerm($row['perm_name'])) { echo " checked='y' "; }
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