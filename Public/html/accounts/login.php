<?php
	require_once ("tool_vars.php");

	// Handle the login process or display a login page
	$PAGE_NAME = "Login";

	// connect to database
	require "mysqlconnect.php";

	// Clear the current session cookie
	setcookie("SESSION_ID", "NULL", null, "/", false, 0);

	// Pass along the referrer
	$REF = $_REQUEST["ref"]; // This is the refering page

	// reset message
	$Message = "";

	// Get the username and password (force username to lowercase)
	$USERNAME = strtolower($_POST["username"]);
	$PASSWORD = stripslashes($_POST["password"]);

	// check the username/password to auth if present
	if (strlen($USERNAME) && strlen($PASSWORD)) {
		// check the username and password
		$sql1 = "SELECT pk FROM users WHERE username = '$USERNAME' and " .
			"password = PASSWORD('$PASSWORD') and activated = '1'";
		$result = mysql_query($sql1) or die('Query failed: ' . mysql_error());
		$count = mysql_num_rows($result);
		$row = mysql_fetch_assoc($result);

		if( !empty($result) && ($count == 1)) {
			// valid login
			$Message = "Valid login: $USERNAME <br/>";
			$user_pk = $row["pk"];

			// delete all sessions related to this user
			$sql2 = "DELETE FROM sessions WHERE users_pk = '$user_pk'";
			$result = mysql_query($sql2) or die('Query failed: ' . mysql_error());

			$cookie_val = md5($row["pk"] . time() . mt_rand() );
			// create session cookie, this should last until the user closes the browser
			setcookie("SESSION_ID", $cookie_val, null, "/", false, 0);

			// add user to sessions table
			$sql3 = "insert into sessions (users_pk, passkey) values ('$user_pk', '$cookie_val')";
			$result = mysql_query($sql3) or die('Query failed: ' . mysql_error());

			// log the login
			writeLog($TOOL_SHORT,$USERNAME,"user logged in:" . $_SERVER["REMOTE_ADDR"].":".$_SERVER["HTTP_REFERER"]);

			// redirect after login -AZ
			//print "ref = $REF<br/>";
			if ($REF) {
				header('location:'.$REF);
			} else {
				header('location:index.php');
			}

		} else {
			// user/pass combo not found
			$Message = "<span class='error'>Invalid login: $USERNAME </span><br/>" .
				"Please check your username and password and make sure your account is activated.";

			// Clear the current session cookie
			setcookie("SESSION_ID", "NULL", null, "/", false, 0);
		}
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title>
<link href="<?= $CSS_FILE ?>" rel="stylesheet" type="text/css">

<script>
<!--
function focus(){document.login.username.focus();}
// -->
</script>

</head>
<body onLoad="focus();">

<? // Include the HEADER -AZ
include 'header.php'; ?>

<?= $Message ?>

<table border="0">
<tr>

<td width="10%" valign="top" height="100">
	<div class="login">
	<form action="login.php" method="post" name="login" style="margin:0px;">
<?php if($REF) { ?>
	<input type="hidden" name="ref" value="<?= $REF ?>">
<?php } ?>
	<div class="loginheader">Voting Form Login</div>
	<table border="0" class="padded">
		<tr>
			<td><b>Username:</b></td>
			<td><input type="text" name="username" tabindex="1" value="<?= $USERNAME ?>"></td>
		</tr>
		<tr>
			<td><b>Password:</b></td>
			<td><input type="password" name="password" tabindex="2" value="<?= $PASSWORD ?>"></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="login" value="Login" tabindex="3"></td>
		</tr>
		<tr>
			<td colspan="2">
				<a class="pwhelp" href="createaccount.php">Need to create an account?</a>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<a class="pwhelp" href="forgot_password.php">Forgot your password?</a>
			</td>
		</tr>
	</table>
	</form>
	</div>
</td>

<td valign="top">
	<div class="right">
	<div class="rightheader">Info Display</div>
	<table border="0" class="padded">
	<tr>
	<td>
	This space is planned to be used later to add help information as needed.

	</td>
	</tr>
	</table>
	</div>
</td>

</tr>
</table>

<? // Include the FOOTER -AZ
include 'footer.php'; ?>

</body>
</html>