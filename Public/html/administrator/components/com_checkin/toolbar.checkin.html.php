<?php
/**
* @version $Id: toolbar.checkin.html.php,v 1.2 2005/11/08 10:26:19 eliasan Exp $
* @package Mambo
* @subpackage Checkin
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/**
* @package Mambo
* @subpackage Checkin
*/
class TOOLBAR_checkin {
	/**
	* Draws the menu for a New category
	*/
	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::help( '453.screen.checkin' );
		mosMenuBar::endTable();
	}
}
?>
