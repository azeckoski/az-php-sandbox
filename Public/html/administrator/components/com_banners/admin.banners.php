<?php
/**
* @version $Id: admin.banners.php,v 1.1 2005/07/22 01:52:06 eddieajau Exp $
* @package Mambo
* @subpackage Banners
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )| $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_banners' ))) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

$cid = mosGetParam( $_REQUEST, 'cid', array(0) );
if (!is_array( $cid )) {
	$cid = array(0);
}

switch ($task) {
	case 'newclient':
		editBannerClient( 0, $option );
		break;

	case 'editclient':
		editBannerClient( $cid[0], $option );
		break;

	case 'editclientA':
		editBannerClient( $id, $option );
		break;

	case 'saveclient':
		saveBannerClient( $option );
		break;

	case 'removeclients':
		removeBannerClients( $cid, $option );
		break;

	case 'cancelclient':
		cancelEditClient( $option );
		break;

	case 'listclients':
		viewBannerClients( $option );
		break;

	// BANNER EVENTS

	case 'new':
		editBanner( null, $option );
		break;

	case 'cancel':
		cancelEditBanner();
		break;

	case 'save':
	case 'resethits':
		saveBanner( $task );
		break;

	case 'edit':
		editBanner( $cid[0], $option );
		break;

	case 'editA':
		editBanner( $id, $option );
		break;

	case 'remove':
		removeBanner( $cid );
		break;

	case 'publish':
		publishBanner( $cid,1 );
		break;

	case 'unpublish':
		publishBanner( $cid, 0 );
		break;

	default:
		viewBanners( $option );
		break;
}

function viewBanners( $option ) {
	global $database, $mainframe, $mosConfig_list_limit;

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "viewban{$option}limitstart", 'limitstart', 0 );

	// get the total number of records
	$database->setQuery( "SELECT count(*) FROM #__banner" );
	$total = $database->loadResult();

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit );

	$query = "SELECT b.*, u.name as editor FROM #__banner as b "
	. "\n LEFT JOIN #__users AS u ON u.id = b.checked_out"
	. "\nLIMIT $pageNav->limitstart,$pageNav->limit";
	$database->setQuery( $query );

	if(!$result = $database->query()) {
		echo $database->stderr();
		return;
	}
	$rows = $database->loadObjectList();
	HTML_banners::showBanners( $rows, $pageNav, $option );
}

function editBanner( $bannerid, $option ) {
	global $database, $my;
	$lists = array();

	$row = new mosBanner($database);
	$row->load( $bannerid );

  if ( $bannerid ){
    $row->checkout( $my->id );
  }
  
	// Build Client select list
	$sql	= "SELECT cid as value, name as text FROM #__bannerclient";
	$database->setQuery($sql);
	if (!$database->query()) {
		echo $database->stderr();
		return;
	}

	$clientlist[] = mosHTML::makeOption( '0', 'Select Client' );
	$clientlist = array_merge( $clientlist, $database->loadObjectList() );
	$lists['cid'] = mosHTML::selectList( $clientlist, 'cid', 'class="inputbox" size="1"','value', 'text', $row->cid);

	// Imagelist
	$javascript = 'onchange="changeDisplayImage();"';
	$directory = '/images/banners';
	$lists['imageurl'] = mosAdminMenus::Images( 'imageurl', $row->imageurl, $javascript, $directory );


	// make the select list for the image positions
	$yesno[] = mosHTML::makeOption( '0', 'No' );
  	$yesno[] = mosHTML::makeOption( '1', 'Yes' );
  
  	$lists['showBanner'] = mosHTML::selectList( $yesno, 'showBanner', 'class="inputbox" size="1"' , 'value', 'text', $row->showBanner );

	HTML_banners::bannerForm( $row, $lists, $option );
}

function saveBanner( $task ) {
	global $database;
	
	$row = new mosBanner($database);

	$msg = 'Saved Banner info';
	if ( $task == 'resethits' ) {
		$row->clicks = 0;
		$msg = 'Reset Banner clicks';
	}
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();

	mosRedirect( 'index2.php?option=com_banners', $msg );
}

function cancelEditBanner() {
	global $database;
	
	$row = new mosBanner($database);
	$row->bind( $_POST );
	$row->checkin();
	
	mosRedirect( 'index2.php?option=com_banners' );
}

function publishBanner( $cid, $publish=1 ) {
	global $database, $my;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__banner SET showBanner='$publish'"
	. "\nWHERE bid IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))"
	);
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (count( $cid ) == 1) {
		$row = new mosBanner( $database );
		$row->checkin( $cid[0] );
	}
	mosRedirect( 'index2.php?option=com_banners' );

}

function removeBanner( $cid ) {
	global $database;
	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$database->setQuery( "DELETE FROM #__banner WHERE bid IN ($cids)" );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
	}
	mosRedirect( 'index2.php?option=com_banners' );
}

// ---------- BANNER CLIENTS ----------

function viewBannerClients( $option ) {
	global $database, $mainframe, $mosConfig_list_limit;

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "viewcli{$option}limitstart", 'limitstart', 0 );

	// get the total number of records
	$database->setQuery( "SELECT count(*) FROM #__bannerclient" );
	$total = $database->loadResult();

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit );

	$sql = "SELECT a.*,	count(b.bid) AS bid, u.name AS editor"
	. "\n FROM #__bannerclient AS a"
	. "\n LEFT JOIN #__banner AS b ON a.cid = b.cid"
	. "\n LEFT JOIN #__users AS u ON u.id = a.checked_out"
	. "\n GROUP BY a.cid"
	. "\n LIMIT $pageNav->limitstart,$pageNav->limit";
	$database->setQuery($sql);

	if(!$result = $database->query()) {
		echo $database->stderr();
		return;
	}
	$rows = $database->loadObjectList();

	HTML_bannerClient::showClients( $rows, $pageNav, $option );
}

function editBannerClient( $clientid, $option ) {
	global $database, $my;
	
	$row = new mosBannerClient($database);
	$row->load($clientid);

	// fail if checked out not by 'me'
	if ($row->checked_out && $row->checked_out <> $my->id) {
		$msg = 'The client [ '. $row->name. ' ] is currently being edited by another person.';
		mosRedirect( 'index2.php?option='. $option .'&task=listclients', $msg );
	}

	if ($clientid) {
		// do stuff for existing record
		$row->checkout( $my->id );
	} else {
		// do stuff for new record
		$row->published = 0;
		$row->approved = 0;
	}

	HTML_bannerClient::bannerClientForm( $row, $option );
}

function saveBannerClient( $option ) {
	global $database;

	$row = new mosBannerClient( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->check()) {
		mosRedirect( "index2.php?option=$option&task=editclient&cid[]=$row->id", $row->getError() );
	}

	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();
	
	mosRedirect( "index2.php?option=$option&task=listclients" );
}

function cancelEditClient( $option ) {
	global $database;
	$row = new mosBannerClient( $database );
	$row->bind( $_POST );
	// sanitize
	$row->id = intval($row->id);
	$row->checkin();
	mosRedirect( "index2.php?option=$option&task=listclients" );
}

function removeBannerClients( $cid, $option ) {
	global $database;

	for ($i = 0; $i < count($cid); $i++) {
		$query = "SELECT COUNT(bid) FROM #__banner WHERE cid='".$cid[$i]."'";
		$database->setQuery($query);

		if(($count = $database->loadResult()) == null) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}

		if ($count != 0) {
			mosRedirect( "index2.php?option=$option&task=listclients",
			"Cannot delete client at this time as they have a banner still running" );
		} else {
			$query="DELETE FROM #__bannerfinish WHERE `cid`='".$cid[$i]."'";
			$database->setQuery($query);
			$database->query();

			$query="DELETE FROM #__bannerclient WHERE `cid`='".$cid[$i]."'";
			$database->setQuery($query);
			$database->query();
		}
	}
	mosRedirect("index2.php?option=$option&task=listclients");
}
?>
