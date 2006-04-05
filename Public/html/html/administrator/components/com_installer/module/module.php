<?php
/**
* @version $Id: module.php,v 1.1 2005/07/22 01:52:34 eddieajau Exp $
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

require_once( $mainframe->getPath( 'installer_html', 'module' ) );

HTML_installer::showInstallForm( 'Install new Modules', $option, 'module', '', dirname(__FILE__) );
?>
<table class="content">
<?php
writableCell( 'media' );
writableCell( 'administrator/modules' );
writableCell( 'modules' );
?>
</table>
<?php
showInstalledModules( $option );

/**
* @param string The URL option
*/
function showInstalledModules( $_option ) {
	global $database, $mosConfig_absolute_path;

	$filter = mosGetParam( $_POST, 'filter', '' );
	$select[] = mosHTML::makeOption( '', 'All' );
	$select[] = mosHTML::makeOption( '0', 'Site Modules' );
	$select[] = mosHTML::makeOption( '1', 'Admin Modules' );
	$lists['filter'] = mosHTML::selectList( $select, 'filter', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $filter );
	if ( $filter == NULL ) {
		$and = '';
	} else if ( !$filter ) {
		$and = "\n AND client_id = '0'";
	} else if ( $filter ) {
		$and = "\n AND client_id = '1'";
	}

	$database->setQuery( "SELECT id, module, client_id"
		. "\n FROM #__modules"
		. "\n WHERE module LIKE 'mod_%' AND iscore='0'"
		. $and
		. "\n GROUP BY module, client_id"
		. "\n ORDER BY client_id, module"
	);
	$rows = $database->loadObjectList();

	$n = count( $rows );
	for ($i = 0; $i < $n; $i++) {
	    $row =& $rows[$i];

		// path to module directory
		if ($row->client_id == "1"){
			$moduleBaseDir	= mosPathName( mosPathName( $mosConfig_absolute_path ) . "administrator/modules" );
		} else {
			$moduleBaseDir	= mosPathName( mosPathName( $mosConfig_absolute_path ) . "modules" );
		}

		// xml file for module
		$xmlfile = $moduleBaseDir. "/" .$row->module .".xml";

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
			if ($element->getAttribute( "type" ) != "module") {
				continue;
			}

			$element = &$xmlDoc->getElementsByPath( 'creationDate', 1 );
			$row->creationdate = $element ? $element->getText() : '';

			$element = &$xmlDoc->getElementsByPath( 'author', 1 );
			$row->author = $element ? $element->getText() : '';

			$element = &$xmlDoc->getElementsByPath( 'copyright', 1 );
			$row->copyright = $element ? $element->getText() : '';

			$element = &$xmlDoc->getElementsByPath( 'authorEmail', 1 );
			$row->authorEmail = $element ? $element->getText() : '';

			$element = &$xmlDoc->getElementsByPath( 'authorUrl', 1 );
			$row->authorUrl = $element ? $element->getText() : '';

			$element = &$xmlDoc->getElementsByPath( 'version', 1 );
			$row->version = $element ? $element->getText() : '';
    	}
	}

	HTML_module::showInstalledModules( $rows, $_option, $xmlfile, $lists );
}
?>
