<?php 

//validate the attendee contact information 
if (isset($_POST['submit_attendee'])) {
	// Check to make sure they entered their last name and it's of the right format. 
	if (eregi ("[[:alnum:][:space:]]", $_POST[firstname])) {
	
	
			$f = TRUE;
	} else {
			$f = FALSE;
			$message[] = "<li>first name</li>";
	}
	// Check to make sure they entered their last name and it's of the right format. 
	if (eregi ("[[:alnum:][:space:]]", $_POST[lastname])) {
				$l = TRUE;
	} else {
			$l = FALSE;
			$message[] = "<li>last name</li>";
	}
	
	// Check to make sure they entered a valid email address. 
	if (eregi("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $_POST[email1])) { 
			$e1 = TRUE;
	} else {
			$e1 = FALSE;
			$message[] = "<li>email address</li>";
	}

	// Check to make sure they entered a valid email address. 
	if (eregi("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $_POST[email2])) { 
			$e2 = TRUE;
	} else {
			$e2 = FALSE;
			$message[] = "<li>confirmation email address</li>";
	}
	
	// Check to make sure the email matches the confirmed email. 
	if ($_POST[email1] == $_POST[email2]) {
	
			$e3 = TRUE;
	} else {
			$e3 = FALSE;
			$message[] = "<li>The email you entered did not match the confirmed email</li>";	
	}
	
	// Check to make sure they entered no spam

		$email=$_POST[email1];
		$domain = strstr($email, '@');
	if ($domain == '@sakaiproject.org') {
			
			$s = FALSE;
		//$message[] = "sakaiproject.org is not a valid email domain.";

	} else {
			$s = TRUE; 
				//no spam
	}
	
	// Check to make sure they entered a role/title

	if ($_POST['title']){
	$title = TRUE;
	} else {
			$title = FALSE;
			$message[] = "<li>Title</li>";
	}
	
	// Check to make sure they entered an institution
	if (isset($_POST['otherInst'])){
			 	$inst = TRUE;

	}  else {
		 	if ($_POST['institution']){
    
			$inst = TRUE;
	} else { 
	$inst = FALSE;
			$message[] = "<li>Organization</li>";
	}		 
	}
	
	
     if ($_POST['address1']){
	$add = TRUE;
	} else {
			$add = FALSE;
			$message[] = "<li>Address</li>";
	}		 
      if ($_POST['city']){
	$city = TRUE;
	} else {
			$city = FALSE;
			$message[] = "<li>Town/City</li>";
	}	
	
  if ($_POST['state']){
    
	$state = TRUE;
	} else {  if ($_POST['otherState']){
	$state=TRUE;
	}
	else { 
	$state = FALSE;
			$message[] = "<li>State</li>";
	}	
	
	}    if ($_POST['zip']){
	$zip = TRUE;
	} else {
			$zip = FALSE;
			$message[] = "<li>Zip/Postal Code</li>";
	}		 
      if ($_POST['country']){
	$country = TRUE;
	} else {
			$country = FALSE;
			$message[] = "<li>Country</li>";
	}		 
	
      if ($_POST['phone']){
	$phone = TRUE;
	} else {
			$phone = FALSE;
			$message[] = "<li>Phone</li>";
	}
	

	if ($title AND $inst AND $add AND $city AND $state AND $zip
	AND $country AND $phone AND $f AND $l AND $e1 AND $e2 AND $e3 AND $s){
	
	$valid=TRUE;
	}

}


//Validate the co_registrant information
elseif (isset($_POST['submit_coReg'])) {

	// Check to make sure they entered their last name and it's of the right format. 
	if (eregi ("[[:alnum:][:space:]]", $_POST[co_firstname])) {
	
	
			$f = TRUE;
	} else {
			$f = FALSE;
			$message[] = "<li>Enter your first name</li>";
	}
	// Check to make sure they entered their last name and it's of the right format. 
	if (eregi ("[[:alnum:][:space:]]", $_POST[co_lastname])) {
				$l = TRUE;
	} else {
			$l = FALSE;
			$message[] = "<li>Enter your last name</li>";
	}
	
	// Check to make sure they entered a valid email address. 
	if (eregi("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $_POST[co_email1])) { 
			$e1 = TRUE;
	} else {
			$e1 = FALSE;
			$message[] = "<li>Enter your email address</li>";
	}

	// Check to make sure they entered a valid email address. 
	if (eregi("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $_POST[co_email2])) { 
			$e2 = TRUE;
	} else {
			$e2 = FALSE;
			$message[] = "<li>Confirm your email address</li>";
	}
	
	// Check to make sure the email matches the confirmed email. 
	if ($_POST[co_email1] == $_POST[co_email2]) {
	
			$e3 = TRUE;
	} else {
			$e3 = FALSE;
			$message[] = "<li>The email you entered did not match the confirmed email</li>";	
	}
	
	
	// Check to make sure they entered no spam

		$email=$_POST[co_email1];
$domain = strstr($email, '@');
	if ($domain == '@sakaiproject.org') {
			
			$s = FALSE;
		//$message[] = "sakaiproject.org is not a valid email domain.";

	} else {
			$s = TRUE; 
				//no spam
	}
	if ($_POST['co_phone']){
	$phone = TRUE;
	} else {
			$phone = FALSE;
			$message[] = "<li>Enter your phone number</li>";
	}

	
if ($f AND $l AND $e1 AND $e2 AND $e3 AND $s AND $phone) {
$valid=TRUE;
}
else { 
$valid=FALSE; 
}
}

//validate the OtherInfo form
elseif ( (isset($_POST['submit_NonMemberReg'])) || (isset($_POST['submit_MemberReg'])) ) {
if ($_POST['shirt']){
	$shirt = TRUE;
	} else {
			$shirt = FALSE;
			$message[] = "<li>T-Shirt size</li>";
	}
	
	if ($_POST['jasig']){
	$jasig = TRUE;
	} else {
			$jasig = FALSE;
			$message[] = "<li>JA-SIG conference attendance</li>";
	}
    if ($_POST['hotelInfo']){
	$hotelInfo = TRUE;
	} else {
			$hotelInfo = FALSE;
			$message[] = "<li>Hotel Information</li>";
	}
	
	if ($shirt AND $jasig AND $hotelInfo)  {
	$valid=TRUE;
	
	}
	

}
?>