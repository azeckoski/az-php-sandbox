<?php

//*****************************************//

//Sakai Facebook Version 2 Austin
//September 2005

//shardin@umich.edu
//
//search.php   searches the database for matching entries
//*****************************************//


//get page header
 require_once('includes/election_header.inc');
?>
 
   
          <!--  image content begins -->

           <td><table  class="centerContent" valign=top width="100%">
           <tr><td width=100%><table width=100%><tr><td width=100% align=center><strong>Search Results</strong></td></tr>
           
                     
                     
                
                  
        <?php
	
	    require ('includes/resize.php');


require ('includes/mysqlconnect.php');
include('includes/get_offset.php');

	
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

	$query  = "SELECT * FROM elections WHERE MATCH (First, Last, Institution, bio, platform) AGAINST('$text') Limit 0, 40";
$searchresult = mysql_query($query) or die('Your Error, query failed');


// how many rows we have in database that match criteria
$count   = "SELECT COUNT(*) AS numrows FROM elections  WHERE MATCH  (First, Last, Institution, bio, platform) AGAINST('$text') Limit 0, 40";
$result  = mysql_query($count) or die('Error, query failed');
$row     = mysql_fetch_array($result, MYSQL_ASSOC);
$numrows = $row['numrows'];


if ($numrows <1) {
echo"<tr><td><div id=box style=\"height:300px; width:100%;\"><p align=center> Your search for <strong> $text </strong>  did not produce any results.</p></div>
</td></tr>";
	
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
echo"<tr><td><div id=box><p align=center>$numrows item matched your search for -<strong>
$text </strong>.</p>";

include ('includes/display_images.php');
echo" </td></tr>";
}

if ($numrows > 1) {
echo"<tr><td><div id=box><p align=center> $numrows items matched your search for -<strong>
$text </strong>.</p>";


include ('includes/display_images.php');

echo" </td></tr>";

}
}

?>  <!--  image content ends -->
        </table>
  </td>
  </tr>
     <!-- Menus and Main Content - Row Ends and Footer begins -->


  <?php 
  //get page footer
  require_once('includes/footer.inc');
?>