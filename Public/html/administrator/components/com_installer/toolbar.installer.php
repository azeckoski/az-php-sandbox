<?php
/**
* @version $Id: toolbar.installer.php,v 1.4 2005/01/06 01:13:17 eddieajau Exp $
* @package Mambo
* @subpackage Installer
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ($task){
	case "new":
		TOOLBAR_installer::_NEW();
		break;

	default:
	    $element = mosGetParam( $_REQUEST, 'element', '' );
	    if ($element == 'component' || $element == 'module' || $element == 'mambot') {
			TOOLBAR_installer::_DEFAULT2();
		} else {
			TOOLBAR_installer::_DEFAULT();
		}
		break;
}
?>