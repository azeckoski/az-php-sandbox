<?php
	require_once ("tool_vars.php");

	// Introduction or main page
	$PAGE_NAME = "Main";

	// connect to database
	require "mysqlconnect.php";

	// get the passkey from the cookie if it exists
	$PASSKEY = $_COOKIE["SESSION_ID"];

	// check the passkey
	$USER_PK = 0;
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
		}
		mysql_free_result($result);
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
function focus(){document.login.username.focus();}
// -->
</script>

</head>
<body onLoad="focus();">

<?php
	$USER = "";
	if ($USER_PK) {
		// get the authenticated user information
		$authsql = "SELECT * FROM users WHERE pk = '$USER_PK'";
		$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());
		$USER = mysql_fetch_assoc($result);
	}
?>

<? // Include the HEADER -AZ
include 'header.php'; ?>


<div class="info">
This page will allow you to create an account to access the following tools:<br/>
<a href="/requirements">Requirements Voting</a><br/>
<br/>
You should <a href="createaccount.php">create an account</a> first if you do not have one.<br/>
<br/>
You can <a href="<?= $LOGIN_PAGE ?>">login</a> if you already have an account.<br/>
<br/>
You can <a href="<?= $ACCOUNTS_PAGE ?>">manage your account settings</a> and change your password if you would like.<br/>
<br/>
You can even <a href="forgot_password.php">reset your password</a> if you forgot it.<br/>

</div>


<div class="help">
	<b>Help:</b>
	<a class="pwhelp" href="createaccount.php">I need to create an account</a> -
	<a class="pwhelp" href="login.php">I need to login</a> -
	<a class="pwhelp" href="forgot_password.php">I forgot my password</a>
</div>

<? // Include the FOOTER -AZ
include 'footer.php'; ?>

</body>
</html>