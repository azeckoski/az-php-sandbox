<?php
/**
* @version $Id: HTML_toolbar.php,v 1.1 2005/07/22 01:57:13 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/**
* Utility class for the button bar
* @package Mambo
*/
class mosToolBar {

	/**
	* Writes the start of the button bar table
	*/
	function startTable() {
		?>
		<table cellpadding="0" cellspacing="0" border="0" width="99%">
		<tr>
		<?php
	}

	/**
	* Writes a custom option and task button for the button bar
	* @param string The task to perform (picked up by the switch($task) blocks
	* @param string The image to display
	* @param string The image to display when moused over
	* @param string The alt text for the icon image
	* @param boolean True if required to check that a standard list item is checked
	*/
	function custom( $task='', $icon='', $iconOver='', $alt='', $listSelect=true ) {
		if ($listSelect) {
			$href = "javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to $alt');}else{submitbutton('$task')}";
		} else {
			$href = "javascript:submitbutton('$task')";
		}
		?>
		<td width="25" align="center">
		<a href="<?php echo $href;?>" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','images/<?php echo $iconOver;?>',1);">
		<img name="<?php echo $task;?>" src="images/<?php echo $icon;?>" alt="<?php echo $alt;?>" border="0" />
		</a>
		</td>
		<?php
	}

	/**
	* Writes the common 'new' icon for the button bar
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function addNew( $task='new', $alt=_CMN_NEW ) {
		$image = mosAdminMenus::ImageCheck( 'new.png', '/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheck( 'new_f2.png', '/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:submitbutton('<?php echo $task;?>');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'publish' button
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function publish( $task='publish', $alt=_CMN_PUBLISHED ) {
		$image = mosAdminMenus::ImageCheck( 'publish.png', '/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheck( 'publish_f2.png', '/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:submitbutton('<?php echo $task;?>');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'publish' button for a list of records
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function publishList( $task='publish', $alt=_CMN_PUBLISHED ) {
		$image = mosAdminMenus::ImageCheck( 'publish.png', '/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheck( 'publish_f2.png', '/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to publish'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'unpublish' button
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function unpublish( $task='unpublish', $alt=_CMN_UNPUBLISHED ) {
		$image = mosAdminMenus::ImageCheck( 'unpublish.png', '/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheck( 'unpublish_f2.png', '/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:submitbutton('<?php echo $task;?>');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);" >
		<?php echo $image; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'unpublish' button for a list of records
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function unpublishList( $task='unpublish', $alt=_CMN_UNPUBLISHED ) {
		$image = mosAdminMenus::ImageCheck( 'unpublish.png', '/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheck( 'unpublish_f2.png', '/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to unpublish'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);" >
		<?php echo $image; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'archive' button for a list of records
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function archiveList( $task='archive', $alt=_CMN_ARCHIVE ) {
		$image = mosAdminMenus::ImageCheck( 'archive.png', '/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheck( 'archive_f2.png', '/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to archive'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes an unarchive button for a list of records
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function unarchiveList( $task='unarchive', $alt=_CMN_UNARCHIVE ) {
		$image = mosAdminMenus::ImageCheck( 'unarchive.png', '/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheck( 'unarchive_f2.png', '/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please select a news story to unarchive'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'edit' button for a list of records
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function editList( $task='edit', $alt=_E_EDIT ) {
		$image = mosAdminMenus::ImageCheck( 'html.png', '/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheck( 'html_f2.png', '/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please select an item from the list to edit'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'edit' button for a template html
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function editHtml( $task='edit_source', $alt=_CMN_EDIT_HTML ) {
		$image = mosAdminMenus::ImageCheck( 'html.png', '/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheck( 'html_f2.png', '/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please select an item from the list to edit'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'edit' button for a template css
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function editCss( $task='edit_css', $alt=_CMN_EDIT_CSS ) {
		$image = mosAdminMenus::ImageCheck( 'css.png', '/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheck( 'css_f2.png', '/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please select an item from the list to edit'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'delete' button for a list of records
	* @param string  Postscript for the 'are you sure' message
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function deleteList( $msg='', $task='remove', $alt=_CMN_DELETE ) {
		$image = mosAdminMenus::ImageCheck( 'delete.png', '/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheck( 'delete_f2.png', '/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to delete'); } else if (confirm('Are you sure you want to delete selected items. <?php echo $msg;?>')){ submitbutton('<?php echo $task;?>');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a preview button for a given option (opens a popup window)
	* @param string The name of the popup file (excluding the file extension)
	*/
	function preview( $popup='' ) {
		global $database;
		$sql = "SELECT template FROM #__templates_menu WHERE client_id='0' AND menuid='0'";
		$database->setQuery( $sql );
		$cur_template = $database->loadResult();
		$image = mosAdminMenus::ImageCheck( 'preview.png', 'images/', NULL, NULL, 'Preview', 'preview' );
		$image2 = mosAdminMenus::ImageCheck( 'preview_f2.png', 'images/', NULL, NULL, 'Preview', 'preview', 0 );
		?>
		<td width="25" align="center">
		<a href="#" onclick="window.open('popups/<?php echo $popup;?>.php?t=<?php echo $cur_template; ?>', 'win1', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('preview','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a save button for a given option
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function save( $task='save', $alt=_CMN_SAVE ) {
		$image = mosAdminMenus::ImageCheck( 'save.png', '/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheck( 'save_f2.png', '/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:submitbutton('<?php echo $task;?>');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2;?>',1);">
		<?php echo $image;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a save button for a given option (NOTE this is being deprecated)
	*/
	function savenew() {
		$image = mosAdminMenus::ImageCheck( 'save.png', '/images/', NULL, NULL, 'save', 'save' );
		$image2 = mosAdminMenus::ImageCheck( 'save_f2.png', '/images/', NULL, NULL, 'save', 'save', 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:submitbutton('savenew');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('save','','<?php echo $image2;?>',1);">
		<?php echo $image;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a save button for a given option (NOTE this is being deprecated)
	*/
	function saveedit() {
		$image = mosAdminMenus::ImageCheck( 'save.png', '/images/', NULL, NULL, 'save', 'save' );
		$image2 = mosAdminMenus::ImageCheck( 'save_f2.png', '/images/', NULL, NULL, 'save', 'save', 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:submitbutton('saveedit');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('save','','<?php echo $image2;?>',1);">
		<?php echo $image;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a cancel button and invokes a cancel operation (eg a checkin)
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function cancel( $task='cancel', $alt=_CMN_CANCEL ) {
		$image = mosAdminMenus::ImageCheck( 'cancel.png', '/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheck( 'cancel_f2.png', '/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:submitbutton('<?php echo $task;?>');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2;?>',1);">
		<?php echo $image;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a cancel button that will go back to the previous page without doing
	* any other operation
	*/
	function back() {
		$image = mosAdminMenus::ImageCheck( 'back.png', '/images/', NULL, NULL, 'back', 'cancel' );
		$image2 = mosAdminMenus::ImageCheck( 'back_f2.png', '/images/', NULL, NULL, 'back', 'cancel', 0 );
		?>
		<td width="25" align="center">
		<a href="javascript:window.history.back();" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','images/<?php echo $image2;?>',1);">
		<?php echo $image;?>
		</a>
		</td>
		<?php
	}

	/**
	* Write a divider between menu buttons
	*/
	function divider() {
		$image = mosAdminMenus::ImageCheck( 'menu_divider.png', '/images/' );
		?>
		<td width="25" align="center">
		<?php echo $image; ?>
		</td>
		<?php
	}

	/**
	* Writes a media_manager button
	* @param string The sub-drectory to upload the media to
	*/
	function media_manager( $directory = '' ) {
		$image = mosAdminMenus::ImageCheck( 'upload.png', '/images/', NULL, NULL, 'Upload Image', 'uploadPic' );
		$image2 = mosAdminMenus::ImageCheck( 'upload_f2.png', '/images/', NULL, NULL, 'Upload Image', 'uploadPic', 0 );
		?>
		<td width="25" align="center">
		<a href="#" onclick="popupWindow('popups/uploadimage.php?directory=<?php echo $directory; ?>','win1',250,100,'no');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('uploadPic','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a spacer cell
	* @param string The width for the cell
	*/
	function spacer( $width='' )
	{
		if ($width != '') {
?>
		<td width="<?php echo $width;?>">&nbsp;</td>
<?php
		} else {
?>
		<td>&nbsp;</td>
<?php
		}
	}

	/**
	* Writes the end of the menu bar table
	*/
	function endTable() {
		?>
		</tr>
		</table>
		<?php
	}
}
?>