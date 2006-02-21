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

	 $msg ="Thank you for your Sakai Vancouver Conference Proposal Submission. \r\n";
	 	 $msg.="Number of Presentation Proposals Submitted:   $_SESSION[num_pres] \r\n";
	 	 $msg.="Number of Technical Demo Proposals Submitted:  $_SESSION[num_demo]  \r\n\r\n";
	 
	 	 $msg.=" If you have any questions about the following confirmation, please contact Susan Hardin at shardin@umich.edu.   \r\n \r\nThank You\r\n      Sakai Staff\r\n\r\n";
	 	 
	 	 $msg.="------- Your contact information  ---------- \r\n\r\n";
	 	 $msg.="Date Submitted: $today \r\n\r\n";
	 	 $msg.="Submitter:  $firstname $lastname \r\n\r\n";
	 	 
	 	 
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
	 
	 	 
	 	




	 	 


	 	 
	 	 //set up mail for Susan
	 	 $recipient = "shardin@umich.edu";
	 	 $subject= "COPY-Vancouver CFP Contact Info - $lastname ";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: sakaiproject_webmaster@umich.edu \n";
	 	 $mailheaders .="Reply-To: $email";

	 	 //send the mail to susan
	 	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 	 	 
	 	 //set up mail for registrant
	 	 $recipient = "$email";
	 	 $subject= "Sakai- Vancouver CFP Confirmation";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: sakaiproject_webmaster@umich.edu \n";
	 	 $mailheaders .="Reply-To: shardin@umich.edu";

	 	 //send the mail to registrant
 	 mail($recipient, $subject, $msg, $mailheaders);


?>