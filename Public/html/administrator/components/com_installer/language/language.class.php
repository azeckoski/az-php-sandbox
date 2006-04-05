<?php
/**
* @version $Id: language.class.php,v 1.1 2005/07/22 01:52:31 eddieajau Exp $
* @package Mambo
* @subpackage Installer
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/**
* Language installer
* @package Mambo
* @subpackage Installer
*/
class mosInstallerLanguage extends mosInstaller {
	/**
	* Custom install method
	* @param boolean True if installing from directory
	*/
	function install( $p_fromdir = null ) {
		global $mosConfig_absolute_path,$database;

		if (!$this->preInstallCheck( $p_fromdir, 'language' )) {
			return false;
		}

		$xml = $this->xmlDoc();

		// Set some vars
		$e = &$xml->getElementsByPath( 'name', 1);
		$this->elementName($e->getText());
		$this->elementDir( mosPathName( $mosConfig_absolute_path . "/language/" ) );

		// Find files to copy
		if ($this->parseFiles( 'files', 'language' ) === false) {
			return false;
		}
		if ($e = &$xml->getElementsByPath( 'description', 1 )) {
			$this->setError( 0, $this->elementName() . '<p>' . $e->getText() . '</p>' );
		}

		return $this->copySetupFile('front');
	}
	/**
	* Custom install method
	* @param int The id of the module
	* @param string The URL option
	* @param int The client id
	*/
	function uninstall( $id, $option, $client=0 ) {
		global $mosConfig_absolute_path;
		$id = str_replace( array( '\\', '/' ), '', $id );

		$basepath = $mosConfig_absolute_path . '/language/';
		$xmlfile = $basepath . $id . '.xml';

		// see if there is an xml install file, must be same name as element
		if (file_exists( $xmlfile )) {
			$this->i_xmldoc =& new DOMIT_Lite_Document();
			$this->i_xmldoc->resolveErrors( true );

			if ($this->i_xmldoc->loadXML( $xmlfile, false, true )) {
				$mosinstall =& $this->i_xmldoc->documentElement;
				// get the files element
				$files_element =& $mosinstall->getElementsByPath( 'files', 1 );

				if (!is_null( $files_element )) {
					$files = $files_element->childNodes;
					foreach ($files as $file) {
						// delete the files
						$filename = $file->getText();
						echo $filename;
						if (file_exists( $basepath . $filename )) {
							echo '<br />Deleting: '. $basepath . $filename;
							$result = unlink( $basepath . $filename );
						}
						echo intval( $result );
					}
				}
			}
		} else {
			HTML_installer::showInstallMessage( 'Language id empty, cannot remove files', 'Uninstall -  error', $this->returnTo( $option, 'language', $client ) );
			exit();
		}

		// remove XML file from front
    	@unlink( $xmlfile );

		return true;
	}
	/**
	* return to method
	*/
	function returnTo( $option, $element, $client ) {
		return "index2.php?option=com_languages";
	}

}
?>
