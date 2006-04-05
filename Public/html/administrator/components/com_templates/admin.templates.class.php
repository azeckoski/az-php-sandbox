<?php
/**
* @version $Id: admin.templates.class.php,v 1.1 2005/07/22 01:53:29 eddieajau Exp $
* @package Mambo
* @subpackage Templates
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Templates
*/
class mosTemplatePosition extends mosDBTable {
	var $id=null;
	var $position=null;
	var $description=null;

	function mosTemplatePosition() {
	    global $database;
	    $this->mosDBTable( '#__template_positions', 'id', $database );
	}
}

?>
