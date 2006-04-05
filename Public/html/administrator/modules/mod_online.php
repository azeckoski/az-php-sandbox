<?php
/**
* @version $Id: mod_online.php,v 1.1 2005/07/22 01:53:59 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$session_id = mosGetParam( $_SESSION, 'session_id', '' );

// Get no. of users online not including current session
$query = "SELECT count(session_id) FROM #__session"
."\n WHERE session_id <> '$session_id'";

$database->setQuery($query);
$online_num = intval( $database->loadResult() );

echo $online_num . " <img src=\"images/users.png\" align=\"middle\" alt=\"Users Online\" />";
?>