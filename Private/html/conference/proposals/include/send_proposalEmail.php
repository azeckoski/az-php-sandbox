<?php


$email_sql="Select * from `conf_proposals` WHERE id='$proposals_pk' ";

$result= mysql_query($email_sql);



while($presentation=mysql_fetch_array($result))
{

$date=stripslashes($presentation['date']);
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

$title=stripslashes($presentation['title']);
$abstract=stripslashes($presentation['abstract']);
$desc=stripslashes($presentation['desc']);
$speaker=stripslashes($presentation['speaker']);
$bio=stripslashes($presentation['bio']);
$co_speaker=stripslashes($presentation['co_speaker']);
$co_bio=stripslashes($presentation['co_bio']);
$url=$presentation['URL'];


$today = date("F j, Y"); 


      
//set up mail message
//echo $length;

	 
	$msg .="Your Sakai Vancouver conference Presentation proposal details are shown below.  You will receive one message for each presentation or technical demo you submitted.\r\n \r\n";
	$msg .="Please respond to this email with any corrections or comments regarding this information.  \r\n";
	 
	 	 $msg.="\r\nThank You\r\n      Susan Hardin\r\nwww.sakaiproject.org webmaster\r\n";
	 	
	 	 
	 	 $msg.="-------------------------------------------- \r\n\r\n";
	 	 $msg.="Date Submitted: $today \r\n\r\n";
	 	 
	 	 $msg.="Proposal:  PRESENTATION  \r\n\r\n";
	 	 $msg.="Submitted by:  $firstname $lastname  \r\n\r\n";
	 	 $msg.="Email:  $email  \r\n\r\n";
	 	 $msg.="Format:  $type  \r\n\r\n";
	 	 $msg.="Title: $title  \r\n\r\n";
	 	 $msg.="Abstract:\r\n  $abstract  \r\n\r\n";
	 	 $msg.="Description:\r\n  $desc  \r\n\r\n";
	 	 $msg.="Project URL:  $url  \r\n\r\n";
	 	 $msg.="Primary Speaker:  $speaker  \r\n\r\n";
	 	 $msg.="Speaker Bio: \r\n $bio \r\n\r\n";
	 	 $msg.="Co-Speaker (s):  $co_speaker  \r\n\r\n";
	 	// $msg.="Co-speaker Bio: \r\n $co_bio \r\n\r\n";

	  	
	 	$msg.="\r\nPresentation layout:  ";
 		if ($layout=='class')
	 	$msg .="Classroom \r\n ";
	 	if ($layout=="theater")
	 	$msg .="Theater  \r\n ";
	 	if ($layout=="conference")
	 	$msg .="Conference (roundtable) \r\n";
	 	

	 	$msg.="\r\nPresentation length: $length minutes \r\n\r\n ";
	 	$msg.="Availability:  ";
	 	
	 	if ($conflict) {
	 		 	$msg .="unavailable $conflict" ;
	 	}
	 	else {
	 		 	$msg .="available all days ";
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
$subject= "COPY-Vancouver CFP Presentation- $lastname";
//send the mail to susan
mail($recipient, $subject, $msg, $headers);


// This is a better set of mail headers -AZ
ini_set(SMTP, $MAIL_SERVER);
$headers  = 'From: ' . $HELP_EMAIL . "\n";
$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
$headers .= 'Reply-To: ' . $email . "\n";
$headers .= 'MIME-Version: 1.0' ."\n";
$headers .= 'Content-type: text/plain; charset=ISO-8859-1' ."\n";
$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";

//set up mail for attendee
$recipient = "$email";
$subject= "Sakai Call for Proposals: Presentation- $lastname";
//send the mail to attendee
mail($recipient, $subject, $msg, $headers);
 	 

	 	 
	 	 	 //	 echo "done sending user copy<br />";

}

	 	 //echo "done with all messages<br />";

?>
