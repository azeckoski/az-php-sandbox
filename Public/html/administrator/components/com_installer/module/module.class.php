<?php
/**
* @version $Id: module.class.php,v 1.1 2005/07/22 01:52:34 eddieajau Exp $
* @package Mambo
* @subpackage Installer
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
* */

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Module installer
* @package Mambo
*/
class mosInstallerModule extends mosInstaller {
	/**
	* Custom install method
	* @param boolean True if installing from directory
	*/
	function install( $p_fromdir = null ) {
		global $mosConfig_absolute_path, $database;

		if (!$this->preInstallCheck( $p_fromdir, 'module' )) {
			return false;
		}

		$xml = $this->xmlDoc();
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
			. '/modules/' )
		);

		if ($this->parseFiles( 'files', 'module', 'No file is marked as module file' ) === false) {
		    return false;
		}
		$this->parseFiles( 'images' );

		$client_id = intval( $client == 'admin' );
		// Insert in module in DB
		$database->setQuery( "SELECT id FROM #__modules"
			. "\nWHERE module = '" . $this->elementSpecial() . "' AND client_id=$client_id" );
		if (!$database->query()) {
			$this->setError( 1, 'SQL error: ' . $database->stderr( true ) );
			return false;
		}

		$id = $database->loadResult();

		if (!$id) {
			$row = new mosModule( $database );
			$row->title = $this->elementName();
			$row->ordering = 99;
			$row->position = 'left';
			$row->showtitle = 1;
			$row->iscore = 0;
			$row->access = $client == 'admin' ? 99 : 0;
			$row->client_id = $client_id;
			$row->module = $this->elementSpecial();

			$row->store();

			$database->setQuery( "INSERT INTO #__modules_menu VALUES ('$row->id', 0)" );
			if(!$database->query()) {
				$this->setError( 1, 'SQL error: ' . $database->stderr( true ) );
				return false;
			}
		} else {
			$this->setError( 1, 'Module "' . $this->elementName() . '" already exists!' );
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

		$id = intval( $id );

		$query = "SELECT module, iscore, client_id FROM #__modules WHERE id = '$id'";
		$database->setQuery( $query );
		$row = null;
		$database->loadObject( $row );

		if ($row->iscore) {
			HTML_installer::showInstallMessage( $row->title .'is a core module, and can not be uninstalled.<br />You need to unpublish it if you don\'t want to use it', 'Uninstall -  error', $this->returnTo( $option, 'module', $row->client_id ? '' : 'admin' ) );
			exit();
		}

		$query = "SELECT id FROM #__modules WHERE module = '$row->module'";
		$database->setQuery( $query );
		$modules = $database->loadResultArray();

		if (count( $modules )) {
			$query = "DELETE FROM #__modules_menu"
			. "\n WHERE moduleid IN ('".implode( "','", $modules ) ."')"
			;
			$database->setQuery( $query );
			if (!$database->query()) {
			    $msg = $database->stderr;
			    die( $msg );
			}
		}

		$query = "DELETE FROM #__modules WHERE module = '$row->module'";
		$database->setQuery( $query );
		if (!$database->query()) {
		    $msg = $database->stderr;
		    die( $msg );
		}

		if ( $row->client_id ) {
			$basepath = $mosConfig_absolute_path . '/administrator/modules/';
		} else {
			$basepath = $mosConfig_absolute_path . '/modules/';
		}

  		$xmlfile = $basepath . $row->module . '.xml';

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
						if (file_exists( $basepath . $filename )) {
							$parts = pathinfo( $filename );
							$subpath = $parts['dirname'];
							if ($subpath <> '' && $subpath <> '.' && $subpath <> '..') {
								echo '<br />Deleting: '. $basepath . $subpath;
								$result = deldir(mosPathName( $basepath . $subpath . '/' ));
							} else {
								echo '<br />Deleting: '. $basepath . $filename;
								$result = unlink( mosPathName ($basepath . $filename, false));
							}
							echo intval( $result );
						}
					}

					// remove XML file from front
					echo "Deleting XML File: $xmlfile";
					@unlink(  mosPathName ($xmlfile, false ) );
					return true;
				}
			}
		}

	}
}
?>
