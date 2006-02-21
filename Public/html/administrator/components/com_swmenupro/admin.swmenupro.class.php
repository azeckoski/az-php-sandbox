<?
/**
* swmenupro v1.0
* http://swonline.biz
* Copyright 2004 Sean White
* DHTML Menu Component for Mambo Open Source
* Mambo Open Source is Free Software
* Released under GNU/GPL License: http://www.gnu.org/copyleft/gpl.html
**/

class swmenuproMenu extends mosDBTable 
{
var $id = null;
var $main_top= 0;
var $main_left= 0;
var $main_height= 25;
var $main_width= 120;
var $sub_width= 100;
var $main_back= "#FFFFFF";
var $main_over= "#33CCFF";
var $sub_back= "#FFCC99";
var $sub_over= "#FF6600";
var $sub_border= "0px solid #FFFFFF";
var $main_font_color= "#FF9933";
var $main_font_size= 12;
var $sub_font_color= "#000000";
var $sub_font_size= 12;
var $main_border= "0px solid #FFFFFF";
var $sub_border_over= "1px dashed #11B8F4";
var $main_font_color_over= "#FFFFFF";
var $main_border_over= "1px dashed #FFC819";
var $sub_align= "left";
var $main_align= "left";
var $sub_height= 20;
var $sub_font_color_over= "#FFFFFF";
var $position= "relative";
var $orientation= "vertical";
var $font_family= "Arial";
var $sub_font_family= "Arial";
var $font_weight= "normal";
var $font_weight_over= "bold";
var $level1_sub_top= 2;
var $level1_sub_left= 115;
var $level2_sub_top= 2;
var $level2_sub_left= 95;
var $main_back_image= null;
var $main_back_image_over = null;
var $sub_back_image= null;
var $sub_back_image_over= null;
var $specialA= 85;
var $specialB= 50;
var $sub_padding= "0px 0px 0px 0px";
var $main_padding= "0px 0px 0px 0px";


function swmenuproMenu( &$db ) 
        {
                $this->mosDBTable( '#__swmenu_config', 'id', $db );
        }

 function treemenu() 
        {
           
           $this->set('main_back_image', "modules/mod_swmenupro/images/tree_icons/folder.gif");
		   $this->set('main_back_image_over', "modules/mod_swmenupro/images/tree_icons/folder-open.gif");
		   $this->set('sub_back_image', "modules/mod_swmenupro/images/tree_icons/doc.gif");
		   $this->set('sub_back_image_over', "modules/mod_swmenupro/images/tree_icons/doc.gif");
		   $this->set('main_back', "#FFFFFF");
		   $this->set('main_over',  "#FFFFFF");
		   $this->set('main_width', 150);
		   $this->set('level2_sub_left', 20);
		   $this->set('level1_sub_left', 20);
		   $this->set('main_padding', "2px 0px 2px 0px");
		   $this->set('sub_padding', "2px 0px 2px 0px");
		   $this->set('main_font_color_over', "#C01E00");
		    $this->set('main_font_color', "#E17200");
           return true;
        }


function clickmenu() 
	{
		   
		   $this->set('main_width', 150);
		   $this->set('sub_width', 150);
		   $this->set('level1_sub_left', 0);
		   $this->set('level1_sub_top', 0);
		   
           return true;
        }

function gosumenu() 
	{
		   
		   $this->set('main_width', 0);
		   $this->set('sub_width', 0);
		    $this->set('main_height', 0);
		   $this->set('sub_height', 0);
		   $this->set('level1_sub_left', 0);
		   $this->set('level1_sub_top', 0);
		    $this->set('level2_sub_left', 0);
		   $this->set('level2_sub_top', 0);
		    $this->set('main_padding', "5px 5px 5px 5px");
		   $this->set('sub_padding', "5px 5px 5px 5px");
		    $this->set('position', "left");
		   
           return true;
        }



}






class swmenuproImages extends mosDBTable 
{
var $ext_id = null;
var $menu_id = 1;
var $image = null;
var $image_over = null;
var $moduleID = 1;
var $show_name = 1;


function swmenuproImages( &$db ) 
        {
                $this->mosDBTable( '#__swmenu_extended', 'ext_id', $db );
        }

}
?>