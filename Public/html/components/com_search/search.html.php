<?php
/**
* @version $Id: search.html.php,v 1.1 2005/07/22 01:54:56 eddieajau Exp $
* @package Mambo
* @subpackage Search
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Search
*/
class search_html {
	
	function openhtml( $params ) {
		if ( $params->get( 'page_title' ) ) {
			?>
			<div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
			<?php echo $params->get( 'header' ); ?>
			</div> 
			<?php 
		}
	}

	function searchbox( $searchword, &$lists, $params ) {
		global $Itemid;
		?>
		<form action="index.php" method="post">
		<table class="contentpaneopen<?php echo $params->get( 'pageclass_sfx' ); ?>">
			<tr>
				<td nowrap="nowrap">
				<?php echo _PROMPT_KEYWORD; ?>:
				</td>
				<td nowrap="nowrap">
				<input type="text" name="searchword"size="15" value="<?php echo stripslashes($searchword);?>" class="inputbox" />
				</td>
				<td width="100%" nowrap="nowrap">
				<input type="submit" name="submit" value="<?php echo _SEARCH_TITLE;?>" class="button" />
				</td>
			</tr>
			<tr>
				<td colspan="3">
				<?php echo $lists['searchphrase']; ?>
				</td>
			</tr>
			<tr>
				<td colspan="3"><?php echo _CMN_ORDERING;?>: <?php echo $lists['ordering'];?></td>
			</tr>
		</table>
		
		<input type="hidden" name="option" value="com_search" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		</form>
		<?php
	}

	function searchintro( $searchword, $params ) {
		?>
		<table class="searchintro<?php echo $params->get( 'pageclass_sfx' ); ?>">
		<tr>
			<td colspan="3" align="left">
			<?php echo _PROMPT_KEYWORD . ' <b>' . stripslashes($searchword) . '</b>'; ?>	
		<?php
	}

	function message( $message, $params ) {
		?>
		<table class="searchintro<?php echo $params->get( 'pageclass_sfx' ); ?>">
		<tr>
			<td colspan="3" align="left">
			<?php eval ('echo "'.$message.'";');	?>
			</td>
		</tr>
		</table>
		<?php
	}

	function displaynoresult() {
		?>
			</td>
		</tr>
		<?php
	}

	function display( &$rows, $params ) {
		global $mosConfig_offset;
		
		$c 			= count ($rows);
		$tabclass 	= array("sectiontableentry1", "sectiontableentry2");
		$k 			= 0;
				
		// number of matches found
		printf( _SEARCH_MATCHES, $c );
		?>
			</td>
		</tr>
		</table>
		<br />
		<table class="contentpaneopen<?php echo $params->get( 'pageclass_sfx' ); ?>">
		<?php
		foreach ($rows as $row) {
			if ($row->created) {
				$created = mosFormatDate ($row->created, '%d %B, %Y');
			} else {
				$created = '';
			}
			?>
			<tr class="<?php echo $tabclass[$k] . $params->get( 'pageclass_sfx' ); ?>">
				<td>
				<?php
				if ($row->browsernav == 1) {
					?>
					<a href="<?php echo sefRelToAbs($row->href); ?>" target="_blank">
					<?php
				} else {
					?>
					<a href="<?php echo sefRelToAbs($row->href); ?>">
					<?php
				}
				echo $row->title;
				?>
				</a>
				<span class="small<?php echo $params->get( 'pageclass_sfx' ); ?>">
				(<?php echo $row->section; ?>)
				</span>
				</td>
			</tr>
			<tr class="<?php echo $tabclass[$k] . $params->get( 'pageclass_sfx' ); ?>">
				<td>
				<?php echo $row->text;?> &#133;
				</td>
			</tr>
			<tr>
				<td class="small<?php echo $params->get( 'pageclass_sfx' ); ?>">
				<?php echo $created; ?>
				</td>
			</tr>
			<tr>
				<td>
				&nbsp;
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
	}

	function conclusion( $totalRows, $searchword ) {
		global $mosConfig_live_site;
		?>
		<tr>
			<td colspan="3">
			&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="3">
			<?php
			eval ('echo "'._CONCLUSION.'";');
			?>
			<a href="http://www.google.com/search?q=<?php echo stripslashes($searchword);?>" target="_blank">
			<img src="<?php echo $mosConfig_live_site;?>/images/M_images/google.png" border="0" align="texttop" />
			</a>
			</td>
		</tr>
		</table>	
		<?php
	}
}
?>