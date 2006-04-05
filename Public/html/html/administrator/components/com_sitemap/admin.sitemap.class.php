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
// $Id: admin.sitemap.class.php,v 1.2 2003/11/22 19:41:03 akede Exp $
//
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Management class for the configuration
*
* @package sitemap
* @copyright 2003 Think Network GmbH
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @version $Revision: 1.2 $
* @author  $Author: akede $
*/
class SitemapManager {
/** @var config Configuration of the map */
	var $_config=null;

	/**
	 * Standard constructor
	 * @param database A database connection object
	 * @param string The path of the mos directory
	*/
	function SitemapManager( $basePath, $adminPath ) {
		$this->_loadConfiguration( $adminPath );
	}
	
	/**
	* Loads the configuration.php file and assigns values to the internal variable
	* @param string The base path from which to load the configuration file
	*/
	function _loadConfiguration( $adminPath='.' ) {
		$this->_config = new stdClass();
		require( "$adminPath/components/com_sitemap/config.sitemap.php" );
		$this->_config->numColumns = $sitemap_numColumns;
		$this->_config->showSubmenus = $sitemap_showSubmenus;
		$this->_config->showSections = $sitemap_showSections;
		$this->_config->showCategories = $sitemap_showCategories;
		$this->_config->showContent = $sitemap_showContent;
		$this->_config->showPublishedContent = $sitemap_showPublishedContent;
		$this->_config->showRestrictedIcon = $sitemap_showRestrictedIcon;
		$this->_config->showURLIcon = $sitemap_showURLIcon;

		$this->_config->styleMainmenu = $sitemap_styleMainmenu;
		$this->_config->styleSubmenu = $sitemap_styleSubmenu;
		$this->_config->styleAnchorTag = $sitemap_styleAnchorTag;
	}

	/**
	* @param string The name of the variable (from configuration.php)
	* @return mixed The value of the configuration variable or null if not found
	*/
	function getCfg( $varname ) {
		if (isset( $this->_config->$varname )) {
			return $this->_config->$varname;
		} else {
			return null;
		}
	}
	
	/**
	* @param string The name of the variable (from configuration.php)
	* @param mixed The value of the configuration variable
	*/
	function setCfg( $varname, $newValue ) {
		if (isset( $this->_config->$varname )) {
			$this->_config->$varname = $newValue;
		}
	}

	function saveConfiguration ($adminPath=".") {
		global $option;
		
		$configfile = "$adminPath/components/com_sitemap/config.sitemap.php";
		@chmod ($configfile, 0766);
		$permission = is_writable($configfile);
		if (!$permission) {
			$mosmsg = "Config file not writeable!";
			mosRedirect("index2.php?option=$option&act=config",$mosmsg);
			break;
		}
		
		$config = "<?php\n";
		$config .= "/** @var showSubmenus Flag that defines if the sub menus will be displayed */\n";
		$config .= "\$sitemap_showSubmenus = " .$this->_config->showSubmenus. ";\n\n";
		$config .= "/** @var showSections Flag that defines if the sections will be displayed */\n";
		$config .= "\$sitemap_showSections = " .$this->_config->showSections. ";\n";
		$config .= "/** @var showCategories Flag that defines if the categories of each section will be displayed */\n";
		$config .= "\$sitemap_showCategories = " .$this->_config->showCategories. ";\n";
		$config .= "/** @var showContent Flag that defines if the content titles will be displayed */\n";
		$config .= "\$sitemap_showContent = " .$this->_config->showContent. ";\n";
		$config .= "/** @var publishedContent Indecates that only published content will be displayed */\n";
		$config .= "\$sitemap_showPublishedContent = " .$this->_config->showPublishedContent. ";\n\n";
		
		$config .= "/** @var showRestrictedIcon Flag to activate an additional icon for restricted menu's */\n";
		$config .= "\$sitemap_showRestrictedIcon = " .$this->_config->showRestrictedIcon. ";\n";
		$config .= "/** @var showURLIcon Flag to activate an additional icon for URL menu's */\n";
		$config .= "\$sitemap_showURLIcon = " .$this->_config->showURLIcon. ";\n\n";
		
		$config .= "/** @var numColumns Number of columns the map should be displayed */\n";
		$config .= "\$sitemap_numColumns = " .$this->_config->numColumns. ";\n";
		$config .= "/** @var styleMainmenu Reference to the css name of level 0 menus also for the anchor tag! */\n";
		$config .= "\$sitemap_styleMainmenu = '" .$this->_config->styleMainmenu. "';\n";
		$config .= "/** @var styleSubmenu Reference to the css name of level > 0 menus */\n";
		$config .= "\$sitemap_styleSubmenu = '" .$this->_config->styleSubmenu. "';\n";
		$config .= "/** @var styleAnchorTag Reference to the css name of the anchor tag */\n";
		$config .= "\$sitemap_styleAnchorTag = '" .$this->_config->styleAnchorTag. "';\n";
		
		$config .= "?>";
		
		if ($fp = fopen("$configfile", "w")) {
			fputs($fp, $config, strlen($config));
			fclose ($fp);
		}
		$this->_loadConfiguration( $adminPath );
		mosRedirect("index2.php?option=$option&act=config", "Settings saved");
	}

	/**
	 * Actual version information
	 */
	function getVersion() {
		return 'V1.2 (2003-11-22)';
	}
}
?>