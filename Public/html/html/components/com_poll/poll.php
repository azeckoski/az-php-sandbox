<?php
/**
* @version $Id: poll.php,v 1.3 2005/08/17 05:55:46 eddieajau Exp $
* @package Mambo
* @subpackage Polls
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'front_html' ) );
require_once( $mainframe->getPath( 'class' ) );

$tabclass 			= 'sectiontableentry2,sectiontableentry1';
$polls_graphwidth 	= 200;
$polls_barheight 	= 2;
$polls_maxcolors 	= 5;
$polls_barcolor 	= 0;

$poll = new mosPoll( $database );

$id 	= intval( mosGetParam( $_REQUEST, 'id', 0 ) );
$task 	= mosGetParam( $_REQUEST, 'task', '' );

switch ($task) {

	case 'vote':
		pollAddVote( $id );
		break;

	default:
		pollresult( $id );
		break;
}

function pollAddVote( $uid ) {
	global $database, $mosConfig_offset, $Itemid;

	$redirect = 1;

	$sessionCookieName = md5( 'site'.$GLOBALS['mosConfig_live_site'] );
	$sessioncookie = mosGetParam( $_REQUEST, $sessionCookieName, '' );

	if (!$sessioncookie) {
		echo '<h3>'. _ALERT_ENABLED .'"</h3>';
		echo '<input class="button" type="button" value="'. _CMN_CONTINUE .'" onClick="window.history.go(-1);">';
		return;
	}

	$poll = new mosPoll( $database );
	if (!$poll->load( $uid )) {
		echo '<h3>'. _NOT_AUTH .'</h3>';
		echo '<input class="button" type="button" value="'. _CMN_CONTINUE .'" onClick="window.history.go(-1);">';
		return;
	}

	$cookiename = "voted$poll->id";
	$voted = mosGetParam( $_COOKIE, $cookiename, '0' );

	if ($voted) {
		echo "<h3>"._ALREADY_VOTE."</h3>";
		echo "<input class=\"button\" type=\"button\" value=\""._CMN_CONTINUE."\" onClick=\"window.history.go(-1);\">";
		return;
	}

	$voteid = mosGetParam( $_POST, 'voteid', 0 );
	if (!$voteid) {
		echo "<h3>"._NO_SELECTION."</h3>";
		echo '<input class="button" type="button" value="'. _CMN_CONTINUE .'" onClick="window.history.go(-1);">';
		return;
	}

	setcookie( $cookiename, '1', time()+$poll->lag );

	$database->setQuery( "UPDATE #__poll_data SET hits=hits + 1"
		."\n WHERE pollid='$poll->id' AND id='$voteid'");

	$database->query();

	$database->setQuery( "UPDATE #__polls SET voters=voters + 1"
		."\n WHERE id='$poll->id'");

	$database->query();

	$now = date("Y-m-d G:i:s");
	$database->setQuery( "INSERT INTO #__poll_date SET date='$now', vote_id='$voteid',	poll_id='$poll->id'");

	$database->query();
	if ( $redirect ) {
		mosRedirect( sefRelToAbs( 'index.php?option=com_poll&task=results&id='. $uid ), _THANKS );
	} else {
		echo '<h3>'. _THANKS .'</h3>';
		echo '<form action="" method="GET">';
		echo '<input class="button" type="button" value="'. _BUTTON_RESULTS .'" onClick="window.location=\''. sefRelToAbs( 'index.php?option=com_poll&task=results&id='. $uid ) .'\'">';
		echo '</form>';
	}
}


function pollresult( $uid ) {
	global $database, $mosConfig_offset, $mosConfig_live_site, $Itemid;
	global $mainframe;

	$poll = new mosPoll( $database );
	$poll->load( $uid );

	if (empty($poll->title)) {
		$poll->id = '';
		$poll->title = _SELECT_POLL;
	}

	$first_vote = '';
	$last_vote = '';

	if (isset($poll->id) && $poll->id != "") {
		$query = "SELECT MIN(date) AS mindate, MAX(date) AS maxdate"
		."\n FROM #__poll_date"
		."\n WHERE poll_id='$poll->id'"
		;
		$database->setQuery( $query );

		$dates = $database->loadObjectList();

		if (isset($dates[0]->mindate)) {
			$first_vote = mosFormatDate( $dates[0]->mindate, _DATE_FORMAT_LC2 );
			$last_vote = mosFormatDate( $dates[0]->maxdate, _DATE_FORMAT_LC2 );
		}
	}

	$query = "SELECT a.id, a.text, count( DISTINCT b.id ) AS hits, count( DISTINCT b.id )/COUNT( DISTINCT a.id )*100.0 AS percent"
	. "\n FROM #__poll_data AS a"
	. "\n LEFT JOIN #__poll_date AS b ON b.vote_id = a.id"
	. "\n WHERE a.pollid='$poll->id' AND a.text <> ''"
	. "\n GROUP BY a.id"
	. "\n ORDER BY a.id"
	;
	$database->setQuery( $query );
	$votes = $database->loadObjectList();

	$query = "SELECT id, title"
	. "\n FROM #__polls"
	. "\n WHERE published=1"
	. "\n ORDER BY id"
	;
	$database->setQuery( $query );
	$polls = $database->loadObjectList();

	reset( $polls );
	$link = sefRelToAbs( 'index.php?option=com_poll&amp;task=results&amp;id=\' + this.options[selectedIndex].value + \'&amp;Itemid='. $Itemid .'\' + \'' );
	$pollist = '<select name="id" class="inputbox" size="1" style="width:200px" onchange="if (this.options[selectedIndex].value != \'\') {document.location.href=\''. $link .'\'}">';
	$pollist .= '<option value="">'. _SELECT_POLL .'</option>';
	for ($i=0, $n=count( $polls ); $i < $n; $i++ ) {
		$k = $polls[$i]->id;
		$t = $polls[$i]->title;

		$sel = ($k == intval( $poll->id ) ? " selected=\"selected\"" : '');
		$pollist .= "\n\t<option value=\"".$k."\"$sel>" . $t . "</option>";
	}
	$pollist .= '</select>';

	// Adds parameter handling
	$menu =& new mosMenu( $database );
	$menu->load( $Itemid );

	$params =& new mosParameters( $menu->params );
	$params->def( 'page_title', 1 );
	$params->def( 'pageclass_sfx', '' );
	$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
	$params->def( 'header', $menu->name );

	$mainframe->SetPageTitle($poll->title);

	poll_html::showResults( $poll, $votes, $first_vote, $last_vote, $pollist, $params );
}
?>
