<?require_once 'include/tool_vars.php';

// This is the forgot password or username script
$PAGE_NAME = "Forgot Password";
$ACTIVE_MENU="ACCOUNTS";  //for managing active links on multiple menus

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require 'include/check_authentic.php';

// get POST var
$email = mysql_real_escape_string($_POST['email']);

$errors = 0;
$Message = "Please enter your email address below then click on the <strong>Submit</strong> button.<br/> A new password will be emailed to you.<br/>";
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

	$subject = "Sakai Web Account- User Account password reset";
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
	@mail($email, $subject, $mail_message, $headers);

	$Message = "<span>Your username and new password have been sent to $email! Please check your email!<br />" .
		"You can change your password in My Account after you login.<br/><br/></span>";

	// For testing only -AZ
	//$Message .= "<br/>Subject: $subject<br><pre>$message</pre><br>";
}
// top header links
$EXTRA_LINKS = "<span class='extralinks'>";
	$EXTRA_LINKS .= "<a class='active' href='$CONFADMIN_URL/index.php' title='Sakai accounts home'><strong>Home</strong></a>:";

$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/registration/index.php'>Register</a>" .
"<a href='$CONFADMIN_URL/proposals/index.php'>Call for Proposals</a>" ;
if ($SCHEDULE_PUBLISHED) { 
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
		 }  else {
		 		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/draft_schedule.php'>Schedule</a>";
	
		 	
		 }
	
	$EXTRA_LINKS.="</span>";
	
?>

<?php //// INCLUDE THE HEADER
 include 'include/top_header.php'; ?>
<script type="text/javascript">
<!--
window.onload = doFocus;

function doFocus() {
	document.resetpass.email.focus();
}
// -->
</script>
<?php include 'include/header.php'; 
 ?><div id="maincontent">
	
	<form action="forgot_password.php" method="post" name="resetpass" style="margin:0px;">
	<input type="hidden" name="saving" value="1"/>
	<table border="0" class="padded">
		<tr>
		<td valign="top">
			<div class="login">
			<div class="rightheader">Forgotten password</div>
				<table border="0" class="padded" width="50%">
				<tr><td colspan="2" class="account"><?= $Message ?><br/><br/></td>
				</tr>
				<tr>
				<td class="account" width="160px"><b>Email:</b></td>
						<td><input type="text" name="email" tabindex="6" value="<?= $email ?>" size="50" maxlength="50"/></td>
					</tr>
				<tr>
					<td colspan="2" style="text-align:right; padding-left: 50px;"><br/>
						<input style="font-size:.9em;" id="submitbutton" type="submit" name="account" value="Submit" tabindex="6"/>
					</td>
				</tr>
				</table>
			</div>	
		</td>
		</tr>
	</table>
	</form>

</div>
<div class="padding50"></div>
<div class="padding50"></div>
<?php include 'include/footer.php'; // Include the FOOTER ?>