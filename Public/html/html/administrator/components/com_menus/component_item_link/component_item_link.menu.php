<?php
/**
* @version $Id: component_item_link.menu.php,v 1.1 2005/07/22 01:52:45 eddieajau Exp $
* @package Mambo
* @subpackage Menus
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

mosAdminMenus::menuItem( $type );

switch ( $task ) {
	case 'component_item_link':
		// this is the new item, ie, the same name as the menu `type`
		component_item_link_menu::edit( 0, $menutype, $option );
		break;

	case 'edit':
		component_item_link_menu::edit( $cid[0], $menutype, $option );
		break;

	case 'save':
	case 'apply':
		saveMenu( $option, $task );
		break;
}
?>