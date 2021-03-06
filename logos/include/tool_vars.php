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
$TOOL_PATH = $_SERVER["DOCUMENT_ROOT"].'/conf_logos/';
$TOOL_URL = "/conference";
$TOOL_NAME = "Conference Logos";
$TOOL_SHORT = "logos";

$CSS_FILE = $TOOL_URL."/include/template/css/template_css.css";
$CSS_FILE2 = $TOOL_URL."/include/template/css/header.css";
$CSS_FILE3 = $TOOL_URL."/include/template/css/footer.css";
$HELP_LINK = "include/help.php";

$CONF_ID = "Dec2006";
$CONF_URL = "http://sakaiproject.org/index.php?option=com_content&amp;task=view&amp;id=418&amp;Itemid=567";

// date format for display
$DATE_FORMAT = "l, F dS, Y h:i A";

$MAX_THUMB_WIDTH = 120;
$MAX_THUMB_HEIGHT = 100;

$IMAGE_MIMES = array(
	'image/pjpeg'=>"jpg",
	'image/jpeg'=>"jpg",
	'image/jpg'=>"jpg",
	'image/png'=>"png",
	'image/x-png'=>"png",
	'image/gif'=>"gif",
	'image/bmp'=>"bmp");

?>
