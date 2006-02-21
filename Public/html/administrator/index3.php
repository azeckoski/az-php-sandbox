<?php
/**
* @version $Id: index3.php,v 1.4 2005/01/06 01:13:25 eddieajau Exp $
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

if (!file_exists( "../configuration.php" )) {
	header( "Location: ../installation/index.php" );
	exit();
}

require_once( "../globals.php" );
require_once( "../configuration.php" );
require_once( $mosConfig_absolute_path . "/includes/mambo.php" );
include_once( $mosConfig_absolute_path . "/language/".$mosConfig_lang.".php" );
require_once( $mosConfig_absolute_path . "/administrator/includes/admin.php" );

$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );
$acl = new gacl_api();

$option = trim( strtolower( mosGetParam( $_REQUEST, 'option', '' ) ) );

// must start the session before we create the mainframe object
session_name( 'mosadmin' );
session_start();

// mainframe is an API workhorse, lots of 'core' interaction routines
$mainframe = new mosMainFrame( $database, $option, '..', true );

// initialise some common request directives
$task = trim( mosGetParam( $_REQUEST, 'task', '' ) );
$act = trim( strtolower( mosGetParam( $_REQUEST, 'act', '' ) ) );
$section = trim( mosGetParam( $_REQUEST, 'section', '' ) );
$mosmsg = trim( strip_tags( mosGetParam( $_REQUEST, 'mosmsg', '' ) ) );
$no_html = strtolower( trim( mosGetParam( $_REQUEST, 'no_html', '' ) ) );


if ($option == 'logout') {
	require 'logout.php';
	exit();
}

// restore some session variables
$my = new mosUser( $database );
$my->id = mosGetParam( $_SESSION, 'session_user_id', '' );
$my->username = mosGetParam( $_SESSION, 'session_username', '' );
$my->usertype = mosGetParam( $_SESSION, 'session_usertype', '' );
$my->gid = mosGetParam( $_SESSION, 'session_gid', '' );

$session_id = mosGetParam( $_SESSION, 'session_id', '' );
$logintime = mosGetParam( $_SESSION, 'session_logintime', '' );

// check against db record of session
if ($session_id == md5( $my->id.$my->username.$my->usertype.$logintime )) {
	$database->setQuery( "SELECT * FROM #__session"
	. "\nWHERE session_id='$session_id'"
	. " AND username = '" . $database->getEscaped( $my->username ) . "'"
	. " AND userid = " . intval( $my->id )
	);
	if (!$result = $database->query()) {
		echo $database->stderr();
	}
	if ($database->getNumRows( $result ) <> 1) {
		echo "<script>document.location.href='index.php'</script>\n";
		exit();
	}
} else {
	echo "<script>document.location.href='index.php'</script>\n";
	exit();
}

// update session timestamp
$current_time = time();
$database->setQuery( "UPDATE #__session SET time='$current_time'"
. "\nWHERE session_id='$session_id'"
);
$database->query();

// timeout old sessions
$past = time()-1800;
$database->setQuery( "DELETE FROM #__session WHERE time < '$past'" );
$database->query();

// start the html output
if ($no_html) {
	if ($path = $mainframe->getPath( "admin" )) {
		require $path;
	}
	exit;
}

initGzip();

?>
<?php echo "<?xml version=\"1.0\"?>"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $mosConfig_sitename; ?> - Administration [Mambo]</title>
<link rel="stylesheet" href="templates/<?php echo $mainframe->getTemplate(); ?>/css/template_css.css" type="text/css">
<link rel="stylesheet" href="templates/<?php echo $mainframe->getTemplate(); ?>/css/theme.css" type="text/css">
<script language="JavaScript" src="../includes/js/JSCookMenu.js" type="text/javascript"></script>
<script language="JavaScript" src="includes/js/ThemeOffice/theme.js" type="text/javascript"></script>
<script language="JavaScript" src="../includes/js/mambojavascript.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
</head>
<body>
<?php
if ($mosmsg) {
	if (!get_magic_quotes_gpc()) {
		$mosmsg = addslashes( $mosmsg );
	}
	echo "\n<script language=\"javascript\" type=\"text/javascript\">alert('$mosmsg');</script>";
}

// Show list of items to edit or delete or create new
if ($path = $mainframe->getPath( 'admin' )) {
	require $path;
} else {
	?>
      <img src="images/logo.png" border="0" alt="Mambo Logo" />&nbsp; <br />
      <?php
}
?>

</body>
</html>
<?php
doGzip();
?>
