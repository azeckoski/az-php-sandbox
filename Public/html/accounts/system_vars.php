<?php
// PLEASE READ THIS
//
// this file now supports a flag with three options, so that we can have different
// settings for development (local machines), preprod (sakaitest) and prod
// You should change the environment variable to correspond to the environment you're using.

// supported options are "dev", "preprod", and "prod"
$ENVIRONMENT = "dev";


if ($ENVIRONMENT == "dev") {
	// Set needed system variables
	$SYSTEM_NAME = "Sakai Web";
	$SERVER_NAME = "http:/localhost";
	$ACCOUNTS_PAGE = "myaccount.php";
	$LOGIN_PAGE = "login.php";
	$LOGOUT_PAGE = "logout.php";
	$HELP_EMAIL = "shardin@umich.edu";
	$MAIL_SERVER = "mail.vt.edu";
}
elseif ($ENVIRONMENT == "preprod") {
	// Set needed system variables
	$SYSTEM_NAME = "Sakai Web";
	$SERVER_NAME = "http://sakaitest.org";
	$ACCOUNTS_PAGE = "myaccount.php";
	$LOGIN_PAGE = "login.php";
	$LOGOUT_PAGE = "logout.php";
	$HELP_EMAIL = "shardin@umich.edu";
	$MAIL_SERVER = "mail.umich.edu";
}
elseif ($ENVIRONMENT == "prod") {
	// Set needed system variables
	$SYSTEM_NAME = "Sakai Web";
	$SERVER_NAME = "http://sakaiproject.org";
	$ACCOUNTS_PAGE = "myaccount.php";
	$LOGIN_PAGE = "login.php";
	$LOGOUT_PAGE = "logout.php";
	$HELP_EMAIL = "shardin@umich.edu";
	$MAIL_SERVER = "mail.umich.edu";
}
else {
  die("Don't how how to operate in the environment entitled &quot;$ENVIRONMENT&quot;.'");	
}


?>
