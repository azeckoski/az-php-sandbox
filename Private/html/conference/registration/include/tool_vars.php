<?php

// This is a subtool, bring in the vars from the parent tool
// Subtools to not need to bring in the system vars because those come in
// from the parent tool vars
require $_SERVER["DOCUMENT_ROOT"].'/conference/include/tool_vars.php';
$PARENT_URL = $TOOL_URL;
$PARENT_PATH = $TOOL_PATH;

// Tool variables
$TOOL_URL = $PARENT_URL.'/registration';
$TOOL_PATH = $PARENT_PATH.'registration/';
$TOOL_NAME = "Registration";
$TOOL_SHORT = "reg";
// CSS_FILE from parent
// CSS_FILE2 from parent
$CSS_FILE3 = $ACCOUNTS_URL."/include/accounts.css";
//$HELP_LINK = "";

$DATE_FORMAT = "l, F dS, Y h:i A";

?>
