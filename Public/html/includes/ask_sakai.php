<?php 

if (isset($_POST['submit'])){

	  $errors="";
      // initialize a variable to 
	  
      //hold any errors we encounter
      $error_msg = "";
      $email=$_POST['email'];
	 
    
    // check to see if required fields were entered
  
  if (($_POST['Name']) && ($_POST['email']) && ($_POST['Institute']) 
  		&& ($_POST['components']) && ($_POST['description']) && ($_POST['summary'])) {
    
	  if(!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*" ."@"."([a-z0-9]+([\.-][a-z0-9]+)*)+"."\\.[a-z]{2,}"."$",$email))
		 {
 			  $msg.="Invalid e-mail address.";
 			  $error++;
			}
         }  else {   
           
           $error++;
	
         $msg.="<p><strong>Please complete all required fields below:</strong></p>";
		}
         
         if (!$errors) {
          //all required fields include data, now check for possible spam
      
        if(eregi("(@|href=)",$_POST['Name'])) {
			 $msg.="Name field cannot contain an email address<br />";
		   $error++;
		}  
		if(eregi("(@|href=)",$_POST['Institute']))  {
		  $msg.="Organization field cannot contain an email address<br />";
		   $error++;
		} 
		if (eregi("(@|href=)",$_POST['summary'])) { 
			$msg.="Subject contains invalid characters<br />";
		   $error++;
		}
		if(eregi("(href=)",$_POST['description'])) {
 			$msg.="invalid characters in comment (no html allowed)<br />";
		  $error++;
		}
     
    }
   	  // if there are any errors, display them
      if ($error) {
   		  echo "<p style='color:red'>$msg</p>";
	
		  
		}  else {  

require_once('mysqlconnectWeb.php');

$query="INSERT INTO ask_sakai values('', NOW(), '$_POST[issuetype]', '$_POST[Name]',
'$_POST[Institute]',
'$_POST[Phone]',
'$_POST[email]', 
'$_POST[summary]', '$_POST[components]', '$_POST[description]'
)";
	$result = mysql_query($query) or die(mysql_error("There was a 
	problem with the submission form submission.  Please try again or email the sakaiproject.org webmaster at sakaiproject_webmaster@umich.edu
		"));

$id = mysql_insert_id(); //get this proposal_pk

if ($id) {
//data entered into ask sakai database

echo "<p><strong>Your request was successfully submitted. </strong></p>
<p>Thank you for your interest in the Sakai Project.</p>";
echo "<br /><br /><br /><br /><br /><br />";

//set up the email confirmations

	// $msg ="Please do not reply to this email.  Someone will be in touch with you soon.\r\n\r\n";
		
			$msg="Name:   $_POST[Name]\r\n";
			$msg.="Institute/Org:   $_POST[Institute]\r\n";
			$msg.="Email:   $_POST[email] \r\n";
			$msg.="Category:   $_POST[components] \r\n\r\n";

			$msg.="Subject:   $_POST[summary] \r\n";
			$msg.="Question or Comment:\r\n   $_POST[description] \r\n";
					
	//$recipient="mmiles@umich.edu mkorcuska@sakaifoundation.org";
	$recipient="arwhyte@umich.edu mkorcuska@sakaifoundation.org";

	if ($_POST['components'] == 'Tech')
	$recipient="arwhyte@umich.edu mkorcuska@sakaifoundation.org";
	
	if ($_POST['components'] == 'SPOT')
	$recipient="arwhyte@umich.edu mwagner@umich.edu mkorcuska@sakaifoundation.org";
	
	if ($_POST['components'] == 'Web')
 	$recipient="arwhyte@umich.edu mkorcuska@sakaifoundation.org";

			//set up mail for Sakai Staff
			$subject= "Ask Sakai: $_POST[summary]";
			$mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
			$mailheaders .="From: sakaiproject_webmaster@umich.edu \n";
			$mailheaders .="Reply-To: $_POST[email]";

			//send the mail
			mail($recipient, $subject, $msg, $mailheaders);
				
			// backup copy to anthony
			$recipient="arwhyte@umich.edu";

			$subject= "COPY: $_POST[summary]";
			$mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
			$mailheaders .="From: www.sakaiproject.org \n";
			$mailheaders .="Reply-To: $_POST[email]";

			// send the mail
			// mail($recipient, $subject, $msg, $mailheaders);
	
}
}
}
		  
?>

<?php if (!$id) {
//not successfully sent or a new form request
  ?>



<form id="contactUs" action="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=260&Itemid=487" method="post" name="jiraform" enctype="multipart/form-data">
<table width="98%" cellspacing="3" cellpadding="7" class="jiraform"><tbody><tr><td>&nbsp;</td><td class="small"><strong>* </strong> Required<br>
 <br>
 </td></tr><tr><td valign="top" align="right" class="fieldLabelArea"><em><span title="Fields in italics are required"> <sup>*</sup> Name</span></em> </td><td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="Name" size="40" maxlength="150" value="<?php echo $_POST['Name']; ?>"> </td></tr><tr><td valign="top" align="right"> <span class="label"> <em><span title="Fields in italics are required"> <sup>*</sup> E-mail : </span></em></span></td><td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="email" maxlength="150" value="<?php echo $email; ?>"> <br>
 </td></tr><tr><td valign="top" align="right" class="fieldLabelArea"> <em><span title="Fields in italics are required"> <sup>*</sup> Organization</span></em> </td><td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="Institute" size="40" maxlength="150" value="<?php echo $_POST['Institute']; ?>"> </td></tr><tr><td valign="top" align="right" class="fieldLabelArea"><em><span title="Fields in italics are required">
<sup>*</sup>Select a category</span></em>: </td><td nowrap="nowrap" class="fieldValueArea"><select name="components">
<option value="">---Select---</option>
<option value="SEPP"> Sakai Foundation Partners Program </option>
<option value="SCA"> Sakai Commercial Affiliates </option>
<option value="SPOT"> Sakai Spotlight or Implementations </option>
<option value="Sakai"> Sakai Project- general </option>
<option value="Tech"> Technical-User Support </option>
<option value="Conf"> Sakai Conferences </option>
<option value="Web"> WebSite </option>
<option value="Other">Other</option></select></td></tr><tr><td valign="top" align="right" class="fieldLabelArea"><em><span title="Fields in italics are required"><sup>*</sup> Subject</span></em> </td><td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="summary" size="40" maxlength="200" value="<?php echo $_POST['summary']; ?>"> </td></tr>
<tr><td valign="top" align="right" class="fieldLabelArea"><em> <span title="Fields in italics are required"><sup>*</sup> Question or Comment</span></em>: </td>
<td nowrap="nowrap" class="fieldValueArea"> <textarea style="width: 80%;" name="description" cols="50" rows="5" wrap="virtual"><?php echo $_POST['description']; ?></textarea></td></tr><tr class="hidden"><td>
<input type="hidden" name="issuetype" value="6"><br>
 </td></tr><tr><td>&nbsp;</td><td class="jiraformfooter">
<input type="submit" name="submit" value="Submit">
<input type="button" id="cancelButton" value="Cancel"> </td></tr></tbody></table></form>

<?php }  ?>