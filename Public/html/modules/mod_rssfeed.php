<?php
/**
* @version $Id: mod_rssfeed.php,v 1.1 2005/07/22 01:58:30 eddieajau Exp $
* @pacakge Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_live_site, $mosConfig_absolute_path, $cur_template;

$text 			= $params->get( 'text' );
$moduleclass_sfx 	= $params->get( 'moduleclass_sfx', '' );
$rss091  			= $params->get( 'rss091', 1 );
$rss10  			= $params->get( 'rss10', 1 );
$rss20  			= $params->get( 'rss20', 1 );
$atom  			= $params->get( 'atom', 1 );
$opml  			= $params->get( 'opml', 1 );
$rss091_image		= $params->get( 'rss091_image', '' );
$rss10_image		= $params->get( 'rss10_image', '' );
$rss20_image		= $params->get( 'rss20_image', '' );
$atom_image		= $params->get( 'atom_image', '' );
$opml_image		= $params->get( 'opml_image', '' );

$t_path 			= $mosConfig_live_site .'/templates/'. $cur_template .'/images/';
$d_path			= $mosConfig_live_site .'/images/M_images/';

?>

<div class="syndicate<?php echo $moduleclass_sfx;?>">
<?php
// rss091 link
if ( $text ) {
	?>
	<div align="center" class="syndicate_text<?php echo $moduleclass_sfx;?>">
	<?php echo $text;?>
	</div>
	<?php
}
?>

<?php
// rss091 link
if ( $rss091 ) {
	$img = mosAdminMenus::ImageCheck( 'rss091.gif', '/images/M_images/', $rss091_image, '/images/M_images/', 'RSS 0.91' );
	?>
	<div align="center">
	<a href="<?php echo $mosConfig_live_site ?>/index2.php?option=com_rss&amp;feed=RSS0.91&amp;no_html=1">
	<?php echo $img ?>
	</a>
	</div>
	<?php
}
?>

<?php
// rss10 link
if ( $rss10 ) {
	$img = mosAdminMenus::ImageCheck( 'rss10.gif', '/images/M_images/', $rss10_image, '/images/M_images/', 'RSS 1.0' );
	?>
	<div align="center">
	<a href="<?php echo $mosConfig_live_site ?>/index2.php?option=com_rss&amp;feed=RSS1.0&amp;no_html=1">
	<?php echo $img ?>
	</a>
	</div>
	<?php
}
?>

<?php
// rss20 link
if ( $rss20 ) {
	$img = mosAdminMenus::ImageCheck( 'rss20.gif', '/images/M_images/', $rss20_image, '/images/M_images/', 'RSS 2.0' );
	?>
	<div align="center">
	<a href="<?php echo $mosConfig_live_site ?>/index2.php?option=com_rss&amp;feed=RSS2.0&amp;no_html=1">
	<?php echo $img ?>
	</a>
	</div>
	<?php
}
?>

<?php
// atom link
if ( $atom ) {
	$img = mosAdminMenus::ImageCheck( 'atom03.gif', '/images/M_images/', $atom_image, '/images/M_images/', 'ATOM 0.3' );
	?>
	<div align="center">
	<a href="<?php echo $mosConfig_live_site ?>/index2.php?option=com_rss&amp;feed=ATOM0.3&amp;no_html=1">
	<?php echo $img ?>
	</a>
	</div>
	<?php
}
?>

<?php
// opml link
if ( $opml ) {
	$img = mosAdminMenus::ImageCheck( 'opml.png', '/images/M_images/', $opml_image, '/images/M_images/', 'OPML' );
	?>
	<div align="center">
	<a href="<?php echo $mosConfig_live_site ?>/index2.php?option=com_rss&amp;feed=OPML&amp;no_html=1">
	<?php echo $img ?>
	</a>
	</div>
	<?php
}
?>
</div>