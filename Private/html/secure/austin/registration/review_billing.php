<?php

//echo $_SESSION['USER1'];
  
$today = date("F j, Y"); 
echo"<table width=450px>";
			//echo"<tr><td colspan=2>This is your registration confirmation (pending credit card approval).  A copy of this information has also been sent to o you at <strong>$email</strong><br /><br /></td></tr>";
			echo"<tr><td colspan=2>Please verify that the following information is correct.  Then click  on <strong>Submit</strong> to complete the registration process.  An email confirmation will be sent to the email address you provided. <br /><br /><br /></td></tr>";
			
			
			
			echo"<tr><td width=200px><div align=\"right\"><strong><span>DateSubmitted</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong></div></td>
			<td>$today</td></tr>";
			echo"<tr><td><div align=\"right\"><strong><span>Attendee</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			<td width=300px>$firstname $lastname</td></tr>";


			 echo"<tr><td><div align=\"right\"><strong><span>Registration Fee</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			 <td width=300p>$ $fee</td></tr>";
		
		//	 echo"<tr><td><div align=\"right\"><strong><span>Order ID</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			// <td width=300p>$transID</td></tr>";
			
			echo"<tr><td><div align=\"right\"><strong><span>Badge Name</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			<td>$badge </td></tr>";

			
			echo"<tr><td><div align=\"right\"><strong><span>Email</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$email</td></tr>";
			echo"<tr><td><div align=\"right\"><strong><span>Role</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$title</td></tr>";
			
			echo"<tr><td><div align=\"right\"><strong><span>Organization</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
			<td>$otherInst<br></td></tr>";

			

		    echo"<tr><td><div align=\"right\"><strong><span>Department</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$dept<br></td></tr>";

			
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Address</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
			<td>";
			
			
			
			echo"$address1<br />";
		
			echo"$address2<br />";
			
			echo"$city, $state, $zip<br/>
					$country</td>
					</tr>";
					

		echo"<tr><td><div align=\"right\"><strong><span>Phone</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$phone</td></tr>";
			echo"<tr><td><div align=\"right\"><strong><span>Fax</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$fax</td></tr>";
		
		
		echo"<tr><td><div align=\"right\"><strong><span>TShirt size</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$shirt</td></tr>";
		
			echo"<tr><td><div align=\"right\"><strong><span>Special Needs</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td>$spec</td></tr>";
		 

			
			echo"<tr><td><div align=\"right\"><strong><span>Staying at Conf. Hotel</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td> $hotel</td></tr>";
		
			echo"<tr><td><div align=\"right\"><strong><span>Attending JA-SIG</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td> $jasig</td></tr>";

		
			
			echo"<tr><td valign=top width=250px><div align=\"right\"><strong><span>Publish name on Attendee list</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
			<td>$contact</td></tr>";
		echo"<tr><td valign=top><div align=\"right\"><br /><br /><strong><span>Billing Information</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td><td valign=top> <br /><br />$transID</td></tr>";
echo"</table>";