
<?php
$today = date("F j, Y"); 
echo"<table width=100%><tr>
<td colspan=2>You have successfully submitted your proposal information.   
You will receive an email confirming
your proposal submission(s) shortly.   We look forward to seeing you in
Vancouver!  <br />Thanks for being a part of Sakai!<br /><br /></td><tr>";


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
		
		
		echo"<tr><td valign=top><div align=\"right\" ><strong><span>Presentation Proposals Submitted</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
		<td>$_SESSION[num_pres]<br />";
	
		
		echo"</td></tr>";
		
			echo"<tr><td valign=top><div align=\"right\"><strong><span>Demo Proposals Submitted</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
			<td> $_SESSION[num_demo]<br />";
			

			echo"<br /><br /><br /></td></tr></table>";
		
		 

			
	
		?>