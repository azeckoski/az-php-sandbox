<?php
/**
* @version $Id: wrapper.menu.php,v 1.7 2005/01/23 08:28:14 stingrey Exp $
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
	case 'wrapper':
		// this is the new item, ie, the same name as the menu `type`
		wrapper_menu::edit( 0, $menutype, $option );
		break;
		
	case 'edit':
		wrapper_menu::edit( $cid[0], $menutype, $option );
		break;
		
	case 'save':
	case 'apply':
		wrapper_menu::saveMenu( $option, $task );
		break;
}
?>