<?php
/*
 * file: admin_inst.php
 * Created on Mar 6, 2006 8:59:17 AM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Institution Edit";
$Message = "Edit the information below to adjust the institution.<br/>";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
$Message = "";
if (!$User->checkPerm("admin_insts")) {
	$allowed = 0;
	$Message = "Only admins with <b>admin_insts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}


$PK = $_REQUEST["pk"]; // if editing/removing this will be set
if ($PK) {
	$Message = "Edit the information below to adjust the institution.<br/>";
}


// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['name'] = "required:namespaces:uniqueinstp;name;$PK";
$vItems['type'] = "required";
$vItems['city'] = "namespaces";
$vItems['state'] = "namespaces";
$vItems['zipcode'] = "zipcode";
$vItems['country'] = "namespaces";


// create the user object from provider
$opInst = new Institution($PK);


// this matters when the form is submitted
if ($_POST["save"]) {

	$opInst->name = $_POST["name"];
	$opInst->type = $_POST["type"];
	$opInst->city = $_POST["city"];
	$opInst->state = $_POST["state"];
	$opInst->zipcode = $_POST["zipcode"];
	$opInst->country = $_POST["country"];

	// DO SERVER SIDE VALIDATION
	$errors = 0;
	$validationOutput = ServerValidate($vItems, "return");
	if ($validationOutput) {
		$errors++;
		$Message = "<fieldset><legend>Validation Errors</legend>".
			"<span style='color:red;'>Please fix the following errors:</span><br/>".
			$validationOutput."</fieldset>";
	}

	if ($errors == 0) {
		// save the current inst
		if (!$opInst->save()) {
			$Message = "Error: Could not save: ".$opInst->Message;
		} else {
			$Message = "<strong>Saved institution information</strong>";
		}
	} else {
		$Message = "<div class='error'>Please fix the following errors:\n<blockquote>\n$Message</blockquote>\n</div>\n";
	}
}

//echo $opUser, "<br/>"; // for testing
$thisItem = $opInst->toArray(); // put the user data into an array for easy access


// top header links
$EXTRA_LINKS = "<br/><span style='font-size:9pt;'>" .
	"<a href='index.php'>Admin</a>: " .
	"<a href='admin_users.php'>Users</a> - " .
	"<a href='admin_insts.php'><strong>Institutions</strong></a> - " .
	"<a href='admin_perms.php'>Permissions</a>" .
	"</span>";

?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<?php include $ACCOUNTS_PATH.'include/header.php'; ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $ACCOUNTS_PATH.'include/footer.php';
		exit;
	}
?>

<div class="required" id="requiredMessage"></div>
<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" name="adminform" style="margin:0px;">
<input type="hidden" name="pk" value="<?= $PK ?>" />
<input type="hidden" name="add" value="<?= $_REQUEST["add"] ?>" />
<input type="hidden" name="save" value="1" />

<?php require $ACCOUNTS_PATH.'include/inst_form.php'; ?>

</form>

<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>