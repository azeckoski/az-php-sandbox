<?php
	require_once ("tool_vars.php");

	// Allow user to modify account settings
	$PAGE_NAME = "My Account";

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

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title>
<link href="./accounts.css" rel="stylesheet" type="text/css">

<script>
<!--
function focus(){document.account.firstname.focus();}
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
	$INSTITUTION_PK = $_POST["institution_pk"];

	$Message = "";

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

		// verify that the email address is valid
		if(!eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$', $EMAIL)) {
			$Message .= "<span class='error'>Error: You have entered an invalid email address!</span><br/>";
			$errors++;
	        unset($EMAIL);
		}

		$sql_email_check = mysql_query("SELECT email FROM users WHERE email='$EMAIL' and pk != '$USER_PK'");
		$email_check = mysql_num_rows($sql_email_check);
		if ($email_check > 0) {
			$Message .= "<span class='error'>Error: The new email address you have chosen ($EMAIL) is already in use.</span><br/>";
			$errors++;
		}

		if ($errors == 0) {
			// write the new values to the DB
			$Message = "Edit the information below to adjust your account.<br/>";
			$passChange = "";
			if (strlen($PASS1) > 0) {
				$passChange = " password=PASSWORD('$PASS1'), ";
			}

			$sqledit =
					"UPDATE users set email='$EMAIL', " .
					"firstname='$FIRSTNAME', " . $passChange .
					"lastname='$LASTNAME', institution_pk='$INSTITUTION_PK' " .
					"where pk='$USER_PK'";

			$result = mysql_query($sqledit) or die('Update query failed: ' . mysql_error());
			$Message = "<b>Updated user information</b><br/>";

			// clear all values
			$EMAIL = "";
			$FIRSTNAME = "";
			$LASTNAME = "";
			$INSTITUTION_PK = "";
		} else {
			$Message = "<div class='error'>Please fix the following errors:\n<blockquote>\n$Message</blockquote>\n</div>\n";
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
		if (!strlen($INSTITUTION_PK)) { $INSTITUTION_PK = $USER["institution_pk"]; }
	}
	mysql_free_result($result);
?>

<?
// Include the HEADER -AZ
include 'header.php';

// generate the institution drop down based on the information returned
$institutionDropdownText = generate_partner_dropdown($INSTITUTION_PK);

?>

<?= $Message ?>

<i style="font-size:9pt;">All fields are required</i><br/>
<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" name="account" style="margin:0px;">
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
		<td class="account"><b>Institution:</b></td>
		<td>
		  <select name="institution_pk" tabindex="7">
		  	<option value=''> --Select Your Organization-- </option>
			<?= $institutionDropdownText?>
		  </select>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="submit" name="account" value="Save information" tabindex="8">
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