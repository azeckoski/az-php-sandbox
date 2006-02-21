<?php
/**
* @version $Id: toolbar.checkin.html.php,v 1.5 2005/02/11 01:20:41 levis Exp $
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
		mosMenuBar::help( 'screen.checkin' );
		mosMenuBar::endTable();
	}
}
?>
