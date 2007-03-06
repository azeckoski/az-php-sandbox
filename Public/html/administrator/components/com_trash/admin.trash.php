<?php
/**
* @version $Id: admin.trash.php,v 1.1 2005/07/22 01:53:32 eddieajau Exp $
* @package Mambo
* @subpackage Trash
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_trash' ))) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class', 'com_frontpage' ) );

$task = mosGetParam( $_REQUEST, 'task', array(0) );
$cid = mosGetParam( $_POST, 'cid', array(0) );
$mid = mosGetParam( $_POST, 'mid', array(0) );
if ( !is_array( $cid ) ) {
	$cid = array(0);
}

switch ($task) {
	case "deleteconfirm":
	viewdeleteTrash( $cid, $mid, $option );
	break;

	case "delete":
	deleteTrash( $cid, $option );
	break;

	case "restoreconfirm":
	viewrestoreTrash( $cid, $mid, $option );
	break;

	case "restore":
	restoreTrash( $cid, $option );
	break;

	default:
	viewTrash( $option );
	break;
}


/**
* Compiles a list of trash items
*/
function viewTrash( $option ) {
	global $database, $mainframe, $mosConfig_list_limit;
	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{". $option ."}limitstart", 'limitstart', 0 );

	// get the total number of content
	$query = "SELECT count(*)"
	. "\n FROM #__content AS c"
	. "\n LEFT JOIN #__categories AS cc ON cc.id = c.catid"
	. "\n LEFT JOIN #__sections AS s ON s.id = cc.section AND s.scope='content'"
	. "\n WHERE c.state = '-2'"
	;
	$database->setQuery( $query );
	$total_content = $database->loadResult();
	$pageNav_content = new mosPageNav( $total_content, $limitstart, $limit );

	// Query content items
	$query = 	"SELECT c.*, g.name AS groupname, cc.name AS catname, s.name AS sectname"
	. "\n FROM #__content AS c"
	. "\n LEFT JOIN #__categories AS cc ON cc.id = c.catid"
	. "\n LEFT JOIN #__sections AS s ON s.id = cc.section AND s.scope='content'"
	. "\n INNER JOIN #__groups AS g ON g.id = c.access"
	. "\n LEFT JOIN #__users AS u ON u.id = c.checked_out"
	. "\n WHERE c.state = '-2'"
	. "\n ORDER BY s.name, cc.name, c.title"
	. "\n LIMIT ". $pageNav_content->limitstart .", ".$pageNav_content->limit .""
	;
	$database->setQuery( $query );
	$contents = $database->loadObjectList();


	$query = "SELECT count(*)"
	. "\n FROM #__menu AS m"
	. "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
	. "\n WHERE m.published = -2"
	;
	$database->setQuery( $query );
	$total_menu = $database->loadResult();
	//$total_menu = count( $total_menu );
	$pageNav_menu = new mosPageNav( $total_menu, $limitstart, $limit );

	// Query menu items
	$query = 	"SELECT m.*"
	. "\n FROM #__menu AS m"
	. "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
	. "\n WHERE m.published = -2"
	. "\n ORDER BY m.menutype, m.ordering, m.ordering, m.name"
	. "\n LIMIT ". $pageNav_menu->limitstart .", ".$pageNav_menu->limit .""
	;
	$database->setQuery( $query );
	$menus = $database->loadObjectList();

	for ( $i = 0; $i < $total_content; $i++ ) {
		if ( ( $contents[$i]->sectionid == 0 ) && ( $contents[$i]->catid == 0 ) ) {
			$contents[$i]->sectname = 'Typed Content';
		}
	}

	HTML_trash::showList( $option, $contents, $menus, $pageNav_content, $pageNav_menu );
}


/**
* Compiles a list of the items you have selected to permanently delte
*/
function viewdeleteTrash( $cid, $mid, $option ) {
	global $database, $mainframe;

	// seperate contentids
	$cids = implode( ',', $cid );
	$mids = implode( ',', $mid );

	if ( $cids ) {
		// Content Items query
		$query = 	"SELECT a.title AS name"
		. "\n FROM #__content AS a"
		. "\n WHERE ( a.id IN (". $cids .") )"
		. "\n ORDER BY a.title"
		;
		$database->setQuery( $query );
		$items = $database->loadObjectList();
		$id = $cid;
		$type = "content";
	} else if ( $mids ) {
		// Content Items query
		$query = 	"SELECT a.name"
		. "\n FROM #__menu AS a"
		. "\n WHERE ( a.id IN (". $mids .") )"
		. "\n ORDER BY a.name"
		;
		$database->setQuery( $query );
		$items = $database->loadObjectList();
		$id = $mid;
		$type = "menu";
	}

	HTML_trash::showDelete( $option, $id, $items, $type );
}


/**
* Permanently deletes the selected list of trash items
*/
function deleteTrash( $cid, $option ) {
	global $database, $mainframe;
	$type = mosGetParam( $_POST, 'type', array(0) );

	$total = count( $cid );

	if ( $type == "content" ) {
		$obj = new mosContent( $database );
		$fp = new mosFrontPage( $database );
		foreach ( $cid as $id ) {
			$id = intval( $id );
			$obj->delete( $id );
			$fp->delete( $id );
		}
	} else if ( $type == "menu" ) {
		$obj = new mosMenu( $database );
		foreach ( $cid as $id ) {
			$id = intval( $id );
			$obj->delete( $id );
		}
	}

	$msg = $total. " Item(s) successfully Deleted";
	mosRedirect( "index2.php?option=$option&mosmsg=". $msg ."" );
}


/**
* Compiles a list of the items you have selected to permanently delte
*/
function viewrestoreTrash( $cid, $mid, $option ) {
	global $database, $mainframe;

	// seperate contentids
	$cids = implode( ',', $cid );
	$mids = implode( ',', $mid );

	if ( $cids ) {
		// Content Items query
		$query = 	"SELECT a.title AS name"
		. "\n FROM #__content AS a"
		. "\n WHERE ( a.id IN (". $cids .") )"
		. "\n ORDER BY a.title"
		;
		$database->setQuery( $query );
		$items = $database->loadObjectList();
		$id = $cid;
		$type = "content";
	} else if ( $mids ) {
		// Content Items query
		$query = 	"SELECT a.name"
		. "\n FROM #__menu AS a"
		. "\n WHERE ( a.id IN (". $mids .") )"
		. "\n ORDER BY a.name"
		;
		$database->setQuery( $query );
		$items = $database->loadObjectList();
		$id = $mid;
		$type = "menu";
	}

	HTML_trash::showRestore( $option, $id, $items, $type );
}


/**
* Restores items selected to normal - restores to an unpublished state
*/
function restoreTrash( $cid, $option ) {
	global $database;
	$type = mosGetParam( $_POST, 'type', array(0) );

	$total = count( $cid );

	// restores to an unpublished state
	$state = "0";
	$ordering = '9999';
	//seperate contentids
	$cids = implode( ',', $cid );

	if ( $type == "content" ) {
		$query = 	"UPDATE #__content SET state = '". $state ."', ordering = '". $ordering ."'"
		. "\n WHERE id IN ( ". $cids ." )"
		;
	} else if ( $type == "menu" ) {
		$query = 	"UPDATE #__menu SET published = '". $state ."', ordering = '9999'"
		. "\n WHERE id IN ( ". $cids ." )"
		;
	}

	$database->setQuery( $query );
	if ( !$database->query() ) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$msg = $total. " Item(s) successfully Restored";
	mosRedirect( "index2.php?option=$option&mosmsg=". $msg ."" );
}


?>
