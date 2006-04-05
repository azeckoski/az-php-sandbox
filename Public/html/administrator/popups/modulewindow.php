<?php
/**
* @version $Id: modulewindow.php,v 1.1 2005/07/22 01:54:00 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** Set flag that this is a parent file */
define( "_VALID_MOS", 1 );

require_once( '../includes/auth.php' );
include_once ( $mosConfig_absolute_path . '/language/' . $mosConfig_lang . '.php' );

$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );

$title = mosGetParam( $_REQUEST, 'title', 0 );
$css = mosGetParam( $_REQUEST, 't', '');
$database->setQuery( "SELECT * FROM #__modules WHERE title='$title'" );
$row = null;
$database->loadObject( $row );

$pat= "src=images";
$replace= "src=../../images";
$pat2="\\\\'";
$replace2="'";
$content=eregi_replace($pat, $replace, $row->content);
$content=eregi_replace($pat2, $replace2, $row->content);
$title=eregi_replace($pat2, $replace2, $row->title);

$iso = split( '=', _ISO );
// xml prolog
echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Module Preview</title>
	<link rel="stylesheet" href="../../templates/<?php echo $css; ?>/css/template_css.css" type="text/css">
	<script>
		var content = window.opener.document.adminForm.content.value;
		var title = window.opener.document.adminForm.title.value;

		content = content.replace('#', '');
		title = title.replace('#', '');
		content = content.replace('src=images', 'src=../../images');
		content = content.replace('src=images', 'src=../../images');
		title = title.replace('src=images', 'src=../../images');
		content = content.replace('src=images', 'src=../../images');
		title = title.replace('src=\"images', 'src=\"../../images');
		content = content.replace('src=\"images', 'src=\"../../images');
		title = title.replace('src=\"images', 'src=\"../../images');
		content = content.replace('src=\"images', 'src=\"../../images');
	</script>
</head>

<body style="background-color:#FFFFFF">
<table align="center" width="160" cellspacing="2" cellpadding="2" border="0" height="100%">
	<tr>
	    <td class="moduleheading"><script>document.write(title);</script></td>
	</tr>
	<tr>
	    <td valign="top" height="90%"><script>document.write(content);</script></td>
	</tr>
	<tr>
	    <td align="center"><a href="#" onClick="window.close()">Close</a></td>
	</tr>
</table>
</body>
</html>
