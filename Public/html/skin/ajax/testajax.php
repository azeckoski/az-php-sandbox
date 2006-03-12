<?php
/*
 * file: testajax.php
 * Created on Mar 11, 2006 1:31:38 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?
require_once $_SERVER["DOCUMENT_ROOT"].'/skin/include/tool_vars.php';

// connect to database
require $_SERVER["DOCUMENT_ROOT"].$TOOL_PATH.'/sql/mysqlconnect.php';

writeLog($TOOL_SHORT,"az","testing...");

//define variables
$field = trim($_REQUEST['field']);
$userfield = trim($_REQUEST['userfield']);
$emailfield = trim($_REQUEST['emailfield']);
$output = "";

if($field == "userfield"){
    $query = "SELECT * FROM users WHERE username = '".$userfield."'";
    $result = mysql_query($query) or die ("<h2>Could not select user</h2>".mysql_error());
    $num = mysql_num_rows($result);

	writeLog($TOOL_SHORT,"az","validating $userfield...");
    
    if($num !=0){
        $output = "userfield|That username is taken, try another.";
    }else{
        $output = "userfield|!error";
    }
}elseif($field == "emailfield"){
    $query = "SELECT * FROM users WHERE email = '".$emailfield."'";
    $result = mysql_query($query) or die ("<h2>Could not select email address</h2>".mysql_error());
    $num = mysql_num_rows($result);
    
    if($num !=0){
        $output = "emailfield|That email address is taken, try another.";
    }else{
        $output = "emailfield|!error";
    }
}

echo $output;

?> 