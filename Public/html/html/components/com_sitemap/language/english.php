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
//
// Translated by: Alex Kempkens
// --------------------------------------------------------------------------------
// $Id: english.php,v 1.2 2003/11/22 19:41:03 akede Exp $
//
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// common
DEFINE('_SITEMAP_TITLE','SiteMap for: ');
DEFINE('_SITEMAP_RESTRICTED_CONTENT', 'Content only for registered users');
DEFINE('_SITEMAP_EXTERNAL_CONTENT', 'External WebLink');

DEFINE('_SITEMAP_YES', 'Yes');
DEFINE('_SITEMAP_NO', 'No');

// administration
DEFINE('_SITEMAP_ADMIN_BASEDON', "Based on what should the map be created?");
DEFINE('_SITEMAP_ADMIN_MAINMENU', "Main menu structure:");
DEFINE('_SITEMAP_ADMIN_MAINMENU_HELP', "It's not so easy without any reference - so I decided this is a must.");
DEFINE('_SITEMAP_ADMIN_SUBMENU', "Show sub menu's:");
DEFINE('_SITEMAP_ADMIN_SUBMENU_HELP', "Include all the hierachie of your menu structure?");
DEFINE('_SITEMAP_ADMIN_PUBLISHED', "Only published content:");
DEFINE('_SITEMAP_ADMIN_PUBLISHED_HELP', "Shows only the menu items that are published.");


DEFINE('_SITEMAP_ADMIN_LAYOUT', "How should your layout look like?");
DEFINE('_SITEMAP_ADMIN_NUMCOLS', "Number of columns:");
DEFINE('_SITEMAP_ADMIN_NUMCOLS_HELP', "The number of columns for the layout.");
DEFINE('_SITEMAP_ADMIN_STYLE_MAINMENU', "Style for main menu's:");
DEFINE('_SITEMAP_ADMIN_STYLE_MAINMENU_HELP', "The css style for td and anchor tag of the main menu's");
DEFINE('_SITEMAP_ADMIN_STYLE_SUBMENU', "Style for sub menu's:");
DEFINE('_SITEMAP_ADMIN_STYLE_SUBMENU_HELP', "The css style for the td tag of all sub menu's");
DEFINE('_SITEMAP_ADMIN_STYLE_ANCHOR', "Style for anchor tag:");
DEFINE('_SITEMAP_ADMIN_STYLE_ANCHOR_HELP', "The css style for the anchor tags of your links.");

DEFINE('_SITEMAP_ADMIN_ICONS', "Some icons welcome?");
DEFINE('_SITEMAP_ADMIN_ICON_REGISTERED', "Icon for registered pages:");
DEFINE('_SITEMAP_ADMIN_ICON_REGISTERED_HELP', "Displays a lock behind all pages for registerend users. The page will be displayed if the user has the right, anyhow ;-).");
DEFINE('_SITEMAP_ADMIN_ICON_URL', "Icon for external links:");
DEFINE('_SITEMAP_ADMIN_ICON_URL_HELP', "A globe for all external URL adresses.");
?>