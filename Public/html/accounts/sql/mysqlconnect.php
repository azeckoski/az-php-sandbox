<?php

// mySQL server settings

if ($ENVIRONMENT == "dev") {
	// localhost settings
	$dbhost = "localhost";
	$dbname = "sakaiweb";
	$dbuser = "sakaiwww";
	$dbpass = "5aka1w3b";
} elseif ($ENVIRONMENT == "test") {
	$dbhost = "bengali.web.itd.umich.edu";
	$dbname = "sakai_stage";
	$dbuser = "sakai";
	$dbpass = "mujoIII";
} elseif ($ENVIRONMENT == "prod") {
	$dbhost = "bengali.web.itd.umich.edu";
	$dbname = "sakai";
	$dbuser = "sakai";
	$dbpass = "mujoIII";
}

elseif ($ENVIRONMENT == "devSusan") {
	$dbhost = "localhost";
	$dbname = "sakai";
	$dbuser = "root";
	$dbpass = "mujoIII";
}

// Creating the mySQL database
// create database sakaiweb;
// grant all privileges on sakaiweb.* to 'sakaiwww'@'localhost' identified by '5aka1w3b';
// grant all privileges on sakaiweb.* to 'sakaiwww'@'%' identified by '5aka1w3b';
// flush privileges;

// System SQL functions
function get_table_rows ($table) {
       $temp = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM $table LIMIT 1");
       $result = mysql_query("SELECT FOUND_ROWS()");
       $total = mysql_fetch_row($result);
       return $total[0];
}

// connect to the DB
$db = mysql_connect("$dbhost", "$dbuser", "$dbpass");
if (!$db) {
   die("Unable to connect to DB ($dbhost): " . mysql_error());
}
if (!mysql_select_db("$dbname", $db)) {
   die("Unable to select $dbname: " . mysql_error());
}

?>