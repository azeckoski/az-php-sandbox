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
$TOOL_PATH = "/skin";
$TOOL_NAME = "Skin Submission and Voting";
$TOOL_SHORT = "skin";
$CSS_FILE = $TOOL_PATH."/include/skin.css";
$HELP_LINK = $TOOL_PATH."/include/help.php";

$JIRA_REQ = "http://bugs.sakaiproject.org/jira/browse/";

$VOTE_TEXT = array("not applicable","desirable","essential","critical");
$VOTE_HELP = array("Does not impact our use of Sakai",
	"Can use Sakai but would like this",
	"Can use Sakai but need this as soon as possible",
	"Cannot use Sakai without it");
// Weighting for sorting votes

// these control the round of the contest and voting
$ROUND = 1;
// date format for display
$DATE_FORMAT = "D, M j, Y h:i A";

// dates below in format: YYYY/MM/DD HH24:MI
if ($ENVIRONMENT == "prod") {
	// OFFICIAL DATES
	$ROUND_START_DATE = "2006/03/15 1:00";
	$ROUND_CLOSE_DATE = "2006/05/15 1:00";
	$ROUND_VOTE_DATE = "2006/05/17 1:00";
	$ROUND_END_DATE = "2006/05/31 10:00";	

} elseif ($ENVIRONMENT == "preprod") {
	// TESTING DATES
	$ROUND_START_DATE = "2006/03/15 1:00";
	$ROUND_CLOSE_DATE = "2006/05/15 1:00";
	$ROUND_VOTE_DATE = "2006/05/17 1:00";
	$ROUND_END_DATE = "2006/05/31 10:00";	

} else { // assume dev environment
	// DEV DATES
	$ROUND_START_DATE = "2006/03/01 1:00";
	$ROUND_CLOSE_DATE = "2006/05/15 1:00";
	$ROUND_VOTE_DATE = "2006/05/17 1:00";
	$ROUND_END_DATE = "2006/05/31 10:00";	
}

?>
