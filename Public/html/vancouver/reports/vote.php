<?php

$result= mysql_query($sql);
$resultsnumber=mysql_numrows($result);

$totalEntry=$resultsnumber;


function format_datetime($string, $type)
{
  $year = substr($string, 0, 4);
  $month = substr($string, 5, 2);
  $day = substr($string, 8, 2);
  $hour = substr($string, 11, 2);
  $minute = substr($string, 14, 2);
  $second = substr($string, 17, 2);


  return date('Y-m-d', mktime($hour, $minute, $second, $month, $day, $year));
} 
 



//display results


$line = "1";
$row="0";





//print out demo report data
//
//

if ($_POST['type']=="demo")
{
echo"</tr></table>
<table cellpadding=0 cellspacing=0 width=100% bgcolor:#fff  align=center border=0>
<tr>
		
		<td border=0><br /><br /><strong>Vancouver CFP:</strong>-- $reportName</td>
		</tr>
</table>


 <table cellspacing=0 width=100%> 
<tr class=tableheader>
	<td>NO</td>
	<td>Date</td>
<td class=label>Name/Email</td>
<td>Title</td>
<td>Description</td>
<td>Demo Presenter</td>
<td>Project URL</td>

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


$date=format_datetime($date, datetime);




if ($line == 1) {   	
	echo "<tr id=oddrow valign=top>";
   $line='2';

} else {
	echo "<tr id=evenrow valign=top>";
	$line='1';
}
	echo"
	<td class=line_no>$row</td>
	<td class=nowrap>$date</td>
	<td class=nowrap>$first $last<br /><a href=\"$emailadd\">$emailadd</a></td>

<td width=200px><strong>$title</strong></td>
<td width=300px>$demo_desc</td>
<td width=200px>$demo_speaker</td>
<td align=center>";
if ($demo_url)
echo"<a href=\"$demo_url\"><img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 width=15px height=15px></a>";
echo"


</td>

</tr>
";

 //end row, so change color   


} //end of while


echo"</table>";


}

else {
	echo"
<table  width=100%>
<tr>		
	<td border=0 valign=top><br /><div style=\"font-size:12px; font-weight:bold; color:#333;\">$reportName<br /> </div></td>
</tr>
</table>
	
 <table cellspacing=0 cellpadding=0 class=main> 
<tr class=tableheader>
	<td> </td>

<td>Title</td>

<td>Format</td>
<td>Abstract/Description/Presenter Bio</td>
<td>Topics/Rank</td><td>Audiences/Rank</td>
<td width=150>Reviewer Rank</td><td>Comments</td>
</tr>
";





while($links=mysql_fetch_array($result))
{
$row++; 
$id=$links["id"];
$date=$links["date"];
$conf=$links["confID"]; 
$last=stripslashes($links["lastname"]);
$first=stripslashes($links["firstname"]);
$emailadd=$links["email1"];
$p_track=$links["p_track"];
$p_format=$links["p_format"];
$p_title=$links["p_title"];
$p_abstract=stripslashes($links["p_abstract"]);
$p_desc=stripslashes($links["p_desc"]);
$p_URL=$links["p_URL"];
$sp_URL=$links["sp_URL"];
$bio=stripslashes($links["bio"]);
$co_bio=$links["co_bio"];
$co_speaker=stripslashes($links["co_speaker"]);
$dev=$links["dev"];
$faculty=$links["faculty"];
$mgr=$links["mgr"];
$sys_admin=$links["sys_admin"];
$sr_admin=$links["sr_admin"];
$ui_dev=$links["ui_dev"];
$length=$links["length"];
$support=$links["support"];
$approved=$links["approved"];
$date=format_datetime($date, datetime);


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
	<td class=line_no>$row</td>";
	?>
	
	

        
	  <?php 
	  
	  
echo"
	<td>";
	if ($sp_URL)
echo"<a href=\"$sp_URL\"><img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 width=10px height=10px></a>";

echo"<strong>$p_title</strong><br/><br/><a href=\"mailto:$emailadd\">$first $last</a></td>
<td ><strong>Format: </strong><br/>$p_format<br /><br/><strong>Length:</strong><br/>$length min.<br /><br/><strong>Date Submitted: </strong>$date</td>
<td><strong>Abstract: <br/></strong>";


echo"$p_abstract<br /><br />";
		

if ($p_URL)
echo"<br/><br/><strong>Project site: </strong><a href=\"$p_URL\">
<img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 width=10px height=10px></a><br/>
&nbsp; &nbsp;";

echo"<br/><br/><strong>Presenter Bio: </strong><br/>$bio<br /><br />
<strong>Co-Presenters:<br/></strong><br/><br/></td>
";
?>

<td><strong>High</strong><br/>
Development<br/>
UI Development<br/>
<br/>
<strong>Med</strong><br/>
Implementation:Pilot<br/>
User Support<br/></br>
</td><!-- topic list here -->

 
<td><strong>High</strong><br/>
Developer<br/>
UI Developer<br/>
<br/>
<br/><br/>
<strong>Med</strong><br/>
Implementor<br/>
System Administrator<br/>
User Support<br/></td><!-- audience list here -->


<FORM ACTION="<?php echo($PHP_SELF); ?>" METHOD="POST" 
name="comment_form" id="comment_form">
 <td>	<strong>Rank this session:</strong><br/><input id="vr6_3" name="vr6" type="radio" value="3"  onClick="checkSaved('6')" title="Cannot use Sakai without it"><label for="vr6_3" title="Cannot use Sakai without it">critical</label><br />
			<input id="vr6_2" name="vr6" type="radio" value="2"  onClick="checkSaved('6')" title="Can use Sakai but need this as soon as possible"><label for="vr6_2" title="Can use Sakai but need this as soon as possible">green</label><br />
			<input id="vr6_1" name="vr6" type="radio" value="1"  onClick="checkSaved('6')" title="Can use Sakai but would like this"><label for="vr6_1" title="Can use Sakai but would like this">yellow</label><br />
			<input id="vr6_0" name="vr6" type="radio" value="0"  onClick="checkSaved('6')" title="Does not impact our use of Sakai"><label for="vr6_0" title="Does not impact our use of Sakai">red</label><br />
			<br/><br/><strong>Or suggest a change to:</strong><br/>
<input id="vr6_0" name="vr6" type="radio" value="0"  onClick="checkSaved('6')" title="Does not impact our use of Sakai"><label for="vr6_0" title="Does not impact our use of Sakai">Tool Carousel</label><br />
<input id="vr6_0" name="vr6" type="radio" value="0"  onClick="checkSaved('6')" title="Does not impact our use of Sakai"><label for="vr6_0" title="Does not impact our use of Sakai">Tech Demo</label><br />
	</td>
	
	
<td><strong>Reviewer Comments: </strong><br/>
<textarea name="comments" cols="30" rows="6">Not working yet....</textarea>
<input name="submit" type="submit" value="save">
</td>
</form>		</tr>

 

<?php
} //end of while
//end row, so change color   

echo"</table>";





}






?>