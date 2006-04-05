<?php
/**
* @version $Id: wrapper.php,v 1.1 2005/07/22 01:55:01 eddieajau Exp $
* @package Mambo
* @subpackage Wrapper
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/** load the html drawing class */
require_once( $mainframe->getPath( 'front_html' ) );

showWrap( $option );

function showWrap( $option ) {
	global $database, $Itemid, $mainframe;

	$menu =& new mosMenu( $database );
	$menu->load( $Itemid );
	$params =& new mosParameters( $menu->params );
	$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
	$params->def( 'scrolling', 'auto' );
	$params->def( 'page_title', '1' );
	$params->def( 'pageclass_sfx', '' );
	$params->def( 'header', $menu->name );
	$params->def( 'height', '500' );
	$params->def( 'height_auto', '1' );
	$params->def( 'width', '100%' );
	$params->def( 'add', '1' );
	$url = $params->def( 'url', '' );
	
	if ( $params->get( 'add' ) ) {
		// adds 'http://' if none is set	
		if ( !strstr( $url, 'http' ) && !strstr( $url, 'https' ) ) {
			$row->url = 'http://'. $url;
		} else {
			$row->url = $url;
		}
	} else {
		$row->url = $url;
	}

	// auto height control
	if ( $params->def( 'height_auto' ) ) {
		$row->load = 'window.onload = iFrameHeight;';
	} else {
		$row->load = '';
	}

  $mainframe->SetPageTitle($menu->name);
	HTML_wrapper::displayWrap( $row, $params, $menu );
}

?>
