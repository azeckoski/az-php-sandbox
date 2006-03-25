<?php 

require_once('../sql/mysqlconnect.php');


$title=addslashes($_POST['title']);
$abstract=addslashes($_POST['abstract']);
$speaker=addslashes($_POST['speaker']);
$url=addslashes($_POST['url']);

$demo_sql="INSERT INTO `conf_proposals` ( `id` , `date_created` , `date_modified` , `confID` , `users_pk` , `type` , `new_type` , `title` , `abstract` , `desc` , `speaker` , `URL` , `bio` , `layout` , `length` , `conflict` , `co_speaker` , `co_bio` , `approved` )
VALUES (
'' , NOW(), '', '$CONF_ID', '$USER_PK', 'demo', '' , '$title', '$abstract', '' , '$speaker', '$url', '' , '' , '', '' , '' , '' , 'N'
)";



$result = mysql_query($demo_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
		"registration form submission. Please try to submit the registration again. " .
		"If you continue to have problems, please report the problem to the " .
		"<a href='mailto:$HELP_EMAIL'>sakaiproject.org webmaster</a>." );
		
		$demo_id=mysql_insert_id(); //this is how to query the last entered auto-id entry

?>

