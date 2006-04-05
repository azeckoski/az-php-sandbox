<?php
/**
* @version $Id: cpanel.php,v 1.1 2005/07/22 01:54:20 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
?>
<table class="adminform">
<tr>
	<td width="50%" valign="top">
	<?php mosLoadAdminModules( 'icon', 0 ); ?>
	</td>
	<td width="50%" valign="top">
	<div style="width=100%;">
	<form action="index2.php" method="post" name="adminForm">
	<?php mosLoadAdminModules( 'cpanel', 1 ); ?>
	</form>
	</div>
	</td>
</tr>
</table>