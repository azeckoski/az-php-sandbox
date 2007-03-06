<?php
/**
* @version $Id: admin.languages.php,v 1.1 2005/07/22 01:52:34 eddieajau Exp $
* @package Mambo
* @subpackage Languages
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!$acl->acl_check( 'administration', 'config', 'users', $my->usertype )) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}


require_once( $mainframe->getPath( 'admin_html' ) );
// XML library
require_once( "$mosConfig_absolute_path/includes/domit/xml_domit_lite_include.php" );

$task = trim( strtolower( mosGetParam( $_REQUEST, "task", "" ) ) );
$cid = mosGetParam( $_REQUEST, "cid", array(0) );

if (!is_array( $cid )) {
	$cid = array(0);
}

switch ($task) {
	case "new":
	mosRedirect( "index2.php?option=com_installer&element=language" );
	break;

	case "edit_source":
	editLanguageSource( $cid[0], $option );
	break;

	case "save_source":
	saveLanguageSource( $option );
	break;

	case "remove":
	removeLanguage( $cid[0], $option );
	break;

	case "publish":
	publishLanguage( $cid[0], $option );
	break;

	case "cancel":
	mosRedirect( "index2.php?option=$option" );
	break;

	default:
	viewLanguages( $option );
	break;
}

/**
* Compiles a list of installed languages
*/
function viewLanguages( $option ) {
	global $languages;
	global $mainframe;
	global $mosConfig_lang, $mosConfig_absolute_path, $mosConfig_list_limit;

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

	// get current languages
	$cur_language = $mosConfig_lang;

	$rows = array();
	// Read the template dir to find templates
	$languageBaseDir = mosPathName(mosPathName($mosConfig_absolute_path) . "language");

	$rowid = 0;

	$xmlFilesInDir = mosReadDirectory($languageBaseDir,'.xml$');

	$dirName = $languageBaseDir;
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
		if ($element->getAttribute( "type" ) != "language") {
			continue;
		}

		$row = new StdClass();
		$row->id = $rowid;
		$row->language = substr($xmlfile,0,-4);
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

		// if current than set published
		if ($cur_language == $row->language) {
			$row->published	= 1;
		} else {
			$row->published = 0;
		}

		$row->checked_out = 0;
		$row->mosname = strtolower( str_replace( " ", "_", $row->name ) );
		$rows[] = $row;
		$rowid++;
	}

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( count( $rows ), $limitstart, $limit );

	$rows = array_slice( $rows, $pageNav->limitstart, $pageNav->limit );

	HTML_languages::showLanguages( $cur_language, $rows, $pageNav, $option );
}

/**
* Publish, or make current, the selected language
*/
function publishLanguage( $p_lname, $option ) {
	global $mosConfig_lang;

	$config = "";

	$fp = fopen("../configuration.php","r");
	while(!feof($fp)){
		$buffer = fgets($fp,4096);
		if (strstr($buffer,"\$mosConfig_lang")){
			$config .= "\$mosConfig_lang = \"$p_lname\";\n";
		} else {
			$config .= $buffer;
		}
	}
	fclose($fp);

	if ($fp = fopen("../configuration.php","w")){
		fputs($fp, $config, strlen($config));
		fclose($fp);
		mosRedirect("index2.php","Configuration succesfully updated!");
	} else {
		mosRedirect("index2.php","Error! Make sure that configuration.php is writeable.");
	}

}

/**
* Remove the selected language
*/
function removeLanguage( $cid, $option, $client ) {
	global $mosConfig_lang;

	$client_id = $client=='admin' ? 1 : 0;

	$cur_language = $mosConfig_lang;

	if ($cur_language == $cid) {
		echo "<script>alert(\"You can not delete language in use.\"); window.history.go(-1); </script>\n";
		exit();
	}

	/*$lang_path = "../language/$cid.php";
	$lang_ignore_path = "../language/$cid.ignore.php";
	$xml_path = "../language/$cid.xml";

	unlink($lang_path);
	unlink($lang_ignore_path);
	unlink($xml_path);
	*/

	mosRedirect( 'index2.php?option=com_installer&element=language&client='. $client .'&task=remove&cid[]='. $cid );

}

function editLanguageSource( $p_lname, $option) {
	$file = stripslashes( "../language/$p_lname.php" );

	if ($fp = fopen( $file, "r" )) {
		$content = fread( $fp, filesize( $file ) );
		$content = htmlspecialchars( $content );

		HTML_languages::editLanguageSource( $p_lname, $content, $option );
	} else {
		mosRedirect( "index2.php?option=$option&mosmsg=Operation Failed: Could not open $file" );
	}
}

function saveLanguageSource( $option ) {
	$language = trim( mosGetParam( $_POST, 'language', '' ) );
	$filecontent = mosGetParam( $_POST, 'filecontent', '', _MOS_ALLOWHTML );

	if (!$language) {
		mosRedirect( "index2.php?option=$option&mosmsg=Operation failed: No language specified." );
	}
	if (!$filecontent) {
		mosRedirect( "index2.php?option=$option&mosmsg=Operation failed: Content empty." );
	}

	$file = "../language/$language.php";
    $enable_write = mosGetParam($_POST,'enable_write',0);
	$oldperms = fileperms($file);
	if ($enable_write) @chmod($file, $oldperms | 0222);

	clearstatcache();
	if (is_writable( $file ) == false) {
		mosRedirect( "index2.php?option=$option&mosmsg=Operation failed: The file is not writable." );
	}

	if ($fp = fopen ($file, "w")) {
		fputs( $fp, stripslashes( $filecontent ) );
		fclose( $fp );
		if ($enable_write) {
			@chmod($file, $oldperms);
		} else {
			if (mosGetParam($_POST,'disable_write',0))
				@chmod($file, $oldperms & 0777555);
		} // if
		mosRedirect( "index2.php?option=$option" );
	} else {
		if ($enable_write) @chmod($file, $oldperms);
		mosRedirect( "index2.php?option=$option&mosmsg=Operation failed: Failed to open file for writing." );
	}

}

?>