<?php
/**
* @version $Id: pathway.php,v 1.1 2005/07/22 01:57:13 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function pathwayMakeLink( $id, $name, $link, $parent ) {
	$mitem = new stdClass();
	$mitem->id 		= $id;
	$mitem->name 	= $mitem->name = html_entity_decode( $name ); 
	$mitem->link 	= $link;
	$mitem->parent 	= $parent;
	$mitem->type 	= '';

	return $mitem;
}

/**
* Outputs the pathway breadcrumbs
* @param database A database connector object
* @param int The db id field value of the current menu item
*/
function showPathway( $Itemid ) {
	global $database, $option, $task, $mainframe, $mosConfig_absolute_path, $mosConfig_live_site;
	// get the home page
	$database->setQuery( "SELECT *"
	. "\nFROM #__menu"
	. "\nWHERE menutype='mainmenu' AND published='1'"
	. "\nORDER BY parent, ordering LIMIT 1"
	);
	$home_menu = new mosMenu( $database );
	$database->loadObject( $home_menu );

	// the the whole menu array and index the array by the id
	$database->setQuery( "SELECT id, name, link, parent, type"
	. "\nFROM #__menu"
	. "\nWHERE published='1'"
	. "\nORDER BY parent, ordering"
	);
	$mitems = $database->loadObjectList( 'id' );

	$isWin = (substr(PHP_OS, 0, 3) == 'WIN');
	$optionstring = $isWin ? $_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'];

	// are we at the home page or not
	$homekeys = array_keys( $mitems );
	$home = @$mitems[$home_menu->id]->name;
	$path = "";

	// this is a patch job for the frontpage items! aje
	if ($Itemid == $home_menu->id) {
		switch ($option) {
			case 'content':
			$id = intval( mosGetParam( $_REQUEST, 'id', 0 ) );
			if ($task=='blogsection'){

				$database->setQuery( "SELECT title FROM #__sections WHERE id=$id" );
			} else if ( $task=='blogcategory' ) {
				$database->setQuery( "SELECT title FROM #__categories WHERE id=$id" );
			} else {
				$database->setQuery( "SELECT title, catid FROM #__content WHERE id=$id" );
			}

			$row = null;
			$database->loadObject( $row );

			$id = max( array_keys( $mitems ) ) + 1;

			// add the content item
			$mitem2 = pathwayMakeLink(
			$Itemid,
			$row->title,
			"",
			1
			);
			$mitems[$id] = $mitem2;
			$Itemid = $id;

			$home = '<a href="'. sefRelToAbs('index.php') .'" class="pathway">'. $home .'</a>';
			break;

		}
	}

	switch( @$mitems[$Itemid]->type ) {
		case 'content_section':
		$id = intval( mosGetParam( $_REQUEST, 'id', 0 ) );

		switch ($task) {
			case 'category':
			if ($id) {
				$database->setQuery( "SELECT title FROM #__categories WHERE id=$id" );
				$title = $database->loadResult();

				$id = max( array_keys( $mitems ) ) + 1;
				$mitem = pathwayMakeLink(
				$id,
				$title,
				'index.php?option='. $option .'&task='. $task .'&id='. $id .'&Itemid='. $Itemid,
				$Itemid
				);
				$mitems[$id] = $mitem;
				$Itemid = $id;
			}
			break;

			case 'view':
			if ($id) {
				// load the content item name and category
				$database->setQuery( "SELECT title, catid, id FROM #__content WHERE id=$id" );
				$row = null;
				$database->loadObject( $row );

				// load and add the category
				$database->setQuery( "SELECT c.title AS title, s.id AS sectionid "
				."FROM #__categories AS c "
				."LEFT JOIN #__sections AS s "
				."ON c.section=s.id "
				."WHERE c.id=$row->catid" );
				$result = $database->loadObjectList();

				$title = $result[0]->title;
				$sectionid = $result[0]->sectionid;

				$id = max( array_keys( $mitems ) ) + 1;
				$mitem1 = pathwayMakeLink(
				$Itemid,
				$title,
				'index.php?option='. $option .'&task=category&sectionid='. $sectionid .'&id='. $row->catid,
				$Itemid
				);
				$mitems[$id] = $mitem1;

				// add the final content item
				$id++;
				$mitem2 = pathwayMakeLink(
				$Itemid,
				$row->title,
				"",
				$id-1
				);
				$mitems[$id] = $mitem2;
				$Itemid = $id;

			}
			break;
		}
		break;

		case 'content_category':
		$id = intval( mosGetParam( $_REQUEST, 'id', 0 ) );

		switch ($task) {

			case 'view':
			if ($id) {
				// load the content item name and category
				$database->setQuery( "SELECT title, catid FROM #__content WHERE id=$id" );
				$row = null;
				$database->loadObject( $row );

				$id = max( array_keys( $mitems ) ) + 1;
				// add the final content item
				$mitem2 = pathwayMakeLink(
				$Itemid,
				$row->title,
				"",
				$Itemid
				);
				$mitems[$id] = $mitem2;
				$Itemid = $id;

			}
			break;
		}
		break;

		case 'content_blog_category':
		case 'content_blog_section':
		switch ($task) {
			case 'view':
			$id = intval( mosGetParam( $_REQUEST, 'id', 0 ) );

			if ($id) {
				// load the content item name and category
				$database->setQuery( "SELECT title, catid FROM #__content WHERE id=$id" );
				$row = null;
				$database->loadObject( $row );

				$id = max( array_keys( $mitems ) ) + 1;
				$mitem2 = pathwayMakeLink(
				$Itemid,
				$row->title,
				"",
				$Itemid
				);
				$mitems[$id] = $mitem2;
				$Itemid = $id;

			}
			break;
		}
		break;
	}

	$i = count( $mitems );
	$mid = $Itemid;

	$imgPath =  'templates/' . $mainframe->getTemplate() . '/images/arrow.png';
	if (file_exists( "$mosConfig_absolute_path/$imgPath" )){
		$img = '<img src="' . $mosConfig_live_site . '/' . $imgPath . '" border="0" alt="arrow" />';
	} else { 
		$imgPath = '/images/M_images/arrow.png';
		if (file_exists( $mosConfig_absolute_path . $imgPath )){
			$img = '<img src="' . $mosConfig_live_site . '/images/M_images/arrow.png" alt="arrow" />';
		} else {
		    $img = '&gt;';
		}
	}

	while ($i--) {
		if (!$mid || empty( $mitems[$mid] ) || $mid == 1 || !eregi("option", $optionstring)) {
			break;
		}
		$item =& $mitems[$mid];

		// converts & to &amp; for xtml compliance
		$itemname = ampReplace( $item->name );
		
		// if it is the current page, then display a non hyperlink
		if ($item->id == $Itemid || empty( $mid ) || empty($item->link)) {
			$newlink = "  $itemname";
		} else if (isset($item->type) && $item->type == 'url') {
			$correctLink = eregi( 'http://', $item->link);
			if ($correctLink==1) {
				$newlink = '<a href="'. $item->link .'" target="_window" class="pathway">'. $itemname .'</a>';
			} else {
				$newlink = $itemname;
			}
		} else {
			$newlink = '<a href="'. sefRelToAbs( $item->link .'&Itemid='. $item->id ) .'" class="pathway">'. $itemname .'</a>';
		}

		$newlink = ampReplace( $newlink );
		
		if (trim($newlink)!="") {
			$path = $img .' '. $newlink .' '. $path;
		} else {
			$path = '';
		}

		$mid = $item->parent;
	}
	
	if ( eregi( 'option', $optionstring ) && trim( $path  ) ) {
		$home = '<a href="'. sefRelToAbs( 'index.php' ) .'" class="pathway">'. $home .'</a>';
	}

	if ($mainframe->getCustomPathWay()){
		$path .= $img . ' ';
		$path .= implode ("$img " ,$mainframe->getCustomPathWay());
	}
  
	echo ( "<span class=\"pathway\">". $home ." ". $path ."</span>\n" );
}

// code placed in a function to prevent messing up global variables
showPathway( $Itemid );
?>
