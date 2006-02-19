<?php

// Sakai server settings
/**
$dbhost = "bengali.web.itd.umich.edu";
$dbname = "sakai_stage";
$dbuser = "sakai";
$dbpass = "mujoIII";
**/

// localhost settings
$dbhost = "localhost";
$dbname = "sakaivote";
$dbuser = "voter";
$dbpass = "3l3ct1on";

// connect to the DB
$db = mysql_connect("$dbhost", "$dbuser", "$dbpass");
if (!$db) {
   die("Unable to connect to DB ($dbhost): " . mysql_error());
}
if (!mysql_select_db("$dbname", $db)) {
   die("Unable to select $dbname: " . mysql_error());
}
?>
