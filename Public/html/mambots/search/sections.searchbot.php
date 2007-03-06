<?php
/**
* @version $Id: sections.searchbot.php,v 1.1 2005/07/22 01:58:25 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onSearch', 'botSearchSections' );

/**
* Sections Search method
*
* The sql must return the following fields that are used in a common display
* routine: href, title, section, created, text, browsernav
* @param string Target search string
* @param string mathcing option, exact|any|all
* @param string ordering option, newest|oldest|popular|alpha|category
*/
function botSearchSections( $text, $phrase='', $ordering='' ) {
	global $database, $my;

     $text = trim( $text );
	if ($text == '') {
		return array();
	}

	switch ( $ordering ) {
		case 'alpha':
			$order = 'a.name ASC';
			break;
		case 'category':
		case 'popular':
		case 'newest':
		case 'oldest':
		default:
			$order = 'a.name DESC';
	}

	$query = "SELECT a.name AS title,"
	. "\n a.description AS text,"
	. "\n '' AS created,"
	. "\n '2' AS browsernav,"
	. "\n a.id AS secid, m.id AS menuid, m.type AS menutype"
	. "\n FROM #__sections AS a"
	. "\n LEFT JOIN #__menu AS m ON m.componentid = a.id"
	. "\n WHERE ( a.name LIKE '%$text%'"
	. "\n OR a.title LIKE '%$text%'"
	. "\n OR a.description LIKE '%$text%' )"
	. "\n AND a.published = '1'"
	. "\n AND a.access <= '$my->gid'"
	. "\n AND ( m.type = 'content_section' OR m.type = 'content_blog_section' )"
	. "\n ORDER BY $order"
	;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$count = count( $rows );
	for ( $i = 0; $i < $count; $i++ ) {
		if ( $rows[$i]->menutype == 'content_section' ) {
			$rows[$i]->href 	= 'index.php?option=com_content&task=section&id='. $rows[$i]->secid .'&Itemid='. $rows[$i]->menuid;
			$rows[$i]->section 	= 'Section List';
		}
		if ( $rows[$i]->menutype == 'content_blog_section' ) {
			$rows[$i]->href 	= 'index.php?option=com_content&task=blogsection&id='. $rows[$i]->secid .'&Itemid='. $rows[$i]->menuid;
			$rows[$i]->section 	= 'Section Blog';
		}
	}
	return $rows;
}
?>