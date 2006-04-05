<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sakai Project:  SEPP Conference Facebook</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content=",Sakai - www.sakaiproject.org, Community Source Software for Education.">
<meta name="keywords" content=",sakai, sakaiproject.org, sakaiproject, Sakai, Community Source, Open Source, open-open, educational software, collaborative">
<meta name="robots" content="index, follow">
<link href="template_css.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="facebook2.css" type="text/css"/>

</head>
<style type="text/css">
</style>
<body>
<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">

  <tbody>
    <tr>
      <td class="mainHeader" width="100%"><table border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td width=180px><a href="../index.php"><img src="../conferenceJune_05/regindex_files/logoslate160x89.jfif" alt="Sakai Logo" border="0"></a>
              </td><td><div id=header>
	<h1>SEPP Conference Facebook</h1>
	<p class=banner>Baltimore, MD - June 8-10, 2005</p>
	</div></td>
             
            </tr>
          </tbody>

        </table></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#eeeeee"><table class="searchBar1" bgcolor="#f3f3f3" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td class="searchBar"><span class="pathway"> <img src="../conferenceJune_05/regindex_files/arrow.png" height="9" width="9"> <span class="pathway"><a href="http://www.sakaitest.org/index.php?option=com_content&task=view&id=243&Itemid=477" class="pathway">SEPP Conference</a> <img src="../conferenceJune_05/regindex_files/arrow.png" alt="arrow"> <a href="index.php">Facebook </a><img src="../conferenceJune_05/regindex_files/arrow.png" alt="arrow"></span> </span></td>

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
              
              <td class="centerContent" width="100%">
              
              
   <div id=photos>

	

	<div id=menu>
<table width=100%><tr><td  valign=top>

		<div><strong>Display photos by: </strong><br /> 
		
		 <a href=index.php> Last Name</a> 
<br />	<a href=view_recent.php>Recent Entry</a> 
		<br />
		<a href=view_institution.php> Institution</a></div></td><td></td>
		<td valign=top>
		
		<div align=right><a href=add_photo.php><br /><strong>-> Submit Entry</strong></a></div></td>
		
		<td valign=top>
		
		
		
		<div id="search" align="right"> 
          <form method="post" action="search.php">
            <label> Search </label>
            <input type="text" name="searchword" size="20" maxlength="80" value="<?php echo $_POST['searchword']?>" />
       
             <input type="submit" value="go" />
       
          </form>
        </div></td></tr></table>
	</div>
	
	<?php
	
	    require 'resize.php';


require "facebook_db.php";

	
// how many rows to show per page
$rowsPerPage = 10;

// by default we show first page
$pageNum = 1;

// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
    $pageNum = $_GET['page'];
}

// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;

$query  = "SELECT * FROM facebook Order by last LIMIT $offset, $rowsPerPage";
$result = mysql_query($query) or die('Error, query failed');


// print the images

echo"<div id=box>";

		while($links=mysql_fetch_array($result))
		{
		$id=$links["id"]; 
		$first=$links["First"]; 
		$last=$links["Last"]; 
		$institution=$links["Institution"]; 
		$emailadd=$links["email"];
		$filename=$links["pict"];
		$interests=$links["interests"];
		

echo "
<div id=frame>";

		imageResize($filename, "120", "");
		echo "<div id=label style=border: 1px solid #eee;> <br />$first $last<br />$institution<br /><br />$interests<br />
		</div>
		
	
	 </div></div>";


		}
		
		


echo"


</td>
            </tr>";


// how many rows we have in database
$query   = "SELECT COUNT(*) AS numrows FROM facebook";
$result  = mysql_query($query) or die('Error, query failed');
$row     = mysql_fetch_array($result, MYSQL_ASSOC);
$numrows = $row['numrows'];

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
    
    $first = " <a href=\"$self?page=1\">[First Page]</a> ";
}
else
{
    $prev  = ' [Prev] ';       // we're on page one, don't enable 'previous' link
    $first = ' [First Page] '; // nor 'first page' link
}

// print 'next' link only if we're not
// on the last page
if ($pageNum < $maxPage)
{
    $page = $pageNum + 1;
    $next = " <a href=\"$self?page=$page\">[Next]</a> ";
    
    $last = " <a href=\"$self?page=$maxPage\">[Last Page]</a> ";
}
else
{
    $next = ' [Next] ';      // we're on the last page, don't enable 'next' link
    $last = ' [Last Page] '; // nor 'last page' link
}

// print the page navigation link
echo "<div class=nav align=center>$first &nbsp;&nbsp; $prev &nbsp;&nbsp;  page &nbsp;<strong>$pageNum</strong> &nbsp;of &nbsp;<strong>$maxPage</strong>&nbsp; pages &nbsp;&nbsp;  $next &nbsp;&nbsp; $last</div>";

?>
   <tr class="creditsHere">

              <td>&nbsp;</td>
              <td align="center" valign="top"><span class="small">Contact <a href="mailto:sakaiproject_webmaster@umich.edu">--Webmaster</a></span><br>
              </td>
            </tr>
          </tbody>
        </table></td>
    </tr>
</body>
</html>
