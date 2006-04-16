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
$TOOL_PATH = "/requirements";
$TOOL_NAME = "Requirements Voting";
$TOOL_SHORT = "reqs";
$CSS_FILE = "include/requirements_vote.css";
$HELP_LINK = "include/help.php";

$JIRA_REQ = "http://bugs.sakaiproject.org/jira/browse/";

$VOTE_TEXT = array("not applicable","desirable","essential","critical");
$VOTE_HELP = array("Does not impact our use of Sakai",
	"Can use Sakai but would like this",
	"Can use Sakai but need this as soon as possible",
	"Cannot use Sakai without it");
// Weighting for sorting votes
// NA, Desirable, Essential, Critical
$SCORE_MOD = array(0.5, 1, 2, 4);
// IMPORTANT: If you change these values you must run "Recalculate scores" in the admin screen
// or all scores will be inaccurate

// these control the round of voting
$ROUND = 1;
// date format for display
$DATE_FORMAT = "l, F dS, Y h:i A";
$ROUND_DATE_FORMAT = "l, F dS, Y h:i A";

// dates below in format: YYYY/MM/DD HH24:MI
if ($ENVIRONMENT == "prod") {
	// OFFICIAL DATES
	$ROUND_OPEN_DATE = "2006/02/27 11:00";
	$ROUND_SWITCH_DATE = "2006/03/06 1:00";
	$ROUND_CLOSE_DATE = "2006/03/23 6:00";	

} elseif ($ENVIRONMENT == "test") {
	// TESTING DATES
	$ROUND_OPEN_DATE = "2006/02/01 11:00";
	$ROUND_SWITCH_DATE = "2006/03/06 1:00";
	$ROUND_CLOSE_DATE = "2006/03/23 6:00";

} else { // assume dev environment
	// DEV DATES
	$ROUND_OPEN_DATE = "2006/01/01 11:00";
	$ROUND_SWITCH_DATE = "2006/03/01 1:00";
	$ROUND_CLOSE_DATE = "2006/03/23 6:00";
}

?>
