<?php
/**
* @version $Id: footer.php,v 1.4 2005/01/06 01:13:29 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
global $_VERSION;
?>
<div align="center"><?php echo $_VERSION->COPYRIGHT; ?></div>
<div align="center"><?php echo $_VERSION->URL; ?></div>
