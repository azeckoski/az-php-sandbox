<?php
/**
* @version $Id: mod_templatechooser.php,v 1.1 2005/07/22 01:58:30 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $cur_template;

// titlelength can be set in module params
$titlelength = $params->get( 'title_length', 20 );
$preview_height = $params->get( 'preview_height', 90 );
$preview_width = $params->get( 'preview_width', 140 );
$show_preview = $params->get( 'show_preview', 0 );

// Read files from template directory
$template_path = "$mosConfig_absolute_path/templates";
$templatefolder = @dir( $template_path );
$darray = array();
if ($templatefolder) {
	while ($templatefile = $templatefolder->read()) {
		if ($templatefile != "." && $templatefile != ".." && $templatefile != "CVS" && is_dir( "$template_path/$templatefile" )  ) {
			if(strlen($templatefile) > $titlelength) {
				$templatename = substr( $templatefile, 0, $titlelength-3 );
				$templatename .= "...";
			} else {
				$templatename = $templatefile;
			}
			$darray[] = mosHTML::makeOption( $templatefile, $templatename );
		}
	}
	$templatefolder->close();
}

sort( $darray );

// Show the preview image
// Set up JavaScript for instant preview
$onchange = "";
if ($show_preview) {
	$onchange = "showimage()";
?>
<img src="<?php echo "templates/$cur_template/template_thumbnail.png";?>" name="preview" border="1" width="<?php echo $preview_width;?>" height="<?php echo $preview_height;?>" alt="<?php echo $cur_template; ?>" />
<script language='JavaScript1.2' type='text/javascript'>
<!--
	function showimage() {
		//if (!document.images) return;
		document.images.preview.src = 'templates/' + getSelectedValue( 'templateform', 'mos_change_template' ) + '/template_thumbnail.png';
	}
	function getSelectedValue( frmName, srcListName ) {
		var form = eval( 'document.' + frmName );
		var srcList = eval( 'form.' + srcListName );

		i = srcList.selectedIndex;
		if (i != null && i > -1) {
			return srcList.options[i].value;
		} else {
			return null;
		}
	}
-->
</script>
<?php
}
?>
<form action="<?php echo $_SERVER['REQUEST_URI'];?>" name='templateform' method="post">
<?php
echo mosHTML::selectList( $darray, 'mos_change_template', "class=\"button\" onchange=\"$onchange\"",'value', 'text', $cur_template );
?>
<input class="button" type="submit" value="<?php echo _CMN_SELECT;?>" />
</form>
