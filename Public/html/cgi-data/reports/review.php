<?php 
$result= mysql_query($sql);
$resultsnumber=mysql_numrows($result);

$totalEntry=$resultsnumber;


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
	<td>NO</td>
<td><strong>Title</strong><br />
Name/Email</td>
<td>Abstract</td>

	<td>Reviewer #1<br />

	<td>Reviewer #1</td>
	<td>Reviewer #2</td>
	<td>Reviewer #3</td>
	<td>Reviewer #4</td>
	<td>Reviewer #5</td>
	<td>Reviewer #6</td>
	<td>Reviewer #7</td>
	<td>Reviewer #8</td>
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
$approved=$links["approved"];


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
	<td class=line_no>$id</td>";
	?>
	
	
	  <?php


	
	?>
        
	  <?php 
	  
	  
echo"
	<td>$date</td>
	<td><a href=\"$emailadd\">$first $last</a><br />
<strong>$p_title</strong><br />
$p_abstract</td>
";
?>
<td><strong></strong><br /><br /><form   name="austin_sessions"  method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <select style="font-size: 9px; padding: 0px margin:0px" name="day" id="day">
                <option value="<?php echo $talk_day; ?>" selected>-change priority-</option>
                <option value="Monday">High</option>
                <option value="Monday">neutral</option>
                <option value="Tuesday">Low </option>
        </select><br />		  
        <input style="font-size: 9px;"  type="submit" name="update" value="change">
	 </form>
	 <br /><strong>Comments:</strong><br /><br /><br />
</td>
<td><strong></strong><br /><br /><form   name="austin_sessions"  method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <select style="font-size: 9px; padding: 0px margin:0px" name="day" id="day">
                <option value="<?php echo $talk_day; ?>" selected>-change priority-</option>
                <option value="Monday">High</option>
                <option value="Monday">neutral</option>
                <option value="Tuesday">Low </option>
        </select><br />		  
        <input style="font-size: 9px;"  type="submit" name="update" value="change">
	 </form>
	 <br /><strong>Comments:</strong><br /><br /><br />
</td>

<td><strong></strong><br /><br /><form   name="austin_sessions"  method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <select style="font-size: 9px; padding: 0px margin:0px" name="day" id="day">
                <option value="<?php echo $talk_day; ?>" selected>-change priority-</option>
                <option value="Monday">High</option>
                <option value="Monday">neutral</option>
                <option value="Tuesday">Low </option>
        </select><br />		  
        <input style="font-size: 9px;"  type="submit" name="update" value="change">
	 </form>
	 <br /><strong>Comments:</strong><br /><br /><br />
</td>

<td><strong></strong><br /><br /><form   name="austin_sessions"  method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <select style="font-size: 9px; padding: 0px margin:0px" name="day" id="day">
                <option value="<?php echo $talk_day; ?>" selected>-change priority-</option>
                <option value="Monday">High</option>
                <option value="Monday">neutral</option>
                <option value="Tuesday">Low </option>
        </select><br />		  
        <input style="font-size: 9px;"  type="submit" name="update" value="change">
	 </form>
	 <br /><strong>Comments:</strong><br /><br /><br />
</td>

<td><strong></strong><br /><br /><form   name="austin_sessions"  method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <select style="font-size: 9px; padding: 0px margin:0px" name="day" id="day">
                <option value="<?php echo $talk_day; ?>" selected>-change priority-</option>
                <option value="Monday">High</option>
                <option value="Monday">neutral</option>
                <option value="Tuesday">Low </option>
        </select><br />		  
        <input style="font-size: 9px;"  type="submit" name="update" value="change">
	 </form>
	 <br /><strong>Comments:</strong><br /><br /><br />
</td>

<td><strong></strong><br /><br /><form   name="austin_sessions"  method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <select style="font-size: 9px; padding: 0px margin:0px" name="day" id="day">
                <option value="<?php echo $talk_day; ?>" selected>-change priority-</option>
                <option value="Monday">High</option>
                <option value="Monday">neutral</option>
                <option value="Tuesday">Low </option>
        </select><br />		  
        <input style="font-size: 9px;"  type="submit" name="update" value="change">
	 </form>
	 <br /><strong>Comments:</strong><br /><br /><br />
</td>

<td><strong></strong><br /><br /><form   name="austin_sessions"  method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <select style="font-size: 9px; padding: 0px margin:0px" name="day" id="day">
                <option value="<?php echo $talk_day; ?>" selected>-change priority-</option>
                <option value="Monday">High</option>
                <option value="Monday">neutral</option>
                <option value="Tuesday">Low </option>
        </select><br />		  
        <input style="font-size: 9px;"  type="submit" name="update" value="change">
	 </form>
	 <br /><strong>Comments:</strong><br /><br /><br />
</td>

<td><strong></strong><br /><br /><form   name="austin_sessions"  method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <select style="font-size: 9px; padding: 0px margin:0px" name="day" id="day">
                <option value="<?php echo $talk_day; ?>" selected>-change priority-</option>
                <option value="Monday">High</option>
                <option value="Monday">neutral</option>
                <option value="Tuesday">Low </option>
        </select><br />		  
        <input style="font-size: 9px;"  type="submit" name="update" value="change">
	 </form>
	 <br /><strong>Comments:</strong><br /><br /><br />
</td>



<?php
echo"
</tr>
";

 //end row, so change color   


} //end of while


echo"</table>";

?>



