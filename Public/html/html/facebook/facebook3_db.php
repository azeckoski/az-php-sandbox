<?php
$dbhost = "bengali.web.itd.umich.edu";

$dbname = "sakai_stage";

$dbuser = "sakai";
$dbpass = "mujoIII"; 


$db = mysql_connect("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname",$db);
?>
