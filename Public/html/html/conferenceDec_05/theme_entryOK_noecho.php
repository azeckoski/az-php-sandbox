<?php 
if (isset ($HTTP_POST_VARS[submit])) {  


	// Check to make sure they entered their last name and it's of the right format. 
	if (eregi ("^([[:alpha:]]|-|')+$", $HTTP_POST_VARS[name1])) { 
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
	if (eregi ("^([[:alpha:]]|-|')+$", $HTTP_POST_VARS[idea])) { 
			$b = TRUE;
	} else {
			$b = FALSE;
			$message[] = "Please enter your idea.";
	}


	

	if ($a AND $b AND $c AND $d AND $e) {
 
  //  If the data passes all the tests, check to ensure a unique member name, then register them. 

require "../includes/mysqlconnectWeb.php";


$entry="INSERT INTO contest values ('',
		'$_POST[name1]', 
		'$_POST[email1]',
		'$_POST[email2]',
		'$_POST[idea]',
		'$filename'
		)";
		
$result = mysql_query($entry) or die(mysql_error("
		<p>There was a problem with the submission form submission.
		Please try to submit the entry again. 
		 If you continue to have prolems, please report the problem to the 
		 <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>.</p>"));

echo "<p>entry successful</p>";
	

}
}



 //show form 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Register</title>
</head>
<body>
<?php 
if ($message) {
	echo "<div align=\"left\"><font color=red><b>The following problems occurred:</b><br />\n";	
	foreach ($message as $key => $value) {
		echo "$value <br />\n";	
	}
	echo "<br /><br /></font></div>";
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
<table cellpadding="1" bordercolor="#cccccc" border="0">
  <tbody><tr><td width="213" align="right">
<div align="right"><strong>Name: &nbsp;&nbsp;</strong></div></td><td width="10">&nbsp;</td><td width="392">
<input type="text" value="" maxlength="40" size="20" value="<?php echo $_POST['name1'];?>" name="name1"></td><td width="245" bordercolor="#E4E4E4" bgcolor="#FFFFFF">
<div align="center"><u><em><strong>Previous Conferences</strong></em></u></div></td></tr><tr><td align="right">
<div align="right"><strong>Email: *&nbsp; <br>
</strong></div></td><td>&nbsp;</td><td>
<input type="text" value="" maxlength="70" size="20" name="email1" value="<?php echo $HTTP_POST_VARS[email1] ?>"> </td><td rowspan="5" bordercolor="#E4E4E4" bgcolor="#FFFFFF">
<div align="center"><a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=view&amp;id=243&amp;Itemid=477" title="3rd Sakai SEPP Conference June 2005"><img style="margin: 0px;" width="77" height="100" border="0" align="bottom" src="http://www.sakaiproject.org/images/stories/conferenceLogos/csw05_sakai_sm.jpg" alt="" title=""></a><br>
<a href="http://sakaiproject.org/conferenceDec_04" title="2nd Sakai SEPP Conference December 2004"><img style="margin: 0px;" width="80" height="73" border="0" align="bottom" title="" alt="" src="http://www.sakaitest.org/images/stories/conferenceLogos/2nd_conf_logo.jpg"></a><br>
<a href="http://sakaiproject.org/conferenceJune_04" title="1st Sakai SEPP Conference, June 2004"><img style="margin: 0px;" width="80" height="69" border="0" align="bottom" title="" alt="" src="http://www.sakaitest.org/images/stories/1st_conf.jpg"></a></div></td></tr><tr><td align="right">
<div align="right"><strong>Confirm Email: *&nbsp; <br>
</strong></div></td><td>&nbsp;</td><td>
<input type="text" value="" maxlength="70" size="20" name="email2" value="<?php echo $HTTP_POST_VARS[email2] ?>"> </td></tr><tr><td align="right">
<div align="right"><strong>Theme/Logo Idea </strong></div></td><td>&nbsp;</td><td>
<input type="text" size="30" maxlength="200" name="idea" ></td></tr><tr><td align="right">
<div align="right">
<p><strong>Accompanying<br>
</strong><strong>graphic </strong>(if any) </p> </div></td><td>&nbsp;</td><td>
<input type="file" name="userfile"> </td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td valign="top"><br>
<input type="submit" name="submit" value="submit"> <br>
</td></tr></tbody></table>
</form><br>
<p>If you experience problems using this form, you
may submit your ideas directly to <a href="mailto:shardin@umich.edu?subject=Austin%20Logo%20Idea">shardin@umich.edu</a></p>

</body>
</html>