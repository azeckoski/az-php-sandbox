<?php
/**
* @version $Id: newsfeeds.searchbot.php,v 1.1 2005/07/22 01:58:25 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onSearch', 'botSearchNewsfeedslinks' );

/**
* Contacts Search method
*
* The sql must return the following fields that are used in a common display
* routine: href, title, section, created, text, browsernav
* @param string Target search string
* @param string mathcing option, exact|any|all
* @param string ordering option, newest|oldest|popular|alpha|category
*/
function botSearchNewsfeedslinks( $text, $phrase='', $ordering='' ) {
	global $database, $my;

	$text = trim( $text );
	if ($text == '') {
		return array();
	}

	$wheres = array();
	switch ($phrase) {
		case 'exact':
			$wheres2 = array();
			$wheres2[] = "LOWER(a.name) LIKE '%$text%'";
			$wheres2[] = "LOWER(a.link) LIKE '%$text%'";
			$where = '(' . implode( ') OR (', $wheres2 ) . ')';
			break;
		case 'all':
		case 'any':
		default:
			$words = explode( ' ', $text );
			$wheres = array();
			foreach ($words as $word) {
				$wheres2 = array();
		  	    $wheres2[] = "LOWER(a.name) LIKE '%$word%'";
			    $wheres2[] = "LOWER(a.link) LIKE '%$word%'";
				$wheres[] = implode( ' OR ', $wheres2 );
			}
			$where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
			break;
	}
	

	switch ( $ordering ) {
		case 'alpha':
			$order = 'a.name ASC';
			break;
			
		case 'category':
			$order = 'b.title ASC, a.name ASC';
			break;
			
		case 'oldest':
		case 'popular':
		case 'newest':
		default:
			$order = 'a.name ASC';
	}

	$query = "SELECT a.name AS title,"
	. "\n a.link AS text,"
	. "\n '' AS created,"
	. "\n CONCAT_WS( ' / ','Newsfeeds', b.title )AS section,"
	. "\n '1' AS browsernav,"
	. "\n CONCAT( 'index.php?option=com_newsfeeds&task=view&feedid=', a.id ) AS href"
	. "\n FROM #__newsfeeds AS a"
	. "\n INNER JOIN #__categories AS b ON b.id = a.catid AND b.access <= '$my->gid'"
	. "\n WHERE ( $where )"
	. "\n AND a.published = 1"
	. "\n ORDER BY $order"
	;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	return $rows;
}
?>
