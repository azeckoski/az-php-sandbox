<?php
/**
* @version $Id: editor.wysiwygpro.php,v 1.1 2005/07/22 01:55:01 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
?>
<script type="text/javascript"> 
<!--
/** Wrapper around the editor specific update function in JavaScript
*/
function updateEditorContents( editorName, newValue ) {
	wp_send_to_html( 'editorName' );
}
//-->
</script>
<?php
function initEditor() {
	global $mosConfig_live_site;
}

function editorArea( $name, $content, $hiddenField, $width, $height, $col, $row ) {
	global $mosConfig_absolute_path;

	$content = str_replace("&lt;", "<", $content);
	$content = str_replace("&gt;", ">", $content);
	$content = str_replace("&amp;", "&", $content);
	$content = str_replace("&nbsp;", " ", $content);
	$content = str_replace("&quot;", "\"", $content);


	// include the config file and editor class:
	include_once ($mosConfig_absolute_path.'/editor/wysiwygpro/config.php');
	include_once ($mosConfig_absolute_path.'/editor/wysiwygpro/editor_class.php');

	// create a new instance of the wysiwygPro class:
	$name = new wysiwygPro();

	$name->set_name($hiddenField);

	if ($hiddenField=='fulltext') {
		$name->subsequent(true);
	}

	$name->usep(true);

	// insert some HTML
	$name->set_code($content);

	// print the editor to the browser:
	$name->print_editor('100%', intval($height));

}

function getEditorContents( $editorArea, $hiddenField ) {
?>

submit_form();

<?php
}
?>
