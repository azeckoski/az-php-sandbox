<?php 
	// Check to make sure they entered their last name and it's of the right format. 
	if (eregi ("[[:alnum:][:space:]]", $_POST['first'])) {
	
	
			$f = TRUE;
	} else {
			$f = FALSE;
			$message[] = "<li>first name</li>";
	}
	// Check to make sure they entered their last name and it's of the right format. 
	if (eregi ("[[:alnum:][:space:]]", $_POST['last'])) {
				$l = TRUE;
	} else {
			$l = FALSE;
			$message[] = "<li>last name</li>";
	}
	


	
	// Check to make sure they entered a valid email address. 
	if (eregi("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $_POST['email1'])) { 
			$e1 = TRUE;
	} else {
			$e1 = FALSE;
			$message[] = "<li>email address</li>";
	}

	// Check to make sure they entered a valid email address. 
	if (eregi("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $_POST['email2'])) { 
			$e2 = TRUE;
	} else {
			$e2 = FALSE;
			$message[] = "<li>confirmation email address</li>";
	}
	
	

	// Check to make sure the email matches the confirmed email. 
	if ($_POST['email1'] == $_POST['email2']) {
	
			$e3 = TRUE;
	} else {
			$e3 = FALSE;
			$message[] = "<li>The email you entered did not match the confirmed email</li>";	
	}
	
	
	// Check to make sure they entered no spam

		$email=$_POST['email1'];
$domain = strstr($email, '@');
	if ($domain == '@sakaiproject.org') {
			
			$s = FALSE;
		//$message[] = "sakaiproject.org is not a valid email domain.";

	} else {
			$s = TRUE; 
				//no spam

			

	}

		
	
	

		// Check to make sure they entered an institution. 

	if (eregi ("[[:alnum:][:space:]]", $_POST['institution'])) {
	
	
			$inst = TRUE;
	} else {
			$inst = FALSE;
			$message[] = "<li>Enter Organization Name</li>";
	}
	


if (eregi ("[[:alnum:][:space:]]", $_POST['p_title'])) {
	
	
			$title = TRUE;
	} else {
			$title = FALSE;
			$message[] = "<li>Enter a short title</li>";
	}
	
	
if (eregi ("[[:alnum:][:space:]]", $_POST['p_desc'])) {
	
	
			$desc = TRUE;
	} else {
			$d = FALSE;
			$message[] = "<li>Enter brief description</li>";
	}




if (eregi ("[[:alnum:][:space:]]", $_POST['event_name'])) {
	
	
			$event = TRUE;
	} else {
			$event = FALSE;
			$message[] = "<li>Enter  event name</li>";
	}
	
	
if (eregi ("[[:alnum:][:space:]]", $_POST['event_date'])) {
	
	
			$event_date = TRUE;
	} else {
			$event_date = FALSE;
			$message[] = "<li>Enter  event date</li>";
	}




	
	
	

	
	
	
if ($f AND $l AND $s AND $e1 AND $e2 AND $e3 AND $title AND $desc AND $inst AND $event) {


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