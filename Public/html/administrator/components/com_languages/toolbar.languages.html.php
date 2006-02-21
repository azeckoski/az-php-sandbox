<?php
/**
* @version $Id: toolbar.languages.html.php,v 1.7 2005/02/16 05:14:52 kochp Exp $
* @package Mambo
* @subpackage Languages
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Languages
*/
class TOOLBAR_languages {
	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::publishList();
		mosMenuBar::spacer();
		mosMenuBar::addNew();
		mosMenuBar::spacer();
		mosMenuBar::editListX( 'edit_source' );
		mosMenuBar::spacer();
		mosMenuBar::deleteList();
		mosMenuBar::spacer();
		mosMenuBar::help( 'screen.languages' );
		mosMenuBar::endTable();
	}
	function _NEW() {
		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}

	function _EDIT_SOURCE(){
		mosMenuBar::startTable();
		mosMenuBar::save( 'save_source' );
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}

}
?>