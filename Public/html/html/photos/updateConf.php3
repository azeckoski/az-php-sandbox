<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><title>Sakai Project: SEPP Conference Facebook</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta name="description" content=",Sakai - www.sakaiproject.org, Community Source Software for Education."><meta name="keywords" content=",sakai, sakaiproject.org, sakaiproject, Sakai, Community Source, Open Source, open-open, educational software, collaborative"><meta name="robots" content="index, follow"><link href="template_css.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="facebook2.css" type="text/css"/></head><body><table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">  <tbody>    <tr>      <td class="mainHeader" width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0">          <tbody>            <tr>              <td width=160px><a href="../index.php"><img src="../conferenceJune_05/regindex_files/logoslate160x89.jfif" alt="Sakai Logo" border="0"></a> </td>              <td id=confHeader><div id=header><img src="../images/stories/conf_albumJune05/conf4.jpg"></div></td>            </tr>          </tbody>        </table></td>    </tr>    <tr>      <td><table id="searchBar1" bgcolor="#f3f3f3" border="0" width="100%">          <tbody>            <tr>              <td class="searchBar"><span class="pathway"> <img src="../conferenceJune_05/regindex_files/arrow.png" height="9" width="9"> <span class="pathway"><a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=243&Itemid=477">SEPP Conference</a> <img src="../conferenceJune_05/regindex_files/arrow.png" alt="arrow"> <a href="index.php">Conference Album </a> </span></td>            <td class="searchBar" valign=top align="right">                  <form method="post" action="searchConf.php">                    <label> Search Conference Album</label>                    <input type="text" name="searchword" size="15" maxlength="40" value="<?php echo $_POST['searchword']?>" />                    <input type="submit" value="go" />                  </form>                </td></tr>          </tbody>        </table></td>    </tr>    <tr class="mainPageContent">      <td><table border="0" cellpadding="0" cellspacing="0" width="100%">          <tbody>            <tr align="center" valign="top">              <td>                                         <div id=help>              	<p> <span class=goback><a href=index.php>Return to Conference Photos</a></span> </p><br /><br /><br />			<p><strong>Need help?</strong><br />If you experience problems adding your information to our facebook, 			or if you need to make changes after your information is published, please email 			<a href="mailto:shardin@umich.edu">Susan Hardin</a></p>		   </div>				</td>    <td class="centerContent" width="100%">       <div id=photos>		<div id=menu>			<div id=addphoto >			<?php            require 'resize.php'; //error reporting      error_reporting(0);	        // initialize a variable to 	        //hold any errors we encounter      $errors = "";      // test to see if the form was actually       // check to see if requiired fields were entered	  	       if (!$_POST['name'])         $errors .= "<li> Name<br></li>";		     //  if (!$_POST['Last'])     //    $errors .= "<li> Last Name<br></li>";		       if (!$_POST['email'])         $errors .= "<li> Email<br></li>";		      if (!$_POST['date'])        $errors .= "<li> Date<br></li>";               // if (!$_POST['interests'])      //   $errors .= "<li> Interests<br></li>";           // if there are any errors, display them      if ($errors)  {		echo"<div id=box style=height:300px;><div class=errors><p><strong>Upload Incomplete</strong></p>		  			<p>Please use your browser's Back button to provide the following information: <br /></p>			<blockquote><ul> $errors		  </ul></blockquote><br><br></div></div>";		  		  }		  //all text fields filled out check for registration entry		 		else {		require "mysqlconnectReg.php";$myemail=$_POST['email'];				$sql="SELECT email FROM seppConf where confID='June05'";		$result= mysql_query($sql);		$resultsnumber=mysql_numrows($result);		while($links=mysql_fetch_array($result))		{		$id=$links["id"]; 		$emailadd=$links["email"];		$first=$links["First"];		if ($emailadd == $myemail) 		$found="TRUE";		}					if (!$found) //no previous entry  				 die( "<div id=box style=height:300px;><div class=errors><p><strong>Entry Error:</strong>  <br /><br />You must be a registered conference attendee to add photos to our conference album. <br /><br />	 The email address you entered does<br /> not match any of the 		  			email addresses for conference attendees.</p>		  					  			<p>Please use your browser's Back button and verify that your email<br />		  			address was entered correctly.  If you are registered for the conference<br />		  but continue to receive this error message, please report the problem<br /> to the webmaster</p></div></div>");		 //a registered user so upload image$userfile_error = $_FILES['userfile']['error'];// userfile_error was introduced at PHP 4.2.0// use this code with newer versionsif ($userfile_error > 0) {echo '<div id=box style=height:300px;><div class=errors><p><strong>Upload Incomplete</strong></p><p>';switch ($userfile_error){ case 1:echo 'File exceeded upload_max_filesize</p></div></div>';break;case 2:echo 'File exceeded max_file_size</p></div></div>';break;case 3:echo 'File only partially uploaded</p></div></div>';break;case 4:echo 'No file uploaded</p></div></div>';break;}exit;}$fileNameParts = explode(".", $_FILES['userfile']['name']); $fileExtension = end($fileNameParts); // part behind last dot if ($fileExtension != "jpg" && $fileExtension != "JPEG" && $fileExtension != "JPG" && $fileExtension != "gif" && $fileExtension != "GIF" && $fileExtension != "PNG" && $fileExtension != "png") die("<div id=box style=height:300px;><div class=errors><p><strong>Upload Incomplete</strong></p><p>Error -  Image format must be jpg, gif, png, or bmp</p></div></div>"); $uploadDir = '/afs/umich.edu/group/acadaff/sakai/Public/html/images/stories/conf_albumJune05/';$dbDir = '../images/stories/conf_albumJune05/';$uploadFile = $uploadDir . ($_FILES['userfile']['name']);$dbFile = $dbDir .  ($_FILES['userfile']['name']);// get client side file name if (file_exists($uploadFile)){	$uploadFile = $uploadDir . time() . "-" . ($_FILES['userfile']['name']);	$dbFile = $dbDir . time() . "-" . ($_FILES['userfile']['name']);	if (file_exists($uploadFile))	{		die("<div id=box style=height:300px;><div class=errors><p><strong>Please rename file</strong></p>		<p>Error -  That filename is already used.  Please rename the file and try uploading again.</p></div></div>"); 	}}if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {echo '<div id=box style=height:300px;><div class=errors><p><strong>Upload Incomplete</strong></p><p>';   echo "<blockquote><p>File ". $_FILES['userfile']['name'] ." uploaded successfully.</p>   <p> <a href=\"conf_add_photo.php\">Add another photo </a></p>   <p><br /><a href=\"index.php\">View all photos</a></p>";      if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile))       {   require "facebook_db.php";$password='pass';$register="INSERT INTO conference_album values ('',		'$_POST[name]', 		'$_POST[email]',		'$_POST[event]',		'$_POST[date]',		'$_POST[who]',		'$dbFile',		'$_POST[other]',		'$_POST[url]',		'$password'		)";				$result = mysql_query($register) or die(mysql_error("		<p>There was a problem with the submission form submission.		Please try to submit the entry again. 		 If you continue to have problems, please report the problem to the 		 <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>."));}}      // read photo          }				?>  </div></div>    </td>       </tr>                          <tr><td colspan=2 height=200px></td></tr>	          <tr class="creditsHere">              <td align="center" valign="top"><div><p><span class="small">Contact <a href="mailto:sakaiproject_webmaster@umich.edu">--Webmaster</a></span><br>             </p> </div></td>            </tr>         </tbody>       </table>     </div>    </td>  </tr>  </tbody></table></body></html>