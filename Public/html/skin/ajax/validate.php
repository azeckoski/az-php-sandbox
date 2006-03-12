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

	// fetch the passed items from the get string
	$formid = stripslashes($_GET["id"]); // id of the form element
	$value = stripslashes($_GET["val"]); // the value of the field
	$type = stripslashes($_GET["type"]); // text requirements like email, date, time, zip
	$spec = stripslashes($_GET["spec"]); // special requirements like unique
	$param1 = stripslashes($_GET["param3"]); // extra parameters
	$param2 = stripslashes($_GET["param4"]); // extra parameters
	$param3 = stripslashes($_GET["param5"]); // extra parameters
	$param4 = stripslashes($_GET["param6"]); // extra parameters

	// required validating handled on javascript side to reduce server traffic

	// do the type validation
	if ($type == "email") {
		if(validateEmail($value)) {
			$ajaxReturn = "$PASS|$formid|Valid Email";
		} else {
			$ajaxReturn = "$FAIL|$formid|Invalid Email Address";
		}
	} else if ($type == "date") {
		if(validateDate($value)) {
			$ajaxReturn = "$PASS|$formid|Valid Date";
		} else {
			$ajaxReturn = "$FAIL|$formid|Invalid Date Entry";
		}
	} else if ($type == "time") {
		if(validateTime($value)) {
			$ajaxReturn = "$PASS|$formid|Valid Time";
		} else {
			$ajaxReturn = "$FAIL|$formid|Invalid Time Entry";
		}
	} else if ($type == "zip") {
		if(validateZip($value)) {
			$ajaxReturn = "$PASS|$formid|Valid Zip";
		} else {
			$ajaxReturn = "$FAIL|$formid|Invalid Zip Code";
		}
	}

	// do the special validation


	echo $ajaxReturn;
	writeLog($TOOL_SHORT,"ajax","$ajaxReturn");
}


//--------------------------VALIDATION FUNCTIONS -----------------
//Function to validate if the field is required.  It just checks to see if the field is empty.
function validateRequired($val) {
	// if it is required check to see if it validates
	if (empty($val)) {
		// if val is blank then then the field is invalid
		return false;
	}
	return true;
}

// validate email address using regexp
function validateEmail($val) {
	if(empty($val)) {
		// field is empty
	    return false;
	}

	// check the email address with a regex function
	if  (eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$', $val)) {
		return true;
	}
	return false;
}

// validate date using php function
function validateDate($val) {
	if(empty($val)) {
		// field is empty
	    return false;
	}

	if (!strtotime($val)) {
		return false;
	}
	return true;
}

// validate time using php function
function validateTime($val) {
	if(empty($val)) {
		// field is empty
	    return false;
	}

	if (!strtotime($val)) {
		return false;
	}
	return true;
}

// validate zip code
function validateZip($val) {
	if(empty($val)) {
		// field is empty
	    return false;
	}

	$Bad = eregi_replace("([-0-9]+)","",$val);	
	if(!empty($Bad)) {
		// invalid chars in zip code
	    return false;
	}
	$Num = eregi_replace("\-","",$val);
	$len = strlen($Num);
	if ( ($len > 10) or ($len < 5) ) {
	    // Invalid length for zipcode
	    return false;
	}
	
	return true;
}