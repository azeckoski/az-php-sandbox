<?php
/*
 * file: activation_email.php
 * Created on Mar 4, 2006 2:54:38 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
        // generate a unique identifier based on the user_pk
        $myActivationCode = substr(md5($USERNAME),0,10);

		// send an email to the new user with a confirmation URL
		$subject = "$TOOL_NAME account";
		$mail_message = "Dear $FIRSTNAME $LASTNAME,\n" .
				"Thank you for registering at our website, $SERVER_NAME.\n\n" .
				"You are two steps away from logging in and accessing the $TOOL_NAME system.\n\n" .
				"To activate your membership, please click here:\n\n" .
				"$SERVER_NAME$TOOL_PATH/activate.php?id=$PK&code=$myActivationCode&end=1\n\n" .
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
        	$headers  = 'From: ' . $HELP_EMAIL . "\n";
		$headers .= 'To: ' . $EMAIL . "\n";
		$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
		$headers .= 'MIME-Version: 1.0' ."\n";
		$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";
		mail($EMAIL, $subject, $mail_message, $headers);
?>