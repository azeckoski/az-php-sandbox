<?php
/*
 * file: admin_perm.php
 * Created on Mar 28, 2006 8:59:17 AM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Permission Edit";
$Message = "Edit the information below to adjust the permission.<br/>";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
$Message = "";
if (!$User->checkPerm("admin_accounts")) {
	$allowed = 0;
	$Message = "Only admins with <b>admin_accounts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}

// get the form variables
$PK = $_REQUEST["pk"];
if (!$PK) {
	$Message = "You cannot come here without a pk set!<br/>";
	$Message .= "<a href='admin_perms.php'>Go back</a>";
	$allowed = 0;
}


// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['perm_name'] = "required:focus:name:uniquesql;perm_name;permissions;pk;$PK";
$vItems['perm_description'] = "required";

// this matters when the form is submitted
if ($_POST["save"]) {

	$perm_name = mysql_real_escape_string($_POST["perm_name"]);
	$perm_description = mysql_real_escape_string($_POST["perm_description"]);

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
		if ($_REQUEST["add"]) {
			// insert new item
			$sqlinsert = "INSERT into permissions (perm_name,perm_description,date_created)" .
					" values ('$perm_name','$perm_description',NOW())";
			$result = mysql_query($sqlinsert) or die('Insert query failed: ' . mysql_error());
			$PK = mysql_insert_id();
			$Message = "<b>Added new permission</b><br/>";
			$_REQUEST["add"] = "";
		} else {
			// write the new values to the DB
			$sqledit = "UPDATE permissions set perm_name='$perm_name', " .
					"perm_description='$perm_description' where pk='$PK'";
			$result = mysql_query($sqledit) or die('Update query failed: ' . mysql_error());
			$Message = "<b>Updated permission information</b><br/>";
		}
	} else {
		$Message = "<div class='error'>Please fix the following errors:\n<blockquote>\n$Message</blockquote>\n</div>\n";
	}
}


// get the item information from the DB
$itemsql = "SELECT * from permissions P1 WHERE P1.pk = '$PK'";
$result = mysql_query($itemsql) or die('Query failed: ' . mysql_error());
$thisItem = mysql_fetch_assoc($result);
mysql_free_result($result);


// top header links
$EXTRA_LINKS = "<br/><span style='font-size:9pt;'>" .
	"<a href='index.php'>Admin</a>: " .
	"<a href='admin_users.php'>Users</a> - " .
	"<a href='admin_insts.php'>Institutions</a> - " .
	"<a href='admin_perms.php'><strong>Permissions</strong></a>" .
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
<input type="hidden" name="save" value="1" />
<input type="hidden" name="add" value="<?= $_REQUEST["add"] ?>" />

<table>
	<tr>
		<td class="account"><b>Name:</b></td>
		<td>
<?php if($_REQUEST["add"]) { ?>
			<img id="perm_nameImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="perm_name" value="<?= $thisItem['perm_name'] ?>" size="25" maxlength="30" />
			<input type="hidden" id="perm_nameValidate" value="<?= $vItems['perm_name'] ?>" />
			<span id="perm_nameMsg"></span>
<?php } else { ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $thisItem['perm_name'] ?>
			<input type="hidden" name="perm_name" value="<?= $thisItem['perm_name'] ?>" />
<?php } ?>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Description:</b></td>
		<td>
			<img id="perm_descriptionImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="perm_description" value="<?= $thisItem['perm_description'] ?>" size="80" maxlength="200"/>
			<input type="hidden" id="perm_descriptionValidate" value="<?= $vItems['perm_description'] ?>" />
			<span id="perm_descriptionMsg"></span>
		</td>
	</tr>
</table>

<input type='submit' value='Save Information' />

</form>

<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>