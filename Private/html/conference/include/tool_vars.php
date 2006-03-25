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
$ACCOUNTS_PATH = $_SERVER["DOCUMENT_ROOT"].'/accounts/';
require_once ($ACCOUNTS_PATH.'include/system_vars.php');

// Tool variables
$TOOL_URL = "/conference";
$TOOL_PATH = $_SERVER["DOCUMENT_ROOT"].$TOOL_URL.'/';
$TOOL_NAME = "Conference";
$TOOL_SHORT = "conf";
$CSS_FILE = $TOOL_URL."/include/template_css.css";
$CSS_FILE2 = $TOOL_URL."/include/template_CFPform_css.css";
//$HELP_LINK = "include/help.php";

$CONF_ID = "Jun2006";
$CONF_LOC = "Vancouver";
$CONF_NAME = "Sakai Vancouver";

// date format for display
$DATE_FORMAT = "l, F dS, Y h:i A";

// tool functions


?>
