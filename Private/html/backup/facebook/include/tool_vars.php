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
$TOOL_PATH = $_SERVER["DOCUMENT_ROOT"].'/facebook/';
$TOOL_URL = "/facebook";
$TOOL_NAME = "Facebook";
$TOOL_SHORT = "face";
$CSS_FILE = $TOOL_URL."/include/template_facebook.css";
$HELP_LINK = "include/help.php";

$CONF_ID = "Jun2006";

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
