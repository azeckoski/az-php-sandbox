<?php 

require_once('../includes/mysqlconnect.php');

$firstname=addslashes($_SESSION['firstname']);
$lastname=addslashes($_SESSION['lastname']);
$email1=addslashes($_SESSION['email1']);

$p_track=addslashes($_SESSION['p_track']);
$p_format=addslashes($_SESSION['p_format']);
$p_title=addslashes($_SESSION['p_title']);
$p_abstract=addslashes($_SESSION['p_abstract']);
$p_audience=addslashes($_SESSION['p_audience']);
$p_desc=addslashes($_SESSION['p_desc']);
$p_speaker=addslashes($_SESSION['p_speaker']);
$p_URL=addslashes($_SESSION['p_URL']);
$sp_URL=addslashes($_SESSION['sp_URL']);
$bio=addslashes($_SESSION['bio']);


$dev=$_SESSION['dev'];
$faculty=$_SESSION['faculty'];
$mgr=$_SESSION['mgr'];
$sys_admin=$_SESSION['sys_admin'];
$sr_admin=$_SESSION['sr_admin'];
$ui_dev=$_SESSION['ui_dev'];
$support=$_SESSION['support'];




$demo="INSERT INTO cfp_austin_presentation VALUES (
'', 
NOW( ) ,
'Dec05', 
'$p_track', 
'$p_format',
'$p_title',
'$p_abstract',
'$p_desc',
'$p_speaker',
'$p_URL',
'$sp_URL',
'$bio',
'$firstname',
'$lastname',
'$email1', 
'$dev',
'$faculty',
'$mgr',
'$sys_admin',
'$sr_admin',
'$ui_dev',
'$support'

)";



$result = mysql_query($demo) or die(mysql_error("There was a problem with the registration form submission.
		Please try to submit the registration again. 
		 If you continue to have prolems, please report the problem to the 
		 <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>."));
		
			$user_id=mysql_insert_id(); //this is how to query the last entered auto-id entry


?>

