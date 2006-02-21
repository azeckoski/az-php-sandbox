<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );
require_once( $mainframe->getPath( 'toolbar_default' ) );

switch ($act) {
	case "config":
		MENU_sitemap::CONFIG_MENU();
		break;
	
	case "help":
		MENU_sitemap::DEFAULT_MENU();
		break;
		
	default:
		MENU_sitemap::DEFAULT_MENU();
		break;
}
?>