<?php
/**
* @version $Id: admin.weblinks.php,v 1.1 2005/07/22 01:53:38 eddieajau Exp $
* @package Mambo
* @subpackage Weblinks
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
		| $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_weblinks' ))) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

$cid = mosGetParam( $_POST, 'cid', array(0) );

switch ($task) {
	case 'new':
		editWeblink( $option, 0 );
		break;

	case 'edit':
		editWeblink( $option, $cid[0] );
		break;

	case 'editA':
		editWeblink( $option, $id );
		break;

	case 'save':
		saveWeblink( $option );
		break;

	case 'remove':
		removeWeblinks( $cid, $option );
		break;

	case 'publish':
		publishWeblinks( $cid, 1, $option );
		break;

	case 'unpublish':
		publishWeblinks( $cid, 0, $option );
		break;

	case 'approve':
		break;

	case 'cancel':
		cancelWeblink( $option );
		break;

	case 'orderup':
		orderWeblinks( $cid[0], -1, $option );
		break;

	case 'orderdown':
		orderWeblinks( $cid[0], 1, $option );
		break;

	default:
		showWeblinks( $option );
		break;
}

/**
* Compiles a list of records
* @param database A database connector object
*/
function showWeblinks( $option ) {
	global $database, $mainframe, $mosConfig_list_limit;

	$catid = $mainframe->getUserStateFromRequest( "catid{$option}", 'catid', 0 );
	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	$search = $database->getEscaped( trim( strtolower( $search ) ) );

	$where = array();

	if ($catid > 0) {
		$where[] = "a.catid='$catid'";
	}
	if ($search) {
		$where[] = "LOWER(a.title) LIKE '%$search%'";
	}

	// get the total number of records
	$database->setQuery( "SELECT count(*) FROM #__weblinks AS a"
		. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	);
	$total = $database->loadResult();

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	$query = "SELECT a.*, cc.name AS category, u.name AS editor"
	. "\n FROM #__weblinks AS a"
	. "\n LEFT JOIN #__categories AS cc ON cc.id = a.catid"
	. "\n LEFT JOIN #__users AS u ON u.id = a.checked_out"
	. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
	. "\n ORDER BY a.catid, a.ordering"
	. "\n LIMIT $pageNav->limitstart, $pageNav->limit"
	;
	$database->setQuery( $query );

	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	// build list of categories
	$javascript = 'onchange="document.adminForm.submit();"';
	$lists['catid'] 			= mosAdminMenus::ComponentCategory( 'catid', $option, intval( $catid ), $javascript );

	HTML_weblinks::showWeblinks( $option, $rows, $lists, $search, $pageNav );
}

/**
* Compiles information to add or edit
* @param integer The unique id of the record to edit (0 if new)
*/
function editWeblink( $option, $id ) {
	global $database, $my, $mosConfig_absolute_path, $mosConfig_live_site;

	$lists = array();

	$row = new mosWeblink( $database );
	// load the row from the db table
	$row->load( $id );

	// fail if checked out not by 'me'
	if ($row->checked_out && $row->checked_out <> $my->id) {
		mosRedirect( 'index2.php?option='. $option, 'The module $row->title is currently being edited by another administrator.' );
	}

	if ($id) {
		$row->checkout( $my->id );
	} else {
		// initialise new record
		$row->published 		= 1;
		$row->approved 		= 1;
		$row->order 			= 0;
		$row->catid = mosGetParam( $_POST, 'catid', 0 );
	}

	// build the html select list for ordering
	$query = "SELECT ordering AS value, title AS text"
	. "\n FROM #__weblinks"
	. "\n WHERE catid='$row->catid'"
	. "\n ORDER BY ordering"
	;
	$lists['ordering'] 			= mosAdminMenus::SpecificOrdering( $row, $id, $query, 1 );

	// build list of categories
	$lists['catid'] 			= mosAdminMenus::ComponentCategory( 'catid', $option, intval( $row->catid ) );
	// build the html select list
	$lists['approved'] 			= mosHTML::yesnoRadioList( 'approved', 'class="inputbox"', $row->approved );
	// build the html select list
	$lists['published'] 		= mosHTML::yesnoRadioList( 'published', 'class="inputbox"', $row->published );

	$file = $mosConfig_absolute_path .'/administrator/components/com_weblinks/weblinks_item.xml';
	$params =& new mosParameters( $row->params, $file, 'component' );

	HTML_weblinks::editWeblink( $row, $lists, $params, $option );
}

/**
* Saves the record on an edit form submit
* @param database A database connector object
*/
function saveWeblink( $option ) {
	global $database, $my;

	$row = new mosWeblink( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	// save params
	$params = mosGetParam( $_POST, 'params', '' );
	if (is_array( $params )) {
		$txt = array();
		foreach ( $params as $k=>$v) {
			$txt[] = "$k=$v";
		}
		$row->params = implode( "\n", $txt );
	}

	$row->date = date( "Y-m-d H:i:s" );
	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();
	$row->updateOrder( "catid='$row->catid'" );

	mosRedirect( "index2.php?option=$option" );
}

/**
* Deletes one or more records
* @param array An array of unique category id numbers
* @param string The current url option
*/
function removeWeblinks( $cid, $option ) {
	global $database;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$database->setQuery( "DELETE FROM #__weblinks WHERE id IN ($cids)" );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
	}

	mosRedirect( "index2.php?option=$option" );
}

/**
* Publishes or Unpublishes one or more records
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
* @param string The current url option
*/
function publishWeblinks( $cid=null, $publish=1,  $option ) {
	global $database, $my;

	$catid = mosGetParam( $_POST, 'catid', array(0) );

	if (!is_array( $cid ) || count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__weblinks SET published='$publish'"
		. "\nWHERE id IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))"
	);
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (count( $cid ) == 1) {
		$row = new mosWeblink( $database );
		$row->checkin( $cid[0] );
	}
	mosRedirect( "index2.php?option=$option" );
}
/**
* Moves the order of a record
* @param integer The increment to reorder by
*/
function orderWeblinks( $uid, $inc, $option ) {
	global $database;
	$row = new mosWeblink( $database );
	$row->load( $uid );
	$row->move( $inc, "published >= 0" );

	mosRedirect( "index2.php?option=$option" );
}

/**
* Cancels an edit operation
* @param string The current url option
*/
function cancelWeblink( $option ) {
	global $database;
	$row = new mosWeblink( $database );
	$row->bind( $_POST );
	// sanitize
	$row->id = intval($row->id);
	$row->checkin();
	mosRedirect( "index2.php?option=$option" );
}
?>