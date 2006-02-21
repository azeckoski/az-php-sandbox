<?php 
/**
* swmenupro v1.0
* http://swonline.biz
* Copyright 2004 Sean White
* DHTML Menu Component for Mambo Open Source
* Mambo Open Source is Free Software
* Released under GNU/GPL License: http://www.gnu.org/copyleft/gpl.html
**/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mosConfig_absolute_path . "/includes/frontend.php");

require_once( $mosConfig_absolute_path . "/administrator/components/com_swmenupro/admin.swmenupro.class.php");


$cid = mosGetParam( $_REQUEST, 'cid', array(0) );

if (!is_array( $cid )) {

	$cid = array(0);

}
		switch ($task) 
		{
 		case "new":
 		editModule( '0', $option);       
 		break;	
	
		case "saveedit":
		saveconfig($cid[0], $option);
		break;

		case "publish":
		publishModule( $id, $cid, 1, $option );
		break;

		case "unpublish":
		publishModule( $id, $cid, 0, $option );
		break;
		
		case "editDhtmlMenu":
 		editDhtmlMenu( $cid[0], $option );      
 		break;	

  		case "moduleEdit":
       	editModule( $cid[0], $option );
       	break;

		case "edit":
       	editModule( $cid[0], $option );
       	break;

  		case "save":
       	saveMyMenu( $option );
       	break;

 		case "remove":
   		{
     	if(is_array($cid) && count($cid) >1)
		{
			foreach($cid as $delid)
			{
				removeMyMenu( $delid, $option );
			}
		}
		else
		{
			$delid = $cid[0];
			removeMyMenu( $delid, $option );
		}
   		} break;
		
		default:
      	showModules( $option );
        break;

}


function showModules( $option ) 
{
	
	
	global $database, $my, $mainframe;

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

	// get the total number of records
	$database->setQuery( "SELECT count(*) FROM #__modules WHERE module='mod_swmenupro' OR module='mod_mainmenu'" );
	$total = $database->loadResult();
	echo $database->getErrorMsg();

	require_once( "includes/pageNavigation.php" );
	$pageNav = new mosPageNav( $total, $limitstart, $limit );

	$database->setQuery( "SELECT m.*, u.name AS editor, g.name AS groupname"
		. "\nFROM #__modules AS m"
		. "\nLEFT JOIN #__users AS u ON u.id = m.checked_out"
		. "\nLEFT JOIN #__groups AS g ON g.id = m.access"
		. "\nWHERE module='mod_swmenupro' OR module='mod_mainmenu'"
		. "\nORDER BY position, ordering"
		. "\nLIMIT $pageNav->limitstart,$pageNav->limit"
	);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
 HTML_swmenupro::showModules( $rows, $option, $pageNav );
	
}


function publishModule( $id=null, $cid=null, $publish=1, $option ) {
	global $database;

	if (!is_array( $cid )) {
		$cid = array();
	}
	if ($id) {
		$cid[] = $id;
	}

	if (count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select a module to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__modules SET published='$publish'"
		. "\nWHERE id IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))"
	);
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (count( $cid ) == 1) {
		$row = new mosModule( $database );
		$row->checkin( $cid[0] );
	}

	$limit = intval( mosGetParam( $_REQUEST, 'limit', 10 ) );
	$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
	mosRedirect( "index2.php?option=$option&limit=$limit&limitstart=$limitstart" );
}    



/**
* Creates a new or edits and existing user record
* @param int The id of the record, 0 if a new entry
* @param string The current GET/POST option
*/
function editModule( $uid, $option ) 
{
	global $database, $my;

	$row = new mosModule( $database );
	// load the row from the db table
	$row->load( $uid );

	// fail if checked out not by 'me'
	if ($row->checked_out && $row->checked_out <> $my->id) {
		echo "<script>alert('The module $row->title is currently being edited by another administrator'); document.location.href='index2.php?option=$option'</script>\n";
		exit(0);
	}

	if ($uid) {
		$row->checkout( $my->id );
	}

	$database->setQuery( "SELECT position, ordering, showtitle, title FROM #__modules"
		. "\nORDER BY ordering"
	);
	if (!($orders = $database->loadObjectList())) {
		echo $database->stderr();
		return false;
	}

// build the order lists to be used to make the javascript arrays

	// hard code options for now
	$orders2 = array();
	$orders2['left'] = array();
	$orders2['right'] = array();
	$orders2['top'] = array();
	$orders2['bottom'] = array();
	$orders2['inset'] = array();
	$orders2['user1'] = array();
	$orders2['user2'] = array();

	$l = 0;
	$r = 0;
	for ($i=0, $n=count( $orders ); $i < $n; $i++) {
		$ord = 0;
		if (array_key_exists( $orders[$i]->position, $orders2 )) {
			$ord =count( array_keys( $orders2[$orders[$i]->position] ) ) + 1;
		}

		$orders2[$orders[$i]->position][] = mosHTML::makeOption( $ord, $ord.'::'.addslashes( $orders[$i]->title ) );

		##if ($orders[$i]->position == 'left') {
		##	$leftorder[$l] = mosHTML::makeOption( ++$l, $l.' before '.$orders[$i]->title );
		##} else {
		##	$rightorder[$r] = mosHTML::makeOption( ++$r, $r.' before '.$orders[$i]->title );
		##}
	}

// if a new record we must still prime the mosModule object with a default
// position and the order; also add an extra item to the order list to
// place the 'new' record in last position if desired
	if ($uid == 0) {
		$row->position = 'left';
		$row->showtitle = true;
		$row->ordering = $l;
	}

// make an array for the left and right positions
	foreach ( array_keys( $orders2 ) as $v ) {
		$ord = count( array_keys( $orders2[$v] ) ) + 1;
		$orders2[$v][] = mosHTML::makeOption( $ord, $ord.'::last' );
		##$pos[] = mosHTML::makeOption( 'left' );
		##$pos[] = mosHTML::makeOption( 'right' );
		$pos[] = mosHTML::makeOption( $v );
	}

// build the html select list
	$poslist = mosHTML::selectList( $pos, 'position',
		'class="inputbox" size="1" onchange="changeDynaList(\'ordering\',orders,document.adminForm.position.options[document.adminForm.position.selectedIndex].value, originalPos, originalOrder)"',
		'value', 'text', $row->position ? $row->position : 'left' );

// get list of groups
	$database->setQuery( "SELECT id AS value, name AS text FROM #__groups ORDER BY id" );
	$groups = $database->loadObjectList();

// build the html select list
	$glist = mosHTML::selectList( $groups, 'access', 'class="inputbox" size="1"',
		'value', 'text', intval( $row->access ) );

// get a list of the menu items
	$database->setQuery( "SELECT m.*"
		. "\nFROM #__menu m"
		. "\nWHERE type != 'url' AND type != 'separator'"
		. "\nORDER BY menutype, ordering, parent"
	);
	$mitems = $database->loadObjectList();

// get selected pages
	if ($uid) {
		$database->setQuery( "SELECT menuid AS value FROM #__modules_menu WHERE moduleid=$row->id" );
		$lookup = $database->loadObjectList();
	} else {
		$lookup = array( mosHTML::makeOption( 0, 'All' ) );
	}

// establish the hierarchy of the menu
	$children = array();
// first pass - collect children
	foreach ($mitems as $v ) {
		$id = $v->id;
		$pt = $v->parent;
		$list = @$children[$pt] ? $children[$pt] : array();
		array_push( $list, $v );
		$children[$pt] = $list;
	}
// second pass - get an indent list of the items
	$list = mosTreeRecurse( intval( $mitems[0]->parent ), '', array(), $children );

// prepare an array with 'all' as the first item
	$mitems = array( mosHTML::makeOption( 0, 'All' ) );
// append the rest of the menu items to the array
	foreach ($list as $item) {
		$mitems[] = mosHTML::makeOption( $item->id, $item->menutype.": ".$item->treename );
	}

// build the html select list
	$menulist = mosHTML::selectList( $mitems, 'selections[]', 'class="inputbox" size="10" multiple="multiple"',
		'value', 'text', $lookup );

// make the select list for the image positions
	$yesno[] = mosHTML::makeOption( '0', 'No' );
	$yesno[] = mosHTML::makeOption( '1', 'Yes' );

// build the html select list
	$titlelist = mosHTML::selectList( $yesno, 'showtitle', 'class="inputbox" size="1"', 'value', 'text', $row->showtitle );

	$publishlist = mosHTML::selectList( $yesno, 'published', 'class="inputbox" size="1"', 'value', 'text', $row->published );

	
	
	
		$menu_type=null;
		$menu_type[] = "Please Select...";
		$menu_type[] = "Create new menu";

		

		$database->setQuery("SELECT DISTINCT menutype FROM #__menu");
		$lookup = $database->loadObjectList();
		
		
		foreach($lookup as $result)
		{
		$menu_type[] = $result->menutype;
		
		}
		
	
	
	HTML_swmenupro::editModule( $row, $orders2, $glist, $menulist, $poslist, $titlelist, $publishlist, $option, $menu_type );
      
}






/**
* Saves the record from an edit form submit
* @param string The current GET/POST option
*/
function saveMyMenu( $option ) 
{    
 	global $database, $my, $mainframe;

	$row = new mosModule( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	
	$params = mosParseParams( $row->params );
	$menutype = @$params->menutype ? $params->menutype : 'mainmenu';
	$moduleID = @$params->moduleID;
	$menustyle = @$params->menustyle;

	

	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();
	$row->updateOrder( "position='$row->position'" );
	
	
	if((!$moduleID) && ($row->module != "mod_mainmenu")){
	$params = "menutype=".$menutype."\n";
	$params.= "menustyle=".$menustyle."\n";
	$params.= "moduleID=".$row->id."\n";
	$row->params = $params;

	


	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	}

	$menus = mosGetParam( $_POST, 'selections', array() );

	$database->setQuery( "DELETE FROM #__modules_menu WHERE moduleid='$row->id'" );
	$database->query();

	foreach ($menus as $menuid){
		$database->setQuery( "INSERT INTO #__modules_menu"
			. "\nSET moduleid='$row->id', menuid='$menuid'"
		);
		$database->query();
	}

	$row2 = new swmenuproMenu( $database );
	
	if($menustyle=="treemenu"){
	
	if (!$row2->treemenu()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	}
	if($menustyle=="clickmenu"){
	
	if (!$row2->clickmenu()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	}
	if($menustyle=="gosumenu"){
	
	if (!$row2->gosumenu()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	}
	

	$result = mysql_query("SELECT * FROM #__swmenu_config WHERE id='".$row->id."'");
	$count = mysql_num_rows($result);

		if($count >= 1) {
			$ret = $row2->_db->updateObject( $row2->_tbl, $row2, $row2->_tbl_key, $updateNulls );
		} else {
			$row2->id = $row->id;
			$ret = $row2->_db->insertObject( $row2->_tbl, $row2, $row2->_tbl_key );
		}

	$limit = intval( mosGetParam( $_REQUEST, 'limit', 10 ) );
	$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
	mosRedirect( "index2.php?option=$option&limit=$limit&limitstart=$limitstart" );
}


function removeMyMenu( &$cid, $option ) 
{
  	global $database,$mosConfig_absolute_path;

	$database->setQuery( "SELECT * FROM #__modules WHERE id = '$cid'" );
	$database->query();
	$database->loadObject($row);

	$database->setQuery( "DELETE FROM #__modules WHERE id = '$cid'" );
	$database->query();
	$database->setQuery( "DELETE FROM #__modules_menu WHERE moduleid = '$cid'" );
	$database->query();
  		
	$database->setQuery( "DELETE FROM #__swmenu_config WHERE id = '$cid'" );
	$database->query();
	$database->setQuery( "DELETE FROM #__swmenu_extended WHERE moduleID = '$cid'" );
	$database->query();
  	mosRedirect("index2.php?option=$option");
}


function editDhtmlMenu($id, $option){
global $database, $my, $mainframe;
		
		$pageID = mosGetParam( $_REQUEST, 'pageID', array(0) );
		if (substr($pageID,0,3)!='tab'){$pageID = 'tab1';}
		$row = new mosModule( $database );
		// load the row from the db table
		$row->load( $id );
		$params = mosParseParams( $row->params );
		$menutype = @$params->menutype ? $params->menutype : 'mainmenu';
		$menustyle = @$params->menustyle;
		$moduleID = @$params->moduleID;
		$modulename = $row->title;
		$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
		$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart$menutype", 'limitstart', 0 );
		$levellimit = $mainframe->getUserStateFromRequest( "view{$option}limit$menutype", 'levellimit', 10 );
	

	$database->setQuery("SELECT #__menu.* , #__swmenu_extended.* FROM #__menu LEFT JOIN #__swmenu_extended ON #__menu.id = #__swmenu_extended.menu_id AND (#__swmenu_extended.moduleID=".$moduleID." OR #__swmenu_extended.moduleID IS NULL) WHERE menutype='".$menutype."' ORDER BY parent, ordering");
    $rows = $database->loadObjectList();
	echo $database->getErrorMsg();

// establish the hierarchy of the menu
	$children = array();
// first pass - collect children
	foreach ($rows as $v ) {
		$pt = $v->parent;
		$list = @$children[$pt] ? $children[$pt] : array();
		array_push( $list, $v );
		$children[$pt] = $list;
	}
// second pass - get an indent list of the items
	$list = mosTreeRecurse( 0, '', array(), $children, max( 0, $levellimit-1 ) );
	// eventually only pick out the searched items.
	
	$total = count( $list );

	require_once( "includes/pageNavigation.php" );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	if($menustyle=="clickmenu"){
	$levellist = mosHTML::integerSelectList( 1, 2, 1, 'levellimit', 'size="1" onchange="document.adminForm.submit();"', $levellimit );
	}else{
	$levellist = mosHTML::integerSelectList( 1, 20, 1, 'levellimit', 'size="1" onchange="document.adminForm.submit();"', $levellimit );
	}

// slice out elements based on limits
	$list = array_slice( $list, $pageNav->limitstart, $pageNav->limit );

       
        $row = new swmenuproMenu( $database );
        $row->load( $id );

	
	$padding1 = explode("px", $row->main_padding);
	$padding2 = explode("px", $row->sub_padding);
	for($i=0;$i<4; $i++){
	$padding1[$i]=trim($padding1[$i]);
	$padding2[$i]=trim($padding2[$i]);
	}
	$border1 = explode(" ", $row->main_border);
	$border2 = explode(" ", $row->sub_border);
	
	$border1[0]=rtrim(trim($border1[0]),'px');
	$border2[0]=rtrim(trim($border2[0]),'px');
	$border1[1]=trim($border1[1]);
	$border2[1]=trim($border2[1]);
	$border1[2]=trim($border1[2]);
	$border2[2]=trim($border2[2]);

	$border3 = explode(" ", $row->main_border_over);
	$border4 = explode(" ", $row->sub_border_over);
	
	$border3[0]=rtrim(trim($border3[0]),'px');
	$border4[0]=rtrim(trim($border4[0]),'px');
	$border3[1]=trim($border3[1]);
	$border4[1]=trim($border4[1]);
	$border3[2]=trim($border3[2]);
	$border4[2]=trim($border4[2]);
	
       

switch ($menustyle) 
		{
 		case "popoutmenu":
       HTML_swmenupro::popoutMenuConfig( $row, $option , $id, $list, $menutype, $moduleID, $pageNav, $levellist, $pageID, $padding1, $padding2, $border1, $border2, $border3, $border4, $modulename);
		break;
		case "clickmenu":
       HTML_swmenupro::clickMenuConfig( $row, $option , $id, $list, $menutype, $moduleID, $pageNav, $levellist, $pageID, $padding1, $padding2, $border1, $border2, $border3, $border4, $modulename);
		break;
		case "treemenu":
       HTML_swmenupro::treeMenuConfig( $row, $option , $id, $list, $menutype, $moduleID, $pageNav, $levellist, $pageID, $padding1, $padding2, $border1, $border2, $border3, $border4, $modulename);
		break;
		case "gosumenu":
       HTML_swmenupro::gosuMenuConfig( $row, $option , $id, $list, $menutype, $moduleID, $pageNav, $levellist, $pageID, $padding1, $padding2, $border1, $border2, $border3, $border4, $modulename);
		break;
		case "jscookmenu":
       HTML_swmenupro::gosuMenuConfig( $row, $option , $id, $list, $menutype, $moduleID, $pageNav, $levellist, $pageID, $padding1, $padding2, $border1, $border2, $border3, $border4, $modulename);
		break;
		}

}


function saveconfig($id, $option){

global $database, $my, $mainframe;

$row = new swmenuproMenu( $database );
	
	if (!$row->bind( $_POST )) {
    	echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
      	exit();
  	}

	$database->setQuery( "SELECT * FROM #__swmenu_config WHERE id='".$row->id."'");
	$database->query();
	$database->loadObject($count);

		if($count >= 1) {
			$ret = $row->_db->updateObject( $row->_tbl, $row, $row->_tbl_key, $updateNulls );
		} else {
			$ret = $row->_db->insertObject( $row->_tbl, $row, $row->_tbl_key );
		}

	$moduleid = mosGetParam( $_REQUEST, 'moduleID', array(0) );
	$menutype = mosGetParam( $_REQUEST, 'menutype', array(0) );
	$menu = mosGetParam( $_REQUEST, 'menuid', array() );
	$rowid = mosGetParam( $_REQUEST, 'rowid', array() );
	$showname= mosGetParam( $_REQUEST, 'showname', array() );
	$imagealign= mosGetParam( $_REQUEST, 'imagealign', array() );
	$targetlevel= mosGetParam( $_REQUEST, 'targetlevel', array() );
	
	for($i=0;$i<count($menu);$i++){
	
	$image = mosGetParam( $_REQUEST, 'menuimage1'.$i.'hidden', array(0) );
	$imageover = mosGetParam( $_REQUEST, 'menuimage2'.$i.'hidden', array(0) );
	
	
	//if (($image || $imageover || ($showname[$i] !='1') || ($targetlevel[$i] !='1')) AND ($rowid[$i] != 'null')){ 

	if ($rowid[$i] != 'null'){ 
			if (($image == "modules/mod_swmenupro/images/no_image.gif")||($image == "modules/mod_swmenupro/images")){$image = null;}
			if (($imageover == "modules/mod_swmenupro/images/no_image.gif")||($imageover == "modules/mod_swmenupro/images")){$imageover = null;}
			
			
			$database->setQuery( "UPDATE #__swmenu_extended SET image ='".$image."', image_over='".$imageover."', show_name='".$showname[$i]."', image_align='".$imagealign[$i]."', target_level='".$targetlevel[$i]."' WHERE menu_id='".$menu[$i]."' AND moduleID='".$moduleid."'");
			$database->query();
				
		
		
		} elseif(($image || $imageover || ($showname[$i] !='1') || ($targetlevel[$i] !='1')) AND ($rowid[$i] == 'null')){ 
			if (($image == "modules/mod_swmenupro/images/no_image.gif")||($image == "modules/mod_swmenupro/images")){$image = null;}
			if (($imageover == "modules/mod_swmenupro/images/no_image.gif")||($imageover == "modules/mod_swmenupro/images")){$imageover = null;}
			
			if ($image || $imageover || ($showname[$i] !='1') || ($targetlevel[$i] !='1')){
			
			$database->setQuery( "INSERT INTO #__swmenu_extended VALUES ('','".$menu[$i]."','".$image."','".$imageover."','".$moduleid."','".$showname[$i]."','".$imagealign[$i]."','".$targetlevel[$i]."')");
			$database->query();
			
			
			}
		
		}
	}       
    mosRedirect( "index2.php?option=$option" );
}

?>
