<?php
// Site map component for Mambo Open Server version 4.5
// Copyright (C) 2003 Think Network GmbH
// All rights reserved
//
// This source file is part of the SiteMap component written as a
// component for Mambo Open Server. For further details please
// visit www.mamboserver.com
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
// --------------------------------------------------------------------------------
// $Id: admin.sitemap.php,v 1.1 2003/11/12 21:30:36 akede Exp $
//
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'admin_html' ) );

$adminPath = $mosConfig_absolute_path . '/administrator';
if (isset ($mosConfig_admin_path)) {
	$adminPath = $mosConfig_admin_path;
}
require_once("$adminPath/components/com_sitemap/admin.sitemap.class.php");
$sitemapManager = new SitemapManager($mosConfig_absolute_path, $adminPath);

if (file_exists("$mosConfig_absolute_path/components/com_sitemap/language/$mosConfig_lang.php")) {
	include_once ("$mosConfig_absolute_path/components/com_sitemap/language/$mosConfig_lang.php");
} else {
	include_once ("$mosConfig_absolute_path/components/com_sitemap/language/english.php");
}


switch($act) {
	case "config":
		if($task=='saveedit') {
			$sitemapManager->setCfg( 'numColumns' , $sitemap_numColumns );
			$sitemapManager->setCfg( 'showSubmenus' , $sitemap_showSubmenus );
			$sitemapManager->setCfg( 'showSections' , $sitemap_showSections );
			$sitemapManager->setCfg( 'showCategories' , $sitemap_showCategories );
			$sitemapManager->setCfg( 'showContent' , $sitemap_showContent );
			$sitemapManager->setCfg( 'showPublishedContent' , $sitemap_showPublishedContent );
			$sitemapManager->setCfg( 'showRestrictedIcon' , $sitemap_showRestrictedIcon );
			$sitemapManager->setCfg( 'showURLIcon' , $sitemap_showURLIcon );
			$sitemapManager->setCfg( 'styleMainmenu' , $sitemap_styleMainmenu );
			$sitemapManager->setCfg( 'styleSubmenu' , $sitemap_styleSubmenu );
			$sitemapManager->setCfg( 'styleAnchorTag' , $sitemap_styleAnchorTag );
			
		    $sitemapManager->saveConfiguration ($adminPath);
		}
		
		HTML_sitemap::showConfiguration( $option, $sitemapManager );
		break;
	
	case "help":
		HTML_sitemap::showHelp( $option, $sitemapManager );
		break;
	
	default:
		HTML_sitemap::showWelcome( $option, $sitemapManager );
		break;
}

