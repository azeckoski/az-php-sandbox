<?php

/*******************************/
//start registration process
/*******************************/

$formID="start";

if (isset($_POST['submit_start'])) {
//Process the start.php registration form

	if (!isset($_POST['memberType']))
		$message[]="select member or non-member<br />";
	
	if (!isset($_POST['regType']))
		$message[]="Are you registering yourself, or someone else?<br />";
	
	if ($_POST['memberType']=="1"){
		if ($_POST['institution']=="") {
			//selected Member button, but did not select an institution from the drop down list
			$message[]="Please select your organization.";
		}
	}
	
	if (!$message) {  //a valid form
		//session_start();
		$_SESSION['memberType']=$_POST['memberType'];
		$_SESSION['institution']=$_POST['institution'];
		$_SESSION['regType']=$_POST['regType'];
		
		
		if ($_SESSION['regType']=="2") {
			$formID="co_registrant";
		} else {
			$formID="attendee"; 
		}
	}
} elseif (isset($_POST['submit_coReg'])) {
	//Process the co-registrant  information form
	
	require ('includes/validateForms.php');
	
	if ($valid){
		session_start();
		$_SESSION['co_firstname']=$_POST['co_firstname'];
		$_SESSION['co_lastname']=$_POST['co_lastname'];
		$_SESSION['co_email1']=$_POST['co_email1'];
		$_SESSION['co_phone']=$_POST['co_phone'];
		
		$formID="attendee";  //continue to attendee registration form
	} else{
		$formID="co_registrant";  //redisplay the  co_registrant form with errors
	}
} elseif (isset($_POST['submit_attendee'])) { 
	//Process the attendee contact information form
	session_start();
	require ('includes/validateForms.php');
	if ($valid) {
		//check to see if duplicate registration
		
		$myemail=$_POST['email1'];
		$sql="SELECT email FROM sakaiConf_vancouver where confID='June06'";
		$result= mysql_query($sql);
		$resultsnumber=mysql_numrows($result);
		
		while($links=mysql_fetch_array($result))
		{
			$id=$links["id"]; 
			$emailadd=$links["email"];
			$first=$links["firstname"];
			if ($emailadd == $myemail) 
			$found="TRUE";
		}
		
		//this next line for testing only
		//to allow duplicate entries by those testing registration
		
		$found=FALSE;
		
		//
		
		if (!$found) {
			//not previously registered 
			session_start();
			
			$_SESSION['firstname']=$_POST['firstname'];
			$_SESSION['lastname']=$_POST['lastname'];
			$_SESSION['title']=$_POST['title'];
			$_SESSION['badge']=$_POST['badge'];
			$_SESSION['email1']=$_POST['email1'];
			$_SESSION['address1']=$_POST['address1'];
			$_SESSION['otherInst']=$_POST['otherInst'];
			$_SESSION['city']=$_POST['city'];
			$_SESSION['state']=$_POST['state'];
			$_SESSION['otherState']=$_POST['otherState'];
			$_SESSION['zip']=$_POST['zip'];
			$_SESSION['phone']=$_POST['phone'];
			$_SESSION['fax']=$_POST['fax'];
			$_SESSION['country']=$_POST['country'];
			
			
			$formID="otherInfo"; //continue to extra conference information form
			
		} else { 
			//already registered
			session_start();
			 $message[]= "Your name and email have already been entered into our registration database.
			 <br />If you have any questions about your registration information please contact kreister@umich.edu.   "; 
			 $formID="attendee"; //show registrant name an contact entry page and errors
		}
	}
	
	if ($message) {  //form errors  on attendee contact page
		$formID="attendee"; //redisplay attendee form with errors
	}
}  //end attendee contact form evaluation
elseif (isset($_POST['submit_NonMemberReg'])) {
	// Process otherInfo form for nonmember registration
	
	require('includes/validateForms.php');
	if ($valid){
		session_start();
		$_SESSION['special']=$_POST['special'];
		$_SESSION['publish']=$_POST['publish'];
		$_SESSION['confHotel']=$_POST['confHotel'];
		$_SESSION['jasig']=$_POST['jasig'];
		$_SESSION['shirt']=$_POST['shirt'];
		
		require('includes/submit_PayReg.php'); //add nonmember to sakaiConf_vancouver_ccard table
		header("Location:payment.php");  //begin VerisignPayment process
	} else {  //errors
		session_start();
		$formID="otherInfo"; //show registrant address info page and errors
	}
}
elseif (isset($_POST['submit_MemberReg'])) {
	// Process otherInfo form for member registration
	
	require('includes/validateForms.php');
	if ($valid){  
		session_start();
		$_SESSION['special']=$_POST['special'];
		$_SESSION['publish']=$_POST['publish'];
		$_SESSION['confHotel']=$_POST['confHotel'];
		$_SESSION['jasig']=$_POST['jasig'];
		$_SESSION['shirt']=$_POST['shirt'];
		
		require('includes/submit_MemberReg.php');
		
		$formID="member_confirmation";  //show member registration confirmation
	} else {  //errors
		session_start();
		$formID="otherInfo"; //show registrant address info page and errors
	}
}

?>