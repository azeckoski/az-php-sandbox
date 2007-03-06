<?php


//get page header
 require_once('includes/facebook_headernew.inc');

	    require 'includes/resize.php';


require "includes/mysqlconnect.php";


	
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

	$query  = "SELECT * FROM facebook_vancouver WHERE approved='1' and  MATCH (First, Last, Institution, interests) AGAINST('$text') LIMIT $offset, $rowsPerPage";
$searchresult = mysql_query($query);


// how many rows we have in database that match criteria
$count   = "SELECT COUNT(*) AS numrows FROM facebook_vancouver WHERE approved='1' and  MATCH (First, Last, Institution, interests) AGAINST('$text') LIMIT $offset, $rowsPerPage";
$result  = mysql_query($count) or die('Error, query failed');
$row     = mysql_fetch_array($result, MYSQL_ASSOC);
$numrows = $row['numrows'];


if ($numrows <1) {
echo"<tr><td valign=top><p align=center> Your search for <strong> $text </strong>  did not match any facebook entries.</p></td></tr>
";
	
	}
	if ($numrows > 0) {

// how many pages we have when using paging?
$maxPage = ceil($numrows/$rowsPerPage);

$self = $_SERVER['PHP_SELF'];

// creating 'previous' and 'next' link
// plus 'first page' and 'last page' link

// print 'previous' link only if we're not
// on page one

if ($numrows ==1 ) {
echo"<tr><td valign=top><div id=box align=center>$numrows item matched your search for -<strong> $text </strong>.</div>";

include ('includes/display_images.php');
echo"</td></tr>";

}

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



if ($numrows > 1) {
echo"<tr><td valign=top><div id=box  align=center> $numrows items matched your search for -<strong> $text </strong>.</div>";


include ('includes/display_images.php');
echo"</td></tr>";


}
}

?>
</table>
 
 </td>
  
  
  <?php 
  //get page footer
  require_once('includes/facebook_footernew.inc');
?>