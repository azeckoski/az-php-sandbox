<?php
/**
* PHP Evaluation Mambot
* author John Long <konlong@mail.mambobrothers.com>
* Based on the "Code Highliting Mambot" by eddieajau
**/
// $Id: moscode.php,v 1.1 2003/12/15 00:39:03 eddieajau Exp $
/**
* Code Highlighting Mambot
* @package Mambo Open Source
* @Copyright (C) 2000 - 2003 Miro International Pty Ltd
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.1 $
* @author Andrew Eddie <eddieajau@user.sourceforge.net>
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onPrepareContent', 'botKL_PHP' );

/**
* PHP Evaluation Mambot
*
* <b>Usage:</b>
* {kl_php}...some PHP code...end with a return;{/kl_php}
*/

function botKL_PHP( $published, &$row, &$params, $page=0 ) {

	$regex = "#{kl_php}(.*?){/kl_php}#s";

	// perform the replacement
	$row->text = preg_replace_callback( $regex, 'botKL_PHP_replacer', $row->text );

	return true;
}

function botKL_PHP_replacer( &$matches ) {
	global $mosConfig_absolute_path, $mosConfig_live_site, $database;

	$query = "SELECT id FROM #__mambots WHERE element = 'kl_php' AND folder = 'content'";
	$database->setQuery( $query );
	$kl_id = $database->loadResult();
	$mambot = new mosMambot( $database );
	$mambot->load( $kl_id );
	$bot_params =& new mosParameters( $mambot->params );
	$kl_entities = $bot_params->get( 'entities' );
	$kl_span = $bot_params->get( 'span' );
	$kl_ob = $bot_params->get( 'ob' );
	$kl_debug = $bot_params->get( 'debug' );

	if ($kl_debug) {
		print 'Debug-KL_PHP:<br />------<br />';
		print_r($matches[1]);
		print '<br />------<br />';
	}
	if ($kl_ob) ob_start();
	if ($kl_entities)
		$code = eval(html_entity_decode(@$matches[1] ));
	else
		$code = eval(@$matches[1]);
	if ($kl_ob) {
		$buf = ob_get_contents();
		ob_end_clean();
		$code .= $buf;
	}
	if ($kl_span)
    return  "<span class=\"kl_php\">$code</span>";
	else
    return  $code;
}
?>