<?php

// Comment this out if the server is different from the one for accounts
require_once ("$ACCOUNTS_PATH/mysqlconnect.php");

// Sakai Web mySQL server
// Uncomment these if the server is not the same as the one for accounts
/**/
$dbhost = "localhost";
$dbname = "sakaiweb";
$dbuser = "sakaiwww";
$dbpass = "5aka1w3b";
/**/

// connect to the DB
// Uncomment these if the server is not the same as the one for accounts
/**
$db = mysql_connect("$dbhost", "$dbuser", "$dbpass");
if (!$db) {
   die("Unable to connect to DB ($dbhost): " . mysql_error());
}
if (!mysql_select_db("$dbname", $db)) {
   die("Unable to select $dbname: " . mysql_error());
}
**/

?>
