<?php
/**
* @version $Id: auth.php,v 1.4 2005/01/06 01:13:25 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$basePath = dirname( __FILE__ );
$path = $basePath . '/../../configuration.php';
require( $path );

if (!defined( '_MOS_MAMBO_INCLUDED' )) {
	$path = $basePath . '/../../includes/mambo.php';
	require( $path );
}

session_name( 'mosadmin' );
session_start();
// restore some session variables
if (!isset( $my )) {
	$my = new mosUser( $database );
}

$my->id = mosGetParam( $_SESSION, 'session_user_id', '' );
$my->username = mosGetParam( $_SESSION, 'session_username', '' );
$my->usertype = mosGetParam( $_SESSION, 'session_usertype', '' );
$my->gid = mosGetParam( $_SESSION, 'session_gid', '' );

$session_id = mosGetParam( $_SESSION, 'session_id', '' );
$logintime = mosGetParam( $_SESSION, 'session_logintime', '' );

if ($session_id != md5( $my->id.$my->username.$my->usertype.$logintime )) {
	mosRedirect( "../index.php" );
	die;
}
?>