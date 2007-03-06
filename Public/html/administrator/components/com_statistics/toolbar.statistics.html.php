<?php
/**
* @version $Id: toolbar.statistics.html.php,v 1.1 2005/07/22 01:53:22 eddieajau Exp $
* @package Mambo
* @subpackage Statistics
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Statistics
*/
class TOOLBAR_statistics {
	function _SEARCHES() {
		mosMenuBar::startTable();
		mosMenuBar::help( '453.screen.stats.searches' );
		mosMenuBar::endTable();
	}
}
?>
