<?php
/**
* @version $Id: toolbar.languages.php,v 1.1 2005/07/22 01:52:34 eddieajau Exp $
* @package Mambo
* @subpackage Languages
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ($task) {

	case "edit_source":
		TOOLBAR_languages::_EDIT_SOURCE();
		break;

	default:
		TOOLBAR_languages::_DEFAULT();
		break;
}
?>