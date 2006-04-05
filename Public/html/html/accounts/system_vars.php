<?php
// PLEASE READ THIS
//
// this file now supports a flag with three options, so that we can have different
// settings for development (local machines), preprod (sakaitest) and prod
// You should change the environment variable to correspond to the environment you're using.

// supported options are "dev", "preprod", and "prod"
$ENVIRONMENT = "preprod";


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

// GLOBAL functions
function generate_partner_dropdown($institution="", $short=0) {
	global $SAKAI_PARTNERS;
	$output = "";

    $institution_select_statement = "select PK, NAME from institution";
    $result = mysql_query($institution_select_statement);
    while ($instRow = mysql_fetch_array($result)) {
    		$selected="";
	    if ( $institution == $instRow['PK'] ) { 
	    		$selected=" selected='Y'";
	    	}
	    $instName = $instRow['NAME'];
	    if ($short && (strlen($instName) > 38) ) {
			$instName = substr($instName,0,35) . "...";
	    	}
		$output .= "<option title=\"".$instRow['NAME']."\" value=\"" . $instRow['PK'] . "\"$selected>" . $instName . "</option>\n";
	}
 
 	return $output;
}

?>
