<?php
/**
* @version $Id: index2.php,v 1.9 2005/02/10 03:12:35 akede Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** Set flag that this is a parent file */
define( "_VALID_MOS", 1 );

$protects = array('_REQUEST', '_GET', '_POST', '_COOKIE', '_FILES', '_SERVER', '_ENV', 'GLOBALS', '_SESSION');

foreach ($protects as $protect) {
	if ( in_array($protect , array_keys($_REQUEST)) ||
	     in_array($protect , array_keys($_GET)) ||
	     in_array($protect , array_keys($_POST)) ||
	     in_array($protect , array_keys($_COOKIE)) ||
	     in_array($protect , array_keys($_FILES))) {
	    die("Invalid Request.");
	}
}

include_once ('globals.php');
require_once ('configuration.php');
require_once ('includes/mambo.php');
if (file_exists( 'components/com_sef/sef.php' )) {
	require_once( 'components/com_sef/sef.php' );
} else {
	require_once( 'includes/sef.php' );
}
require_once ('includes/frontend.php');
$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );

// retrieve some expected url (or form) arguments
$option 	= trim( strtolower( mosGetParam( $_REQUEST, 'option' ) ) );
$no_html 	= intval( mosGetParam( $_REQUEST, 'no_html', 0 ) );
$Itemid 	= strtolower( trim( mosGetParam( $_REQUEST, 'Itemid',0 ) ) );
$act 		= mosGetParam( $_REQUEST, 'act', '' );
$do_pdf 	= intval( mosGetParam( $_REQUEST, 'do_pdf', 0 ) );

// mainframe is an API workhorse, lots of 'core' interaction routines
$mainframe = new mosMainFrame( $database, $option, '.' );

$mainframe->initSession();
if ($mosConfig_lang=='') {
	$mosConfig_lang='english';
}
include_once ('language/'.$mosConfig_lang.'.php');

if ($mosConfig_offline == 1){
	include( 'offline.php' );
	exit();
}

if ($option == 'login') {
	$mainframe->login();
	mosRedirect('index.php');
} else if ($option == 'logout') {
	$mainframe->logout();
	mosRedirect( 'index.php' );
}

if ( $do_pdf == 1 ){
	include ('includes/pdf.php');
	exit();
}

$acl = new gacl_api();

// get the information about the current user from the sessions table
$my = $mainframe->getUser();

$mainframe->detect();

$gid = intval( $my->gid );

$cur_template = $mainframe->getTemplate();

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

header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
header( "Cache-Control: no-store, no-cache, must-revalidate" );
header( "Cache-Control: post-check=0, pre-check=0", false );
header( "Pragma: no-cache" );
// start basic HTML
if ( $no_html == 0 ) {
	// needed to seperate the ISO number from the language file constant _ISO
	$iso = split( '=', _ISO );
	// xml prolog
	echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<link rel="stylesheet" href="templates/<?php echo $cur_template;?>/css/template_css.css" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
	<meta name="robots" content="noindex, nofollow">
	</head>
	<body class="contentpane">
	<?php mosMainBody(); ?>
	</body>
	</html>
	<?php
} else {
	mosMainBody();
}
doGzip();

?>
