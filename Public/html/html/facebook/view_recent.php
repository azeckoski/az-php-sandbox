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
              <td width=180px><a href="../index.php"><img src="../conferenceJune_05/regindex_files/logoslate160x89.jfif" alt="Sakai Logo" border="0"></a> </td>
              <td><div id=header>
                  <h1>SEPP Conference Facebook</h1>
                  <p class=banner>Baltimore, MD - June 8-10, 2005</p>
                </div></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
    <tr>
      <td><table id="searchBar1" bgcolor="#f3f3f3" border="0" width="100%">
          <tbody>
            <tr>
              <td class="searchBar"><span class="pathway"> <img src="../conferenceJune_05/regindex_files/arrow.png" height="9" width="9"> <span class="pathway"><a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=243&Itemid=477">SEPP Conference</a> <img src="../conferenceJune_05/regindex_files/arrow.png" alt="arrow"> <a href="index.php">Facebook </a><img src="../conferenceJune_05/regindex_files/arrow.png" alt="arrow">- by recent entries</span> </span></td>
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
              <td  valign=top class="viewmenu"><div><strong>Display photos by: </strong></div>
              <div><ul>
                 <li>&nbsp;&nbsp;&nbsp;<a href=view_lastname.php>Last Name</a></li>
                <li><img src="../conferenceJune_05/regindex_files/arrow.png" height="9" width="9"><a href=view_recent.php>Recent Entry</a></li>
               <li>&nbsp;&nbsp;&nbsp;<a href=view_institution.php>Institution</a></li></ul></div></td>
              <td  valign=top  class="editmenu"><p><img src="http://sakaiproject.org/austin/austinLogos/sakaiAustin_metalSm_wht.jpg" width=50 height=50 align=left /><strong>NEW for December 2005:<br /></strong>&nbsp; &nbsp;<a href="http://www.sakaiproject.org/austin/facebook">Sakai Austin Conference Facebook</a></p></td>
               
            </tr>
 
          </table>
        </div>
        <?php
	
include ('get_offset.php');
	$query  = "SELECT * FROM facebook order by id DESC LIMIT $offset, $rowsPerPage";
$searchresult = mysql_query($query);

include ('main_content.php');
?>
  <td></tr><tr><td> <div>     <table width="100%">
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
