<?php

//*****************************************//

//Sakai Facebook Version 3 Elections
//October 2005

//shardin@umich.edu
//

//*****************************************//


//get page header
 require_once('includes/election_header.inc');
?>
        
          <!--  image content begins -->

        <td width=640px>
           
           <table  class="centerContent" valign=top width="95%">
           
            <tr><td><table><tr><td align=center><strong>Order: by Institution</strong>
           </td></tr>
           
          <?php
        
        
      //set up the number of pictures per page
	
		include ('includes/get_offset.php');

	//query database for all austin images and data
	$query  = "SELECT * FROM elections order by Institution DESC LIMIT $offset, $rowsPerPage";
	$searchresult = mysql_query($query);


// display content 
include ('includes/main_content.php');
?>  <!--  image content ends -->
        </table>
  </td>
  </tr>
     <!-- Menus and Main Content - Row Ends and Footer begins -->


  <?php 
  //get page footer
  require_once('includes/footer.inc');
?>