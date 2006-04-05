<?php
/**
* PHP 4.1.x Compatibility functions
* @version $Id: compat.php41x.php,v 1.1 2005/07/22 01:57:13 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if (!function_exists( 'array_change_key_case' )) {
	if (!defined('CASE_LOWER')) {
	    define('CASE_LOWER', 0);
	}
	if (!defined('CASE_UPPER')) {
	    define('CASE_UPPER', 1);
	}
	function array_change_key_case( $input, $case=CASE_LOWER ) {
	    if (!is_array( $input )) {
	        return false;
		}
		$array = array();
		foreach ($input as $k=>$v) {
			if ($case) {
			    $array[strtoupper( $k )] = $v;
			} else {
			    $array[strtolower( $k )] = $v;
			}
		}
		return $array;
	}
}
?>