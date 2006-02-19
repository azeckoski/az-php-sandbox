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
			$USER_PK = 0;
		} else {
			// authenticated user
			$USER_PK = $row["users_pk"];
			header('location:myaccount.php');
		}
		mysql_free_result($result);
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sakai Requirements Voting - login</title>
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

	$USERNAME = $_POST["username"];
	$PASS1 = $_POST["password1"];
	$PASS2 = $_POST["password2"];
	$FIRSTNAME = $_POST["firstname"];
	$LASTNAME = $_POST["firstname"];
	$EMAIL = $_POST["email"];

	$Message = "<a href='login.php'>Login if you already have an account</a><br/>";
	$Message .= "If you need to create an account, enter your information below.<br/>";

	// this matters when the form is submitted
	if ($SAVE) {
		// Check for form completeness
		$errors = 0;
		if (!strlen($USERNAME)) {
			$Message .= "<span class='error'>Error: Username cannot be blank</span><br/>";
			$errors++;
		}
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
		if (!strlen($PASS1) || !strlen($PASS2)) {
			$Message .= "<span class='error'>Error: Password cannot be blank</span><br/>";
			$errors++;
		}

		if ((strlen($PASS1) > 0 || strlen($PASS2) > 0) && ($PASS1 != $PASS2)) {
			$Message .= "<span class='error'>Error: Passwords do not match</span><br/>";
			$errors++;
		}

		if ($errors == 0) {
			// write the new values to the DB

			$sqledit = "INSERT INTO users (username,password,firstname,lastname,email) values " .
				"('$USERNAME',PASSWORD('$PASSWORD'),'$FIRSTNAME','$LASTNAME','$EMAIL')";

			$result = mysql_query($sqledit) or die('Update query failed: ' . mysql_error());
			$Message = "<b>New user account created</b><br/>";

			// tell use they will get a confirmation email

			// send an email to the new user with a confirmation URL

		}
	}

	// Set the page name
	$PAGE_NAME = "Create Account";
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
		<td><input type="text" name="username" tabindex="1" value="<?= $USERNAME ?>" maxlength="30"></td>
	</tr>
	<tr>
		<td class="account"><b>Password:</b></td>
		<td><input type="password" name="password1" tabindex="2" maxlength="30"></td>
	</tr>
	<tr>
		<td class="account"><b>Confirm password:</b></td>
		<td><input type="password" name="password2" tabindex="3" maxlength="30"></td>
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
		</td>
	</tr>
</table>
</form>

<span style="font-size:9pt;">
	<b>Note:</b> <i>Your user information is private and will only be used in this system.
	It will not be given to anyone else. Passwords are not stored as plain text in the database.</i>
</span>
<br/>

<? // Include the FOOTER -AZ
include 'footer.php'; ?>

</body>
</html>