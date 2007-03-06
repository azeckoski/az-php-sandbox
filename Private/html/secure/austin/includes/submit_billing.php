<?php
require_once('mysqlconnect.php');
 if($_SESSION['jasig']=='Y'){

   $amount='345.00';
    }
    else {
    
    $amount='395.00';
    }
    
  // $amount='1.00';
   


//add slashes to text entry fields
$firstname=addslashes($_SESSION['firstname']);
$lastname=addslashes($_SESSION['lastname']);
$badge=addslashes($_SESSION['badge']);
$email1=addslashes($_SESSION['email1']);
$institution=addslashes($_SESSION['institution']);
$otherInst=addslashes($_SESSION['otherInst']);
$dept=addslashes($_SESSION['dept']);
$address1=addslashes($_SESSION['address1']);
$address2=addslashes($_SESSION['address2']);
$city=addslashes($_SESSION['city']);
$otherState=addslashes($_SESSION['otherState']);
$zip=addslashes($_SESSION['zip']);
$phone=addslashes($_SESSION['phone']);
$fax=addslashes($_SESSION['fax']);
$transID=addslashes($_SESSION['transID']);

$special=addslashes($_SESSION['special']);




$register="INSERT INTO seppConf_austin_ccard VALUES (
'',
NOW( ) ,
'Dec05',
'$firstname',
'$lastname', 
'$badge',
'$email1',
		'$institution',
		'$otherInst',
		'$dept',
		'$address1',
		'$address2',
		'$city',
		'$_POST[state]',
		'$otherState',
'$zip',
		'$_POST[country]',
		'$phone',
		'$fax',
		'$_POST[shirt]',
'$special',
		'$_POST[hotelInfo]',
		'$_POST[contactInfo]',
	'$_POST[jasig]',
		'$_POST[ospi]',
	
'$amount',
'$_POST[title]',
'$transID'
)";

$result = mysql_query($register); 
        //or die(mysql_error("There was a problem with the registration form submission. Please try to submit the registration again. 
		// If you continue to have prolems, please report the problem to the 
		// <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>."));
	
	
	$user_id=mysql_insert_id(); //this is how to query the last entered auto-id entry
	
echo $user_id;



// end of the don't change part
?>