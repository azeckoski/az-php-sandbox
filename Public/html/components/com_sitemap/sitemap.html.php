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
// $Id: sitemap.html.php,v 1.1 2003/11/12 21:30:36 akede Exp $
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

/**
* Utility class for writing the HTML code of the site map
*/
class HTML_sitemap {
/* @var sitemapManager	Reference to my Manager for config and so on */
	var $_sitemapManager=null;

/** @var userRights		The access level the user has */
	var $_userRights=0;
	
	/** Default constructor
	 */
	function HTML_sitemap ($sitemapManager) {
		global $my;
		
		$this->_sitemapManager = $sitemapManager;
		
		# Check User rights
		$is_editor = (strtolower($my->usertype) == 'editor' || strtolower($my->usertype) == 'administrator' || strtolower($my->usertype) == 'superadministrator' );
		if ((strtolower($my->usertype) <> '')) {
			$this->_userRights=1;
		} else if (strtolower($my->usertype) == 'editor') {
			$this->_userRights=2;
		} else if (strtolower($my->usertype) == 'administrator') {
			$this->_userRights=3;
		} else if (strtolower($my->usertype) == 'superadministrator') {
			$this->_userRights=4;
		}
	}
	
	/**
	 * Displays actually the whole map including the header and the rest of the structure
	 *
	 * @param	sitemapManager	Reference to my manager
	 */
	function show($sitemapManager) {
		$htmlSiteMap = new HTML_sitemap($sitemapManager);
		
		$htmlSiteMap->_header();
		
		$sitemap=null;
		$htmlSiteMap->_buildMenuMap($sitemap);
		
		// Add sections if requsted
		if ( $sitemapManager->getCfg( 'showSections' ) ) {
			$htmlSiteMap->_addSections2Map( $sitemap );
		}
		
		// Split the map to the number of columns
		$numColumns = $sitemapManager->getCfg( 'numColumns' );
		$sitemap = $htmlSiteMap->_splitMap($sitemap, $numColumns);
		
		foreach ($sitemap as $row) {
			HTML_sitemap::_showRow($row, $numColumns, $sitemapManager);
		}

		$htmlSiteMap->_footer();
	}
	
	/**
	 * Create one output row
	 */
	function _showRow(&$row, $numColumns, $sitemapManager)
	{
		global $mosConfig_live_site;
	?>
	<tr>
	<?php
		for( $i=0; $i<$numColumns; $i++ ) {
			if ( isset($row[$i]) ) {
			 	switch ( $row[$i]->level ) {
					case 0:
						echo '<td colspan="5" width="100%" nowrap class="' .$sitemapManager->getCfg( 'styleMainmenu' ). '">';
						break;
					
					case 1:
						echo '<td>&nbsp;</td><td colspan="4" width="100%" nowrap class="' .$sitemapManager->getCfg( 'styleSubmenu' ). '">';
						break;
					
					case 2:
						echo '<td>&nbsp;</td><td>&nbsp;</td><td colspan="3" width="100%" nowrap class="' .$sitemapManager->getCfg( 'styleSubmenu' ). '">';
						break;
					
					case 3:
						echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td colspan="2" width="100%" nowrap class="' .$sitemapManager->getCfg( 'styleSubmenu' ). '">';
						break;
					
					case 4:
						echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>';
						break;
				}
				
				echo $row[$i]->link;
				echo '</td><td align="right">';
				
				$icons='';
				if ( $row[$i]->access > 0 && $sitemapManager->getCfg( 'showRestrictedIcon' )) {
					$icons .= '<img src="components/com_sitemap/images/lock.png" alt="' ._SITEMAP_RESTRICTED_CONTENT. '" border="0">';
				}
				if ( $row[$i]->type=='url' && $sitemapManager->getCfg( 'showURLIcon' )
					 && strpos ($row[$i]->link, 'http') > 0) {
					 //
					$icons .= '<img src="images/M_images/weblink.png" alt="' ._SITEMAP_EXTERNAL_CONTENT. '" border="0">';
				}
				 
				if ($icons!='') {
					echo $icons;
				} else {
					echo "&nbsp;";
				}
				echo '</td>';
			}
			else {
				echo '<td colspan="6">&nbsp;</td>';
			}
		}
		?>
	</tr>
	<?php
	}
	
	/**
	 * Function to write the header of the map
	 */
	function _header() {
		global $mainframe;
	?>
<table cellpadding="0" cellspacing="4" border="0" width="100%" class="contentpane">
  <tr> 
    <td class="componentheading" width="100%""><?php echo _SITEMAP_TITLE . $mainframe->getCfg('sitename');?></td>
  </tr>
  <tr><td class="contentdescription">
    <table align="center" cellpadding="1" cellspacing="0" border="0" width="90%" class="contentpane">
      <tr>
  <?php
  		$numColumns =  $this->_sitemapManager->getCfg('numColumns');
  		for($i=0; $i<$numColumns; $i++) {
		?>
        <td width="<?php echo 100/$numColumns;?>%" colspan="6"><img src="images/M_images/blank.png" height="0" width="5"></td>
		<?php
		}
  ?>
      </tr>
		<tr>
  <?php
  		$numColumns =  $this->_sitemapManager->getCfg('numColumns');
  		for($i=0; $i<$numColumns; $i++) {
		?>
		<td width="1%"><img src="images/M_images/blank.png" height="0" width="5"></td>
		<td width="1%"><img src="images/M_images/blank.png" height="0" width="5"></td>
		<td width="1%"><img src="images/M_images/blank.png" height="0" width="5"></td>
		<td width="1%"><img src="images/M_images/blank.png" height="0" width="5"></td>
	   <td>&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<?php
		}
  ?>
      </tr>
	<?php
	}
	
	/** 
	
	/**
	 * Function to write the footer of the map
	 */
	function _footer() {
	?>
    </table>
  </td></tr>
</table>
<!--SiteMap <?php echo $this->_sitemapManager->getVersion();?>-->
<!-- &copy; 2003 Think Network, released under the GPL. -->
<!-- More information: at http://www.ThinkNetwork.com -->
	<?php
	}
	
	/**
	 * This functions splits the whole map into a certain number of pieces
	 *
	 */
	function _splitMap( $wholeSiteMap, $numColumns ) {
		$columnMap = array();
		
		$mapBreak = count($wholeSiteMap) / $numColumns;
		$lastBreak = 0;
		
		for( $col=0; $col<$numColumns-1; $col++) {
			$level0Break=-1;
			for( $i=$mapBreak+1; $i<count($wholeSiteMap); $i++ ) {
				if( $wholeSiteMap[$i]->level==0 ) {
					$level0Break=$i;
					break;
				}
			}
			$columnMap[$col]=array_slice( $wholeSiteMap, $lastBreak, $level0Break-1 );
			$lastBreak=$level0Break-1;
		}
		$columnMap[$col]=array_slice( $wholeSiteMap, $lastBreak );
		
		$maxRows=0;
		for( $i=0; $i<$numColumns; $i++ ) {
			if ( count($columnMap[$i])>$maxRows ) {
				$maxRows = count($columnMap[$i]);
			}
		}
		$splittedMap = array();
		for( $col=0; $col<$numColumns; $col++ ) {
			for( $i=0; $i<$maxRows; $i++ ) {
				if ( !isset($columnMap[$col][$i]) ) continue;
				$splittedMap[$i][$col]=$columnMap[$col][$i];
			}
		}
		return $splittedMap;
	}
	
	/**
	 * Builds the map of all the menus
	 */
	function _buildMenuMap(&$siteMap)
	{
		global $database, $my;
		
		$menuMap=null;
		$published = 'AND published=1';
		if ($this->_sitemapManager->getCfg('showPublishedContent')==false) {
			$published = '';
		}
		
		$sql = "SELECT m.* FROM #__menu AS m"
		. "\nWHERE menutype='mainmenu' $published AND access <= $my->gid"
		. "\nORDER BY sublevel,ordering";
		
		$database->setQuery( $sql );
		
		$rows = $database->loadObjectList( 'id' );
		echo $database->getErrorMsg();
		
		// establish the hierarchy of the menu
		$children = array();
		// first pass - collect children
		foreach ($rows as $v ) {
			$pt = $v->parent;
			$list = @$children[$pt] ? $children[$pt] : array();
			array_push( $list, $v );
			$children[$pt] = $list;
		}
		$menuMap = $children;
		
		$siteMap = array();
		$this->_recurseMenu( 0, 0, $menuMap, $siteMap );
		
	}

	/**
	 * Recurse the menu and build it up for all levels
	 */
	function _recurseMenu( $id, $level, &$menuMap, &$siteMap ) {
		global $mosConfig_lang, $mosConfig_mbf_content;
		if (@$menuMap[$id]) {
			
			foreach ($menuMap[$id] as $row) {
				$menuLink='';
				
				if ($row->type != 'url') {
					$row->link .= "&Itemid=$row->id";
				}
			 	// akede, 2003-11-07: Support for multi language component MambelFish added
				if (isset($mosConfig_mbf_content) && $mosConfig_mbf_content) {
					$row = MambelFish::translate( $row, 'menu', $mosConfig_lang);
				}
				$row->link = sefRelToAbs($row->link);
				
				// END: akede
				if ($level == 0) {
					$menuclass =  $this->_sitemapManager->getCfg( 'styleMainmenu' );
				} else {
					$menuclass =  $this->_sitemapManager->getCfg( 'styleAnchorTag' );
				}
				
				switch ($row->browserNav) {
					// cases are slightly different
					case 1:
					// open in a new window
					$menuLink = "<a href=\"$row->link\" target=\"_window\" class=\"$menuclass\">$row->name</a>\n";
					break;
					
					case 2:
					// open in a popup window
					$menuLink = "<a href=\"#\" onClick=\"javascript: window.open('$row->link', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550');\" class=\"$menuclass\">$row->name</a>\n";
					break;
					
					default:	// formerly case 2
					// open in parent window
					$menuLink = "<a href=\"$row->link\" class=\"$menuclass\">$row->name</a>\n";
					break;
				}
				
				$rowNum = count($siteMap)+1;
				$siteMap[$rowNum] = new stdClass();
				$siteMap[$rowNum]->link = $menuLink;
				$siteMap[$rowNum]->type = $row->type;
				$siteMap[$rowNum]->level = $level;
				$siteMap[$rowNum]->componentid = $row->componentid;
				$siteMap[$rowNum]->access = $row->access;
				
				if ($this->_sitemapManager->getCfg('showSubmenus')) {
					$this->_recurseMenu( $row->id, $level+1, $menuMap, $siteMap );
				}
			}
		}
	}
	
	/**
	 * Adds all the sections to the menu items.
	 * For that reason the whole map will be parsed be cause in every menu there could
	 * be a section, or?
	 *
	 * @param	wholemap	Reference to the complete, not splitted map
	 */
	function _addSections2Map( $wholeSiteMap ) {
		global $database, $my, $mosConfig_ml_content, $mosConfig_lang;
		$sectionsMap = array();
		
		foreach( $wholeSiteMap as $row ) {
			$sectionid=$row->componentid;
			if ( $row->type=='content_section' ) {
				$section = new mosSection( $database );
				$section->load( $sectionid );
			
			 	// akede, 2003-11-07: Support for multi language component MambelFish added
				if (isset($mosConfig_mbf_content) && $mosConfig_mbf_content) {
					$section = MambelFish::translate( $section, 'sections', $mosConfig_lang);
				}
				// END: akede
				
				//echo 'reference for ['. $section->title. '] = ' .$sectionid. ' [' .$row->type. ']<br>';
			}
		}
	}
}
?>
