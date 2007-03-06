<?php
/**
* @version $Id: admin.messages.php,v 1.1 2005/07/22 01:53:17 eddieajau Exp $
* @package Mambo
* @subpackage Messages
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

$task = trim( mosGetParam( $_REQUEST, 'task', null ) );
$cid = mosGetParam( $_REQUEST, 'cid', array( 0 ) );
if (!is_array( $cid )) {
	$cid = array ( 0 );
}

switch ($task) {
	case "view":
		viewMessage( $cid[0], $option );
		break;

	case "new":
		newMessage( $option, NULL, NULL );
		break;

	case "reply":
		newMessage(
			$option,
			mosGetParam( $_REQUEST, 'userid', 0 ),
			mosGetParam( $_REQUEST, 'subject', '' )
		);
		break;

	case "save":
		saveMessage( $option );
		break;

	case "remove":
		removeMessage( $cid, $option );
		break;

	case "config":
		editConfig( $option );
		break;

	case "saveconfig":
		saveConfig( $option );
		break;

	default:
		showMessages( $option );
		break;
}

function editConfig( $option ) {
	global $database, $my;

	$database->setQuery( "SELECT cfg_name, cfg_value FROM #__messages_cfg WHERE user_id='$my->id'" );
	$data = $database->loadObjectList( 'cfg_name' );

	$vars = array();
	$vars['lock'] = mosHTML::yesnoSelectList( "vars[lock]", 'class="inputbox" size="1"', @$data['lock']->cfg_value );
	$vars['mail_on_new'] = mosHTML::yesnoSelectList( "vars[mail_on_new]", 'class="inputbox" size="1"', @$data['mail_on_new']->cfg_value );

	HTML_messages::editConfig( $vars, $option );

}

function saveConfig( $option ) {
	global $database, $my;

	$database->setQuery( "DELETE FROM #__messages_cfg WHERE user_id='$my->id'" );
	$database->query();

	$vars = mosGetParam( $_POST, 'vars', array() );
	foreach ($vars as $k=>$v) {
		$v = $database->getEscaped( $v );
		$database->setQuery( "INSERT INTO #__messages_cfg (user_id,cfg_name,cfg_value)"
			. "\nVALUES ('$my->id','$k','$v')"
		);
		$database->query();
	}
	mosRedirect( "index2.php?option=$option" );
}

function newMessage( $option, $user, $subject ) {
	global $database, $mainframe, $my, $acl;

	// get available backend user groups
	$gid = $acl->get_group_id( 'Public Backend', 'ARO' );
	$gids = $acl->get_group_children( $gid, 'ARO', 'RECURSE' );
	$gids = implode( ',', $gids );

	// get list of usernames
	$recipients = array( mosHTML::makeOption( '0', '- Select User -' ) );
	$database->setQuery( "SELECT id AS value, username AS text FROM #__users"
	."\n WHERE gid IN ($gids)"
	. "\n ORDER BY name" );
	$recipients = array_merge( $recipients, $database->loadObjectList() );

	$recipientslist =
		mosHTML::selectList(
			$recipients,
			'user_id_to',
			'class="inputbox" size="1"',
			'value',
			'text',
            $user
		);
	HTML_messages::newMessage($option, $recipientslist, $subject );
}

function saveMessage( $option ) {
	global $database, $mainframe, $my;

	$row = new mosMessage( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/phpInputFilter/class.inputfilter.php');
	$iFilter = new InputFilter( null, null, 1, 1 );
	$row->subject = trim( $iFilter->process( $row->subject ) );
	$row->message = trim( $iFilter->process( $row->message ) );


	if (!$row->send()) {
		mosRedirect( "index2.php?option=com_messages&mosmsg=" . $row->getError() );
	}
	mosRedirect( "index2.php?option=com_messages" );
}

function showMessages( $option ) {
	global $database, $mainframe, $my, $mosConfig_list_limit;

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	$search = $database->getEscaped( trim( strtolower( $search ) ) );

	$wheres = array();
	$wheres[] = " a.user_id_to='$my->id'";

	if (isset($search) && $search!= "") {
		$wheres[] = "(u.username LIKE '%$search%' OR email LIKE '%$search%' OR u.name LIKE '%$search%')";
	}

	$database->setQuery( "SELECT COUNT(*)"
		. "\nFROM #__messages AS a"
		. "\nINNER JOIN #__users AS u ON u.id = a.user_id_from"
		. ($wheres ? " WHERE " . implode( " AND ", $wheres ) : "" )
	);
	$total = $database->loadResult();

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	$database->setQuery( "SELECT a.*, u.name AS user_from"
		. "\nFROM #__messages AS a"
		. "\nINNER JOIN #__users AS u ON u.id = a.user_id_from"
		. ($wheres ? " WHERE " . implode( " AND ", $wheres ) : "" )
		. "\nORDER BY date_time DESC"
		. "\nLIMIT $pageNav->limitstart, $pageNav->limit"
	);

	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	HTML_messages::showMessages( $rows, $pageNav, $search, $option );
}

function viewMessage( $uid='0', $option ) {
	global $database, $my, $acl;

	$row = null;
	$database->setQuery( "SELECT a.*, u.name AS user_from"
		. "\nFROM #__messages AS a"
		. "\nINNER JOIN #__users AS u ON u.id = a.user_id_from"
		. "\nWHERE a.message_id='$uid'"
		. "\nORDER BY date_time DESC"
	);
	$database->loadObject( $row );

	$database->setQuery( "UPDATE #__messages SET state='1' WHERE message_id='$uid'" );
	$database->query();

	HTML_messages::viewMessage( $row, $option );
}

function removeMessage( $cid, $option ) {
	global $database;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$database->setQuery( "DELETE FROM #__messages WHERE message_id IN ($cids)" );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
	}

	$limit = intval( mosGetParam( $_REQUEST, 'limit', 10 ) );
	$limitstart	= intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
	mosRedirect( "index2.php?option=$option&limit=$limit&limitstart=$limitstart" );
}

?>