<?php
// get all the information that is needed into the correct variables for the email confirmation
$firstname=$USER["firstname"];
$lastname=$USER["lastname"];
$email=$USER["email"];
$address1=$USER["address"];
$city=$USER["city"];
$state=$USER["state"];
$zip=$USER["zipcode"];
$country=$USER["country"];
$phone=$USER["phone"];
$fax=$USER["fax"];

$shirt=$CONF["shirt"];
$special=$CONF["special"];
$hotel=$CONF["confHotel"];
$jasig=$CONF["jasig"];
$publish=$CONF["publishInfo"];
$fee=$CONF["fee"];
$title=$CONF["title"];
$co_registrant=$CONF["delegate"];

$institution = $INST["name"];
if ($USER["otherInst"]) { $institution = $USER["otherInst"]; }


$today = date("F j, Y"); 

//set up mail message

	 $msg ="Thank you for your registration to the Sakai Vancouver Conference, scheduled for May 30 to June 2, 2006 in Vancouver B.C.
	 \r\n";
	 	 $msg.=" If you have any questions about your registration information please contact kreister@umich.edu. \r\n \r\nThank You\r\n      Sakai Staff\r";
	 	 
	 	 $msg.="-------------------------------------------- \r\n\r\n";
	 	 $msg.="Date Submitted: $today \r\n\r\n";
	 	
	 	
	 	 $msg.="Attendee:  $firstname $lastname, $email\r\n\r\n";
	 	 
	 	 
	 	
	 	 $msg.="Organization:\r\n$institution \r\n";
	 	 

	 	 
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
	 	
	 	 $msg.="Staying at Conf. Hotel:   $confHotel \r\n\r\n";
	 	 
	 	if ($publish){
	 	 $msg.="Publish name on Attendee list:  $publish ";
	 	 }
	 
	 	   if ($co_registrant){
	 	 $msg.="\r\n----------------------------------------------------------\r\nYour Registration was submitted by: \r\n\r\n$co_registrant \r\n----------------------------------------------------------";
	 	 }
	 	   if ($fee > 0){
	 	 $msg.="\r\n----------------------------------------------------------\r\nPayment Information: \r\n\r\n Paid by:\r\n$payeeInfo \r\n\r\n Transaction ID: $transID\r\n\r\n Amount Paid: $transAmount \r\n----------------------------------------------------------";
	 	 }

// This is a better set of mail headers -AZ
ini_set(SMTP, $MAIL_SERVER);
$headers  = 'From: ' . $HELP_EMAIL . "\n";
$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
$headers .= 'Reply-To: ' . $email . "\n";
$headers .= 'MIME-Version: 1.0' ."\n";
$headers .= 'Content-type: text/plain; charset=ISO-8859-1' ."\n";
$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";

//set up mail for Susan
$recipient = "shardin@umich.edu";
$subject= "COPY-Vancouver Reg-$firstname $lastname";
//send the mail to susan
mail($recipient, $subject, $msg, $headers);

/*******	 
 //set up mail for Susan with the old mail method
 $recipient = "shardin@umich.edu";
 $subject= "COPY-Vancouver Registration";
 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
 $mailheaders .="From: sakaiproject_webmaster@umich.edu \n";
 $mailheaders .="Reply-To: $email";
 //send the mail to Susan
 mail($recipient, $subject, $msg, $mailheaders);
********/

//set up mail for registrant
$headers  = 'From: ' . $HELP_EMAIL . "\n";
$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
$headers .= 'Reply-To: ' . "kreister@umich.edu" . "\n";
$headers .= 'MIME-Version: 1.0' ."\n";
$headers .= 'Content-type: text/plain; charset=ISO-8859-1' ."\n";
$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";

$recipient = "$email";
$subject= "Sakai Conference Registration";
 //send the mail to registrant
 mail($recipient, $subject, $msg, $headers);

?>