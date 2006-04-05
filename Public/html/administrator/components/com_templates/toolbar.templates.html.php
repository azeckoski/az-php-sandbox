<?php
/**
* @version $Id: toolbar.templates.html.php,v 1.2 2005/11/08 10:26:19 eliasan Exp $
* @package Mambo
* @subpackage Templates
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Templates
*/
class TOOLBAR_templates {
	function _DEFAULT($client) {
		mosMenuBar::startTable();
		if ($client=="admin") {
			mosMenuBar::custom('publish', 'publish.png', 'publish_f2.png', 'Default', true);
			mosMenuBar::spacer();
		} else {
			mosMenuBar::makeDefault();
			mosMenuBar::spacer();
			mosMenuBar::assign();
			mosMenuBar::spacer();
		}
		mosMenuBar::addNew();
		mosMenuBar::spacer();
		mosMenuBar::editHtmlX( 'edit_source' );
		mosMenuBar::spacer();
		mosMenuBar::editCssX( 'edit_css' );
		mosMenuBar::spacer();
		mosMenuBar::deleteList();
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.templates.main' );
		mosMenuBar::endTable();
	}
 	function _VIEW(){
		mosMenuBar::startTable();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	function _EDIT_SOURCE(){
		mosMenuBar::startTable();
		mosMenuBar::save( 'save_source' );
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.templates.edithtml' );
		mosMenuBar::endTable();
	}

	function _EDIT_CSS(){
		mosMenuBar::startTable();
		mosMenuBar::save( 'save_css' );
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.templates.editcss' );
		mosMenuBar::endTable();
	}

	function _ASSIGN(){
		mosMenuBar::startTable();
		mosMenuBar::save( 'save_assign', 'Save' );
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.templates.assign' );
		mosMenuBar::endTable();
	}

	function _POSITIONS(){
		mosMenuBar::startTable();
		mosMenuBar::save( 'save_positions' );
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.templates.modules' );
		mosMenuBar::endTable();
	}
}
?>
