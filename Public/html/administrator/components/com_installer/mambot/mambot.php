<?php
/**
* @version $Id: mambot.php,v 1.1 2005/07/22 01:52:34 eddieajau Exp $
* @package Mambo
* @subpackage Installer
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
* */

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if ( !$acl->acl_check( 'administration', 'install', 'users', $my->usertype, $element . 's', 'all' ) ) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'installer_html', 'mambot' ) );

HTML_installer::showInstallForm( 'Install new Mambots', $option, 'mambot', '', dirname(__FILE__) );
?>
<table class="content">
<?php
writableCell( 'media' );
writableCell( 'language' );
writableCell( 'mambots' );
writableCell( 'mambots/content' );
writableCell( 'mambots/search' );
?>
</table>
<?php
showInstalledMambots( $option );

function showInstalledMambots( $_option ) {
	global $database, $mosConfig_absolute_path;

	$database->setQuery( "SELECT id, name, folder, element, client_id"
	. "\n FROM #__mambots"
	. "\n WHERE iscore='0'"
	. "\n ORDER BY folder, name"
	);
	$rows = $database->loadObjectList();

	// path to mambot directory
	$mambotBaseDir	= mosPathName( mosPathName( $mosConfig_absolute_path ) . "mambots" );

	$id = 0;
	$n = count( $rows );
	for ($i = 0; $i < $n; $i++) {
	    $row =& $rows[$i];
		// xml file for module
		$xmlfile = $mambotBaseDir. "/" .$row->folder . '/' . $row->element .".xml";

		if (file_exists( $xmlfile )) {
			$xmlDoc =& new DOMIT_Lite_Document();
			$xmlDoc->resolveErrors( true );
			if (!$xmlDoc->loadXML( $xmlfile, false, true )) {
				continue;
			}

			$element = &$xmlDoc->documentElement;

			if ($element->getTagName() != 'mosinstall') {
				continue;
			}
			if ($element->getAttribute( "type" ) != "mambot") {
				continue;
			}

			$element = &$xmlDoc->getElementsByPath('creationDate', 1);
			$row->creationdate = $element ? $element->getText() : '';

			$element = &$xmlDoc->getElementsByPath('author', 1);
			$row->author = $element ? $element->getText() : '';

			$element = &$xmlDoc->getElementsByPath('copyright', 1);
			$row->copyright = $element ? $element->getText() : '';

			$element = &$xmlDoc->getElementsByPath('authorEmail', 1);
			$row->authorEmail = $element ? $element->getText() : '';

			$element = &$xmlDoc->getElementsByPath('authorUrl', 1);
			$row->authorUrl = $element ? $element->getText() : '';

			$element = &$xmlDoc->getElementsByPath('version', 1);
			$row->version = $element ? $element->getText() : '';
		}
	}

	HTML_mambot::showInstalledMambots($rows, $_option, $id, $xmlfile );
}
?>