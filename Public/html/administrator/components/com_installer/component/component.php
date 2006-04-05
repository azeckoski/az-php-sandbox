<?php
/**
* @version $Id: component.php,v 1.1 2005/07/22 01:52:30 eddieajau Exp $
* @package Mambo
* @subpackage Installer
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if ( !$acl->acl_check( 'administration', 'install', 'users', $my->usertype, $element . 's', 'all' ) ) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'installer_html', 'component' ) );

HTML_installer::showInstallForm( 'Install new Component', $option, 'component', '', dirname(__FILE__) );
?>
<table class="content">
<?php
writableCell( 'media' );
writableCell( 'administrator/components' );
writableCell( 'components' );
writableCell( 'images/stories' );
?>
</table>
<?php
showInstalledComponents( $option );

/**
* @param string The URL option
*/
function showInstalledComponents( $option ) {
	global $database, $mosConfig_absolute_path;

	$database->setQuery( "SELECT *"
	. "\n FROM #__components"
	. "\n WHERE parent = 0 AND iscore = 0"
	. "\n ORDER BY name"
	);
	$rows = $database->loadObjectList();

	// Read the component dir to find components
	$componentBaseDir	= mosPathName( $mosConfig_absolute_path . '/administrator/components' );
	$componentDirs = mosReadDirectory( $componentBaseDir );

	$n = count( $rows );
	for ($i = 0; $i < $n; $i++) {
	    $row =& $rows[$i];

		$dirName = $componentBaseDir . $row->option;
		$xmlFilesInDir = mosReadDirectory( $dirName, '.xml$' );

		foreach ($xmlFilesInDir as $xmlfile) {
			// Read the file to see if it's a valid component XML file
			$xmlDoc =& new DOMIT_Lite_Document();
			$xmlDoc->resolveErrors( true );

			if (!$xmlDoc->loadXML( $dirName . '/' . $xmlfile, false, true )) {
				continue;
			}

			$element = &$xmlDoc->documentElement;

			if ($element->getTagName() != 'mosinstall') {
				continue;
			}
			if ($element->getAttribute( "type" ) != "component") {
				continue;
			}

			$element = &$xmlDoc->getElementsByPath('creationDate', 1);
			$row->creationdate = $element ? $element->getText() : 'Unknown';

			$element = &$xmlDoc->getElementsByPath('author', 1);
			$row->author = $element ? $element->getText() : 'Unknown';

			$element = &$xmlDoc->getElementsByPath('copyright', 1);
			$row->copyright = $element ? $element->getText() : '';

			$element = &$xmlDoc->getElementsByPath('authorEmail', 1);
			$row->authorEmail = $element ? $element->getText() : '';

			$element = &$xmlDoc->getElementsByPath('authorUrl', 1);
			$row->authorUrl = $element ? $element->getText() : '';

			$element = &$xmlDoc->getElementsByPath('version', 1);
			$row->version = $element ? $element->getText() : '';

			$row->mosname = strtolower( str_replace( " ", "_", $row->name ) );
		}
	}

	HTML_component::showInstalledComponents( $rows, $option );
}
?>