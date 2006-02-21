<?php

$result= mysql_query($sql);
$resultsnumber=mysql_numrows($result);



echo"
</tr>";
	
	
echo"


<tr class=tableheader>";
?>

<td align=left width=50px><strong>ID</strong></td>
<td align=left width=150px><strong>Title</strong></td>
<!--<td align=left width=150px><strong>Session Abstract</strong> </td>
-->
<td align=left width=100px><strong>Speaker</strong></td>

<td align=left width=100px><strong>Date/Time</strong></td>

</tr>";
<?php

function format_datetime($string, $type)
{
  $year = substr($string, 0, 4);
  $month = substr($string, 5, 2);
  $day = substr($string, 8, 2);
  $hour = substr($string, 11, 2);
  $minute = substr($string, 14, 2);
  $second = substr($string, 17, 2);


  return date('g:i a', mktime($hour, $minute, $second, $month, $day, $year));
} 
 
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
$p_speaker=$links["p_speaker"];
$p_desc=$links["p_desc"];
$p_URL=$links["p_URL"];
$sp_URL=$links["sp_URL"];
$bio=$links["sp_bio"];
$dev=$links["dev"];
$faculty=$links["faculty"];
$mgr=$links["mgr"];
$sys_admin=$links["sys_admin"];
$sr_admin=$links["sr_admin"];
$ui_dev=$links["ui_dev"];

$support=$links["support"];
$convener=$links["convener"];

$startinfo=$links["session_time"];
$endinfo=$links["session_endtime"];
$explode = explode(" ", $timeinfo);

$date = $explode[0];

$my_time = $explode[1]; 



$talk_day=$links["talk_day"];
$talk_start=$links["talk_start"];
$talk_end=$links["talk_end"];


$talk_room=$links["talk_room"];


$talk_start=$links["talk_start"];
$talk_start=time_convert($talk_start, 2);
$talk_start_sort=time_convert($talk_start, 3);

$talk_end=$links["talk_end"];
$talk_end=time_convert($talk_end, 2);
$talk_end_sort=time_convert($talk_start, 3);



switch($p_track) {
case 'T1':
$p_track='Management & Campus Implementation';
break;
case 'T2':
$p_track='Research & Collaboration';
break;
case 'T3':
$p_track='Sakai Foundation, Community Source & Governance ';
break;
case 'T4':
$p_track='Teaching, Learning & Assessment';
break;

case 'T5':
$p_track='Technology';
break;

}




if ($line == 1) {   	
	echo "<tr id=oddrow valign=top>";
   $line='2';

} else {
	echo "<tr id=evenrow  valign=top>";
	$line='1';
}
	echo"
		<td align=center>$id</td>

	<td><strong>$p_title</strong></td>
";
//echo "<td>$p_abstract</td>":
echo"
	<td><strong>$p_speaker</strong><br />
";

//echo"$bio</td>":
echo"
	<td valign=top align=left width=200px style=\"whitespace: nowrap;\"><strong>$talk_day</strong><br />
	$talk_start-$talk_end<br />
	Room: $talk_room</td>



</tr>
";

 //end row, so change color   


} //end of while


echo"</table>";



?>