<?php
/********************************************
PHP - Excel Extraction Tutorial Code
Page: excel.php
Developer: Jeffrey M. Johns
Support: binary.star@verizon.net
Created: 10/01/2003
Modified: N/A
*********************************************
Notes/Comments: This code is a very basic/replica of
the code that is in the tutorial. To make it work you must
define your connection variables below. Make sure you
replace the following all CAPS text with your proper values.
*********************************************
YOUR DATABASE HOST = (ex. localhost)
USERNAME = username used to connect to host
PASSWORD = password used to connect to host
DB_NAME = your database name
TABLE_NAME = table in the database used for extraction
*********************************************
This code will extract the data from your table and format
it for an excel spreadsheet download. It is very quick,
simple, and to the point. If you only want to extract 
certain fields and not the whole table, simply replace
the * in the $select variable with the fields you want
to extract.
*********************************************
Disclaimer: Upon using this code, it is your responsibilty
and I, Jeffrey M. Johns, can not be held accountable for
any misuse or anything that may go wrong.
*********************************************
Other: Support will not be provided if the code is
enhanced or changed. I do not have the time for 
figuring out your changes and modifications. I will only
offer simple support for the code listed below.
/********************************************/
define(db_host, "bengali.web.itd.umich.edu");
define(db_user, "sakai");
define(db_pass, "mujoIII");
define(db_link, mysql_connect(db_host,db_user,db_pass));
define(db_name, "sakai");
mysql_select_db(db_name);



/********************************************
Determine the type of report requested
/********************************************/


$download=$_POST["type"];




if ($download =="demo") {


$select = "SELECT * FROM cfp_vancouver_demo";				

$export = mysql_query($select);
$count = mysql_num_fields($export);


/********************************************
Extract field names and write them to the $header
variable
/********************************************/
$downloadTime = date("m_d_y"); 
$pgInfo .="Sakai Austin Conference, CFP Technology  Demos\n";

$headerrow .="id \tDate \tConfID \tFirst \tLast \temail \tProduct \tdemo_desc \tSpeaker \tDemo_URL";


}



if ($download =="contact") {

$select = "SELECT * FROM cfp_vancouver_contact ORDER by id ASC";				


$export = mysql_query($select);
$count = mysql_num_fields($export);


/********************************************
Extract field names and write them to the $header
variable
/********************************************/

$downloadTime = date("m_d_y"); 
$pgInfo .="Sakai Austin Conference, CFP Contact List\n";
for ($i = 0; $i < $count; $i++) {
	$header .= mysql_field_name($export, $i)."\t";
 }

//$headerrow .="id \tDate \tConfID \tTrack \tFormat \tTitle \tAbstract \tDescription \tSpeaker \tProject_URL \tSpeaker_URL \tSpeaker_BIo \tFirst \tLast \temail \tdev \tfaculty \tmgr \tsys_admin \tsr_admin \tui_dev \tsupport";


}


if ($download == 'R1') {


$select = "SELECT * FROM `seppConf_austin` WHERE `confID` = 'Dec05' ORDER by id";		
include ('write_excel.php');

}

if ($download == 'R2') {


$select = "SELECT * FROM `seppConf_austin_ccard` WHERE `confID` = 'Dec05' ORDER by id";		
include ('write_excel.php');

}

if ($download == 'discussion') {


$select = "SELECT * FROM `cfp_vancouver_present_test` WHERE `p_format` = '$download' ORDER by id ASC";		
include ('write_excel.php');

}

if ($download == 'panel') {


$select = "SELECT * FROM `cfp_vancouver_present_test` WHERE `p_format` = '$download' ORDER by id ASC";		
include ('write_excel.php');

}

if ($download == 'showcase') {


$select = "SELECT * FROM `cfp_vancouver_present_test` WHERE `p_format` = '$download' ORDER by id ASC";		
include ('write_excel.php');

}

if ($download == 'workshop') {


$select = "SELECT * FROM `cfp_vancouver_present_test` WHERE `p_format` = '$download' ORDER by id ASC";		
include ('write_excel.php');

}

if ($download == 'lecture') {


$select = "SELECT * FROM `cfp_vancouver_present_test` WHERE `p_format` = '$download' ORDER by id ASC";		
include ('write_excel.php');

}

if ($download == 'T1') {


$select = "SELECT * FROM `cfp_vancouver_present_test` WHERE `p_track` = '$download' ORDER by id ASC";		
include ('write_excel.php');

}

if ($download == 'T2') {


$select = "SELECT * FROM `cfp_vancouver_present_test` WHERE `p_track` = '$download' ORDER by id ASC";		
include ('write_excel.php');

}

if ($download == 'T3') {


$select = "SELECT * FROM `cfp_vancouver_present_test` WHERE `p_track` = '$download' ORDER by id ASC";		
include ('write_excel.php');

}

if ($download == 'T4') {


$select = "SELECT * FROM `cfp_vancouver_present_test` WHERE `p_track` = '$download' ORDER by id ASC";		
include ('write_excel.php');

}

if ($download == 'T5') {


$select = "SELECT * FROM `cfp_vancouver_present_test` WHERE `p_track` = '$download' ORDER by id ASC";		
include ('write_excel.php');

}



if ($download =="presentation") {


$select = "SELECT * FROM cfp_vancouver_present_test ORDER by id ASC";				






/********************************************/

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



if ($download =="approved_fullList") {


		$select="Select * from cfp_vancouver_present_test where approved='1' or approved='2' or approved='3' ORDER by session_time";






/********************************************/

$export = mysql_query($select);
$count = mysql_num_fields($export);


/********************************************
Extract field names and write them to the $header
variable
/********************************************/
$downloadTime = date("m_d_y"); 
$pgInfo .="Sakai Austin Conference, All approved sessions, bofs, and tool carousel  of $downloadTime\n";


for ($i = 0; $i < $count; $i++) {
	$header .= mysql_field_name($export, $i)."\t";
 }

}






/********************************************
Extract all data, format it, and assign to the $data
variable
/********************************************/
while($row = mysql_fetch_row($export)) {
	$line = '';
	foreach($row as $value) {											
		if ((!isset($value)) OR ($value == "")) {
			$value = "\t";
		} else {
			$value = str_replace('"', '""', $value);
			$value = '"' . $value . '"' . "\t";
		}
		$line .= $value;
	}
	$data .= trim($line)."\n";
}
$data = str_replace("\r", "", $data);
/********************************************
Set the default message for zero records
/********************************************/
if ($data == "") {
	$data = "\n(0) Records Found!\n";	
	


//header  ("Location:reports.php");



}
	









$today = date("m_d_y"); 

 if ($download == 'R1')   {

$filename="AustinReg" . $download . "_" . $today . ".xls";

} else   if ($download == 'R2')  {

$filename="AustinRegBilling" . $download . "_" . $today . ".xls";

}

else {


$filename="AustinCFP_" . $download . "_" . $today . ".xls";

}
/********************************************
Set the automatic downloadn section
/********************************************/
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");
print "$pgInfo\n$legend$audience\n$headerrow\n$header\n$data";






?>