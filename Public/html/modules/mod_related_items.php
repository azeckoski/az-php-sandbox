<?php
/**
* @version $Id: mod_related_items.php,v 1.1 2005/07/22 01:58:30 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$option = trim( mosGetParam( $_REQUEST, 'option', null ) );
$task = trim( mosGetParam( $_REQUEST, 'task', null ) );
$id = intval( mosGetParam( $_REQUEST, 'id', null ) );
$moduleclass_sfx = $params->get( 'moduleclass_sfx' );

if ($option == 'com_content' && $task == 'view' && $id) {

	// select the meta keywords from the item
	$query = "SELECT metakey FROM #__content WHERE id='$id'";
	$database->setQuery( $query );

	if ($metakey = trim( $database->loadResult() )) {
		// explode the meta keys on a comma
		$keys = explode( ',', $metakey );
		$likes = array();

		// assemble any non-blank word(s)
		foreach ($keys as $key) {
			$key = trim( $key );
			if ($key) {
				$likes[] = $database->getEscaped( $key );
			}
		}

		if (count( $likes )) {
			// select other items based on the metakey field 'like' the keys found
			$query = "SELECT id, title"
			. "\nFROM #__content"
			. "\nWHERE id<>$id AND state=1 AND access <=$my->gid AND (metakey LIKE '%";
			$query .= implode( "%' OR metakey LIKE '%", $likes );
			$query .= "%')";

			$database->setQuery( $query );
			if ($related = $database->loadObjectList()) {
				echo "<ul>\n";
				foreach ($related as $item) {
					if ($option="com_content" && $task="view") {
						$Itemid = $mainframe->getItemid($item->id);
					}
					$href = sefRelToAbs( "index.php?option=com_content&task=view&id=$item->id&Itemid=$Itemid" );
					echo "	<li><a href=\"$href\">$item->title</a></li>\n";
				}
				echo "</ul>\n";
			}
		}
	}
}
?>