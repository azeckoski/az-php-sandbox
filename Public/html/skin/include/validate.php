<?php
/*
 * file: validate.php
 * Created on Mar 11, 2006 1:00:00 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/skin/include/tool_vars.php';

// connect to database
require $_SERVER["DOCUMENT_ROOT"].$TOOL_PATH.'/sql/mysqlconnect.php';

// global vars
$PASS = "ok";
$FAIL = "error";

// run the ajax stuff if the ajax var is set
if ($_REQUEST["ajax"]) {
	ProcessAjax();
	exit();
} else {
	print "Check<br>";
}


// validates a single field via AJAX, all data passed in the get string
function ProcessAjax() {
	global $TOOL_SHORT;
	global $PASS;
	global $FAIL;

	writeLog($TOOL_SHORT,"ajax",$_SERVER["QUERY_STRING"]);

	$required = $_GET["req"]; // is field required, "required" or "optional"
	$type = $_GET["type"]; // additional requirements like email or none
	$formid = $_GET["id"]; // id of the form element
	$value = $_GET["val"]; // the value of the field
	$param1 = $_GET["param3"]; // extra parameters
	$param2 = $_GET["param4"]; // extra parameters
	$param3 = $_GET["param5"]; // extra parameters
	$param4 = $_GET["param6"]; // extra parameters

	// the display id is always formid + "Msg"
	$displayId = $formid . "Msg";

	$ajaxReturn = "";
	if ($required == "required") {
		if(validateRequired($value)) {
			$ajaxReturn = "$PASS|$displayId|Done";
		} else {
			// failed required check
			$ajaxReturn = "$FAIL|$displayId|Required";
			echo $ajaxReturn;
			writeLog($TOOL_SHORT,"ajax","$ajaxReturn");
			exit(); // if we fail the required check then no more checks needed
		}
	}

	if ($type == "email") {
		if(validateEmail($value)) {
			$ajaxReturn = "$PASS|$displayId|Valid Email";
		} else {
			$ajaxReturn = "$FAIL|$displayId|Invalid Email Address";
		}
	}
	
	echo $ajaxReturn;
	writeLog($TOOL_SHORT,"ajax","$ajaxReturn");
}


//--------------------------VALIDATION FUNCTIONS -----------------
//Function to validate if the field is required.  It just checks to see if the field is empty.
function validateRequired($value) {
	// if it is required check to see if it validates
	if (!$value) {
		// if val is blank then then the field is invalid
		return false;
	}
	return true;
}

function validateEmail($val) {
	// check the email address with a regex function
	if  (eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$', $val)) {
		return true;
	}
	return false;
}