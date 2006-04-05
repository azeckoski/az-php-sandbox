<?php
/**
* @version $Id: toolbar.installer.html.php,v 1.2 2005/11/08 10:26:19 eliasan Exp $
* @package Mambo
* @subpackage Installer
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/**
* @package Mambo
* @subpackage Installer
*/
class TOOLBAR_installer
{
	function _DEFAULT()	{
		mosMenuBar::startTable();
		mosMenuBar::help( '453.screen.installer.lang' );
		mosMenuBar::endTable();
	}

	function _DEFAULT2()	{
		mosMenuBar::startTable();
		mosMenuBar::deleteList( '', 'remove', 'Uninstall' );
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.installer.cmm' );
		mosMenuBar::endTable();
	}

	function _NEW()	{
		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}
}
?>
