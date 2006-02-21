<?php
/**
* @version $Id: toolbar.massmail.html.php,v 1.6 2005/02/16 05:14:52 kochp Exp $
* @package Mambo
* @subpackage Massmail
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Massmail
*/
class TOOLBAR_massmail {
	/**
	* Draws the menu for a New Contact
	*/
	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::custom('send','publish.png','publish_f2.png','Send Mail',false);
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::help( 'screen.users.massmail' );
		mosMenuBar::endTable();
	}
}
?>