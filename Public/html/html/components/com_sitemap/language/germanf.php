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
// $Id: germanf.php,v 1.2 2003/11/22 19:41:03 akede Exp $
//
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// common
DEFINE('_SITEMAP_TITLE','SiteMap f&uuml;r: ');
DEFINE('_SITEMAP_RESTRICTED_CONTENT', 'Content only for registered users');
DEFINE('_SITEMAP_EXTERNAL_CONTENT', 'Externer WebLink');

DEFINE('_SITEMAP_YES', 'Ja');
DEFINE('_SITEMAP_NO', 'Nein');

// administration
DEFINE('_SITEMAP_ADMIN_BASEDON', "Welche Information nutzt die SiteMap?");
DEFINE('_SITEMAP_ADMIN_MAINMENU', "Hauptmenu's anzeigen:");
DEFINE('_SITEMAP_ADMIN_MAINMENU_HELP', "Ganz ohne Referenz ist es nicht so einfach, daher ein muss.");
DEFINE('_SITEMAP_ADMIN_SUBMENU', "Submenu's anzeigen:");
DEFINE('_SITEMAP_ADMIN_SUBMENU_HELP', "Soll die weitere Hierarchie dargestellt werden?");
DEFINE('_SITEMAP_ADMIN_PUBLISHED', "Nur veröffentlichte Inhalte:");
DEFINE('_SITEMAP_ADMIN_PUBLISHED_HELP', "Zeigt nur Menüeinträge an die veröffentlicht sind.");

DEFINE('_SITEMAP_ADMIN_LAYOUT', "Wie soll das Layout sein?");
DEFINE('_SITEMAP_ADMIN_NUMCOLS', "Anzahl von Spalten:");
DEFINE('_SITEMAP_ADMIN_NUMCOLS_HELP', "Anzahl der Spalten in der die SiteMap dargestellt wird.");
DEFINE('_SITEMAP_ADMIN_STYLE_MAINMENU', "Style f&uuml;r Hauptmenu's:");
DEFINE('_SITEMAP_ADMIN_STYLE_MAINMENU_HELP', "Der css-style f&uuml;r td und anchor tag der Hauptmenu's");
DEFINE('_SITEMAP_ADMIN_STYLE_SUBMENU', "Style f&uuml;r Submenu's:");
DEFINE('_SITEMAP_ADMIN_STYLE_SUBMENU_HELP', "Der css-style f&uuml;r das td tag aller Submenu's");
DEFINE('_SITEMAP_ADMIN_STYLE_ANCHOR', "Style f&uuml;r anchor tags:");
DEFINE('_SITEMAP_ADMIN_STYLE_ANCHOR_HELP', "Der css-style f&uuml;r anchor tags aller links.");


DEFINE('_SITEMAP_ADMIN_ICONS', "Icons gef&auml;llig?");
DEFINE('_SITEMAP_ADMIN_ICON_REGISTERED', "Icon f&uuml;r gesch&uuml;tzte Seiten:");
DEFINE('_SITEMAP_ADMIN_ICON_REGISTERED_HELP', "Ein Schloss bei gesch&uuml;tzten Seiten. Die Links werden nur dargestellt, wenn der Benutzer &uuml;berhaupt das Recht hat diese Seite zu sehn ;-).");
DEFINE('_SITEMAP_ADMIN_ICON_URL', "Icon f&uuml;r externe Links:");
DEFINE('_SITEMAP_ADMIN_ICON_URL_HELP', "Ein Globus f&uuml;r externe Links.");
?>