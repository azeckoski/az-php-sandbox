<?php
/**
* @version $Id: frontend.html.php,v 1.3 2005/07/22 03:36:09 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
*/
class modules_html {

	function module( &$module, &$params, $Itemid, $style=0 ) {
		global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_lang, $mosConfig_absolute_path;

		// custom module params
		$rssurl 			= $params->get( 'rssurl' );
		$rssitems 			= $params->get( 'rssitems', 5 );
		$rssdesc 			= $params->get( 'rssdesc', 1 );
		$rssimage 			= $params->get( 'rssimage', 1 );
		$rssitemdesc		= $params->get( 'rssitemdesc', 1 );
		$moduleclass_sfx 	= $params->get( 'moduleclass_sfx' );
		$words 				= $params->def( 'word_count', 0 );

		if ($style == -1 && !$rssurl) {
			echo $module->content;
			return;
		} else {
			?>
			<table cellpadding="0" cellspacing="0" class="moduletable<?php echo $moduleclass_sfx; ?>">
			<?php
			if ( $module->showtitle != 0 ) {
				?>
				<tr>
					<th valign="top">
					<?php echo $module->title; ?>
					</th>
				</tr>
				<?php
			}

			if ( $module->content ) {
				?>
				<tr>
					<td>
					<?php echo $module->content; ?>
					</td>
				</tr>
				<?php
			}
		}
		// feed output
		if ( $rssurl ) {
			$cacheDir 		= $mosConfig_absolute_path .'/cache/';
			$LitePath 		= $mosConfig_absolute_path .'/includes/Cache/Lite.php';
			require_once( $mosConfig_absolute_path .'/includes/domit/xml_domit_rss.php' );
			$rssDoc =& new xml_domit_rss_document();
			$rssDoc->useCacheLite(true, $LitePath, $cacheDir, 3600);
			$rssDoc->loadRSS( $rssurl );
			$totalChannels 	= $rssDoc->getChannelCount();

			for ( $i = 0; $i < $totalChannels; $i++ ) {
				$currChannel =& $rssDoc->getChannel($i);
				$elements 	= $currChannel->getElementList();
				$iUrl		= 0;
				foreach ( $elements as $element ) {
					//image handling
					if ( $element == 'image' ) {
						$image =& $currChannel->getElement( DOMIT_RSS_ELEMENT_IMAGE );
						$iUrl	= $image->getUrl();
						$iTitle	= $image->getTitle();
					}
				}

				// feed title
				?>
				<tr>
					<td>
					<strong>
					<a href="<?php echo $currChannel->getLink(); ?>" target="_blank">
					<?php echo $currChannel->getTitle(); ?>
					</a>
					</strong>
					</td>
				</tr>
				<?php
				// feed description
				if ( $rssdesc ) {
					?>
					<tr>
						<td>
						<?php echo $currChannel->getDescription(); ?>
						</td>
					</tr>
					<?php
				}
				// feed image
				if ( $rssimage ) {
					?>
					<tr>
						<td align="center">
						<image src="<?php echo $iUrl; ?>" alt="<?php echo $iTitle; ?>"/>
						</td>
					</tr>
					<?php
				}

				$actualItems = $currChannel->getItemCount();
				$setItems = $rssitems;

				if ($setItems > $actualItems) {
					$totalItems = $actualItems;
				} else {
					$totalItems = $setItems;
				}

				?>
				<tr>
					<td>
					<ul class="newsfeed<?php echo $moduleclass_sfx; ?>">
					<?php
					for ($j = 0; $j < $totalItems; $j++) {
						$currItem =& $currChannel->getItem($j);
						// item title
						?>
						<li class="newsfeed<?php echo $moduleclass_sfx; ?>">
						<strong>
						<a href="<?php echo $currItem->getLink(); ?>" target="_blank">
						<?php echo $currItem->getTitle(); ?>
						</a>
						</strong>
						<?php
						// item description
						if ( $rssitemdesc ) {
							// item description
							$text 	= html_entity_decode( $currItem->getDescription() );

							// word limit check
							if ( $words ) {
								$texts = explode( ' ', $text );
								$count = count( $texts );
								if ( $count > $words ) {
									$text = '';
									for( $i=0; $i < $words; $i++ ) {
										$text .= ' '. $texts[$i];
									}
									$text .= '...';
								}
							}
							?>
							<div>
							<?php echo $text; ?>
							</div>
							<?php
						}
						?>
						</li>
						<?php
					}
					?>
					</ul>
					</td>
				</tr>
				<?php
			}
		}
		?>
		</table>
		<?php
	}

	/**
	* @param object
	* @param object
	* @param int The menu item ID
	* @param int -1=show without wrapper and title, -2=x-mambo style
	*/
	function module2( &$module, &$params, $Itemid, $style=0, $count=0 ) {
		global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_lang, $mosConfig_absolute_path;
		global $mainframe, $database, $my;
		$moduleclass_sfx 		= $params->get( 'moduleclass_sfx' );

		// check for custom language file
		$path = $mosConfig_absolute_path . '/modules/' . $module->module.$mosConfig_lang . '.php';
		if (file_exists( $path )) {
			include( $path );
		} else {
			$path = $mosConfig_absolute_path .'/modules/'. $module->module .'.eng.php';
			if (file_exists( $path )) {
				include( $path );
			}
		}

		$number = '';
		if ($count > 0) {
			$number = '<span>' . $count . '</span> ';
		}
		if ($style == -3) {
			// allows for rounded corners
			echo "\n<div class=\"module$moduleclass_sfx\"><div><div><div>";
			if ($module->showtitle != 0) {
				echo "<h3>$module->title</h3>";
			}
 			echo "\n";

			include( $mosConfig_absolute_path .'/modules/'. $module->module .'.php' );
			if (isset( $content)) {
				echo $content;
			}

			echo "\n";
			echo "\n</div></div></div></div>\n";
		} else if ($style == -2) {
			// x-mambo (divs and font headder tags)
			?>
			<div class="moduletable<?php echo $moduleclass_sfx; ?>">
			<?php
			if ($module->showtitle != 0) {
				//echo $number;
				?>
				<h3>
				<?php echo $module->title; ?>
				</h3>
				<?php
			}
			include( $mosConfig_absolute_path .'/modules/'. $module->module .'.php' );

			if (isset( $content)) {
				echo $content;
			}
			?>
			</div>
			<?php
		} else if ($style == -1) {
			// show a naked module - no wrapper and no title
			include( $mosConfig_absolute_path .'/modules/'. $module->module .'.php' );

			if (isset( $content)) {
				echo $content;
			}
		} else {
			?>
			<table cellpadding="0" cellspacing="0" class="moduletable<?php echo $moduleclass_sfx; ?>">
			<?php
			if ( $module->showtitle != 0 ) {
				?>
				<tr>
					<th valign="top">
					<?php //echo $number; ?>
					<?php echo $module->title; ?>
					</th>
				</tr>
				<?php
			}
			?>
			<tr>
				<td>
				<?php
				include( $mosConfig_absolute_path . '/modules/' . $module->module . '.php' );
				if (isset( $content)) {
					echo $content;
				}
				?>
				</td>
			</tr>
			</table>
			<?php
		}
	}
}
?>