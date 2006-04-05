<?php
/**
* @version $Id: toolbar.menus.php,v 1.3 2005/11/11 10:07:35 eliasan Exp $
* @package Mambo
* @subpackage Menus
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );
require_once( $mainframe->getPath( 'toolbar_default' ) );

switch ($task) {
	case 'new':
		TOOLBAR_menus::_NEW();
		break;

	case 'movemenu':
		TOOLBAR_menus::_MOVEMENU();
		break;

	case 'copymenu':
		TOOLBAR_menus::_COPYMENU();
		break;

	case 'edit':
		$cid 	= mosGetParam( $_POST, 'cid', array(0) );
		if (!is_array( $cid )) {
			$cid = array(0);
		}
		$path 	= $mosConfig_absolute_path .'/administrator/components/com_menus/';	

		if ( $cid[0] ) {
			$query = "SELECT type FROM #__menu WHERE id = $cid[0]";
			$database->setQuery( $query );
			$type = $database->loadResult();
			$item_path  = $path . $type .'/'. $type .'.menubar.php';
			
			if ( $type ) {
				if ( file_exists( $item_path  ) ) {
					require_once( $item_path  );
				} else {
					TOOLBAR_menus::_EDIT($type);
				}
			} else {
				echo $database->stderr();
			}
		} else {
			$type 		= mosGetParam( $_REQUEST, 'type', null );
			$item_path  = $path . $type .'/'. $type .'.menubar.php';
			
			if ( $type ) {
				if ( file_exists( $item_path ) ) {
					require_once( $item_path  );
				} else {
					TOOLBAR_menus::_EDIT($type);
				}
			} else {
				TOOLBAR_menus::_EDIT($type);
			}
		}
		break;

	default:
		$type 		= trim( mosGetParam( $_REQUEST, 'type', null ) );
		$item_path  = $path . $type .'/'. $type .'.menubar.php';
		
		if ( $type ) {
			if ( file_exists( $item_path ) ) {
				require_once( $item_path );
			} else {
				TOOLBAR_menus::_DEFAULT();
			}
		} else {
			TOOLBAR_menus::_DEFAULT();
		}
		break;
}
?>
