<?php
//$user_id=$_GET['id'];
//echo "start <br />";
require "../includes/mysqlconnect.php";

//test email using susans test entry
$sql="Select * from `cfp_austin_presentation` WHERE id='$user_id' ";
//test
//		$sql="Select * from `cfp_austin_presentation`";
$result= mysql_query($sql);


//echo "total emails to be sent: $numrows<br /><br />";



while($links=mysql_fetch_array($result))
{
$row++; 
$id=$links["id"];
$date=$links["date"];
$conf=$links["confID"]; 
$last=$links["lastname"];
$first=$links["firstname"];
$emailadd=$links["email1"];
$p_track=$links["p_track"];
$p_format=$links["p_format"];
$p_title=$links["p_title"];
$p_abstract=$links["p_abstract"];
$p_desc=$links["p_desc"];
$p_URL=$links["p_URL"];
$sp_URL=$links["sp_URL"];
$bio=$links["sp_bio"];
$dev=$links["dev"];
$faculty=$links["faculty"];
$mgr=$links["mgr"];
$sys_admin=$links["sys_admin"];
$sr_admin=$links["sr_admin"];
$ui_dev=$links["ui_dev"];

$support=$links["support"];

switch($p_track) {
case 'T1':
$p_track='Management & Campus Implementation';
break;
case 'T2':
$p_track='Research & Collaboration';
break;
case 'T3':
$p_track='Sakai Foundation, Community Source & Governance ';
break;
case 'T4':
$p_track='Teaching, Learning & Assessment';
break;
case 'T5':
$p_track='Technology';
break;

}




      
//set up mail message


	 
	$msg .="Your Call for Proposals submission details are shown below.  You will receive one message for each presentation or technical demo you submitted.\r\n \r\n";
	$msg .="Please respond to this email with any corrections or comments regarding this information.  \r\n";
	 
	 	 $msg.="\r\nThank You\r\n      Susan Hardin\r\n\r\n";
	 	 
	 	 $msg.="-------------------------------------------- \r\n\r\n";
	 	 $msg.="Date Submitted: $date \r\n\r\n";
	 	 
	 	 $msg.="Proposal:  PRESENTATION  \r\n\r\n";
	 	 $msg.="Submitted by:  $first $last  \r\n\r\n";
	 	 $msg.="Email:  $emailadd  \r\n\r\n";
	 	 $msg.="Track:  $p_track  \r\n\r\n";
	 	 $msg.="Format:  $p_format  \r\n\r\n";
	 	 $msg.="Title: $p_title  \r\n\r\n";
	 	 $msg.="Abstract:\r\n  $p_abstract  \r\n\r\n";
	 	 $msg.="Description:\r\n  $p_desc  \r\n\r\n";
	 	 $msg.="Project URL:  $p_URL  \r\n\r\n";
	 	 $msg.="Personal URL:  $sp_URL  \r\n\r\n";
	 	 $msg.="Bio: \r\n $bio \r\n\r\n";

	 	 	 $msg.="Audience:\r\n";
 		if ($dev==1)
	 	$msg .=" Develpers \r\n ";
	 	if ($faculty==1)
	 	$msg .="Faculty Development and Instructional Designers \r\n ";
	 	if ($mgr==1)
	 	$msg .="Managers \r\n ";
	 	if ($sys_admin==1)
	 	$msg .="System Administrators/Implementors \r\n ";
	 	if ($sr_admin==1)
	 	$msg .="Senior Administration \r\n ";
	 	if ($ui_dev==1)
	 	$msg .="UI Developers \r\n ";
	 	if ($support==1)
	 	$msg .="User Support  \r\n";
	 	
	 	
	 	


 	 
	 	 //set up mail for Susan
	 	 $recipient = "shardin@umich.edu";
	 	 $subject= "COPY-  CFP Proposal";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: $emailadd";

	 	 //send the mail to susan
	 	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 //	 echo "done sending susan copy<br />";
	 	 
	 	 	 
	 	 //set up mail for registrant
	 $recipient = "$emailadd";
	  $subject= "RE:  Sakai- Austin Conference Call for Proposal Confirmation";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: shardin@umich.edu";

	 	 //send the mail to registrant
	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 	 

	 	 
	 	 	 //	 echo "done sending user copy<br />";

}

	 	 //echo "done with all messages<br />";

?>
