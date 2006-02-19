<?php
	// check if user is logged in, if not then create a new account for them
	// connect to database
	require "mysqlconnect.php";

	// get the passkey from the cookie if it exists
	$PASSKEY = $_COOKIE["SESSION_ID"];

	// check the passkey
	$USER_PK = 0;
	if (isset($PASSKEY)) {
		$sql1 = "SELECT users_pk FROM sessions WHERE passkey = '$PASSKEY'";
		$result = mysql_query($sql1) or die('Query failed: ' . mysql_error());
		$count = mysql_num_rows($result);
		$row = mysql_fetch_assoc($result);

		if( empty($result) || ($count < 1)) {
			// no valid key exists, user not authenticated
			header('location:login.php');
			exit;
		} else {
			// authenticated user
			$USER_PK = $row["users_pk"];
		}
		mysql_free_result($result);
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sakai Requirements Voting - myaccount</title>
<link href="./requirements_vote.css" rel="stylesheet" type="text/css">

<script>
<!--
function focus(){document.filter.searchtext.focus();}
// -->
</script>

</head>
<body onLoad="focus();">

<?php
	$SAVE = $_POST["saving"];

	$EMAIL = $_POST["email"];
	$PASS1 = $_POST["password1"];
	$PASS2 = $_POST["password2"];
	$FIRSTNAME = $_POST["firstname"];
	$LASTNAME = $_POST["lastname"];

	$Message = "Edit the information below to adjust your account.<br/>";

	// this matters when the form is submitted
	if ($SAVE) {
		// Check for form completeness
		$errors = 0;
		if (!strlen($EMAIL)) {
			$Message .= "<span class='error'>Error: Email cannot be blank</span><br/>";
			$errors++;
		}
		if (!strlen($FIRSTNAME)) {
			$Message .= "<span class='error'>Error: First name cannot be blank</span><br/>";
			$errors++;
		}
		if (!strlen($LASTNAME)) {
			$Message .= "<span class='error'>Error: Last name cannot be blank</span><br/>";
			$errors++;
		}

		if ((strlen($PASS1) > 0 || strlen($PASS2) > 0) && ($PASS1 != $PASS2)) {
			$Message .= "<span class='error'>Error: Passwords do not match</span><br/>";
			$errors++;
		}

		if ($errors == 0) {
			// write the new values to the DB

			$passChange = "";
			if (strlen($PASS1) > 0) {
				$passChange = " password=PASSWORD('$PASSWORD'), ";
			}

			$sqledit = "UPDATE users set email='$EMAIL', firstname='$FIRSTNAME', " .
				$passChange . "lastname='$LASTNAME' where pk='$USER_PK'";

			$result = mysql_query($sqledit) or die('Update query failed: ' . mysql_error());
			$Message = "<b>Updated user information</b><br/>";

			// clear all values
			$EMAIL = "";
			$FIRSTNAME = "";
			$LASTNAME = "";
		}
	}


	// get the authenticated user information
	$authsql = "SELECT * FROM users WHERE pk = '$USER_PK'";
	$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());
	$USER = mysql_fetch_assoc($result);

	if (!empty($result)) {
		if (!strlen($EMAIL)) { $EMAIL = $USER["email"]; }
		if (!strlen($FIRSTNAME)) { $FIRSTNAME = $USER["firstname"]; }
		if (!strlen($LASTNAME)) { $LASTNAME = $USER["lastname"]; }
	}
	mysql_free_result($result);

	// Set the page name
	$PAGE_NAME = "My Account";
?>

<? // Include the HEADER -AZ
include 'header.php'; ?>

<?= $Message ?>

<i style="font-size:9pt;">All fields are required</i><br/>
<form action="myaccount.php" method="post" name="account" style="margin:0px;">
<input type="hidden" name="saving" value="1">
<table border="0" class="padded">
	<tr>
		<td class="account"><b>Username:</b></td>
		<td><?= $USER["username"] ?></td>
	</tr>
	<tr>
		<td class="account"><b>Password:</b></td>
		<td><input type="password" name="password1" tabindex="2" maxlength="50"></td>
	</tr>
	<tr>
		<td class="account"><b>Confirm password:</b></td>
		<td><input type="password" name="password2" tabindex="3" maxlength="50"></td>
	</tr>
	<tr>
		<td class="account"><b>First name:</b></td>
		<td><input type="text" name="firstname" tabindex="4" value="<?= $FIRSTNAME ?>" size="40" maxlength="50"></td>
	</tr>
	<tr>
		<td class="account"><b>Last name:</b></td>
		<td><input type="text" name="lastname" tabindex="5" value="<?= $LASTNAME ?>" size="40" maxlength="50"></td>
	</tr>
	<tr>
		<td class="account"><b>Email:</b></td>
		<td><input type="text" name="email" tabindex="6" value="<?= $EMAIL ?>" size="50" maxlength="50"></td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="submit" name="account" value="Save information" tabindex="6">
			<input type="button" value="Back" onClick="javascript:history.go(-1);return false;" tabindex="7">
		</td>
	</tr>
</table>
</form>

<span style="font-size:9pt;">
	<b>Note:</b> <i>To change your password, enter the new values in the fields above.<br/>
	To leave your password at it's current value, leave the password fields blank.</i>
</span>
<br/>

<? // Include the FOOTER -AZ
include 'footer.php'; ?>

</body>
</html>