<?php
	require_once ("tool_vars.php");

	// Account Creation - check if user is logged in, if not then create a new account for them
	$PAGE_NAME = "Create Account";

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
<title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title>
<link href="./accounts.css" rel="stylesheet" type="text/css">

<script>
<!--
function focus(){document.account.username.focus();}
// -->
</script>

</head>
<body onLoad="focus();">

<?php
	$SAVE = $_POST["saving"];

	$USERNAME = stripslashes($_POST["username"]);
	$PASS1 = stripslashes($_POST["password1"]);
	$PASS2 = stripslashes($_POST["password2"]);
	$FIRSTNAME = stripslashes($_POST["firstname"]);
	$LASTNAME = stripslashes($_POST["lastname"]);
	$EMAIL = stripslashes($_POST["email"]);

	$Message = "<a href='login.php'>Login if you already have an account</a><br/>";
	$Message .= "If you need to create an account, enter your information below.<br/>";

	// this matters when the form is submitted
	$created = 0;
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
			// check to see if username or email already exists in the system
			$sql_email_check = mysql_query("SELECT email FROM users WHERE email='$EMAIL'");
			$sql_username_check = mysql_query("SELECT username FROM users WHERE username='$USERNAME'")
				or die('Username check failed: ' . mysql_error());

			$email_check = mysql_num_rows($sql_email_check);
			$username_check = mysql_num_rows($sql_username_check);

			if(($email_check > 0) || ($username_check > 0)){
			    $displayMessage .= "<div class='error'>Please fix the following errors:\n<blockquote>";
			    if($email_check > 0){
			        $displayMessage .= "This email address is already in use. Please submit a different Email address!<br />";
			        unset($EMAIL);
			    }
			    if($username_check > 0){
			        $displayMessage .= "The username you have selected is already taken. Please choose a different Username!<br />";
			        unset($USERNAME);
			    }
			    $displayMessage .= "</blockquote></div>";
			    $errors++;
			}
		}

		if ($errors == 0) {
			// write the new values to the DB
			$sqledit = "INSERT INTO users (username,password,firstname,lastname,email) values " .
				"('$USERNAME',PASSWORD('$PASS1'),'$FIRSTNAME','$LASTNAME','$EMAIL')";

			$result = mysql_query($sqledit) or die('User creation failed: ' . mysql_error());
			$user_pk = mysql_insert_id();

            // generate a unique identifier based on the user_pk
            $myActivationCode = base64_encode($USERNAME);

			$displayMessage = "<b>New user account created</b><br/>" .
				"An email has been sent to $EMAIL.<br/>" .
				"Use the link in the email to activate your account.<br/>";
			$created = 1;

			// send an email to the new user with a confirmation URL
			$subject = "$TOOL_NAME account";
			$message = "Dear $FIRSTNAME $LASTNAME,\n" .
					"Thank you for registering at our website, $SERVER_NAME.\n\n" .
					"You are two steps away from logging in and accessing the $TOOL_NAME system.\n\n" .
					"To activate your membership, please click here:\n\n" .
					"$SERVER_NAME$TOOL_PATH/activate.php?id=$user_pk&code=$myActivationCode\n\n" .
					"Once you activate your membership, you will be able to log in with the following\n" .
					"information:\n\n" .
					"Username: $USERNAME\n" .
					"Password: (not shown)\n\n" .
					"Thanks!\n" .
					"$TOOL_NAME Account Creation System\n\n" .
					"==\nThis is an automated response, please do not reply!";

			// For testing only -AZ
			//print ("Subject: $subject<br><pre>$message</pre><br>");
            ini_set(SMTP, $MAIL_SERVER);
			mail($EMAIL, $subject, $message,
				"From: $HELP_EMAIL\r\nX-Mailer: PHP/" . phpversion());
		}
	}

?>

<? // Include the HEADER -AZ
include 'header.php'; ?>

<?= $displayMessage ?>

<?php if (!$created) {

	$institutionDropdownText = generate_partner_dropdown();
	?>


	<span style="font-style:italic;font-size:9pt;">All fields are required</span><br/>
	<form action="createaccount.php" method="post" name="account" style="margin:0px;">
	<input type="hidden" name="saving" value="1">
	<table border="0" class="padded">
		<tr>
			<td class="account"><b>Username:</b></td>
			<td><input type="text" name="username" tabindex="1" value="<?= $USERNAME ?>" maxlength="30"></td>
		</tr>
		<tr>
			<td class="account"><b>Password:</b></td>
			<td><input type="password" name="password1" tabindex="2" value="<?= $PASS1 ?>" maxlength="30"></td>
		</tr>
		<tr>
			<td class="account"><b>Confirm password:</b></td>
			<td><input type="password" name="password2" tabindex="3" value="<?= $PASS2 ?>" maxlength="30"></td>
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
			<td><?= $institutionDropdownText?></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" name="account" value="Create Account" tabindex="8">
			</td>
		</tr>
	</table>
	</form>

<span style="font-size:9pt;">
	<b>Note:</b> <i>Your user information is private and will only be used in this system.<br/>
	It will not be given to anyone else. Passwords are not stored as plain text in the database.</i>
</span>
<br/>

<?php } ?>


<? // Include the FOOTER -AZ
include 'footer.php'; ?>

</body>
</html>