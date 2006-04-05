<?php
/**
* @version $Id: index.php,v 1.6 2005/11/21 11:57:50 csouza Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

// fix to address the globals overwrite problem in php versions < 4.4.1
$protect_globals = array('_REQUEST', '_GET', '_POST', '_COOKIE', '_FILES', '_SERVER', '_ENV', 'GLOBALS', '_SESSION');
foreach ($protect_globals as $global) {
    if ( in_array($global , array_keys($_REQUEST)) ||
         in_array($global , array_keys($_GET))     ||
         in_array($global , array_keys($_POST))    ||
         in_array($global , array_keys($_COOKIE))  ||
         in_array($global , array_keys($_FILES))) {
        die("Invalid Request.");
    }
}

/** Set flag that this is a parent file */
define( "_VALID_MOS", 1 );

if (!file_exists( '../configuration.php' )) {
	header( 'Location: ../installation/index.php' );
	exit();
}

require_once( '../configuration.php' );
require_once( '../includes/mambo.php' );
include_once ( $mosConfig_absolute_path .'/language/'. $mosConfig_lang .'.php' );
$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );
$acl = new gacl_api();

$option = mosGetParam( $_REQUEST, 'option', NULL );

// mainframe is an API workhorse, lots of 'core' interaction routines
$mainframe = new mosMainFrame( $database, $option, '..', true );

if (isset( $_POST['submit'] )) {
	/** escape and trim to minimise injection of malicious sql */
	$usrname 	= $database->getEscaped( trim( mosGetParam( $_POST, 'usrname', '' ) ) );
	$pass 		= $database->getEscaped( trim( mosGetParam( $_POST, 'pass', '' ) ) );

	if (!$pass) {
		echo "<script>alert('Please enter a password'); document.location.href='index.php';</script>\n";
	} else {
		$pass = md5( $pass );
	}

	$query = "SELECT COUNT(*)"
	. "\n FROM #__users"
	. "\n WHERE ( LOWER( usertype ) = 'administrator'"
	. "\n OR LOWER( usertype ) = 'superadministrator'"
	. "\n OR LOWER( usertype ) = 'super administrator' )"
	;
	$database->setQuery( $query );
	$count = intval( $database->loadResult() );
	if ($count < 1) {
		echo "<script>alert(\""._LOGIN_NOADMINS."\"); window.history.go(-1); </script>\n";
		exit();
	}

	$query = "SELECT * FROM #__users WHERE username='$usrname' AND block='0'";
	$database->setQuery( $query );
	$my = null;
	$database->loadObject( $my );

	/** find the user group (or groups in the future) */
	if (@$my->id) {
		$grp 			= $acl->getAroGroup( $my->id );
		$my->gid 		= $grp->group_id;
		$my->usertype 	= $grp->name;

		if (strcmp( $my->password, $pass )
		|| !$acl->acl_check( 'administration', 'login', 'users', $my->usertype )) {
			echo "<script>alert('Incorrect Username, Password, or Access Level.  Please try again'); document.location.href='index.php';</script>\n";
			exit();
		}

		session_name( md5( $mosConfig_live_site ) );
		session_start();

		$logintime 	= time();
		$session_id = md5( "$my->id$my->username$my->usertype$logintime" );
		$query = "INSERT INTO #__session"
		. "\nSET time='$logintime', session_id='$session_id', "
		. "userid='$my->id', usertype='$my->usertype', username='$my->username'"
		;
		$database->setQuery( $query );
		if (!$database->query()) {
			echo $database->stderr();
		}

		$_SESSION['session_id'] 		= $session_id;
		$_SESSION['session_user_id'] 	= $my->id;
		$_SESSION['session_username'] 	= $my->username;
		$_SESSION['session_usertype'] 	= $my->usertype;
		$_SESSION['session_gid'] 		= $my->gid;
		$_SESSION['session_logintime'] 	= $logintime;
		$_SESSION['session_userstate'] 	= array();

		session_write_close();
		/** cannot using mosredirect as this stuffs up the cookie in IIS */
		echo "<script>document.location.href='index2.php';</script>\n";
		exit();
	} else {
		echo "<script>alert('Incorrect Username and Password, please try again'); document.location.href='index.php';</script>\n";
		exit();
	}
} else {
	initGzip();
	$path = $mosConfig_absolute_path . '/administrator/templates/' . $mainframe->getTemplate() . '/login.php';
	require_once( $path );
	doGzip();
}
?>