<?php
/**
* patTemplate modfifier for Search Engine Friendly URL's
* @version $Id: SEF.php,v 1.1 2004/12/24 04:06:31 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
 */

/**
* @package Mambo
*/
class patTemplate_Modifier_SEF extends patTemplate_Modifier
{
   /**
	* modify the value
	*
	* @access	public
	* @param	string		value
	* @return	string		modified value
	*/
	function modify( $value, $params = array() )
	{
		if (function_exists( 'sefRelToAbs' )) {
			return sefRelToAbs( $value );
		} else {
			return $value;
		}
	}
}
?>