<?  
/*
if ($_SESSION['memberType'] =="1") {
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
	 	 $publish = $_SESSION['publish'];
	 	 $co_registrant=$_SESSION['co_registrant'];
}	 	 
	 	 $today = date("F j, Y"); 
*/

//set up mail message

	 $msg ="Thank you for your registration to the Sakai Vancouver Conference, scheduled for May 30 to June 2, 2006 in Vancouver B.C.
	 \r\n";
	 	 $msg.=" If you have any questions about your registration information please contact kreister@umich.edu. \r\n \r\nThank You\r\n      Sakai Staff\r";
	 	 
	 	 $msg.="-------------------------------------------- \r\n\r\n";
	 	 $msg.="Date Submitted: $today \r\n\r\n";
	 	
	 	
	 	 $msg.="Attendee:  $firstname $lastname, $email\r\n\r\n";
	 	 
	 	
	 	if ($badge){
	 	 $msg.="Badge Name:  $badge \r\n\r\n";
	 	 
	 	 }
	 	 
	// 	 $msg.="Email:$email\r\n\r\n";
	 	 
	 	 if ($otherInst){
	 	 $msg.="Organizatoin:\r\n$otherInst \r\n";
		}
	 	 else {
	 	 $msg.="Organization:\r\n$institution \r\n";
	 	 }

	 	 
	 	// $msg.="Address:\r\n";
	 	 $msg.="$address1 \r\n";
	 		 	 
	 	 $msg.="$city, $state, $zip,    $country \r\n\r\n";
	 	 

	 	 $msg.="Phone:  $phone  \r\n\r\n";
	 	 if ($fax) {
	 	 $msg.="Fax:   $fax \r\n\r\n";
	 }
	 	 $msg.="TShirt size: $shirt \r\n\r\n";
	 	 
	 	 if ($special) {
	 	 $msg.="Special needs:   $special \r\n\r\n";
	 	 }
	 	 else {
	 	 	 	 $msg.="Special needs:  none \r\n\r\n";

	 	 
	 	 }
	 	
	 	 $msg.="Attending JA-SIG:   $jasig \r\n\r\n";
	 	
	 	 $msg.="Staying at Conf. Hotel:   $hotelInfo \r\n\r\n";
	 	 
	 	if ($publish){
	 	 $msg.="Publish name on Attendee list:  $publish ";
	 	 }
	 
	 	   if ($co_registrant){
	 	 $msg.="\r\n----------------------------------------------------------\r\nYour Registration was submitted by: \r\n\r\n$co_registrant \r\n----------------------------------------------------------";
	 	 }
	 	   if ($fee > 0){
	 	 $msg.="\r\n----------------------------------------------------------\r\nPayment Information: \r\n\r\n Paid by:\r\n$payeeInfo \r\n\r\n Transaction ID: $transID\r\n\r\n Amount Paid: $transAmount \r\n----------------------------------------------------------";
	 	 }


	 	 
	 	 //set up mail for Susan
	 	 $recipient = "shardin@umich.edu";
	 	 $subject= "COPY-Vancouver Reg- $lastname";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: sakaiproject_webmaster@umich.edu \n";
	 	 $mailheaders .="Reply-To: $email";

	 	 //send the mail to susan
	 	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	  //set up mail for Kathi
	 	 	 $recipient = "kreister@umich.edu";
	  $subject= "COPY-Vancouver Registration";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: sakaiproject_webmaster@umich.edu \n";
	 	 $mailheaders .="Reply-To: $email";

	 	 //send the mail to Kathi
	 	 //mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 	 //set up mail for registrant
	 	 $recipient = "$email";
	 	 $subject= "Sakai Conference Registration";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: sakaiproject_webmaster@umich.edu \n";
	 	 $mailheaders .="Reply-To: kreister@umich.edu";

	 	 //send the mail to registrant
	 	 mail($recipient, $subject, $msg, $mailheaders);


?>