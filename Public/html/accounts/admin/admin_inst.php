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

// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['name'] = "required:namespaces:uniquesql;institution;name;pk;$PK";
$vItems['type'] = "required";
$vItems['city'] = "required:namespaces";
$vItems['state'] = "namespaces";
$vItems['zipcode'] = "zipcode";
$vItems['country'] = "required:namespaces";


$PK = $_REQUEST["pk"]; // if editing/removing this will be set
if ($PK) {
	$Message = "Edit the information below to adjust the institution.<br/>";
}

// create the user object from provider
$opInst = new Institution($PK);


// this matters when the form is submitted
if ($_POST["save"]) {

	$NAME = $_POST["name"];
	$ABBR = $_POST["abbr"];
	$TYPE = $_POST["type"];

	// check if the name is unique
	$sql_name_check = mysql_query("SELECT pk FROM institution WHERE name='$NAME'");
	$row = mysql_fetch_row($sql_name_check);
	if ($row[0] > 0 && $row[0] != $PK) {
		$Message .= "<span class='error'>Error: This name ($NAME) is already in use.</span><br/>";
		$errors++;
	}
	mysql_free_result($sql_name_check);

	if ($errors == 0) {
		if ($_REQUEST["add"]) {
			// insert new institution
			$sqlinsert = "INSERT into institution (name,abbr,type) values ('$NAME','$ABBR','$TYPE')";
			$result = mysql_query($sqlinsert) or die('Inst insert query failed: ' . mysql_error());
			$PK = mysql_insert_id();
			$Message = "<b>Added new institution</b><br/>";
			$_REQUEST["add"] = "";
		} else if ($_REQUEST["remove"]) {
			// remove this institution if no users are in it
			$sqlremove = "DELETE from institution where pk='$PK' and rep_pk is null and repvote_pk is null";
			$result = mysql_query($sqlremove) or die('Inst remove query failed: ' . mysql_error());
			$Message = "<b>Remove institution $NAME</b><br/>";
		} else {
			// write the new values to the DB
			$sqledit = "UPDATE institution set name='$NAME', abbr='$ABBR', " .
					"type='$TYPE' where pk='$PK'";
			$result = mysql_query($sqledit) or die('Inst update query failed: ' . mysql_error());
			$Message = "<b>Updated institution information</b><br/>";

			// clear all values
			$NAME = "";
			$ABBR = "";
			$TYPE = "";
		}
	} else {
		$Message = "<div class='error'>Please fix the following errors:\n<blockquote>\n$Message</blockquote>\n</div>\n";
	}
}


// get the item information from the DB
$itemsql = "SELECT I1.*, U1.firstname,U1.lastname,U1.email," .
	"U2.firstname as vfirstname,U2.lastname as vlastname,U2.email as vemail " .
	"from institution I1 left join users U1 on U1.pk=I1.rep_pk " .
	"left join users U2 on U2.pk=I1.repvote_pk WHERE I1.pk = '$PK'";
$result = mysql_query($itemsql) or die('Query failed: ' . mysql_error());
$thisItem = mysql_fetch_assoc($result);
mysql_free_result($result);


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