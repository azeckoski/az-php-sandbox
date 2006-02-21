<?  
$firstname = $_SESSION['firstname']; 
	 	 $lastname = $_SESSION['lastname'];
	 	 $badge = $_SESSION['badge'];
	 	 $email = $_SESSION['email1'];
	 	 $institution = $_SESSION['institution'];
	 	 $otherInst = $_SESSION['otherInst'];
	 	 $dept = $_SESSION['dept'];
	 	 $address1 = $_SESSION['address1'];
	 	 $address2 = $_SESSION['address2'];
	 	 $city = $_SESSION['city'];
	 	 $state = $_SESSION['state'];
	 	 $otherState = $_SESSION['otherState'];
	 	 $zip = $_SESSION['zip'];
	 	 $country = $_SESSION['country'];
	 	 $phone = $_SESSION['phone'];
	 	 $fax = $_SESSION['fax'];
	 	 $shirt = $_SESSION['shirt'];
	 	 $special = $_SESSION['special'];
	 	 $hotelInfo = $_SESSION['hotelInfo'];
	 	 $jasig = $_SESSION['jasig'];
	 	 $ospi = $_SESSION['ospi'];
	 	 $contactInfo = $_SESSION['contactInfo'];

//set up mail message

	 $msg ="Thank you for your registration to the Sakai SEPP Austin Conference, scheduled for December 7-9, 2005 in Austin, Texas.
	 \r\n";
	 	 $msg.=" If you have any questions about your registration information please contact kreister@umich.edu. \r\n \r\nThank You\r\n      Sakai Staff\r";
	 	 
	 	 $msg.="-------------------------------------------- \r\n\r\n";
	 	 $msg.="Date Submitted: $today \r\n\r\n";
	 	 $msg.="Attendee:  $firstname $lastname \r\n\r\n";
	 	 
	 	 $msg.="Badge Name:  $badge \r\n\r\n";
	 	 
	 	 $msg.="Email:$email\r\n\r\n";
	 	 
	 	 if ($_POST['institution']=="Other")
	 	 $msg.="Institution:  $otherInst \r\n\r\n";

	 	 else
	 	 $msg.="Organization:  $institution \r\n\r\n";
	 	 

	 	 $msg.="Department:  $dept \r\n\r\n";

	 	 
	 	 $msg.="Address:\r\n";
	 	 $msg.="\t$address1 \r\n";
	 	 
	 	 $msg.="\t$address2 \r\n";
	 	 
	 	 $msg.="\t$city, $state, $zip,    $country \r\n\r\n";
	 	 

	 	 $msg.="Phone:  $phone  \r\n\r\n";
	 	 $msg.="Fax:   $fax \r\n\r\n";
	 
	 	 $msg.="TShirt size: $shirt \r\n\r\n";
	 	 
	 	 $msg.="Special needs:   $special \r\n\r\n";
	 	
	 	 $msg.="Attending JA-SIG:   $jasig \r\n\r\n";
	 	
	 	 $msg.="Staying at Conf. Hotel:   $hotelInfo \r\n\r\n";
	 	 
	 	
	 	 $msg.="Publish name on Attendee list:  $contactInfo ";
	 
	 	 


	 	 
	 	 //set up mail for Susan
	 	 $recipient = "shardin@umich.edu";
	 	 $subject= "COPY-SEPP Austin Registration";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: $_SESSION[email1]";

	 	 //send the mail to susan
	 	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	  //set up mail for Kathi
	 	 	 $recipient = "kreister@umich.edu";
	  $subject= "COPY-SEPP Austin Registration";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: $_SESSION[email1]";

	 	 //send the mail to Kathi
	 	 //mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 	 //set up mail for registrant
	 	 $recipient = "$_SESSION[email1]";
	 	 $subject= "SEPP Austin Registration Confirmation";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: kreister@umich.edu";

	 	 //send the mail to registrant
	 	 mail($recipient, $subject, $msg, $mailheaders);


?>