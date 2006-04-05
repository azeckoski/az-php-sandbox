<?php
/**
* @version $Id: toolbar.trash.php,v 1.1 2005/07/22 01:53:32 eddieajau Exp $
* @package Mambo
* @subpackage Trash
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );
//require_once( $mainframe->getPath( 'toolbar_default' ) );

$act = mosGetParam( $_REQUEST, 'act', '' );
if ($act) {
	$task = $act;
}

switch ($task) {

	case "settings":
		TOOLBAR_Trash::_SETTINGS();
		break;

	case "restoreconfirm":
	case "deleteconfirm":
		TOOLBAR_Trash::_DELETE();
		break;

	default:
		TOOLBAR_Trash::_DEFAULT();
		break;
}
?>