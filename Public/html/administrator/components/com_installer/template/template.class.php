<?php
/**
* @version $Id: template.class.php,v 1.1 2005/07/22 01:52:34 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @subpackage Installer
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!$acl->acl_check( 'administration', 'manage', 'users', $GLOBALS['my']->usertype, 'components', 'com_templates' )) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

/**
* Template installer
* @package Mambo
* @subpackage Installer
*/
class mosInstallerTemplate extends mosInstaller {
	/**
	* Custom install method
	* @param boolean True if installing from directory
	*/
	function install( $p_fromdir = null ) {
		global $mosConfig_absolute_path,$database;

		if (!$this->preInstallCheck( $p_fromdir, 'template' )) {
			return false;
		}

		$xml =& $this->xmlDoc();
		$mosinstall =& $xml->documentElement;

		$client = '';
		if ($mosinstall->getAttribute( 'client' )) {
			$validClients = array( 'administrator' );
			if (!in_array( $mosinstall->getAttribute( 'client' ), $validClients )) {
				$this->setError( 1, 'Unknown client type ['.$mosinstall->getAttribute( 'client' ).']' );
				return false;
			}
			$client = 'admin';
		}

		// Set some vars
		$e = &$xml->getElementsByPath('name',1);
		$this->elementName($e->getText());
		$this->elementDir( mosPathName( $mosConfig_absolute_path
		. ($client == 'admin' ? '/administrator' : '')
		. '/templates/' . strtolower(str_replace(" ","_",$this->elementName())))
		);

		if (!file_exists( $this->elementDir() ) && !mosMakePath( $this->elementDir() )) {
			$this->setError(1, 'Failed to create directory "' . $this->elementDir() . '"' );
			return false;
		}

		if ($this->parseFiles( 'files' ) === false) {
			return false;
		}
		if ($this->parseFiles( 'images' ) === false) {
			return false;
		}
		if ($this->parseFiles( 'css' ) === false) {
			return false;
		}
		if ($this->parseFiles( 'media' ) === false) {
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
		global $database, $mosConfig_absolute_path;

		// Delete directories
		$path = $mosConfig_absolute_path
		. ($client == 'admin' ? '/administrator' : '' )
		. '/templates/' . $id;

		$id = str_replace( '..', '', $id );
		if (trim( $id )) {
			if (is_dir( $path )) {
				return deldir( mosPathName( $path ) );
			} else {
				HTML_installer::showInstallMessage( 'Directory does not exist, cannot remove files', 'Uninstall -  error',
					$this->returnTo( $option, 'template', $client ) );
			}
		} else {
			HTML_installer::showInstallMessage( 'Template id is empty, cannot remove files', 'Uninstall -  error',
				$this->returnTo( $option, 'template', $client ) );
			exit();
		}
	}
	/**
	* return to method
	*/
	function returnTo( $option, $element, $client ) {
		return "index2.php?option=com_templates&client=$client";
	}
}
?>