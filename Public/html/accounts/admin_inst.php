<?php
/*
 * file: admin_inst.php
 * Created on Mar 6, 2006 8:59:17 AM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
	require_once ("tool_vars.php");

	$PAGE_NAME = "Institution Edit";
	$Message = "Edit the information below to adjust the institution.<br/>";

	// connect to database
	require "mysqlconnect.php";

	// get the passkey from the cookie if it exists
	$PASSKEY = $_COOKIE["SESSION_ID"];

	// check the passkey
	$USER_PK = 0;
	if (isset($PASSKEY)) {
		$sql1 = "SELECT users_pk FROM sessions WHERE passkey = '$PASSKEY'";
		$result = mysql_query($sql1) or die('Query failed: ' . mysql_error());
		$row = mysql_fetch_assoc($result);

		if( !$result ) {
			// no valid key exists, user not authenticated
			$USER_PK = -1;
		} else {
			// authenticated user
			$USER_PK = $row["users_pk"];
		}
		mysql_free_result($result);
	}

	if( $USER_PK <= 0 ) {
		// no user_pk, user not authenticated
		// redirect to the login page
		header('location:'.$ACCOUNTS_PATH.'login.php?ref='.$_SERVER['PHP_SELF']);
		exit;
	}

	// if we get here, user should be authenticated
	// get the authenticated user information
	$authsql = "SELECT * FROM users WHERE pk = '$USER_PK'";
	$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());
	$USER = mysql_fetch_assoc($result);

	// Make sure user is authorized
	$allowed = 0; // assume user is NOT allowed unless otherwise shown
	$Message = "";
	if (!$USER["admin_insts"]) {
		$allowed = 0;
		$Message = "Only admins with <b>admin_insts</b> may view this page.<br/>" .
			"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
	} else {
		$allowed = 1;
	}
	
	$EXTRA_LINKS = "<br><span style='font-size:9pt;'><a href='admin.php'>Users admin</a> - " .
		"<a href='admin_insts.php'>Institutions admin</a></span>";

	// get the form variables
	$PK = $_REQUEST["pk"];
	if (!$PK) {
		$Message = "You cannot come here without an institution pk set!<br/>";
		$Message .= "<a href='admin_insts.php'>Go back</a>";
		$allowed = 0;
	}
	
	if ($_REQUEST["add"]) {
		print "Adding new inst<br>";
	}

	$SAVE = $_POST["saving"]; // this indicates we are saving values

	$NAME = $_POST["name"];
	$ABBR = $_POST["abbr"];
	$TYPE = $_POST["type"];


	// this matters when the form is submitted
	if ($SAVE) {
		// Check for form completeness
		$errors = 0;
		if (!strlen($NAME)) {
			$Message .= "<span class='error'>Error: Name cannot be blank</span><br/>";
			$errors++;
		}
		if (!strlen($TYPE)) {
			$Message .= "<span class='error'>Error: Type cannot be blank</span><br/>";
			$errors++;
		}

		// check if the name is unique
		$sql_name_check = mysql_query("SELECT pk FROM institution WHERE name='$NAME'");
		$row = mysql_fetch_row($sql_name_check);
		if ($row[0] > 0 && $row[0] != $PK) {
			$Message .= "<span class='error'>Error: This name ($NAME) is already in use.</span><br/>";
			$errors++;
		}
		mysql_free_result($sql_name_check);

		if ($errors == 0) {
			// write the new values to the DB
			$sqledit = "UPDATE institution set name='$NAME', abbr='$ABBR', " .
					"type='$TYPE' where pk='$PK'";

			$result = mysql_query($sqledit) or die('Inst update query failed: ' . mysql_error());
			$Message = "<b>Updated institution information</b><br/>";

			// clear all values
			$NAME = "";
			$ABBR = "";
			$TYPE = "";
		} else {
			$Message = "<div class='error'>Please fix the following errors:\n<blockquote>\n$Message</blockquote>\n</div>\n";
		}
	}


	// get the item information from the DB
	$authsql = "SELECT * FROM institution WHERE pk = '$PK'";
	$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());
	$thisItem = mysql_fetch_assoc($result);

	if (!empty($result)) {
		if (!strlen($NAME)) { $NAME = $thisItem["name"]; }
		if (!strlen($ABBR)) { $ABBR = $thisItem["abbr"]; }
		if (!strlen($TYPE)) { $TYPE = $thisItem["type"]; }
	}
	mysql_free_result($result);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title>
<link href="<?= $CSS_FILE ?>" rel="stylesheet" type="text/css">

<script>
<!--
function focus(){document.editform.name.focus();}

function orderBy(newOrder) {
	if (document.adminform.sortorder.value == newOrder) {
		document.adminform.sortorder.value = newOrder + " desc";
	} else {
		document.adminform.sortorder.value = newOrder;
	}
	document.adminform.submit();
	return false;
}

// -->
</script>

</head>
<body onLoad="focus()">

<? // Include the HEADER -AZ
include 'header.php'; ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include 'footer.php';
		exit;
	}
?>

<i style="font-size:9pt;">All fields are required</i><br/>
<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" name="editform" style="margin:0px;">
<input type="hidden" name="pk" value="<?= $PK ?>">
<input type="hidden" name="add" value="<?= $_REQUEST["add"] ?>">
<input type="hidden" name="saving" value="1">

<table border="0" class="padded">
	<tr>
		<td class="account"><b>Name:</b></td>
		<td><input type="text" name="name" tabindex="1" value="<?= $thisItem["name"] ?>" maxlength="250"></td>
	</tr>
	<tr>
		<td class="account"><b>Abbreviation:</b></td>
		<td><input type="text" name="abbr" tabindex="2" value="<?= $thisItem["abbr"] ?>" maxlength="50"></td>
	</tr>
	<tr>
		<td class="account"><b>Type:</b></td>
		<td><input type="text" name="type" tabindex="3" value="<?= $thisItem["type"] ?>" maxlength="50"></td>
	</tr>

	<tr>
		<td colspan="2">
			<input type="submit" name="account" value="Save information" tabindex="4">
		</td>
	</tr>
</table>

</form>

<?php // Include the FOOTER -AZ
include 'footer.php'; ?>

</body>
</html>