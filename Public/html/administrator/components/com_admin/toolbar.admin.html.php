<?php
/**
* @version $Id: toolbar.admin.html.php,v 1.5 2005/02/11 01:19:32 levis Exp $
* @package Mambo
* @subpackage Admin
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/**
* @package Mambo
* @subpackage Admin
*/
class TOOLBAR_admin {
	function _SYSINFO() {
		mosMenuBar::startTable();
		mosMenuBar::help( 'screen.system.info' );
		mosMenuBar::endTable();
	}
	/**
	* Draws the menu for a New category
	*/
	function _CPANEL() {
		mosMenuBar::startTable();
		mosMenuBar::help( 'screen.cpanel' );
		mosMenuBar::endTable();
	}
	/**
	* Draws the menu for a New category
	*/
	function _DEFAULT() {
		mosMenuBar::startTable();
		//mosMenuBar::help( 'screen.cpanel' );
		mosMenuBar::endTable();
	}
}
?>
