<?php 
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
	
	$email=$_POST[email1];
$domain = strstr($email, '@');
// Check to make sure they entered no spam
	if ($domain == '@sakaiproject.org') {
			
			$s = FALSE;
		$message[] = "sakaiproject.org is not a valid email domain.";

	} else {
			$s = TRUE; 
				//no spam

			

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
	
		if (isset($_POST[type])) {

		//one of the presentation types has been selected
	
			$t = TRUE;
	} else {
			$t = FALSE;
			$message[] = "<li>Please select the type of proposal you wish to submit</li>";
	}
	
	if ($f AND $l AND $e1 AND $e2 AND $e3 AND $s AND $t) {
$validated=TRUE;
}



//if ($t) {
//$validated = TRUE;
//}
//else {
//$validated= FALSE;
//}

?>