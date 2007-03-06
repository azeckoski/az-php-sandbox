
<?php
$today = date("F j, Y"); 
echo"<table width=100%>";

			echo"
                  <tr><td   colspan=2><strong>CONFIRMATION</strong>: <br /> Thank you for registering for the Sakai Vancouver conference.  
                     You will receive a confirmation email shortly.  See you in Vancouver! <br /><br />-- Sakai Conference Committee</td></tr>
 ";
 
/*
echo"<tr><td width=200px valign=top><div align=\"right\"><strong><span>DateSubmitted</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong></div></td>
			<td>$today</td></tr>";
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Conference Attendee's Name</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			<td width=300px valign=top>$firstname $lastname</td></tr>";
					if ($co_registrant) {
		echo"<tr><td><div align=\"right\"><strong><span>Registered by</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			<td width=300px>$co_registrant</td></tr>";
	}
						if ($payeeInfo) {
	echo"<tr><td valign=top><div align=\"right\"><strong><span>Paid by</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			<td width=300px>$payee<br />$payeeEmail<br />$payeePhone</td></tr>";
	}
	
			if ($badge) {
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Badge Name</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			<td>$badge </td></tr>";
			
			}

			
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Email</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$email</td></tr>";
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Role</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$title</td></tr>";
			
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Organization</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
			<td>$institution<br></td></tr>";



			
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Address</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
			<td>";
			
			
			
			echo"$address1<br />
			
			$city, $state, $zip<br/>
					$country</td>
					</tr>";
					

		echo"<tr><td><div align=\"right\"><strong><span>Phone</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$phone</td></tr>";
			echo"<tr><td><div align=\"right\"><strong><span>Fax</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$fax</td></tr>";
		
		
		echo"<tr><td><div align=\"right\"><strong><span>TShirt size</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$shirt</td></tr>";
		
			echo"<tr><td><div align=\"right\"><strong><span>Special Needs</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$special</td></tr>";
		 

		if ($hotelInfo=='Y') {
			echo"<tr><td><div align=\"right\"><strong><span>Staying at Conf. Hotel</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>Yes</td></tr>";
		} else  {
			echo"<tr><td><div align=\"right\"><strong><span>Staying at Conf. Hotel</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td> No</td></tr>";
	} 
	if ($jasig=='Y')  {
			echo"<tr><td><div align=\"right\"><strong><span>Attending JA-SIG</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>Yes</td></tr>";
	}	else   {
			echo"<tr><td><div align=\"right\"><strong><span>Attending JA-SIG</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td> No</td></tr>";
			}
			
		if ($contactInfo=='Y')  {
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Publish name on Attendee list</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>Yes</td></tr>";
	}	else  {
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Publish name on Attendee list</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>No<br /><br /><br /><br /><br /></td></tr>";
		}
		
	*/
		?></table>