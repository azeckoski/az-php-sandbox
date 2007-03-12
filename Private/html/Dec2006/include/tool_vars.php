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

$CSS_FILE2 = $TOOL_URL."/include/template/css/template_css.css";
$CSS_FILE3 = $TOOL_URL."/include/template/css/header.css";
$CSS_FILE4 = $TOOL_URL."/include/template/css/footer.css";
//$HELP_LINK = "include/help.php";

$CONF_ID = "Dec2006";
$CONF_LOC = "Atlanta";
$CONF_NAME = "Sakai Atlanta";
$CONF_URL = "http://sakaiproject.org/index.php?option=com_content&amp;task=view&amp;id=418&amp;Itemid=567";
$REG_START_DATE = "2006/09/01 8:00";
$CONF_START_DATE = "2006/12/05 8:00";
$CONF_END_DATE = "2006/12/08 17:00";

// date format for display
$DATE_FORMAT = "l, F dS, Y g:i A";
$MED_DATE_FORMAT = "M d, Y (g A)";
$SHORT_DATE_FORMAT = "g A M d, y";

// proposals voting

$VOTE_TEXT = array("green", "yellow", "red");
$VOTE_HELP = array(
	"Proposal is appropriate",
	"Proposal needs work but idea is sound",
	"Proposal is inappropriate");
$VOTE_SCORE = array("2", "1", "0");

// dates below in format: YYYY/MM/DD HH24:MI
$VOTE_OPEN_DATE = "2006/09/15 8:00";
$VOTE_CLOSE_DATE = "2006/10/30 5:00";

// conference attendee reports
$CONF_REPORT_PATH = realpath($_SERVER["DOCUMENT_ROOT"]."/../reports/");
if ($ENVIRONMENT == "prod") {
	$CONF_REPORT_TO = "hardin@umich.edu,BCassidy@sefas.com,mmiles@umich.edu";
	$CONF_REPORT_CC = "shardin@umich.edu,kreister@umich.edu";
} elseif ($ENVIRONMENT == "test") {
	// TESTING
	$CONF_REPORT_TO = "shardin@umich.edu";
	$CONF_REPORT_CC = "aaronz@vt.edu";
} else { // assume dev environment
	$CONF_REPORT_TO = "aaronz@vt.edu";
	$CONF_REPORT_CC = "aaron@vt.edu";
}

// tool functions


?>