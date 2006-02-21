<?php
require "../includes/mysqlconnect.php";

$sql="Select * from `cfp_austin_demo` WHERE id='$user_id' ";


$result= mysql_query($sql);



while($links=mysql_fetch_array($result))
{
$row++; 
$id=$links["id"];
$date=$links["date"];
$conf=$links["confID"]; 
$last=$links["lastname"];
$first=$links["firstname"];
$emailadd=$links["email1"];

$product=$links["product"];
$desc=$links["demo_desc"];
$speaker=$links["demo_speaker"];
$url=$links["demo_url"];

      
//set up mail message


	 
	$msg .="Your Call for Proposals details are shown below.  You will receive one message for each presentation or technical demo you submitted to us.\r\n \r\n";
	$msg .="Please respond to this email with any corrections or comments regarding this information.  \r\n";
	 
	 	 $msg.="\r\nThank You\r\n      Susan Hardin\r\n\r\n";
	 	 
	 	 $msg.="-------------------------------------------- \r\n\r\n";
	 	 $msg.="Date Submitted: $date \r\n\r\n";
	 	 
	 	 $msg.="Proposal:  TECHNICAL DEMO  \r\n\r\n";
	 	 $msg.="Submitted by:  $first $last  \r\n\r\n";
	 	 $msg.="Email:  $emailadd  \r\n\r\n";
	 	 $msg.="Demo product:  $product  \r\n\r\n";
	 	 $msg.="Description:  $desc  \r\n\r\n";
	 	 $msg.="Speaker: $speaker  \r\n\r\n";
	 	 $msg.="Project URL:  $url  \r\n\r\n";
	  	
	 	


 	 
	 	 //set up mail for Susan
	 	 $recipient = "shardin@umich.edu";
	 	 $subject= "COPY- CFP Proposal Demo";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: $emailadd";

	 	 //send the mail to susan
	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 	 
	 	 	 
	 	 //set up mail for registrant
	$recipient = "$emailadd";
	  $subject= "RE:  Sakai- Call for Proposal Confirmation";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: shardin@umich.edu";

	 	 //send the mail to registrant
	 	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 	 

	 	 

}


?>
