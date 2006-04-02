<?
require_once 'include/tool_vars.php';

// This is the forgot password or username script
$PAGE_NAME = "Forgot Password";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require 'include/check_authentic.php';

// get POST var
$email = mysql_real_escape_string($_POST['email']);

$errors = 0;
$Message = "Please enter your email address below and your username and a new password will be emailed to you.<br/>";
if (!$email) {
    $errors++;
}

// quick check to see if email exists
$thisUser = new User();
if ($errors == 0) {
	$thisUser->getUserByEmail($email);
	if ($thisUser->pk == 0) {
		$Message = "<span class='error'>That email address does not exist in the system.</span><br />";
		$errors++;
	}
}

if ($errors == 0) {
	$random_password = makeRandomPassword();
	$thisUser->setPassword($random_password);
	$thisUser->save();

	writeLog($TOOL_SHORT,$_SERVER["REMOTE_ADDR"],"password reset: $email");

	$subject = "$TOOL_NAME password reset";
	$mail_message = "Hi, we have reset your password.

Username: $thisUser->username
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
	mail($email, $subject, $mail_message, $headers);

	$Message = "Your username and new password have been sent to $email! Please check your email!<br />" .
		"You can change your password in My Account after you login.<br/>";

	// For testing only -AZ
	//$Message .= "<br/>Subject: $subject<br><pre>$message</pre><br>";
}
?>

<?php include 'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<script type="text/javascript">
<!--
window.onload = doFocus;

function doFocus() {
	document.resetpass.email.focus();
}
// -->
</script>
<?php include 'include/header.php'; // INCLUDE THE HEADER ?>

<?= $Message ?>

	<i style="font-size:9pt;">All fields are required</i><br/>
	<form action="forgot_password.php" method="post" name="resetpass" style="margin:0px;">
	<input type="hidden" name="saving" value="1"/>
	<table border="0" class="padded">
		<tr>
			<td class="account"><b>Email:</b></td>
			<td><input type="text" name="email" tabindex="6" value="<?= $email ?>" size="50" maxlength="50"/></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" name="account" value="Reset password" tabindex="6"/>
			</td>
		</tr>
	</table>
	</form>



<?php include 'include/footer.php'; // Include the FOOTER ?>