<?php
/**
* @version $Id: toolbar.modules.php,v 1.1 2005/07/22 01:53:21 eddieajau Exp $
* @package Mambo
* @subpackage Modules
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );
switch ($task) {

	case 'editA':
	case 'edit':
		$cid = mosGetParam( $_POST, 'cid', 0 );
		if ( !is_array( $cid ) ){
			$mid = mosGetParam( $_POST, 'id', 0 );;
		} else {
			$mid = $cid[0];
		}
		
		$published = 0;
		if ( $mid ) {
			$query = "SELECT published FROM #__modules WHERE id='$mid'";
			$database->setQuery( $query );
			$published = $database->loadResult();
		}
		$cur_template = $mainframe->getTemplate();
		TOOLBAR_modules::_EDIT( $cur_template, $published );
		break;

	case 'new':
		TOOLBAR_modules::_NEW();
		break;

	default:
		TOOLBAR_modules::_DEFAULT();
		break;
}
?>