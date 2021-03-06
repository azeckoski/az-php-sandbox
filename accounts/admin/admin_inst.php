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

$ACTIVE_MENU="ACCOUNTS";  //for managing active links on multiple menus
$Message = "<br/>Add the information below to create an institution.<br/>";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';


// Make sure user is authorized
$allowed = false; // assume user is NOT allowed unless otherwise shown
if ((!$User->checkPerm("admin_accounts")) && (!$User->checkPerm("admin_inst")) ){
	$allowed = false;
	$Message = "Only admins with <b>admin_accounts</b> or <b>admin_inst</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = true;
}


// top header links
$EXTRA_LINKS = "<span class='extralinks'>" .
	"<a href='admin_users.php'>Users</a>" .
	"<a class='active'  href='admin_insts.php'>Institutions</a>" .
	"<a href='admin_perms.php'>Permissions</a>" .
	"<a href='admin_roles.php'>Roles</a>" .
	"</span>";



?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<?php include $ACCOUNTS_PATH.'include/header.php'; ?>
<div id="maincontent"> 

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
	$Message = "Edit the information below to adjust the institution.<br/>";
}
// create the user object from provider
$opInst = new Institution($PK);
if ($PK && !$opInst->pk) {
	echo "ERROR: Institution cannot be obtained from pk: $PK";
	exit;
}

// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['name'] = "required:namespaces:uniqueinstp;name;$PK"; // PK MUST be the last item
$vItems['type'] = "required";
$vItems['city'] = "namespaces";
$vItems['state'] = "namespaces";
$vItems['zipcode'] = "zipcode";
$vItems['country'] = "namespaces";

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
			if (!$PK) {
				// added a new institution
				echo "Created new institution: $opInst->name<br/>" .
					"<a href='$_SERVER[PHP_SELF]?pk=$opInst->pk'>Edit this institution</a> " .
					"or <a href='admin_insts.php'>Go to Institutions page</a>";
				include $ACCOUNTS_PATH.'include/footer.php';
				exit;
			}
		}
	} else {
		$Message = "<div class='error'>Please fix the following errors:\n<blockquote>\n$Message</blockquote>\n</div>\n";
	}
}

//echo $opUser, "<br/>"; // for testing
$thisItem = $opInst->toArray(); // put the user data into an array for easy access

// Use the user pks to get the user info for reps
$userPks = array();
$userPks[$opInst->rep_pk] = $opInst->rep_pk;
$userPks[$opInst->repvote_pk] = $opInst->repvote_pk;

$userInfo = $User->getUsersByPkList($userPks, "firstname,lastname,email");

//echo "<pre>",print_r($userInfo),"</pre><br/>";

// put the userInfo into the item
$thisItem['firstname'] = $userInfo[$opInst->rep_pk]['firstname'];
$thisItem['lastname'] = $userInfo[$opInst->rep_pk]['lastname'];
$thisItem['email'] = $userInfo[$opInst->rep_pk]['email'];

$thisItem['vfirstname'] = $userInfo[$opInst->repvote_pk]['firstname'];
$thisItem['vlastname'] = $userInfo[$opInst->repvote_pk]['lastname'];
$thisItem['vemail'] = $userInfo[$opInst->repvote_pk]['email'];
?>


<?= $Message ?>


<div class="required" id="requiredMessage"></div>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name="adminform" style="margin:0px;">
<input type="hidden" name="pk" value="<?= $PK ?>" />
<input type="hidden" name="save" value="1" />

<?php require $ACCOUNTS_PATH.'include/inst_form.php'; ?>

</form>
 </div>
 
 <div class="padding50">&nbsp;</div>
 <div class="padding50">&nbsp;</div>
<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>