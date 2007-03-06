<?php
/*
 * Created on March 8, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * This checks if the user is logged in and populates the USER variable
 * This should be on every page that uses the login
 */
?>
<?php
// NEW WAY
// Load User and Inst PROVIDERS
require $ACCOUNTS_PATH.'include/providers.php';

// create user from session if possible
$User = new User("session");

// OLD WAY
/***
// get the passkey from the cookie if it exists
$PASSKEY = $_COOKIE["SESSION_ID"];

// check the passkey
$USER_PK = 0;
if (isset($PASSKEY)) {
	$sql1 = "SELECT users_pk FROM sessions WHERE passkey = '$PASSKEY'";
	$result = mysql_query($sql1) or die('Authenticate query failed: ' . mysql_error());
	$row = mysql_fetch_assoc($result);

	if( !$result ) {
		// no valid key exists, user not authenticated
		$User->pk = -1;
	} else {
		// authenticated user
		$User->pk = $row["users_pk"];
	}
	mysql_free_result($result);
}

// get the authenticated user information
$USER = array();
if ($User->pk) {
	// get the authenticated user information
	$authsql = "SELECT * FROM users WHERE pk = '$User->pk'";
	$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());
	$USER = mysql_fetch_assoc($result);
}
******/
?>