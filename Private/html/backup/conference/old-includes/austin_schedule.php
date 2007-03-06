<?php


	 require "mysqlconnect.php";
	 
	 
	 $order=$_GET['order'];

if ($order=="id_asc"){

 $sql = "SELECT * FROM cfp_vancouver_present_test  where approved='1' or approved= '2' or approved='3'  ORDER BY id asc";
	  	  $reportname='Ordered by session id';
}
if ($order=="id_desc"){

 $sql = "SELECT * FROM cfp_vancouver_present_test  where approved='1'  or approved= '2' or approved='3'  ORDER BY id desc";
	  	  $reportname='Ordered by session id';
}

if ($order=="speaker_asc"){

 $sql = "SELECT * FROM cfp_vancouver_present_test  where approved='1' or approved= '2' or approved='3'  ORDER BY lastname asc";
	  	  $reportname="Ordered by primary speaker's last name";
}
if ($order=="speaker_desc"){

 $sql = "SELECT * FROM cfp_vancouver_present_test  where approved='1' or approved= '2' or approved='3'   ORDER BY lastname desc";
	  	  $reportname="Ordered by primary speaker's last name";
}



if ($order=="title_asc"){

 $sql = "SELECT * FROM cfp_vancouver_present_test  where approved='1'  or approved= '2' or approved='3'  ORDER BY p_title asc";
	  	  $reportname='Ordered by title';
}
if ($order=="title_desc"){

 $sql = "SELECT * FROM cfp_vancouver_present_test  where approved='1' or approved= '2' or approved='3'  ORDER BY p_title desc";
	  	  $reportname='Ordered by title';
}
if ($order==""){

 $sql = "SELECT * FROM cfp_vancouver_present_test  where approved='1' or approved= '2' or approved='3'  ORDER BY session_time asc";
	  	  $reportname='Ordered by date/time';
}
if ($order=="time_asc"){

 $sql = "SELECT * FROM cfp_vancouver_present_test  where approved='1' or approved= '2' or approved='3'  ORDER BY session_time asc";
	  	  $reportname='Ordered by date/time';
}
if ($order=="time_desc"){

 $sql = "SELECT * FROM cfp_vancouver_present_test  where approved='1' or approved= '2' or approved='3'   ORDER BY session_time desc";
	  	  $reportname='Ordered by date/time';
}


$result= mysql_query($sql);
$resultsnumber=mysql_numrows($result);



echo"


	
  <table width=800px  cellpadding=8 cellspacing=0> 

		<tr><td colspan=5 align=Left><br /><strong>Sakai Presentations</strong> ($reportname)</td>
		</tr>


		</tr>

			
<tr class=tableheader>";
?>

<td align=left width=50px><strong>ID</strong><a href="http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=161&Itemid=497&order=id_asc"><img border=0 src="http://www.sakaiproject.org/administrator/images/uparrow.png" height=10 width=10></a><a href="http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=161&Itemid=497&order=id_desc">&nbsp;<img border=0 src="http://www.sakaiproject.org/administrator/images/downarrow.png" height=10 width=10></a></td>
<td align=left width=150px><strong>Title</strong><a href="http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=161&Itemid=497&order=title_asc"><img border=0 src="http://www.sakaiproject.org/administrator/images/uparrow.png" height=10 width=10></a><a href="http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=161&Itemid=497&order=title_desc">&nbsp;<img border=0 src="http://www.sakaiproject.org/administrator/images/downarrow.png" height=10 width=10></a></td>
<td align=left width=150px><strong>Session Abstract</strong> </td>
<td align=left width=100px><strong>Speaker</strong></td>
<td align=left width=100px><strong>Date/Time</strong><a href="http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=161&Itemid=497&order=time_asc"><img border=0 src="http://www.sakaiproject.org/administrator/images/uparrow.png" height=10 width=10></a><a href="http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=161&Itemid=497&order=time_desc">&nbsp;<img border=0 src="http://www.sakaiproject.org/administrator/images/downarrow.png" height=10 width=10></a></td>

</tr>



<?php 

function time_convert($time,$type){
  $time_hour=substr($time,0,2);
  $time_minute=substr($time,3,2);
  $time_seconds=substr($time,6,2);
  if($type == 1):
  	// 12 Hour Format with uppercase AM-PM
  	$time=date("g:i A", mktime($time_hour,$time_minute,$time_seconds));
  elseif($type == 2):
  	// 12 Hour Format with lowercase am-pm
  	$time=date("g:i a", mktime($time_hour,$time_minute,$time_seconds)); 
  elseif($type == 3):
  	// 24 Hour Format
  	$time=date("H:i", mktime($time_hour,$time_minute,$time_seconds)); 
  elseif($type == 4):
  	// Swatch Internet time 000 through 999
  	$time=date("B", mktime($time_hour,$time_minute,$time_seconds)); 
  elseif($type == 5):
  	// 9:30:23 PM
  	$time=date("g:i:s A", mktime($time_hour,$time_minute,$time_seconds));
  elseif($type == 6):
  	// 9:30 PM with timezone, EX: EST, MDT
  	$time=date("g:i A T", mktime($time_hour,$time_minute,$time_seconds));
  elseif($type == 7):
  	// Different to Greenwich(GMT) time in hours
  	$time=date("O", mktime($time_hour,$time_minute,$time_seconds)); 
  endif;
  return $time;
};

 

 



while($links=mysql_fetch_array($result))
{
$row++; 
$id=$links["id"];
$date=$links["date"];
$conf=$links["confID"]; 
$last=$links["lastname"];
$first=$links["firstname"];
$emailadd=$links["email1"];
$p_track=$links["p_track"];
$p_format=$links["p_format"];
$p_title=$links["p_title"];
$p_abstract=$links["p_abstract"];
$p_desc=$links["p_desc"];
$p_URL=$links["p_URL"];
$sp_URL=$links["sp_URL"];
$p_speaker=$links["p_speaker"];
$bio=$links["sp_bio"];
$dev=$links["dev"];
$faculty=$links["faculty"];
$mgr=$links["mgr"];
$sys_admin=$links["sys_admin"];
$sr_admin=$links["sr_admin"];
$ui_dev=$links["ui_dev"];
$approved=$links["approved"];

$support=$links["support"];
$confluence=$links["confluence"];

$talk_day=$links["talk_day"];
$day=$talk_day;

  	// convert from day of week for sorting
  	switch ($day) {
  	
  	case "1":
  	$day_num='Sunday';
  	
  	break;
 	case "2":
  	$day_num='Monday';
  	
  	break;
  	
  	case "3":
  	  	$day_num='Tuesday';

  	break;
    case "4":
  	  	$day_num='Wednesday';

  	break;
  	 case "5":
  	  	$day_num='Thursday';

  	break;
  	 case "6":
  	  	$day_num='Friday';

  	break;
  	
  	 	case "7":
  	$day_num='Saturday';
  	
  	break;
  	
  	}

$talk_start=$links["talk_start"];
$talk_start=time_convert($talk_start, 2);
$talk_start_sort=time_convert($talk_start, 3);

$talk_end=$links["talk_end"];
$talk_end=time_convert($talk_end, 2);
$talk_end_sort=time_convert($talk_start, 3);




$talk_room=$links["talk_room"];




if ($line == 1) {   	
	echo "<tr id=oddrow valign=top>";
   $line='2';

} else {
	echo "<tr id=evenrow  valign=top>";
	$line='1';
}

echo "		<td align=center>$id</td>";
	if ($approved== 1) {
	echo"

	<td><strong><a href=\"$confluence\" title=\"click title to visit related Confluence site\" target=\"_blank\">$p_title</a></strong></td>
<td>$p_abstract</td>
	<td><strong>$p_speaker</strong>";
	} 
	if ($approved== 3) {
	echo"

	<td><strong>BOF: <br />  <a href=\"$confluence\" title=\"click title to visit related Confluence site\" target=\"_blank\">$p_title</a></strong></td>
<td>$p_abstract</td>
	<td><strong>$p_speaker</strong>";
	} 
	if ($approved== 2) {
	echo"

	<td><strong>";
	if (!$p_URL=="") {
	echo"Tool Carousel: <br />
<a href=\"$p_URL\" title=\"click title to visit related project site\" target=\"_blank\">$p_title</a>
"; }
else { echo"Tool Carousel:  <br />$p_title";
}

echo"</strong></td>
<td>$p_abstract</td>
	<td><strong>$p_speaker</strong>";
	}
	
	if ($approved==3) {
	echo"<br />BOF session ";
	
	}
	
	else {
	echo"
	
	<br />
$bio";
}

echo"</td>
	<td valign=top align=left width=200px style=\"whitespace: nowrap;\"><strong>$talk_day<strong><br />
	$talk_start-$talk_end<br />
	Room: $talk_room</td>




</tr>
";

 //end row, so change color   


} //end of while


echo"</table>";



?>