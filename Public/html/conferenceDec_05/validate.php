<?php # register.php

if (isset($HTTP_POST_VARS[Submit])) { // If the form was submitted, process it.

	// Check the username.	
	if (eregi ("^[[:alnum:]]+$", $HTTP_POST_VARS[username])) {
		$a = TRUE;
	} else {
		$a = FALSE;
		$message[] = "Please enter a username that consists only of letters and numbers.";
	}
	
	// Check to make sure the password is long enough and of the right format. 
	if (eregi ("^[[:alnum:]]{8,16}$", $HTTP_POST_VARS[pass1])) {
			$b = TRUE;
	} else {
			$b = FALSE;
			$message[] = "Please enter a password that consists only of letters and numbers, between 8 and 16 characters long.";	
	}

	// Check to make sure the password matches the confirmed password. 
	if ($HTTP_POST_VARS[pass1] == $HTTP_POST_VARS[pass2]) {
			$c = TRUE;
			$password = crypt ($HTTP_POST_VARS[pass1]); // Encrypt the password.
	} else {
			$c = FALSE;
			$message[] = "The password you entered did not match the confirmed password.";	
	}
	
	// Check to make sure they entered their first name and it's of the right format. 
	if (eregi ("^([[:alpha:]]|-|')+$", $HTTP_POST_VARS[first_name])) { 
			$d = TRUE;
	} else {
			$d = FALSE;
			$message[] = "Please enter a valid first name.";
	}
	
	// Check to make sure they entered their last name and it's of the right format. 
	if (eregi ("^([[:alpha:]]|-|')+$", $HTTP_POST_VARS[last_name])) { 
			$e = TRUE;
	} else {
			$e = FALSE;
			$message[] = "Please enter a valid last name.";
	}
	
	// Check to make sure they entered a valid email address. 
	if (eregi("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $HTTP_POST_VARS[email])) { 
			$f = TRUE;
	} else {
			$f = FALSE;
			$message[] = "Please enter a valid email address.";
	}
	// Check to make sure the email matches the confirmed email. 
	if ($HTTP_POST_VARS[email1] == $HTTP_POST_VARS[email2]) {
			$c = TRUE;
	} else {
			$k = FALSE;
			$message[] = "The email you entered did not match the confirmed password.";	
	}
	
	// Check to make sure they entered a valid birth date.
	if (checkdate ($HTTP_POST_VARS[birth_month], $HTTP_POST_VARS[birth_day], $HTTP_POST_VARS[birth_year])) { 
			$g = TRUE;
	} else {
			$g = FALSE;
			$message[] = "Please enter a valid birth date.";
	}
	
	//  If the data passes all the tests, check to ensure a unique member name, then register them. 
	if ($a AND $b AND $c AND $d AND $e AND $f AND $g) {
	
		if ($fp = @fopen ("../users.txt", "r")) { // Open the file for reading.
			
			while ( !feof($fp) AND !$user_found ) { // Loop through each line, checking each username.
				$read_data = fgetcsv ($fp, 1000, "\t"); // Read the line into an array.
				if ($read_data[0] == $HTTP_POST_VARS[username]) {
					$user_found = TRUE;
				}
			}
			fclose ($fp); // Close the file.
			
			if (!$user_found) { // If the username is okay, register them.
			
				if ($fp2 = @fopen ("../users.txt", "a")) { // Open the file for writing.
					$write_data = $HTTP_POST_VARS[username] . "\t" . $password . "\t" . $HTTP_POST_VARS[first_name] . "\t" . $HTTP_POST_VARS[last_name] . "\t" . $HTTP_POST_VARS[email] . "\t" . $HTTP_POST_VARS[birth_month] . "-" . $HTTP_POST_VARS[birth_day] . "-" . $HTTP_POST_VARS[birth_year] . "\n";
					fwrite ($fp2, $write_data); 
					fclose ($fp2);
					$message = urlencode ("You have been successfully registered.");
					header ("Location: homepage.php?message=$message"); // Send them on their way.
					exit;
				} else {
					$message[] = "Could not register to the user's file! Please contact the Webmaster for more information.<br />";			
				}
			} else {
				$message[] = "That username is already taken. Please select another.";			
			}
			
		} else { // If it couldn't open the file, print an error message.
			$message[] = "Could not read the user,s file! Please contact the Webmaster for more information.<br />";
		}
	} 
 

} // End of Submit if.
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Register</title>
</head>
<body>
<?php
// Print out any error messages.
if ($message) {
	echo "<div align=\"left\"><font color=red><b>The following problems occurred:</b><br />\n";	
	foreach ($message as $key => $value) {
		echo "$value <br />\n";	
	}
	echo "<p></p><b>Be sure to reenter your passwords and your birth date!</b></font></div><br />\n";	
}
?>
<form action="validate.php" method="post">
<table border="0" width="90%" cellspacing="2" cellpadding="2" align="center">
	<tr>
		<td align="right">Name</td>
		<td align="left"><input type="text" name="username" size="25" maxsize="16" value="<?=$HTTP_POST_VARS[username] ?>"></td>
		<td align="left"><small>Maximum of 16 characters, stick to letters and numbers, no spaces, underscores, hyphens, etc.</small></td>
	</tr>
	<tr>
		<td align="right">Password</td>
		<td align="left"><input type="password" name="pass1" size="25"></td>
		<td align="left"><small>Minimum of 8 characters, maximum of 16, stick to letters and numbers, no spaces, underscores, hyphens, etc.</small></td>
	</tr>
	<tr>
		<td align="right">Confirm Password</td>
		<td align="left"><input type="password" name="pass2" size="25"></td>
		<td align="left"><small>Should be the same as the password.</small></td>
	</tr>
	<tr>
		<td align="right">First Name</td>
		<td align="left"><input type="text" name="first_name" size="25" maxsize="20" value="<?=$HTTP_POST_VARS[first_name] ?>"></td>
		<td align="left">&nbsp;</td>
	</tr>
	<tr>
		<td align="right">Last Name</td>
		<td align="left"><input type="text" name="last_name" size="25" maxsize="20" value="<?=$HTTP_POST_VARS[last_name] ?>"></td>
		<td align="left">&nbsp;</td>
	</tr>
	<tr>
		<td align="right">Email Address</td>
		<td align="left"><input type="text" name="email" size="25" maxsize="60" value="<?=$HTTP_POST_VARS[email] ?>"></td>
		<td align="left"><small>Use whichever email address you want to receive notices at.</small></td>
	</tr>
	<tr>
		<td align="right">Email Address</td>
		<td align="left"><input type="text" name="email2" size="25" maxsize="60" value="<?=$HTTP_POST_VARS[email] ?>"></td>
		<td align="left"><small>Use whichever email address you want to receive notices at.</small></td>
	</tr>
	<tr>
		<td align="right">Birth date</td>
		<td align="left" colspan="2">
<?php 
echo '<select name="birth_month">
<option value="">Month</option>
';
for ($n = 1; $n <= 12; $n++) {
	echo "<option value=\"$n\">$n</option>\n";
}
echo '</select>
<select name="birth_day">
<option value="">Day</option>
';
for ($n = 1; $n <= 31; $n++) {
	echo "<option value=\"$n\">$n</option>\n";
}
echo '</select>
<select name="birth_year">
<option value="">Year</option>
';
for ($n = 1900; $n <= 2001; $n++) {
	echo "<option value=\"$n\">$n</option>\n";
}
?>
		</select></td>
	</tr>
	<tr>
		<td align="center" colspan="3"><input type="submit" name="Submit" value="Register!"> &nbsp; &nbsp; &nbsp; <input type="reset" name="Reset" value="Reset"></td>
	</tr>
</table>
</form>
</body>
</html>