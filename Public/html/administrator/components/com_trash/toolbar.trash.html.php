<?php
/**
* @version $Id: toolbar.trash.html.php,v 1.2 2005/11/08 10:26:19 eliasan Exp $
* @package Mambo
* @subpackage Trash
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Trash
*/
class TOOLBAR_Trash {
	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::custom('restoreconfirm','restore.png','restore_f2.png','Restore', true);
		mosMenuBar::spacer();
		mosMenuBar::custom('deleteconfirm','delete.png','delete_f2.png','Delete', true);
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.trashmanager' );
		mosMenuBar::endTable();
	}

	function _DELETE() {
		mosMenuBar::startTable();
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}

	function _SETTINGS() {
		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

}
?>
