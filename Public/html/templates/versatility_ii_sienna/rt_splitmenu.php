<?php
/**
* @version $Id: md_submenu.php,v 1.2 2005/04/28 04:56:49 rhuk Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if (!defined( '_MOS_SUBMENU_MODULE' )) {
	/** ensure that functions are declared only once */
	define( '_MOS_SUBMENU_MODULE', 1 );
	$hilightid = -1;
	$menuname = null;
	
	$tab_colors = array('red');
	$tab_color = 'red';
	$tab_index = 0;
	
	/**
	* Utility function for writing a menu link
	*/
	function rtGetTabColor() {
		global $tab_color;
		return $tab_color;
	}
	

	function rtGetHilightid() {
		global $hilightid;
		return $hilightid;
	}
	
	function rtGetSubMenuLink( $mitem, $level, $hilight=false , $color_index=false) {
		global $Itemid, $mosConfig_live_site, $mainframe, $hilightid, $menuname, $tab_colors, $tab_color, $tab_index, $forcehilite;
		$txt = '';
		$id = '';

		switch ($mitem->type) {
			case 'separator':
			case 'component_item_link':
			break;
			case 'content_item_link':
			$temp = split("&task=view&id=", $mitem->link);
			$mitem->link .= '&Itemid='. $mainframe->getItemid($temp[1]);
			break;
			case 'url':
			if ( eregi( 'index.php\?', $mitem->link ) ) {
				if ( !eregi( 'Itemid=', $mitem->link ) ) {
					$mitem->link .= '&Itemid='. $mitem->id;
				}
			}
			break;
			case 'content_typed':
			default:
			$mitem->link .= '&Itemid='. $mitem->id;
			break;
		}

		if ($color_index) {
			$id .= $tab_colors[($tab_index)%count($tab_colors)];
			$tab_index++;
			
		}
		// Active Menu highlighting
		$current_itemid = trim( mosGetParam( $_REQUEST, 'Itemid', 0 ) );
		if ( !$current_itemid && !$hilight ) {
			//$id = '';
		} else if (($forcehilite && $hilight) || (($current_itemid == $mitem->id || $hilight) && !$forcehilite)) {
			if ($level == 0) {
				$tab_color = $id;
				$menuname = $mitem->name;
				$hilightid = $mitem->id;
			} 
			$id = 'active_menu';
		} 
		
		$id = ' class="' . $id . '"';
		$mitem->link = ampReplace( $mitem->link );

		if ( strcasecmp( substr( $mitem->link,0,4 ), 'http' ) ) {
			$mitem->link = sefRelToAbs( $mitem->link );
		}

		switch ($mitem->browserNav) {
			// cases are slightly different
			case 1:
			// open in a new window
			$txt = '<li'. $id . '><a href="'. $mitem->link .'" target="_blank">'. $mitem->name ."</a></li>\n";
			break;

			case 2:
			// open in a popup window
			$txt = "<li". $id . "><a href=\"#\" onclick=\"javascript: window.open('". $mitem->link ."', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\">". $mitem->name ."</a></li>\n";
			break;

			case 3:
			// don't link it
			$txt = '<li'. $id . '><span class="seperator">'. $mitem->name ."</span></li>\n";
			break;

			default:	// formerly case 2
			// open in parent window
			$txt = '<li'. $id . '><a href="'. $mitem->link .'">'. $mitem->name ."</a></li>\n";
			break;
		}

		return $txt;
	}

	
	
	function rtShowHorizMenu(  $menutype) {
		global $database, $my, $cur_template, $Itemid, $hilightid, $forcehilite;
		global $mosConfig_absolute_path, $mosConfig_shownoauth;
		
		$topnav = '';

		if ($mosConfig_shownoauth) {
			$sql = "SELECT m.* FROM #__menu AS m"
			. "\nWHERE menutype='". $menutype ."' AND published='1' AND parent=0"
			. "\nORDER BY ordering";
		} else {
			$sql = "SELECT m.* FROM #__menu AS m"
			. "\nWHERE menutype='". $menutype ."' AND published='1' AND access <= '$my->gid' AND parent=0"
			. "\nORDER BY ordering";
		}
		$database->setQuery( $sql );

		$topmenu = $database->loadObjectList( 'id' );
		
		//work out if this should be highlighted
		$sql = "SELECT m.* FROM #__menu AS m"
		. "\nWHERE menutype='". $menutype ."' AND published='1'"; 
		$database->setQuery( $sql );
		$subrows = $database->loadObjectList( 'id' );
		$maxrecurse = 5;
		$parentid = $Itemid;

		//this makes sure toplevel stays hilighted when submenu active
		while ($maxrecurse-- > 0) {
			$parentid = getParentRow($subrows, $parentid);
			if (isset($parentid) && $parentid >= 0 && $subrows[$parentid]) {
				$hilightid = $parentid;
			} else {
				break;	
			}
		}
				
		$links = array();
		$i = 0;
		foreach ($topmenu as $menuitem) {
			$hilight = false;
			if (isset($forcehilite) && $forcehilite && $forcehilite == $i++) {
					$hilight = true;
			} else {
				if ($menuitem->id == $hilightid) {
					$hilight = true;	
				}
			}
			$links[] = rtGetSubMenuLink( $menuitem, 0, $hilight, true );
		}
		



		$menuclass = 'mainlevel';
		if (count( $links )) {
	
			$topnav .= '<ul id="'. $menuclass .'">';
			foreach ($links as $link) {
				$topnav .= $link;
			}
			$topnav .= '</ul>';
			
		}
		return $topnav;
	}
	
	function getParentRow($rows, $id) {
		if (isset($rows[$id]) && $rows[$id]) {
			if($rows[$id]->parent > 0) {
				return $rows[$id]->parent;
			}	
		}
		return -1;
	}
	
	/**
	* Vertically Indented Menu
	*/
	function rtShowSubMenu(  $menutype, $pre=NULL, $post=NULL  ) {
		global $database, $my, $cur_template, $Itemid;
		global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_shownoauth;
		
		$sidenav = '';

		/* If a user has signed in, get their user type */
		$intUserType = 0;
		if($my->gid){
			switch ($my->usertype) {
				case 'Super Administrator':
				$intUserType = 0;
				break;
				case 'Administrator':
				$intUserType = 1;
				break;
				case 'Editor':
				$intUserType = 2;
				break;
				case 'Registered':
				$intUserType = 3;
				break;
				case 'Author':
				$intUserType = 4;
				break;
				case 'Publisher':
				$intUserType = 5;
				break;
				case 'Manager':
				$intUserType = 6;
				break;
			}
		} else {
			/* user isn't logged in so make their usertype 0 */
			$intUserType = 0;
		}

		if ($mosConfig_shownoauth) {
			$sql = "SELECT m.* FROM #__menu AS m"
			. "\nWHERE menutype='". $menutype ."' AND published='1'"
			. "\nAND parent > 0"
			. "\nORDER BY parent,ordering";
		} else {
			$sql = "SELECT m.* FROM #__menu AS m"
			. "\nWHERE menutype='". $menutype ."' AND published='1' AND access <= '$my->gid'"
			. "\nAND parent > 0"
			. "\nORDER BY parent,ordering";
		}
		$database->setQuery( $sql );
		$rows = $database->loadObjectList( 'id' );
	

		// establish the hierarchy of the menu
		$children = array();
		// first pass - collect children
		

		foreach ($rows as $v ) {
			$pt = $v->parent;
			$list = @$children[$pt] ? $children[$pt] : array();
			array_push( $list, $v );
			$children[$pt] = $list;
		}
				
		

		// second pass - collect 'open' menus
		$open = array( $Itemid );
		$count = 20; // maximum levels - to prevent runaway loop
		$id = $Itemid;
		while (--$count) {
			if (isset($rows[$id]) && $rows[$id]->parent > 0) {
				$id = $rows[$id]->parent;
				$open[] = $id;
			} else {
				break;
			}
		}
		
		if (isset($children[$id]) && $children[$id]) {
			$sidenav = rtRecurseSubMenu( $id, 1, $children, $open);
		}
		return $sidenav;

	}

	/**
	* Utility function to recursively work through a vertically indented
	* hierarchial menu
	*/
	function rtRecurseSubMenu( $id, $level, &$children, &$open) {
		global $Itemid, $menuname;
		
		$output = "";
		$sub_class = "submenu";
		
		if (@$children[$id]) {
			//$n = min( $level, count( $indents )-1 );
			if ($level == 1 ) {
				$output .= "<div class=\"moduletable\"><h3>" . $menuname . "</h3>\n";
				$output .= "<ul class=\"" . $sub_class . "\">\n";
			} else {
				$output .= "<ul>\n";
			}

			
			foreach ($children[$id] as $row) {
				$output .= rtGetSubMenuLink( $row, $level );
				if ( in_array( $row->id, $open )) {
					$output .= rtRecurseSubMenu( $row->id, $level+1, $children, $open );
				}
			}
			
			
			$output .= "</ul>\n";

			if ($level == 1) {
				$output .= "</div>\n";
			}
		}
		return $output;
	}
	
	function beginsWith( $str, $sub ) {
   return ( substr( $str, 0, strlen( $sub )-1 ) == $sub );
	}

}

?>
