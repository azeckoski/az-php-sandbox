<?php
/**
* @version $Id: toolbar.admin.php,v 1.1 2005/07/22 01:51:58 eddieajau Exp $
* @package Mambo
* @subpackage Admin
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ($task){
	case 'sysinfo':
		TOOLBAR_admin::_SYSINFO();
	    break;

	default:
	    if ($GLOBALS['task']) {
			TOOLBAR_admin::_DEFAULT();
		} else {
			TOOLBAR_admin::_CPANEL();
		}
		break;
}
?>