<?php

// Sakai server settings
/**
$dbhost = "bengali.web.itd.umich.edu";
$dbname = "sakai_stage";
$dbuser = "sakai";
$dbpass = "mujoIII";
**/

// localhost settings
/**/
$dbhost = "localhost";
$dbname = "sakaiweb";
$dbuser = "sakaiwww";
$dbpass = "5aka1w3b";
/**/

// Creating the mySQL database
// create database sakaiweb;
// grant all privileges on sakaiweb.* to 'sakaiwww'@'localhost' identified by '5aka1w3b';
// grant all privileges on sakaiweb.* to 'sakaiwww'@'%' identified by '5aka1w3b';
// flush privileges;

// connect to the DB
$db = mysql_connect("$dbhost", "$dbuser", "$dbpass");
if (!$db) {
   die("Unable to connect to DB ($dbhost): " . mysql_error());
}
if (!mysql_select_db("$dbname", $db)) {
   die("Unable to select $dbname: " . mysql_error());
}

?>