<?php

//*****************************************//

//Sakai Facebook Version 3 Elections
//October 2005

//shardin@umich.edu
//

//*****************************************//


//get page header


$user_id=$_GET['id'];


require ('includes/resize.php');
require ('includes/mysqlconnect.php');

		$sql="SELECT * FROM elections_auth where id='$user_id'";
		$result= mysql_query($sql);
	
		

		while($links=mysql_fetch_array($result))
		{
		
		$add_url="1";
		$id=$links["id"]; 
		$first=$links["first"]; 
		$last=$links["last"]; 
		$institution=$links["institution"]; 
		$emailadd=$links["email"];
		$filename=$links["pict"];
		$bio=$links["bio"];
		$platform=$links["platform"];
		//if ($url=='')
		//$add_url="0";
		
		
		
		
		
		
	
	}
	function nl2p($str)
{
  return str_replace('<p></p>', '', '<p>' . preg_replace('#\n|\r#', '</p>$0<p>', $str) . '</p>');
}


function nl2br_skip_html($string)
{
   // remove any carriage returns (mysql)
   $string = str_replace("\r", '', $string);

   // replace any newlines that aren't preceded by a > with a <br />
   $string = preg_replace('/(?<!>)\n/', "<br />\n", $string);

   return $string;
}
   
   
   
   
 $first=addslashes($first);
$last=addslashes($last);
$institution=addslashes($institution);
$bio=addslashes($bio);
$platform=addslashes($platform);

//add html tags for returns so text will display properly on html pages


//check for required fields and make sure they are registered for the conference


			$sql="INSERT INTO `elections` values ('',
		'$first', 
		'$last',
		'$institution',
		'$emailadd',
		'$filename',
		'$bio',
		'$platform',
		''
		)";
		
		$result = mysql_query($sql) or die(mysql_error("
		<p>There was a problem with the submission form submission.
		Please try to submit the entry again. 
		 If you continue to have prolems, please report the problem to the 
		 <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>."));
		 
	$user_id=mysql_insert_id(); //this is how to query the last entered auto-id entry

	
  

	$errors='0';
	
	 $first=stripslashes($first);
$last=stripslashes($last);
$institution=stripslashes($institution);
$bio=stripslashes($bio);
$platform=stripslashes($platform);

		$bio = strip_tags( $bio );
		$platform = strip_tags( $platform );


	 	 $msg ="A copy of your Sakai Board Nominee submission follows. 
	 	 Please contact shardin@umich.edu if you have any questions. \r\n\r\n";
	 	 $msg .="NOMINEE:  $first $last \r\n\r\n";
		 $msg .="ORGANIZATION:  $institution \r\n\r\n";
		 $msg .="BIO:\r\n $bio \r\n\r\n";
		 $msg .="PLATFORM STATEMENT:\r\n $platform \r\n\r\n";
	
	
	 	 $admin_msg ="NOMINEE (id $user_id):  $first $last \r\n\r\n";
		 $admin_msg .="ORGANIZATION:  $institution \r\n\r\n";
		 $admin_msg .="BIO:\r\n $bio \r\n\r\n";
		 $admin_msg .="PLATFORM STATEMENT:\r\n $platform \r\n\r\n";
	
	 	 
	  	 
	 	 //set up mail for Susan
	 	 $recipient = "shardin@umich.edu";
	 	 $subject= "COPY- Sakai Board Nominee entry";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: $emailadd";

	 	 //send the mail to susan
 	 mail($recipient, $subject, $admin_msg, $mailheaders);
 	 
 	 
	 //set up mail for user
	 	 $recipient = "$emailadd";
	 	 $subject= "Sakai Board Nomination Confirmation";
	 	 $mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	 	 $mailheaders .="From: www.sakaiproject.org \n";
	 	 $mailheaders .="Reply-To: shardin@umich.edu";

	 	 //send the mail to susan
	 	 mail($recipient, $subject, $msg, $mailheaders);
		 
	 	 
	 	 
	 	 
 require_once('includes/election_submitHeader.inc');
?>
        
          <!--  image content begins -->

           <td valign=top><table  class="centerContent" valign=top width="100%">
           <tr><td><table><tr><td align=left><strong>Nominee form submission completed. </strong></td></tr>
           
<?php
if ($errors){
 
 echo $errors;
	}
	
	else {
	
	?>
		
	
        <tr><td valign=top> <br /><br />Your form was successfully submitted, a copy of your information has been sent to you by email. 

		</td>
		
	</tr>
		
<?php 
}
?>
	
	
  </table></div></td></tr></table>
	      </td>
    </tr>          <!--  image content ends -->

  </table>
  </td>
   </tr>  <!-- Menus and Main Content - Row Ends and Footer begins -->


  <?php 
  //get page footer
  require_once('includes/footer.inc');
?>