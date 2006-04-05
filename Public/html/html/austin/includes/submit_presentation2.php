<?php 

require_once('mysqlconnect.php');


$demo="INSERT INTO cfp_austin_presentation VALUES (
'', 
NOW( ) ,
'conference', 
'$_SESSION[p_track]', 
'$_SESSION[p_format]',
'$_SESSION[p_title]',
'$_SESSION[p_abstract]',
'$_SESSION[p_audience]',
'$_SESSION[p_desc]',
'$_SESSION[p_speaker]',
'$_SESSION[p_URL]',
'$_SESSION[sp_URL]',
'$_SESSION[bio]',
'$_SESSION[firstname]',
'$_SESSION[lastname]',
'$_SESSION[email1]'
)";

$result = mysql_query($demo) or die(mysql_error("error."));
		
	echo $result;
		

?>

