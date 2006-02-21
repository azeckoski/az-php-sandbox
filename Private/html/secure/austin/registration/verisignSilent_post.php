<?php
// Gather Silent Post data with this PHP script.
// use $_POST instead of $HTTP_POST_VARS for version PHP 4.0 or greater.
  
 if (!empty($HTTP_POST_VARS)) {
  extract($HTTP_POST_VARS);

    }
    
     if (!$_POST) {

 // No post received
// echo "No Post received\n";
 
 }
 
     if ($_POST) {
     

 // Close the file
 //fclose ($fp);



 // Print out post contents
 
   $last4cc=$_POST['USER2'];
  $transID=$_POST['PNREF'];
  $transAmount=$_POST['AMOUNT'];
  $user_id=$_POST['USER1'];


$ResultCode=$_POST['RESULT'];
$ResponseMsg=$_POST['RESPMSG'];

 $CSCMATCH=$_POST['CSCMATCH'];
 
$AVSDATA=$_POST['AVSDATA'];


    
  // Loop through post array
//  foreach ($_POST as $key => $value) {
    
//echo "Variable: $key; Value: $value\n\r\r<br />";
//  }
  
  
  //set variables for updating the registration data
    

if ($ResultCode>0){
include('index.php');  //error received so 
}

//if ($ResponseMsg='CSCDECLINED'){
//include('index.php');
//}
//if ($ResponseMsg='AVSDECLINED'){
//include('index.php');
//}




if ($ResultCode== 0){ 

//no errors
    
   require('../includes/mysqlconnect.php');
 $sql = "UPDATE seppConf_austin_ccard SET 
 datea = NOW(),
 fee='$transAmount',
 transID = '$transID' 
 WHERE id = '$user_id' LIMIT 1"; 
 
 
 $result = mysql_query($sql); 
 if ($result==1) {
//copy this information to the conference database

		$sql="SELECT * FROM seppConf_austin_ccard where id='$user_id'";
		$result= mysql_query($sql);

		while($links=mysql_fetch_array($result))
{
$firstname=$links["firstname"];
$lastname=$links["lastname"];
$badge=$links["badge"];
$email=$links["email"];
$institution=$links["institution"];
$otherInst=$links["otherInst"];
$dept=$links["dept"];
$address1=$links["address1"];
$address2=$links["address2"];
$city=$links["city"];
$state=$links["state"];
$otherstate=$links["otherState"];
$zip=$links["zip"];
$country=$links["country"];
$phone=$links["phone"];
$fax=$links["fax"];
$shirt=$links["shirt"];
$spec=$links["special"];
$hotel=$links["hotelInfo"];
$jasig=$links["jasig"];
$ospi=$links["ospi"];
$contact=$links["contactInfo"];
$fee=$links["fee"];
$title=$links["title"];

		}
		
		
$register="INSERT INTO seppConf_austin VALUES (
		'',
		NOW( ) ,
		'Dec05',
		'$firstname',
		'$lastname', 
		'$badge',
		'$email',
		'$institution',
		'$otherInst',
		'$dept',
		'$address1',
		'$address2',
		'$city',
		'$state',
		'$otherState',
		'$zip',
		'$country',
		'$phone',
		'$fax',
		'$shirt',
		'$special',
		'$hotel',
		'$contact',
		'$jasig',
		'$ospi',
		'$fee',
		'$title'
)";


$result = mysql_query($register);


//now provide a confirmation page		
		 session_start();
		 
		 
		 
		 
		 

include('index.php');


                                 include('email_confirmation.php');

                                
 }
 

 }
 }
 

  
 
 


?>