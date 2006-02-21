<?php
/**
* @version $Id: toolbar.weblinks.php,v 1.5 2005/02/11 11:10:54 stingrey Exp $
* @package Mambo
* @subpackage Weblinks
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ($task) {
	case 'new':
	case 'edit':
	case 'editA':
		TOOLBAR_weblinks::_EDIT();
		break;

	default:
		TOOLBAR_weblinks::_DEFAULT();
		break;
}
?>