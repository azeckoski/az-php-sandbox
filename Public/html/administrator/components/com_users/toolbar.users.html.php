<?php
/**
* @version $Id: toolbar.users.html.php,v 1.10 2005/02/16 13:55:35 stingrey Exp $
* @package Mambo
* @subpackage Users
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Users
*/
class TOOLBAR_users {
	/**
	* Draws the menu to edit a user
	*/
	function _EDIT() {
		global $id;
		
		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::spacer();
		mosMenuBar::apply();
		mosMenuBar::spacer();
		if ( $id ) {
			// for existing content items the button is renamed `close`
			mosMenuBar::cancel( 'cancel', 'Close' );
		} else {
			mosMenuBar::cancel();
		}
		mosMenuBar::spacer();
		mosMenuBar::help( 'screen.users.edit' );
		mosMenuBar::endTable();
	}

	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::addNewX();
		mosMenuBar::spacer();
		mosMenuBar::editListX();
		mosMenuBar::spacer();
		mosMenuBar::deleteList();
		mosMenuBar::spacer();
		mosMenuBar::custom( 'logout', 'cancel.png', 'cancel_f2.png', '&nbsp;Force Logout' );
		mosMenuBar::spacer();
		mosMenuBar::help( 'screen.users' );
		mosMenuBar::endTable();
	}
}
?>