<?php
/**
* @version $Id: toolbar.media.html.php,v 1.2 2005/11/08 10:26:19 eliasan Exp $
* @package Mambo
* @subpackage Massmail
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Massmail
*/
class TOOLBAR_media {
	/**
	* Draws the menu for a New Media
	*/

	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::custom('upload','upload.png','upload_f2.png','Upload',false);
		mosMenuBar::spacer();
		mosMenuBar::custom('newdir','new.png','new_f2.png','Create' ,false);
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.mediamanager' );
		mosMenuBar::endTable();
	}

}
?>
