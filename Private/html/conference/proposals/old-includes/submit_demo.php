<?php 

require_once('../sql/mysqlconnect.php');


$product=addslashes($_SESSION['product']);
$demo_desc=addslashes($_SESSION['demo_desc']);
$Dspeaker=addslashes($_SESSION['Dspeaker']);
$demo_url=addslashes($_SESSION['demo_url']);

	
$demo="INSERT INTO proposal_demo VALUES (
'',
NOW( ) ,
'$CONF_ID', 
'$USER_PK',
'$firstname',
'$lastname',
'$email',
'$product',
'$demo_desc',
'$Dspeaker',
'$demo_url'
)";

$result = mysql_query($demo) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
		"registration form submission. Please try to submit the registration again. " .
		"If you continue to have problems, please report the problem to the " .
		"<a href='mailto:$HELP_EMAIL'>sakaiproject.org webmaster</a>." );
		
		$demo_id=mysql_insert_id(); //this is how to query the last entered auto-id entry

?>

