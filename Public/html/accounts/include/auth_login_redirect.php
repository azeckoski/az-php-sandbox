<?php
/*
 * Created on Mar 8, 2006 8:26:54 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * This will redirect the user to the login screen if they are not logged in
 */
?>
<?php
if( $USER_PK <= 0 ) {
	// no user_pk, user not authenticated
	// redirect to the login page
	header('location:'.$ACCOUNTS_URL.'/login.php?ref='.$_SERVER['PHP_SELF']);
	exit;
}
?>