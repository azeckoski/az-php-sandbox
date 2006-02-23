<?php

// Bring in the system variables
// You must verify the path to the system_vars and the
// user control directory are correct or many things will break -AZ
$ACCOUNTS_PATH = "../accounts";
require ("$ACCOUNTS_PATH/system_vars.php");

// Tool variables
$TOOL_PATH = "/accounts";
$TOOL_NAME = "Account Management";

function generate_partner_dropdown($institution="") {
	global $SAKAI_PARTNERS;
	$output = "";

	if (!isset($institution)) { $institution = $_POST['institution']; }
	if (!isset($institution)) { $institution = $_GET['institution']; }

	$output .= "<option value=\"0\"> --Select Your Organization--</option>";

    $institution_select_statement = "select PK, NAME from institution";
    $result = mysql_query($institution_select_statement);
    while ($instRow = mysql_fetch_array($result)) {
	    if (isset($instRow['PK']) && ($institution == $instRow['PK'])) { $selected="selected=\"Y\""; }
	    else { $selected=""; }
		$output .= "<option value=\"" . $instRow['PK'] . "\"$selected>" . $instRow['NAME'] . "</option>\n";
	}
 
 
 	return $output;
}
?>
