<?php 
	// Check to make sure they entered their last name and it's of the right format. 
	if (eregi ("[[:alnum:][:space:]]", $_POST[firstname])) {
	
	
			$f = TRUE;
	} else {
			$f = FALSE;
			$message[] = "<li>Enter Last Name</li>";
	}
	// Check to make sure they entered their last name and it's of the right format. 
	if (eregi ("[[:alnum:][:space:]]", $_POST[lastname])) {
				$l = TRUE;
	} else {
			$l = FALSE;
			$message[] = "<li>Enter First Name</li>";
	}
	
		
	
	

		// Check to make sure they entered an institution. 

	if (eregi ("[[:alnum:][:space:]]", $_POST[Institution])) {
	
	
			$inst = TRUE;
	} else {
			$inst = FALSE;
			$message[] = "<li>Enter Organization Name</li>";
	}
	
if (eregi ("[[:alnum:][:space:]]", $_POST[bio])) {
	
	
			$b = TRUE;
	} else {
			$b = FALSE;
			$message[] = "<li>Enter Personal Bio</li>";
	}
	
	if (eregi ("[[:alnum:][:space:]]", $_POST[platform])) {
	
	
			$p = TRUE;
	} else {
			$p = FALSE;
			$message[] = "<li>Enter Platform</li>";
	}

	
	// Check to make sure they entered a valid email address. 
	if (eregi("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $_POST[email1])) { 
			$e1 = TRUE;
	} else {
			$e1 = FALSE;
			$message[] = "<li>Enter email address</li>";
	}

	// Check to make sure they entered a valid email address. 
	if (eregi("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $_POST[email2])) { 
			$e2 = TRUE;
	} else {
			$e2 = FALSE;
			$message[] = "<li>Enter confirmation email address</li>";
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
	
	
	

	
	
	
if ($f AND $l AND $e1 AND $e2 AND $e3 AND $s AND $inst AND $b AND $p) {


//required data has been entered and is valid - so make sure they are in the 
//registration database
//************************************************//
//		require_once('mysqlconnect.php');
//	
//		$myemail=$_POST[email1];
//		$sql="SELECT email FROM seppConf_austin where confID='Dec05'";
//		$result= mysql_query($sql);
//		$resultsnumber=mysql_numrows($result);
//
//		while($links=mysql_fetch_array($result))
//		{
//		$id=$links['id']; 
//		$emailadd=$links['email'];
//		if ($emailadd == $myemail) 
//		$found=TRUE;
//		
//		}
//
//	if ($found) {
//		$new=TRUE;
//	//they are registered for the conference
//	 }
//	 else {  //not registered yet
//	 $new=FALSE;
//	 $message[]= "<li><strong>You must be registered for the Sakai Austin conference<br /> in order to add your photo to the facebook. </strong></li>"; 
//	 }
	 
	 
//  if ($new) 
//  {

//  insert the valid statement here if using this option
//}
//************************************************//


  $valid=TRUE;
}
else { 
$valid=FALSE; 
}



?>