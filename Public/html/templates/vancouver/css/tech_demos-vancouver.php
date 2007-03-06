<?php 	 require "http://www.sakaiproject.org/austin/includes/mysqlconnect.php";

		$sql="Select * from cfp_vancouver_demo order by product";
			$reportName="<strong>Technical Demonstrations</strong>";
			
$result= mysql_query($sql);
$resultsnumber=mysql_numrows($result);


echo" <table cellspacing=5 cellpadding=8 width=100%> 
<tr class=tableheader>
<td><strong>Technical Demos scheduled for Thursday, December 8th</strong></td>

</tr>
";





while($links=mysql_fetch_array($result))
{
$row++; 
$id=$links["id"];
$date=$links["date"];

$conf=$links["confID"]; 
$last=$links["lastname"];
$first=$links["firstname"];
$emailadd=$links["email1"];
$title=$links['product'];
$demo_desc=$links["demo_desc"];
$demo_speaker=$links["demo_speaker"];

$demo_url=$links["demo_url"];



if ($line == 1) {   	
	echo "<tr id=oddrow valign=top>";
   $line='2';

} else {
	echo "<tr id=evenrow valign=top>";
	$line='1';
}
	echo"

<td width=200px>";
if ($demo_url)
echo"<a href=\"$demo_url\"><img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 width=9px height=9px></a>&nbsp; &nbsp;";
echo"<strong>$title</strong><br /></td>

</tr>
";

 //end row, so change color   


} //end of while


echo"</table>";
?>
