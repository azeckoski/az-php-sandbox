<?php
/*
 * file: createaccount.php
 * Created on Mar 01, 2006 10:21:01 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "My Account";

$ACTIVE_MENU="ACCOUNTS";  //for managing active links on multiple menus
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
	

	//$User->username = $_POST["username"];
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
			$User->setPassword($PASS1);
		}

		// handle the other institution stuff in a special way
		if (!is_numeric($User->institution_pk)) {
			// assume someone is using the other institution, Other MUST be pk=1
			$User->institution = $User->institution_pk;
			$User->institution_pk = 1;
		}

		$User->save(); // save the new values
		$Message = "<div style=\"border:2px solid darkgreen;padding:3px;background:lightgreen;font-weight:bold;\"><b>Updated user information</b></div><br/>";
	}
}



if ( ($User->checkPerm("admin_accounts")) || ($User->checkPerm("admin_conference")) ) {
// top header links for admins
$EXTRA_LINKS = "<span class='extralinks'>" .
	"<a href='$ACCOUNTS_URL/admin/admin_users.php'>Users</a>" .
	"<a   href='$ACCOUNTS_URL/admin/admin_insts.php'>Institutions</a>" .
	"<a href='$ACCOUNTS_URL/admin/admin_perms.php'>Permissions</a>" .
	"<a href='$ACCOUNTS_URL/admin/admin_roles.php'>Roles</a>" .
	"</span>";
} else {

// top header links
$EXTRA_LINKS = "<span class='extralinks'>";
	$EXTRA_LINKS .= "<a class='active' href='$CONFADMIN_URL/index.php' title='Sakai accounts home'><strong>Home</strong></a>:";

$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/registration/index.php'>Register</a>" .
"<a href='$CONFADMIN_URL/proposals/index.php'>Call for Proposals</a>" ;
if ($SCHEDULE_PUBLISHED) { 
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
		 }  else {
		 		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/draft_schedule.php'>Schedule</a>";
	
		 	
		 }
	$EXTRA_LINKS.="</span>";
}
	
?>
<?php // INCLUDE THE HTML HEAD
 include 'include/top_header.php';  ?>
<script type="text/javascript" src="ajax/validate.js"></script>
<?php require 'include/header.php';  ?>
<div id="maindata">
<?= $Message ?>

<div class="required" id="requiredMessage"></div>
<form name="adminform" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;">
<input type="hidden" name="save" value="1" />

<?php
	//echo "<pre>",$User,"</pre><br/>";
	$thisUser = $User->toArray();
	$disableUsername = true;
	$submitButtonName = "Save Information";
	require $ACCOUNTS_PATH.'include/user_form.php';
?>

</form>
<br/>
</div>

<?php include 'include/footer.php'; // Include the FOOTER ?>