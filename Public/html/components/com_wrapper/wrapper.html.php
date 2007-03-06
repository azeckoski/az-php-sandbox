<?php
/**
* @version $Id: wrapper.html.php,v 1.1 2005/07/22 01:54:59 eddieajau Exp $
* @package Mambo
* @subpackage Wrapper
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Wrapper
*/
class HTML_wrapper {

	function displayWrap( &$row, &$params, &$menu ) {
		?>
		<script language="javascript" type="text/javascript">
		<?php echo $row->load ."\n"; ?>
		function iFrameHeight() {
			var h = 0;
			if ( !document.all ) {
				h = document.getElementById('blockrandom').contentDocument.height;
				document.getElementById('blockrandom').style.height = h + 60 + 'px';
			} else if( document.all ) {
				h = document.frames('blockrandom').document.body.scrollHeight;
				document.all.blockrandom.style.height = h + 20 + 'px';
			}
		}
		</script>
		<div class="contentpane<?php echo $params->get( 'pageclass_sfx' ); ?>">

		<?php
		if ( $params->get( 'page_title' ) ) {
			?>
			<div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
			<?php echo $params->get( 'header' ); ?>
			</div>
			<?php
		}
		?>
		<iframe   
		id="blockrandom"
		src="<?php echo $row->url; ?>" 
		width="<?php echo $params->get( 'width' ); ?>" 
		height="<?php echo $params->get( 'height' ); ?>" 
		scrolling="<?php echo $params->get( 'scrolling' ); ?>" 
		align="top"
		frameborder="0"
		class="wrapper<?php echo $params->get( 'pageclass_sfx' ); ?>">
		<?php echo _CMN_IFRAMES; ?>
		</iframe>

		</div>
		<?php
		// displays back button
		mosHTML::BackButton ( $params );
	}

}
?>