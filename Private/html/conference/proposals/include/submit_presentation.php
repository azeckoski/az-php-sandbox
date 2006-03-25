<?php 
//echo "VALIDATED<br /><br/>";


require_once('../sql/mysqlconnect.php');

$title=addslashes($_POST['title']);
$abstract=addslashes($_POST['abstract']);
$desc=addslashes($_POST['desc']);
$speaker=addslashes($_POST['speaker']);
$bio=addslashes($_POST['bio']);
$co_speaker=addslashes($_POST['co_speaker']);
$co_bio=addslashes($_POST['co_bio']);
$url=$_POST['url'];

$type=$_POST['type'];
$layout=$_POST['layout'];
$length=$_POST['length'];
$conflict_tues=$_POST['conflict_tues'];
$conflict_wed=$_POST['conflict_wed'];
$conflict_thurs=$_POST['conflict_thurs'];
$conflict_fri=$_POST['conflict_fri'];

if ($_POST['conflict_tues']=='1'){
	$conflict='Tues ';
}
if ($_POST['conflict_wed']=='1'){
	$conflict .='Wed ';
}
if ($_POST['conflict_thurs']=='1'){
	$conflict .='Thurs ';
}
if ($_POST['conflict_fri']=='1'){
	$conflict .='Fri ';
}

  //add presentation information into conf_proposals --all except role and topic data
$presentation_sql="INSERT INTO `conf_proposals` ( `id` , `date_created` , `date_modified` , `confID` , `users_pk` , `type` , `new_type` , `title` , `abstract` , `desc` , `speaker` , `URL` , `bio` , `layout` , `length` , `conflict` , `co_speaker` , `co_bio` , `approved` )
VALUES (
'' , NOW(), '', '$CONF_ID', '$USER_PK', '$type', '' , '$title', '$abstract', '$desc' , '$speaker', '$url', '$bio' , '$layout' , '$length', '$conflict' , '$co_speaker' , '$co_bio' , 'N'
)";


$result = mysql_query($presentation_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
		"registration form submission. Please try to submit the registration again. " .
		"If you continue to have problems, please report the problem to the " .
		"<a href='mailto:$HELP_EMAIL'>sakaiproject.org webmaster</a>." );
		
		$proposals_pk=mysql_insert_id(); //this is how to query the last entered auto-id entry



//get all audience values and add to the database
	for ($i = 1; $i <= 12; $i++) { //should be handled with an sql query in case list of roles increase
	$audience="audience_" .$i;
	if ($_POST[$audience] > 0){ // - only gets roles with values
			$audience_level=$_POST[$audience];
			$insert_audience_sql="INSERT INTO `proposals_audiences` ( `pk` , `date_created` , `date_modified` , `proposals_pk` , `roles_pk` , `choice` )
VALUES ('', NOW(), '', '$proposals_pk', '$i', '$audience_level')";
	
		$audience_result = mysql_query($insert_audience_sql) or die("Error:<br/>" . mysql_error() . "problem entering role" );
		
		
			}
			
			
			
		}
	
//get all topic values and add to the database
	for ($i = 1; $i <= 28; $i++) { //should be handled with an sql query in case list of topics increase
	$get_topic="topic_" .$i;
	if ($_POST[$get_topic] > 0){ // - only gets roles with values
			$topic_level=$_POST[$get_topic];
	$insert_topic_sql="INSERT INTO `proposals_topics` ( `pk` , `date_created` , `date_modified` , `proposals_pk` , `topics_pk` , `choice` )
	VALUES('', NOW(), '', '$proposals_pk', '$i', '$topic_level') " ;	
		
		$topic_result = mysql_query($insert_topic_sql) or die("Error:<br/>" . mysql_error() . "problem entering topic" );
		
		
			}
			
			
			
		}	
			
		
		
?>

