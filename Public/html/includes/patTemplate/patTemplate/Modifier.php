<?PHP
/**
 * Base class for patTemplate variable modifiers
 *
 * $Id: Modifier.php,v 1.1 2005/07/22 01:57:25 eddieajau Exp $
 *
 * A modifier is used to modify a variable when it's parsed
 * into the template.
 *
 * @package		patTemplate
 * @subpackage	Modifiers
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * Base class for patTemplate variable modifiers
 *
 * $Id: Modifier.php,v 1.1 2005/07/22 01:57:25 eddieajau Exp $
 *
 * A modifier is used to modify a variable when it's parsed
 * into the template.
 *
 * @abstract
 * @package		patTemplate
 * @subpackage	Modifiers
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_Modifier extends patTemplate_Module
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
		return $value;
	}
}
?>