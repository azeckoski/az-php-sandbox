<?php

$result= mysql_query($sql);
$resultsnumber=mysql_numrows($result);



        $T1percent =$T1_resultsnumber / $totalEntry *100; 
        $T1P = sprintf('%.1f', $T1percent);
        
        $T2percent =$T2_resultsnumber / $totalEntry *100; 
                $T2P = sprintf('%.1f', $T2percent);

        $T3percent =$T3_resultsnumber / $totalEntry *100; 
                $T3P = sprintf('%.1f', $T3percent);

        $T4percent =$T4_resultsnumber / $totalEntry *100; 
                $T4P = sprintf('%.1f', $T4percent);

        $T5percent =$T5_resultsnumber / $totalEntry *100; 
                $T5P = sprintf('%.1f', $T5percent);
                $TP_total=$T1P + $T2P + $T3P + $T4P + $T5P;

        $discuss_percent =$discuss_resultsnumber / $totalEntry *100; 
                        $discussP = sprintf('%.1f', $discuss_percent);

        $panel_percent  =$panel_resultsnumber / $totalEntry *100; 
                                $panelP = sprintf('%.1f', $panel_percent);
                                
		$lecture_percent  =$lecture_resultsnumber / $totalEntry *100; 
                                $lectureP = sprintf('%.1f', $lecture_percent);

        $showcase_percent  =$showcase_resultsnumber / $totalEntry *100; 
                                $showcaseP = sprintf('%.1f', $showcase_percent);

        $workshop_percent  =$workshop_resultsnumber / $totalEntry *100; 
                                $workshopP = sprintf('%.1f', $workshop_percent);
		$Format_P= $lectureP + $panelP + $showcaseP + $workshopP + $discussP;

echo"
	<td valign=top style=\"padding-left:20px;\">
		
<table class=legend cellpadding=0 cellspacing=0 width=300px>
  
  <tr><td  class=tableheader><strong>Track</strong></td><td  class=tableheader><strong>qty</strong></td><td class=tableheader><strong>%</strong></td></tr>
  <tr><td class=cat> Management & Campus Implementation</td>
  <td class=who>$T1_resultsnumber</td>
  <td class=cat align=right>$T1P%</td></tr>
  
  <tr><td class=cat>Research & Collaboration</td>
  <td class=who>$T2_resultsnumber</td>
  <td class=cat align=right>$T2P%</td></tr>
  
  <tr><td class=cat>Sakai Foundation Comm. Source & Governance</td>
  <td class=who>$T3_resultsnumber</td>
  <td class=cat align=right>$T3P%</td></tr> 
  
  <tr><td class=cat>Teaching, Learning  Assessment</td>
  <td class=who>$T4_resultsnumber</td>
  <td class=cat align=right>$T4P%</td></tr> 
  
  <tr><td class=cat>Technology</td>
  <td class=who>$T5_resultsnumber</td>
  <td class=cat align=right>$T5P%</td></tr> 
  
  <tr><td class=cat align=right><strong>TOTAL</strong></td>
  <td class=who><strong>$resultsnumber</strong></td>
  <td class=cat align=right></td></tr> 
  </table>
  
	</td> 
	
	<td valign=top>
		
  <table class=legend cellpadding=0 cellspacing=0 width=160px>
  
  <tr><td  class=tableheader><strong>Format</strong></td>  <td  class=tableheader><strong>qty</strong></td>  <td class=tableheader><strong>%</strong></td></tr>
  <tr><td class=cat> Discussion</td><td class=who>$discuss_resultsnumber</td><td class=cat align=right>$discussP%</td></tr>
  <tr><td class=cat>Lecture</td> <td class=who>$lecture_resultsnumber</td> <td class=cat align=right>$lectureP%</td></tr>
  <tr><td class=cat>Workshop</td><td class=who>$workshop_resultsnumber</td><td class=cat align=right>$workshopP%</td></tr> 
  <tr><td class=cat>Panel</td><td class=who>$panel_resultsnumber</td><td class=cat align=right>$panelP%</td></tr> 
  <tr><td class=cat>Showcase</td><td class=who>$showcase_resultsnumber</td><td class=cat align=right>$showcaseP%</td></tr> 
  <tr><td class=cat align=right><strong>TOTAL</strong></td><td class=who><strong>$resultsnumber</strong></td><td class=cat></td></tr> 
  </table>
  
  
  
	</td></tr>
	
	

	</table>
<table class=main>
<tr>		
	<td border=0 valign=top><br /><br /><strong>AUSTIN -CALL FOR PROPOSALS<br /> </strong> <br /> $reportName</td>
</tr>
</table>
	
 <table cellspacing=0 cellpadding=0 class=main> 
 <tr class=tableheader>
	<td></td>
<td></td>
<td></td>



<td colspan=4 align=center style=\"border-left: 1px solid #ffcc33;\">---- please check with Mary Miles before making changes to this schedule  -----</td>

<td></td>

</tr>
<tr class=tableheader>
	<td>#</td>
<td>Title/Speaker</td>";
if ($type=="approved_full"){

echo "<td>Track/Format</td>";
} 

if (!$type=="BOF"){

echo "<td>Track/Format</td>";
}
echo"
<td>Description</td>
";

if (!$type=="BOF"){

echo"<td align=center>
<a href=\"http://sakaiproject.org/cgi-data/reports/reports.php?type=conveners\">CONVENERS</td>
";
}
echo"<td align=center>Day</td>
<td align=center>Time</td>
<td align=center>Room</td>
<td></td>

</tr>


";




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
$bio=$links["sp_bio"];
$dev=$links["dev"];
$faculty=$links["faculty"];
$mgr=$links["mgr"];
$sys_admin=$links["sys_admin"];
$sr_admin=$links["sr_admin"];
$ui_dev=$links["ui_dev"];

$support=$links["support"];
$convener=$links["convener"];
$confluence=$links["confluence"];

$startinfo=$links["session_time"];
$endinfo=$links["session_endtime"];
$explode = explode(" ", $timeinfo);

$date = $explode[0];

$my_time = $explode[1]; 



$talk_day=$links["talk_day"];
$talk_start=$links["talk_start"];
$talk_end=$links["talk_end"];


$talk_room=$links["talk_room"];



$starttime=format_datetime($startinfo, datetime);
$endtime=format_datetime($endinfo, datetime);


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
	echo "<tr id=evenrow valign=top>";
	$line='1';
}
	echo"
	<td class=line_no style=\"color: #333;\">$id</td>
<td ><strong><a href=\"$confluence\">$p_title</a></strong><br /><br /><a href=\"mailto:"; echo $emailadd; 
echo "\">$first $last</a><br /><br />
</td>";

if ($type=="approved_full"){

echo"<td><strong>Track: </strong>$p_track<br /><br />

<strong>Format:</strong>$p_format<br /><br /></td>";} 
if (!$type=="BOF"){

echo"<td><strong>Track: </strong>$p_track<br /><br />

<strong>Format:</strong>$p_format<br /><br /></td>";

}
echo"
<td width=40%>$p_abstract<br /><br /></td>";


if (!$type=="BOF"){



echo"<td style=\"border-right: 1px solid #ffcc33; \">&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if ($convener=="") {

echo "<td><br /><strong><span style=\"text-align: center; color:#ffcc00;\">open</span></strong><br /></td>";
	} 
	else {

echo"
<td align=left valign=top ><br /><strong>$convener</strong></td>";
}
}
?>



<!-- 	<form   name="austin_sessions"  method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
 -->
 
 <?php


echo "<td align=left valign=top style=\"border-left: 1px solid #ffcc33; padding-left: 10px;\"><br /><strong>$talk_day</strong><br /><br />";
	
	?>
 <!--           <select style="font-size: 9px; padding: 0px margin:0px" name="day" id="day">
                <option value="<?php echo $talk_day; ?>" selected>- day -</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday </option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
               	  
        </select>
        
        <br />
	-->		  
	  
	  <?php 
	  
	  
	  
   echo "</td>  <td align=left width=160px valign=top><br /><strong>$starttime-$endtime</strong><br /><br />";
	
	?>
	
	
  <!--          <select style="font-size: 9px; padding: 0px margin:0px" name="start" >
                <option value="<?php echo $talk_start; ?>" selected> start</option>
				<option value="7:00">7:00am</option>
				<option value="7:15">7:15am</option>
				<option value="7:30">7:30am</option>
				<option value="7:45">7:45am</option>
				<option value="8:00">8:00am</option>
				<option value="8:15">8:15am</option>
				<option value="8:30">8:30am</option>
				<option value="8:45">8:45am</option>
				<option value="9:00">9:00am</option>
				<option value="9:15">9:15am</option>
				<option value="9:30">9:30am</option>
				<option value="9:45">9:45am</option>
				<option value="10:00">10:00am</option>
				<option value="10:15">10:15am</option>
				<option value="10:30">10:30am</option>
				<option value="10:45">10:45am</option>
				<option value="11:00">11:00am</option>
				<option value="11:15">11:15am</option>
				<option value="11:30">11:30am</option>
				<option value="11:45">11:45am</option>
				<option value="12:00">12:00pm</option>
				<option value="12:15">12:15am</option>
				<option value="12:30">12:30pm</option>
				<option value="12:45">12:45pm</option>
				<option value="13:00a">1:00pm</option>
				<option value="13:15">1:15pm</option>
				<option value="13:30">1:30pm</option>
				<option value="13:45">1:45pm</option>
				<option value="14:00">2:00pm</option>
				<option value="14:15">2:15pm</option>
				<option value="14:30">2:30pm</option>
				<option value="14:45">2:45pm</option>
				<option value="15:00">3:00pm</option>
				<option value="15:15">3:15pm</option>
				<option value="15:30">3:30pm</option>
				<option value="15:45">3:45pm</option>
				<option value="16:00">4:00pm</option>
				<option value="16:15">4:15pm</option>
				<option value="16:30">4:30pm</option>
				<option value="16:45">4:45pm</option>
				<option value="17:00">5:00pm</option>
				<option value="17:15">5:15pm</option>
				<option value="17:30">5:30pm</option>
				<option value="17:45">5:45pm</option>
				<option value="18:00">6:00pm</option>
				<option value="18:15">6:15pm</option>
				<option value="18:30">6:30pm</option>
				<option value="18:45">6:45pm</option>
				<option value="19:00">7:00pm</option>
				<option value="19:15">7:15pm</option>
				<option value="19:30">7:30pm</option>
				<option value="19:45">7:45pm</option>
				<option value="20:00">8:00pm</option>
				<option value="20:15">8:15pm</option>
				<option value="20:30">8:30pm</option>
				<option value="20:45">8:45pm</option>
				<option value="21:00">9:00pm</option>
				<option value="21:15">9:15pm</option>
				<option value="21:30">9:30pm</option>
				<option value="21:45">9:45pm</option>
				
               	  
        </select>  
            <select style="font-size: 9px; padding: 0px margin:0px" name="end" >
                <option value="<?php echo $talk_end; ?>" selected>end</option>
				<option value="7:00">7:00am</option>
				<option value="7:15">7:15am</option>
				<option value="7:30">7:30am</option>
				<option value="7:45">7:45am</option>
				<option value="8:00">8:00am</option>
				<option value="8:15">8:15am</option>
				<option value="8:30">8:30am</option>
				<option value="8:45">8:45am</option>
				<option value="9:00">9:00am</option>
				<option value="9:15">9:15am</option>
				<option value="9:30">9:30am</option>
				<option value="9:45">9:45am</option>
				<option value="10:00">10:00am</option>
				<option value="10:15">10:15am</option>
				<option value="10:30">10:30am</option>
				<option value="10:45">10:45am</option>
				<option value="11:00">11:00am</option>
				<option value="11:15">11:15am</option>
				<option value="11:30">11:30am</option>
				<option value="11:45">11:45am</option>
				<option value="12:00">12:00pm</option>
				<option value="12:15">12:15am</option>
				<option value="12:30">12:30pm</option>
				<option value="12:45">12:45pm</option>
				<option value="13:00a">1:00pm</option>
				<option value="13:15">1:15pm</option>
				<option value="13:30">1:30pm</option>
				<option value="13:45">1:45pm</option>
				<option value="14:00">2:00pm</option>
				<option value="14:15">2:15pm</option>
				<option value="14:30">2:30pm</option>
				<option value="14:45">2:45pm</option>
				<option value="15:00">3:00pm</option>
				<option value="15:15">3:15pm</option>
				<option value="15:30">3:30pm</option>
				<option value="15:45">3:45pm</option>
				<option value="16:00">4:00pm</option>
				<option value="16:15">4:15pm</option>
				<option value="16:30">4:30pm</option>
				<option value="16:45">4:45pm</option>
				<option value="17:00">5:00pm</option>
				<option value="17:15">5:15pm</option>
				<option value="17:30">5:30pm</option>
				<option value="17:45">5:45pm</option>
				<option value="18:00">6:00pm</option>
				<option value="18:15">6:15pm</option>
				<option value="18:30">6:30pm</option>
				<option value="18:45">6:45pm</option>
				<option value="19:00">7:00pm</option>
				<option value="19:15">7:15pm</option>
				<option value="19:30">7:30pm</option>
				<option value="19:45">7:45pm</option>
				<option value="20:00">8:00pm</option>
				<option value="20:15">8:15pm</option>
				<option value="20:30">8:30pm</option>
				<option value="20:45">8:45pm</option>
				<option value="21:00">9:00pm</option>
				<option value="21:15">9:15pm</option>
				<option value="21:30">9:30pm</option>
				<option value="21:45">9:45pm</option>
				
               	  
               	  
        </select> 
        
        -->
			 
	  <?php 
	  
	  echo "</td><td align=left valign=top><strong><br />$talk_room</strong><br /><br />";
	
	?>

     <!--    <select  style="font-size: 9px; padding: 0px margin:0px" name="room" id="room">
                <option value="<?php echo $talk_room; ?>" selected>- room -</option>
                <option value="SalonA-B">SalonA-B</option>
                <option value="SalonC">SalonC</option>
                <option value="SalonD">SalonD</option>
                <option value="SalonE">SalonE</option>
                <option value="SalonF">SalonF</option>
                <option value="SalonG">SalonG</option>
                <option value="SalonH">SalonH</option>
                <option value="SalonJ">SalonJ</option>
                <option value="SalonA">SalonK</option>
                <option value="Rm400">Rm400</option>
                <option value="Rm402">Rm402</option>
                <option value="Rm404">Rm404</option>
                <option value="Rm406">Rm406</option>
                <option value="Rm408">Rm408</option>
                <option value="Rm602">Rm602</option>

               	  
        </select>
        </td><td valign=top>
        <input type=hidden name=id value="<?php echo $id ?>">
        <input type=hidden name="current_day" value="<?php echo $talk_day; ?>" >
        <input type=hidden name="current_start" value="<?php echo $talk_start; ?>">
        <input type=hidden name="current_end" value="<?php echo $talk_end; ?>">
        <input type=hidden name="current_room" value="<?php echo $talk_room; ?>">
        <input type=hidden name="type" value="<?php echo $_POST['type']; ?>">
        
	<br />		  <input style="font-size: 9px;"  type="submit" name="update" value="update">

	
	 
	 </form>-->
	  
	  <?php 
	  echo "</td>

</tr>
";

 //end row, so change color   


} //end of while


echo"</table>";



?>