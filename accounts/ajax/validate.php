<?php
/*
 * file: validate.php
 * Created on Mar 11, 2006 1:00:00 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * 
 * This should only be called via AJAX, if you include this file in 
 * your normal PHP them you will probably break something
 */
?>
<?php
require $_SERVER["DOCUMENT_ROOT"].'/accounts/include/tool_vars.php';

// connect to database
require $_SERVER["DOCUMENT_ROOT"].$TOOL_PATH.'/sql/mysqlconnect.php';

// Load User and Inst PROVIDERS
require $ACCOUNTS_PATH.'include/providers.php';

// bring the validator functions
require 'validators.php';

// run the ajax stuff if the ajax var is set
if ($_REQUEST["ajax"]) {
	ProcessAjax();
	exit();
}

// validates a single field via AJAX, all data passed in the get string
function ProcessAjax() {

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
			$params[] = $value; // validation rules
		}
	}

	// required validating handled on javascript side to reduce server traffic

	// pass to the other function
	ProcessItem($formid,$fvalue,$params,"ajax");
}
?>