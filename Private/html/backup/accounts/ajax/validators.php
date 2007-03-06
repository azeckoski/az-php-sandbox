<?php
/*
 * file: validators.php
 * Created on Mar 14, 2006 1:00:00 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * 
 * These function do the validation only, if you include this you had better
 * have already made a database connection and loaded the necessary globals
 * through a tool_vars file or something like that
 * 
 * Create an array like the one below, the automatic validator will use this array
 * to validate all items that it receives that match the names in the array
 * Then add a call after the array to the validator function
 * output_type = print or return
 * $vItems = array();
 * $vItems['title'] = "required:focus";
 * ServerValidate($vItems, $output_type);
 * 
 */
/***** sample clean html *****
Item name
<img id="Img" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
<input type="text" name="p_title" size="40" maxlength="75" value="<?= $item['item'] ?>" />
<input type="hidden" id="Validate" value="<?= $vItems['item'] ?>" />
<span id="Msg"></span>
******/
?>
<?php
// global vars - sort of
$VALIDATE_TEXT = "";


// this should validate every item that was received on this page
// that matches the names in the array that was passed to it
// The output type is print, array, or return
function ServerValidate($vItems, $output_type) {
	$outputString = "";
	$printString = "<fieldset><legend>Validation Errors</legend>";
	$outputArray = array();
	foreach ($_REQUEST as $itemname=>$itemvalue) {
		if (array_key_exists($itemname, $vItems)) {
			$vstring = $vItems[$itemname];
			$outputArray[$itemname] = ProcessVstring($itemname,$itemvalue,$vstring,$output_type);
			if ($outputArray[$itemname]) {
				$outputString .= "<b>".$itemname.":</b> " . $outputArray[$itemname]."<br/>";
			}
		}
	}
	if ($output_type == "array") {
		return $outputArray;
	} else if ($output_type == "print") {
		if ($outputString) { $printString .= $outputString . "</fieldset>"; }
		print $printString;
	}
	return $outputString;
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
	return ProcessItem($itemname,$itemvalue,$params,$output_type);
}


// Process the validation rules for this item (formid) and it's value (fvalue)
// The rules are stored in an array and are processed in order
// The output type is ajax, print, array, or return
// clear is a special action that sends back a "clear" response instead of pass/fail
// NOTE: print and fail only give back failure info, success outputs nothing or returns blank
function ProcessItem($formid,$fvalue,$params,$output_type) {
	global $TOOL_SHORT;
	$PASS_VALUE = "ok";
	$FAIL_VALUE = "error";
	global $VALIDATE_TEXT;
	$failed = false;
	
	$VALIDATE_TEXT = ""; // clear before doing the validation

	if (!validateRequired($fvalue) && !array_key_exists("required",$params)) {
		// blank and not required
		return "";
	}

	// do the validation
	foreach($params as $value) {
		if ($failed) { break; }
		
		$type = $value;
		if (strpos($value,";") !== false) { // get the special rule type
			$type = substr($value,0,strpos($value,";"));
		}
		
		writeLog($TOOL_SHORT,"ajax","validate:".$type.":".$fvalue);
		if ($type == "required" || $type == "notblank") {
			if(!validateRequired($fvalue)) {
				$failed = true;
			}
		} else if ($type == "email") {
			if(!validateEmail($fvalue)) {
				$failed = true;
			}
		} else if ($type == "phone") {
			if(!validatePhone($fvalue)) {
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
		} else if ($type == "zip" || $type == "zipcode") {
			if(!validateZip($fvalue)) {
				$failed = true;
			}
		} else if ($type == "nospaces" || $type == "password") {
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
		} else if ($type == "name") {
			if(!validateAlphaName($fvalue)) {
				$failed = true;
			}
		} else if ($type == "namespaces") {
			if(!validateAlphaNameSpaces($fvalue)) {
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
		$status = $PASS_VALUE;
		if ($failed) {
			$status = $FAIL_VALUE;
		}
		$ajaxReturn = "$status|$formid|$VALIDATE_TEXT";
		echo $ajaxReturn;
		writeLog($TOOL_SHORT,"ajax","return=$ajaxReturn");
	} else if ($output_type == "print") {
		if ($failed) {
			print $VALIDATE_TEXT . "<br>";
		}
	} else if ($output_type == "array") {
		if ($failed) {
			return $VALIDATE_TEXT;
		}
	}

	// defaults to "return"
	if ($failed) {
		return $VALIDATE_TEXT . "<br>";
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

	// check the email address with a regex function
	if  (!eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$', $val)) {
		$VALIDATE_TEXT = "Invalid email address";
		return false;
	}
	return true;
}

// validate phone numbers using regexp
function validatePhone($val) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";

	$Num = ereg_replace("[[:space:]]","",$val); // strip all spaces out first
	$Num = eregi_replace("(\(|\)|\-|\+|\.)","",$Num); // strip out other chars
	if(!ctype_digit($Num)) {
		$VALIDATE_TEXT = "Invalid phone number (e.g. (###) ###-####)";
		return false;
	}

	// min of 7 digits
	if ( (strlen($Num)) < 7) {
		$VALIDATE_TEXT = "Invalid phone number, too short";
		return false;
	}

	// max of 15 digits with 2 digit country code, 9 numbers, and 4 digit extension
	if( (strlen($Num)) > 15) {
		$VALIDATE_TEXT = "Invalid phone number, too long";
		return false;
	}
	return true;
}

// validate date using php function
function validateDate($val) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";

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

	$Bad = ereg_replace("([0-9A-Z[:space:]-]+)","",$val);
	if(!empty($Bad)) {
		// invalid chars in zip code
		$VALIDATE_TEXT = "Invalid chars, use A-Z, numbers and '-' only";
	    return false;
	}

	if (ereg("[A-Z]",$val)) {
		// letters, this must be canadian
		if (!ereg("[A-Z][0-9][A-Z] [0-9][A-Z][0-9]",$val)) {
			$VALIDATE_TEXT = "Invalid Canadian zip (e.g. A1B 2C3)";
			return false;
		}
	} else {
		// must be US zip code
		$Num = eregi_replace("\-","",$val);
		$len = strlen($Num);
		if ( ($len != 9) && ($len != 5) ) {
		    // Invalid length for zipcode
			$VALIDATE_TEXT = "Invalid US zip, must be 5 or 9 digits";
		    return false;
		}
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

// validates an item is alphanumeric with spaces and .-_ only (name)
function validateAlphaName($val) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";

	if (ereg('[^a-zA-Z0-9_.-]{1,}', $val)) {
		$VALIDATE_TEXT = "Alphanumeric chars and _.- only";
		return false;
	}
	return true;
}

// validates an item is alphanumeric with spaces and .-_ only (name)
function validateAlphaNameSpaces($val) {
	global $VALIDATE_TEXT;
	$VALIDATE_TEXT = "";

	if (ereg('[^[:space:]a-zA-Z0-9_.-]{1,}', $val)) {
		$VALIDATE_TEXT = "Alphanumeric chars, spaces, and _.- only";
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
		$sql .= " and $id != '$idval'";
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
?>