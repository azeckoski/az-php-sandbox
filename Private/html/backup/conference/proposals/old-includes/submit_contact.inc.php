<?php

require_once('../sql/mysqlconnect.php');

	
	$firstname=addslashes($_SESSION['firstname']);
$lastname=addslashes($_SESSION['lastname']);
$email1=addslashes($_SESSION['email1']);

	
$register="INSERT INTO cfp_vancouver_contact VALUES (
'',
NOW( ) ,
'June06',
'$firstname',
'$lastname', 
'$email1',
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
''
	)";

$result = mysql_query($register) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the registration form submission.
		Please try to submit the registration again. 
		 If you continue to have prolems, please report the problem to the 
		 <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>.");


//dataqbase entry was successful - now capture this for future entries during this session
			
	$_SESSION['user_id']=mysql_insert_id(); //this is how to query the last entered auto-id entry

//echo $_SESSION['user_id'];
?>