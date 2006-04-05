<?php
/**
* @version $Id: toolbar.syndicate.php,v 1.1 2005/07/22 01:53:28 eddieajau Exp $
* @package Mambo
* @subpackage Syndicate
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {
	default:
		TOOLBAR_syndicate::_DEFAULT();
		break;
}
?>