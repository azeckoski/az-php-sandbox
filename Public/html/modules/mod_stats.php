<?php
/**
* @version $Id: mod_stats.php,v 1.1 2005/07/22 01:58:30 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_offset, $mosConfig_caching, $mosConfig_enable_stats;
global $mosConfig_gzip;
$serverinfo = $params->get( 'serverinfo' );
$siteinfo = $params->get( 'siteinfo' );
$moduleclass_sfx = $params->get( 'moduleclass_sfx' );

$content = "";

if ($serverinfo) {
	echo "<strong>OS:</strong> "  . substr(php_uname(),0,7) . "<br />\n";
	echo "<strong>PHP:</strong> " .phpversion() . "<br />\n";
	echo "<strong>MySQL:</strong> " .mysql_get_server_info() . "<br />\n";
	echo "<strong>"._TIME_STAT.": </strong> " .date("H:i",time()+($mosConfig_offset*60*60)) . "<br />\n";
	$c = $mosConfig_caching ? 'Enabled':'Disabled';
	echo "<strong>Caching:</strong> " . $c . "<br />\n";
	$z = $mosConfig_gzip ? 'Enabled':'Disabled';
	echo "<strong>GZIP:</strong> " . $z . "<br />\n";
}

if ($siteinfo) {
	$query="SELECT count(id) AS count_users FROM #__users";
	$database->setQuery($query);
	echo "<strong>"._MEMBERS_STAT.":</strong> " .$database->loadResult() . "<br />\n";

	$query="SELECT count(id) as count_items from #__content";
	$database->setQuery($query);
	echo "<strong>"._NEWS_STAT.":</strong> ".$database->loadResult() . "<br />\n";

	$query="SELECT count(id) as count_links FROM #__weblinks WHERE published='1'";
	$database->setQuery($query);
	echo "<strong>"._LINKS_STAT.":</strong> ".$database->loadResult() . "<br />\n";
}

if ($mosConfig_enable_stats) {
	$counter = $params->get( 'counter' );
	$increase = $params->get( 'increase' );
	if ($counter) {
		$query = "SELECT sum(hits) AS count FROM #__stats_agents WHERE type='1'";
		$database->setQuery( $query );
		$hits = $database->loadResult();

		$hits = $hits + $increase;

		if ($hits == NULL) {
			$content .= "<strong>" . _VISITORS . ":</strong> 0\n";
		} else {
			$content .= "<strong>" . _VISITORS . ":</strong> " . $hits . "\n";
		}
	}
}
?>
