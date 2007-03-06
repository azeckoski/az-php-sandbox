<?php
/**
* @version $Id: admin.admin.php,v 1.1 2005/07/22 01:51:58 eddieajau Exp $
* @package Mambo
* @subpackage Admin
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require_once( $mainframe->getPath( 'admin_html' ) );

switch ($task) {
	
	case 'redirect':
		$goto = trim( strtolower( mosGetParam( $_REQUEST, 'link' ) ) );
		if ($goto == 'null') {
			$msg = 'There is no link associated with this item';
			mosRedirect( 'index2.php?option=com_admin&task=listcomponents', $msg );
			exit();
		}
		$goto = str_replace( "'", '', $goto );
		mosRedirect($goto);
		break;
		
	case 'listcomponents':
		HTML_admin_misc::ListComponents();
		break;
	
	case 'sysinfo':
		HTML_admin_misc::system_info( $version, $option );
		break;

	case 'help':
		HTML_admin_misc::help();
		break;

	case 'preview':
		HTML_admin_misc::preview();
		break;

	case 'preview2':
		HTML_admin_misc::preview( 1 );
		break;

	case 'cpanel':
    default:
		HTML_admin_misc::controlPanel();
		break;

}
?>