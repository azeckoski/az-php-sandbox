<?php
/**
* @version $Id: toolbar.banners.html.php,v 1.9 2005/02/16 13:55:32 stingrey Exp $
* @package Mambo
* @subpackage Banners
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Banners
*/
class TOOLBAR_banners {
	/**
	* Draws the menu for to Edit a banner
	*/
	function _EDIT() {
		global $id;
		
		mosMenuBar::startTable();
		mosMenuBar::media_manager( 'banners' );
		mosMenuBar::spacer();
		mosMenuBar::save();
		mosMenuBar::spacer();
		if ( $id ) {
			// for existing content items the button is renamed `close`
			mosMenuBar::cancel( 'cancel', 'Close' );
		} else {
			mosMenuBar::cancel();
		}
		mosMenuBar::spacer();
		mosMenuBar::help( 'screen.banners.edit' );
		mosMenuBar::endTable();
	}
	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::publishList();
		mosMenuBar::unpublishList();
		mosMenuBar::media_manager( 'banners' );
		mosMenuBar::addNewX();
		mosMenuBar::editListX();
		mosMenuBar::deleteList();
		mosMenuBar::help( 'screen.banners' );
		mosMenuBar::endTable();
	}
}

/**
* @package Mambo
*/
class TOOLBAR_bannerClient {
	/**
	* Draws the menu for to Edit a client
	*/
	function _EDIT() {
		global $id;
		
		mosMenuBar::startTable();
		mosMenuBar::save( 'saveclient' );
		mosMenuBar::spacer();
		if ( $id ) {
			// for existing content items the button is renamed `close`
			mosMenuBar::cancel( 'cancelclient', 'Close' );
		} else {
			mosMenuBar::cancel( 'cancelclient' );
		}
		mosMenuBar::spacer();
		mosMenuBar::help( 'screen.banners.client.edit' );
		mosMenuBar::endTable();
	}
	/**
	* Draws the default menu
	*/
	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::addNewX( 'newclient' );
		mosMenuBar::spacer();
		mosMenuBar::editListX( 'editclient' );
		mosMenuBar::spacer();
		mosMenuBar::deleteList( '', 'removeclients' );
		mosMenuBar::spacer();
		mosMenuBar::help( 'screen.banners.client' );
		mosMenuBar::endTable();
	}
}
?>