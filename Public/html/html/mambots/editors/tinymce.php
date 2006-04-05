<?php
/**
* @version $Id: tinymce.php,v 1.2 2005/10/27 08:19:34 lang3 Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onInitEditor', 'botTinymceEditorInit' );
$_MAMBOTS->registerFunction( 'onGetEditorContents', 'botTinymceEditorGetContents' );
$_MAMBOTS->registerFunction( 'onEditorArea', 'botTinymceEditorEditorArea' );

/**
* TinyMCE WYSIWYG Editor - javascript initialisation
*/
function botTinymceEditorInit() {
	global $mosConfig_live_site, $database, $mosConfig_absolute_path;

	// load tinymce info
	$query = "SELECT id FROM #__mambots WHERE element = 'tinymce' AND folder = 'editors'";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$mambot = new mosMambot( $database );
	$mambot->load( $id );
	$params =& new mosParameters( $mambot->params );

	$theme = $params->get( 'theme', 'advanced' );
	// Check for old default option and set to advanced
	if ($theme == 'default' ) {
		$theme = 'simple';
	}

 	$toolbar 			= $params->def( 'toolbar', 'top' );
 	$html_height		= $params->def( 'html_height', '550' );
 	$html_width			= $params->def( 'html_width', '750' );
 	$text_direction		= $params->def( 'text_direction', 'ltr' );
	$content_css		= $params->def( 'content_css', 1 );
 	$content_css_custom	= $params->def( 'content_css_custom', '' );
 	$invalid_elements	= $params->def( 'invalid_elements', 'script,object,applet,iframe' );
 	$newlines			= $params->def( 'newlines', 'false' );
 	
 	if ( $content_css ) {
 		$query = "SELECT template FROM #__templates_menu WHERE client_id='0' AND menuid='0'";
 		$database->setQuery( $query );
 		$template 		= $database->loadResult();
 		$content_css	= 'content_css : "'. $mosConfig_live_site .'/templates/'. $template .'/css/template_css.css"';
 	} else {
 		if ( $content_css_custom ) {
 			$content_css = 'content_css : "'. $content_css_custom .'"';
 		} else {
 			$content_css = '';
 		}
 	}
 	
	return <<<EOD
<script type="text/javascript" src="$mosConfig_live_site/mambots/editors/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		theme : "$theme",
		language : "en",
		mode : "specific_textareas",
		remove_script_host : false,
		relative_urls : false,
		document_base_url : "$mosConfig_live_site/mambots/editors/tinymce/",
 		invalid_elements : "$invalid_elements",
 		theme_advanced_toolbar_location : "$toolbar",
 		theme_advanced_source_editor_height : "$html_height",
		theme_advanced_source_editor_width : "$html_width",
 		directionality: "$text_direction",
 		force_br_newlines : "$newlines",
 		$content_css,		
		debug : false
	});
</script>
EOD;
}
/**
* TinyMCE WYSIWYG Editor - copy editor contents to form field
* @param string The name of the editor area
* @param string The name of the form field
*/
function botTinymceEditorGetContents( $editorArea, $hiddenField ) {
	return <<<EOD

		tinyMCE.triggerSave();
EOD;
}
/**
* TinyMCE WYSIWYG Editor - display the editor
* @param string The name of the editor area
* @param string The content of the field
* @param string The name of the form field
* @param string The width of the editor area
* @param string The height of the editor area
* @param int The number of columns for the editor area
* @param int The number of rows for the editor area
*/
function botTinymceEditorEditorArea( $name, $content, $hiddenField, $width, $height, $col, $row ) {
	global $mosConfig_live_site, $_MAMBOTS;

	$results = $_MAMBOTS->trigger( 'onCustomEditorButton' );
	$buttons = array();
	foreach ($results as $result) {
	    $buttons[] = '<img src="'.$mosConfig_live_site.'/mambots/editors-xtd/'.$result[0].'" onclick="tinyMCE.execCommand(\'mceInsertContent\',false,\''.$result[1].'\')" />';
	}
	$buttons = implode( "", $buttons );

	return <<<EOD

<textarea id="$hiddenField" name="$hiddenField" cols="$col" rows="$row" style="width:{$width}px; height:{$height}px;" mce_editable="true">$content</textarea>
<br />$buttons
EOD;
}
?>
