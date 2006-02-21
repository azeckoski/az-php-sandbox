<?php
//no errors
    
    
    $user_id=$_GET['id'];
   require('../includes/mysqlconnect.php');
 

		$sql="SELECT * FROM seppConf_austin_ccard where id='$user_id'";
		$result= mysql_query($sql);

		while($links=mysql_fetch_array($result))
{
$firstname=addslashes($links["firstname"]);
$lastname=addslashes($links["lastname"]);
$badge=addslashes($links["badge"]);
$email=$links["email"];
$institution=addslashes($links["institution"]);
$otherInst=addslashes($links["otherInst"]);
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
            <td valign="top" bgcolor="#FAFAFA" width="100%"><div classmain>
              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr valign="top" bgcolor="#F1F1F1">
                                  </tr>
                <tr>
                                  </tr>
                <tr align="left" valign="top">
                  <td colspan="3" style=" border-top: 4px solid #FFFFFF; padding: 5px;"><div class="main">

                      <div class="componentheading">Non-Member Registration form</div><table class="blog" cellpadding="0" cellspacing="0"><tr><td valign="top"><div>		
                   
			
		      <tr><td colspan=2>
              
              </td></tr>
                          <tr><td colspan=2><br /><strong>Registration Confirmation</strong><br /><br /></td><tr>
<tr><td colspan=2>

			<?php 
			            	

                                  
$today = date("F j, Y"); 
echo"<table width=100%>";
			//echo"<tr><td colspan=2>This is your registration confirmation (pending credit card approval).  A copy of this information has also been sent to o you at <strong>$email</strong><br /><br /></td></tr>";
			echo"<tr><td colspan=2>Please verify the following information and click Continue to go to our complete the credit card information.  <br /></td></tr>";
			
			
			
			echo"<tr><td width=200px><div align=\"right\"><strong><span>DateSubmitted</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong></div></td>
			<td>$today</td></tr>";
			echo"<tr><td><div align=\"right\"><strong><span>Attendee</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			<td width=300px>$firstname $lastname</td></tr>";


			 echo"<tr><td><div align=\"right\"><strong><span>Registration Fee</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			 <td width=300p>$ $fee</td></tr>";
		
				
			echo"<tr><td><div align=\"right\"><strong><span>Badge Name</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			<td>$badge </td></tr>";

			
			echo"<tr><td><div align=\"right\"><strong><span>Email</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$email</td></tr>";
			echo"<tr><td><div align=\"right\"><strong><span>Role</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$title</td></tr>";
			
			echo"<tr><td><div align=\"right\"><strong><span>Organization</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
			<td>$otherInst<br></td></tr>";

			

		    echo"<tr><td><div align=\"right\"><strong><span>Department</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$dept<br></td></tr>";

			
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Address</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
			<td>";
			
			
			
			echo"$address1<br />";
		
			echo"$address2<br />";
			
			echo"$city, $state, $zip<br/>
					$country</td>
					</tr>";
					

		echo"<tr><td><div align=\"right\"><strong><span>Phone</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$phone</td></tr>";
			echo"<tr><td><div align=\"right\"><strong><span>Fax</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$fax</td></tr>";
		
		
		echo"<tr><td><div align=\"right\"><strong><span>TShirt size</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$shirt</td></tr>";
		
			echo"<tr><td><div align=\"right\"><strong><span>Special Needs</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$spec</td></tr>";
		 

			
			echo"<tr><td><div align=\"right\"><strong><span>Staying at Conf. Hotel</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td> $hotel</td></tr>";
		
			echo"<tr><td><div align=\"right\"><strong><span>Attending JA-SIG</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td> $jasig</td></tr>";

		
			
			echo"<tr><td valign=top width=250px><div align=\"right\"><strong><span>Publish name on Attendee list</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
			<td>$contact</td></tr>";
			
			
			
				 echo"<tr><td><div align=\"right\"><strong><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			 <td width=300p>&nbsp;</td></tr>"; 
			 
			 echo"<tr><td><div align=\"right\"><strong><span>Billing Info</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			 <td width=300p>$transID</td></tr>";
	echo "</table>";                                 
                  
                  
                  
                  ?>
                  
                  
                  
                  <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
<input type=hidden name=user_id value="$user_id">

<input type="submit" name="submit" value="send email" >

<?php 

if (isset($_POST['user_id']))  {

$today = date("F j, Y"); 


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

//set up mail message


	 $msg ="Your registration confirmation (pending credit card approval) for the Sakai SEPP Austin Conference, scheduled for December 7-9, 2005 in Austin, Texas.  If you have questions, please contact Mary Miles at mmiles@umich.edu.
	 \r\n";
	 	
	 	 
	 	 $msg.="-------------------------------------------- \r\n\r\n";
	 	 $msg.="Date Submitted: $today \r\n\r\n";
	 	 $msg.="Registration Fee Paid: $ $transAmount\r\n\r\n\r\n";
	 	 $msg.="Billing Info #: $transID \r\n\r\n\r\n";  
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
	// 	 mail($recipient, $subject, $msg, $mailheaders);
	
	
	//set up mail for registrant
	 	 $recipient = "$email";
	 	 $subject= "Sakai Austin Registration Confirmation";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: kreister@umich.edu";

	 	 //send the mail to registrant
	//	 mail($recipient, $subject, $msg, $mailheaders);
	
	}



?>



                                  
                                    </td>
                        </tr>
                    </table>
                                  <?php
                                  
                                require_once('../includes/footer.inc');

 
 
 

?>