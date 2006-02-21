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
// Translated by:  Joris van den Wittenboer <jwittenboer@home.nl>
// --------------------------------------------------------------------------------
// $Id: dutch.php,v 1.2 2003/11/22 19:41:03 akede Exp $
//
defined( '_VALID_MOS' ) or die( 'Directe toegang tot deze locatie is niet toegestaan.' );

// common
DEFINE('_SITEMAP_TITLE','SiteMap voor: ');
DEFINE('_SITEMAP_RESTRICTED_CONTENT', 'De inhoud is slechts voor geregistreerde gebruikers');
DEFINE('_SITEMAP_EXTERNAL_CONTENT', 'Externe weblink');

DEFINE('_SITEMAP_YES', 'Ja');
DEFINE('_SITEMAP_NO', 'Nee');

// administration
DEFINE('_SITEMAP_ADMIN_BASEDON', "De map moet aangemaakt worden gebaseerd op wat?");
DEFINE('_SITEMAP_ADMIN_MAINMENU', "Structuur van het hoofdmenu:");
DEFINE('_SITEMAP_ADMIN_MAINMENU_HELP', "Het is niet gemakkelijk zonder enige referentie - dus heb ik besloten dat het zo moet.");
DEFINE('_SITEMAP_ADMIN_SUBMENU', "Laat sub-menu's zien:");
DEFINE('_SITEMAP_ADMIN_SUBMENU_HELP', "Gebruik de gehele hierarchie van uw menustructuur?");
DEFINE('_SITEMAP_ADMIN_PUBLISHED', "Alleen gepubliceerde inhoud:");
DEFINE('_SITEMAP_ADMIN_PUBLISHED_HELP', "Laat alleen de menu-items zien die gepubliceerd zijn.");


DEFINE('_SITEMAP_ADMIN_LAYOUT', "Hoe moet uw lay-out eruitzien?");
DEFINE('_SITEMAP_ADMIN_NUMCOLS', "Aantal kolommen:");
DEFINE('_SITEMAP_ADMIN_NUMCOLS_HELP', "Het aantal kolommen voor uw lay-out.");
DEFINE('_SITEMAP_ADMIN_STYLE_MAINMENU', "De stijl voor de hoofdmenu's:");
DEFINE('_SITEMAP_ADMIN_STYLE_MAINMENU_HELP', "De css stijl voor de td en anker-tag van de hoofdmenu's");
DEFINE('_SITEMAP_ADMIN_STYLE_SUBMENU', "Stijl voor uw submenu's:");
DEFINE('_SITEMAP_ADMIN_STYLE_SUBMENU_HELP', "De css stijl voor de td-tag van alle submenu's");
DEFINE('_SITEMAP_ADMIN_STYLE_ANCHOR', "Stijl voor de anker-tag:");
DEFINE('_SITEMAP_ADMIN_STYLE_ANCHOR_HELP', "De css stijl voor de anker-tag van uw links.");

DEFINE('_SITEMAP_ADMIN_ICONS', "Iconen welkom?");
DEFINE('_SITEMAP_ADMIN_ICON_REGISTERED', "Icoon voor geregistreerde pagina's:");
DEFINE('_SITEMAP_ADMIN_ICON_REGISTERED_HELP', "Laat een slot zien achter alle pagina's voor geregistreerde gebruikers. De pagina zal sowieso worden getoond indien de gebruiker toestemming heeft ;-).");
DEFINE('_SITEMAP_ADMIN_ICON_URL', "Icoon voor externe linken:");
DEFINE('_SITEMAP_ADMIN_ICON_URL_HELP', "Een aardbol voor alle externe URL-adressen.");
?> 