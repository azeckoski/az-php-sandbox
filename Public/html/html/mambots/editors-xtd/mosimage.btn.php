<?php
/**
* @version $Id: mosimage.btn.php,v 1.1 2005/07/22 01:57:50 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onCustomEditorButton', 'botMosImageButton' );

/**
* mosimage button
* @return array A two element array of ( imageName, textToInsert )
*/
function botMosImageButton() {
	global $mosConfig_live_site;
	return array( 'mosimage.gif', '{mosimage}' );
}
?>