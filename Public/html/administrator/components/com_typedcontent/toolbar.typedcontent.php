<?php
/**
* @version $Id: toolbar.typedcontent.php,v 1.6 2005/01/09 12:53:18 stingrey Exp $
* @package Mambo
* @subpackage Content
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
		TOOLBAR_typedcontent::_EDIT( );
		break;

	default:
		TOOLBAR_typedcontent::_DEFAULT();
		break;
}
?>