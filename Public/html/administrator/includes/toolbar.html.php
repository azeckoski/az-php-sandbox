<?php
/**
* @version $Id: toolbar.html.php,v 1.4 2005/01/06 01:13:25 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/**
* @package Mambo
*/
class MENU_Default {
	/**
	* Draws a default set of menu icons
	*/
	function MENU_Default() {
		mosMenuBar::startTable();
		mosMenuBar::publishList();
		mosMenuBar::unpublishList();
		mosMenuBar::addNew();
		mosMenuBar::editList();
		mosMenuBar::deleteList();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
}
?>