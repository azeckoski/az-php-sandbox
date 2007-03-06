<?php
session_start();

// Gather Silent Post data with this PHP script.
// use $_POST instead of $HTTP_POST_VARS for version PHP 4.0 or greater.
  
 //if (!empty($HTTP_POST_VARS)) {
//  extract($HTTP_POST_VARS);

//    }
    
    
 // Print out post contents

   //$last4cc=$_POST['USER2'];
  //$transID=$_POST['PNREF'];
//  $transAmount=$_POST['AMOUNT'];
  $user_id=$_SESSION['USER1'];


$ResultCode=$_POST['RESULT'];

    

//no errors
    

//get registration information
   require('../includes/mysqlconnect.php');

		$sql="SELECT * FROM seppConf_austin_ccard where id=237";
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

		}
		
		

//now provide a confirmation page		
		 


		 
		 
		 
		 



		
  
 

 
 
 require_once('../includes/open_reg_header.inc'); 
//echo $user_id;

?>

                  <td width="100%" valign="top" style=" border-top: 4px solid #FFFFFF; padding: 5px;">
                  
                  
                <div class="componentheading">Non-Member Registration form</div>
                
                <table width="650px" class="blog" cellpadding="0" cellspacing="0">
                
               
              <tr><td colspan=2><br /><strong>Registration Confirmation</strong><br />
              <br /></td></tr>
              
              
<tr><td colspan=2>
			<?php 
			            	

                                  
                                  include('review_registration.php');
                                 
                  
                  
                  
                  ?>
                 </td></tr>
                 
                 <tr><td colspan=2 style="padding-left: 200px; padding-top:20px;">
                  
                  
                  <form method="POST" action="https://payments.verisign.com/payflowlink">
 <input type="hidden" name="USER1" value="<?php echo $user_id?>">
<!--  <input type="hidden" name="ORDERFORM" value="TRUE" >
<input type="hidden" name="ECHODATA" value="TRUE" >
<input type="hidden" name="EMAILCUSTOMER" value="FALSE" >
<input type="hidden" name="SHOWCONFIRM" value="TRUE" >
--> <input type="hidden" name="METHOD" value="CC" >
<input type="hidden" name="TYPE" value="S">


<input type="hidden" name="LOGIN" value="sakaiproject">
<input type="hidden" name="PARTNER" value="verisign">
    
<input type="hidden" name="AMOUNT" value="<?php echo $fee;?>">
<input type="hidden" name="DESCRIPTION" value="SAKAI -AUSTIN CONFERENCE REGISTRATION">




<input type="submit" name="submit" value="continue" >
</form>
</td>

                        </tr>
                    </table>
                    
                    </td>
                                  <?php
                                  
                                require_once('../includes/footer.inc');

 
 
 

?>