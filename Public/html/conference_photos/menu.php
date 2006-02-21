 <?php
$pgImg=" <img src=\"../conferenceJune_05/regindex_files/arrow.png\" height=\"9\" width=\"9\">";
 
 <table width=100%>
            <tr>
              <td  valign=top class="viewmenu"><div><strong>Display photos by: </strong></div>
              <div><ul>
                 <li>
                 <?php if ($page_name=="institution") echo"$pgImg";
                 else {echo" &nbsp;&nbsp;&nbsp;";?>
                 <a href=view_lastname.php> Last Name</a></li>
                <li><?php if ($page_name=="recent") echo"$pgImg";?> &nbsp;&nbsp;&nbsp;<a href=view_recent.php>Recent Entry</a></li>
               <li><?php if ($page_name=="last") echo"$pgImg";?> <a href=view_institution.php>Institution</a></li></ul></div></td>
              <td  valign=top  class="editmenu"><div><strong>Add or Edit Entries </strong></div>
              <div><ul>
                 <li> <a href=add_photo.php> Submit New Entry</a> </li>
               <li>   Edit Your Entry <span class=small> (coming soon)</span></li></ul></div></td>
              
            </tr>
 
          </table>
          ?>
    