<?php
//no errors
    
    
    $user_id=$_POST['user_id'];
   require('../includes/mysqlconnect.php');
 

		$sql="SELECT * FROM seppConf_austin_ccard where id='$user_id'";
		$result= mysql_query($sql);

		while($links=mysql_fetch_array($result))
{
$firstname=$links["firstname"];
$lastname=$links["lastname"];
$badge=$links["badge"];
$email=$links["email"];
$institution=$links["institution"];
$otherInst=$links["otherInst"];
$dept=$links["dept"];
$address1=$links["address1"];
$address2=$links["address2"];
$city=$links["city"];
$state=$links["state"];
$otherstate=$links["otherState"];
$zip=$links["zip"];
$country=$links["country"];
$phone=$links["phone"];
$fax=$links["fax"];
$shirt=$links["shirt"];
$spec=$links["special"];
$hotel=$links["hotelInfo"];
$jasig=$links["jasig"];
$ospi=$links["ospi"];
$contact=$links["contactInfo"];
$fee=$links["fee"];
$title=$links["title"];
$transID=$links["transID"];
		}
                               


 require_once('../includes/open_reg_header.inc'); 
//echo $user_id;

?>
              </td>
            <td valign="top" bgcolor="#FAFAFA" width="100%">
              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
       
                <tr align="left" valign="top">
                  <td colspan="3" style=" border-top: 4px solid #FFFFFF; padding: 5px;">

                      <div class="componentheading">Non-Member Registration form</div>
</td></tr>

			
		     
                         
                         <tr><td colspan=3><br />
                         <strong>Thank you for registering for the conference.</strong> <br />
                         You will receive a registration confirmation via email.<br /><br />
                        <br /> </td></tr>

			<?php 
			            	

                                  

$today = date("F j, Y"); 

//set up mail message


	 $msg ="Here is your registration confirmation for the Sakai SEPP Austin Conference, scheduled for December 7-9, 2005 in Austin, Texas.\r\n\r\n
	 If you have any questions, please contact Mary Miles at mmiles@umich.edu
	 \r\n";
	 	
	 	 
	 	 $msg.="-------------------------------------------- \r\n\r\n";
	 	 $msg.="Date Submitted: $today \r\n\r\n";
	 	 $msg.="Registration Fee: $ $fee\r\n\r\n";
	 	 $msg.="Billing Information:\r\n $transID \r\n\r\n";  
	 	 
	 	 	 	 $msg.="-------------------------------------------- \r\n\r\n";

	 	 $msg.="Attendee:  $firstname $lastname \r\n\r\n";
	 	 
	 	 $msg.="Badge Name:  $badge \r\n\r\n";
	 	 
	 	 $msg.="Email:$email\r\n\r\n";
	 	 
	 	 $msg.="Institution:  $otherInst \r\n\r\n";

	 

	 	 $msg.="Department:  $dept \r\n\r\n";

	 	 
	 	 $msg.="Address:\r\n";
	 	 $msg.="\t$address1 \r\n";
	 	 
	 	 $msg.="\t$address2 \r\n";
	 	 
	 	 $msg.="\t$city, $state, $zip,    $country \r\n\r\n";
	 	 

	 	 $msg.="Phone:  $phone  \r\n\r\n";
	 	 $msg.="Fax:   $fax \r\n\r\n";
	 
	 	 $msg.="TShirt size: $shirt \r\n\r\n";
	 	 
	 	 $msg.="Special needs:   $spec \r\n\r\n";
	 	
	 	 $msg.="Attending JA-SIG:   $jasig \r\n\r\n";
	 	
	 	 
	 	 $msg.="Staying at Conf. Hotel:   $hotel \r\n\r\n";
	 	
	 	 
	 	
	 	 $msg.="Publish name on Attendee list:  $contact ";
	 	 

	 	 
	 	 




	 	 


	 	 
	 	 //set up mail for Susan
	 	 $recipient = "shardin@umich.edu";
	 	 $subject= "PUBLIC-Sakai Austin Registration";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: $email";

	 	 //send the mail to susan
	 	 mail($recipient, $subject, $msg, $mailheaders);
 
 //set up mail for Kathy
	 	 $recipient = "kreister@umich.edu";
	 	 $subject= "PUBLIC-Sakai Austin Registration";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: $email";

	 	 //send the mail to susan
	 	 mail($recipient, $subject, $msg, $mailheaders);
	
	
	//set up mail for registrant
	 	 $recipient = "$email";
	 	 $subject= "Sakai Austin Registration Confirmation";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: kreister@umich.edu";

	 	 //send the mail to registrant
		 mail($recipient, $subject, $msg, $mailheaders);
	
	



?>



                          </table>        </td>
                              
     <?php
     
     
     $register="INSERT INTO seppConf_austin VALUES (
		'',
		NOW( ) ,
		'Dec05',
		'$firstname',
		'$lastname', 
		'$badge',
		'$email',
		'$institution',
		'$otherInst',
		'$dept',
		'$address1',
		'$address2',
		'$city',
		'$state',
		'$otherState',
		'$zip',
		'$country',
		'$phone',
		'$fax',
		'$shirt',
		'$special',
		'$hotel',
		'$contact',
		'$jasig',
		'$ospi',
		'$fee',
		'$title'
)";


$result = mysql_query($register);

                                  
                                require_once('../includes/footer.inc');
 
 
 

?>