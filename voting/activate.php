<?
	require_once ("globals.php");

	// This is the account activation script
	$PAGE_NAME = "Activate Account";

	// connect to database
	require "mysqlconnect.php";

	$ID = $_REQUEST['id'];
	$CODE = $_REQUEST['code'];

	$sql = mysql_query("UPDATE users SET activated='1' WHERE pk='$ID'") or
		die('User activation failed: ' . mysql_error());

	$sql_doublecheck = mysql_query("SELECT * FROM users WHERE pk='$ID' AND activated='1'");
	$doublecheck = mysql_num_rows($sql_doublecheck);

	if($doublecheck == 1 && ($CODE == $ACTIVATION_PASSCODE)){
		$Message = "<strong>Your account has been activated!</strong><br/>" .
			"Please <a href='login.php'>login</a> to continue.";
	} else {
		$Message = "<span class='error'>Your account could not be activated!</span><br/>" .
			"Please contact an administrator at $HELP_EMAIL.";
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title>
<link href="./requirements_vote.css" rel="stylesheet" type="text/css">

</head>
<body>

<? // Include the HEADER -AZ
include 'header.php'; ?>

<?= $Message ?>

<? // Include the FOOTER -AZ
include 'footer.php'; ?>

</body>
</html>