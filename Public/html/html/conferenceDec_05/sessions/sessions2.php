<?phpsession_start();$username=$_SESSION['firstname'] .sakai;//database variables		 $_SESSION['firstname']=$_POST['firstname'];		 $_SESSION['lastname']=$_POST['lastname'];$_SESSION['badge']=$_POST['badge'];$_SESSION['email']=$_POST['email'];$_SESSION['institution']=$_POST['institution'];$_SESSION['otherInst']=$_POST['otherInst'];$_SESSION['dept']=$_POST['dept'];$_SESSION['address1']=$_POST['address1'];$_SESSION['address2']=$_POST['address2'];$_SESSION['city']=$_POST['city'];$_SESSION['state']=$_POST['state'];$_SESSION['otherState']=$_POST['otherState'];$_SESSION['zip']=$_POST['zip'];$_SESSION['country']=$_POST['country'];$_SESSION['phone']=$_POST['phone'];$_SESSION['fax']=$_POST['fax'];$_SESSION['org_gov']=$_POST['org_gov'];$_SESSION['framework']=$_POST['framework'];$_SESSION['toolsDev']=$_POST['toolsDev'];$_SESSION['otherInterest']=$_POST['otherInterest'];$_SESSION['adoption']=$_POST['adoption'];$_SESSION['admin']=$_POST['admin'];$_SESSION['arch']=$_POST['arch'];$_SESSION['collab']=$_POST['collab'];$_SESSION['content']=$_POST['content'];$_SESSION['coreMed']=$_POST['coreMed'];$_SESSION['courseEval']=$_POST['courseEval'];$_SESSION['lang']=$_POST['lang'];$_SESSION['dev']=$_POST['dev'];$_SESSION['lib']=$_POST['lib'];$_SESSION['mig']=$_POST['mig'];$_SESSION['portfolio']=$_POST['portfolio'];$_SESSION['pedagogy']=$_POST['pedagogy'];$_SESSION['QA']=$_POST['QA'];$_SESSION['req']=$_POST['req'];$_SESSION['scorm']=$_POST['scorm'];$_SESSION['stratAdvoc']=$_POST['stratAdvoc'];$_SESSION['ui']=$_POST['ui'];$_SESSION['supp']=$_POST['supp'];$_SESSION['demo']=$_POST['demo'];$_SESSION['demoURL']=$_POST['demoURL'];$_SESSION['BOF']=$_POST['BOF'];$_SESSION['comments']=$_POST['comments'];$_SESSION['shirt']=$_POST['shirt'];$_SESSION['diet']=$_POST['diet'];$_SESSION['special']=$_POST['special'];$_SESSION['hotelInfo']=$_POST['hotelInfo'];$_SESSION['contactInfo']=$_POST['contactInfo'];$_SESSION['jasig']=$_POST['jasig'];$_SESSION['ospi']=$_POST['ospi'];?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><title>Sakai Project</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta name="description" content=",Sakai - www.sakaiproject.org, Community Source Software for Education."><meta name="keywords" content=",sakai, sakaiproject.org, sakaiproject, Sakai, Community Source, Open Source, open-open, educational software, collaborative"><meta name="Generator" content="Mambo - Copyright 2000 - 2004 Miro International Pty Ltd.  All rights reserved."><meta name="robots" content="index, follow"><link href="regindex_files/template_css.css" rel="stylesheet" type="text/css"><link rel="shortcut icon" href="../templates/extralight/templates/extralight/images/favicon.ico"></head><style type="text/css">#regForm{padding-left: 20px;}.reg {font-family: Arial, Helvetica, sans-serif;font-size: 12px;margin-left: 40px;width:450px;text-align: left;}.required{color: #FF0000;}span.required{font-size: 20px;}.main {margin: 0px 20px;text-align: left;}.searchbar1{padding:3px 3px;}.ccard{margin: 10px 10px 200px 10px}.centerContent {text-align: left;}</style><body><table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">  <tbody>    <tr>      <td class="mainHeader" width="100%"><table border="0" cellpadding="0" cellspacing="0">          <tbody>            <tr>              <td><a href="http://www.sakaiproject.org/cms"><img src="regindex_files/logoslate160x89.jfif" alt="Sakai Logo" border="0"></a></td>              <td class="topNav" align="right" valign="top" width="100%"></td>            </tr>          </tbody>        </table></td>    </tr>    <tr>      <td align="left" bgcolor="#eeeeee"><table class="searchBar1" bgcolor="#f3f3f3" border="0" cellpadding="0" cellspacing="0" width="100%">          <tbody>            <tr>              <td class="searchBar"><span class="pathway"> <img src="regindex_files/arrow.png" height="9" width="9"> <span class="pathway"><a href="../index.php" class="pathway">Home</a> <img src="regindex_files/arrow.png" alt="arrow"> SEPP Registration </span> </span></td>              <td align="right">&nbsp; &nbsp; &nbsp;&nbsp;</td>              <td align="left" width="120"></td>            </tr>          </tbody>        </table></td>    </tr>    <tr class="mainPageContent">      <td><table border="0" cellpadding="0" cellspacing="0" width="100%">          <tbody>            <tr align="center" valign="top">              <td class="leftSide" style="border-right: 1px solid rgb(227, 227, 227);" width="160"><table border="0" cellpadding="0" cellspacing="3" width="100%">                  <tbody>                    <tr>                      <td><table class="moduletable" cellpadding="0" cellspacing="0">                          <tbody>                            <tr>                              <th valign="top"> Main Menu </th>                            </tr>                            <tr>                              <td><table border="0" cellpadding="0" cellspacing="0" width="100%">                                  <tbody>                                    <tr align="left">                                      <td><a href="../index.php?option=com_frontpage&amp;Itemid=1" class="mainlevel">back to sakaiproject.org </a></td>                                    </tr>                                  </tbody>                                </table></td>                            </tr>                          </tbody>                        </table></td>                    </tr>                  </tbody>                </table></td>              <td class="centerContent"><div align="center">                  <p>&nbsp;&nbsp;</p>                  <p> <strong> Non-Member Registration</strong><br />                    for <br />                    SEPP Conference: &nbsp; June 8-10, Baltimore, Maryland</p>                </div>                <div align="left">                  <?php     //error reporting      error_reporting(0);	        // initialize a variable to  	        //hold any errors we encounter      $errors = "";      // test to see if the form was actually       // check to see if requiired fields were entered	  	        if (!$_POST['firstname'])         $errors .= "<li>First Name</li>";		       if (!$_POST['lastname'])         $errors .= "<li>Last Name</li>";		       if (!$_POST['email'])         $errors .= "<li>Email</li>";		       if (!$_POST['institution'])         $errors .= "<li>Institution</li>";		 		       if (!$_POST['address1'])         $errors .= "<li>Address1</li>";		       if (!$_POST['city'])         $errors .= "<li>City</li>";		       if (!$_POST['state'])         $errors .= "<li>State</li>";		       if (!$_POST['zip'])         $errors .= "<li>Zip/Postal Code</li>";		       if (!$_POST['country'])         $errors .= "<li>Country</li>";		       if (!$_POST['phone'])         $errors .= "<li>Phone #</li>";		 	  if (!$_POST['shirt'])         $errors .= "<li>TShirt size</li>";		       if (!$_POST['contactInfo'])         $errors .= "<li>Attendee List permission</li>"; 		 	  // if there are any errors, display them      if ($errors) {	   echo "<p>&nbsp;</p>";		  echo "<div align=left><hr><blockquote><p><strong class=required>Registration Incomplete</strong></p>			<p><strong> Please use your browser's Back button to provide the following information: </strong></p>			<ul>";		  echo $errors;		  echo "</ul><br></blockquote><br /><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>";		  		?>                  <?php		 } 			else { 	    // no more errors, now check to see if user has already registered		require "mysqlconnect.php";			$myemail=$_POST['email'];				$sql="SELECT email FROM seppConf where confID='June05'";		$result= mysql_query($sql);		$resultsnumber=mysql_numrows($result);		while($links=mysql_fetch_array($result))		{		$id=$links["id"]; 		$emailadd=$links["email"];		$first=$links["firstname"];		if ($emailadd == $myemail) 		$found="TRUE";		}	if ($found) //email address already entered	 echo "<hr><div align=left><blockquote><p><strong class=required>Registration Error:</strong>According to our records, 	  we have already received a conference registration from <em> $_POST[email]</em>.  <br><br>	  Please contact the <a href=\"mailto:kreister@umich.edu\">conference registration manager</a>	   with any questions<br><br></p><br><br></blockquote><hr></div>"; else {	if (!$found) //no previous entry so go to cc form	{ 					  echo "<hr>";         		 echo "<div><blockquote><p><strong>Non-member Registration Fee: </strong>$395.00 </p>";	 if ((($_POST['ospi'])=='X') || (($_POST['jasig'])=='X')) {	 $_SESSION['fee']="345";		 echo "      <p><strong>Community Source Week Discount is </strong> $50</p>";		 echo "<p><br /><strong>---- Your Discounted Registration Fee is: </strong><font color=red>$345.00</font> ---- </p>";		 echo "<p><br /> Please click on <strong>Continue</strong> to proceed to <br />our secure server to complete the credit card payment process. </p></blockquote></div>";	?>                    <blockquote>                    <form name="webcredit" method="POST" action="https://chico.nss.udel.edu/webcredit/formview.jsp" onSubmit='return(sub_form(this) && sub_cc(this))'>                      <input type="submit" value="continue" />                      <input type="hidden" name="wc_formid"  value="SAK1" />                      <input type="hidden" name="wc_deptid"  value="4321" />                      <input type="hidden" name="wc_addItem_SAKreg"  value="1" />                      <input type="hidden" name="wc_SAKreg_price"  value="345.00" />                      <input type="hidden" name="wcsave_email"  value="<?php echo $_POST['email'];?>" />                      <input type="hidden" name="wc_addParm_curl" value="http://www.sakaiproject.org/conferenceJune_05/confirmation.php"/>                    <input type="hidden" name="wc_addParm_eurl" value="<p><b>We are sorry, your registration was not submitted.</b><br><br>Please double-check the form entries and try again. If you continue to have problems, contact the the webmaster at sakaiproject_webmaster@umich.edu.<br /><br /> <strong>Please note</strong>, we WILL hold your registration entry in our registration database while we look into the problems.</p> " />                    </form>                  </blockquote>                  <?php    } else  		{ $_SESSION['fee']="395";		 echo "<blockquote><p>Please click on <strong>Continue</strong> to proceed<br /> to our secure server to complete the credit card payment process. </p>";	  ?>                                   <form name="webcredit" method="POST" action="https://chico.nss.udel.edu/webcredit/formview.jsp" onSubmit='return(sub_form(this) && sub_cc(this))'>                      <input type="submit" value="continue" />                      <input type="hidden" name="wc_formid"  value="SAK1" />                      <input type="hidden" name="wc_deptid"  value="4321" />                      <input type="hidden" name="wc_addItem_SAKreg"  value="1" />                      <input type="hidden" name="wc_SAKreg_price"  value="395.00" />                                            <input type="hidden" name="wcsave_email"  value="<?php echo $_POST['email'];?>" />                      <input type="hidden" name="wc_addParm_curl" value="http://www.sakaiproject.org/conferenceJune_05/confirmation.php"/>                    <input type="hidden" name="wc_addParm_eurl" value="<p><b>We are sorry, your registration was not submitted.</b><br><br>Please double-check the form entries and try again. If you continue to have problems, contact the the webmaster at sakaiproject_webmaster@umich.edu.<br /><br /> <strong>Please note</strong>, we WILL hold your registration entry in our registration database while we look into the problems.</p> " />                    </form>                  </blockquote>                  <?php }		$username=$_SESSION['firstname'] .sakai;	//cc payment was successful, enter data into conference database		$firstname = $_SESSION['firstname']; 		$lastname = $_SESSION['lastname'];		$badge = $_SESSION['badge'];		$email = $_SESSION['email'];		$institution = $_SESSION['institution'];		$otherInst = $_SESSION['otherInst'];		$dept = $_SESSION['dept'];		$address1 = $_SESSION['address1'];		$address2 = $_SESSION['address2'];		$city = $_SESSION['city'];		$state = $_SESSION['state'];		$otherState = $_SESSION['otherState'];		$zip = $_SESSION['zip'];		$country = $_SESSION['country'];		$phone = $_SESSION['phone'];		$fax = $_SESSION['fax'];		$org_gov = $_SESSION['org_gov'];		$framework = $_SESSION['framework'];		$toolsDev = $_SESSION['toolsDev'];		$otherInterest = $_SESSION['otherInterest'];		$adoption = $_SESSION['adoption'];		$admin = $_SESSION['admin'];		$arch = $_SESSION['arch'];		$collab = $_SESSION['collab'];		$content = $_SESSION['content'];		$coreMed = $_SESSION['coreMed'];		$courseEval = $_SESSION['courseEval'];		$lang = $_SESSION['lang'];		$dev = $_SESSION['dev'];		$lib = $_SESSION['lib'];		$mig = $_SESSION['mig'];		$portfolio = $_SESSION['portfolio'];		$pedagogy = $_SESSION['pedagogy'];		$QA = $_SESSION['QA'];		$req = $_SESSION['req'];		$scorm = $_SESSION['scorm'];		$stratAdvoc = $_SESSION['stratAdvoc'];		$ui = $_SESSION['ui'];		$supp = $_SESSION['supp'];		$demo = $_SESSION['demo'];		$demoURL = $_SESSION['demoURL'];		$BOF = $_SESSION['BOF'];		$comments = $_SESSION['comments'];		$shirt = $_SESSION['shirt'];		$diet = $_SESSION['diet'];		$special = $_SESSION['special'];		$hotelInfo = $_SESSION['hotelInfo'];		$contactInfo = $_SESSION['contactInfo'];		$jasig = $_SESSION['jasig'];		$ospi = $_SESSION['ospi'];		$fee=$_SESSION['fee'];	//cc payment was successful, enter data into conference database				require "mysqlconnect.php";				//get the entry date 	$datea= date('m-d-Y');		//perform the mysql query	$register="INSERT INTO seppConf values (		 '', '$datea', 'June05', '$firstname', '$lastname', '$badge', '$email', '$institution', '$otherInst', '$dept', '$address1', '$address2', '$city', '$state', '$otherState', '$zip', '$country', '$phone', '$fax', '$org_gov', '$framework', '$toolsDev', '$otherInterest', '$adoption', '$admin', '$arch', '$collab', '$content', '$coreMed', '$courseEval', '$lang', '$dev', '$lib', '$mig', '$portfolio', '$pedagogy', '$QA', '$req', '$scorm', '$stratAdvoc', '$ui', '$supp', '$demo', '$demoURL', '$BOF', '$comments', '$shirt', '$diet', '$special', '$hotelInfo', '$contactInfo', '$jasig', '$ospi', '$fee')";					//check results		$result = mysql_query($register) or die(mysql_error("<div align=left><blockquote>There was a problem with the registration form submission.		Please try to submit the registration again. 		 If you continue to have prolems, please report the problem to the 		 <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>.</blockquote></div>"));				if ($result)  	//succesful registration so send email confirmation 						//set up the email confirmations					$msg ="Thank you for your registration to the Sakai SEPP Summer 2005 Conference which will be held June 8-10, 2005 in Baltimore, MD.\r\n";					$msg.=" If you have any questions about your registration information please contact kreister@umich.edu. \r\n \r\nThank You\r\n \r\n     Sakai Staff\r\r\r";											$msg.="-------------------------------------------- \r\n\r\n";			$msg.="SAKAI FACEBOOK:  Add your photo to the Sakai SEPP Conference Facebook at http://www.sakaiproject.org/facebook/index.php. \r\n\r\n";			$msg.="-------------------------------------------- \r\n\r\n";			$msg.="Registration Fee:   $ $fee \r\n\r\n";			$msg.="Date Submitted:   $datea \r\n\r\n";			$msg.="Attendee:   $firstname $lastname \r\n\r\n";						if ($_POST['badge'])			$msg.="Badge Name:   $badge \r\n\r\n";			else 						$msg.="Email:    $email\r\n\r\n";						if ($_POST['institution']=="Other")						$msg.="Institution:   $otherInst \r\n\r\n";			else						$msg.="Institution:   $institution \r\n\r\n";															if ($_POST['dept'])						$msg.="Department:   $dept \r\n\r\n";						$msg.="Address:\r\n";												$msg.="\t $address1 \r\n";					if ($_POST['address2'])			$msg.="\t $address2 \r\n";						$msg.="\t $city, $state, $zip,    $country \r\n\r\n";							$msg.="Phone:   $phone  \r\n\r\n";			$msg.="Fax:   $fax \r\n\r\n";						if ($_POST['demo'])			$msg.="Demo:   Yes, please contact me about doing a demo\r\n\r\n";				if ($_POST['comments'])			$msg.="Comments:   $comments\r\n\r\n";		else			$msg.="Comments:   none \r\n\r\n";		$msg.="TShirt size:  $shirt \r\n\r\n";				if ($_POST['diet'])			$msg.="Special Diet:  $diet \r\n\r\n";		else 			$msg.="Special Diet: none \r\n\r\n";				if ($_POST['special'])			$msg.="Other Special:  $special \r\n\r\n";		else 			$msg.="Other Special:  none \r\n\r\n";		if ($_POST['hotel'])			$msg.="Staying at Conf. Hotel:  Yes \r\n\r\n";		else 			$msg.="Staying at Conf. Hotel: No \r\n\r\n";								if ($_POST['contactInfo']=='Y')			$msg.="Publish name on Attendee list: YES ";		else 			$msg.="Publish name on Attendee list:  NO ";						//set up mail for Susan			$recipient = "shardin@umich.edu";			$subject= "SEPP Non-Member Registration Confirmation";			$mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";			$mailheaders .="From: www.sakaiproject.org \n";			$mailheaders .="Reply-To: $email";			//send the mail to susan			mail($recipient, $subject, $msg, $mailheaders);												//set up mail for Kathi			$recipient = "kreister@umich.edu";			$subject= "SEPP Non-Member Registration Confirmation";			$mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";			$mailheaders .="From: www.sakaiproject.org \n";			$mailheaders .="Reply-To: $email";			//send the mail to Kathi			mail($recipient, $subject, $msg, $mailheaders);									//set up mail for registrant			$recipient = "$email";			$subject= "SEPP Conference Registration Confirmation";			$mailheaders = "Content-type: text/plain; charset=ISO-8859-1\r\n";			$mailheaders .="From: www.sakaiproject.org \n";			$mailheaders .="Reply-To: kreister@umich.edu";			//send the mail to registrant			mail($recipient, $subject, $msg, $mailheaders);					}			}}				?>                </div>                <div>                  <p>&nbsp;</p>                  <p>&nbsp;</p>                  <p>&nbsp;</p>                  <p>&nbsp;</p>                </div></td>            </tr>            <tr class="creditsHere">              <td>&nbsp;</td>              <td border="0" align="center" valign="top"><p class="small">Contact <a href="mailto:sakaiproject_webmaster@umich.edu">--Webmaster</a></p>                <br>              </td>            </tr>          </tbody>        </table></td>    </tr></table></body></html>