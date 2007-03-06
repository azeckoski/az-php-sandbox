<?php
/**
* @version $Id: toolbar.menus.html.php,v 1.2 2005/11/08 10:26:19 eliasan Exp $
* @package Mambo
* @subpackage Menus
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Menus
*/
class TOOLBAR_menus {
	/**
	* Draws the menu for a New top menu item
	*/
	function _NEW()	{
		mosMenuBar::startTable();
		mosMenuBar::customX( 'edit', 'next.png', 'next_f2.png', 'Next', true );
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.menus.new' );
		mosMenuBar::endTable();
	}

	/**
	* Draws the menu to Move Menut Items
	*/
	function _MOVEMENU()	{
		mosMenuBar::startTable();
		mosMenuBar::custom( 'movemenusave', 'move.png', 'move_f2.png', 'Move', false );
		mosMenuBar::spacer();
		mosMenuBar::cancel( 'cancelmovemenu' );
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.menus.move' );
		mosMenuBar::endTable();
	}

	/**
	* Draws the menu to Move Menut Items
	*/
	function _COPYMENU()	{
		mosMenuBar::startTable();
		mosMenuBar::custom( 'copymenusave', 'copy.png', 'copy_f2.png', 'Copy', false );
		mosMenuBar::spacer();
		mosMenuBar::cancel( 'cancelcopymenu' );
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.menus.copy' );
		mosMenuBar::endTable();
	}

	/**
	* Draws the menu to edit a menu item
	*/
	function _EDIT($type) {
		global $id;
		$hs='';

		if ( !$id ) {
			$cid = mosGetParam( $_POST, 'cid', array(0) );
			$id = $cid[0];
		}
		$menutype 	= mosGetParam( $_REQUEST, 'menutype', 'mainmenu' );
		
		mosMenuBar::startTable();
		if ( !$id ) {
			$link = 'index2.php?option=com_menus&menutype='. $menutype .'&task=new&hidemainmenu=1';
			mosMenuBar::back( 'Back', $link );
			mosMenuBar::spacer();
		}
		mosMenuBar::save();
		mosMenuBar::spacer();
		mosMenuBar::apply();
		mosMenuBar::spacer();
		if ( $id ) {
			// for existing content items the button is renamed `close`
			mosMenuBar::cancel( 'cancel', 'Close' );
		} else {
			mosMenuBar::cancel();
		}
		mosMenuBar::spacer();
		//Displays the right help screen based on the
		//$type parameter
    switch ($type){
		  case 'content_blog_category': //Blog - Content Category 
		    $hs='453.screen.menus.content_blog_category';
		    break;
		    
		  case 'content_archive_category': //Blog - Content Category Archive 
		    $hs='453.screen.menus.content_archive_category';
		    break;
		    
		  case 'content_blog_section': //Blog - Content Section 
		    $hs='453.screen.menus.content_blog_section';
		    break;
		    
		  case 'content_archive_section': //Blog - Content Section Archive 
		    $hs='453.screen.menus.content_archive_section';
		    break;
		    
		  case 'content_item_link': //Link - Content Item 
		    $hs='453.screen.menus.content_item_link';
		    break;
		    
		  case 'content_typed': //Link - Static Content 
		    $hs='453.screen.menus.content_typed';
		    break;
		    
		  case 'content_category': //Table - Content Category 
		    $hs='453.screen.menus.content_category';
		    break;
		    
		  case 'content_section': //Table - Content Section 
		    $hs='453.screen.menus.content_section';
		    break;
		    
		  case 'components': //Component
		    $hs='453.screen.menus.components';
		    break;
		    
		  case 'component_item_link': //Link - Component Item 
		    $hs='453.screen.menus.component_item_link';
		    break;
		    
		  case 'contact_item_link': //Link - Contact Item
		    $hs='453.screen.menus.contact_item_link';
		    break;
		    
		  case 'newsfeed_link': //Link - Newsfeed
		    $hs='453.screen.menus.newsfeed_link';
		    break;
		    
		  case 'contact_category_table': //Table - Contact Category
		    $hs='453.screen.menus.contact_category_table';
		    break;
		    
		  case 'newsfeed_category_table': //Table - Newsfeed Category
		    $hs='453.screen.menus.newsfeed_category_table';
		    break;
		    
		  case 'weblink_category_table': //Table - Weblink Category
		    $hs='453.screen.menus.weblink_category_table';
		    break;
		    
		  case 'url': //Link - URL
		    $hs='453.screen.menus.url';
		    break;
		    
		  case 'separator': //Separator / Placeholder
		    $hs='453.screen.menus.separator';
		    break;
		    
		  case 'wrapper': //Wrapper
		    $hs='453.screen.menus.wrapper';
		    break;
		    
		  default:
		    $hs='default';
		    break;
		}
		mosMenuBar::help( $hs );  
    //mosMenuBar::help( '453.screen.menus.edit' );
		mosMenuBar::endTable();
	}

	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::addNewX();
		mosMenuBar::spacer();
		mosMenuBar::editListX();
		mosMenuBar::spacer();
		mosMenuBar::publishList();
		mosMenuBar::spacer();
		mosMenuBar::unpublishList();
		mosMenuBar::spacer();
		mosMenuBar::customX( 'movemenu', 'move.png', 'move_f2.png', 'Move', true );
		mosMenuBar::spacer();
		mosMenuBar::customX( 'copymenu', 'copy.png', 'copy_f2.png', 'Copy', true );
		mosMenuBar::spacer();
		mosMenuBar::trash();
		mosMenuBar::spacer();
		mosMenuBar::help( '453.screen.menus.main' );
		mosMenuBar::endTable();
	}
}
?>
