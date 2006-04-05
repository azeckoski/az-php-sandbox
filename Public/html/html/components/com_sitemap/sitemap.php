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
// $Id: sitemap.php,v 1.1 2003/11/12 21:30:36 akede Exp $
//
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* SiteMap frontend component
* @package sitemap
* @copyright 2003 Think Network GmbH
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @version $Revision: 1.1 $
* @author  $Author: akede $
*/
$adminPath = $mosConfig_absolute_path . '/administrator';
if (isset ($mosConfig_admin_path)) {
	$adminPath = $mosConfig_admin_path;
}

require_once($adminPath.'/components/com_sitemap/admin.sitemap.class.php');
if (file_exists('components/com_sitemap/language/'.$mosConfig_lang.'.php')) {
	include_once ('components/com_sitemap/language/'.$mosConfig_lang.'.php');
} else {
	include_once ('components/com_sitemap/language/english.php');
}
require_once( $mainframe->getPath( 'front_html' ) );


$sitemapManager = new SitemapManager($mosConfig_absolute_path, $adminPath);

HTML_sitemap::show($sitemapManager);
?>