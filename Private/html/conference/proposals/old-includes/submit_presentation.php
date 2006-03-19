<?php 
//echo "VALIDATED<br /><br/>";


require_once('../sql/mysqlconnect.php');

$firstname=addslashes($_SESSION['firstname']);
$lastname=addslashes($_SESSION['lastname']);
$email1=addslashes($_SESSION['email1']);
$p_title=addslashes($_SESSION['p_title']);
$p_abstract=addslashes($_SESSION['p_abstract']);
$p_desc=addslashes($_SESSION['p_desc']);
$p_speaker=addslashes($_SESSION['p_speaker']);
$bio=addslashes($_SESSION['bio']);
$co_speaker=addslashes($_SESSION['co_speaker']);
$co_bio=addslashes($_SESSION['co_bio']);
$p_URL=$_SESSION['p_URL'];
$p_track=$_SESSION['p_track'];
$dev=$_SESSION['audience_0'];
$ui_dev=$_SESSION['audience_1'];
$support=$_SESSION['audience_2'];
$faculty=$_SESSION['audience_3'];
$faculty_dev=$_SESSION['audience_4'];
$librarians=$_SESSION['audience_5'];
$implementors=$_SESSION['audience_6'];
$instruct_dev=$_SESSION['audience_7'];
$instruct_tech=$_SESSION['audience_8'];

$managers=$_SESSION['audience_9'];
$sys_admin=$_SESSION['audience_10'];
$univ_admin=$_SESSION['audience_11'];
$p_format=$_SESSION['p_format'];
$layout=$_SESSION['layout'];
$length=$_SESSION['length'];
$conflict_tues=$_SESSION['conflict_tues'];
$conflict_wed=$_SESSION['conflict_wed'];
$conflict_thurs=$_SESSION['conflict_thurs'];
$conflict_fri=$_SESSION['conflict_fri'];

  
//  for ($i = 0; $i <= 27; $i++) {
//$topic="topic_" .$i;

//$topic=$_SESSION[$topic];
//}
  
  
  $topics=$_SESSION['topic_0'] .$_SESSION['topic_1'] .$_SESSION['topic_2'] 
  .$_SESSION['topic_3']  .$_SESSION['topic_4']  .$_SESSION['topic_5']  
   .$_SESSION['topic_6']  .$_SESSION['topic_7']  .$_SESSION['topic_8'] 
     .$_SESSION['topic_9']  .$_SESSION['topic_10']  .$_SESSION['topic_11'] 
      .$_SESSION['topic_12']  .$_SESSION['topic_13']  .$_SESSION['topic_14'] 
       .$_SESSION['topic_15']  .$_SESSION['topic_16']  .$_SESSION['topic_17'] 
       .$_SESSION['topic_18']  .$_SESSION['topic_19']  .$_SESSION['topic_20'] 
        .$_SESSION['topic_21']  .$_SESSION['topic_22']  .$_SESSION['topic_23'] 
         .$_SESSION['topic_24']  .$_SESSION['topic_25']  .$_SESSION['topic_26'] 
          .$_SESSION['topic_27'] ;


// TO DO  add librarian entry in database then add below
$demo="INSERT INTO cfp_vancouver_presentation VALUES (
'', 
NOW( ) ,
'June06', 
'0', 
'$topics',
'$p_format',
'$p_title',
'$p_abstract',
'$p_desc',
'$p_speaker',
'$p_URL',
'$bio',
'$firstname',
'$lastname',
'$email1', 
'$dev',
'$faculty',
'$managers',
'$librarians',
'$sys_admin',
'$univ_admin',
'$ui_dev',
'$support',
'$faculty_dev',
'$implementors',
'$instruct_dev',
'$instruct_tech',
'$layout', 
'$length', 
'$conflict_tues', 
'$conflict_wed', 
'$conflict_thurs', 
'$conflict_fri', 
'$co_speaker', 
'$co_bio',
'$approved'

)";

$result = mysql_query($demo) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
		"registration form submission. Please try to submit the registration again. " .
		"If you continue to have prolems, please report the problem to the " .
		"<a href='mailto:$HELP_EMAIL'>sakaiproject.org webmaster</a>." );
		
		$presentation_id=mysql_insert_id(); //this is how to query the last entered auto-id entry

?>

