<?php
// WP 2.2.5 Configuration file for use with WP Mambot for Mambo 4.5.1 and WP 2.2.5
// You shouldn't need to change anything in this file, except if things aren't working!!
// This script will work out how to include the global mos configuration, include it and then set WP variables using the mos variables so that user doesn't need to do any configuration!
if (!defined('_VALID_MOS')) {
	$wpMosConfigFileInclude = str_replace(array('mambots/editors/wysiwygpro/config.php','mambots//editors//wysiwygpro//config.php','mambots\editors\wysiwygpro\config.php','mambots\\editors\\wysiwygpro\\config.php'), 'configuration.php', __FILE__);
	include_once($wpMosConfigFileInclude);
}

$wp_live_site = preg_replace('/^http(|s):\/\/[^\/]+/smi', '', $mosConfig_live_site);

define('DEFAULT_LANG', 'en-us.php');
define('DOMAIN_ADDRESS', strtolower(substr($_SERVER['SERVER_PROTOCOL'],0,strpos($_SERVER['SERVER_PROTOCOL'],'/')) . (isset($_SERVER['HTTPS']) ? ($_SERVER['HTTPS'] == "on" ? 's://' : '://') : '://' ) . $_SERVER['SERVER_NAME'] ) );
define('WP_FILE_DIRECTORY', $mosConfig_absolute_path.'/mambots/editors/wysiwygpro/');
define('WP_WEB_DIRECTORY', $wp_live_site.'/mambots/editors/wysiwygpro/');
define('IMAGE_FILE_DIRECTORY', $mosConfig_absolute_path.'/images/stories/');
define('IMAGE_WEB_DIRECTORY', $wp_live_site.'/images/stories/');
define('DOCUMENT_FILE_DIRECTORY', $mosConfig_absolute_path.'/images/stories/');
define('DOCUMENT_WEB_DIRECTORY', $wp_live_site.'/images/stories/');
$trusted_directories = array();
define('SMILEY_FILE_DIRECTORY', null);
define('SMILEY_WEB_DIRECTORY', null);
define('NOCACHE', true);
define('SAVE_DIRECTORY', $mosConfig_absolute_path.'/cache/');
define('SAVE_LENGTH', 9000);

if (!empty($mosConfig_fileperms)) {
	define('FILE_CHMOD_MODE', $mosConfig_fileperms);
}
if (!empty($mosConfig_dirperms)) {
	define('CHMOD_MODE', $mosConfig_dirperms);
}

// -------------------------------------------------------------------------------
// All of the following variables affect file management in the image and document windows:
// -------------------------------------------------------------------------------

//////////////////////////
// User Permissions
//////////////////////////

// We will check for valid mos users and dynamically set the permissions accordingly.
// Logged in users with a valid mos session will have full file system access, others will not.
// Note: directory editing is only available from the admin end
if (!defined('_VALID_MOS')) {
	
	// no permissions (default)
	$permissions = 0;
	
	define('_VALID_MOS', true);
	
	// IN ADMIN AUTHENTICATION:
	include_once ($mosConfig_absolute_path."/globals.php");
	require_once ($mosConfig_absolute_path."/configuration.php");
	require_once ($mosConfig_absolute_path."/includes/mambo.php");
	
	require_once( $mosConfig_absolute_path . "/administrator/includes/admin.php" );
	
	$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
	$database->debug( $mosConfig_debug );

	// must start the session before we create the mainframe object
	session_name( 'mosadmin' );
	session_start();
	
	// mainframe is an API workhorse, lots of 'core' interaction routines
	$mainframe = new mosMainFrame( $database, '', $mosConfig_absolute_path, true );
	
	// restore some session variables
	$my = new mosUser( $database );
	$my->id = mosGetParam( $_SESSION, 'session_user_id', '' );
	$my->username = mosGetParam( $_SESSION, 'session_username', '' );
	$my->usertype = mosGetParam( $_SESSION, 'session_usertype', '' );
	$my->gid = mosGetParam( $_SESSION, 'session_gid', '' );
	
	$session_id = mosGetParam( $_SESSION, 'session_id', '' );
	$logintime = mosGetParam( $_SESSION, 'session_logintime', '' );
	
	// GET MAMBOT PARAMS
	$query = "SELECT id FROM #__mambots WHERE element = 'WysiwygPro' AND folder = 'editors'";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$mambot = new mosMambot( $database );
	$mambot->load($id);
	$params = & new mosParameters($mambot->params);
	// END
	
	// check against db record of session
	$ok = false;
	if ($session_id == md5( $my->id.$my->username.$my->usertype.$logintime )) {
		$database->setQuery( "SELECT * FROM #__session"
		. "\nWHERE session_id='$session_id'"
		//. "\n	AND (usertype='administrator' OR usertype='superadministrator')"
		);
		if (!$result = $database->query()) {
			echo $database->stderr();
			exit();
		}
		if ($database->getNumRows( $result ) <> 1) {
			// user not logged into admin
			$ok = false;
		} else {
			// use logged into admin
			$ok = true;
		}
	} 
	if ($ok) {
		// all permissions
		$permissions = 2;
	} else {
		
		/********************************************************************************
		Begin user upload privaleges mod.
		*/
		
		// FRONT-END "USER" AUTHENTICATION:
		session_destroy(); // user not logged into admin, destroy so we can try again
		
		$mainframe->initSession();
		$my = $mainframe->getUser();
		$gid = intval( $my->gid );
		
		if ($gid) {
			
			switch($my->usertype) {
				case 'manager' :
				case 'Administrator' :
				case 'Super Administrator' :
					$permissions = 2;
					break;
				case 'Author' :
				case 'Editor' :
				case 'Publisher' :
					$permissions = $params->get( 'permissions', '0' );
					break;
				default :
					$permissions = 0;
					break;
			}
			
		} else {
			
			// user not logged in anywhere, no permissions.
			$permissions = 0;
			
		}
	}
	
	
	// now actually set the permissions
	switch($permissions) {
		case 0 : // no permissions
			$delete_files = false;
			$delete_directories = false;
			$create_directories = false;
			$rename_files = false;
			$rename_directories = false;
			$upload_files = false;
			$overwrite = false;
			break;
		case 1 : // upload only
			$delete_files = false;
			$delete_directories = false;
			$create_directories = true;
			$rename_files = false;
			$rename_directories = false;
			$upload_files = true;
			$overwrite = false;
			break;
		case 2 : // all permissions
			$delete_files = true;
			$delete_directories = true;
			$create_directories = true;
			$rename_files = true;
			$rename_directories = true;
			$upload_files = true;
			$overwrite = true;
			break;
	}	
	
	
	////////////////////////////
	// File Types  
	////////////////////////////
	
	// These variables decide what types of files users are allowed to upload using the image or document management windows
	
	// What types of images can be uploaded? Separate with a comma.
	$image_types = $params->get( 'image_types', '.jpg, .jpeg, .gif, .png' );
	
	// What types of documents can be uploaded? Separate with a comma.
	$document_types = $params->get( 'document_types', '.html, .htm, .pdf, .doc, .rtf, .txt, .xl, .xls, .ppt, .pps, .zip, .tar, .swf, .wmv, .rm, .mov, .jpg, .jpeg, .gif, .png' );
	
	////////////////////////////
	// File Sizes
	////////////////////////////
	
	// maximum width of uploaded images in pixels set this to ensure that users don't destroy your site's design!!
	$max_image_width = $params->get( 'max_image_width', 500 );
	
	// maximum height of uploaded images in pixels set this to ensure that users don't destroy your site's design!!
	$max_image_height = $params->get( 'max_image_height', 500 );
	
	// maximum image filesize to upload in bytes
	$max_file_size = $params->get( 'max_image_size', 80000 );
	
	// maximum size of documents to upload in bytes
	$max_documentfile_size = $params->get( 'max_document_size', 2000000 );
	
	
}
// end variables, do not change anything below
// ----------------------------------------
define('WP_CONFIG', true);
define('WP_MAMBOT_CONFIG', true);
global $wp_has_been_previous;
$wp_has_been_previous = false;
// ----------------------------------------
?>