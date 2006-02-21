<?php
/**
* @version $Id: separator.menu.php,v 1.6 2005/01/14 08:03:45 stingrey Exp $
* @package Mambo
* @subpackage Menus
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

mosAdminMenus::menuItem( $type );

switch ($task) {
	case 'separator':
		// this is the new item, ie, the same name as the menu `type`
		separator_menu::edit( 0, $menutype, $option );
		break;

	case 'edit':
		separator_menu::edit( $cid[0], $menutype, $option );
		break;

	case 'save':
	case 'apply':
		saveMenu( $option, $task );
		break;
}
?>
