<?php
	require_once ("tool_vars.php");

	// Account Creation - check if user is logged in, if not then create a new account for them
	$PAGE_NAME = "Create Account";

	// connect to database
	require "mysqlconnect.php";

	// check authentication
	require "check_authentic.php";


	// if logged in, kick over to my account instead
	if ($USER_PK) {
		header('location:'.$ACCOUNTS_PATH.'myaccount.php');
		exit;
	}

	// process POST vars
	$SAVE = $_POST["saving"];

	$USERNAME = stripslashes($_POST["username"]);
	$PASS1 = stripslashes($_POST["password1"]);
	$PASS2 = stripslashes($_POST["password2"]);
	$FIRSTNAME = stripslashes($_POST["firstname"]);
	$LASTNAME = stripslashes($_POST["lastname"]);
	$EMAIL = stripslashes($_POST["email"]);
	$INSTITUTION_PK = stripslashes($_POST["institution_pk"]);

	$Message = "<a href='login.php'>Login if you already have an account</a><br/>";
	$Message .= "If you need to create an account, enter your information below.<br/>";

	// this matters when the form is submitted
	$created = 0;
	if ($SAVE) {
		// Check for form completeness
		$Message = "";
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
		if (!strlen($INSTITUTION_PK)) {
			$Message .= "<span class='error'>Error: Institution must be selected</span><br/>";
			$errors++;
		}

		if ((strlen($PASS1) > 0 || strlen($PASS2) > 0) && ($PASS1 != $PASS2)) {
			$Message .= "<span class='error'>Error: Passwords do not match</span><br/>";
			$errors++;
		}

		if ($errors == 0) {
			// verify that the email address is valid
			if(!eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$', $EMAIL)) {
				$Message .= "<span class='error'>Error: You have entered an invalid email address!</span><br/>";
				$errors++;
		        unset($EMAIL);
			}
		}

		if ($errors == 0) {
			// check to see if username or email already exists in the system
			$sql_email_check = mysql_query("SELECT email FROM users WHERE email='$EMAIL'");
			$sql_username_check = mysql_query("SELECT username FROM users WHERE username='$USERNAME'")
				or die('Username check failed: ' . mysql_error());

			$email_check = mysql_num_rows($sql_email_check);
			$username_check = mysql_num_rows($sql_username_check);

			if(($email_check > 0) || ($username_check > 0)){
			    $Message .= "<div class='error'>Please fix the following errors:\n<blockquote>";
			    if($email_check > 0){
			        $Message .= "This email address is already in use. Please submit a different Email address!<br />";
			        unset($EMAIL);
			    }
			    if($username_check > 0){
			        $Message .= "The username you have selected is already taken. Please choose a different Username!<br />";
			        unset($USERNAME);
			    }
			    $Message .= "</blockquote></div>";
			    $errors++;
			}
		}

		if ($errors == 0) {
			// write the new values to the DB
			$sqledit = "INSERT INTO users (username,password,firstname,lastname,email,institution_pk) values " .
				"('$USERNAME',PASSWORD('$PASS1'),'$FIRSTNAME','$LASTNAME','$EMAIL','$INSTITUTION_PK')";

			$result = mysql_query($sqledit) or die('User creation failed: ' . mysql_error());
			$userPk = mysql_insert_id();

			$Message = "<b>New user account created</b><br/>" .
				"An email has been sent to $EMAIL.<br/>" .
				"Use the link in the email to activate your account.<br/>";
			$created = 1;
			
			// log account creation
			writeLog($TOOL_SHORT,$_SERVER["REMOTE_ADDR"],"created account: $USERNAME ($EMAIL) " .
					"$LASTNAME,$FIRSTNAME inst=$INSTITUTION_PK");
			
			// bring in the activation email sending form
			include ("activation_email.php");
		}
	}
?>

<? include 'top_header.php'; // INCLUDE THE HTML HEAD ?>
<script>
<!--
// -->
</script>
<? include 'header.php'; // INCLUDE THE HEADER ?>

<?= $Message ?>

<?php if (!$created) {
	$institutionDropdownText = generate_partner_dropdown($INSTITUTION_PK);
?>

	<span style="font-style:italic;font-size:9pt;">All fields are required</span><br/>
	<form action="createaccount.php" method="post" name="adminform" style="margin:0px;">
	<input type="hidden" name="saving" value="1">
	<table border="0" class="padded">
		<tr>
			<td class="account"><b>Username:</b></td>
			<td><input type="text" name="username" tabindex="1" value="<?= $USERNAME ?>" maxlength="30"></td>
			<script>document.adminform.username.focus();</script>
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
			<td>
			<select name="institution_pk" tabindex="7">
				<option value=''> --Select Your Organization--</option>
				<?= $institutionDropdownText?>
			</select>
			</td>
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

<? include 'footer.php'; // Include the FOOTER ?>