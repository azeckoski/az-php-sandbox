<?php 


$title=addslashes($_POST['title']);
$abstract=addslashes($_POST['abstract']);
$speaker=addslashes($_POST['speaker']);
$url=addslashes($_POST['url']);
$co_speaker=addslashes($_POST['co_speaker']);

$demo_sql="INSERT INTO `conf_proposals` (`date_created` , `confID` , `users_pk` , `type` ,  `title` , `abstract` ,  `speaker` , `URL` , `co_speaker` ,  `approved` )
VALUES ( NOW() , '$CONF_ID', '$User->pk', 'demo', '$title', '$abstract' , '$speaker', '$url' , '$co_speaker', 'N')";



$result = mysql_query($demo_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
		"registration form submission. Please try to submit the registration again. " .
		"If you continue to have problems, please report the problem to the " .
		"<a href='mailto:$HELP_EMAIL'>sakaiproject.org webmaster</a>." );
		
		$demo_pk=mysql_insert_id(); //this is how to query the last entered auto-id entry

?>

