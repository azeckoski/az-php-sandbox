<?php 
if (isset($_POST['submit'])){

      error_reporting(0);
	  
      // initialize a variable to 
	  
      //hold any errors we encounter
      $errors = "";
      // test to see if the form was actually 
      // check to see if requiired fields were entered
      
      	$_SESSION['Name']=$_POST['Name'];
	$_SESSION['customfield_10021']=$_POST['customfield_10021'];
	$_SESSION['Institute']=$_POST['Institute'];
	$_SESSION['Phone']=$_POST['Phone'];
	$_SESSION['components']=$_POST['components'];
	$_SESSION['summary']=$_POST['summary'];
	$_SESSION['description']=$_POST['description'];




  if (!$_SESSION['Name'])
         $errors .= "&nbsp; &nbsp; *Name";
		 
      if (!$_SESSION['customfield_10021'])
         $errors .= "&nbsp; &nbsp; *Email";
		 
      if (!$_SESSION['summary'])
         $errors .= "&nbsp; &nbsp; *Subject";
		 
      if (!$_SESSION['Institute'])
         $errors .= "&nbsp; &nbsp; *Institution or Organization";
         
      if ($_SESSION['components'] < '0')
         $errors .= "&nbsp; &nbsp; *Category";
         
	 if (!$_SESSION['description'])
         $errors .= "&nbsp; &nbsp; *Question or comment";
		 		 
		 
   	  // if there are any errors, display them
      if ($errors) {
   		  echo "<p><strong>Please complete all required fields below:</strong></p>";
		  
		  $email=$_SESSION['customfield_10021'];
?>
<form action="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=260&Itemid=487" method="post" name="jiraform" enctype="multipart/form-data">
<table width="98%" cellspacing="3" cellpadding="7" class="jiraform"><tbody><tr><td>&nbsp;</td><td class="small"><strong>* </strong> Required<br>
 <br>
 </td></tr><tr><td valign="top" align="right" class="fieldLabelArea"><em><span title="Fields in italics are required"> <sup>*</sup> Name</span></em> </td><td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="Name" size="40" maxlength="150" value="<?php echo $_SESSION['Name']; ?>"> </td></tr><tr><td valign="top" align="right"> <span class="label"> <em><span title="Fields in italics are required"> <sup>*</sup> E-mail : </span></em></span></td><td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="customfield_10021" maxlength="150" value="<?php echo $email; ?>"> <br>
 </td></tr><tr><td valign="top" align="right" class="fieldLabelArea"> <em><span title="Fields in italics are required"> <sup>*</sup> Organization</span></em> </td><td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="Institute" size="40" maxlength="150" value="<?php echo $_SESSION['Institute']; ?>"> </td></tr><tr><td valign="top" align="right" class="fieldLabelArea"><em><span title="Fields in italics are required">&nbsp;Phone</span></em> </td><td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="Phone" size="20" maxlength="20" value="<?php echo $_SESSION['Phone']; ?>"> </td></tr><tr><td valign="top" colspan="1">
<p>&nbsp;</p></td><td valign="top" colspan="1">
<p>&nbsp;</p></td></tr><tr><td valign="top" align="right" class="fieldLabelArea"><em><span title="Fields in italics are required">
<sup>*</sup>Select a category</span></em>: </td><td nowrap="nowrap" class="fieldValueArea"><select name="components">
<option value="-1">---Select---</option>
<option value="SEPP"> Sakai Educational Partners Program </option>
<option value="SCA"> Sakai Commercial Affiliates </option>
<option value="SPOT"> Sakai Spotlight or Implementations </option>
<option value="Sakai"> Sakai Project- general </option>
<option value="Tech"> Technical-User Support </option>
<option value="Conf"> Sakai Conferences </option>
<option value="Web"> WebSite </option>
<option value="Other">Other</option></select></td></tr><tr><td valign="top" align="right" class="fieldLabelArea"><em><span title="Fields in italics are required"><sup>*</sup> Subject</span></em> </td><td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="summary" size="40" maxlength="200" value="<?php echo $_SESSION['summary']; ?>"> </td></tr>
<tr><td valign="top" align="right" class="fieldLabelArea"><em> <span title="Fields in italics are required"><sup>*</sup> Question or Comment</span></em>: </td>
<td nowrap="nowrap" class="fieldValueArea"> <textarea style="width: 80%;" name="description" cols="50" rows="10" wrap="virtual"><?php echo $_SESSION['description']; ?></textarea></td></tr><tr class="hidden"><td>
<input type="hidden" name="issuetype" value="6"><br>
 </td></tr><tr><td>&nbsp;</td><td class="jiraformfooter">
<input type="submit" name="submit" value="Submit">
<input type="button" id="cancelButton" value="Cancel"> </td></tr></tbody></table></form>

<?php  }  //end validation

else {     

require_once('mysqlconnectWeb.php');



$query="INSERT INTO ask_sakai values('', NOW(), '$_POST[issuetype]', '$_POST[Name]',
'$_POST[Institute]',
'$_POST[Phone]',
'$_POST[customfield_10021]', 
'$_POST[summary]', '$_POST[components]', '$_POST[description]'
)";
	$result = mysql_query($query) or die(mysql_error("There was a 
	problem with the submission form submission.  Please try again or email the sakaiproject.org webmaster at shardin@umich.edu
		"));



//data entered into ask sakai database

echo "<p><strong>Your request was successfully submitted. </strong></p>
<p>Thank you for your interest in the Sakai Project.</p>";
echo "<br /><br /><br /><br /><br /><br />";




//set up the email confirmations

	// $msg ="Please do not reply to this email.  Someone will be in touch with you soon.\r\n\r\n";
								
			
			$msg="Name:   $_POST[Name]\r\n";
			$msg.="Institute/Org:   $_POST[Institute]\r\n";
			$msg.="Email:   $_POST[customfield_10021] \r\n";
			$msg.="Category:   $_POST[components] \r\n\r\n";

			$msg.="Subject:   $_POST[summary] \r\n";
			$msg.="Question or Comment:\r\n   $_POST[description] \r\n";
			
			
	$recipient="mmiles@umich.edu";

	if ($_POST['components'] == 'Tech')
	$recipient="arwhyte@umich.edu";
	
	if ($_POST['components'] == 'SPOT')
	$recipient="arwhyte@umich.edu mwagner@umich.edu";
	
if ($_POST['components'] == 'Web')
 $recipient="shardin@umich.edu";





					//set up mail for registrant
//			$recipient = "$_POST[customfield_10021]";
	//		$subject= "Your Ask Sakai request was received";
//			$mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
	//		$mailheaders .="From: www.sakaiproject.org \n";
	//		$mailheaders .="Reply-To: shardin@umich.edu";
//
			//send the mail
	//		mail($recipient, $subject, $msg, $mailheaders);
			
	
			//set up mail for Sakai Staff
			$subject= "Ask Sakai: $_POST[summary]";
			$mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
			$mailheaders .="From: www.sakaiproject.org \n";
			$mailheaders .="Reply-To: $_POST[customfield_10021]";

			//send the mail
			mail($recipient, $subject, $msg, $mailheaders);
			
			
			 $recipient="shardin@umich.edu";

			$subject= "COPY: $_POST[summary]";
			$mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
			$mailheaders .="From: www.sakaiproject.org \n";
			$mailheaders .="Reply-To: $_POST[customfield_10021]";

			//send the mail
			mail($recipient, $subject, $msg, $mailheaders);
			
//backup copy to anthony

			$recipient="arwhyte@umich.edu";

			$subject= "COPY: $_POST[summary]";
			$mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";
			$mailheaders .="From: www.sakaiproject.org \n";
			$mailheaders .="Reply-To: $_POST[customfield_10021]";

			//send the mail
		//	mail($recipient, $subject, $msg, $mailheaders);
			
			

	
session_destroy();
}
}



else { 
session_name('YourVisitID');
session_start();


//no form submitted so display empty form



?>
<form action="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=260&Itemid=487" method="post" name="jiraform" enctype="multipart/form-data">
<table width="98%" cellspacing="3" cellpadding="7" class="jiraform"><tbody><tr><td>&nbsp;</td><td class="small"><strong>* </strong> Required<br>
 <br>
 </td></tr><tr><td  valign="top" align="right" class="fieldLabelArea"><em><span title="Fields in italics are required"> <sup>*</sup> Name</span></em> </td>
 <td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="Name" size="40" maxlength="150"> </td></tr><tr><td valign="top" align="right"> <span class="label"> <em><span title="Fields in italics are required"> <sup>*</sup> E-mail : </span></em></span></td><td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="customfield_10021" maxlength="150" value=""> <br>
 </td></tr><tr><td valign="top" align="right" class="fieldLabelArea"> <em><span title="Fields in italics are required"> <sup>*</sup> Organization</span></em> </td><td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="Institute" size="40" maxlength="150"> </td></tr><tr><td valign="top" align="right" class="fieldLabelArea"><em><span title="Fields in italics are required">&nbsp;Phone</span></em> </td><td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="Phone" size="20" maxlength="20"> </td></tr><tr><td valign="top" colspan="1">
<p>&nbsp;</p></td><td valign="top" colspan="1">
<p>&nbsp;</p></td></tr><tr><td valign="top" align="right" class="fieldLabelArea"><em><span title="Fields in italics are required"><sup>*</sup>Select a category</span></em>: </td><td nowrap="nowrap" class="fieldValueArea"><select name="components">
<option value="-1">---Select---</option>
<option value="SEPP"> Sakai Educational Partners Program </option>
<option value="SCA"> Sakai Commercial Affiliates </option>
<option value="Sakai"> Sakai Project- general </option>
<option value="Tech"> Technical-User Support </option>
<option value="Conf"> Sakai Conferences </option>
<option value="Web"> WebSite </option>
<option value="Other">Other</option></select></td></tr><tr><td valign="top" align="right" class="fieldLabelArea"><em><span title="Fields in italics are required"><sup>*</sup> Subject</span></em> </td><td nowrap="nowrap" class="fieldValueArea">
<input type="text" name="summary" size="40" maxlength="200"> </td></tr><tr><td valign="top" align="right" class="fieldLabelArea"><em> <span title="Fields in italics are required"><sup>*</sup> Question or Comment</span></em>: </td><td nowrap="nowrap" class="fieldValueArea"> <textarea style="width: 80%;" name="description" cols="50" rows="10" wrap="virtual"></textarea></td></tr><tr class="hidden"><td>
<input type="hidden" name="issuetype" value="6"><br>
 </td></tr><tr><td>&nbsp;</td><td class="jiraformfooter">
<input type="submit" name="submit" value="Submit">
<input type="button" id="cancelButton" value="Cancel"> </td></tr></tbody></table></form>
<?php 

}
?>
