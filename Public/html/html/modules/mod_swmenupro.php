<?
/**
* swmenupro v1.6
* http://swonline.biz
* Copyright 2004 Sean White
* DHTML Menu Component for Mambo Open Source
* Mambo Open Source is Free Software
* Released under GNU/GPL License: http://www.gnu.org/copyleft/gpl.html
**/

//error_reporting (E_ERROR | E_WARNING | E_PARSE | E_NOTICE); 
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require_once("modules/mod_swmenupro/styles.php");
require_once("modules/mod_swmenupro/functions.php");



global $database, $my;
global $mosConfig_shownoauth, $mosConfig_dbprefix;


$menu = @$params->menutype ? strval( $params->menutype ) : $params->get( 'menutype' );
$menu = @$menu ? $menu: "mainmenu";
$id = @$params->moduleID ? strval( $params->moduleID ) : $params->get( 'moduleID' );
$id = @$id ? $id : 0;
$menustyle = @$params->menustyle ? strval( $params->menustyle ) : $params->get( 'menustyle' );
$menustyle = @$menustyle ? $menustyle : "popoutmenu";
//$parent_level = @$params->get('parent') ? intval( $params->get('parent') ) :  0;
//$levels = @$params->get('levels') ? intval( $params->get('levels') ) :  25;

$result = mysql_query("SELECT * FROM ".$mosConfig_dbprefix."swmenu_config WHERE id = ".$id);
$swmenupro = $result ? mysql_fetch_assoc($result) : 0 ;
/*
unset($browser);
  $browser = 'ns'; // Default browser
  if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera')) $browser = 'op';   
  elseif (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 6')) $browser = 'ie6'; 
  elseif (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie')) $browser = 'ie'; 
  elseif (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mozilla')) $browser = 'ns'; 
  if (stristr($_SERVER['HTTP_USER_AGENT'], 'Gecko/200') && (!(stristr($HTTP_USER_AGENT, 'compatible')))) $browser = 'ns6';

if (($browser=='ns') || ($browser=="ns6")){
	
	$padding1 = explode("px", $swmenupro['main_padding']);
	$padding2 = explode("px", $swmenupro['sub_padding']);
	for($i=0;$i<4; $i++){
	$padding1[$i]=trim($padding1[$i]);
	$padding2[$i]=trim($padding2[$i]);
	}
	$border1 = explode(" ", $swmenupro['main_border']);
	$border2 = explode(" ", $swmenupro['sub_border']);
	
	$border1[0]=rtrim(trim($border1[0]),'px');
	$border2[0]=rtrim(trim($border2[0]),'px');
	$border1[1]=trim($border1[1]);
	$border2[1]=trim($border2[1]);
	$border1[2]=trim($border1[2]);
	$border2[2]=trim($border2[2]);

	$border3 = explode(" ", $swmenupro['main_border_over']);
	$border4 = explode(" ", $swmenupro['sub_border_over']);
	
	$border3[0]=rtrim(trim($border3[0]),'px');
	$border4[0]=rtrim(trim($border4[0]),'px');
	$border3[1]=trim($border3[1]);
	$border4[1]=trim($border4[1]);
	$border3[2]=trim($border3[2]);
	$border4[2]=trim($border4[2]);

if (($menustyle == "gosumenu") || ($menustyle == "clickmenu")){
$swmenupro['main_width'] = ($swmenupro['main_width'] - ($padding1[1]+$padding1[3]));
$swmenupro['main_height'] = ($swmenupro['main_height'] - ($padding1[0]+$padding1[2]));
$swmenupro['sub_width'] = ($swmenupro['sub_width'] - ($padding2[1]+$padding2[3]));
$swmenupro['sub_height'] = ($swmenupro['sub_height'] - ($padding2[0]+$padding2[2]));
}else{
$swmenupro['main_width'] = ($swmenupro['main_width'] - ($border1[0]+$border2[0]));
$swmenupro['main_height'] = ($swmenupro['main_height'] - ($border1[0]+$border2[0]));
$swmenupro['sub_width'] = ($swmenupro['sub_width'] - ($border3[0]+$border4[0]));
$swmenupro['sub_height'] = ($swmenupro['sub_height'] - ($border3[0]+$border4[0]));
}
}

*/
if($menu && $id && $menustyle){




		/* If a user has signed in, get their user type */
		$intUserType = 0;
		if($my->gid){
			switch ($my->usertype)
			{
				case 'Super Administrator':
				$intUserType = 0;
				break;
				case 'Administrator':
				$intUserType = 1;
				break;
				case 'Editor':
				$intUserType = 2;
				break;
				case 'Registered':
				$intUserType = 3;
				break;
				case 'Author':
				$intUserType = 4;
				break;
				case 'Publisher':
				$intUserType = 5;
				break;
				case 'Manager':
				$intUserType = 6;
				break;
			}
		}
		else
		{
			/* user isn't logged in so make their usertype 0 */
			$intUserType = 0;
		}

		if ($mosConfig_shownoauth) {
			$sql = "SELECT ".$mosConfig_dbprefix."menu.* , ".$mosConfig_dbprefix."swmenu_extended.* FROM ".$mosConfig_dbprefix."menu LEFT JOIN ".$mosConfig_dbprefix."swmenu_extended ON ".$mosConfig_dbprefix."menu.id = ".$mosConfig_dbprefix."swmenu_extended.menu_id AND (".$mosConfig_dbprefix."swmenu_extended.moduleID = '".$id."' OR ".$mosConfig_dbprefix."swmenu_extended.moduleID IS NULL) WHERE ".$mosConfig_dbprefix."menu.menutype = '".$menu."' AND published = '1' ORDER BY parent, ordering;";
		} else {
			$sql = "SELECT ".$mosConfig_dbprefix."menu.* , ".$mosConfig_dbprefix."swmenu_extended.* FROM ".$mosConfig_dbprefix."menu LEFT JOIN ".$mosConfig_dbprefix."swmenu_extended ON ".$mosConfig_dbprefix."menu.id = ".$mosConfig_dbprefix."swmenu_extended.menu_id AND (".$mosConfig_dbprefix."swmenu_extended.moduleID = '".$id."' OR ".$mosConfig_dbprefix."swmenu_extended.moduleID IS NULL) WHERE ".$mosConfig_dbprefix."menu.menutype = '".$menu."' AND published = '1' AND access <= '$my->gid' ORDER BY parent, ordering;";
		}

	$database->setQuery( $sql	);
	$result = $database->loadObjectList();
   
  foreach ($result as $result2) { 

	  global $mosConfig_lang, $mosConfig_mbf_content;
	if ($mosConfig_mbf_content) {
		$result2 = MambelFish::translate( $result2, 'menu', $mosConfig_lang);
	}
	
	switch ($result2->type) {
		case 'separator';
		break;

		case 'url':
		if (eregi( "index.php\?", $result2->link )) {
			if (!eregi( "Itemid=", $result2->link )) {
				$result2->link .= "&Itemid=$result2->id";
			}
		}
		break;
		
		default:
		$result2->link .= "&Itemid=$result2->id";
		break;
	}
	
	$result2->link = str_replace( '&', '&amp;', $result2->link );
	
	if (strcasecmp(substr($result2->link,0,4),"http")) {
		$result2->link = sefRelToAbs($result2->link);
	}
  
	$swmenupro_array[] =array("TITLE" => $result2->name, "URL" =>  $result2->link , "ID" => $result2->id  , "PARENT" => $result2->parent ,  "ORDER" => $result2->ordering, "IMAGE" => $result2->image, "IMAGEOVER" => $result2->image_over, "SHOWNAME" => $result2->show_name, "IMAGEALIGN" => $result2->image_align, "TARGETLEVEL" => $result2->target_level, "TARGET" => $result2->browserNav );

   } 
        

$ordered = chain('ID', 'PARENT', 'ORDER', $swmenupro_array);

if ($menustyle == "clickmenu"){doClickMenu($ordered, $swmenupro);}
if ($menustyle == "treemenu"){doTreeMenu($ordered, $swmenupro);}
if ($menustyle == "popoutmenu"){doPopoutMenu($ordered, $swmenupro);}
if ($menustyle == "gosumenu"){doGosuMenu($ordered, $swmenupro);}
if ($menustyle == "tabmenu"){doTabMenu($ordered, $swmenupro);}
if ($menustyle == "flatmenu"){doFlatMenu($ordered, $swmenupro);}


}
?>
 
    
 