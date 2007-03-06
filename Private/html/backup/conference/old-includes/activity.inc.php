<?php

//activity details for recent proposals submitted


?>
<table cellpadding="0" cellspacing="0" class="moduletable">
<tr>
					<th valign="top">
					 Proposal Activity			</th>
				</tr>
								       <tr><td><strong>Proposal Activity for:</strong><br /><?php $first=$_SESSION['firstname']; $last=$_SESSION['lastname'] ;  $num_pres=$_SESSION['num_pres'];
                                    
                                 echo " $first $last<br /><br /><strong>Presentations: </strong>$num_pres"; ?><br /><br />
                                    
                                    
                                    </td>
                                    </tr><tr><td><?php $num_demo=$_SESSION['num_demo'];
                                    
                                 echo "<br /><strong>Demos: </strong>$num_demo"; ?><br /><br />
                                    
                                    
                                    </td>
                                    </tr>
						</table>
						
						