<?php
require "../includes/mysqlconnectWeb.php";


	  $sql = 'SELECT * FROM contest where approved like "yes" ORDER BY id DESC';
	  	  $reportname='All Entries';
 
	  
	 $result= mysql_query($sql);
$resultsnumber=mysql_numrows($result);
$line = "1";
$row="0";


echo"<span id=list></span>

 <table width=80% margin-left=10px id=data cellspacing=2> 
		<tr><td colspan=2 align=Left><p><strong>Sakai Austin Conference Logo Contest Entries</strong></p></td>
		<td colspan=1 align=left class=report>&nbsp;</td></tr>

<tr class=tableheader>

	<td align=center><strong>imagefile</strong></td>
		<td><strong>Theme suggestion</strong></td>

		<td><strong>Submitted by:</strong></td>



</tr>
";





while($links=mysql_fetch_array($result))
{
$row++; 
$id=$links["id"];
$name=$links["name"];
$email1=$links["email1"];
$idea=$links["idea"];
$file=$links["file"];
$approved=$links["approved"];



if ($line == 1) {   	
	echo "<tr id=oddrow valign=top>";
   $line='2';

} else {
	echo "<tr id=evenrow valign=top>";
	$line='1';
}
	
	if ($file == 'none') {  
	echo "<td>n/a</td>";
	}
	else {
	
	echo "<td><a href=\"../$file\"><img src=\"../$file\" height=50px width=50px></a></td>";
	}
	
		echo"	<td>$idea</td>";

	echo"	<td><span class=small style=\"color:#333;\"> $name</span></td>";

echo "</tr>";

 //end row, so change color   


} //end of while


echo"</table><br /><br />";

?>
