<?php

//*****************************************//

//Sakai Facebook Version 2 Austin
//September 2005

//shardin@umich.edu
//
//get_offset.php
//*****************************************//



	
// how many rows to show per page
$rowsPerPage = 15;

// by default we show first page
$pageNum = 1;

// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
    $pageNum = $_GET['page'];
}

// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;


require ('includes/mysqlconnect.php');



?>