<?php
/**
* @version $Id: toolbar.menumanager.html.php,v 1.2 2005/11/08 10:26:19 eliasan Exp $
* @package Mambo
* @subpackage Menus
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Menus
*/
class TOOLBAR_menumanager {
	/**
	* Draws the menu for the Menu Manager
	*/
	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::addNewX();
		mosMenuBar::spacer();
		mosMenuBar::editListX();
		mosMenuBar::spacer();
		mosMenuBar::customX( 'copyconfirm', 'copy.png', 'copy_f2.png', 'Copy', true );
		mosMenuBar::spacer();
		mosMenuBar::customX( 'deleteconfirm', 'delete.png', 'delete_f2.png', 'Delete', true );
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.menumanager.main' );
		mosMenuBar::endTable();
	}

	/**
	* Draws the menu to delete a menu
	*/
	function _DELETE() {
		mosMenuBar::startTable();
		mosMenuBar::cancel( );
		mosMenuBar::endTable();
	}

	/**
	* Draws the menu to create a New menu
	*/
	function _NEWMENU()	{
		mosMenuBar::startTable();
		mosMenuBar::custom( 'savemenu', 'save.png', 'save_f2.png', 'Save', false );
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.menumanager.new' );
		mosMenuBar::endTable();
	}

	/**
	* Draws the menu to create a New menu
	*/
	function _COPYMENU()	{
		mosMenuBar::startTable();
		mosMenuBar::custom( 'copymenu', 'copy.png', 'copy_f2.png', 'Copy', false );
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.menumanager.copy' );
		mosMenuBar::endTable();
	}

}
?>
