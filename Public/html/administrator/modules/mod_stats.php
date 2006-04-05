<?php
/**
* @version $Id: mod_stats.php,v 1.1 2005/07/22 01:53:59 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$query = "SELECT menutype, COUNT(id) AS numitems"
. "\n FROM #__menu"
. "\n WHERE published = 1"
. "\n GROUP BY menutype"
;
$database->setQuery( $query );
$rows = $database->loadObjectList();
?>
<table class="adminlist">
	<tr>
		<th class="title">
		Menu
		</th>
		<th class="title">
		# Items
		</th>
	</tr>
<?php
foreach ($rows as $row) {
	$link = 'index2.php?option=com_menus&amp;menutype='. $row->menutype;
	?>
	<tr>
		<td>
		<a href="<?php echo $link; ?>">
		<?php echo $row->menutype;?>
		</a>
		</td>
		<td>
		<?php echo $row->numitems;?>
		</td>
	</tr>
<?php
}
?>
</table>