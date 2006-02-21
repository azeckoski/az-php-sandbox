
<?php



$num_demo="1";
$title[]=' one';
$num_demo++;

$title[]='two';
$num_demo++;
$title[]='three';
$num_demo++;
$title[]='four';
$num_demo++;
$title[]='five';
$num_demo++;


foreach ($title as $number => $title){
						echo "title is: $title<br />";

			}
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
		
		
		echo"<tr><td><div align=\"right\"><strong><span>Presentation Proposals Submitted</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
		<td>$_SESSION[num_pres]<br />";
	
		
		echo"</td></tr>";
		
			echo"<tr><td><div align=\"right\"><strong><span># of Demo Proposals Submitted</span>: &nbsp;&nbsp;&nbsp;</strong> </div></td>
			<td> $_SESSION[num_demo]<br />";
			
			$test=array(1=> 'Test1', 'Test2', 'Test3', 'Test4');
		
		foreach ($test as  $number => $test){
			echo "$number: $test<br />";
			}
			
			
		echo"</td></tr></table>";
		
		 

			
	
		?>