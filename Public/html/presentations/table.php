<?php
require "includes/mysqlconnect.php";



$order=$_GET['order'];

if ($order=="latest_asc"){

 $sql = "SELECT * FROM presentations ORDER BY id asc";
	  	  $reportname='Ordered by most date added';
}
if ($order=="latest_desc"){

 $sql = "SELECT * FROM presentations ORDER BY id desc";
	  	  $reportname='Ordered by most date added';
}

if ($order=="title_asc"){
 $sql = 'SELECT * FROM presentations  ORDER BY title asc';
	  	  $reportname='Ordered by title';
}

if ($order=="title_desc"){
 $sql = 'SELECT * FROM presentations  ORDER BY title desc';
	  	  $reportname='Ordered by title';
}


if ($order=="event_date_asc"){
 $sql = 'SELECT * FROM presentations  ORDER BY event_date asc';
	  	  $reportname='Ordered by event date';
}
if ($order=="event_date_desc"){
 $sql = 'SELECT * FROM presentations  ORDER BY event_date desc';
	  	  $reportname='Ordered by event date';
}
if ($order=="event_asc"){
 $sql = 'SELECT * FROM presentations  ORDER BY event_name asc';
	  	  $reportname='Ordered by event date';
}
if ($order=="event_desc"){
 $sql = 'SELECT * FROM presentations  ORDER BY event_name desc';
	  	  $reportname='Ordered by event date';
}

if ($order=="presenter_asc"){
 $sql = 'SELECT * FROM presentations  ORDER BY Last asc';
	  	  $reportname='Ordered by presenter last name';
}
if ($order=="presenter_desc"){
 $sql = 'SELECT * FROM presentations  ORDER BY Last desc';
	  	  $reportname='Ordered by presenter last name';
}
if ($order==""){
 $sql = 'SELECT * FROM presentations  ORDER BY id desc';
	  	  $reportname='Orderd by most date added';
}


	  	  
  
	 $result= mysql_query($sql);
$resultsnumber=mysql_numrows($result);
$line = "1";
$row="0";


echo"<span id=list></span>

 <table width=90% margin-left=10px id=data cellspacing=2> 
		<tr><td colspan=2 align=Left><p><strong>Sakai Presentations</strong> ($reportname)</td></tr>
<tr><td>";
?>

<!-- 
<form name="presentationReport"  method="get" >
<input type=hidden name=option value=com_content />
<input type=hidden name=task value=view />
<input type=hidden name=id value=309 />
<input type=hidden name=Item value=513 />


            <select name="order" id="order">
                <option value="">-- sort list by: --</option>
                <option value="latest">Recently Added</option>
                <option value="title">Title</option>
                <option value="event_date">Event Date</option>
                <option value="presenter">Presenter's last name</option>
</select>
<input name=submit type=submit value="go"/>

-->


</td>
<tr class=tableheader>

<td align=left width=150px><strong>TITLE <a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=309&Itemid=513&order=title_asc"><img border=0 src="http://www.sakaiproject.org/administrator/images/uparrow.png"></a><a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=309&Itemid=513&order=title_desc">&nbsp;<img border=0 src="http://www.sakaiproject.org/administrator/images/downarrow.png"></a></strong></td>
	
<td width=150px><strong>Description</strong></td>
<td align=left width=150px><strong>Presenter <a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=309&Itemid=513&order=presenter_asc"><img border=0 src="http://www.sakaiproject.org/administrator/images/uparrow.png"></a><a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=309&Itemid=513&order=presenter_desc">&nbsp;<img border=0 src="http://www.sakaiproject.org/administrator/images/downarrow.png"></a></strong></td>
<td align=left width=150px><strong>Event/Location <a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=309&Itemid=513&order=event_asc"><img border=0 src="http://www.sakaiproject.org/administrator/images/uparrow.png"></a><a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=309&Itemid=513&order=event_desc">&nbsp;<img border=0 src="http://www.sakaiproject.org/administrator/images/downarrow.png"></a></strong></td>
<td align=left width=150px><strong>Date <a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=309&Itemid=513&order=event_date_asc"><img border=0 src="http://www.sakaiproject.org/administrator/images/uparrow.png"></a><a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=309&Itemid=513&order=event_date_desc">&nbsp;<img border=0 src="http://www.sakaiproject.org/administrator/images/downarrow.png"></a></strong></td>







</tr>
<?php





while($links=mysql_fetch_array($result))
{
$row++; 
$id=$links["id"];
$first=$links["First"];
$last=$links["Last"];
$email1=$links["email"];
$institution=$links["Institution"];
$p_title=$links["title"];
$p_desc=$links["description"];
$event_name=$links["event_name"];
$event_date=$links["event_date"];
$filename=$links["filename"];
$date=$links["date"];




if ($line == 1) {   	
	echo "<tr id=oddrow valign=top>";
   $line='2';

} else {
	echo "<tr id=evenrow valign=top>";
	$line='1';
}
	
echo "<td><a href=\"http://www.sakaiproject.org/presentations/downloads/$filename\">$p_title</a></td>";

			echo"	<td>$p_desc</td>";

		echo"	<td>$first $last<br />$institution</td>";


		echo"	<td>$event_name</td><td>$event_date</td>";


echo "</tr>";

 //end row, so change color   


} //end of while


echo"</table><br /><br />";

?>
