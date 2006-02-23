<?php

// Bring in the system variables
// You must verify the path to the system_vars and the
// user control directory are correct or many things will break -AZ
$ACCOUNTS_PATH = "../accounts/";
require ($ACCOUNTS_PATH."system_vars.php");

// Tool variables
$TOOL_PATH = "/requirements";
$TOOL_NAME = "Requirements Voting";

$JIRA_REQ = "http://bugs.sakaiproject.org/jira/browse/";

// these control the round of voting
$ROUND = 1;
$ROUND_DATE_FORMAT = "YYYY/MM/DD HH24:MI";
$ROUND_OPEN_DATE = "2006/02/24 17:00";
$ROUND_SWITCH_DATE = "2006/03/06 1:00";
$ROUND_CLOSE_DATE = "2006/03/14 1:00";
$ROUND_REVIEW_DATE = "2006/03/14 8:00";

?>
