<?php
/**
* @version $Id: cpanel.php,v 1.5 2005/02/13 02:41:39 stingrey Exp $
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