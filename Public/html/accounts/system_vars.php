<?php
// PLEASE READ THIS
//
// this file now supports a flag with three options, so that we can have different
// settings for development (local machines), test (QA and testing) and prod (production)
// You should change the environment variable to correspond to the environment you're using.

// supported options are "dev","test", and "prod"
$ENVIRONMENT = "dev";

if ($ENVIRONMENT == "dev") {
	// Set needed system variables
	$SYSTEM_NAME = "Sakai WebDev";
	$SERVER_NAME = "http://localhost";

	$HELP_EMAIL = "aaronz@vt.edu";
	$MAIL_SERVER = "mail.vt.edu";
}
elseif ($ENVIRONMENT == "test") {
	// Set needed system variables
	$SYSTEM_NAME = "Sakai WebTest";
	$SERVER_NAME = "http://sakaitest.org";

	$HELP_EMAIL = "shardin@umich.edu";
	$MAIL_SERVER = "mail.umich.edu";
}
elseif ($ENVIRONMENT == "prod") {
	// Set needed system variables
	$SYSTEM_NAME = "Sakai Web";
	$SERVER_NAME = "http://sakaiproject.org";

	$HELP_EMAIL = "shardin@umich.edu";
	$MAIL_SERVER = "mail.umich.edu";
}
else {
  die("Don't how how to operate in the environment entitled &quot;$ENVIRONMENT&quot;.'");	
}

// Non-environment dependent globals
$ACCOUNTS_PAGE = "myaccount.php";
$LOGIN_PAGE = "login.php";
$LOGOUT_PAGE = "logout.php";

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

// $UID should be a user ID, $str will be written
function writeLog($tool,$UID, $str) {
	// if the logs directory is not writeable by the webserver then this will fail
	$date=date("Ymd");
	$time=date("H:i:s");
	$filename = $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."logs".DIRECTORY_SEPARATOR.$tool."_".$date.".log";
	$output = "$UID;$date $time;".$_SERVER["PHP_SELF"].";$str\n";
	$fp = @fopen($filename,"a");
	$wcheck = fwrite($fp,$output);
	fclose($fp);
	return $wcheck;
}
?>
