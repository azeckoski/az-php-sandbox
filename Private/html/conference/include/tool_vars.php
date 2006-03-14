<?php
/*
 * Created on Febrary 20, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php

// Bring in the system variables
// You must verify the path to the system_vars and the
// user control directory are correct or many things will break -AZ
$ACCOUNTS_PATH = $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR.'accounts'.DIRECTORY_SEPARATOR;
require ($ACCOUNTS_PATH.'include/system_vars.php');

// Tool variables
$TOOL_PATH = "/conference";
$TOOL_NAME = "Conference";
$TOOL_SHORT = "conf";
$CSS_FILE = "../../templates/vancouver/css/template_css.css";
$CSS_FILE2 = "../../templates/vancouver/css/template_CFPform_css.css";
$HELP_LINK = "include/help.php";

// date format for display
$DATE_FORMAT = "l, F dS, Y h:i A";

// dates below in format: YYYY/MM/DD HH24:MI
if ($ENVIRONMENT == "prod") {
	// OFFICIAL DATES
	$ROUND_OPEN_DATE = "2006/02/27 11:00";
	$ROUND_SWITCH_DATE = "2006/03/06 1:00";
	$ROUND_CLOSE_DATE = "2006/03/14 1:00";	

} elseif ($ENVIRONMENT == "preprod") {
	// TESTING DATES
	$ROUND_OPEN_DATE = "2006/02/01 11:00";
	$ROUND_SWITCH_DATE = "2006/03/06 1:00";
	$ROUND_CLOSE_DATE = "2006/03/14 1:00";

} else { // assume dev environment
	// DEV DATES
	$ROUND_OPEN_DATE = "2006/01/01 11:00";
	$ROUND_SWITCH_DATE = "2006/04/01 1:00";
	$ROUND_CLOSE_DATE = "2006/05/01 1:00";
}

?>