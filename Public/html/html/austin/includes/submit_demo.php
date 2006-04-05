<?php 

require_once('mysqlconnect.php');


$firstname=addslashes($_SESSION['firstname']);
$lastname=addslashes($_SESSION['lastname']);
$email=addslashes($_SESSION['email1']);
$product=addslashes($_SESSION['product']);
$demo_desc=addslashes($_SESSION['demo_desc']);
$Dspeaker=addslashes($_SESSION['Dspeaker']);
$demo_url=addslashes($_SESSION['demo_url']);

	
$demo="INSERT INTO cfp_austin_demo VALUES (
'',
NOW( ) ,
'Dec05',
'$firstname',
'$lastname',
'$email',
'$product',
'$demo_desc',
'$Dspeaker',
'$demo_url'
)";

$result = mysql_query($demo) or die(mysql_error("There was a problem with the registration form submission.
		Please try to submit the registration again. 
		 If you continue to have prolems, please report the problem to the 
		 <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>."));
		
		
			$user_id=mysql_insert_id(); //this is how to query the last entered auto-id entry

?>

