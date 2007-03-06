<?php
/**
* @version $Id: mosvote.php,v 1.1 2005/07/22 01:57:49 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onBeforeDisplayContent', 'botVoting' );

function botVoting( &$row, &$params, $page=0 ) {
	global $mosConfig_live_site, $mosConfig_absolute_path, $cur_template;
	global $Itemid;
	$id = $row->id;
	$option = 'com_content';
	$task = mosGetParam( $_REQUEST, 'task', '' );

	$html = '';
	if ($params->get( 'rating' ) && !$params->get( 'popup' )){
		$html .= '<form method="post" action="' . sefRelToAbs( 'index.php' ) . '">';
		$img = '';

		// look for images in template if available
		$starImageOn = mosAdminMenus::ImageCheck( 'rating_star.png', '/images/M_images/' );
		$starImageOff = mosAdminMenus::ImageCheck( 'rating_star_blank.png', '/images/M_images/' );

		for ($i=0; $i < $row->rating; $i++) {
			$img .= $starImageOn;
		}
		for ($i=$row->rating; $i < 5; $i++) {
			$img .= $starImageOff;
		}
		$html .= '<span class="content_rating">';
		$html .= _USER_RATING . ':' . $img . '&nbsp;/&nbsp;';
		$html .= intval( $row->rating_count );
		$html .= "</span>\n<br />\n";
		$url = @$_SERVER['REQUEST_URI'];
		$url = ampReplace( $url );

		require_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/phpInputFilter/class.inputfilter.php');
		$iFilter = new InputFilter( null, null, 1, 1 );
		$url = trim( $iFilter->process( $url ) );

		if (!$params->get( 'intro_only' ) && $task != "blogsection") {
			$html .= '<span class="content_vote">';
			$html .= _VOTE_POOR;
			$html .= '<input type="radio" alt="vote 1 star" name="user_rating" value="1" />';
			$html .= '<input type="radio" alt="vote 2 star" name="user_rating" value="2" />';
			$html .= '<input type="radio" alt="vote 3 star" name="user_rating" value="3" />';
			$html .= '<input type="radio" alt="vote 4 star" name="user_rating" value="4" />';
			$html .= '<input type="radio" alt="vote 5 star" name="user_rating" value="5" checked="checked" />';
			$html .= _VOTE_BEST;
			$html .= '&nbsp;<input class="button" type="submit" name="submit_vote" value="'. _RATE_BUTTON .'" />';
			$html .= '<input type="hidden" name="task" value="vote" />';
			$html .= '<input type="hidden" name="pop" value="0" />';
			$html .= '<input type="hidden" name="option" value="com_content" />';
			$html .= '<input type="hidden" name="Itemid" value="'. $Itemid .'" />';
			$html .= '<input type="hidden" name="cid" value="'. $id .'" />';
			$html .= '<input type="hidden" name="url" value="'. $url .'" />';
			$html .= '</span>';
		}
		$html .= "</form>\n";
	}
	return $html;
}
?>
