
<?php
$today = date("F j, Y"); 
echo"<table width=100%>";
			echo"<tr><td width=200px><div align=\"right\"><strong><span>DateSubmitted</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong></div></td>
			<td>$today</td></tr>";
			echo"<tr><td><div align=\"right\"><strong><span>Attendee</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			<td width=300px>$_SESSION[firstname] $_SESSION[lastname]</td></tr>";
			
			if ($_SESSION['badge'])
			echo"<tr><td><div align=\"right\"><strong><span>Badge Name</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			<td>$_SESSION[badge] </td></tr>";

			
			echo"<tr><td><div align=\"right\"><strong><span>Email</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$_SESSION[email1]</td></tr>";
			echo"<tr><td><div align=\"right\"><strong><span>Role</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$_SESSION[title]</td></tr>";
			
			if ($_SESSION['institution']=="")
			echo"<tr><td><div align=\"right\"><strong><span>Organization</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
			<td>$_SESSION[otherInst]<br></td></tr>";

			else
			echo"<tr><td><div align=\"right\"><strong><span>Organization</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$_SESSION[institution]<br></td></tr>";

		    echo"<tr><td><div align=\"right\"><strong><span>Department</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$_SESSION[dept]<br></td></tr>";

			
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Address</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
			<td>";
			
			
			
			echo"$_SESSION[address1]<br />";
		
			if ($_SESSION['address2'])
			echo"$_SESSION[address2]<br />";
			
			echo"$_SESSION[city], $_SESSION[state], $_SESSION[zip]<br/>
					$_SESSION[country]</td>
					</tr>";
					

		echo"<tr><td><div align=\"right\"><strong><span>Phone</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$_SESSION[phone]</td></tr>";
			echo"<tr><td><div align=\"right\"><strong><span>Fax</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$_SESSION[fax]</td></tr>";
		
		
		echo"<tr><td><div align=\"right\"><strong><span>TShirt size</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$_SESSION[shirt]</td></tr>";
		
			echo"<tr><td><div align=\"right\"><strong><span>Special Needs</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$_SESSION[special]</td></tr>";
		 

		if ($_SESSION['hotelInfo']=='Y') {
			echo"<tr><td><div align=\"right\"><strong><span>Staying at Conf. Hotel</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>Yes</td></tr>";
		} else  {
			echo"<tr><td><div align=\"right\"><strong><span>Staying at Conf. Hotel</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td> No</td></tr>";
	} 
	if ($_SESSION['jasig']=='Y')  {
			echo"<tr><td><div align=\"right\"><strong><span>Attending JA-SIG</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>Yes</td></tr>";
	}	else   {
			echo"<tr><td><div align=\"right\"><strong><span>Attending JA-SIG</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td> No</td></tr>";
			}
			
		if ($_SESSION['contactInfo']=='Y')  {
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Publish name on Attendee list</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>Yes</td></tr></table>";
	}	else  {
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Publish name on Attendee list</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>No<br /><br /><br /><br /><br /></td></tr></table>";
		}
		
	
		?>