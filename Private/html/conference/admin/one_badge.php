<?php
/* one_badge.php
 * Created on May 26, 2006 by @author az - Aaron Zeckoski
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech 
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Single Badge";
$Message = "Add the information below to print a single badge.<br/>";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = false; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("admin_conference")) {
	$allowed = false;
	$Message = "Only admins with <b>admin_conference</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = true;
}

// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";

// top header links
$EXTRA_LINKS = 
	"<br/><span style='font-size:9pt;'>" .
	"<a href='index.php'>Admin:</a> " .
	"<a href='attendees.php'>Attendees</a> - " .
	"<a href='proposals.php'>Proposals</a> - " .
	"<a href='check_in.php'>Check In</a> - " .
	"<a href='schedule.php'>Schedule</a> - " .
	"<a href='volunteers.php'>Volunteers</a> " .
	"</span>";

?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<?php include $ACCOUNTS_PATH.'include/header.php'; ?>


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
$vItems['firstname'] = "required:focus";
$vItems['lastname'] = "required";
$vItems['institution'] = "required";
$vItems['primaryRole'] = "required";
$vItems['secondaryRole'] = "";

?>

<?= $Message ?>


<div class="required" id="requiredMessage"></div>
<form action="create_badge.php" method="post" name="adminform" style="margin:0px;">
<input type="hidden" name="save" value="1" />

<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="80%" valign="top">

<!-- Column One -->
<fieldset><legend>Personal</legend>
<table border="0" cellpadding="2" cellspacing="0">

	<tr>
		<td class="account"><b>First&nbsp;name:</b></td>
		<td nowrap="y">
			<img id="firstnameImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="firstname" value="" size="30" maxlength="50"/>
			<input type="hidden" id="firstnameValidate" value="<?= $vItems['firstname'] ?>" />
			<span id="firstnameMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Last&nbsp;name:</b></td>
		<td nowrap="y">
			<img id="lastnameImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="lastname" value="" size="30" maxlength="50"/>
			<input type="hidden" id="lastnameValidate" value="<?= $vItems['lastname'] ?>" />
			<span id="lastnameMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Institution:</b></td>
		<td nowrap="y">
			<img id="emailImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="email" value="" size="50" maxlength="80"/>
			<input type="hidden" id="emailValidate" value="<?= $vItems['institution'] ?>" />
			<span id="emailMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Primary&nbsp;Title:</b></td>
		<td nowrap="y">
			<img id="primaryRoleImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="primaryRole" value="" size="30" maxlength="35"/>
			<input type="hidden" id="primaryRoleValidate" value="<?= $vItems['primaryRole'] ?>" />
			<span id="primaryRoleMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Secondary&nbsp;Title:</b></td>
		<td nowrap="y">
			<img id="secondaryRoleImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="secondaryRole" value="" size="30" maxlength="35"/>
			<input type="hidden" id="secondaryRoleValidate" value="<?= $vItems['secondaryRole'] ?>" />
			<span id="secondaryRoleMsg"></span>
		</td>
	</tr>

</table>

<input type='submit' value='Create Badge for printing' />

</fieldset>

</td>
</tr>
</table>

</form>

<br/>
<div class="right">
<div class="rightheader">How to use the special badge printer</div>
<div style="padding:3px;">
<div>If you made a mistake and do not like the way the badge looks, just click back in your browser and change the text.</div>
<div>The secondary title is optional, leave it blank if you like.</div>
<div>Close the window once you are done printing the PDF file.</div>
</div>
</div>

<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>