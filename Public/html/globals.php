<?php
/**
* @version $Id: globals.php,v 1.6 2005/11/26 00:43:58 csouza Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** Set flag that this is a parent file  */
if (!defined('_VALID_MOS')) define( '_VALID_MOS', 1 );

// reads configuration.php for mosConfig_register_globals
function config_register_globals() {
    static $register_globals;
    if (is_null($register_globals)) {
        $config = implode(",", file(dirname(__FILE__).DIRECTORY_SEPARATOR.'configuration.php'));
        preg_match('/\$mosConfig_register_globals\s*=\s*\'([0-1]?)\'/', $config, $matches);
        $register_globals = isset($matches[1]) ? (int) $matches[1] : 1;
    }
    return $register_globals;
}

// get mosConfig_register_globals
$config_register_globals = config_register_globals();

// superglobals array
$superglobals = array($_SERVER, $_ENV, $_FILES, $_COOKIE, $_POST, $_GET);
if (isset($_SESSION)) array_unshift ($superglobals , $_SESSION); 

// Emulate register_globals on
if (!ini_get('register_globals') && $config_register_globals) {
    while(list($key,$value)=each($_GET)) {
       if (!isset($GLOBALS[$key])) $GLOBALS[$key]=$value;
    }
    while(list($key,$value)=each($_POST)) {
       if (!isset($GLOBALS[$key])) $GLOBALS[$key]=$value;
    }
}
// Emulate register_globals off
elseif (ini_get('register_globals') && !$config_register_globals) {
   foreach ($superglobals as $superglobal) {
       foreach ($superglobal as $key => $value) {
           unset($GLOBALS[$key]);
           unset( $GLOBALS[$key]);
       }
   }
}

?>
