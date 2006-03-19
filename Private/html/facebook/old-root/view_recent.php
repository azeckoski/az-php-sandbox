<?php

 require_once('includes/facebook_headernew.inc');

      //set up the number of pictures per page
	
		include ('includes/get_offset.php');

	//query database for all vancouver images and data
	$query  = "SELECT * FROM facebook_vancouver WHERE approved ='1' order by id DESC LIMIT $offset, $rowsPerPage";
$searchresult = mysql_query($query);


// display content 

include ('includes/main_content.php');

  //get page footer
  require_once('includes/facebook_footernew.inc');
?>