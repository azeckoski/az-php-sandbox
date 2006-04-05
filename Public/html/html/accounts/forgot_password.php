<?
require_once 'include/tool_vars.php';

// This is the forgot password or username script
$PAGE_NAME = "Forgot Password";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require 'include/check_authentic.php';

// get POST var
$EMAIL = stripslashes($_POST['email']);

$errors = 0;
$Message = "Please enter your email address and your username and a new password will be emailed to you.<br/>";
if (!$EMAIL) {
    $errors++;
}

// quick check to see if email exists
$USERNAME = "UNKNOWN";
if ($errors == 0) {
	$sql_check = mysql_query("SELECT username FROM users WHERE email='$EMAIL'")
		or die('User email check failed: ' . mysql_error());
	$sql_check_num = mysql_num_rows($sql_check);
	if ($sql_check_num == 0) {
		$Message = "<span class='error'>That email address does not exist in the system.</span><br />";
		$errors++;
	} else {
		// put username in variable
		$row = mysql_fetch_row($sql_check);
		$USERNAME = $row[0];
	}
}

if ($errors == 0) {
	$random_password = makeRandomPassword();

	$sql = mysql_query("UPDATE users SET password=PASSWORD('$random_password') WHERE email='$EMAIL'")
			or die('User password reset failed: ' . mysql_error());

	writeLog($TOOL_SHORT,$_SERVER["REMOTE_ADDR"],"password reset: $EMAIL");

	$subject = "$TOOL_NAME password reset";
	$mail_message = "Hi, we have reset your password.

Username: $USERNAME
New Password: $random_password

Login using the URL below:\n".
$SERVER_NAME.$TOOL_PATH."/login.php

You can change your password in My Account after you login.

Thanks!
$TOOL_NAME automatic mailer

This is an automated response, please do not reply!";

	ini_set(SMTP, $MAIL_SERVER);
    $headers  = 'From: ' . $HELP_EMAIL . "\n";
	$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
	$headers .= 'MIME-Version: 1.0' ."\n";
	$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";
	mail($EMAIL, $subject, $mail_message, $headers);

	$Message = "Your username and new password have been sent to $EMAIL! Please check your email!<br />" .
		"You can change your password in My Account after you login.<br/>";

	// For testing only -AZ
	//$Message .= "<br/>Subject: $subject<br><pre>$message</pre><br>";
}
?>

<? include 'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<script>
<!--
// -->
</script>
<? include 'include/header.php'; // INCLUDE THE HEADER ?>

<?= $Message ?>

	<i style="font-size:9pt;">All fields are required</i><br/>
	<form action="forgot_password.php" method="post" name="resetpass" style="margin:0px;">
	<input type="hidden" name="saving" value="1">
	<table border="0" class="padded">
		<tr>
			<td class="account"><b>Email:</b></td>
			<td><input type="text" name="email" tabindex="6" value="<?= $EMAIL ?>" size="50" maxlength="50"></td>
			<script>document.resetpass.email.focus();</script>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" name="account" value="Reset password" tabindex="6">
			</td>
		</tr>
	</table>
	</form>



<? include 'include/footer.php'; // Include the FOOTER ?>