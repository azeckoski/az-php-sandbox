<?php
/*
 * file: validate.php
 * Created on Mar 11, 2006 1:00:00 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/accounts/include/tool_vars.php';

// connect to database
require $_SERVER["DOCUMENT_ROOT"].$TOOL_PATH.'/sql/mysqlconnect.php';

// global vars - sort of
$PASS = "ok";
$FAIL = "error";
$VALIDATE_TEXT = "";

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
			//writeLog($TOOL_SHORT,"ajax","rules:".$key."=>".$value);
			$params[] = $value; // validation rules
		}
	}

	// required validating handled on javascript side to reduce server traffic

	// pass to the other function
	ProcessItem($formid,$fvalue,$params,"ajax");
}

// this should parse a validation string into an array and then hand it to
// ProcessItem to do the validation for the item
function ProcessVstring($itemname,$itemvalue,$vstring,$output_type) {
	$params = split(":",$vstring);
	// take out the items that are not really validators like focus
	if (in_array('focus', $params)) {
		unset( $params[array_search('focus', $params)] );
	}
	
	// fix indexes
	$params = array_values($params);
	ProcessItem($itemname,$itemvalue,$params,$output_type);
}

// Process the validation rules for this item (formid) and it's value (fvalue)
// The rules are stored in an array and are processed in order
// The output type is ajax, print, or return
// NOTE: print and fail only give back failure info, success outputs nothing or returns blank
function ProcessItem($formid,$fvalue,$params,$output_type) {
	global $TOOL_SHORT;
	global $PASS;
	global $FAIL;
	global $VALIDATE_TEXT;
	$failed = false;
	
	$VALIDATE_TEXT = ""; // clear before doing the validation

	// do the validation
	foreach($params as $value) {
		if ($failed) { break; }
		
		$type = $value;
		if (strpos($value,";") !== false) { // get the special rule type
			$type = substr($value,0,strpos($value,";"));
		}
		
		writeLog($TOOL_SHORT,"ajax","validate:".$type.":".$fvalue);
		if ($type == "required") {
			if(!validateRequired($fvalue)) {
				$failed = true;
			} 
		} else if ($type == "email") {
			if(!validateEmail($fvalue)) {
				$failed = true;
			}
		} else if ($type == "date") {
			if(!validateDate($fvalue)) {
				$failed = true;
			}
		} else if ($type == "time") {
			if(!validateTime($fvalue)) {
				$failed = true;
			}
		} else if ($type == "zip") {
			if(!validateZip($fvalue)) {
				$failed = true;
			}
		} else if ($type == "nospaces") {
			if(!validateNoSpaces($fvalue)) {
				$failed = true;
			}
		} else if ($type == "alpha") {
			if(!validateAlpha($fvalue)) {
				$failed = true;
			}
		} else if ($type == "alphanum") {
			if(!validateAlphaNumeric($fvalue)) {
				$failed = true;
			}
		} else if ($type == "number") {
			if(!validateNumeric($fvalue)) {
				$failed = true;
			}
		}
		// do the special validations
		else if ($type == "uniquesql") {
			// should be uniquesql;(columnname);(tablename);(tableid);(userid)
			$parts = split(';',$value);
			if(!validateUnique($parts[1],$parts[2],$fvalue,$parts[3],$parts[4])) {
				$VALIDATE_TEXT = $formid." already used";
				$failed = true;
			}
		}
	}

	if ($output_type == "ajax") {
		$ajaxReturn = "$PASS|$formid|$VALIDATE_TEXT";
		if ($failed) {
			$ajaxReturn = "$FAIL|$formid|$VALIDATE_TEXT";
		}
		echo $ajaxReturn;
		writeLog($TOOL_SHORT,"ajax","return=$ajaxReturn");
	} else if ($output_type == "print") {
		if ($failed) {
			print $VALIDATE_TEXT;
		}
	}

	// defaults to "return"
	if ($failed) {
		return $VALIDATE_TEXT;
	}
	return "";
}


// ======== VALIDATION FUNCTIONS ========
// validate required field (just checks to see if the field is empty)
function validateRequired($val) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";
	
	// if it is required check to see if it validates
	if (empty($val)) {
		// if val is blank then then the field is invalid
		$VALIDATE_TEXT = "Required, cannot be blank";
		return false;
	}
	return true;
}

// validate email address using regexp
function validateEmail($val) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";

	if(empty($val)) {
		// field is empty
		$VALIDATE_TEXT = "Cannot be blank";
	    return false;
	}

	// check the email address with a regex function
	if  (!eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$', $val)) {
		$VALIDATE_TEXT = "Invalid email address";
		return false;
	}
	return true;
}

// validate date using php function
function validateDate($val) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";

	if(empty($val)) {
		// field is empty
		$VALIDATE_TEXT = "Cannot be blank";
	    return false;
	}

	if (!strtotime($val)) {
		$VALIDATE_TEXT = "Invalid date (use MM/DD/YYYY)";
		return false;
	}
	return true;
}

// validate time using php function
function validateTime($val) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";

	if(empty($val)) {
		// field is empty
		$VALIDATE_TEXT = "Cannot be blank";
	    return false;
	}

	if (!strtotime($val)) {
		$VALIDATE_TEXT = "Invalid time (use HH:MM AM)";
		return false;
	}
	return true;
}

// validate zip code
function validateZip($val) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";

	if(empty($val)) {
		// field is empty
		$VALIDATE_TEXT = "Cannot be blank";
	    return false;
	}

	$Bad = eregi_replace("([-0-9]+)","",$val);	
	if(!empty($Bad)) {
		// invalid chars in zip code
		$VALIDATE_TEXT = "Invalid chars, use numbers and '-' only";
	    return false;
	}
	$Num = eregi_replace("\-","",$val);
	$len = strlen($Num);
	if ( ($len > 10) or ($len < 5) ) {
	    // Invalid length for zipcode
		$VALIDATE_TEXT = "Invalid length, must be 5 to 9 digits";
	    return false;
	}
	return true;
}

// validates an item has no spaces in it
function validateNoSpaces($val) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";
	
	if (ereg('[[:space:]]',$val)) {
		$VALIDATE_TEXT = "Cannot contain spaces";
		return false;
	}
	return true;
}

// validates an item is numeric digits only
function validateNumeric($val) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";
	
	if (!ctype_digit($val)) {
		$VALIDATE_TEXT = "Numeric digits only";
		return false;
	}
	return true;
}

// validates an item is alphabetic chars only
function validateAlpha($val) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";

	if (!ctype_alpha($val)) {
		$VALIDATE_TEXT = "Alphabetic chars only";
		return false;
	}
	return true;
}

// validates an item is alphanumeric chars only
function validateAlphaNumeric($val) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";

	if (!ctype_alnum($val)) {
		$VALIDATE_TEXT = "Alphanumeric chars only";
		return false;
	}
	return true;
}

// checks if an item is unique in the database or in use
// params = (columnname),(tablename),(value),(id),(idvalue)
function validateUnique($columname,$tablename,$val,$id,$idval) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";

	// escape everything first
	$columname = mysql_real_escape_string($columname);
	$tablename = mysql_real_escape_string($tablename);
	$val = mysql_real_escape_string($val);
	$id = mysql_real_escape_string($id);
	$idval = mysql_real_escape_string($idval);

	// if there are any spaces in anything then something is wrong
	if (!validateNoSpaces($columname) || !validateNoSpaces($tablename) ||
		!validateNoSpaces($val) || !validateNoSpaces($id) ||
		!validateNoSpaces($idval)) {
			$VALIDATE_TEXT = "ERROR: Invalid sql";
			return false; // maybe return something else
	}

	// do the sql check
	$sql = "select * from $tablename where $columname = '$val'";
	if ($id != "" && $idval != "") {
		$sql .= " and $id = '$idval'";
	}
	$result = mysql_query($sql) or die('Query failed: ('.$sql.'): ' . mysql_error());
	$count = mysql_num_rows($result);
	if ($count == 0) {
		$VALIDATE_TEXT = "";
		return true;
	}
	$VALIDATE_TEXT = "Item is not unique, enter another";
	return false;
}
