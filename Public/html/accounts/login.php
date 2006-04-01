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

// construct empty user object
$User = new User();

// Pass along the referrer
$REF = $_REQUEST["ref"]; // This is the refering page

// Get the username and password (force username to lowercase)
$username = $_POST["username"];
$password = $_POST["password"];

$errors = 0;
if (ereg('[[:space:]]',$username)) {
	$errors++;
	$Message .= "<span style='color:red;'>Username cannot contain spaces</span><br/>";
}

if (ereg('[[:space:]]',$password)) {
	$errors++;
	$Message .= "<span style='color:red;'>Password cannot contain spaces</span><br/>";
}

// check the username/password to auth if present
if (!$errors && strlen($username) && strlen($password)) {

	if ($User->login($username, $password)) {
		// redirect after login -AZ
		//print "ref = $REF<br/>";

		if ($REF) {
			header('location:'.$REF);
		} else {
			header('location:index.php');
		}
		exit;

	} else {
		// user login failed
		$Message .= "<span class='error'>Invalid login: $username </span><br/>" .
			"Please check your username and password and make sure your account is activated.";

		// Clear the current session cookie
		$User->destroySession();
	}
}
?>
<?php include 'include/top_header.php';  ?>
<script type="text/javascript">
<!--
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
			<td><input type="text" name="username" tabindex="1" value="<?= $username ?>" size="20" /></td>
		</tr>
		<tr>
			<td><b style="font-size:11pt;">Password:</b></td>
			<td><input type="password" name="password" tabindex="2" value="<?= $password ?>" size="20" /></td>
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
	document.adminform.username.focus();
// -->
</script>

<?php include 'include/footer.php'; // Include the FOOTER ?>