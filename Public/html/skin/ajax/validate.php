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
	writeLog($TOOL_SHORT,"nonAJAX","Test call to validate");
}


// validates a single field via AJAX, all data passed in the get string
function ProcessAjax() {
	global $TOOL_SHORT;
	global $PASS;
	global $FAIL;
	$failed = 0;

	//writeLog($TOOL_SHORT,"ajax",$_SERVER["QUERY_STRING"]);

	// fetch the passed items from the get string
	$formid = $_GET["id"]; // id of the form element
	$fvalue = urldecode($_GET["val"]); // the value of the field

	// text requirements like email, date, time, zip
	// special requirements like unique
	$params = array();
	foreach(array_keys($_GET) as $key) {
		$check = strpos($key,'rule');
		if ( $check !== false && $check == 0 ) {
			$value = urldecode($_GET[$key]);
			writeLog($TOOL_SHORT,"ajax","rules:".$key."=>".$value);
			$params[$key] = $value; // validation rules
		}
	}

	// required validating handled on javascript side to reduce server traffic

	// do the validation
	foreach($params as $key=>$value) {
		$type = $value;
		if (strpos($value,";") !== false) { // get the special rule type
			$type = substr($value,0,strpos($value,";"));
		}
		
		//writeLog($TOOL_SHORT,"ajax","validate:".$type);
		if ($type == "email") {
			if(validateEmail($fvalue)) {
				$ajaxReturn = "$PASS|$formid|Valid Email";
			} else {
				$ajaxReturn = "$FAIL|$formid|Invalid Email Address";
				$failed = 1;
			}
		} else if ($type == "date") {
			if(validateDate($fvalue)) {
				$ajaxReturn = "$PASS|$formid|Valid Date";
			} else {
				$ajaxReturn = "$FAIL|$formid|Invalid Date Entry";
				$failed = 1;
			}
		} else if ($type == "time") {
			if(validateTime($fvalue)) {
				$ajaxReturn = "$PASS|$formid|Valid Time";
			} else {
				$ajaxReturn = "$FAIL|$formid|Invalid Time Entry";
				$failed = 1;
			}
		} else if ($type == "zip") {
			if(validateZip($fvalue)) {
				$ajaxReturn = "$PASS|$formid|Valid Zip";
			} else {
				$ajaxReturn = "$FAIL|$formid|Invalid Zip Code";
				$failed = 1;
			}
		}
		// do the special validations
		else if ($type == "uniquesql") {
			// should be uniquesql;(new|exists);(tablename);(columnname)
			$parts = split(';',$value);
			if(validateUnique($parts[1],$parts[2],$parts[3],$fvalue)) {
				$ajaxReturn = "$PASS|$formid|Valid $formid";
			} else {
				$ajaxReturn = "$FAIL|$formid|$formid already used";
				$failed = 1;
			}
		}
	}

	echo $ajaxReturn;
	writeLog($TOOL_SHORT,"ajax","return=$ajaxReturn");
}


// ======== VALIDATION FUNCTIONS ========
// validate required field (just checks to see if the field is empty)
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

// checks if an item is unique in the database or in use
// params = (new|exists),(tablename),(columnname),value
function validateUnique($status,$tablename,$columname,$val) {
	$sql = "select * from $tablename where $columname = '$val'";
	$result = mysql_query($sql) or die('Query failed: ('.$sql.'): ' . mysql_error());
	$count = mysql_num_rows($result);
	if ($status == "new") {
		if ($count == 0) { return true; }
	} else {
		if ($count == 1) { return true; }
	}
	return false;
}