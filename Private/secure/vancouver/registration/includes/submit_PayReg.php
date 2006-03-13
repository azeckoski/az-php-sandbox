<?php
/*******************************/
//non-member registrant submission
/*******************************/
require_once('../includes/mysqlconnect.php');


/*******************************/
//co registrant contact information
/*******************************/
if ($_SESSION['regType']=="2") {
$co_firstname=addslashes($_SESSION['co_firstname']);
$co_lastname=addslashes($_SESSION['co_lastname']);
$co_phone=addslashes($_SESSION['co_phone']);
$co_email1=addslashes($_SESSION['co_email1']);
$co_registrant=$co_firstname ." " .$co_lastname ."\r"  .$co_phone ."\r" .$co_email1;
$co_registrant=addslashes($co_registrant);
}
else {
$co_registrant="";

}


/*******************************/
//registrant information
/*******************************/

$firstname=addslashes($_SESSION['firstname']);
$lastname=addslashes($_SESSION['lastname']);
$badge=addslashes($_SESSION['badge']);
$email=addslashes($_SESSION['email1']);
$title=addslashes($_SESSION['title']);
$institution=addslashes($_SESSION['otherInst']);
$address1=addslashes($_SESSION['address1']);
$city=addslashes($_SESSION['city']);

if ($_SESSION['state']=="") {
$state=addslashes($_SESSION['otherState']);
}
else {
$state=addslashes($_SESSION['state']);
}

$zip=addslashes($_SESSION['zip']);
$country=addslashes($_SESSION['country']);
$phone=addslashes($_SESSION['phone']);
$fax=addslashes($_SESSION['fax']);


$special=addslashes($_SESSION['special']);
$shirt=$_SESSION['shirt'];
$publish=$_SESSION['publish'];
$hotelInfo=$_SESSION['hotelInfo'];

$jasig=$_SESSION['jasig'];
$fee=$_SESSION['fee'];
$payeeInfo="";



$register="INSERT INTO sakaiconf_vancouver_ccard VALUES (
		'',
		NOW( ) ,
		'June06',
		'$firstname',
		'$lastname', 
		'$badge',
		'$email',
		'$title',
		'$institution',
		'$address1',
		'$city',
		'$state',
		'$zip',
		'$country',
		'$phone',
		'$fax',
		'$shirt',
		'$special',
		'$hotelInfo',
		'$publish',
		'$jasig',
		'$fee',
		'$co_registrant',
		'$payeeInfo',
		'none'
	)";
	

$result = mysql_query($register); 
       

	$user_id=mysql_insert_id(); //get this database id 
	

$_SESSION['user_id']=$user_id;

?>