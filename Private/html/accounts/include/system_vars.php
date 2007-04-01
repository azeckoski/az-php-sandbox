<?php
// PLEASE READ THIS
//
// this file now supports a flag with three options, so that we can have different
// settings for development (local machines), test (QA and testing) and prod (production)
// You should change the environment variable to correspond to the environment you're using.

// supported options are "dev","test", and "prod"
$ENVIRONMENT = "Prod";

if ($ENVIRONMENT == "dev") {
	// Set needed system variables
	$SYSTEM_NAME = "Sakai WebDev";
	$SERVER_NAME = "http://localhost";
	$USE_LDAP = false; // false=no ldap
	$LDAP_SSL = false; // false=no SSL

	$HELP_EMAIL = "aaronz@vt.edu";
	$MAIL_SERVER = "smtp.vt.edu";
}
elseif ($ENVIRONMENT == "test") {
	// Set needed system variables
	$SYSTEM_NAME = "Sakai WebTest";
	$SERVER_NAME = "https://sakaitest.org";
	$USE_LDAP = true; // false=no ldap
	$LDAP_SSL = true; // false=no SSL

	$HELP_EMAIL = "shardin@umich.edu";
	$MAIL_SERVER = "mail.umich.edu";
}
elseif ($ENVIRONMENT == "prod") {
	// Set needed system variables
	$SYSTEM_NAME = "Sakai Web";
	$SERVER_NAME = "https://sakaiproject.org";
	$USE_LDAP = true; // false=no ldap
	$LDAP_SSL = true; // false=no SSL

	$HELP_EMAIL = "sakaiproject_webmaster@umich.edu";
	$MAIL_SERVER = "mail.umich.edu";
}
elseif ($ENVIRONMENT == "devSusan") {
	// Set needed system variables
	$SYSTEM_NAME = "SusanMac";
	$SERVER_NAME = "http://localhost";
	$USE_LDAP = false; // false=no ldap
	$LDAP_SSL = false; // false=no SSL

	$HELP_EMAIL = "shardin@umich.edu";
	$MAIL_SERVER = "mail.umich.edu";
}
else {
  die("Invalid environment varaiable: &quot;$ENVIRONMENT&quot;.'");	
}


require ('config.php');
// Load the GD module (for images)
if (!extension_loaded('gd')) {
	if (!dl('gd.so')) {
		die("Could not enable GD library!");
	}
}


// GLOBAL functions

// setting the institution will select the institution with that pk
// setting short to true will truncate the institution names
// setting an ignore value will cause the list skip that item
function generate_partner_dropdown($institution="", $short=false, $ignore="") {
	$output = "";

    $institution_select_statement = "select PK, NAME from institution order by NAME";
    $result = mysql_query($institution_select_statement);
    while ($instRow = mysql_fetch_array($result)) {
    	$selected="";
		if ($ignore == $instRow['PK']) { continue; } // skip the ignore item
	    if ( $institution && $institution == $instRow['PK'] ) {
	    	$selected=" selected='y'";
	    }
	    $instName = $instRow['NAME'];
	    if ($short && (strlen($instName) > 38) ) {
			$instName = substr($instName,0,35) . "...";
	    }
		$output .= "<option title=\"".$instRow['NAME']."\" value=\"" . $instRow['PK'] . "\"$selected>" . $instName . "</option>\n";
	}
 
 	return $output;
}


// generates the role selector dropdown list options
function generate_roles_dropdown($role="") {
	$output = "";
	$found = false;

    $sql = "select role_name from roles order by role_order";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result)) {
    	$selected="";
	    if ( $role && $role == $row['role_name'] ) {
	    	$selected=" selected='y'";
	    	$found = true;
	    }
	    $itemName = $row['role_name'];
		$output .= "<option title='$itemName' value='$itemName' $selected>$itemName</option>\n";
	}
	if (!$found && $role) {
		// add the role as the top item if it does not exist
		$output = "<option title='$role' value='$role' selected='y'>$role</option>\n" . $output;
	}
 	return $output;
}

// check if an item is utf-8 encoded
function is_utf8($string) {
	if (mb_detect_encoding($string) == "UTF-8") { return true; }
	return false;
}

// $UID should be a user ID, $str will be written
function writeLog($tool,$UID, $str) {
	// if the logs directory is not writeable by the webserver then this will fail
	$date=date("Ymd");
	$time=date("H:i:s");
	$filename = $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."logs".DIRECTORY_SEPARATOR.$tool."_".$date.".log";
	$output = "$UID;$date $time;".$_SERVER["PHP_SELF"].";$str\n";
	$fp = @fopen($filename,"a");
	if (!$fp) {return false;}
	$wcheck = fwrite($fp,$output);
	fclose($fp);
	return $wcheck;
}
?>
