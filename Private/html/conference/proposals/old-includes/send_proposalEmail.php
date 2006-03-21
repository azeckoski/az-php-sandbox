<?php
//$user_id=$_GET['id'];
//echo "start <br />";
require "../sql/mysqlconnect.php";


$sql="Select * from `proposal_presentation` WHERE id='$presentation_id' ";

$result= mysql_query($sql);


//echo "total emails to be sent: $numrows<br /><br />";


while($links=mysql_fetch_array($result))
{

$date=stripslashes($links['date']);
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

$p_title=stripslashes($links['p_title']);
$p_abstract=stripslashes($links['p_abstract']);
$p_desc=stripslashes($links['p_desc']);
$p_speaker=stripslashes($links['p_speaker']);
$bio=stripslashes($links['bio']);
$co_speaker=stripslashes($links['co_speaker']);
$co_bio=stripslashes($links['co_bio']);
$p_URL=$links['p_URL'];
$p_track=$links['p_track'];
$dev=$links['dev'];
$ui_dev=$links['ui_dev'];
$faculty=$links['faculty'];
$faculty_dev=$links['faculty_dev'];
$implementors=$links['implementors'];
$instruct_dev=$links['instruct_dev'];

//$librarian=$links['librarian'];

$managers=$links['managers'];
$sys_admin=$links['sys_admin'];
$univ_admin=$links['univ_admin'];
$support=$links['support'];
$p_format=$links['p_format'];
$layout=$links['layout'];
$length=$links['length'];
$conflict_tues=$links['conflict_tues'];
$conflict_wed=$links['conflict_wed'];
$conflict_thurs=$links['conflict_thurs'];
$conflict_fri=$links['conflict_fri'];





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
$p_track='Technology and User Interface';
break;

}

function get_level($level){
switch ($level) {

case '1':
$interest="low";
break;

case '2':
$interest="medium";
break;

case '3':
$interest="high";
break;


}
return $interest;

}

$today = date("F j, Y"); 


      
//set up mail message
echo $length;

	 
	$msg .="Your Sakai Vancouver conference Presentation proposal details are shown below.  You will receive one message for each presentation or technical demo you submitted.\r\n \r\n";
	$msg .="Please respond to this email with any corrections or comments regarding this information.  \r\n";
	 
	 	 $msg.="\r\nThank You\r\n      Susan Hardin\r\nwww.sakaiproject.org webmaster\r\n";
	 	
	 	 
	 	 $msg.="-------------------------------------------- \r\n\r\n";
	 	 $msg.="Date Submitted: $today \r\n\r\n";
	 	 
	 	 $msg.="Proposal:  PRESENTATION  \r\n\r\n";
	 	 $msg.="Submitted by:  $firstname $lastname  \r\n\r\n";
	 	 $msg.="Email:  $email  \r\n\r\n";
	 	// $msg.="Track:  $p_track  \r\n\r\n";
	 	 $msg.="Format:  $p_format  \r\n\r\n";
	 	 $msg.="Title: $p_title  \r\n\r\n";
	 	 $msg.="Abstract:\r\n  $p_abstract  \r\n\r\n";
	 	 $msg.="Description:\r\n  $p_desc  \r\n\r\n";
	 	 $msg.="Project URL:  $p_URL  \r\n\r\n";
	 	 $msg.="Primary Speaker:  $p_speaker  \r\n\r\n";
	 	 $msg.="Speaker Bio: \r\n $bio \r\n\r\n";
	 	 $msg.="Co-Speaker (s):  $co_speaker  \r\n\r\n";
	 	 $msg.="Co-speaker Bio: \r\n $co_bio \r\n\r\n";

	    $msg.="Audience:  \r\n"; 
 		if ($dev > 0){
 		$interest=get_level($dev);
	 	$msg .="  Develpers (interest level= $interest) \r\n ";
	 	}
	 	if ($faculty > 0){
 		$interest=get_level($faculty);
	 	$msg .="  Faculty (interest level= $interest) \r\n ";
	 	}
	    if ($faculty_dev > 0){
 		$interest=get_level($faculty_dev);
	 	$msg .="  Faculty (interest level= $interest) \r\n ";
	 	}
	 	 	if ($instruct_dev > 0){
 		$interest=get_level($instruct_dev);
	 	$msg .="  Instructional Designers (interest level= $interest) \r\n ";
	 	}
	 	if ($implementors > 0){
 		$interest=get_level($implementors);
	 	$msg .="  Implementors (interest level= $interest) \r\n ";
	 	}
	 	if ($managers > 0){
 		$interest=get_level($managers);
	 	$msg .="  Managers (interest level= $interest) \r\n ";
	 	}
	 	if ($sys_admin > 0){
 		$interest=get_level($sys_admin);
	 	$msg .="  System Administrators/Implementors (interest level= $interest) \r\n ";
	 	}
	 	if ($univ_admin > 0){
 		$interest=get_level($univ_admin);
	 	$msg .="  University Administration (interest level= $interest) \r\n ";
	 	}
	 	if ($ui_dev > 0){
 		$interest=get_level($ui_dev);
	 	$msg .="  UI Developers(interest level= $interest) \r\n ";
	 	}
	 	if ($support > 0){
 		$interest=get_level($support);
	 	$msg .="User Support (interest level= $interest) \r\n\r\n";
	 	}
	 	
	 	$msg.="\r\nPresentation layout:  ";
 		if ($layout=='class')
	 	$msg .="Classroom \r\n ";
	 	if ($layout=="theater")
	 	$msg .="Theater  \r\n ";
	 	if ($layout=="conference")
	 	$msg .="Conference (roundtable) \r\n";
	 	

	 	$msg.="\r\nPresentation length: $length minutes \r\n\r\n ";
	 	$msg.="Availability:  ";
	 	if (($conflict_tues==0) AND ($conflict_wed==0) AND 
	 	($conflict_thurs==0) AND ($conflict_fri==0)  ) {
	 	
	 	$msg .="available all days \r\n";
	 	}
	 	else {
	 	$msg .="unavailable on : ";
        if ($conflict_tues==1) 
        	 	$msg .="(Tuesday, May 30 )  ";
        if ($conflict_wed==1) 
        	 	$msg .="(Wednesday, May 31) ";
         if ($conflict_thurs==1) 
        	 	$msg .="(Thursday, June 1) ";
        if ($conflict_fri==1) 
        	 	$msg .="(Friday, June 2) \r\n";
   
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

 /*******	 	 
	 	 //set up mail for Susan
	 	 $recipient = "shardin@umich.edu";
	 	 $subject= "COPY- Vancouver CFP Presentation - $lastname";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: sakaiproject_webmaster@umich.edu \n";
	 	 $mailheaders .="Reply-To: $email";

	 	 //send the mail to susan
	 	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 	 echo "done sending susan copy<br />";
*******/ 	


// This is a better set of mail headers -AZ
ini_set(SMTP, $MAIL_SERVER);
$headers  = 'From: ' . $HELP_EMAIL . "\n";
$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
$headers .= 'Reply-To: ' . $email . "\n";
$headers .= 'MIME-Version: 1.0' ."\n";
$headers .= 'Content-type: text/plain; charset=ISO-8859-1' ."\n";
$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";

//set up mail for attendee
$recipient = "email";
$subject= "Sakai Conference Registration- $lastname";
//send the mail to attendee
mail($recipient, $subject, $msg, $headers);
 	 
/*******	 	 	 	 
	 	 //set up mail for registrant
	 $recipient = "$email";
	  $subject= "Sakai- Vancouver CFP - presentation submission";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: sakaiproject_webmaster@umich.edu \n";
	 	 $mailheaders .="Reply-To: shardin@umich.edu";

	 	 //send the mail to registrant
	 mail($recipient, $subject, $msg, $mailheaders);
	 	 
	 	 
*******/	 
	 	 
	 	 	 //	 echo "done sending user copy<br />";

}

	 	 //echo "done with all messages<br />";

?>
