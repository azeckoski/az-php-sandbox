<?php
/**
* @version $Id: admin.menus.html.php,v 1.3 2005/10/21 17:33:55 lang3 Exp $
* @package Mambo
* @subpackage Menus
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Menus
*/
class HTML_menusections {

	function showMenusections( $rows, $pageNav, $search, $levellist, $menutype, $option ) {
		global $my;

		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th class="menus">
			Menu Manager <small><small>[ <?php echo $menutype;?> ]</small></small>
			</th>
			<td nowrap="true">
			Max Levels
			</td>
			<td>
			<?php echo $levellist;?>
			</td>
			<td>
			Filter:
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" />
			</td>
		</tr>
		<?php
		if ( $menutype == 'mainmenu' ) {
			?>
			<tr>
				<td align="right" nowrap style="color: red; font-weight: normal;" colspan="5">
				<?php echo _MAINMENU_DEL; ?>
				<br/>
				<span style="color: black;">
				<?php echo _MAINMENU_HOME; ?>
				</span>
				</td>
			</tr>
			<?php
		}
		?>
		</table>

		<table class="adminlist">
		<tr>
			<th width="20">
			#
			</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
			</th>
			<th class="title" width="40%">
			Menu Item
			</th>
			<th width="5%">
			Published
			</th>
			<th colspan="2" width="5%">
			Reorder
			</th>
			<th width="2%">
			Order
			</th>
			<th width="1%">
			<a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Save Order" /></a>
			</th>
			<th width="10%">
			Access
			</th>
			<th>
			Itemid
			</th>
			<th width="35%" align="left">
			Type
			</th>
			<th>
			CID
			</th>
		</tr>
	    <?php
		$k = 0;
		$i = 0;
		$n = count( $rows );
		foreach ($rows as $row) {
			$access 	= mosCommonHTML::AccessProcessing( $row, $i );
			$checked 	= mosCommonHTML::CheckedOutProcessing( $row, $i );
			$published 	= mosCommonHTML::PublishedProcessing( $row, $i );
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $i + 1 + $pageNav->limitstart;?>
				</td>
				<td>
				<?php echo $checked; ?>
				</td>
				<td nowrap="nowrap">
				<?php
				if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
					echo $row->treename;
				} else {
					$link = 'index2.php?option=com_menus&menutype='. $row->menutype .'&task=edit&id='. $row->id . '&hidemainmenu=1';
					?>
					<a href="<?php echo $link; ?>">
					<?php echo $row->treename; ?>
					</a>
					<?php
				}
				?>
				</td>
				<td width="10%" align="center">
				<?php echo $published;?>
				</td>
				<td>
				<?php echo $pageNav->orderUpIcon( $i ); ?>
				</td>
				<td>
				<?php echo $pageNav->orderDownIcon( $i, $n ); ?>
				</td>
				<td align="center" colspan="2">
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
				</td>
				<td align="center">
				<?php echo $access;?>
				</td>
				<td align="center">
				<?php echo $row->id; ?>
				</td>
				<td align="left">
				<?php
				echo mosToolTip( $row->descrip, '', 280, 'tooltip.png', $row->type, $row->edit );
				?>
				</td>
				<td align="center">
				<?php echo $row->componentid; ?>
				</td>
		    </tr>
			<?php
			$k = 1 - $k;
			$i++;
		}
		?>
		</table>

		<?php echo $pageNav->getListFooter(); ?>

		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="menutype" value="<?php echo $menutype; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}


	/**
	* Displays a selection list for menu item types
	*/
	function addMenuItem( &$cid, $menutype, $option, $types_content, $types_component, $types_link, $types_other ) {

		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th class="menus">
			New Menu Item
			</th>
			<td valign="bottom" nowrap style="color: red;">
			<?php //echo _MENU_GROUP; ?>
			</td>
		</tr>
		</table>
<style type="text/css">
fieldset {
	border: 1px solid #777;
}
legend {
	font-weight: bold;
}
</style>
<table class="adminform">
	<tr>
		<td width="50%" valign="top">
			<fieldset>
				<legend>Content</legend>
				<table class="adminform">
				<?php
				$k 		= 0;
				$count 	= count( $types_content );
					for ( $i=0; $i < $count; $i++ ) {
					$row = &$types_content[$i];

					$link = 'index2.php?option=com_menus&menutype='. $menutype .'&task=edit&hidemainmenu=1&type='. $row->type;
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td width="20">
						<input type="radio" id="cb<?php echo $i;?>" name="type" value="<?php echo $row->type; ?>" onClick="isChecked(this.checked);" />
						</td>
						<td>
						<a href="<?php echo $link; ?>">
						<?php echo $row->name; ?>
						</a>
						</td>
						<td align="center" width="20">
						<?php
						echo mosToolTip( $row->descrip, $row->name, 250 );
						?>
						</td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
				</table>
			</fieldset>
			<fieldset>
				<legend>Miscellaneous</legend>
				<table class="adminform">
				<?php
				$k 		= 0;
				$count 	= count( $types_other );
					for ( $i=0; $i < $count; $i++ ) {
					$row = &$types_other[$i];

					$link = 'index2.php?option=com_menus&menutype='. $menutype .'&task=edit&type='. $row->type;
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td width="20">
						<input type="radio" id="cb<?php echo $i;?>" name="type" value="<?php echo $row->type; ?>" onClick="isChecked(this.checked);" />
						</td>
						<td>
						<a href="<?php echo $link; ?>">
						<?php echo $row->name; ?>
						</a>
						</td>
						<td align="center" width="20">
						<?php
						echo mosToolTip( $row->descrip, $row->name, 250 );
						?>
						</td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
				</table>
			</fieldset>
			* Note that some menu types appear in more that one grouping, but they are still the same menu type.
		</td>
		<td width="50%" valign="top">
			<fieldset>
				<legend>Components</legend>
				<table class="adminform">
				<?php
				$k 		= 0;
				$count 	= count( $types_component );
					for ( $i=0; $i < $count; $i++ ) {
					$row = &$types_component[$i];

					$link = 'index2.php?option=com_menus&menutype='. $menutype .'&task=edit&type='. $row->type;
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td width="20">
						<input type="radio" id="cb<?php echo $i;?>" name="type" value="<?php echo $row->type; ?>" onClick="isChecked(this.checked);" />
						</td>
						<td>
						<a href="<?php echo $link; ?>">
						<?php echo $row->name; ?>
						</a>
						</td>
						<td align="center" width="20">
						<?php
						echo mosToolTip( $row->descrip, $row->name, 250 );
						?>
						</td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
				</table>
			</fieldset>
			<fieldset>
				<legend>Links</legend>
				<table class="adminform">
				<?php
				$k 		= 0;
				$count 	= count( $types_link );
					for ( $i=0; $i < $count; $i++ ) {
					$row = &$types_link[$i];

					$link = 'index2.php?option=com_menus&menutype='. $menutype .'&task=edit&type='. $row->type;
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td width="20">
						<input type="radio" id="cb<?php echo $i;?>" name="type" value="<?php echo $row->type; ?>" onClick="isChecked(this.checked);" />
						</td>
						<td>
						<a href="<?php echo $link; ?>">
						<?php echo $row->name; ?>
						</a>
						</td>
						<td align="center" width="20">
						<?php
						echo mosToolTip( $row->descrip, $row->name, 250 );
						?>
						</td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
				</table>
			</fieldset>
		</td>
	</tr>
</table>

<?php /* ?>

		<table width="100%">
		<tr>
			<td width="60%">
				<h2 align="left">Content</h2>
				<table class="adminlist">
				<tr>
					<th width="5">
					#
					</th>
					<th width="20">
					</th>
					<th class="title">
					Menu Item Type
					</th>
					<th class="title" align="center" width="20px">
					Description
					</th>
					<th>
					</th>
				</tr>
				<?php
				$k 		= 0;
				$count 	= count( $types_content );
					for ( $i=0; $i < $count; $i++ ) {
					$row = &$types_content[$i];

					$link = 'index2.php?option=com_menus&menutype='. $menutype .'&task=edit&type='. $row->type;
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td>
						<?php echo $i+1; ?>
						</td>
						<td>
						<input type="radio" id="cb<?php echo $i;?>" name="type" value="<?php echo $row->type; ?>" onClick="isChecked(this.checked);" />
						</td>
						<td>
						<a href="<?php echo $link; ?>">
						<?php echo $row->name; ?>
						</a>
						</td>
						<td align="center">
						<?php
						echo mosToolTip( $row->descrip, $row->name, 250 );
						?>
						</td>
						<td>
						</td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
				<tr>
					<th colspan="5">
					</th>
				</tr>
				</table>
				<br/>

				<h2 align="left">Components</h2>
				<table class="adminlist">
				<tr>
					<th width="5">
					#
					</th>
					<th width="20">
					</th>
					<th class="title">
					Menu Item Type
					</th>
					<th class="title" align="center" width="20">
					Description
					</th>
					<th>
					</th>
				</tr>
				<?php
				$k 		= 0;
				$count 	= count( $types_component );
					for ( $i=0; $i < $count; $i++ ) {
					$row = &$types_component[$i];

					$link = 'index2.php?option=com_menus&menutype='. $menutype .'&task=edit&type='. $row->type;
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td>
						<?php echo $i+1; ?>
						</td>
						<td>
						<input type="radio" id="cb<?php echo $i;?>" name="type" value="<?php echo $row->type; ?>" onClick="isChecked(this.checked);" />
						</td>
						<td>
						<a href="<?php echo $link; ?>">
						<?php echo $row->name; ?>
						</a>
						</td>
						<td align="center">
						<?php
						echo mosToolTip( $row->descrip, $row->name, 250 );
						?>
						</td>
						<td>
						</td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
				<tr>
					<th colspan="5">
					</th>
				</tr>
				</table>
				<br/>


				<h2 align="left">Links</h2>
				<table class="adminlist">
				<tr>
					<th width="5">
					#
					</th>
					<th width="20">
					</th>
					<th class="title">
					Menu Item Type
					</th>
					<th class="title" align="center" width="20">
					Description
					</th>
					<th>
					</th>
				</tr>
				<?php
				$k 		= 0;
				$count 	= count( $types_link );
					for ( $i=0; $i < $count; $i++ ) {
					$row = &$types_link[$i];

					$link = 'index2.php?option=com_menus&menutype='. $menutype .'&task=edit&type='. $row->type;
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td>
						<?php echo $i+1; ?>
						</td>
						<td>
						<input type="radio" id="cb<?php echo $i;?>" name="type" value="<?php echo $row->type; ?>" onClick="isChecked(this.checked);" />
						</td>
						<td>
						<a href="<?php echo $link; ?>">
						<?php echo $row->name; ?>
						</a>
						</td>
						<td align="center">
						<?php
						echo mosToolTip( $row->descrip, $row->name, 250 );
						?>
						</td>
						<td>
						</td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
				<tr>
					<th colspan="5">
					</th>
				</tr>
				</table>
				<br/>

				<h2 align="left">Other</h2>
				<table class="adminlist">
				<tr>
					<th width="5">
					#
					</th>
					<th width="20">
					</th>
					<th class="title">
					Menu Item Type
					</th>
					<th class="title" align="center" width="20">
					Description
					</th>
					<th>
					</th>
				</tr>
				<?php
				$k 		= 0;
				$count 	= count( $types_other );
					for ( $i=0; $i < $count; $i++ ) {
					$row = &$types_other[$i];

					$link = 'index2.php?option=com_menus&menutype='. $menutype .'&task=edit&type='. $row->type;
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td>
						<?php echo $i+1; ?>
						</td>
						<td>
						<input type="radio" id="cb<?php echo $i;?>" name="type" value="<?php echo $row->type; ?>" onClick="isChecked(this.checked);" />
						</td>
						<td>
						<a href="<?php echo $link; ?>">
						<?php echo $row->name; ?>
						</a>
						</td>
						<td align="center">
						<?php
						echo mosToolTip( $row->descrip, $row->name, 250 );
						?>
						</td>
						<td>
						</td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
				<tr>
					<th colspan="5">
					</th>
				</tr>
				</table>
			</td>
			<td width="40%" valign="top" align="center">
			<h2>Help</h2>
			<br/>
			<a href="#">
			What is a 'Blog' view
			</a>
			<br/><br/><br/>
			<a href="#">
			What is a 'Table' view
			</a>
			<br/><br/><br/>
			<a href="#">
			What is a 'List' view
			</a>
			<br/><br/><br/><br/><br/>
			<div style="color: red; font-weight: bold;">
			<?php echo _MENU_GROUP; ?>
			</div>
			</td>
		</tr>
		</table>
<?php */ ?>

		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="menutype" value="<?php echo $menutype; ?>" />
		<input type="hidden" name="task" value="edit" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}


	/**
	* Form to select Menu to move menu item(s) to
	*/
	function moveMenu( $option, $cid, $MenuList, $items, $menutype  ) {
		?>
		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th>
			Move Menu Items
			</th>
		</tr>
		</table>

		<br />
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="30%">
			<strong>Move to Menu:</strong>
			<br />
			<?php echo $MenuList ?>
			<br /><br />
			</td>
			<td align="left" valign="top">
			<strong>
			Menu Items being moved:
			</strong>
			<br />
			<ol>
			<?php
			foreach ( $items as $item ) {
				?>
				<li>
				<?php echo $item->name; ?>
				</li>
				<?php
			}
			?>
			</ol>
			</td>
		</tr>
		</table>
		<br /><br />

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="boxchecked" value="1" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="menutype" value="<?php echo $menutype; ?>" />
		<?php
		foreach ( $cid as $id ) {
			echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		</form>
		<?php
	}


	/**
	* Form to select Menu to copy menu item(s) to
	*/
	function copyMenu( $option, $cid, $MenuList, $items, $menutype  ) {
		?>
		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th>
			Copy Menu Items
			</th>
		</tr>
		</table>

		<br />
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="30%">
			<strong>
			Copy to Menu:
			</strong>
			<br />
			<?php echo $MenuList ?>
			<br /><br />
			</td>
			<td align="left" valign="top">
			<strong>
			Menu Items being copied:
			</strong>
			<br />
			<ol>
			<?php
			foreach ( $items as $item ) {
				?>
				<li>
				<?php echo $item->name; ?>
				</li>
				<?php
			}
			?>
			</ol>
			</td>
		</tr>
		</table>
		<br /><br />

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="menutype" value="<?php echo $menutype; ?>" />
		<?php
		foreach ( $cid as $id ) {
			echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		</form>
		<?php
	}


}
?>