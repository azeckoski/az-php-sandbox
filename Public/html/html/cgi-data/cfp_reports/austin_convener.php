<?php

$result= mysql_query($sql);
$resultsnumber=mysql_numrows($result);



echo"

</tr>
	
	<tr><td>&nbsp;</td></tr>


	</table>";
	
/*	echo"<table width=100% class=main>
<tr>		
	<td width=400px border=0 valign=top><br /><br />
	<strong>Sakai Austin Conference -Session Conveners</strong></td>
<td > <br /> $reportName: To add your name as the convener
for a session, select your name from the drop down menu for the
desired session. (To remove your name from a session select \"unknown\" from the list of conveners.) </td>
<td>ADD A CONVENER NAME:";



*/
?>

<!--
<FORM ACTION="<?php echo($PHP_SELF); ?>" METHOD="POST" 
name="FORM_name_convener" id="FORM_name_convener">

Add a Convener name (first last)<input type=text name="convener_name" style=" line-height: 11px;" value="UNDER CONSTRUCTION" "onchange="function_submit_name_convener<?php echo $id;?>()">

    <input type=hidden name="type" value="<?php echo $_POST['type']; ?>">

                                <input type=hidden name="add" value="true">
-->


<script language="JavaScript" type="text/javascript">
<!--
//function function_submit_name_convener(){
//document.FORM_name_convener.submit();
	}
//-->
</script>
<!--
<noscript>

<input type="submit" value="change" name="SUBMIT_change_convener<?php echo $id;?>">
</noscript>
</FORM>
-->

<?php echo" </td>
</tr>

</table>
	
 <table cellspacing=0 cellpadding=0 class=main> 
<tr class=tableheader>
	<td>#</td>
<td>Title and Speaker Name<br />
<td>Track/Format</td>
<td>Abstract</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align=center>Convener</td>
<td align=center>Day/Time/Room</td>
<td></td>

</tr>

<tr class=tableheader>
	<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>

<td colspan=4 align=center style=\"border-left: 1px solid #ffcc33;\"></td>


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

$convener=$links["convener"];
$support=$links["support"];

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
	<td class=line_no><strong>$id</strong></td>
<td ><strong>$p_title</strong><br /><a href=\"$emailadd\">$first $last</a></td>
<td><strong>Track: </strong>$p_track<br /><strong>Format: </strong>$p_format</td>
<td width=300px>$p_abstract</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td align=left valign=top style=\"border-left: 1px solid #ffcc33; padding-left: 10px;\">";

?>
	<?php
if ($convener=="") {

echo "<br /><strong><span style=\"text-align: center; color:#ffcc00;\">open</span></strong><br />";
	}
	
	echo "<br /><strong>$convener</strong><br /><br />";

	?>




<!-- <FORM ACTION="<?php echo($PHP_SELF); ?>" METHOD="POST" 
name="FORM_change_convener<?php echo $id;?>" id="FORM_change_convener<?php echo $id;?>">

 <select name="convener" style=" line-height: 11px; "onchange="function_submit_change_convener<?php echo $id;?>()">


<br />		 

                <option class=small value="" selected>change to...</option>
                                <option value="">unkown</option>

                <option value="Joseph Hardin">Joseph Hardin</option>
<option value="Trent Batson">Trent Batson</option>
<option value="Mara Hancock">Mara Hancock</option>
<option value="Rob Cartolano">Rob Cartolano</option>
<option value="Sayeed Choudhury">Sayeed Choudhury</option>
<option value="Chris Coppola">Chris Coppola</option>
<option value="Carol Dippel">Carol Dippel</option>
<option value="Jim Farmer">Jim Farmer</option>
<option value="Tom Finholt">Tom Finholt</option>
<option value="Duffy Gillman">Duffy Gillman</option>
<option value="Jeff Haywood">Jeff Haywood</option>
<option value="Tom Lewis">Tom Lewis</option>
<option value="Phillip Long">Phillip Long</option>
<option value="Jim Martino">Jim Martino</option>
<option value="Mary Miles">Mary Miles</option>
<option value="Gail Moore">Gail Moore</option>
<option value="Mark Norton">Mark Norton</option>
<option value="Daphne Ogle">Daphne Ogle</option>
<option value="Tony Potts">Tony Potts</option>
<option value="Kathi Reister">Kathi Reister</option>
<option value="Seth Theriault">Seth Theriault</option>
<option value="Lionel Tolan">Lionel Tolan</option>
<option value="Jutta Treviranus">Jutta Treviranus</option>
<option value="Anthony Whyte">Anthony Whyte</option>
               	  
                   
                </select>
               

                
                
                                <input type=hidden name="id" value="<?php echo $id; ?>">
                                <input type=hidden name="change" value="true">


                <input type=hidden name="type" value="<?php echo $_POST['type']; ?>">
-->
<script language="JavaScript" type="text/javascript">
<!--
//function function_submit_change_convener<?php echo $id;?>(){
//document.FORM_change_convener<?php echo $id;?>.submit();
	}
//-->
</script>
<!-- 
<noscript>

<input type="submit" value="change" name="SUBMIT_change_convener<?php echo $id;?>">
</noscript>
</FORM>

-->

<?php	  
	  
	             
	  
	  echo "</td>";
	  
	  echo "<td align=left valign=top style=\"border-left: 1px solid #ffcc33; padding-left: 10px;\">
<strong>$talk_day</strong>
	  
	  <br /><strong>$starttime-$endtime</strong><br /><br />$talk_room</strong><br /><br />";
	
	?>

          
        </td><td valign=top>
      	
	  
	  <?php echo "</td>

</tr>
";

 //end row, so change color   


} //end of while


echo"</table>";





?>    
