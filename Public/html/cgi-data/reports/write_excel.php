<?php

 if ($download == 'R1') {
 
 
/***********Registration download********************/

$export = mysql_query($select);
$count = mysql_num_fields($export);


/********************************************
Extract field names and write them to the $header
variable
/********************************************/
$downloadTime = date("m_d_y"); 
$pgInfo .="Sakai Austin Conference All Registration Data as of  $downloadTime\n";

//$headerrow .="id \tDate \tConfID \tTrack \tFormat \tTitle \tAbstract \tDescription \tSpeaker \tProject_URL \tSpeaker_URL \tSpeaker_BIo \tFirst \tLast \temail \tdev \tfaculty \tmgr \tsys_admin \tsr_admin \tui_dev \tsupport";

for ($i = 0; $i < $count; $i++) {
$header .= mysql_field_name($export, $i)."\t";
} 

/********************************************/


}

else  if ($download == 'R2')  {
 
 
/***********Registration download********************/

$export = mysql_query($select);
$count = mysql_num_fields($export);


/********************************************
Extract field names and write them to the $header
variable
/********************************************/
$downloadTime = date("m_d_y"); 
$pgInfo .="Sakai Austin Conference All PUBLIC Registration Data as of $downloadTime\n";

//$headerrow .="id \tDate \tConfID \tTrack \tFormat \tTitle \tAbstract \tDescription \tSpeaker \tProject_URL \tSpeaker_URL \tSpeaker_BIo \tFirst \tLast \temail \tdev \tfaculty \tmgr \tsys_admin \tsr_admin \tui_dev \tsupport";

for ($i = 0; $i < $count; $i++) {
$header .= mysql_field_name($export, $i)."\t";
} 

/********************************************/


}


else {

$export = mysql_query($select);
$count = mysql_num_fields($export);


/********************************************
Extract field names and write them to the $header
variable
/********************************************/
$downloadTime = date("m_d_y"); 
$pgInfo .="Sakai Austin Conference, All Submitted Call for Propsals as of $downloadTime\n";
$legend .="T1\tManagement & Campus Implementationt\nT2\tResearch & Collaboration\nT3\tSakai Foundation, Community Source & Governance\nT4\tTeaching, Learning & Assessment\nT5\tTechnology\n";
$audience.="\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tAUDIENCE\t";

$headerrow .="id \tDate \tConfID \tTrack \tFormat \tTitle \tAbstract \tDescription \tSpeaker \tProject_URL \tSpeaker_URL \tSpeaker_BIo \tFirst \tLast \temail \tdev \tfaculty \tmgr \tsys_admin \tsr_admin \tui_dev \tsupport";

//for ($i = 0; $i < $count; $i++) {
//	$header .= mysql_field_name($export, $i)."\t";
// }


}
?>