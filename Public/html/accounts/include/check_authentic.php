<?php
/*
 * Created on March 8, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * This checks if the user is logged in and populates the USER variable
 * This should be on every page that uses the login
 */
?>
<?php
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
			$USER_PK = -1;
		} else {
			// authenticated user
			$USER_PK = $row["users_pk"];
		}
		mysql_free_result($result);
	}

	// get the authenticated user information
	$USER = array();
	if ($USER_PK) {
		// get the authenticated user information
		$authsql = "SELECT * FROM users WHERE pk = '$USER_PK'";
		$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());
		$USER = mysql_fetch_assoc($result);
	}
?>