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
              <td class="searchBar"><span class="pathway"> <img src="../conferenceJune_05/regindex_files/arrow.png" height="9" width="9"> <span class="pathway"><a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=243&Itemid=477">SEPP Conference</a> <img src="../conferenceJune_05/regindex_files/arrow.png" alt="arrow"> <a href="index.php">Facebook </a><img src="../conferenceJune_05/regindex_files/arrow.png" alt="arrow">Search Results</span> </span></td>
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
                 <li><a href=view_lastname.php>Last Name</a> </li>
                <li><a href=view_recent.php>Recent Entry</a> </li>
               <li><a href=view_institution.php>Institution</a></li></ul></div></div></td>
              <td  valign=top  class="editmenu">
              
           <p><img src="http://sakaiproject.org/austin/austinLogos/sakaiAustin_metalSm_wht.jpg" width=50 height=50 align=left /><strong>NEW for December 2005:<br /></strong>&nbsp; &nbsp;<a href="http://www.sakaiproject.org/austin/facebook">Sakai Austin Conference Facebook</a></p></td>
                     </tr>
          </table>
        </div>
        <?php
	
	    require 'resize.php';


require "facebook_db.php";


	
$text = $_POST['searchword'];
$text = trim( $text );
	

	

// how many rows to show per page
$rowsPerPage = 30;

// by default we show first page
$pageNum = 1;

// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
    $pageNum = $_GET['page'];
}

// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;

	$query  = "SELECT * FROM facebook WHERE MATCH (First, Last, Institution, interests) AGAINST('$text') LIMIT $offset, $rowsPerPage";
$searchresult = mysql_query($query);


// how many rows we have in database that match criteria
$count   = "SELECT COUNT(*) AS numrows FROM facebook WHERE MATCH (First, Last, Institution, interests) AGAINST('$text') LIMIT $offset, $rowsPerPage";
$result  = mysql_query($count) or die('Error, query failed');
$row     = mysql_fetch_array($result, MYSQL_ASSOC);
$numrows = $row['numrows'];


if ($numrows <1) {
echo"<div id=box style=height:300px;><p align=center> Your search for -<strong> $text </strong> - did not match any facebook entries.</p></div>
";
	
	}
	if ($numrows >0) {

// how many pages we have when using paging?
$maxPage = ceil($numrows/$rowsPerPage);

$self = $_SERVER['PHP_SELF'];

// creating 'previous' and 'next' link
// plus 'first page' and 'last page' link

// print 'previous' link only if we're not
// on page one
if ($pageNum > 1)
{
    $page = $pageNum - 1;
    $prev = " <a href=\"$self?page=$page\">[Prev]</a> ";
    
    $firstp = " <a href=\"$self?page=1\">[First Page]</a> ";
}
else
{
    $prev  = ' [Prev] ';       // we're on page one, don't enable 'previous' link
    $firstp = ' [First Page] '; // nor 'first page' link
}

// print 'next' link only if we're not
// on the last page
if ($pageNum < $maxPage)
{
    $page = $pageNum + 1;
    $next = " <a href=\"$self?page=$page\">[Next]</a> ";
    
    $lastp = " <a href=\"$self?page=$maxPage\">[Last Page]</a> ";
}
else
{
    $next = ' [Next] ';      // we're on the last page, don't enable 'next' link
    $lastp = ' [Last Page] '; // nor 'last page' link
}

if ($numrows ==1 ) {
echo"<div id=box style=height:300px;><p align=center>$numrows item matched your search for -<strong> $text </strong>.</p>";

include ('print_images.php');
echo" </td></tr>";
}

if ($numrows > 1) {
echo"<div id=box style=height:300px;><p align=center> $numrows items matched your search for -<strong> $text </strong>.</p>";


include ('print_images.php');
echo" </td></tr>";


}
}

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
