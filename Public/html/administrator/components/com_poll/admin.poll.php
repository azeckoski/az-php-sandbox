<?php
/**
* @version $Id: admin.poll.php,v 1.1 2005/07/22 01:53:21 eddieajau Exp $
* @package Mambo
* @subpackage Polls
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
		| $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_poll' ))) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

$cid 	= mosGetParam( $_REQUEST, 'cid', array(0) );
if (!is_array( $cid )) {
	$cid = array(0);
}

switch( $task ) {
	case 'new':
		editPoll( 0, $option );
		break;

	case 'edit':
		editPoll( $cid[0], $option );
		break;

	case 'editA':
		editPoll( $id, $option );		
		break;
		
	case 'save':
		savePoll( $option );
		break;

	case 'remove':
		removePoll( $cid, $option );
		break;

	case 'publish':
		publishPolls( $cid, 1, $option );
		break;

	case 'unpublish':
		publishPolls( $cid, 0, $option );
		break;

	case 'cancel':
		cancelPoll( $option );
		break;

	default:
		showPolls( $option );
		break;
}

function showPolls( $option ) {
	global $database, $mainframe, $mosConfig_list_limit;

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

	$database->setQuery( "SELECT COUNT(*) FROM #__polls" );
	$total = $database->loadResult();

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	$query = "SELECT m.*, u.name AS editor,"
	. "\n COUNT(d.id) AS numoptions"
	. "\n FROM #__polls AS m"
	. "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
	. "\n LEFT JOIN #__poll_data AS d ON d.pollid = m.id AND d.text <> ''"
	. "\n GROUP BY m.id"
	. "\n LIMIT $pageNav->limitstart,$pageNav->limit"
	;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	HTML_poll::showPolls( $rows, $pageNav, $option );
}

function editPoll( $uid=0, $option='com_poll' ) {
	global $database, $my;

	$row = new mosPoll( $database );
	// load the row from the db table
	$row->load( $uid );

	// fail if checked out not by 'me'
	if ($row->checked_out && $row->checked_out <> $my->id) {
		mosRedirect( 'index2.php?option='. $option, 'The poll '. $row->title .' is currently being edited by another administrator.' );
	}

	$options = array();

	if ($uid) {
		$row->checkout( $my->id );
		$query = "SELECT id, text FROM #__poll_data"
		. "\n WHERE pollid='$uid'"
		. "\n ORDER BY id"
		;
		$database->setQuery($query);
		$options = $database->loadObjectList();
	} else {
		$row->lag = 3600*24;
	}

	// get selected pages
	if ( $uid ) {
		$database->setQuery( "SELECT menuid AS value FROM #__poll_menu WHERE pollid='$row->id'" );
		$lookup = $database->loadObjectList();
	} else {
		$lookup = array( mosHTML::makeOption( 0, 'All' ) );
	}

	// build the html select list
	$lists['select'] = mosAdminMenus::MenuLinks( $lookup, 1, 1 );

	HTML_poll::editPoll($row, $options, $lists );
}

function savePoll( $option ) {
	global $database, $my;

	// save the poll parent information
	$row = new mosPoll( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$isNew = ($row->id == 0);

	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();
	// save the poll options
	$options = mosGetParam( $_POST, 'polloption', array() );

	foreach ($options as $i=>$text) {
		// 'slash' the options
		if (!get_magic_quotes_gpc()) {
			$text = addslashes( $text );
		}

		if ($isNew) {
			$database->setQuery( "INSERT INTO #__poll_data (pollid,text) VALUES ($row->id,'$text')" );
			$database->query();
		} else {
			$database->setQuery( "UPDATE #__poll_data SET text='$text' WHERE id='$i' AND pollid='$row->id'" );
			$database->query();
		}
	}

	// update the menu visibility
	$selections = mosGetParam( $_POST, 'selections', array() );

	$database->setQuery( "DELETE from #__poll_menu where pollid='$row->id'" );
	$database->query();

	for ($i=0, $n=count($selections); $i < $n; $i++) {
		$database->setQuery( "INSERT INTO #__poll_menu SET pollid='$row->id', menuid='$selections[$i]'" );
		$database->query();
	}

	mosRedirect( 'index2.php?option='. $option );
}

function removePoll( $cid, $option ) {
	global $database;
	$msg = '';
	for ($i=0, $n=count($cid); $i < $n; $i++) {
		$poll = new mosPoll( $database );
		if (!$poll->delete( $cid[$i] )) {
			$msg .= $poll->getError();
		}
	}
	mosRedirect( 'index2.php?option='. $option .'&mosmsg='. $msg );
}

/**
* Publishes or Unpublishes one or more records
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
* @param string The current url option
*/
function publishPolls( $cid=null, $publish=1, $option ) {
	global $database, $my;

	$catid = mosGetParam( $_POST, 'catid', array(0) );

	if (!is_array( $cid ) || count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$query = "UPDATE #__polls SET published='$publish'"
	. "\n WHERE id IN ($cids)"
	. "\n AND ( checked_out=0 OR ( checked_out='$my->id' ) )"
	;
	$database->setQuery( $query );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (count( $cid ) == 1) {
		$row = new mosPoll( $database );
		$row->checkin( $cid[0] );
	}
	mosRedirect( 'index2.php?option='. $option );
}

function cancelPoll( $option ) {
	global $database;
	$row = new mosPoll( $database );
	$row->bind( $_POST );
	// sanitize
	$row->id = intval($row->id);
	$row->checkin();
	mosRedirect( 'index2.php?option='. $option );
}
?>