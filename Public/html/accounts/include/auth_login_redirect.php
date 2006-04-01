<?php
/*
 * Created on Mar 8, 2006 8:26:54 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * This will redirect the user to the login screen if they are not logged in
 */
?>
<?php
if( $User->pk <= 0 ) {
	// no user_pk, user not authenticated
	// redirect to the login page
	if ($AUTH_MESSAGE) {
		$AUTH_MESSAGE = "&msg=".urlencode($AUTH_MESSAGE);
	}
	header('location:'.$ACCOUNTS_URL.'/login.php?ref='.$_SERVER['PHP_SELF'].$AUTH_MESSAGE);
	exit;
}
?>