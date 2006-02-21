<?  

$today = date("F j, Y"); 

//set up mail message

	 $msg ="Below is your registration confirmation (pending credit card approval) for the Sakai SEPP Austin Conference, scheduled for December 7-9, 2005 in Austin, Texas.
	 \r\n";
	 	 $msg.=" If you have any questions about your registration information please contact kreister@umich.edu. \r\n \r\nThank You\r\n      Sakai Staff\r";
	 	 
	 	 $msg.="-------------------------------------------- \r\n\r\n";
	 	 $msg.="Date Submitted: $today \r\n\r\n";
	 	 $msg.="Registration Fee Paid: $ $transAmount\r\n\r\n";
	 	 $msg.="Order ID #: $transID \r\n\r\n";  
	 	 $msg.="Attendee:  $firstname $lastname \r\n\r\n";
	 	 
	 	 $msg.="Badge Name:  $badge \r\n\r\n";
	 	 
	 	 $msg.="Email:$email\r\n\r\n";
	 	 
	 	 $msg.="Institution:  $otherInst \r\n\r\n";

	 

	 	 $msg.="Department:  $dept \r\n\r\n";

	 	 
	 	 $msg.="Address:\r\n";
	 	 $msg.="\t$address1 \r\n";
	 	 
	 	 $msg.="\t$address2 \r\n";
	 	 
	 	 $msg.="\t$city, $state, $zip,    $country \r\n\r\n";
	 	 

	 	 $msg.="Phone:  $phone  \r\n\r\n";
	 	 $msg.="Fax:   $fax \r\n\r\n";
	 
	 	 $msg.="TShirt size: $shirt \r\n\r\n";
	 	 
	 	 $msg.="Special needs:   $spec \r\n\r\n";
	 	
	 	 $msg.="Attending JA-SIG:   $jasig \r\n\r\n";
	 	
	 	 
	 	 $msg.="Staying at Conf. Hotel:   $hotel \r\n\r\n";
	 	
	 	 
	 	
	 	 $msg.="Publish name on Attendee list:  $contact ";
	 	 
	 	 




	 	 


	 	 
	 	 //set up mail for Susan
	 	 $recipient = "shardin@umich.edu";
	 	 $subject= "PUBLIC-Sakai Austin Registration";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: $email";

	 	 //send the mail to susan
	 	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	  //set up mail for Kathi
	  	 $recipient = "kreister@umich.edu";
	  $subject= "PUBLIC-Sakai Austin Registration";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
		 $mailheaders .="Reply-To: $email";

	 	// send the mail to Kathi
	 	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 	 //set up mail for registrant
	 	 $recipient = "$email";
	 	 $subject= "Sakai Austin Registration Confirmation";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: kreister@umich.edu";

	 	 //send the mail to registrant
	 	 mail($recipient, $subject, $msg, $mailheaders);
$_SESSION['complete']='1';

?>