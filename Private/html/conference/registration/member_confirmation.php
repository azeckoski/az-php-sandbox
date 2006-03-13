<?php


$sql="SELECT * FROM sakaiConf_vancouver where id='$user_id'";
		$result= mysql_query($sql);
		

		while($links=mysql_fetch_array($result))
{
$firstname=$links["firstname"];
$lastname=$links["lastname"];
$badge=$links["badge"];
$email=$links["email"];
$institution=$links["institution"];
$address1=$links["address1"];
$city=$links["city"];
$state=$links["state"];
$zip=$links["zip"];
$country=$links["country"];
$phone=$links["phone"];
$fax=$links["fax"];
$shirt=$links["shirt"];
$special=$links["special"];
$hotel=$links["hotelInfo"];
$jasig=$links["jasig"];
$publish=$links["contactInfo"];
$fee=$links["fee"];

$title=$links["title"];
$co_registrant=$links["co_registrant"];
		}
		
		?>
<table width="500px"  id=confirm  cellpadding="3" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td  colspan=2 style=" padding:5px;"><strong>Registration Complete</strong>: <br />
      Thank you for registering for the Sakai Vancouver conference. You will receive a confirmation email shortly. We look forward to seeing you in Vancouver! <br />
      <br />
      -- Sakai Conference Committee</td>
  </tr>
  <tr>
    <td   colspan=2><blockquote style="background:#fff; border: 1px solid #ffcc33; padding: 5px;"><strong>Special announcements and reminders:</strong>
        <ul>
          <li><strong>Visit the Sakai Conference Facebook</strong> to see who else is attending -- and add your photo while you're there! (see sidebar for more information)</li>
          <li><strong>Call for Proposals Deadline is March 31st.</strong> [ <a href=" http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=170&Itemid=519">more information</a> ]</li>
        </ul>
      </blockquote></td>
  </tr>
  <?php 
			            	
   //include('confirm_reg_data.php');
   include('./includes/email_confirmation.php');
                                  
   ?>
</table>