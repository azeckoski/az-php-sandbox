<?php
/**
* @version $Id: login.php,v 1.1 2005/07/22 01:54:49 eddieajau Exp $
* @package Mambo
* @subpackage Users
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// load the html drawing class
require_once( $mainframe->getPath( 'front_html' ) );

global $database, $my;
global $mosConfig_live_site;

$return = mosGetParam( $_SERVER, 'REQUEST_URI', null );
$return = ampReplace( $return );

$menu = new mosMenu( $database );
$menu->load( $Itemid );
$params =& new mosParameters( $menu->params );

$params->def( 'page_title', 1 );
$params->def( 'header_login', $menu->name );
$params->def( 'header_logout', $menu->name );
$params->def( 'pageclass_sfx', '' );
$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
$params->def( 'login', $mosConfig_live_site );
$params->def( 'logout', $mosConfig_live_site );
$params->def( 'login_message', 0 );
$params->def( 'logout_message', 0 );
$params->def( 'description_login', 1 );
$params->def( 'description_logout', 1 );
$params->def( 'description_login_text', _LOGIN_DESCRIPTION );
$params->def( 'description_logout_text', _LOGOUT_DESCRIPTION );
$params->def( 'image_login', 'key.jpg' );
$params->def( 'image_logout', 'key.jpg' );
$params->def( 'image_login_align', 'right' );
$params->def( 'image_logout_align', 'right' );
$params->def( 'registration', $mainframe->getCfg( 'allowUserRegistration' ) );

$image_login = '';
$image_logout = '';
if ( $params->get( 'image_login' ) <> -1 ) {
	$image = $mosConfig_live_site .'/images/stories/'. $params->get( 'image_login' );
	$image_login = '<img src="'. $image  .'" align="'. $params->get( 'image_login_align' ) .'" hspace="10" alt="" />';
}
if ( $params->get( 'image_logout' ) <> -1 ) {
	$image = $mosConfig_live_site .'/images/stories/'. $params->get( 'image_logout' );
	$image_logout = '<img src="'. $image .'" align="'. $params->get( 'image_logout_align' ) .'" hspace="10" alt="" />';
}

if ( $my->id ) {
	loginHTML::logoutpage( $params, $image_logout );
} else {
	loginHTML::loginpage( $params, $image_login );
}

?>