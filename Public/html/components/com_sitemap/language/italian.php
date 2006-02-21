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
// Translated by:  Giovanni Rezzoli <giorez@libero.it>
// --------------------------------------------------------------------------------
// $Id: italian.php,v 1.2 2003/11/22 19:41:03 akede Exp $
//
defined( '_VALID_MOS' ) or die( 'L\'accesso diretto a questa sezione non &egrave; consentito.' );

// common
DEFINE('_SITEMAP_TITLE','SiteMap per: ');
DEFINE('_SITEMAP_RESTRICTED_CONTENT', 'Contenuto solo per gli utenti registrati');
DEFINE('_SITEMAP_EXTERNAL_CONTENT', 'WebLink Esterno');

DEFINE('_SITEMAP_YES', 'Si');
DEFINE('_SITEMAP_NO', 'No');

// administration
DEFINE('_SITEMAP_ADMIN_BASEDON', "Sulla base di che cosa dovrebbe essere generata la mappa?");
DEFINE('_SITEMAP_ADMIN_MAINMENU', "Struttura principale del menu:");
DEFINE('_SITEMAP_ADMIN_MAINMENU_HELP', "Non &egrave; cos&igrave; facile senza alcun riferimento - Perci&ograve; ho deciso che questo &egrave; un must.");
DEFINE('_SITEMAP_ADMIN_SUBMENU', "Mostra il menu secondario:");
DEFINE('_SITEMAP_ADMIN_SUBMENU_HELP', "Includi tutta la gerarchia della struttura del menu?");
DEFINE('_SITEMAP_ADMIN_PUBLISHED', "Solo i contenuti pubblicati:");
DEFINE('_SITEMAP_ADMIN_PUBLISHED_HELP', "Mostra soltanto le voci di menu che sono pubblicate.");


DEFINE('_SITEMAP_ADMIN_LAYOUT', "Come dovrebbe apparire il vostro layout?");
DEFINE('_SITEMAP_ADMIN_NUMCOLS', "Numero di colonne:");
DEFINE('_SITEMAP_ADMIN_NUMCOLS_HELP', "Numero di colonne per il layout.");
DEFINE('_SITEMAP_ADMIN_STYLE_MAINMENU', "Stile per il menu principale:");
DEFINE('_SITEMAP_ADMIN_STYLE_MAINMENU_HELP', "Stile css per i tag td e anchor del menu principale");
DEFINE('_SITEMAP_ADMIN_STYLE_SUBMENU', "Stile per il menu secondario:");
DEFINE('_SITEMAP_ADMIN_STYLE_SUBMENU_HELP', "Stile css per i tag e anchor di tutti i menu secondari");
DEFINE('_SITEMAP_ADMIN_STYLE_ANCHOR', "Stile il tag anchor:");
DEFINE('_SITEMAP_ADMIN_STYLE_ANCHOR_HELP', "Stile css per il tag anchor dei tuoi links.");

DEFINE('_SITEMAP_ADMIN_ICONS', "Icone di benvenuto?");
DEFINE('_SITEMAP_ADMIN_ICON_REGISTERED', "Icona per pagine registrate:");
DEFINE('_SITEMAP_ADMIN_ICON_REGISTERED_HELP', "Mostra  un lucchetto dietro tutte le pagine per gli utenti registrati. La pagina sar&agrave; visualizzata se l'utente ne ha diritto, ;-).");
DEFINE('_SITEMAP_ADMIN_ICON_URL', "Icona per links esterni:");
DEFINE('_SITEMAP_ADMIN_ICON_URL_HELP', "Un globo per tutti gli indirizzi URL esterni.");
?> 