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
	
if ($f AND $l AND $e1 AND $e2 AND $e3 AND $s) {
$valid=TRUE;
}
else { 
$valid=FALSE; 
}

?>