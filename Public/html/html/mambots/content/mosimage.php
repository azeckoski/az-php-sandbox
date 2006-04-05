<?php
/**
* @version $Id: mosimage.php,v 1.2 2005/10/16 00:10:03 cauld Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onPrepareContent', 'botMosImage' );

/**
*/
function botMosImage( $published, &$row, &$params, $page=0 ) {
	global $database;
	
 	// expression to search for
	$regex = '/{mosimage\s*.*?}/i';
  	
	// find all instances of mambot and put in $matches
	preg_match_all( $regex, $row->text, $matches );
	
 	// Number of mambots
	$count = count( $matches[0] );

 	// mambot only processes if there are any instances of the mambot in the text
 	if ( $count ) {
		// load mambot params info
		$query = "SELECT id FROM #__mambots WHERE element = 'mosimage' AND folder = 'content'";
		$database->setQuery( $query );
	 	$id 	= $database->loadResult();
	 	$mambot = new mosMambot( $database );
	  	$mambot->load( $id );
	 	$params =& new mosParameters( $mambot->params ); 	
	 	
	 	$params->def( 'padding' );
	 	$params->def( 'margin' );
	 	$params->def( 'link', 0 );

 		$images 	= processImages( $row, $params );
		
		// store some vars in globals to access from the replacer
		$GLOBALS['botMosImageCount'] 	= 0;
		$GLOBALS['botMosImageParams'] 	=& $params;
		$GLOBALS['botMosImageArray'] 	=& $images;
		//$GLOBALS['botMosImageArray'] 	=& $combine;
	
		// perform the replacement
		$row->text = preg_replace_callback( $regex, 'botMosImage_replacer', $row->text );
	
		// clean up globals
		unset( $GLOBALS['botMosImageCount'] );
		unset( $GLOBALS['botMosImageMask'] );
		unset( $GLOBALS['botMosImageArray'] );
	
		return true;
	} 	
}

function processImages ( &$row, &$params ) {
	global $mosConfig_absolute_path, $mosConfig_live_site;
	
	$images 		= array();

	// split on \n the images fields into an array
	$row->images 	= explode( "\n", $row->images );
	$total 			= count( $row->images );
	
	$start = 0;
	for ( $i = $start; $i < $total; $i++ ) {
		$img = trim( $row->images[$i] );

		// split on pipe the attributes of the image
		if ( $img ) {
			$attrib = explode( '|', trim( $img ) );
			// $attrib[0] image name and path from /images/stories
			
			// $attrib[1] alignment
			if ( !isset($attrib[1]) || !$attrib[1] ) {
				$attrib[1] = '';
			}
			
			// $attrib[2] alt & title
			if ( !isset($attrib[2]) || !$attrib[2] ) {
				$attrib[2] = 'Image';
			} else {
				$attrib[2] = htmlspecialchars( $attrib[2] );
			}
			
			// $attrib[3] border
			if ( !isset($attrib[3]) || !$attrib[3] ) {
				$attrib[3] = '0';
			}
			
			// $attrib[4] caption
			if ( !isset($attrib[4]) || !$attrib[4] ) {
				$attrib[4]	= '';
				$border 	= $attrib[3];
			} else {
				$border 	= 0;
			}
			
			// $attrib[5] caption position
			if ( !isset($attrib[5]) || !$attrib[5] ) {
				$attrib[5] = '';
			}
			
			// $attrib[6] caption alignment
			if ( !isset($attrib[6]) || !$attrib[6] ) {
				$attrib[6] = '';
			}
			
			// $attrib[7] width
			if ( !isset($attrib[7]) || !$attrib[7] ) {
				$attrib[7] 	= '';
				$width 		= '';
			} else {
				$width 		= ' width: '. $attrib[7] .'px;';
			}
			
			// image size attibutes
			$size = '';
			if ( function_exists( 'getimagesize' ) ) {
				$size 	= @getimagesize( $mosConfig_absolute_path .'/images/stories/'. $attrib[0] );
				if (is_array( $size )) {
					$size = 'width="'. $size[0] .'" height="'. $size[1] .'"';
				}
			}
			
			// assemble the <image> tag
			$image = '<img src="'. $mosConfig_live_site .'/images/stories/'. $attrib[0] .'" '. $size;
			// no aligment variable - if caption detected
			if ( !$attrib[4] ) {
				$image .= $attrib[1] ? ' align="'. $attrib[1] .'"' : '';
			}
			$image .=' hspace="6" alt="'. $attrib[2] .'" title="'. $attrib[2] .'" border="'. $border .'" />';
			
			// assemble caption - if caption detected
			if ( $attrib[4] ) {
				$caption = '<div class="mosimage_caption" style="width: '. $width .'; text-align: '. $attrib[6] .';" align="'. $attrib[6] .'">';
				$caption .= $attrib[4];
				$caption .='</div>';
			}		
			
			// final output
			if ( $attrib[4] ) {
				$img = '<div class="mosimage" style="border-width: '. $attrib[3] .'px; float: '. $attrib[1] .'; margin: '. $params->def( 'margin' ) .'px; padding: '. $params->def( 'padding' ) .'px;'. $width .'" align="center">';
				
				// display caption in top position
				if ( $attrib[5] == 'top' ) {
					$img .= $caption;
				}
				
				$img .= $image;				
				
				// display caption in bottom position
				if ( $attrib[5] == 'bottom' ) {
					$img .= $caption;
				}
				$img .='</div>';
			} else {
				$img = $image;
			}

			
			$images[] = $img;
		}
	}
	
	return $images;
}

/**
* Replaces the matched tags an image
* @param array An array of matches (see preg_match_all)
* @return string
*/
function botMosImage_replacer( &$matches ) {
	$i = $GLOBALS['botMosImageCount']++;
	
	return @$GLOBALS['botMosImageArray'][$i];
}
?>
