<?php
/**
* @version $Id: mod_quickicon.php,v 1.2 2005/10/20 01:08:31 cfraser Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

?>
<table width="100%" class="cpanel">
<?php if($_SESSION['simple_editing'] == 'off'){?>
<tr>
	<td align="center" style="height:100px">
	<a href="index2.php?option=com_admin&amp;task=help" style="text-decoration:none;">
	<img src="images/support.png" width="48" height="48" align="middle" border="0"/>
	<br />
	Help
	</a>
	</td>
	<td align="center" style="height:100px">
	<a href="index2.php?option=com_content&amp;sectionid=0" style="text-decoration:none;">
	<img src="images/addedit.png" width="48" height="48" align="middle" border="0"/>
	<br />
	All Content Items
	</a>
	</td>
	<td align="center" style="height:100px">
	<a href="index2.php?option=com_typedcontent" style="text-decoration:none;">
	<img src="images/addedit.png" width="48" height="48" align="middle" border="0"/>
	<br />
	Static Content
	</a>
	</td>
	<td>
	<a href="index2.php?option=com_frontpage" style="text-decoration:none;">
	<img src="images/frontpage.png" width="48" height="48" align="middle" border="0"/>
	<br />
	Frontpage
	</a>
	</td>
</tr>
<tr>
	<td align="center" style="height:100px">
	<a href="index2.php?option=com_sections&amp;scope=content" style="text-decoration:none;">
	<img src="images/sections.png" width="48" height="48" align="middle" border="0"/>
	<br />
	Sections
	</a>
	</td>
	<td align="center" style="height:100px">
	<a href="index2.php?option=com_categories&amp;section=content" style="text-decoration:none;">
	<img src="images/categories.png" width="48" height="48" align="middle" border="0"/>
	<br />
	Categories
	</a>
	</td>
	<td align="center" style="height:100px">
	<a href="index2.php?option=com_media" style="text-decoration:none;">
	<img src="images/mediamanager.png" width="48" height="48" align="middle" border="0"/>
	<br />
	Media
	</a>
	</td>
	<td align="center" style="height:100px">
	
	&nbsp;
	</td>
</tr>

<tr>
	<td align="center" style="height:100px">
	<a href="index2.php?option=com_trash" style="text-decoration:none;">
	<img src="images/trash.png" width="48" height="48" align="middle" border="0"/>
	<br />
	Trash
	</a>
	</td>
	<td>
	<?php
	if ( $acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_menumanager' ) ) {
		?>
		<a href="index2.php?option=com_menumanager" style="text-decoration:none;">
		<img src="images/menu.png" width="48" height="48" align="middle" border="0"/>
		<br />
		Menus
		</a>
		<?php
	}
	?>
	</td>
	<td align="center" style="height:100px">
	<?php
	if ( $acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_users' ) ) {
		?>
		<a href="index2.php?option=com_users" style="text-decoration:none;">
		<img src="images/user.png" width="48" height="48" align="middle" border="0"/>
		<br />
		Users
		</a>
		<?php
	}
	?>
	</td>
	<td align="center" style="height:100px">
	<?php
	if ( $acl->acl_check( 'administration', 'config', 'users', $my->usertype ) ) {
		?>
		<a href="index2.php?option=com_config&amp;hidemainmenu=1" style="text-decoration:none;">
		<img src="images/config.png" width="48" height="48" align="middle" border="0"/>
		<br />
		Global Configuration
		</a>
		<?php
	}
	?>
	</td>
	
</tr>
<?php }else{?>
<!-- if we are simple mode we display these icons -->
<tr>
	<td align="center" style="height:100px">
	<a href="index2.php?option=com_admin&amp;task=help" style="text-decoration:none;">
	<img src="images/support.png" width="48" height="48" align="middle" border="0"/>
	<br />
	Help
	</a>
	</td>
	<td align="center" style="height:100px">
	<a href="index2.php?option=com_content&amp;sectionid=0" style="text-decoration:none;">
	<img src="images/addedit.png" width="48" height="48" align="middle" border="0"/>
	<br />
	All Content Items
	</a>
	</td>
	<td align="center" style="height:100px">
	<a href="index2.php?option=com_typedcontent" style="text-decoration:none;">
	<img src="images/addedit.png" width="48" height="48" align="middle" border="0"/>
	<br />
	Static Content
	</a>
	</td>
	
	<td>
	<a href="index2.php?option=com_frontpage" style="text-decoration:none;">
	<img src="images/frontpage.png" width="48" height="48" align="middle" border="0"/>
	<br />
	Frontpage
	</a>
	</td>
	<td align="center" style="height:100px">
		
		&nbsp;
</td>
</tr>
<?php }?>


</table>