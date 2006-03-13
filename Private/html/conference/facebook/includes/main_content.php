<?php 

//displays the photos section of the facebook

// how many rows we have in database
$count   = "SELECT COUNT(*) AS numrows FROM facebook_vancouver";

$result  = mysql_query($count) or die('Error, query failed');
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









//resizes image for thumnail - does not create separate thumbnail
 require 'includes/resize.php';  
 

echo "<div id=nav align=center><strong>Facebook entries:  </strong>$numrows<br />
$firstp &nbsp;&nbsp; $prev &nbsp;&nbsp;  page &nbsp;<strong>$pageNum</strong> &nbsp;of &nbsp;<strong>$maxPage</strong>&nbsp; pages &nbsp;&nbsp;  $next &nbsp;&nbsp; $lastp<br /><br /></div>";
include ('includes/display_images.php');


// print the page navigation link

echo"<div id=nav align=center>
$firstp &nbsp;&nbsp; $prev &nbsp;&nbsp;  page &nbsp;<strong>$pageNum</strong> &nbsp;of &nbsp;<strong>$maxPage</strong>&nbsp; pages &nbsp;&nbsp;  $next &nbsp;&nbsp; $lastp<br /><br /></div>";?>