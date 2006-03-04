<?
	require_once ("tool_vars.php");

	// This is the forgot password or username script
	$PAGE_NAME = "Forgot Password";

	// connect to database
	require "mysqlconnect.php";

	// get the passkey from the cookie if it exists
	$PASSKEY = $_COOKIE["SESSION_ID"];

	// check the passkey
	$USER_PK = 0;
	$USER = array();
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
			$authsql = "SELECT * FROM users WHERE pk = '$USER_PK'";
			$result = mysql_query($authsql) or die('User query failed: ' . mysql_error());
			$USER = mysql_fetch_assoc($result);
		}
		mysql_free_result($result);
	}
		
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

    // Generate password, update db, and send email
    function makeRandomPassword() {
          $salt = "abchefghjkmnpqrstuvwxyz0123456789";
          srand((double)microtime()*1000000);
          $i = 0;
          while ($i <= 7) {
                $num = rand() % 33;
                $tmp = substr($salt, $num, 1);
                $pass = $pass . $tmp;
                $i++;
          }
          return $pass;
    }

	if ($errors == 0) {
		$random_password = makeRandomPassword();

		$sql = mysql_query("UPDATE users SET password=PASSWORD('$random_password') WHERE email='$EMAIL'")
				or die('User password reset failed: ' . mysql_error());

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
		$headers .= 'To: ' . $EMAIL . "\n";
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title>
<link href="./accounts.css" rel="stylesheet" type="text/css">

<script>
<!--
function focus(){document.resetpass.email.focus();}
// -->
</script>

</head>
<body onLoad="focus();">

<? // Include the HEADER -AZ
include 'header.php'; ?>

<?= $Message ?>

	<i style="font-size:9pt;">All fields are required</i><br/>
	<form action="forgot_password.php" method="post" name="resetpass" style="margin:0px;">
	<input type="hidden" name="saving" value="1">
	<table border="0" class="padded">
		<tr>
			<td class="account"><b>Email:</b></td>
			<td><input type="text" name="email" tabindex="6" value="<?= $EMAIL ?>" size="50" maxlength="50"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" name="account" value="Reset password" tabindex="6">
			</td>
		</tr>
	</table>
	</form>

<? // Include the FOOTER -AZ
include 'footer.php'; ?>

</body>
</html>