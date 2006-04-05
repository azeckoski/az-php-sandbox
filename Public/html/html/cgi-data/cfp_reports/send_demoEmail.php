<?php
echo "start <br />";
require "mysqlconnect2.php";

//test email using susans test entry
//$sql="Select * from `cfp_vancouver_demo` WHERE id=19 ";
//test


		$sql="Select * from `cfp_vancouver_demo`";
$result= mysql_query($sql);
echo "$result <br />";
$resultsnumber=mysql_numrows($result);
$count   = "SELECT COUNT(*) AS numrows FROM cfp_vancouver_demo";

$countresult  = mysql_query($count) or die('Error, query failed');
$crow     = mysql_fetch_array($countresult, MYSQL_ASSOC);
$numrows = $crow['numrows'];

echo "total emails to be sent: $numrows<br /><br />";



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




echo "$row -";

      
//set up mail message


	 
$msg .="Your proposal details are shown below.  You will receive one message for each presentation or technical demo you submitted to us.\r\n \r\n";
	$msg .="Please respond to this email with any corrections or comments regarding this information.  \r\n";
	 
	 	 $msg.="\r\nThank You\r\n      Susan Hardin\r\n\r\n";
	 	 
	 	 $msg.="-------------------------------------------- \r\n\r\n";
	 	 $msg.="Date Submitted: $date \r\n\r\n";
	 	 
	 	 $msg.="Proposal:  DEMO  \r\n\r\n";
	 	 $msg.="Submitted by:  $first $last  \r\n\r\n";
	 	 $msg.="Email:  $emailadd  \r\n\r\n";
	 	 $msg.="Demo product:  $product  \r\n\r\n";
	 	 $msg.="Description:  $desc  \r\n\r\n";
	 	 $msg.="Speaker: $speaker  \r\n\r\n";
	 	 $msg.="Project URL:  $url  \r\n\r\n";
	  	
	 	

echo "$last (id=$id) <br />";

 	 
	 	 //set up mail for Susan
	 	 $recipient = "shardin@umich.edu";
	 	 $subject= "COPY-mass mail CFP Proposal";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: $emailadd";

	 	 //send the mail to susan
//	 	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 	 echo "done sending susan copy<br />";
	 	 
	 	 	 
	 	 //set up mail for registrant
	$recipient = "$emailadd";
	  $subject= "RE:  Sakai- Call for Proposal Confirmation";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: shardin@umich.edu";

	 	 //send the mail to registrant
	 //	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 	 

	 	 
	 	 	 	 echo "done sending user copy<br />";

}

	 	 echo "done with all messages<br />";

?>
