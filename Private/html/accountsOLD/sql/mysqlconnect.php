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
	$dbpass = "sk8t3rs";
} elseif ($ENVIRONMENT == "prod") {
	$dbhost = "bengali.web.itd.umich.edu";
	$dbname = "sakai";
	$dbuser = "sakai";
	$dbpass = "sk8t3rs";
}

elseif ($ENVIRONMENT == "devSusan") {
	$dbhost = "localhost";
	$dbname = "sakai";
	$dbuser = "root";
	$dbpass = "mujoIII";
}
elseif ($ENVIRONMENT == "sakai_web") {
	$dbhost = "bengali.web.itd.umich.edu";
	$dbname = "sakai_web";
	$dbuser = "sakai_web";
	$dbpass = "collabor8";
}
elseif ($ENVIRONMENT == "sakai_webtest") {
	$dbhost = "bengali.web.itd.umich.edu";
	$dbname = "sakai_webtest";
	$dbuser = "sakai_webtest";
	$dbpass = "testCollabor8";
}


// Creating the mySQL database
// create database sakaiweb default character set utf8;
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

// return the next auto-increment value from a table or false if this failed
function nextAutoIncrement($tablename) {
	$sql = "SHOW TABLE STATUS LIKE '$tablename'";
	$result = mysql_query($sql) or die ( "Query failed ($sql): " . mysql_error() );
	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);
	if ($row['Auto_increment']) {
		return $row['Auto_increment'];
	}
	return false;
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