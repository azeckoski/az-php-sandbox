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
              <td class="centerContent"><div>
</div>
<br>

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
		<tr><td colspan=2 align=Left><p><strong>Sakai Austin Conference Logo Contest Entries</strong></p></td>
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
