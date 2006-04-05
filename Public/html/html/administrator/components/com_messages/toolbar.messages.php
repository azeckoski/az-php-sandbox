<?php
/**
* @version $Id: toolbar.messages.php,v 1.1 2005/07/22 01:53:17 eddieajau Exp $
* @package Mambo
* @subpackage Messages
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {

	case "view":
		TOOLBAR_messages::_VIEW();
		break;

	case "new":
	case "edit":
	case "reply":
		TOOLBAR_messages::_EDIT();
		break;

	case "config":
		TOOLBAR_messages::_CONFIG();
		break;

	default:
		TOOLBAR_messages::_DEFAULT();
		break;
}
?>