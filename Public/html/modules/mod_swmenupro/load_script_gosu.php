<?php
/**
* swmenupro v1.0
* http://swonline.biz
* Copyright 2004 Sean White
* DHTML Menu Component for Mambo Open Source
* Mambo Open Source is Free Software
* Released under GNU/GPL License: http://www.gnu.org/copyleft/gpl.html
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

## Loads load_script function
load_scriptGosu();


/**---------------------------------------------------------------------**/
function load_scriptGosu() {
	global $mosConfig_live_site;
	echo '<script type="text/javascript" src="modules/mod_swmenupro/ie5.js"></script>';
	echo '<script type="text/javascript" src="modules/mod_swmenupro/DropDownMenuX.js"></script>';
}
//---------------------------------------------------------------------

?>