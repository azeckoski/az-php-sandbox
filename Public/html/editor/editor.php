<?php
/**
* @version $Id: editor.php,v 1.1 2005/07/22 01:55:01 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if (!defined( '_MOS_EDITOR_INCLUDED' )) {
	$_MAMBOTS->loadBotGroup( 'editors' );
	$_MAMBOTS->loadBotGroup( 'editors-xtd' );

	function initEditor() {
		global $_MAMBOTS;

		$results = $_MAMBOTS->trigger( 'onInitEditor' );
		foreach ($results as $result) {
		    if (trim($result)) {
		        echo $result;
			}
		}
	}
	function getEditorContents( $editorArea, $hiddenField ) {
		global $_MAMBOTS;

		$results = $_MAMBOTS->trigger( 'onGetEditorContents', array( $editorArea, $hiddenField ) );
		foreach ($results as $result) {
		    if (trim($result)) {
		        echo $result;
			}
		}
	}
	// just present a textarea
	function editorArea( $name, $content, $hiddenField, $width, $height, $col, $row ) {
		global $_MAMBOTS;

		$results = $_MAMBOTS->trigger( 'onEditorArea', array( $name, $content, $hiddenField, $width, $height, $col, $row ) );
		foreach ($results as $result) {
		    if (trim($result)) {
		        echo $result;
			}
		}
	}
	define( '_MOS_EDITOR_INCLUDED', 1 );
}
?>