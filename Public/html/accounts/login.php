<?php
/*
 * file: login.php
 * Created on Mar 3, 2006 9:45:03 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Login";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// Clear the current session cookie
setcookie("SESSION_ID", "NULL", null, "/", false, 0);

// Pass along the referrer
$REF = $_REQUEST["ref"]; // This is the refering page

// Get the username and password (force username to lowercase)
$USERNAME = strtolower($_POST["username"]);
$PASSWORD = mysql_real_escape_string($_POST["password"]);

$errors = 0;
if (ereg('[[:space:]]',$USERNAME)) {
	$errors++;
	$Message .= "<span style='color:red;'>Username cannot contain spaces</span><br/>";
}

if (ereg('[[:space:]]',$PASSWORD)) {
	$errors++;
	$Message .= "<span style='color:red;'>Password cannot contain spaces</span><br/>";
}

// check the username/password to auth if present
if (!$errors && strlen($USERNAME) && strlen($PASSWORD)) {
	$login_success = 0;
	
	if (!$login_success) {
		// ATTEMPT AUTH VIA LOCAL DB
	
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

			//print ("Internal Auth Suceeded");
			writeLog($TOOL_SHORT,$USERNAME,"user logged in (internal):" . $_SERVER["REMOTE_ADDR"].":".$_SERVER["HTTP_REFERER"]);
			$login_success = 1;
		}
	}

	if ($login_success && $user_pk) {
		// login suceeded so create the session in the database
		
		$cookie_val = md5($row["pk"] . time() . mt_rand() );
		// create session cookie, this should last until the user closes the browser
		setcookie("SESSION_ID", $cookie_val, null, "/", false, 0);

		// delete all sessions related to this user
		$sql2 = "DELETE FROM sessions WHERE users_pk = '$user_pk'";
		$result = mysql_query($sql2) or die('Query failed: ' . mysql_error());

		// add user to sessions table
		$sql3 = "insert into sessions (users_pk, passkey) values ('$user_pk', '$cookie_val')";
		$result = mysql_query($sql3) or die('Query failed: ' . mysql_error());

		// redirect after login -AZ
		//print "ref = $REF<br/>";

		if ($REF) {
			header('location:'.$REF);
		} else {
			header('location:index.php');
		}
		exit;

	} else {
		// user/pass combo not found
		$Message .= "<span class='error'>Invalid login: $USERNAME </span><br/>" .
			"Please check your username and password and make sure your account is activated.";

		// Clear the current session cookie
		setcookie("SESSION_ID", "NULL", null, "/", false, 0);
	}
}
?>

<!-- // INCLUDE THE HTML HEAD -->
<?php include 'include/top_header.php';  ?>
<script type="text/javascript">
<!--
window.onload = doFocus;

function doFocus() {
	document.adminform.username.focus();
}
// -->
</script>
<!-- // INCLUDE THE HEADER -->
<?php include 'include/header.php';  ?>

<?= $Message ?>

<table border="0">
<tr>

<td width="10%" valign="top" height="100">
	<div class="login">
	<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<?php if($REF) { ?>
	<input type="hidden" name="ref" value="<?= $REF ?>" />
<?php } ?>
	<div class="loginheader"><?= $SYSTEM_NAME ?> Login</div>
	<table border="0" class="padded">
		<tr>
			<td><b style="font-size:11pt;">Username:</b></td>
			<td><input type="text" name="username" tabindex="1" value="<?= $USERNAME ?>" /></td>
		</tr>
		<tr>
			<td><b style="font-size:11pt;">Password:</b></td>
			<td><input type="password" name="password" tabindex="2" value="<?= $PASSWORD ?>" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="login" value="Login" tabindex="3" /></td>
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
	<td style="font-size:11pt;">
<?php // output the passed message if there is one
	if ($_REQUEST["msg"]) {
		echo "<b>NOTE:</b> ".$_REQUEST["msg"]."<br><br>";
	}
?>
	This space is planned to be used later to add help information as needed.

	</td>
	</tr>
	</table>
	</div>
</td>

</tr>
</table>

<script type="text/javascript">
<!--
	//document.adminform.username.focus();
// -->
</script>

<?php include 'include/footer.php'; // Include the FOOTER ?>