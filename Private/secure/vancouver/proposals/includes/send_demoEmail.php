<?php
require "../includes/mysqlconnect.php";

$sql="Select * from `cfp_vancouver_demo` WHERE id='$demo_id' ";


$result= mysql_query($sql);



while($links=mysql_fetch_array($result))
{
$row++; 
$id=$links["id"];
$date=$links["date"];
$conf=$links["confID"]; 
$last=$links["lastname"];
$first=$links["firstname"];
$email=$links["email1"];

$product=$links["product"];
$desc=$links["demo_desc"];
$speaker=$links["demo_speaker"];
$url=$links["demo_url"];

      
//set up mail message


	 $today = date("F j, Y"); 

	$msg .="Your Sakai Vancouver conference Technology Demo proposal details are shown below.  You will receive one message for each presentation or technical demo you submitted to us.\r\n \r\n";
	$msg .="Please respond to this email with any corrections or comments regarding this information.  \r\n";
	 
	 	 $msg.="\r\nThank You\r\n      Susan Hardin\r\n\r\n";
	 	 
	 	 $msg.="-------------------------------------------- \r\n\r\n";
	 	 $msg.="Date Submitted: $today \r\n\r\n";
	 	 
	 	 $msg.="Proposal:  TECHNICAL DEMO  \r\n\r\n";
	 	 $msg.="Submitted by:  $first $last  \r\n\r\n";
	 	 $msg.="Email:  $email  \r\n\r\n";
	 	 $msg.="Demo product:  $product  \r\n\r\n";
	 	 $msg.="Description:  $desc  \r\n\r\n";
	 	 $msg.="Speaker: $speaker  \r\n\r\n";
	 	 $msg.="Project URL:  $url  \r\n\r\n";
	  	
	 	


 	 
	 	 //set up mail for Susan
	 	 $recipient = "shardin@umich.edu";
	 	 $subject= "COPY- Vancouver CFP Demo- $last";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: sakaiproject_webmaster@umich.edu \n";
	 	 $mailheaders .="Reply-To: $email";

	 	 //send the mail to susan
	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 	 
	 	 	 
	 	 //set up mail for registrant
	$recipient = "$email";
	  $subject= "Sakai- Call for Proposal - Demo submission";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: sakaiproject_webmaster@umich.edu \n";
	 	 $mailheaders .="Reply-To: shardin@umich.edu";

	 	 //send the mail to registrant
	  mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 	 

	 	 

}


?>
