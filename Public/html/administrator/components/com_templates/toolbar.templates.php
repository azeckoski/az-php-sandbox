<?php
/**
* @version $Id: toolbar.templates.php,v 1.1 2005/07/22 01:53:31 eddieajau Exp $
* @package Mambo
* @subpackage Templates
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

$client = mosGetParam( $_REQUEST, 'client', '' );

switch ($task) {

	case "view":
		TOOLBAR_templates::_VIEW();
		break;

	case "edit_source":
		TOOLBAR_templates::_EDIT_SOURCE();
		break;

	case "edit_css":
		TOOLBAR_templates::_EDIT_CSS();
		break;

	case "assign":
		TOOLBAR_templates::_ASSIGN();
		break;

	case "positions":
		TOOLBAR_templates::_POSITIONS();
		break;

	default:
		TOOLBAR_templates::_DEFAULT($client);
		break;

}
?>
