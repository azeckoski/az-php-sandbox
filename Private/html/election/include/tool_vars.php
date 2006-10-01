<?php
/*
 * Created on March 19, 2006 by @author aaronz
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
$TOOL_PATH = $_SERVER["DOCUMENT_ROOT"].'/elections/';
$TOOL_URL = "/elections";
$TOOL_NAME = "Elections";
$TOOL_SHORT = "elections";

$CSS_FILE2 = $TOOL_URL."../../conference/include/template/css/template_css.css";
$CSS_FILE3 = $TOOL_URL."../../conference/include/template/css/header.css";
$CSS_FILE4 = $TOOL_URL."../../conference/include/template/css/footer.css";

$HELP_LINK = "include/help.php";

$ELECTIONS_ID = "Nov2005";

// date format for display
$DATE_FORMAT = "l, F dS, Y h:i A";

$MAX_THUMB_WIDTH = 120;
$MAX_THUMB_HEIGHT = 100;


// date format for display
$DATE_FORMAT = "l, F dS, Y g:i A";
$MED_DATE_FORMAT = "M d, Y (g A)";
$SHORT_DATE_FORMAT = "g A M d, y";

// dates below in format: YYYY/MM/DD HH24:MI
//$NOMINEE_OPEN_DATE = "2006/9/20 8:00";
//$NOMINEE_CLOSE_DATE = "2006/10/30 5:00";
//$NOMINEE_VIEW_DATE = "2006/10/01 5:00";

// dates below in format: YYYY/MM/DD HH24:MI  FOR TESTING ONLY
$NOMINEE_OPEN_DATE = "2006/9/15 8:00";
$NOMINEE_CLOSE_DATE = "2006/10/30 5:00";
$NOMINEE_VIEW_DATE = "2006/9/15 5:00";


$IMAGE_MIMES = array(
	'image/pjpeg'=>"jpg",
	'image/jpeg'=>"jpg",
	'image/jpg'=>"jpg",
	'image/png'=>"png",
	'image/x-png'=>"png",
	'image/gif'=>"gif",
	'image/bmp'=>"bmp");

?>
