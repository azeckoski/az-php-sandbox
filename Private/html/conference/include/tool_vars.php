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
$SHORT_DATE_FORMAT = "g A M d, y";

// proposals voting

$VOTE_TEXT = array("red","yellow","green");
$VOTE_HELP = array(
	"Proposal is inappropriate",
	"Proposal needs work but idea is sound",
	"Proposal is appropriate");

// dates below in format: YYYY/MM/DD HH24:MI
$VOTE_OPEN_DATE = "2006/04/12 8:00";
$VOTE_CLOSE_DATE = "2006/04/22 5:00";

// tool functions


?>
