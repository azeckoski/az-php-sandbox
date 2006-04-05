<?php
/**
* @version $Id: offline.php,v 1.1 2005/07/22 01:57:42 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

@include_once ('language/'.$mosConfig_lang.'.php');

$cur_template = 'rhuk_solarflare';

// needed to seperate the ISO number from the language file constant _ISO
$iso = split( '=', _ISO );
// xml prolog
echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
global $mosConfig_live_site;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $mosConfig_sitename; ?> - Offline</title>
<link rel="stylesheet" href="<?php echo $mosConfig_live_site; ?>/templates/<?php echo $cur_template;?>/css/template_css.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
</head>
<body>

<p>&nbsp;</p>
<table width="550" align="center" style="background-color: #ffffff; border: 1px solid">
<tr>
	<td width="60%" height="50" align="center">
	<img src="<?php echo $mosConfig_live_site; ?>/images/logo.png" alt="Mambo Logo" align="middle" />
	</td>
</tr>
<tr> 
	<td align="center">
	<h1>
	<?php echo $mosConfig_sitename; ?>
	</h1>
	</td>
</tr>
<?php
if ( $mosConfig_offline == 1 ) {
	?>
	<tr> 
		<td width="39%" align="center">
		<h2>
		<?php echo $mosConfig_offline_message; ?>
		</h2>
		</td>
	</tr>
	<?php
} else if (@$mosSystemError) {
	?>
	<tr> 
		<td width="39%" align="center">
		<h2>
		<?php echo $mosConfig_error_message; ?>
		</h2>
		<?php echo $mosSystemError; ?>
		</td>
	</tr>
	<?php
} else {
	?>
	<tr> 
		<td width="39%" align="center">
		<h2>
		<?php echo _INSTALL_WARN; ?>
		</h2>
		</td>
	</tr>
	<?php
}
?>
</table>

</body>
</html>
