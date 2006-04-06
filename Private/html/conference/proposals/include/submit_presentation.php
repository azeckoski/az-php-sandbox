<?php 
//echo "VALIDATED<br /><br/>";




$title=mysql_real_escape_string($_POST['title']);
$abstract=mysql_real_escape_string($_POST['abstract']);
$desc=mysql_real_escape_string($_POST['desc']);
$speaker=mysql_real_escape_string($_POST['speaker']);
$bio=mysql_real_escape_string($_POST['bio']);
$co_speaker=mysql_real_escape_string($_POST['co_speaker']);
$co_bio=mysql_real_escape_string($_POST['co_bio']);
$url=$_POST['url'];

$type=$_POST['type'];
$layout=$_POST['layout'];
$length=$_POST['length'];
$conflict = trim($_POST['conflict_tue'] ." ". $_POST['conflict_wed'] ." ". $_POST['conflict_thu'] ." ". $_POST['conflict_fri']);


  //add presentation information into conf_proposals --all data except role and topic data
$presentation_sql="INSERT INTO `conf_proposals` ( `confID` , `users_pk` , `type`, `title` , `abstract` , `desc` , `speaker` , `URL` , `bio` , `layout` , `length` , `conflict` , `co_speaker` , `co_bio` , `approved` )
VALUES (
'$CONF_ID', '$User->pk', '$type', '$title', '$abstract', '$desc', '$speaker', '$url', '$bio' , '$layout' , '$length', '$conflict' , '$co_speaker' , '$co_bio' , 'N'
)";


	$result = mysql_query($presentation_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
		"registration form submission. Please try to submit the registration again. " .
		"If you continue to have problems, please report the problem to the " .
		"<a href='mailto:$HELP_EMAIL'>sakaiproject.org webmaster</a>." );
		
		$proposals_pk=mysql_insert_id(); //get this proposal_pk

//get the list of audience information submitted and enter them into the proposal_audiences table
$audience_sql="select pk,role_name from roles order by role_order";
$result = mysql_query($audience_sql) or die(mysql_error());

 while($audience_items=mysql_fetch_array($result)) {
 	$audience_pk=$audience_items['pk'];
 	$audienceID="audience_" .$audience_pk;
 	if ($_POST[$audienceID] > 0){ // - only get $audience_items with values above 0
			$audience_choice=$_POST[$audienceID];
			$insert_audience_sql="INSERT INTO `proposals_audiences` ( `pk` , `date_created` ,  `proposals_pk` , `roles_pk` , `choice` )
VALUES ('', NOW(), '$proposals_pk', '$audience_pk', '$audience_choice')";

	$audience_result = mysql_query($insert_audience_sql) or die("Error:<br/>" . mysql_error() . "problem entering role" );
	
 	}
 }

	
//get topic information submitted and enter them into the proposal_topics table
	$topic_sql="select pk, topic_name from topics order by topic_order";
	$result = mysql_query($topic_sql) or die(mysql_error());

	 while($topic_items=mysql_fetch_array($result)) {
		$topic_pk=$topic_items['pk'];
		$topicID="topic_" . $topic_pk;
		if ($_POST[$topicID] > 0) { // - only get topics with values greater than 0
			$topic_choice=$_POST[$topicID];
		$insert_topic_sql="INSERT INTO `proposals_topics` ( `pk` , `date_created` , `proposals_pk` , `topics_pk` , `choice` )
		VALUES('', NOW(),  '$proposals_pk', '$topic_pk', '$topic_choice') " ;	
		
		$topic_result = mysql_query($insert_topic_sql) or die("Error:<br/>" . mysql_error() . "problem entering topic" );
		
		
			}
			
 }
 
 
		
?>

