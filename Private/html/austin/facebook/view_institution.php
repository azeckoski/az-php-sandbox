<?php

//*****************************************//

//Sakai Facebook Version 2 Austin
//September 2005

//shardin@umich.edu
//
//VIEW BY INSTITUTION
//*****************************************//

//get page header

 require_once('includes/facebook_headernew.inc');
?>
       <td colspan="2" valign=top style=" border-top: 4px solid #FFFFFF; padding: 5px;">


                  <table width="650px"  class="blog" cellpadding="0" cellspacing="0">
                      
                      <tr>
                      <td valign="top" align=center>
       
                      <div class="componentheading">Sakai - Austin Conference Facebook</div>
                      </td></tr>
                      
                  
  
    
          <?php
        
        
      //set up the number of pictures per page
	
		include ('includes/get_offset.php');

	//query database for all austin images and data
$query  = "SELECT * FROM facebook_austin order by Institution LIMIT $offset, $rowsPerPage";
$searchresult = mysql_query($query);


// display content 

include ('includes/main_content.php');
?>
</table>
 
 </td>
  
  
  <?php 
  //get page footer
  require_once('includes/facebook_footernew.inc');
?>