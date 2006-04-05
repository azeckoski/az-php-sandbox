<?php 
if (isset ($HTTP_POST_VARS[submit])) {  


	// Check to make sure they entered their last name and it's of the right format. 
	if (eregi ("[[:alnum:][:space:]]", $HTTP_POST_VARS[name1])) {
			$a = TRUE;
	} else {
			$a = FALSE;
			$message[] = "Please enter your name.";
	}
	
	// Check to make sure they entered a valid email address. 
	if (eregi("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $HTTP_POST_VARS[email1])) { 
			$c = TRUE;
	} else {
			$c = FALSE;
			$message[] = "Please enter a valid email address.";
	}

	// Check to make sure they entered a valid email address. 
	if (eregi("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $HTTP_POST_VARS[email2])) { 
			$d = TRUE;
	} else {
			$d = FALSE;
			$message[] = "Please confirm your email address.";
	}

	// Check to make sure the email matches the confirmed email. 
	if ($HTTP_POST_VARS[email1] == $HTTP_POST_VARS[email2]) {
			$e = TRUE;
	} else {
			$e = FALSE;
			$message[] = "The email you entered did not match the confirmed email.";	
	}
	
		// Check to make sure they entered an idea. 
	if (eregi ("[[:alnum:][:space:]]", $HTTP_POST_VARS[idea])) {
			$b = TRUE;
	} else {
			$b = FALSE;
			$message[] = "Please enter your idea.";
	}




	
		if ($a AND $b AND $c AND $d AND $e) {
		if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {

   $uploadedOk=TRUE;

		
		// get client side file name 

$userfile_error = $_FILES['userfile']['error'];

// userfile_error was introduced at PHP 4.2.0
// use this code with newer versions

if ($userfile_error > 0) {
echo '<div id=box style=height:300px;><div class=errors><p><strong>Upload Incomplete</strong></p><p>';
switch ($userfile_error)
{ case 1:
echo 'File exceeded upload_max_filesize</p></div></div>';
break;
case 2:
echo 'File exceeded max_file_size</p></div></div>';
break;
case 3:
echo 'File only partially uploaded</p></div></div>';
break;
case 4:
echo 'File not found </p></div></div>';
break;
}
exit;
}
				
		
	
	
$uploadDir = '/afs/umich.edu/group/acadaff/sakai/Public/html/conferenceDec_05/theme/graphics/';
$uploadFile = $uploadDir . ($_FILES['userfile']['name']);
$filename= '../conferenceDec_05/theme/graphics/' . $_FILES['userfile']['name'];

$fileNameParts = explode(".", $_FILES['userfile']['name']); 

$fileExtension = end($fileNameParts); 
// part behind last dot 



if ($fileExtension != "jpg" && $fileExtension != "JPEG" && $fileExtension != "JPG" && $fileExtension != "gif" && $fileExtension != "GIF" && $fileExtension != "PNG" && $fileExtension != "png") 
die("<div id=box style=height:300px;><div class=errors><p><strong>Upload Incomplete</strong></p>
<p>Error -  Image format must be jpg, gif, png, or bmp</p></div></div>"); 







    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile))       {

  //  If the data passes all the tests, check to ensure a unique member name, then register them. 

require "../includes/mysqlconnectWeb.php";


$entry="INSERT INTO contest values ('',
		'$_POST[name1]', 
		'$_POST[email1]',
		'$_POST[email2]',
		'$_POST[idea]',
		'$filename',
		'no'
		)";
		
$result = mysql_query($entry) or die(mysql_error("
		<p>There was a problem with the submission form submission.
		Please try to submit the entry again. 
		 If you continue to have prolems, please report the problem to the 
		 <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>.</p>"));

					header ("Location: theme2.php"); // Send them on their way.

}}
else {

$filename='none';
require "../includes/mysqlconnectWeb.php";


$entry="INSERT INTO contest values ('',
		'$_POST[name1]', 
		'$_POST[email1]',
		'$_POST[email2]',
		'$_POST[idea]',
		'$filename',
		'no'		)";
		
$result = mysql_query($entry) or die(mysql_error("
		<p>There was a problem with the submission form submission.
		Please try to submit the entry again. 
		 If you continue to have prolems, please report the problem to the 
		 <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>.</p>"));

echo "<p>entry successful</p>";
					header ("Location: theme2.php"); // Send them on their way.

}


}
}
 //show form 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sakai Project- Conference Theme entries</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content=",Sakai - www.sakaiproject.org, Community Source Software for Education.">
<meta name="keywords" content=",sakai, sakaiproject.org, sakaiproject, Sakai, Community Source, Open Source, open-open, educational software, collaborative">
<meta name="Generator" content="Mambo - Copyright 2000 - 2004 Miro International Pty Ltd.  All rights reserved.">
<meta name="robots" content="index, follow">
<link href="../conferenceJune_05/regindex_files/template_css.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="../conferenceJune_05/templates/extralight/templates/extralight/images/favicon.ico">
<link href="contest.css" rel="stylesheet" type="text/css">

</head>

<body>
<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
    <tr>
      <td class="mainHeader" width="100%"><table border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td><a href="../index.php"><img src="../conferenceJune_05/regindex_files/logoslate160x89.jfif" alt="Sakai Logo" border="0"></a></td>
              <td class="topNav" align="right" valign="top" width="100%"></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#eeeeee"><table class="searchBar1" bgcolor="#f3f3f3" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td class="searchBar" style="padding:3px;"><span class="pathway"> <img src="../conferenceJune_05/regindex_files/arrow.png" height="9" width="9"> <span class="pathway"><a href="../index.php" class="pathway">Home</a> <img src="../conferenceJune_05/regindex_files/arrow.png" alt="arrow">&nbsp; Sakai SEPP Conference Theme</span> </span></td>
              <td align="right">&nbsp; &nbsp; &nbsp;&nbsp;</td>
              <td align="left" width="120"></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
    <tr class="mainPageContent">
      <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr align="center" valign="top">
              <td class="leftSide" style="border-right: 1px solid rgb(227, 227, 227);" width="160">
			  
			  <table border="0" cellpadding="0" cellspacing="3" width="100%">
                  <tbody>
                    <tr>
                      <td><table class="moduletable"   cellpadding="0" cellspacing="0">
                          <tbody>
                            <tr>
                              <th valign="top"> NEXT CONFERENCE </th>
                            </tr>
                            <tr>
                              <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
                                  <tbody>
                                    
                                   <tr><td><div>
<p><strong><font color="#000000"><font face="Arial"><font color="#000000">4th SEPP Conference</font></font><br>
<font color="#333333">
Austin, Texas<br>
</font></font><font color="#333333">
December 7-9, 2005</font></strong></p><br>
</div>
<div>
<p style="padding-left: 10px;" class="small"><a target="_blank" href="http://www.hilton.com/en/hi/hotels/index.jhtml;jsessionid=E4QT4OOFSMQ5MCSGBIYM22QKIYFCXUUC?ctyhocn=AUSCVHH" title=""><img style="margin: 0px 0px 5px;" width="50" height="35" border="0" align="middle" src="http://www.hilton.com/en/hi/media/images/logos/brandLogo.gif" alt="" title=""></a><br>
<strong><a target="_blank" href="http://www.hilton.com/en/hi/hotels/index.jhtml;jsessionid=E4QT4OOFSMQ5MCSGBIYM22QKIYFCXUUC?ctyhocn=AUSCVHH" title="">Austin Hilton
</a></strong><br>
500 East 4th Street<br>
Austin,&nbsp;Texas&nbsp; 78701 <br>
Tel:&nbsp;+1-512-482-8000&nbsp; <br>
Fax:&nbsp;+1-512-469 0078 &nbsp;</p></div><br /><br /></td></tr>

<tr><td class="small"><br /><br /><br />If you experience problems using this form, you
may submit your ideas directly to <a href="mailto:shardin@umich.edu?subject=Austin%20Logo%20Idea">shardin@umich.edu</a></p></td></tr>
                                  </tbody>
                                </table></td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
              <td class="centerContent"><div><?php 
if ($message) {
	echo "<blockquote class=small align=\"left\"><font color=red><b>The following problems occurred:</b><br />\n";	
	foreach ($message as $key => $value) {
		echo "$value <br />\n";	
	}
	echo "<br /><br /></font></blockquote>";
}


?>
</div>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
<table cellpadding="1" bordercolor="#cccccc" border="0">
  <tbody>
    <tr>
           <td align="right"><div>
<img style="margin: -10px 10px 2px;" width="110" height="95" align="right" src="/images/stories/swag_sm.jpg" alt="" title="">
      </div></td>
      <td align="right">&nbsp;</td>
      <td align="left"><p align="left"><strong>Enter to Win a Sakai Polo Shirt. </strong><br />
  Submit your ideas for a conference logo or theme  for the Austin conference. If your idea is chosen, we'll send
  you a shirt or hat from the Austin conference. </p><p>Submit as many ideas as you like before the deadline.  <a href="theme_entry.php#list">View Recent Entries</a>
      </p></td>
      <td width="245" rowspan="8" style="border-left:1px solid #eee;">
<div align="center"><u><em><strong>Previous Conferences</strong></em></u></div><div align="center"><a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=view&amp;id=243&amp;Itemid=477" title="3rd Sakai SEPP Conference June 2005"><img style="margin: 0px;" width="77" height="100" border="0" align="bottom" src="http://www.sakaiproject.org/images/stories/conferenceLogos/csw05_sakai_sm.jpg" alt="" title=""><br />Set Sail with Sakai<br><br /></a><br>
    <a href="http://sakaiproject.org/conferenceDec_04" title="2nd Sakai SEPP Conference December 2004"><img style="margin: 0px;" width="80" height="73" border="0" align="bottom" title="" alt="" src="http://www.sakaiproject.org/images/stories/conferenceLogos/2nd_conf_logo.jpg"><br />Improvising on Sakai<br><br /></a>
    <a href="http://sakaiproject.org/conferenceJune_04" title="1st Sakai SEPP Conference, June 2004"><img style="margin: 0px;" width="80" height="69" border="0" align="bottom" title="" alt="" src="http://www.sakaiproject.org/images/stories/1st_conf.jpg"><br />Rocky Mountain Sakai<br><br /></a></div></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td><p><strong>Deadline for entries: </strong><span class="style1">August 15, 2005 </span></p></td>
    </tr>
    <tr><td width="213" align="right">
<div align="right"><strong>Name: *&nbsp;</strong></div></td><td width="10">&nbsp;</td><td width="392">
<input type="text"maxlength="40" size="20" value="<?php echo $HTTP_POST_VARS[name1] ?>" name="name1"></td></tr><tr><td align="right">
<div align="right"><strong>Email: *&nbsp; <br>
</strong></div></td><td>&nbsp;</td><td>
<input type="text" maxlength="70" size="20" name="email1" value="<?php echo $HTTP_POST_VARS[email1] ?>"> </td></tr><tr><td align="right">
<div align="right"><strong>Confirm Email: *&nbsp; <br>
</strong></div></td><td>&nbsp;</td><td>
<input type="text"  maxlength="70" size="20" name="email2" value="<?php echo $HTTP_POST_VARS[email2] ?>"> </td></tr><tr><td align="right">
<div align="right"><strong>Theme/Logo Idea:* </strong></div></td><td>&nbsp;</td><td>
<input type="text" size="30" maxlength="200" name="idea" value="<?php echo $HTTP_POST_VARS[idea] ?>"></td></tr><tr><td align="right">
<div align="right">
<p><strong>Image File</strong>  (if any)<br>

<span class="small">(jpg, png, bmp, gif)</span>
 </p> </div></td><td>&nbsp;</td><td>
<input type="file" name="userfile" >
 </td>
</tr><tr><td>&nbsp;</td><td>&nbsp;</td><td valign="top">
<input type="submit" name="submit" value="submit"> <br>
</td></tr></tbody></table>
</form><br>

<?php
require "../includes/mysqlconnectWeb.php";


	  $sql = 'SELECT * FROM contest where approved like "yes" ORDER BY id DESC';
	  	  $reportname='All Entries';
 
	  
	 $result= mysql_query($sql);
$resultsnumber=mysql_numrows($result);
$line = "1";
$row="0";


echo"<span id=list></span>

 <table width=80% margin-left=10px id=data cellspacing=2> 
		<tr><td colspan=2 align=Left><p><strong>Contest Entries</strong></p></td>
		<td colspan=1 align=left class=report>&nbsp;</td></tr>

<tr class=tableheader>

	<td align=center><strong>imagefile</strong></td>
		<td><strong>Theme suggestion</strong></td>

		<td><strong>Submitted by:</strong></td>



</tr>
";





while($links=mysql_fetch_array($result))
{
$row++; 
$id=$links["id"];
$name=$links["name"];
$email1=$links["email1"];
$idea=$links["idea"];
$file=$links["file"];
$approved=$links["approved"];



if ($line == 1) {   	
	echo "<tr id=oddrow valign=top>";
   $line='2';

} else {
	echo "<tr id=evenrow valign=top>";
	$line='1';
}
	
	if ($file == 'none') {  
	echo "<td>n/a</td>";
	}
	else {
	
	echo "<td><a href=\"../$file\"><img src=\"../$file\" height=50px width=50px></a></td>";
	}
	
		echo"	<td>$idea</td>";

	echo"	<td><span class=small style=\"color:#333;\"> $name</span></td>";

echo "</tr>";

 //end row, so change color   


} //end of while


echo"</table><br /><br />";

?>

</td>
            </tr>
            <tr class="creditsHere">
              <td height="60px">&nbsp;</td>
              <td align="center" valign="top"><span class="small">Contact <a href="mailto:sakaiproject_webmaster@umich.edu">--Webmaster</a></span><br>
              </td>
            </tr>
          </tbody>
        </table></td>
    </tr>
</table>
</body>
</html>
