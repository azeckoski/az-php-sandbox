<?php

	$text = $_POST['searchword'];
$text = trim( $text );
	

	

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

	$query  = "SELECT * FROM facebook_vancouver WHERE MATCH (First, Last, Institution, interests) AGAINST('$text') LIMIT $offset, $rowsPerPage";
$searchresult = mysql_query($query);

// how many rows we have in database that match criteria
$count   = "SELECT COUNT(*) AS numrows FROM facebook_vancouver WHERE MATCH (First, Last, Institution, interests) AGAINST('$text') LIMIT $offset, $rowsPerPage";
$result  = mysql_query($count) or die('Error, query failed');
$row     = mysql_fetch_array($result, MYSQL_ASSOC);
$numrows = $row['numrows'];



?>