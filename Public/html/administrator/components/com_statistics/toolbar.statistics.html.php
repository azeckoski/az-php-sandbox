<?php
/**
* @version $Id: toolbar.statistics.html.php,v 1.5 2005/02/11 01:26:42 levis Exp $
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
		mosMenuBar::help( 'screen.stats.searches' );
		mosMenuBar::endTable();
	}
}
?>
