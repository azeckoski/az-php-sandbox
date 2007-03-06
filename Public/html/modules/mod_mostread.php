<?php
/**
* @version $Id: mod_mostread.php,v 1.1 2005/07/22 01:58:30 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_offset, $mosConfig_live_site;

$type 		= intval( $params->get( 'type', 1 ) );
$count 		= intval( $params->get( 'count', 5 ) );
$catid 		= trim( $params->get( 'catid' ) );
$secid 		= trim( $params->get( 'secid' ) );
$show_front	= $params->get( 'show_front', 1 );
$class_sfx 	= $params->get( 'moduleclass_sfx' );

$now 		= date( 'Y-m-d H:i:s', time()+$mosConfig_offset*60*60 );

$access = !$mainframe->getCfg( 'shownoauth' );

// select between Content Items, Static Content or both
switch ( $type ) {
	case 2:
		$query = "SELECT a.id, a.title"
		. "\n FROM #__content AS a"
		. "\n WHERE ( a.state = '1' AND a.checked_out = '0' AND a.sectionid = '0' )"
		. "\n AND ( a.publish_up = '0000-00-00 00:00:00' OR a.publish_up <= '". $now ."' )"
		. "\n AND ( a.publish_down = '0000-00-00 00:00:00' OR a.publish_down >= '". $now ."' )"
    	. ( $access ? "\n AND a.access <= '". $my->gid ."'" : '' )
		. "\n ORDER BY a.hits DESC LIMIT $count"
		;
		$database->setQuery( $query );
		$rows = $database->loadObjectList();	
		break;

	case 3:
		$query = "SELECT a.id, a.title, a.sectionid"
		. "\n FROM #__content AS a"
		. "\n WHERE ( a.state = '1' AND a.checked_out = '0' )"
		. "\n AND ( a.publish_up = '0000-00-00 00:00:00' OR a.publish_up <= '". $now ."' )"
		. "\n AND ( a.publish_down = '0000-00-00 00:00:00' OR a.publish_down >= '". $now ."' )"
    	. ( $access ? "\n AND a.access <= '". $my->gid ."'" : '' )
		. "\n ORDER BY a.hits DESC LIMIT $count"
		;
		$database->setQuery( $query );
		$rows = $database->loadObjectList();	
		break;
		
	case 1:
	default:
		$query = "SELECT a.id, a.title, a.sectionid, a.catid"
		. "\n FROM #__content AS a"
		. "\n LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id"
		. "\n WHERE ( a.state = '1' AND a.checked_out = '0' AND a.sectionid > '0' )"
		. "\n AND ( a.publish_up = '0000-00-00 00:00:00' OR a.publish_up <= '". $now ."' )"
		. "\n AND ( a.publish_down = '0000-00-00 00:00:00' OR a.publish_down >= '". $now ."' )"
    	. ( $access ? "\n AND a.access <= '". $my->gid ."'" : '' )
		. ( $catid ? "\n AND ( a.catid IN (". $catid .") )" : '' )
		. ( $secid ? "\n AND ( a.sectionid IN (". $secid .") )" : '' )
		. ( $show_front == "0" ? "\n AND f.content_id IS NULL" : '' )
		. "\n ORDER BY a.hits DESC LIMIT $count"
		;
		$database->setQuery( $query );
		$rows = $database->loadObjectList();
		
		break;		
}

// needed to reduce queries used by getItemid for Content Items
if ( ( $type == 1 ) || ( $type == 3 ) ) {
	$bs 	= $mainframe->getBlogSectionCount();
	$bc 	= $mainframe->getBlogCategoryCount();
	$gbs 	= $mainframe->getGlobalBlogSectionCount();
}

// Output
?>
<ul class="mostread<?php echo $class_sfx; ?>">
<?php
foreach ($rows as $row) {
	// get Itemid
	switch ( $type ) {
		case 2:
			$query = "SELECT id"
			. "\n FROM #__menu"
			. "\n WHERE type = 'content_typed'"
			. "\n AND componentid = $row->id"
			;
			$database->setQuery( $query );	
			$Itemid = $database->loadResult();
			break;
			
		case 3:
			if ( $row->sectionid ) {
				$Itemid = $mainframe->getItemid( $row->id, 0, 0, $bs, $bc, $gbs );
			} else {
				$query = "SELECT id"
				. "\n FROM #__menu"
				. "\n WHERE type = 'content_typed'"
				. "\n AND componentid = $row->id"
				;
				$database->setQuery( $query );	
				$Itemid = $database->loadResult();				
			}
			break;

		case 1:
		default:
			$Itemid = $mainframe->getItemid( $row->id, 0, 0, $bs, $bc, $gbs );
			break;
	}
	
	// Blank itemid checker for SEF
	if ($Itemid == NULL) {
		$Itemid = '';
	} else {
		$Itemid = '&amp;Itemid='.$Itemid;
	}
	
 	$link = sefRelToAbs( 'index.php?option=com_content&amp;task=view&amp;id='. $row->id . $Itemid );
 	?>
 	<li class="latestnews<?php echo $class_sfx; ?>">
 	<a href="<?php echo $link; ?>" class="mostread<?php echo $class_sfx; ?>">
 	<?php echo $row->title; ?>
 	</a>
 	</li>
 	<?php
}
?>
</ul>