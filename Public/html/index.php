<?php
/**
* @version $Id: index.php,v 1.6 2005/11/21 11:57:20 csouza Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

// fix to address the globals overwrite problem in php versions < 4.4.1
$protect_globals = array('_REQUEST', '_GET', '_POST', '_COOKIE', '_FILES', '_SERVER', '_ENV', 'GLOBALS', '_SESSION');
foreach ($protect_globals as $global) {
    if ( in_array($global , array_keys($_REQUEST)) ||
         in_array($global , array_keys($_GET))     ||
         in_array($global , array_keys($_POST))    ||
         in_array($global , array_keys($_COOKIE))  ||
         in_array($global , array_keys($_FILES))) {
        die("Invalid Request.");
    }
}

/** Set flag that this is a parent file  */
define( '_VALID_MOS', 1 );
session_start();
// checks for configuration file, if none found loads installation page
if ( !file_exists( 'configuration.php' ) || filesize( 'configuration.php' ) < 10 ) {
	header( 'Location: installation/index.php' );
	exit();
}

include_once( 'globals.php' );
require_once( 'configuration.php' );

// displays offline page
if ( $mosConfig_offline == 1 ){
	include( 'offline.php' );
	exit();
}

require_once( 'includes/mambo.php' );
if (file_exists( 'components/com_sef/sef.php' )) {
	require_once( 'components/com_sef/sef.php' );
} else {
	require_once( 'includes/sef.php' );
}
require_once( 'includes/frontend.php' );

/*
Installation sub folder check, removed for work with CVS*/
if (file_exists( 'installation/index.php' )) {
	include ('offline.php');
	exit();
}
/**/
/** retrieve some expected url (or form) arguments */
$option = trim( strtolower( mosGetParam( $_REQUEST, 'option' ) ) );
$Itemid = intval( mosGetParam( $_REQUEST, 'Itemid', null ) );
$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );
$acl = new gacl_api();

//--- Start Nok Kaew Patch
$mosConfig_nok_content='0';
if (file_exists( 'components/com_nokkaew/nokkaew.php' )) {
	$mosConfig_nok_content='1';		// can also go into the configuration - but this might be overwritten!
	require_once( "administrator/components/com_nokkaew/nokkaew.class.php");
	require_once( "components/com_nokkaew/classes/nokkaew.class.php");
}

if( $mosConfig_nok_content ) {
	$database = new mlDatabase( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
} else {
	$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
}
    if ($mosConfig_nok_content) {
        $mosConfig_defaultLang = $mosConfig_lang;		// Save the default language of the site
        $iso_client_lang = NokKaew::discoverLanguage( $database );
        $_NOKKAEW_MANAGER = new NokKaewManager();
}

//--- End Nok Kaew Patch
if ($option == '') {
	if ($Itemid) {
		$query = "SELECT id, link"
		. "\n FROM #__menu"
		. "\n WHERE menutype='mainmenu'"
		. "\n AND id = '$Itemid'"
		. "\n AND published = '1'"
		;
		$database->setQuery( $query );
	} else {
		$query = "SELECT id, link"
		. "\n FROM #__menu"
		. "\n WHERE menutype='mainmenu' AND published='1'"
		. "\n ORDER BY parent, ordering LIMIT 1"
		;
		$database->setQuery( $query );
	}
	$menu = new mosMenu( $database );
	if ($database->loadObject( $menu )) {
		$Itemid = $menu->id;
	}
	$link = $menu->link;
	if (($pos = strpos( $link, '?' )) !== false) {
		$link = substr( $link, $pos+1 ). '&Itemid='.$Itemid;
	}
	parse_str( $link, $temp );
	/** this is a patch, need to rework when globals are handled better */
	foreach ($temp as $k=>$v) {
		$GLOBALS[$k] = $v;
		$_REQUEST[$k] = $v;
		if ($k == 'option') {
			$option = $v;
		}
	}
}

/** mainframe is an API workhorse, lots of 'core' interaction routines */
$mainframe = new mosMainFrame( $database, $option, '.' );
$mainframe->initSession();

// checking if we can find the Itemid thru the content
if ( $option == 'com_content' && $Itemid === 0 ) {
	$id = intval( mosGetParam( $_REQUEST, 'id', 0 ) );
	$Itemid = $mainframe->getItemid( $id );
}

/** do we have a valid Itemid yet?? */
if ( $Itemid === null ) {
	/** Nope, just use the homepage then. */
	$query = "SELECT id"
	. "\n FROM #__menu"
	. "\n WHERE menutype='mainmenu'"
	. "\n AND published='1'"
	. "\n ORDER BY parent, ordering"
	. "\n LIMIT 1"
	;
	$database->setQuery( $query );
	$Itemid = $database->loadResult();
}

/** patch to lessen the impact on templates */
if ($option == 'search') {
	$option = 'com_search';
}

// loads english language file by default
if ( $mosConfig_lang == '' ) {
	$mosConfig_lang = 'english';
}
include_once ( 'language/'.$mosConfig_lang.'.php' );

// frontend login & logout controls
$return = mosGetParam( $_REQUEST, 'return', NULL );
if ($option == "login") {
	$mainframe->login();

	// JS Popup message
	if ( mosGetParam( $_POST, 'message', 0 ) ) {
		?>
		<script> 
		<!--//
		alert( "<?php echo _LOGIN_SUCCESS; ?>" ); 
		//-->
		</script>
		<?php
	}

	if ($return) {
		mosRedirect( $return );
	} else {
		mosRedirect( 'index.php' );
	}

} else if ($option == "logout") {
	$mainframe->logout();

	// JS Popup message
	if ( mosGetParam( $_POST, 'message', 0 ) ) {
		?>
		<script> 
		<!--//
		alert( "<?php echo _LOGOUT_SUCCESS; ?>" ); 
		//-->
		</script>
		<?php
	}

	if ($return) {
		mosRedirect( $return );
	} else {
		mosRedirect( 'index.php' );
	}
}

/** get the information about the current user from the sessions table */
$my = $mainframe->getUser();

/** detect first visit */
$mainframe->detect();

$gid = intval( $my->gid );

// gets template for page
$cur_template = $mainframe->getTemplate();
/** temp fix - this feature is currently disabled */

/** @global A places to store information from processing of the component */
$_MOS_OPTION = array();

// precapture the output of the component
require_once( $mosConfig_absolute_path . '/editor/editor.php' );

ob_start();
if ($path = $mainframe->getPath( 'front' )) {
	$task = mosGetParam( $_REQUEST, 'task', '' );
	$ret = mosMenuCheck( $Itemid, $option, $task, $gid );
	if ($ret) {
		require_once( $path );
	} else {
		mosNotAuth();
	}
} else {
	echo _NOT_EXIST;
}
$_MOS_OPTION['buffer'] = ob_get_contents();
ob_end_clean();

initGzip();

header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );

// loads template file
if ( !file_exists( 'templates/'. $cur_template .'/index.php' ) ) {
	echo _TEMPLATE_WARN . $cur_template;
} else {
	require_once( 'templates/'. $cur_template .'/index.php' );
	echo "<!-- ".time()." -->";
}

// displays queries performed for page
if ($mosConfig_debug) {
	echo $database->_ticker . ' queries executed';
	echo '<pre>';
 	foreach ($database->_log as $k=>$sql) {
 	    echo $k+1 . "\n" . $sql . '<hr />';
	}
}

doGzip();
?>
