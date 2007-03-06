<?php
/**
* @version $Id: rss.php,v 1.1 2005/07/22 01:54:56 eddieajau Exp $
* @package Mambo
* @subpackage Syndicate
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// load feed creator class
require_once( $mosConfig_absolute_path .'/includes/feedcreator.class.php' );

$info	=	null;
$rss	=	null;

switch ( $task ) {
	case 'live_bookmark':
		feedFrontpage( false );
		break;
		
	default:
		feedFrontpage( true );
		break;
}

/*
* Creates feed from Content Iems associated to teh frontpage component
*/
function feedFrontpage( $showFeed ) {
	global $database, $mainframe;
	global $mosConfig_live_site, $mosConfig_offset, $mosConfig_sef, $mosConfig_absolute_path;
	
	// get id of the syndication component
	$query = "SELECT a.id"
	. "\n FROM #__components AS a"
	. "\n WHERE a.name = 'Syndicate'";
	$database->setQuery( $query );
	$id = $database->loadResult();

	// load the row from the database table
	$row = new mosComponent( $database );
	$row->load( $id );

	// get syndication param definitions
	$params =& new mosParameters( $row->params, $mainframe->getPath( 'com_xml', $row->option ), 'component' );

	$query = "SELECT id FROM #__modules WHERE published=1 AND module='mod_rssfeed'";
	$database->setQuery($query);
	if (!$database->loadResult()) {
		mosNotAuth();
		return;
	}

	$now 	= date( 'Y-m-d H:i:s', time() + $mosConfig_offset * 60 * 60 );
	$iso 	= split( '=', _ISO );
	
	// parameter intilization
	$info[ 'date' ] 		= date( 'r' );
	$info[ 'year' ] 		= date( 'Y' );
	$info[ 'encoding' ] 	= $iso[1];
	$info[ 'link' ] 		= htmlspecialchars( $mosConfig_live_site );
	$info[ 'cache' ] 		= $params->def( 'cache', 1 );
	$info[ 'cache_time' ] 	= $params->def( 'cache_time', 3600 );
	$info[ 'count' ]		= $params->def( 'count', 5 );
	$info[ 'orderby' ] 		= $params->def( 'orderby', '' );
	$info[ 'title' ] 		= $params->def( 'title', 'Powered by Mambo' );
	$info[ 'description' ] 	= $params->def( 'description', 'Mambo site syndication' );
	$info[ 'image_file' ]	= $params->def( 'image_file', 'mambo_rss.png' );
	if ( $info[ 'image_file' ] == -1 ) {
		$info[ 'image' ]	= NULL;
	} else{
		$info[ 'image' ]	= $mosConfig_live_site .'/images/M_images/'. $info[ 'image_file' ];
	}
	$info[ 'image_alt' ] 	= $params->def( 'image_alt', 'Powered by Mambo' );
	$info[ 'limit_text' ] 	= $params->def( 'limit_text', 1 );
	$info[ 'text_length' ] 	= $params->def( 'text_length', 20 );
	// get feed type from url
	$info[ 'feed' ] 		= mosGetParam( $_GET, 'feed', 'RSS2.0' );
	// live bookmarks
	$info[ 'live_bookmark' ]	= $params->def( 'live_bookmark', '' );
	$info[ 'bookmark_file' ]	= $params->def( 'bookmark_file', '' );
	// content to syndicate
//	$info[ 'content' ]		= $params->def( 'content', -1 );
	// validate the feed type
    $validFeedTypes = array('RSS2.0', '2.0', 'RSS1.0', '1.0', 'RSS0.91',
                            '0.91', 'PIE0.1', 'MBOX', 'OPML', 'ATOM',
                            'ATOM0.3', 'HTML', 'JAVASCRIPT', 'JS');
    if (!in_array(strtoupper($info[ 'feed' ]), $validFeedTypes)) {
        $info[ 'feed' ] = $validFeedTypes[0];
    } 
	// set filename for live bookmarks feed
	if ( !$showFeed & $info[ 'live_bookmark' ] ) {
		if ( $info[ 'bookmark_file' ] ) {
		// custom bookmark filename
			$info[ 'file' ] = $mosConfig_absolute_path .'/cache/'. $info[ 'bookmark_file' ];
		} else {
		// standard bookmark filename
			$info[ 'file' ] = $mosConfig_absolute_path .'/cache/'. $info[ 'live_bookmark' ];
		}		
	} else {
	// set filename for rss feeds
		$info[ 'file' ] = strtolower( str_replace( '.', '', $info[ 'feed' ] ) );
		$info[ 'file' ] = $mosConfig_absolute_path .'/cache/'. $info[ 'file' ] .'.xml';
	}
	
	// load feed creator class
	$rss 	= new UniversalFeedCreator();
	// load image creator class
	$image 	= new FeedImage();
	
	// loads cache file
	if ( $showFeed && $info[ 'cache' ] ) {
		$rss->useCached( $info[ 'feed' ], $info[ 'file' ], $info[ 'cache_time' ] );
	}
	
	$rss->title 			= $info[ 'title' ];
	$rss->description 		= $info[ 'description' ];
	$rss->link 				= $info[ 'link' ];
	$rss->syndicationURL 	= $info[ 'link' ];
	$rss->cssStyleSheet 	= NULL;
	$rss->encoding 			= $info[ 'encoding' ];
	
	if ( $info[ 'image' ] ) {
		$image->url 		= $info[ 'image' ];
		$image->link 		= $info[ 'link' ];
		$image->title 		= $info[ 'image_alt' ];
		$image->description	= $info[ 'description' ];
		// loads image info into rss array
		$rss->image 		= $image;
	}
	
/*	
testing to extend Syndication capabilities
	$join 		= '';
	$and 		= '';
	$content	= $info['content'];
	switch ( $info['content' ] ) {
		case 0:			
			$and 		= "\n AND a.sectionid != '0'";
			$orderby 	= 'a.sectionid, a.ordering';		
			break;
	
		case -1:
			$join 		= "\n INNER JOIN #__content_frontpage AS f ON f.content_id = a.id";
			$orderby 	= 'f.ordering';		
			break;

		default:
			$and 		= "\n AND a.sectionid = '$content'";
			$and 		.= "\n AND a.sectionid != '0'";
			$orderby 	= 'a.ordering';		
			break;	
	}
*/	
	// Determine ordering for sql
	switch ( strtolower( $info[ 'orderby' ] ) ) {
		case 'date':
			$orderby = 'a.created';
			break;
	
		case 'rdate':
			$orderby = 'a.created DESC';
			break;
	
		case 'alpha':
			$orderby = 'a.title';
			break;
	
		case 'ralpha':
			$orderby = 'a.title DESC';
			break;
	
		case 'hits':
			$orderby = 'a.hits DESC';
			break;
	
		case 'rhits':
			$orderby = 'a.hits ASC';
			break;
	
		case 'front':
			$orderby = 'f.ordering';
			break;
	
		default:
			$orderby = 'f.ordering';
			break;
	}

	$join 		= "\n INNER JOIN #__content_frontpage AS f ON f.content_id = a.id";
	$and 		= '';
	
	// query of frontpage content items
	$query = "SELECT a.*, u.name AS author, u.usertype"
	. "\n FROM #__content AS a"
	. $join
	. "\n LEFT JOIN #__users AS u ON u.id = a.created_by"
	. "\n WHERE a.state = '1'"
	. $and
	. "\n AND a.access = 0"
	. "\n AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '". $now ."' )"
	. "\n AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '". $now ."' )"
	. "\n ORDER BY ". $orderby
	. ( $info[ 'count' ] ? "\n LIMIT ". $info[ 'count' ] : '' )
	;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	
	foreach ( $rows as $row ) {
		// title for particular item
		$item_title = htmlspecialchars( $row->title );
		$item_title = html_entity_decode( $item_title );
		
		// article author
		$item_author		= $row->author;
	
		$ItemID = $mainframe->getItemid( $row->id );
		if ($ItemID==0) {
			//If the content item is not tied to a menu and the ItemID is 0 then the URL fails with SEF on
			//Reset to frontpage if this is the case
			$ItemID=1;
		}
		
		// url link to article (& used instead of &amp; as this is converted by feed creator)
		/* Build the $item_link a bit differently for SEF since sefRelToAbs doesn't convert the URL properly when 
		passed $mosConfig_live_site.  No SEF needs $mosConfig_live_site, else &amp; becomes an issue. */
		if ($mosConfig_sef==1) {
			$item_link = 'index.php?option=com_content&task=view&id='. $row->id .'&Itemid='. $ItemID;
		} else {
			$item_link = $mosConfig_live_site .'/index.php?option=com_content&task=view&id='. $row->id .'&Itemid='. $ItemID;
		}
  		$item_link = sefRelToAbs( $item_link );
	
		// removes all formating from the intro text for the description text
		$item_description = $row->introtext;
		$item_description = mosHTML::cleanText( $item_description );
		$item_description = html_entity_decode( $item_description );
		if ( $info[ 'limit_text' ] ) {
			if ( $info[ 'text_length' ] ) {
				// limits description text to x words
				$item_description_array = split( ' ', $item_description );
				$count = count( $item_description_array );
				if ( $count > $info[ 'text_length' ] ) {
					$item_description = '';
					for ( $a = 0; $a < $info[ 'text_length' ]; $a++ ) {
						$item_description .= $item_description_array[$a]. ' ';
					}
					$item_description = trim( $item_description );
					$item_description .= '...';
				}
			} else  {
				// do not include description when text_length = 0
				$item_description = NULL;
			}
		}
	
		// load individual item creator class
		$item = new FeedItem();
		// item info
		$item->title 		= $item_title;
		$item->link 		= $item_link;
		$item->description 	= $item_description;
		$item->source 		= $info[ 'link' ];
		$item->author		= $item_author;
	 
		// loads item info into rss array
		$rss->addItem( $item );
	}

	// save feed file
	$rss->saveFeed( $info[ 'feed' ], $info[ 'file' ], $showFeed );		
}	
?>
