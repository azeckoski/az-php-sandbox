<?php


require_once('../sql/mysqlconnect.php');



$u_title=addslashes($_SESSION['title']);
$u_inst=addslashes($_SESSION['institution']);
$u_otherIns=addslashes($_SESSION['institution']);
$u_dept=addslashes($_SESSION['dept']);
$u_address1=addslashes($_SESSION['address1']);
$u_address2=addslashes($_SESSION['address2']);
$u_city=addslashes($_SESSION['city']);
$u_state=addslashes($_SESSION['state']);
$u_otherState=addslashes($_SESSION['otherState']);
$u_zip=addslashes($_SESSION['zip']);
$u_country=addslashes($_SESSION['country']);
$u_phone=addslashes($_SESSION['phone']);
$u_fax=addslashes($_SESSION['fax']);

//recall the current user id

 $sql = "UPDATE `cfp_vancouver_contact` SET 
 `title`='$u_title',
 `institution`='$u_inst',
 `institution`='$u_institution',
 `dept`='$u_dept',
 `address1`='$u_address1',
 `address2`='$u_address2',
 `city`='$u_city',
 `state`='$u_state',
 `otherState`='$u_otherState',
 `zip`='$u_zip',
 `country`='$u_country',
 `phone`='$u_phone',
 `fax`='$u_fax'
 
  
 WHERE `id`='$user_id'"; 
 
 
 $result = mysql_query($sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the registration form submission.
		Please try to submit the registration again. 
		 If you continue to have prolems, please report the problem to the 
		 <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>.");

		if ($result)
//		echo "success";

?>