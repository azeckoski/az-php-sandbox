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

$ACTIVE_MENU="ACCOUNTS";  //for managing active links  on multiple menus
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require 'include/check_authentic.php';

// if logged in, kick over to my account instead
if ($User->pk)  {
if (!$User->checkPerm("admin_accounts") ) { 
	header('location:'.$ACCOUNTS_URL.'/myaccount.php');
	exit;
}
}
if ($User->checkPerm("admin_accounts")){ 

$allowed=true;
$Message = "<br/><strong>ADMIN: Create New User Account</strong> ";
} else {
	$Message = " <br/><strong>Already have an account?</strong>   <a style='font-size:1.1em;' href='login.php'> Login <img src='include/images/arrow.gif' border='0'/></a> <br/> " .
	"";
	
	
}

// bring in the form validation code// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['username'] = "required:email:focus:uniqueuserp;username:uniqueuserp;email";
$vItems['email'] = "required:email:uniqueuserp;email";
$vItems['password1'] = "required:password";
$vItems['password2'] = "required:password:match;password1";
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

	// create new user object
	$newUser = new User();

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
		$newUser->setPassword($PASS1);

		// handle the other institution stuff in a special way
		if (!is_numeric($newUser->institution_pk)) {
			// assume someone is using the other institution, Other MUST be pk=1
			$newUser->institution = $newUser->institution_pk;
			$newUser->institution_pk = 1;
		}
		
		$newUser->save(); // save the new values

		$Message = "<br/><strong>New user account created</strong><br/>" .
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
<?php include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<!-- // INCLUDE THE HEADER -->
<?php include $ACCOUNTS_PATH.'include/header.php';  ?>
<div id="maincontent">

<?php if($Message) { ?><div> <?= $Message ?><br/></div> <?php }?>

<?php if (!$created) { ?>
	

<div class="required" id="requiredMessage"></div>
<form name="adminform" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;">
<input type="hidden" name="save" value="1" />

<?php
	$thisUser = array();
	$submitButtonName = "Create Account";
	require $ACCOUNTS_PATH.'/include/user_form.php';
?>

</form>


<br/>

<?php } ?> </div>

<div class="padding50"></div>
<?php require 'include/footer.php'; // Include the FOOTER ?>