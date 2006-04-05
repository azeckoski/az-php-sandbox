<?php
/**
* @version $Id: toolbar.poll.php,v 1.1 2005/07/22 01:53:21 eddieajau Exp $
* @package Mambo
* @subpackage Polls
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ($task) {
	case 'new':
		TOOLBAR_poll::_NEW();
		break;

	case 'edit':
		$cid = mosGetParam( $_REQUEST, 'cid', array(0) );
		if (!is_array( $cid )) {
			$cid = array(0);
		}

		$database->setQuery( "SELECT published FROM #__polls WHERE id='$cid[0]'" );
		$published = $database->loadResult();

		$cur_template = $mainframe->getTemplate();
		
		TOOLBAR_poll::_EDIT( $cid[0], $cur_template );
		break;

	case 'editA':
		$id = mosGetParam( $_REQUEST, 'id', 0 );
		
		$database->setQuery( "SELECT published FROM #__polls WHERE id='$id'" );
		$published = $database->loadResult();

		$cur_template = $mainframe->getTemplate();
		
		TOOLBAR_poll::_EDIT( $id, $cur_template );
		break;

	default:
		TOOLBAR_poll::_DEFAULT();
		break;
}
?>