<?php
/**
* @version $Id: admin.templates.php,v 1.1 2005/07/22 01:53:31 eddieajau Exp $
* @package Mambo
* @subpackage Templates
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!$acl->acl_check( 'administration', 'manage', 'users', $GLOBALS['my']->usertype, 'components', 'com_templates' )) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mosConfig_absolute_path .'/administrator/components/com_templates/admin.templates.class.php' );
// XML library
require_once( $mosConfig_absolute_path .'/includes/domit/xml_domit_lite_include.php' );

$task = trim( strtolower( mosGetParam( $_REQUEST, "task", "" ) ) );
$cid = mosGetParam( $_REQUEST, "cid", array(0) );
$client = mosGetParam( $_REQUEST, 'client', '' );

if (!is_array( $cid )) {
	$cid = array(0);
}

switch ($task) {
	case 'new':
		mosRedirect ( 'index2.php?option=com_installer&element=template&client='. $client );
		break;

	case 'edit_source':
		editTemplateSource( $cid[0], $option, $client );
		break;

	case 'save_source':
		saveTemplateSource( $option, $client );
		break;

	case 'edit_css':
		editTemplateCSS( $cid[0], $option, $client );
		break;

	case 'save_css':
		saveTemplateCSS( $option, $client );
		break;

	case 'remove':
		removeTemplate( $cid[0], $option, $client );
		break;

	case 'publish':
		defaultTemplate( $cid[0], $option, $client );
		break;

	case 'default':
		defaultTemplate( $cid[0], $option, $client );
		break;

	case 'assign':
		assignTemplate( $cid[0], $option, $client );
		break;

	case 'save_assign':
		saveTemplateAssign( $option, $client );
		break;

	case 'cancel':
		mosRedirect( 'index2.php?option='. $option .'&client='. $client );
		break;

	case 'positions':
	    editPositions( $option );
	    break;

	case 'save_positions':
	    savePositions( $option );
	    break;

	default:
		viewTemplates( $option, $client );
		break;
}


/**
* Compiles a list of installed, version 4.5+ templates
*
* Based on xml files found.  If no xml file found the template
* is ignored
*/
function viewTemplates( $option, $client ) {
	global $database, $mainframe;
	global $mosConfig_absolute_path, $mosConfig_list_limit;

	$limit = $mainframe->getUserStateFromRequest( 'viewlistlimit', 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

	if ($client == 'admin') {
		$templateBaseDir = mosPathName( $mosConfig_absolute_path . '/administrator/templates' );
	} else {
		$templateBaseDir = mosPathName( $mosConfig_absolute_path . '/templates' );
	}

	$rows = array();
	// Read the template dir to find templates
	$templateDirs		= mosReadDirectory($templateBaseDir);

	$id = intval( $client == 'admin' );

	if ($client=='admin') {
		$database->setQuery( "SELECT template FROM #__templates_menu WHERE client_id='1' AND menuid='0'" );
	} else {
		$database->setQuery( "SELECT template FROM #__templates_menu WHERE client_id='0' AND menuid='0'" );
	}
	$cur_template = $database->loadResult();

	$rowid = 0;
	// Check that the directory contains an xml file
	foreach($templateDirs as $templateDir) {
		$dirName = mosPathName($templateBaseDir . $templateDir);
		$xmlFilesInDir = mosReadDirectory($dirName,'.xml$');

		foreach($xmlFilesInDir as $xmlfile) {
			// Read the file to see if it's a valid template XML file
			$xmlDoc =& new DOMIT_Lite_Document();
			$xmlDoc->resolveErrors( true );
			if (!$xmlDoc->loadXML( $dirName . $xmlfile, false, true )) {
				continue;
			}

			$element = &$xmlDoc->documentElement;

			if ($element->getTagName() != 'mosinstall') {
				continue;
			}
			if ($element->getAttribute( 'type' ) != 'template') {
				continue;
			}

			$row = new StdClass();
			$row->id = $rowid;
			$row->directory = $templateDir;
			$element = &$xmlDoc->getElementsByPath('name', 1 );
			$row->name = $element->getText();

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

			// Get info from db
			if ($cur_template == $templateDir) {
				$row->published	= 1;
			} else {
				$row->published = 0;
			}

			$row->checked_out = 0;
			$row->mosname = strtolower( str_replace( ' ', '_', $row->name ) );

			// check if template is assigned
			$database->setQuery( "SELECT count(*) FROM #__templates_menu WHERE client_id='0' AND template='$row->directory' AND menuid<>'0'" );
			$row->assigned = $database->loadResult() ? 1 : 0;

			$rows[] = $row;
			$rowid++;
		}
	}

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( count( $rows ), $limitstart, $limit );

	$rows = array_slice( $rows, $pageNav->limitstart, $pageNav->limit );

	HTML_templates::showTemplates( $rows, $pageNav, $option, $client );
}


/**
* Publish, or make current, the selected template
*/
function defaultTemplate( $p_tname, $option, $client ) {
	global $database;

	if ($client=='admin') {
		$database->setQuery("DELETE FROM #__templates_menu WHERE client_id='1' AND menuid='0'");
		$database->query();

		$database->setQuery("INSERT INTO #__templates_menu SET client_id='1', template='$p_tname', menuid='0'");
		$database->query();
	} else {
		$database->setQuery("DELETE FROM #__templates_menu WHERE client_id='0' AND menuid='0'");
		$database->query();

		$database->setQuery("INSERT INTO #__templates_menu SET client_id='0', template='$p_tname', menuid='0'");
		$database->query();

		$_SESSION['cur_template'] = $p_tname;
	}

	mosRedirect('index2.php?option='. $option .'&client='. $client);
}

/**
* Remove the selected template
*/
function removeTemplate( $cid, $option, $client ) {
	global $database;

	$client_id = $client=='admin' ? 1 : 0;

	$database->setQuery("SELECT template FROM #__templates_menu WHERE client_id='$client_id' AND menuid='0'");
	$cur_template = $database->loadResult();

	if ($cur_template == $cid) {
		echo "<script>alert(\"You can not delete template in use.\"); window.history.go(-1); </script>\n";
		exit();
	}

	// Un-assign

	$database->setQuery( "DELETE FROM #__templates_menu WHERE template='$cid' AND client_id='$client_id' AND menuid<>'0'" );
	$database->query();

	mosRedirect( 'index2.php?option=com_installer&element=template&client='. $client .'&task=remove&cid[]='. $cid );
}

function editTemplateSource( $p_tname, $option, $client ) {
	global $mosConfig_absolute_path;

	if ( $client == 'admin' ) {
		$file = $mosConfig_absolute_path .'/administrator/templates/'. $p_tname .'/index.php';
	} else {
		$file = $mosConfig_absolute_path .'/templates/'. $p_tname .'/index.php';
	}

	if ( $fp = fopen( $file, 'r' ) ) {
		$content = fread( $fp, filesize( $file ) );
		$content = htmlspecialchars( $content );

		HTML_templates::editTemplateSource( $p_tname, $content, $option, $client );
	} else {
		mosRedirect( 'index2.php?option='. $option .'&client='. $client, 'Operation Failed: Could not open'. $file );
	}
}


function saveTemplateSource( $option, $client ) {
	global $mosConfig_absolute_path;

	$template = mosGetParam( $_POST, 'template', '' );
	$filecontent = mosGetParam( $_POST, 'filecontent', '', _MOS_ALLOWHTML );

	if ( !$template ) {
		mosRedirect( 'index2.php?option='. $option .'&client='. $client, 'Operation failed: No template specified.' );
	}
	if ( !$filecontent ) {
		mosRedirect( 'index2.php?option='. $option .'&client='. $client, 'Operation failed: Content empty.' );
	}

	if ( $client == 'admin' ) {
		$file = $mosConfig_absolute_path .'/administrator/templates/'. $template .'/index.php';
	} else {
		$file = $mosConfig_absolute_path .'/templates/'. $template .'/index.php';
	}

    $enable_write = mosGetParam($_POST,'enable_write',0);
	$oldperms = fileperms($file);
	if ($enable_write) @chmod($file, $oldperms | 0222);

	clearstatcache();
	if ( is_writable( $file ) == false ) {
		mosRedirect( 'index2.php?option='. $option , 'Operation failed: '. $file .' is not writable.' );
	}

	if ( $fp = fopen ($file, 'w' ) ) {
		fputs( $fp, stripslashes( $filecontent ), strlen( $filecontent ) );
		fclose( $fp );
		if ($enable_write) {
			@chmod($file, $oldperms);
		} else {
			if (mosGetParam($_POST,'disable_write',0))
				@chmod($file, $oldperms & 0777555);
		} // if
		mosRedirect( 'index2.php?option='. $option .'&client='. $client );
	} else {
		if ($enable_write) @chmod($file, $oldperms);
		mosRedirect( 'index2.php?option='. $option .'&client='. $client, 'Operation failed: Failed to open file for writing.' );
	}

}

function editTemplateCSS( $p_tname, $option, $client ) {
	global $mosConfig_absolute_path;

	if ( $client == 'admin' ) {
		$file = $mosConfig_absolute_path .'/administrator/templates/'. $p_tname .'/css/template_css.css';
	} else {
		$file = $mosConfig_absolute_path .'/templates/'. $p_tname .'/css/template_css.css';
	}

	if ($fp = fopen( $file, 'r' )) {
		$content = fread( $fp, filesize( $file ) );
		$content = htmlspecialchars( $content );

		HTML_templates::editCSSSource( $p_tname, $content, $option, $client );
	} else {
		mosRedirect( 'index2.php?option='. $option .'&client='. $client, 'Operation Failed: Could not open'. $file );
	}
}


function saveTemplateCSS( $option, $client ) {
	global $mosConfig_absolute_path;
	$template = trim( mosGetParam( $_POST, 'template', '' ) );
	$filecontent = mosGetParam( $_POST, 'filecontent', '', _MOS_ALLOWHTML );

	if ( !$template ) {
		mosRedirect( 'index2.php?option='. $option .'&client='. $client, 'Operation failed: No template specified.' );
	}

	if ( !$filecontent ) {
		mosRedirect( 'index2.php?option='. $option .'&client='. $client, 'Operation failed: Content empty.' );
	}

	if ( $client == 'admin' ) {
		$file = $mosConfig_absolute_path .'/administrator/templates/'. $template .'/css/template_css.css';
	} else {
		$file = $mosConfig_absolute_path .'/templates/'. $template .'/css/template_css.css';
	}

    $enable_write = mosGetParam($_POST,'enable_write',0);
	$oldperms = fileperms($file);
	if ($enable_write) @chmod($file, $oldperms | 0222);

	clearstatcache();
	if ( is_writable( $file ) == false ) {
		mosRedirect( 'index2.php?option='. $option .'&client='. $client, 'Operation failed: The file is not writable.' );
	}

	if ($fp = fopen ($file, 'w')) {
		fputs( $fp, stripslashes( $filecontent ) );
		fclose( $fp );
		if ($enable_write) {
			@chmod($file, $oldperms);
		} else {
			if (mosGetParam($_POST,'disable_write',0))
				@chmod($file, $oldperms & 0777555);
		} // if
		mosRedirect( 'index2.php?option='. $option );
	} else {
		if ($enable_write) @chmod($file, $oldperms);
		mosRedirect( 'index2.php?option='. $option .'&client='. $client, 'Operation failed: Failed to open file for writing.' );
	}

}


function assignTemplate( $p_tname, $option, $client ) {
	global $database;

	// get selected pages for $menulist
	if ( $p_tname ) {
		$database->setQuery( "SELECT menuid AS value FROM #__templates_menu WHERE client_id='0' AND template='$p_tname'" );
		$lookup = $database->loadObjectList();
	}

	// build the html select list
	$menulist = mosAdminMenus::MenuLinks( $lookup, 0, 1 );

	HTML_templates::assignTemplate( $p_tname, $menulist, $option, $client );
}


function saveTemplateAssign( $option, $client ) {
	global $database;

	$menus = mosGetParam( $_POST, 'selections', array() );
	$template = mosGetParam( $_POST, 'template', '' );

	$database->setQuery( "DELETE FROM #__templates_menu WHERE client_id='0' AND template='$template' AND menuid<>'0'" );
	$database->query();

	if ( !in_array( '', $menus ) ) {
		foreach ( $menus as $menuid ){
			// If 'None' is not in array
			if ( $menuid <> -999 ) {
				// check if there is already a template assigned to this menu item
				$database->setQuery( "DELETE FROM #__templates_menu WHERE client_id='0' AND menuid='$menuid'" );
				$database->query();
				$database->setQuery( "INSERT INTO #__templates_menu SET client_id='0', template='$template', menuid='$menuid'" );
				$database->query();
			}
		}
	}

	mosRedirect( 'index2.php?option='. $option .'&client='. $client );
}


/**
*/
function editPositions( $option ) {
	global $database;

	$database->setQuery( "SELECT * FROM #__template_positions" );
	$positions = $database->loadObjectList();

	HTML_templates::editPositions( $positions, $option );
}

/**
*/
function savePositions( $option ) {
	global $database;

	$positions = mosGetParam( $_POST, 'position', array() );
	$descriptions = mosGetParam( $_POST, 'description', array() );

	$query = 'DELETE FROM #__template_positions';
	$database->setQuery( $query );
	$database->query();

	foreach ($positions as $id=>$position) {
	    $position = trim( $database->getEscaped( $position ) );
	    $description = mosGetParam( $descriptions, $id, '' );
		if ($position != '') {
		    $id = intval( $id );
		    $query = "INSERT INTO #__template_positions"
				. "\nVALUES ($id,'$position','$description')";
			$database->setQuery( $query );
			$database->query();
		}
	}
	mosRedirect( 'index2.php?option='. $option .'&task=positions', 'Positions saved' );
}
?>