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
require ($ACCOUNTS_PATH.'include/system_vars.php');

// Tool variables
$TOOL_URL = "/skin";
$TOOL_PATH = $_SERVER["DOCUMENT_ROOT"].$TOOL_URL."/";
$TOOL_NAME = "Skin Submission and Voting";
$TOOL_SHORT = "skin";
$CSS_FILE = $TOOL_URL."/include/skin.css";
$HELP_LINK = $TOOL_URL."/include/help.php";

$JIRA_REQ = "http://bugs.sakaiproject.org/jira/browse/";

$VOTE_TEXT = array("poor", "fair", "average", "good", "excellent");
$VOTE_HELP1 = array(
	"Usability is poor",
	"Usability is fair",
	"Usability is average",
	"Usability is good",
	"Usability is excellent");
$VOTE_HELP2 = array(
	"Asthetic appeal is poor",
	"Asthetic appeal is fair",
	"Asthetic appeal is average",
	"Asthetic appeal is good",
	"Asthetic appeal is excellent");
$VOTE_SCORE = array("-2", "-1", "0", "1", "2");

// Image handling vars
$MAX_THUMB_WIDTH  = 160;
$MAX_THUMB_HEIGHT = 120;

$IMAGE_MIMES = array(
	'image/pjpeg'=>"jpg",
	'image/jpeg'=>"jpg",
	'image/jpg'=>"jpg",
	'image/png'=>"png",
	'image/x-png'=>"png",
	'image/gif'=>"gif",
	'image/bmp'=>"bmp");

// these control the round of the contest and voting
$ROUND = 1;
// date format for display
$DATE_FORMAT = "D, M j, Y h:i A";
$MED_DATE_FORMAT = "M d, Y (g A)";
$SHORT_DATE_FORMAT = "g A M d, y";

// dates below in format: YYYY/MM/DD HH24:MI
if ($ENVIRONMENT == "prod") {
	// OFFICIAL DATES
	$ROUND_START_DATE = "2006/04/20 1:00";
	$ROUND_CLOSE_DATE = "2006/05/26 17:00";
	$ROUND_VOTE_DATE = "2006/05/27 8:00";
	$ROUND_END_DATE = "2006/06/01 21:00";

} elseif ($ENVIRONMENT == "preprod") {
	// TESTING DATES
	$ROUND_START_DATE = "2006/04/20 1:00";
	$ROUND_CLOSE_DATE = "2006/05/26 17:00";
	$ROUND_VOTE_DATE = "2006/05/27 8:00";
	$ROUND_END_DATE = "2006/05/31 11:00";

} else { // assume dev environment
	// DEV DATES
	$ROUND_START_DATE = "2006/04/20 1:00";
	$ROUND_CLOSE_DATE = "2006/05/26 17:00";
	$ROUND_VOTE_DATE = "2006/05/27 8:00";
	$ROUND_END_DATE = "2006/05/31 11:00";
}

// TOOL FUNCTIONS
// generates the title selector dropdown list options
function generate_title_dropdown($title="") {
	global $TOOL_PATH, $ROUND;
	$output = "";
	$found = false;

	$namesDoc = new DOMDocument();
	$namesDoc->load($TOOL_PATH.'include/skin_names.xml');
	$elements = $namesDoc->getElementsByTagName('NAME');
	$allNames = array();
	foreach ($elements as $node) { $allNames[] = $node->nodeValue; }
	$sql_names = "select title from skin_entries where round='$ROUND' and title != '$title'";
	$result = mysql_query($sql_names) or die("Name query failed ($sql_names): " . mysql_error());
	$usedItems = array();
	while ($row = mysql_fetch_row($result)) {
		$usedItems[]=$row[0];
	}
	mysql_free_result($result);
	$allNames = array_diff($allNames,$usedItems);

    foreach ($allNames as $name) {
    	$selected="";
	    if ( $title && $title == $name ) {
	    	$selected=" selected='y'";
	    	$found = true;
	    }
	    $itemName = $name;
		$output .= "<option title='$itemName' value='$itemName' $selected>$itemName</option>\n";
	}
 	return $output;
}

?>
