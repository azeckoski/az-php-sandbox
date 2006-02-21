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
  
  <!--  header-->
  <tr>
      <td class="mainHeader" width="100%">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td width=160px><a href="../index.php"><img src="../conferenceJune_05/regindex_files/logoslate160x89.jfif" alt="Sakai Logo" border="0"></a> </td>
              <td id=confHeader><div id=header>
<img src="../images/stories/conf_albumJune05/conf4.jpg"></div></td>
            </tr>
          </tbody>
        </table>
       </td>
  </tr>
  
    <!--  searchbar-->

  <tr>
      <td>
      <table id="searchBar1" bgcolor="#f3f3f3" border="0" width="100%">
          <tbody>
            <tr>
              <td class="searchBar"><span class="pathway"> <img src="../conferenceJune_05/regindex_files/arrow.png" height="9" width="9"> <span class="pathway"><a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=243&Itemid=477">SEPP Conference</a> <img src="../conferenceJune_05/regindex_files/arrow.png" alt="arrow"> <a href="index.php">Conference Album </a> -search </span></span></td>
            <td class="searchBar" valign=top align="right">
                  <form method="post" action="searchConf.php">
                    <label> Search Conference Album</label>
                    <input type="text" name="searchword" size="15" maxlength="40" value="<?php echo $_POST['searchword']?>" />
                    <input type="submit" value="go" />
                  </form>
                </td>
              </tr>
          </tbody>
        </table>
       </td>
    </tr>
    
      <!--  main page content-->
    <tr class="mainPageContent">
      <td>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
       <tbody>

    <tr align="center" valign="top">
        
    <td class="centerContent" width="100%">

	<div id="photos">
        <!-- menu -->

		<div id=menu>
          <table width=100%>
            <tr>
              <td  valign=top class="viewmenu"><br />
              <div><a href="conf_add_photo.php">  Submit Conference Photo</a><br />
              <br />
              </div></td>
              <td  valign=top class="add_photo">
              <div><br />
              <a href="../facebook/index.php"> Visit the Sakai Facebook</a><br />
              <br /></div>
              </td>
            </tr>
          </table>
        </div>
      
               <div id="add_photo">

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

	$query  = "SELECT * FROM conference_album WHERE MATCH (name, other, email, event, who) AGAINST('$text') LIMIT $offset, $rowsPerPage";
$searchresult = mysql_query($query);


// how many rows we have in database that match criteria
$count   = "SELECT COUNT(*) AS numrows FROM conference_album WHERE MATCH (name, other, email, event, who) AGAINST('$text') LIMIT $offset, $rowsPerPage";
$result  = mysql_query($count) or die('Error, query failed');
$row     = mysql_fetch_array($result, MYSQL_ASSOC);
$numrows = $row['numrows'];


if ($numrows <1) {
echo"<div id=box style=height:300px;><p align=center> Your search for -<strong> $text </strong> - did not match any album entries.</p></div>
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
echo"<div id=box style=height:300px;><p align=center>$numrows item matched your search.</p>";

include ('print_images.php');
echo" </td></tr>";
}

if ($numrows > 1) {
echo"<div id=box style=height:300px;><p align=center> $numrows items matched your search.</p>";


include ('print_images.php');
echo" </td></tr>";


}
}

?>
 <table width="100%">
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