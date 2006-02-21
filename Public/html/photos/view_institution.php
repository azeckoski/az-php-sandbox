<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sakai Project: SEPP Conference Facebook</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content=",Sakai - www.sakaiproject.org, Community Source Software for Education.">
<meta name="keywords" content=",sakai, sakaiproject.org, sakaiproject, Sakai, Community Source, Open Source, open-open, educational software, collaborative">
<meta name="robots" content="index, follow">
<link href="template_css.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="facebook2.css" type="text/css"/>
</head>
<body>
<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
    <tr>
      <td class="mainHeader" width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td width=160px><a href="../index.php"><img src="../conferenceJune_05/regindex_files/logoslate160x89.jfif" alt="Sakai Logo" border="0"></a> </td>
              <td id=confHeader><div id=header>
<img src="../images/stories/conf_albumJune05/conf4.jpg"></div></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
    <tr>
      <td><table id="searchBar1" bgcolor="#f3f3f3" border="0" width="100%">
          <tbody>
            <tr>
              <td class="searchBar"><span class="pathway"> <img src="../conferenceJune_05/regindex_files/arrow.png" height="9" width="9"> <span class="pathway"><a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=243&Itemid=477">SEPP Conference</a> <img src="../conferenceJune_05/regindex_files/arrow.png" alt="arrow"> <a href="index.php">Conference Album </a> </span></td>
            <td class="searchBar" valign=top align="right">
                  <form method="post" action="search.php">
                    <label> Search Facebook</label>
                    <input type="text" name="searchword" size="15" maxlength="40" value="<?php echo $_POST['searchword']?>" />
                    <input type="submit" value="go" />
                  </form>
                </td></tr>
          </tbody>
        </table></td>
    </tr>
  <tr class="mainPageContent">
      <td class="centerContent" width="100%"><div id="photos"><div id="menu">
          <table width=100%>
            <tr>
              <td  valign=top class="viewmenu">
              <div><br /><a href=../facebook/index.php>Back to Sakai Facebook<br /></a><br /><a href=add_photo.php> Submit New Conference Photo</a> 
              </div>
              </td>
              
            </tr>
 
          </table>
        </div>
        <?php
	include ('get_offset.php');
	$query  = "SELECT * FROM facebook order by Institution LIMIT $offset, $rowsPerPage";
$searchresult = mysql_query($query);

include ('main_content.php');

?>
<tr><td> <div>     <table width="100%">
          <tbody>
            <tr class="creditsHere">
              <td align="center" valign="top"><div><p><span class="small">Contact <a href="mailto:sakaiproject_webmaster@umich.edu">--Webmaster</a></span><br>
             </p> </div></td>
            </tr>
          </tbody>
        </table></div></td>
    </tr>
  </tbody>
</table>
</body>
</html>

