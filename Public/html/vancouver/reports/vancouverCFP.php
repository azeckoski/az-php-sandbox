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
 




if ( $resultsnumber==0) {   //no records found
echo"
</tr></table>
<table cellpadding=0 cellspacing=0 width=700px bgcolor:#fff  align=center border=0>

<tr>
		<td border=0><strong>AUSTIN -CALL FOR PROPOSALS<br />$reportName</strong></td>
		<td><strong> Download Presentation data to excel:  
		</strong<br /><a href=\"CFPpresentation_excel.php?\">All Presentation Submissions</a>
</tr>
</table>
 <table cellspacing=0 cellpadding=0> 
<tr class=tableheader>
	<td>NO</td>
	<td>Date</td>
<td>Name/Email</td>
<td>Title</td>
<td>Track</td>
<td>Format</td>
<td>Abstract</td>
<td>Description</td>
<td>Project URL</td>
<td>Speaker URL</td>
<td>Bio</td>
<td>Audience</td>
</tr><td><br /><br />no records found </td></tr>
";
}

else {//display results


$line = "1";
$row="0";





//print out demo report data
//
//

if ($_POST['type']=="demo")
{
echo"</tr></table>
<table cellpadding=0 cellspacing=0 width=800px bgcolor:#fff  align=center border=0>
<tr>
		
		<td border=0><br /><br /><strong>Vancouver CFP:</strong>-- $reportName</td>
		</tr>
</table>


 <table cellspacing=0 width=800px> 
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




else  if ($_POST['type']=='contact')
{
echo"
</tr></table>
<table cellpadding=0 cellspacing=0 class=main  border=0>
		
	<tr>	<td><br /><strong>AUSTIN -CALL FOR PROPOSALS</strong>--$reportName<br />
	<br /><strong>Note: </strong> Empty contact fields means that user did not complete
	the proposal proccess.</td></tr>
	</table>



 <table cellspacing=0> 

<tr class=tableheader>
	<td>NO</td>
	<td>Date</td>
	<td>Name</td>
	<td>Email</td>
	<td>Institution</td>
<td>Address</td>
<td>Phone</td>
</tr>
";





while($links=mysql_fetch_array($result))
{
$row++; 
$id=$links["id"];
$date=$links["date"];
$conf=$links["confID"]; 
$inst=$links["institution"];
$otherInst=$links["otherInst"];
$dept=$links["dept"];
$last=$links["lastname"];
$first=$links["firstname"];


$emailadd=$links["email"];

$add1=$links["address1"];
$add2=$links["address2"];
$city=$links["city"];
$state=$links["state"];
$otherstate=$links["otherState"];
$zip=$links["zip"];
$country=$links["country"];
$phone=$links["phone"];
$fax=$links["fax"];

$spec=$links["special"];
$hotel=$links["hotelInfo"];
$jasig=$links["jasig"];
$contact=$links["contactInfo"];
$approved=$links["approved"];

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
	<td class=nowrap>$last, $first
	</td><td>$emailadd</td>

	<td>$inst $otherInst</td>
<td class=nowrap>$city, $state<br />
$country</td>
<td class=nowrap>$phone</td>
</tr>
";

 //end row, so change color   


} //end of while


echo"</table>";





}

else if ($_POST['type']=='approvedP') {

include ('austin_approvedP.php');

}

else if ($_POST['type']=='approved_full') {

include ('austin_approvedP.php');

}

else if ($_POST['type']=='approved_fulldetails') {

include ('austin_approvedFullDetails.php');

}
else if ($_POST['type']=='conveners') {

include ('austin_convener.php');

}
else if ($_POST['type']=='approvedP_carousel') {

include ('austin_approvedP.php');

}
else if ($_POST['type']=='approvedP_day') {

include ('austin_approvedP.php');

}
else if ($_POST['type']=='approvedP_room') {

include ('austin_approvedP.php');

}
else if ($_POST['type']=='approvedP_time') {

include ('austin_approvedP.php');

}
else if ($_POST['type']=='review') {

include ('review.php');

}



else {
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


/*
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
	
	";
	*/
	echo"
<table  width=900px>
<tr>		
	<td border=0 valign=top><br /><div style=\"font-size:12px; font-weight:bold; color:#333;\">$reportName<br /> </div></td>
</tr>
</table>
	
 <table cellspacing=0 cellpadding=0 class=main> 
<tr class=tableheader>
	<td>NO</td>
	<td>Date</td>
<td>Name/Email</td>
<td>Title</td>

<td>Format</td>
<td>Abstract</td>
<td>Description</td>
<td>Bio</td>
<td>Co-presenters</td>
<td>Length</td>
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
$bio=$links["bio"];
$co_bio=$links["co_bio"];
$co_speaker=$links["co_speaker"];
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


	
	?>
        
	  <?php 
	  
	  
echo"
	<td>$date</td>
	<td class=nowrap>";
	if ($sp_URL)
echo"<a href=\"$sp_URL\"><img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 width=15px height=15px><br />Speaker</a>";

echo"<a href=\"mailto:$emailadd\">$first $last</a></td>
<td ><strong>$p_title</strong></td>
";

echo"
<td>$p_format</td>
<td width=300px>$p_abstract</td>
<td width=300px>";

if ($p_URL)
echo"<a href=\"$p_URL\"><img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 width=15px height=15px><br />Project</a>";
echo"$p_desc</td>
<td width=200px>$bio</td>
<td><strong>$co_speaker</strong><br />$co_bio</td>

<td>$length min.</td>


</tr>
";

 //end row, so change color   


} //end of while


echo"</table>";





}




}


?>