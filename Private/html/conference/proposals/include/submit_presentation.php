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
$track=$_POST['track'];
$dev=$_POST['audience_0'];
$ui_dev=$_POST['audience_1'];
$support=$_POST['audience_2'];
$faculty=$_POST['audience_3'];
$faculty_dev=$_POST['audience_4'];
$librarians=$_POST['audience_5'];
$implementors=$_POST['audience_6'];
$instruct_dev=$_POST['audience_7'];
$instruct_tech=$_POST['audience_8'];

$managers=$_POST['audience_9'];
$sys_admin=$_POST['audience_10'];
$univ_admin=$_POST['audience_11'];
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

  
//  for ($i = 0; $i <= 27; $i++) {
//$topic="topic_" .$i;

//$topic=$_POST[$topic];
//}
  //TO DO figure out how to enter topic data into new table
  
  $topics=$_POST['topic_0'] .$_POST['topic_1'] .$_POST['topic_2'] 
  .$_POST['topic_3']  .$_POST['topic_4']  .$_POST['topic_5']  
   .$_POST['topic_6']  .$_POST['topic_7']  .$_POST['topic_8'] 
     .$_POST['topic_9']  .$_POST['topic_10']  .$_POST['topic_11'] 
      .$_POST['topic_12']  .$_POST['topic_13']  .$_POST['topic_14'] 
       .$_POST['topic_15']  .$_POST['topic_16']  .$_POST['topic_17'] 
       .$_POST['topic_18']  .$_POST['topic_19']  .$_POST['topic_20'] 
        .$_POST['topic_21']  .$_POST['topic_22']  .$_POST['topic_23'] 
         .$_POST['topic_24']  .$_POST['topic_25']  .$_POST['topic_26'] 
          .$_POST['topic_27'] ;


// TO DO  add librarian entry in database then add below
$presentation_sql="INSERT INTO `conf_proposals` ( `id` , `date_created` , `date_modified` , `confID` , `users_pk` , `type` , `new_type` , `title` , `abstract` , `desc` , `speaker` , `URL` , `bio` , `layout` , `length` , `conflict` , `co_speaker` , `co_bio` , `approved` )
VALUES (
'' , NOW(), '', '$CONF_ID', '$USER_PK', '$type', '' , '$title', '$abstract', '$desc' , '$speaker', '$url', '$bio' , '$layout' , '$length', '$conflict' , '$co_speaker' , '$co_bio' , 'N'
)";


$result = mysql_query($presentation_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
		"registration form submission. Please try to submit the registration again. " .
		"If you continue to have problems, please report the problem to the " .
		"<a href='mailto:$HELP_EMAIL'>sakaiproject.org webmaster</a>." );
		
		$presentation_id=mysql_insert_id(); //this is how to query the last entered auto-id entry

?>

