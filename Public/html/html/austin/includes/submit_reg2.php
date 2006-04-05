<?php

require_once('mysqlconnect.php');
	
		$myemail=$_SESSION['email1'];
		$sql="SELECT email FROM seppConf_austin where confID='Dec05'";
		$result= mysql_query($sql);
		$resultsnumber=mysql_numrows($result);

		while($links=mysql_fetch_array($result))
		{
		$id=$links["id"]; 
		$emailadd=$links["email"];
		$first=$links["firstname"];
		if ($emailadd == $myemail) 
		$found="TRUE";
		}
//check to see if in database already 
///8am Sept 8 - this is working just fine - don't change

	if ($found) {
	//email address already entered
	 $message[]= "Your name and email have already been entered into our registration database.
	 <br />If you have any questions about your registration information please contact kreister@umich.edu.   "; 
	 }
	   
else {

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

$special=addslashes($_SESSION['special']);




$register="INSERT INTO seppConf_austin VALUES (
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
	
'fee',
'$_POST[title]'
)";

$result = mysql_query($register) or die(mysql_error("There was a problem with the registration form submission.
		Please try to submit the registration again. 
		 If you continue to have prolems, please report the problem to the 
		 <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>."));
	if ($result)
	echo"success";
	header("Location:../registration/confirmpage.php");
	

}

// end of the don't change part
?>