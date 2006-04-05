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

class HTML_swmenupro
{
	function popoutMenuConfig( $rows, $option , $id, $list, $menutype, $moduleID, $pageNav, $levellist, $pageID, $mainpadding, $subpadding, $mainborder, $subborder, $mainborderover, $subborderover, $modulename)
	{
?>
<script type="text/javascript" src="components/com_swmenupro/ImageManager/assets/dialog.js"></script>
<script type="text/javascript" src="components/com_swmenupro/ImageManager/IMEStandalone.js"></script>
<script type="text/javascript" src="components/com_swmenupro/js/swmenupro.js"></script>
<script type="text/javascript" src="components/com_swmenupro/js/preview.js"></script>
<script language="javascript" src="js/dhtml.js"></script>
<script language="javascript">

	
		function submitbutton(pressbutton) {

		doMainBorder();
		doSubBorder();

		submitform( pressbutton );
		}

function activatePreview(){
var counter = <?php echo count($list); ?>;
doMainBorder();
doSubBorder();

for(i=0;i<counter;i++)
			{
			doPreview(i);
			}
}

</script>
 <table cellpadding="4" cellspacing="4" border="0" width="750"> 
  <tr> 
     <td><a href="http://www.swonline.biz"> <img src="components/com_swmenupro/images/swmenupro_logo_small.gif" align="absmiddle" border="0"/> </a></td> 
     <td><span class="sectionname"><?php echo $modulename;?> Tigra Pop-Out Menu Configuration</span> </td> 
   </tr> 
</table> 
<table width="750" style="width='750px';" class="adminForm" align="center"> 
  <tr><td valign="top"> 
    <form action="index2.php" method="POST" name="adminForm"> <table width="100%"> 
      <tr><td align="center"> 
        <table cellpadding="3" cellspacing="0" border="0" width="750"> 
          <tr> 
            <td id="tab1" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Size, Position & Offsets</td> 
            <td id="tab2" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Colors & Backgrounds</td> 
            <td id="tab3" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Fonts & Padding</td> 
            <td id="tab4" class="offtab" onclick="activatePreview(); dhtml.cycleTab(this.id)">Custom Images & Behaviours</td> 
            <td id="tab5" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Borders & Effects</td> 
            <td id="tab6" class="offtab" onclick="dhtml.cycleTab(this.id)">About swmenupro</td> 
          </tr> 
        </table> 
        <div id="page1" class="pagetext"> 
          <table width="750px"> 
            <tr> 
              <td valign="top" align="center"> <table width="360px" height = "200" class="adminForm"> 
                  <tr> 
                    <td colspan="2" class="tabheading"> <div align="center">Menu Position and Orientation</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Top Menu - Position:</td> 
                    <td width="120" class="adminlist"> <div align="left"> 
                        <select name="position" id="position" style = "width:'120px'"> 
                          <option <?php if ($rows->position == 'absolute') {echo 'selected';} ?> value = "absolute">Absolute</option> 
                          <option <?php if ($rows->position == 'relative') {echo 'selected';} ?> value = "relative">Relative</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr> 
                    <td>Top Menu - Orientation:</td> 
                    <td width="120" class="adminlist"> <div align="left"> 
                        <select name="orientation" id="orientation" style = "width:'120px'"> 
                          <option <?php if ($rows->orientation == 'horizontal') {echo 'selected';} ?> value = "horizontal">Horizontal</option> 
                          <option <?php if ($rows->orientation == 'vertical') {echo 'selected';} ?> value = "vertical">Vertical</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Menu Item Sizes</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Top Menu Item Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu Elements Width','main_width',5,800,<?php echo $rows->main_width;?>);" size="8" id = "main_width" name = "main_width" value = "<?php echo $rows->main_width;?>" > 
                        px</div></td> 
                  </tr> 
                  <tr > 
                    <td>Top Menu Item Height:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "main_height"  onChange="checkNumberSyntax('Top Menu Elements Height','main_height',5,800,<?php echo $rows->main_height;?>);" name = "main_height" type="text" value = "<?php echo $rows->main_height;?>" size="8"> 
                        px</div></td> 
                  <tr class="menubackgr"> 
                    <td>Sub Menu Item Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text"  onChange="checkNumberSyntax('Sub Menu Elements Width','sub_width',5,800,<?php echo $rows->sub_width;?>);" size="8" id = "sub_width" name = "sub_width" value = "<?php echo $rows->sub_width;?>"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td>Sub Menu Item Height:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "sub_height"  onChange="checkNumberSyntax('Sub Menu Elements Height','sub_height',5,800,<?php echo $rows->sub_height;?>);" name = "sub_height" type="text" value = "<?php echo $rows->sub_height;?>" size="8"> 
                        px</div></td> 
                  </tr> 
                </table></td> 
              <td valign="top"> <table width = "360px"  height = "200" class="adminForm" > 
                  <tr> 
                    <td colspan="2" class="tabheading"> <div align="center">Top Menu Offsets</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Top Menu - Top Offset:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu - Top Offset','main_top',-1000,1000,<?php echo $rows->main_top;?>);"  size="8" name = "main_top" value = "<?php echo $rows->main_top;?>"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td>Top Menu - Left Offset:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu - Left Offset','main_left',-1000,1000,<?php echo $rows->main_left;?>);"  size="8"  name = "main_left" value = "<?php echo $rows->main_left;?>"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"> <div align="center">Sub Menu Offsets</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Level 1 Sub Menu - Top Offset:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu - Top Offset','level1_sub_top',-1000,1000,<?php echo $rows->level1_sub_top;?>);"  size="8" name = "level1_sub_top" value = "<?php echo $rows->level1_sub_top;?>"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td>Level 1 Sub Menu - Left Offset:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu - Left Offset','level1_sub_left',-1000,1000,<?php echo $rows->level1_sub_left;?>);"  size="8"  name = "level1_sub_left" value = "<?php echo $rows->level1_sub_left;?>"> 
                        px</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Level 2 Sub Menu - Top Offset:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu - Top Offset','level2_sub_top',-1000,1000,<?php echo $rows->level2_sub_top;?>);"  size="8" name = "level2_sub_top" value = "<?php echo $rows->level2_sub_top;?>"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td>Level 2 Sub Menu - Left Offset:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu - Left Offset','level2_sub_left',-1000,1000,<?php echo $rows->level2_sub_left;?>);"  size="8"  name = "level2_sub_left" value = "<?php echo $rows->level2_sub_left;?>"> 
                        px</div></td> 
                  </tr> 
                </table></td> 
            </tr> 
          </table> 
          <TABLE width="100%"> 
            <TR> 
              <TD align="center"> <img src = "components/com_swmenupro/images/menu_offsets.gif" width="350" height = "300" border = "0" hspace="0" vspace="0"> </TD> 
              <TD align="center"> <img src = "components/com_swmenupro/images/menu_dimensions.gif" width="350" height = "300" border = "0" hspace="0" vspace="0"> </TD> 
            </TR> 
          </TABLE> 
        </div> 
        <div id="page2" class="pagetext"> 
          <table width="750px"> 
            <tr><td valign="top" align="center"> 
              <table width="360px"  height = "250" class="adminForm"> 
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Background Images</div></td> 
                </tr> 
                <tr class="menubackgr" > 
                  <td>Top Menu Background:</td> 
                  <td colspan="2"><table id="main_back_image_box" style="border: 1px solid #000000; width:'100px'; height:'15px'" background="../<?php echo $rows->main_back_image;?>" align="left"> 
                      <tr> 
                        <td width="20" height="20">&nbsp</td> 
                      </tr> 
                    </table> 
                    <input type="button" name = "getimage" value = "GET" onclick="BackgroundSelector.select('main_back_image');"> 
                    <input type="hidden" id="main_back_image" name = "main_back_image" value = "<?php echo $rows->main_back_image;?>"> </td> 
                </tr> 
                <tr> 
                  <td>Top Menu Over Background:</td> 
                  <td colspan="2"><table id="main_back_image_over_box" style="border: 1px solid #000000; width:'100px'; height:'15px'" background="../<?php echo $rows->main_back_image_over;?>" align="left"> 
                      <tr> 
                        <td width="20" height="20">&nbsp</td> 
                      </tr> 
                    </table> 
                    <input type="button" name = "getimage" value = "GET" onclick="BackgroundSelector.select('main_back_image_over');"> 
                    <input type="hidden" id="main_back_image_over" name = "main_back_image_over" value = "<?php echo $rows->main_back_image_over;?>"> </td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Sub Menu Background:</td> 
                  <td colspan="2"><table id="sub_back_image_box" style="border: 1px solid #000000; width:'100px'; height:'15px'" background="../<?php echo $rows->sub_back_image;?>" align="left"> 
                      <tr> 
                        <td width="20" height="20">&nbsp</td> 
                      </tr> 
                    </table> 
                    <input type="button" name = "getimage" value = "GET" onclick="BackgroundSelector.select('sub_back_image');"> 
                    <input type="hidden" id="sub_back_image" name = "sub_back_image" value = "<?php echo $rows->sub_back_image;?>"> </td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Over Background:</td> 
                  <td colspan="2"><table id="sub_back_image_over_box" style="border: 1px solid #000000; width:'100px'; height:'15px'" background="../<?php echo $rows->sub_back_image_over;?>" align="left"> 
                      <tr> 
                        <td width="20" height="20">&nbsp</td> 
                      </tr> 
                    </table> 
                    <input type="button" name = "getimage" value = "GET" onclick="BackgroundSelector.select('sub_back_image_over');"> 
                    <input type="hidden" id="sub_back_image_over" name = "sub_back_image_over" value = "<?php echo $rows->sub_back_image_over;?>"> </td> 
                </tr> 
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Background Colors</div></td> 
                </tr> 
                <tr class="menubackgr" > 
                  <td>Top Menu Color:</td> 
                  <td > 
                  <table id="main_back_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_back;?>' > 
                    <tr> 
                      <td width="20" height="20">&nbsp</td>  
                    </tr> 
                    
                  </table> 
                </td> 
                 <td width="120" class="adminlist" > <div align="right"> 
                      <input type="text" onChange="checkColorSyntax('Main Menu Color','main_back','<?php echo $rows->main_back;?>');" size="8"  id="main_back" name = "main_back" value = "<?php echo $rows->main_back;?>"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_back');" > <img src="components/com_swmenupro/images/sel.gif">get</a> </div></td> 
                </tr> <tr> 
                  <td>Top Menu Over Color:</td> 
                  <td > 
                   <table id="main_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_over;?>'> 
                     <tr> 
                       <td width="20" height="20">&nbsp</td>  
                     </tr> 
                    
                   </table> 
                </td> 
                 <td width="120" class="adminlist"> <div align="right"> 
                      <input type="text" onChange="checkColorSyntax('Top Menu Over Color','main_over','<?php echo $rows->main_over;?>');" size="8"  id = "main_over" name = "main_over" value = "<?php echo $rows->main_over;?>"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_over');"><img src="components/com_swmenupro/images/sel.gif">get</a> </div></td> 
                </tr> <tr class="menubackgr"> 
                  <td>Sub Menu Color:</td> 
                  <td > 
                   <table id="sub_back_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->sub_back;?>'> 
                     <tr> 
                      <td width="20" height="20">&nbsp</td>  
                     </tr> 
                     
                   </table> 
                </td> 
                 <td width="120" class="adminlist"> <div align="right"> 
                      <input type="text" onChange="checkColorSyntax('Sub Menu Color','sub_back','<?php echo $rows->sub_back;?>');" size="8"  id = "sub_back" name = "sub_back" value = "<?php echo $rows->sub_back;?>"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_back');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> <tr> 
                  <td>Sub Menu Over Color:</td> 
                  <td > 
                   <table id="sub_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->sub_over;?>'> 
                     <tr> 
                       <td width="20" height="20">&nbsp</td>  
                     </tr> 
                     
                   </table> 
                  </td> 
                   <td width="120" class="adminlist"> <div align="right"> 
                       <input type="text" onChange="checkColorSyntax('Sub Menu Over Color','sub_over','<?php echo $rows->sub_over; ?>');" size="8" id = "sub_over" name = "sub_over" value = "<?php echo $rows->sub_over;?>"> 
                       <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
              </table> 
              </td> 
              <td valign="top"> 
              <table width = "360px"  height = "250" class="adminForm"> 
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Font Colors </div> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Top Menu Font Color:</td> 
                  <td > 
                  <table id="main_font_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_font_color;?>'> 
                    <tr> 
                     <td width="20" height="20">&nbsp</td>  
                    </tr> 
                   
                  </table> 
                </td> 
                 <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "main_font_color" onChange="checkColorSyntax('Top Menu Font Color','main_font_color','<?php echo $rows->main_font_color;?>');" type="text" id="main_font_color" value = "<?php echo $rows->main_font_color;?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_font_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> <tr> 
                  <td>Top Menu Over Font Color:</td> 
                  <td > 
                   <table id="main_font_color_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_font_color_over;?>'> 
                     <tr> 
                       <td width="20" height="20">&nbsp</td>  
                     </tr> 
                     
                   </table> 
                  </td> 
                   <td width="120" class="adminlist"> <div align="right"> 
                       <input name = "main_font_color_over" onChange="checkColorSyntax('Top Menu Over Font Color','main_font_color_over','<?php echo $rows->main_font_color_over;?>');" type="text" id="main_font_color_over" value = "<?php echo $rows->main_font_color_over;?>" size="8"> 
                       <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_font_color_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Sub Menu Font Color:</td> 
                  <td > 
                  <table id="sub_font_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->sub_font_color;?>'> 
                    <tr> 
                      <td width="20" height="20">&nbsp</td>  
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "sub_font_color" onChange="checkColorSyntax('Sub Menu Font Color','sub_font_color','<?php echo $rows->sub_font_color;?>');" type="text" id="sub_font_color" value = "<?php echo $rows->sub_font_color;?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_font_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Over Font Color:</td> 
                  <td > 
                  <table id="sub_font_color_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->sub_font_color_over;?>'> 
                    <tr> 
                      <td width="20" height="20">&nbsp</td>  
                    </tr> 
                    
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input name = "sub_font_color_over" onChange="checkColorSyntax('Sub Menu Over Font Color','sub_font_color_over','<?php echo $rows->sub_font_color_over;?>');" type="text" id="sub_font_color_over" value = "<?php echo $rows->sub_font_color_over;?>"  size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_font_color_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Border Colors</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Top Menu Border Color:</td> 
                  <td > 
                  <table id="main_border_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $mainborder[2];?>'> 
                    <tr> 
                       <td width="20" height="20">&nbsp</td>   
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "main_border_color" onChange="checkColorSyntax('Top Menu Border Color','main_border_color','<?php echo $mainborder[2];?>'); doMainBorder();" type="text" id="main_border_color" value = "<?php echo $mainborder[2];?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_border_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr > 
                  <td>Top Menu Over Border Color:</td> 
                  <td > 
                  <table id="main_border_color_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $mainborderover[2];?>'> 
                    <tr> 
                      <td width="20" height="20">&nbsp</td>  
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "main_border_color_over" onChange="checkColorSyntax('Top Menu Over Border Color','main_border_color_over','<?php echo $mainborderover[2];?>'); doMainBorder();" type="text" id="main_border_color_over" value = "<?php echo $mainborderover[2];?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_border_color_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Sub Menu Border Color:</td> 
                  <td > 
                  <table id="sub_border_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $subborder[2];?>'> 
                    <tr> 
                       <td width="20" height="20">&nbsp</td>   
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "sub_border_color" type="text" onChange="checkColorSyntax('Sub Menu Border Color','sub_border_color','<?php echo $subborder[2];?>'); doSubBorder();" id="sub_border_color" value = "<?php echo $subborder[2];?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_border_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Over Border Color:</td> 
                  <td > 
                  <table id="sub_border_color_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $subborderover[2];?>'> 
                    <tr> 
                       <td width="20" height="20">&nbsp</td>  
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "sub_border_color_over" type="text" onChange="checkColorSyntax('Sub Menu Border Over Color','sub_border_color_over','<?php echo $subborderover[2];?>'); doSubBorder();" id="sub_border_color_over" value = "<?php echo $subborderover[2];?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_border_color_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
              </table> 
              </td> 
            </tr> 
          </table> 
          <TABLE width="100%" valign="top"> 
            <TR> 
              <TD align="center"> <table width = "360px" height = "320px"  valign="top"> 
                  <tr> 
                    <td align="center" valign="top"><img src="components/com_swmenupro/images/color_wheel_top.gif" width="350" height="44"></td> 
                  </tr> 
                  <tr> 
                    <td> <table width = "320px" align="center"> 
                        <tr> 
                          <td id="CPCP_Wheel" ><img src="components/com_swmenupro/images/colorwheel.jpg" width="256" height="256"  onMouseMove="xyOff(event);" onClick="wrtVal();" border="1"></td> 
                          <td>&nbsp;</td> 
                          <td> <table border="0"> 
                              <tr> 
                                <td valign="TOP">Present Color:</td> 
                              </tr> 
                              <tr> 
                                <td id="CPCP_ColorCurrent" height="70"></td> 
                              </tr> 
                              <tr> 
                                <td id="CPCP_ColorSelected">&nbsp;</td> 
                              </tr> 
                              <tr> 
                                <td><br> 
                                  Selected Color:  
                              </tr> 
                              <tr> 
                                <td bgcolor="#FFFFFF" id="CPCP_Input" height="70"  >&nbsp;</td> 
                              <tr> 
                                <td><input name="TEXT" type="TEXT" id="CPCP_Input_RGB" value="#FFFFFF" size="8"></td> 
                              </tr> 
                            </table></td> 
                        </tr> 
                      </table></td> 
                  </tr> 
                </table></TD><td valign="top" align="center"> 
				<table><tr>
              <TD align="center" valign="top"> <img src = "components/com_swmenupro/images/additional_info_top.gif" width="350" height = "25" border = "0" hspace="0" vspace="0"> </TD> </tr><tr>
            
			<td cellpadding="5"><p>All colors should be a valid 6 digit hexadecimal color code with a preceding #. Use the provided color wheel or type values in manually.</p>
			<p>It is possible to set any color value to <B>transparent</B> by simply clearing the appropriate box.</p>
			<p>Background images are tiled across a menu item acording to size and height and will overlay the corresponding color value for the menu item.</p>
			<p>To make a <B>web button</B>, make your menu items size and width the same size and width as the backgound images being used for the normal and mouse over states.</p>
			
			</td>
			
			</tr></table>
			</td></TR> 
          </TABLE> 
        </div> 
        <div id="page3" class="pagetext"> 
          <table width="750px"> 
            <tr> 
              <td valign="top" align="center"> <table style="width:'360px'" width = "360px"  height = "210" class="adminForm"> 
                  <tr> 
                    <td colspan="2" class="tabheading"> <div align="center">Font Family</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td width="100">Top Menu:</td> 
                    <td  width="250" class="adminlist"> <div align="right"> 
                        <select name="font_family" id="font_family" style = "width:'250px'"> 
                          <option <?php if ($rows->font_family == 'Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Arial, Helvetica, sans-serif">Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->font_family == '\'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "'Times New Roman', Times, serif">'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->font_family == 'Georgia, \'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "Georgia, 'Times New Roman', Times, serif">Georgia,'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->font_family == 'Verdana, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Verdana, Arial, Helvetica, sans-serif">Verdana,Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->font_family == 'Geneva, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Geneva, Arial, Helvetica, sans-serif">Geneva,Arial,Helvetica,sans-serif</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr > 
                    <td>Sub Menu:</td> 
                    <td width="250"  class="adminlist"> <div align="right"> 
                        <select name="sub_font_family" id="sub_font_family"  style = "width:'250px'"> 
                          <option <?php if ($rows->sub_font_family == 'Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Arial, Helvetica, sans-serif">Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->sub_font_family == '\'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "'Times New Roman', Times, serif">'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->sub_font_family == 'Georgia, \'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "Georgia, 'Times New Roman', Times, serif">Georgia,'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->sub_font_family == 'Verdana, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Verdana, Arial, Helvetica, sans-serif">Verdana,Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->sub_font_family == 'Geneva, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Geneva, Arial, Helvetica, sans-serif">Geneva,Arial,Helvetica,sans-serif</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Top Menu Padding</div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="adminlist" align="center"> <TABLE> 
                        <TR class="menubackgr"> 
                          <TD width="75" align="center">Top</TD> 
                          <TD width="75" align="center">Right</TD> 
                          <TD width="75" align="center">Bottom</TD> 
                          <TD width="75" align="center">Left</TD> 
                        </TR> 
                        <TR> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Top Padding','main_pad_top',0,100,0); doMainPadding();" size="3" id = "main_pad_top" name = "main_pad_top" value = "<?php echo $mainpadding[0]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Right Padding','main_pad_right',0,100,0);doMainPadding();" size="3" id = "main_pad_right" name = "main_pad_right" value = "<?php echo $mainpadding[1]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Bottom Padding','main_pad_bottom',0,100,0);doMainPadding();" size="3" id = "main_pad_bottom" name = "main_pad_bottom" value = "<?php echo $mainpadding[2]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Left Padding','main_pad_left',0,100,0);doMainPadding();" size="3" id = "main_pad_left" name = "main_pad_left" value = "<?php echo $mainpadding[3]; ?>" maxlength="2"> 
                            px</TD> 
                        </TR> 
                      </TABLE></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Sub Menu Padding</div></td> 
                  </tr> 
                  <tr > 
                    <td colspan="2" class="adminlist" align="center"> <TABLE> 
                        <TR class="menubackgr"> 
                          <TD width="75" align="center">Top</TD> 
                          <TD width="75" align="center">Right</TD> 
                          <TD width="75" align="center">Bottom</TD> 
                          <TD width="75" align="center">Left</TD> 
                        </TR> 
                        <TR> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Top Padding','sub_pad_top',0,100,0);doSubPadding();" size="3" id = "sub_pad_top" name = "sub_pad_top" value = "<?php echo $subpadding[0]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Right Padding','sub_pad_right',0,100,0);doSubPadding(); " size="3" id = "sub_pad_right" name = "sub_pad_right" value = "<?php echo $subpadding[1]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Bottom Padding','sub_pad_bottom',0,100,0);doSubPadding(); " size="3" id = "sub_pad_bottom" name = "sub_pad_bottom" value = "<?php echo $subpadding[2]; ?>" maxlength="2">
						   px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Left Padding','sub_pad_left',0,100,0);doSubPadding(); " size="3" id = "sub_pad_left" name = "sub_pad_left" value = "<?php echo $subpadding[3]; ?>" maxlength="2"> 
                            px</TD> 
                        </TR> 
                      </TABLE></td> 
                  </tr> 
                </table></td> 
              <td valign="top"> 
              <table width = "360px" style="width:'360px'" height = "210"class="adminForm"> 
                <tr> 
                  <td colspan="2" class="tabheading"> <div align="center">Font Size</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Top Menu Font Size:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <input id = "main_font_size" onChange="checkNumberSyntax('Top Menu Font Size:','main_font_size',3,100,<?php echo $rows->main_font_size;?>);" name = "main_font_size" type="text"  value = "<?php echo $rows->main_font_size;?>" size="8"> 
                      px</div></td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Font Size:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <input  id = "sub_font_size" onChange="checkNumberSyntax('Sub Menu Font Size','sub_font_size',3,100,<?php echo $rows->sub_font_size;?>);" name = "sub_font_size" type="text" value = "<?php echo $rows->sub_font_size;?>" size="8"> 
                      px</div></td> 
                </tr> 
                <tr> 
                  <td colspan="2" class="tabheading"> <div align="center">Font Alignment</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Top Menu Text Alignment:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="main_align" id="main_align" onChange="doPreview();" style = "width:'100px'"> 
                        <option <?php if ($rows->main_align == 'left') {echo 'selected';} ?> value = "left">left</option> 
                        <option <?php if ($rows->main_align == 'right') {echo 'selected';} ?> value = "right">right</option> 
                        <option <?php if ($rows->main_align == 'center') {echo 'selected';} ?> value = "center">center</option> 
                      </select> 
                    </div></td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Text Alignment:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="sub_align" id="sub_align" onChange="doPreview();" style = "width:'100px'" > 
                        <option <?php if ($rows->sub_align == 'left') {echo 'selected';} ?> value = "left">left</option> 
                        <option <?php if ($rows->sub_align == 'right') {echo 'selected';} ?> value = "right">right</option> 
                        <option <?php if ($rows->sub_align == 'center') {echo 'selected';} ?> value = "center">center</option> 
                      </select> 
                    </div></td> 
                </tr> 
                <tr> 
                  <td colspan="2" class="tabheading"> <div align="center">Font Weight</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Font Weight:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="font_weight" id="font_weight" onChange="doPreview();" style = "width:'100px'"> 
                        <option <?php if ($rows->font_weight == 'normal') {echo 'selected';} ?> value = "normal">normal</option> 
                        <option <?php if ($rows->font_weight == 'bold') {echo 'selected';} ?> value = "bold">bold</option> 
                        <option <?php if ($rows->font_weight == 'bolder') {echo 'selected';} ?> value = "bolder">bolder</option> 
                        <option <?php if ($rows->font_weight == 'lighter') {echo 'selected';} ?> value = "lighter">lighter</option> 
                      </select> 
                    </div></td> 
                </tr> 
                <tr> 
                  <td>Font Weight Over:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="font_weight_over" id="font_weight_over" onChange="doPreview();" style = "width:'100px'"> 
                        <option <?php if ($rows->font_weight_over == 'normal') {echo 'selected';} ?> value = "normal">normal</option> 
                        <option <?php if ($rows->font_weight_over == 'bold') {echo 'selected';} ?> value = "bold">bold</option> 
                        <option <?php if ($rows->font_weight_over == 'bolder') {echo 'selected';} ?> value = "bolder">bolder</option> 
                        <option <?php if ($rows->font_weight_over == 'lighter') {echo 'selected';} ?> value = "lighter">lighter</option> 
                      </select> 
                    </div></td> 
                </tr> 
                <tr> </tr> 
                </td> 
                 </table> 
              </td> 
            </tr> 
          </table> 
          <TABLE width="100%" align="center"> 
            <TR> 
              <TD align="center" valign="top"> <table width = "360" > 
                  <tr> 
                    <td align="center" valign="top"><img src="components/com_swmenupro/images/menu_fonts_top.gif" width="350" height="25"></td> 
                  </tr> 
				  <tr> 
                    <td align= "center">All browsers render fonts and sizes differently.  The list below shows how your browser has rendered the fonts and sizes described.<br> </td> 
                  </tr> 
                  <tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:10px; font-weight:'normal';font-family:''Times New Roman', Times, serif';">'Times New Roman', Times, serif normal at 10px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:10px; font-weight:'bold';font-family:'Verdana,Arial,Helvetica,sans-serif';">Verdana,Arial,Helvetica,sans-serif Bold at 10px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:12px; font-weight:'normal';font-family:'Arial,Helvetica,sans-serif';">Arial,Helvetica,sans-serif Normal at 12px</span> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center" valign="top"><span  style="color:#1166B0; font-size:12px; font-weight:'normal';font-family:'Georgia, 'Times New Roman', Times, serif';">Georgia, 'Times New Roman', Times, serif Normal at 12px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:12px; font-weight:'bold';font-family:Geneva,Arial,Helvetica,sans-serif';">'Geneva,Arial,Helvetica,sans-serif Bold at 12px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'normal';font-family:''Times New Roman', Times, serif';">'Times New Roman', Times, serif normal at 14px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'bold';font-family:'Verdana,Arial,Helvetica,sans-serif';">Verdana,Arial,Helvetica,sans-serif Bold at 14px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'bold';font-family:'Arial,Helvetica,sans-serif';">Arial,Helvetica,sans-serif Bold at 14px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'normal';font-family:'Geneva,Arial,Helvetica,sans-serif';">Geneva,Arial,Helvetica,sans-serif Normal at 14px</span><br> </td> 
                  </tr> 
                </table></TD> 
              <TD align="center"> <img src = "components/com_swmenupro/images/menu_padding.gif" width="350" height = "274" border = "0" hspace="0" vspace="0"> </TD> 
            </TR> 
          </TABLE> 
        </div> 
        <div id="page4" class="pagetext"> 
          <table width="750px"> 
            <tr><td valign="top"> 
              <table cellpadding="4" cellspacing="0" border="0" width="100%"> 
                <tr> 
                  <th width="80%">Auto Menu Item Configuration Utility</th> 
                  <th nowrap="nowrap" align="right">Max Levels</th> 
                  <th><?php echo $levellist;?></th> 
                  <th nowrap="nowrap">Display #</th> 
                  <th><?php $pageNav->writeLimitBox();?></th> 
                </tr> 
              </table> 
              <table> 
                <tr> 
                  <td><b>Step 1. Select Items</b></td> 
                  <td><b>Step 2. Select Attribute</b></td> 
                  <td align="center"><b>Image Preview</b></td> 
                  <td align="center"><b>Step 3. Press Apply</b></td> 
                </tr> 
                <tr> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="autoassign" id="autoassign" style = "width:'200px'"> 
                        <option  value = "">Please Select..</option> 
                        <option  value = "selected">Selected Menu Items</option> 
                        <option  value = "all">All Menu Items</option> 
                        <option  value = "main">Top Menu Items</option> 
                        <option  value = "sub">Sub Menu Items</option> 
                        <option  value = "parent">Parent Menu Items</option> 
                      </select> 
                    </div></td> 
                  <td width="100"> <select name="autoattrib" onchange="doImageChange();" id="autoattrib" style = "width:'200px'"> 
                      <option  value = "">Please Select..</option> 
                      <option  value = "image1">Image</option> 
                      <option  value = "image2">Image Over</option> 
                      <option  value = "showname">Show name</option> 
                      <option  value = "dontshowname">Do Not Show Name</option> 
                      <option  value = "imageleft">Image Align Left</option> 
                      <option  value = "imageright">Image Align Right</option> 
                      <option  value = "islink">Is A Link</option> 
                      <option  value = "isnotlink">Is Not a Link</option> 
                    </select> </td> 
                  <td width="150" align="center"> <img id="globalimage" name="globalimag0" src="components/com_swmenupro/images/blank.png" border = "0"></td> 
                  <input type ="hidden" id="globalimagehidden" name="globalimagehidden" value="" > 
                </td> 
                 <td nowrap="nowrap" align="center"><input type="button" onClick="doAutoAssign(<?php echo count($list); ?>)" value = "apply"></td> 
                </tr> </table> 
              <table cellpadding="4" cellspacing="0" border="0" width="100%"> 
                <tr> 
                  <th nowrap="nowrap" width="500px">Individual Menu Item Configuration</th> 
                  <th  >Preview</th> 
                  <th align="center"><a onMouseOver="this.style.cursor='pointer'" onClick="changePreviewColor(<?php echo count($list); ?>);"><img src="components/com_swmenupro/images/sel.gif">Change Background Color</a></th> 
                </tr> 
              </table> 
              <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminList"> 
                <?
    $k = 0;
    for ($i=0, $n=count($list); $i < $n; $i++) 
    {
    	$row2 = &$list[$i];
        if ($row2->show_name == null){$row2->show_name = 1;}
		if ($row2->target_level == null){$row2->target_level = 1;}
		if ($row2->image_align == null){$row2->image_align = 'left';}
		$img = $row2->show_name ? 'tick.png' : 'publish_x.png';
		$img2 = $row2->target_level ? 'tick.png' : 'publish_x.png';
		
       
	?> 
                <tr class="row<?PHP echo $k; ?>"> 
                  <td width="4%" nowrap="nowrap"><?php echo $i+$pageNav->limitstart+1;?></td> 
                  <td width="4%"  nowrap="nowrap"><input type="checkbox" id="cb<?PHP echo $i; ?>" name="checkid[]" value="<?PHP echo $i; ?>" onclick="isChecked(this.checked);" /></td> 
                  <td width="20%"  nowrap="nowrap"><b><?PHP echo $row2->treename; ?></b></td> 
                  <td width="20%"  nowrap="nowrap"><a  onmouseover="this.style.cursor='pointer'" onclick="swapValue('showname<?PHP echo $i."',".$i; ?>);">Show Name
                    <?PHP
			echo "<img id=\"showname".$i."image\" name=\"showname".$i."image\" src=\"images/".$img."\" border = \"0\"></a>";
			echo "<input type =\"hidden\" id=\"showname".$i."\" name=\"showname[]\" value=\"".$row2->show_name."\" >";
	?></td> 
                  <td width="20%" nowrap="nowrap"><a  onmouseover="this.style.cursor='pointer'" onclick="swapValue('targetlevel<?PHP echo $i."',".$i; ?>);">Is Link
                    <?PHP
			echo "<img id=\"targetlevel".$i."image\" name=\"targetlevel".$i."image\" src=\"images/".$img2."\" border = \"0\"></a>";
			echo "<input type =\"hidden\" id=\"targetlevel".$i."\" name=\"targetlevel[]\" value=\"".$row2->target_level."\" >";
	?></td> 
                  <td  id="preview_back<?PHP echo $i; ?>" rowspan="2" align="center" style="border-bottom:1px dashed #000000" > <?php 
		
	
	if($row2->parent == '0'){
		$previewimage->image = $row2->image ? $row2->image : 'administrator/components/com_swmenupro/images/blank.png';;

		?> 
                    <table id="maintablepreview<?PHP echo $i; ?>" cellpadding="0" cellspacing="0" border="0"> 
                      <tr> 
                        <td id="mainpreview<?php echo $i; ?>"   onmouseover="doMainPreviewOver(<?php echo $i; ?>)" onmouseout="doMainPreviewOut(<?php echo $i; ?>)" valign="top" align="left" ><img id = "imagepreview<?php echo $i; ?>" src="<?PHP echo "../".$previewimage; ?>" align="<?PHP echo $row2->image_align; ?>" cellpadding="0" cellspacing="0" border="0" > 
                          <div id="maindivpreview<?PHP echo $i; ?>" ><?PHP echo $row2->name; ?></div></td> 
                      </tr> 
                    </table> 
                    <?php  } 
		
		else { 
			$previewimage->image = $row2->image ? $row2->image : 'administrator/components/com_swmenupro/images/blank.png';
			
			?> 
                    <table id="subtablepreview<?PHP echo $i; ?>"  cellpadding="0" cellspacing="0" border="0"> 
                      <tr> 
                        <td id="subpreview<?php echo $i; ?>" onmouseover="doSubPreviewOver(<?php echo $i; ?>)" onmouseout="doSubPreviewOut(<?php echo $i; ?>)" valign="top" align="left" ><img id = "imagepreview<?php echo $i; ?>"  src="<?PHP echo "../".$previewimage; ?>" align="<?PHP echo $row2->image_align; ?>"  cellpadding="0" cellspacing="0" border="0"> 
                          <div id="maindivpreview<?PHP echo $i; ?>"><?PHP echo $row2->name; ?></div></td> 
                      </tr> 
                    </table> 
                    <?php } ?> </td> 
                </tr> 
                <tr class="row<?PHP echo $k; ?>"> 
                  <td width="4%"  nowrap="nowrap" style="border-bottom:1px dashed #000000">&nbsp</td> 
                  <td width="4%"  nowrap="nowrap" style="border-bottom:1px dashed #000000">&nbsp</td> 
                  <td  width="20%"  style="border-bottom:1px dashed #000000">Image Align:
                    <?
	echo "<select id=\"imagealign".$i."\" name=\"imagealign[]\" onchange=\"doPreview(".$i.")\">\n";
	echo "<option ";
	if ($row2->image_align == 'left') {echo 'selected';} 
	echo " value=\"left\">Left</option >\n";
	echo "<option ";
	if ($row2->image_align == 'right') {echo 'selected';} 
	echo " value=\"right\">Right</option >\n";
	echo "</select >"; 
	
	?> </td> 
                  <td width="20%" style="border-bottom:1px dashed #000000"><div align="left"> 
                    <a href="#" onclick="ImageSelector.select('menuimage1<?PHP echo $i; ?>');">Edit Image
                    <?PHP if ($row2->image != null){
			echo "<img id=\"menuimage1".$i."\" name=\"menuimage1".$i."\" src=\"../".$row2->image."\" border = \"0\"></a>";
			echo "<input type =\"hidden\" id=\"menuimage1".$i."hidden\" name=\"menuimage1".$i."hidden\" value=\"".$row2->image."\" >";
		}else{
			echo "<img id=\"menuimage1".$i."\" name=\"menuimage1".$i."\" src=\"components/com_swmenupro/images/blank.png\" alt = \"no image\" border=\"0\"></a>";
			echo "<input type =\"hidden\" id=\"menuimage1".$i."hidden\" name=\"menuimage1".$i."hidden\" value=\"\" >";
		}
		?></td> 
                  <td width="20%" style="border-bottom:1px dashed #000000"><div align="left"> 
                    <a href="#" onclick="ImageSelector.select('menuimage2<?PHP echo $i; ?>');">Edit Over Image
                    <?PHP if ($row2->image_over != null){
			echo "<img id=\"menuimage2".$i."\" name=\"menuimage2".$i."\" src=\"../".$row2->image_over."\" border = \"0\"></a>";
			echo "<input type =\"hidden\" id=\"menuimage2".$i."hidden\" name=\"menuimage2".$i."hidden\" value=\"".$row2->image_over."\" >";
		}else{
			echo "<img id=\"menuimage2".$i."\" name=\"menuimage2".$i."\" src=\"components/com_swmenupro/images/blank.png\" alt = \"no image\" border=\"0\"></a>";
			echo "<input type =\"hidden\" id=\"menuimage2".$i."hidden\" name=\"menuimage2".$i."hidden\" value=\"\" >";
		}
		?> </td> 
                  <input type="hidden" id="isparent<?PHP echo $i; ?>" name="isparent[]" value="<?PHP echo $row2->parent; ?>" /> 
                  <input type="hidden" id="numchildren<?PHP echo $i; ?>" name="numchildren[]" value="<?PHP echo $row2->children; ?>" /> 
                  <input type="hidden" id="menuid<?PHP echo $i; ?>" name="menuid[]" value="<?PHP echo $row2->id; ?>" /> 
                  <input type="hidden" id="rowid<?PHP echo $i; ?>" name="rowid[]" value="<?PHP echo $row2->ext_id ? $row2->ext_id : 'null'; ?>" /> 
                </tr> 
                <?PHP 
			$k = 1 - $k;
     	     }
?> 
                <tr> 
                  <th align="center" colspan="6"> <?php echo $pageNav->writePagesLinks(); ?></th> 
                </tr> 
                <tr> 
                  <td align="center" colspan="6"> <?php echo $pageNav->writePagesCounter(); ?></td> 
                </tr> 
              </table> 
              </td> </tr><tr>
			  <td align="center"><span  style="color:#1166B0; font-size:14px; font-weight:'bold';font-family:'arial';">Important info about custom images and behaviours configuration</span></td></tr><tr>
			   <td align="left"><p>Changing the maximum number of levels or items to display with the dropdown boxes above in the right corner, will cause this page to reload and you will lose all unsaved changes.</p>
			   <p>
			   For best performance of this form, change the maximum number of levels and items to display before making any changes to the form.<br>
			   It is important to note that <B>SWmenuPro can not save changes to menu items not displayed on the custom images and behaviours configuration form.</B>  So if you want to apply changes to all top menu and sub menu items then set the Max Levels# and Display# to high values so that every menu item is visible on the form. If you only wante to change top menu items then set the Max Levels# value to 1</p>
			   <p> 
			   Use the <I><B>Auto menu item configuration utility</B></I> to quickly configure menu items.  Parent menu items are any menu item that has sub menus. Please note the <B>apply</B> button does not save changes, it applies the attributes to the selected items.  Always use the <B>Save</B> button to save changes.</p>
			   <p>
			   The preview should be used as a guide only, and might run quite slow or unpredictable on some computers. This in no way affects the speed or reliability of the menus on your sites front end. You can change the preview background color to the currently selected color on the color wheel picker by clicking the <I><b>'Change Background Color'</b></I> button.</p>
			   <p>
			   The <I><B>Is Link</B></I> behaviour alows you to effectively turn a menu items link off.  It will still react dynamically though by showing sub menus, but it will not reload the page when clicked on by a user.  This feature is very handy when developing menu structures that need placeholders to other pages but not necessarily a page for themselves.</p>
			   </td>
            </tr> 
          </table> 
        </div> 
        <div id="page5" class="pagetext"> 
          <table width="750px"> 
            <tr> 
              <td valign="top" align="center"> <table width="360px"  height = "170" class="adminForm"> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Border Widths </div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Main Menu Border Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "main_border_width" onChange="checkNumberSyntax('Main Menu Border Width','main_border_width',0,200,0); doMainBorder();" name = "main_border_width" type="text" value = "<?php echo $mainborder[0]; ?>" size="8"> 
                        px</div></td> 
                  </tr> 
                  <tr > 
                    <td>Main Menu Over Border Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "main_border_over_width" onChange="checkNumberSyntax('Main Menu Border Over Width','main_border_over_width',0,200,0); doMainBorder();" name = "main_border_over_width" type="text" value = "<?php echo $mainborderover[0]; ?>" size="8"> 
                        px</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Sub Menu Border Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "sub_border_width" onChange="checkNumberSyntax('Sub Menu Border Width','sub_border_width',0,200,0); doSubBorder();" name = "sub_border_width" type="text" value = "<?php echo $subborder[0]; ?>" size="8"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td>Sub Menu Over Border Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "sub_border_over_width" onChange="checkNumberSyntax('Sub Menu Border Over Width','sub_border_over_width',0,200,0); doSubBorder();" name = "sub_border_over_width" type="text" value = "<?php echo $subborderover[0]; ?>" size="8"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Special Effects - Opacity</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td >Sub Menu Opacity:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "specialA" onChange="checkNumberSyntax('Sub Menu Opacity','specialA',0,100,<?php echo $rows->specialA;?>);" name = "specialA" type="text" value = "<?php echo $rows->specialA;?>" size="8"> 
                        %&nbsp</div></td> 
                  </tr> 
                </table></td> 
              <td> <table width="360px"  height = "170" class="adminForm"> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Border Styles </div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Main Menu Border Style:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <select id = "main_border_style" onChange="doMainBorder();" name = "main_border_style" style="width:85px"> 
                          <option <?php if ($mainborder[1] == 'none') {echo 'selected';} ?> value = "none">none</option> 
                         
                          <option <?php if ($mainborder[1] == 'dotted') {echo 'selected';} ?> value = "dotted">dotted</option> 
                          <option <?php if ($mainborder[1] == 'dashed') {echo 'selected';} ?> value = "dashed">dashed</option> 
                          <option <?php if ($mainborder[1] == 'solid') {echo 'selected';} ?> value = "solid">solid</option> 
                          <option <?php if ($mainborder[1] == 'double') {echo 'selected';} ?> value = "double">double</option> 
                          <option <?php if ($mainborder[1] == 'groove') {echo 'selected';} ?> value = "groove">groove</option> 
                          <option <?php if ($mainborder[1] == 'ridge') {echo 'selected';} ?> value = "ridge">ridge</option> 
                          <option <?php if ($mainborder[1] == 'inset') {echo 'selected';} ?> value = "inset">inset</option> 
                          <option <?php if ($mainborder[1] == 'outset') {echo 'selected';} ?> value = "outset">outset</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr > 
                    <td>Main Menu Over Border Style:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <select id = "main_border_over_style" onChange="doMainBorder();" name = "main_border_over_style" style="width:85px"> 
                          <option <?php if ($mainborderover[1] == 'none') {echo 'selected';} ?> value = "none">none</option> 
                         
                          <option <?php if ($mainborderover[1] == 'dotted') {echo 'selected';} ?> value = "dotted">dotted</option> 
                          <option <?php if ($mainborderover[1] == 'dashed') {echo 'selected';} ?> value = "dashed">dashed</option> 
                          <option <?php if ($mainborderover[1] == 'solid') {echo 'selected';} ?> value = "solid">solid</option> 
                          <option <?php if ($mainborderover[1] == 'double') {echo 'selected';} ?> value = "double">double</option> 
                          <option <?php if ($mainborderover[1] == 'groove') {echo 'selected';} ?> value = "groove">groove</option> 
                          <option <?php if ($mainborderover[1] == 'ridge') {echo 'selected';} ?> value = "ridge">ridge</option> 
                          <option <?php if ($mainborderover[1] == 'inset') {echo 'selected';} ?> value = "inset">inset</option> 
                          <option <?php if ($mainborderover[1] == 'outset') {echo 'selected';} ?> value = "outset">outset</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr class="menubackgr" > 
                    <td>Sub Menu Border Style:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <select id = "sub_border_style" onChange="doSubBorder();" name = "sub_border_style" style="width:85px"> 
                          <option <?php if ($subborder[1] == 'none') {echo 'selected';} ?> value = "none">none</option> 
                          
                          <option <?php if ($subborder[1] == 'dotted') {echo 'selected';} ?> value = "dotted">dotted</option> 
                          <option <?php if ($subborder[1] == 'dashed') {echo 'selected';} ?> value = "dashed">dashed</option> 
                          <option <?php if ($subborder[1] == 'solid') {echo 'selected';} ?> value = "solid">solid</option> 
                          <option <?php if ($subborder[1] == 'double') {echo 'selected';} ?> value = "double">double</option> 
                          <option <?php if ($subborder[1] == 'groove') {echo 'selected';} ?> value = "groove">groove</option> 
                          <option <?php if ($subborder[1] == 'ridge') {echo 'selected';} ?> value = "ridge">ridge</option> 
                          <option <?php if ($subborder[1] == 'inset') {echo 'selected';} ?> value = "inset">inset</option> 
                          <option <?php if ($subborder[1] == 'outset') {echo 'selected';} ?> value = "outset">outset</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr > 
                    <td>Sub Menu Over Border Style:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <select id = "sub_border_over_style" onChange="doSubBorder();" name = "sub_border_over_style" style="width:85px"> 
                          <option <?php if ($subborderover[1] == 'none') {echo 'selected';} ?> value = "none">none</option> 
                          
                          <option <?php if ($subborderover[1] == 'dotted') {echo 'selected';} ?> value = "dotted">dotted</option> 
                          <option <?php if ($subborderover[1] == 'dashed') {echo 'selected';} ?> value = "dashed">dashed</option> 
                          <option <?php if ($subborderover[1] == 'solid') {echo 'selected';} ?> value = "solid">solid</option> 
                          <option <?php if ($subborderover[1] == 'double') {echo 'selected';} ?> value = "double">double</option> 
                          <option <?php if ($subborderover[1] == 'groove') {echo 'selected';} ?> value = "groove">groove</option> 
                          <option <?php if ($subborderover[1] == 'ridge') {echo 'selected';} ?> value = "ridge">ridge</option> 
                          <option <?php if ($subborderover[1] == 'inset') {echo 'selected';} ?> value = "inset">inset</option> 
                          <option <?php if ($subborderover[1] == 'outset') {echo 'selected';} ?> value = "outset">outset</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Special Effects - Delay</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td >Sub Menu Open/Close Delay:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "specialB" onChange="checkNumberSyntax('Sub Menu Open/Close Delay','specialB',0,3000,<?php echo $rows->specialB;?>);" name = "specialB" type="text" value = "<?php echo $rows->specialB;?>" size="8"> 
                        ms</div></td> 
                  </tr> 
                </table></td> 
            </tr> 
          </table> 
          <TABLE width="100%"> 
            <TR> 
              <TD align="center" valign="top"> <table width = "300" cellspacing="4"> 
                  <tr> 
                    <td align="center" valign="top"><img src="components/com_swmenupro/images/menu_border_top.gif" width="350" height="25" border = "0" hspace="0" vspace="0"></td> 
                  </tr> 
				 
                  <tr> 
                    <td align= "center" style="height:'20px';border:'1px dashed #000000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 1px Wide and Dashed</td> 
                  </tr> 
                  <tr> 
                   <td align= "center" style="height:'20px';border:'2px dashed #000000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 2px Wide and Dashed</td>  
                  </tr> 
                  <tr> 
                    <td align= "center" style="height:'20px';border:'1px solid #000000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 1px Wide and Solid</td> 
                  </tr> 
                  <tr> 
                   <td align= "center" style="height:'20px';border:'2px solid #000000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 2px Wide and Solid</td> 
                  </tr> 
                  <tr> 
                    <td align= "center" style="height:'20px';border:'2px dotted #669900'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 2px Wide and Dotted</td> 
                  </tr> 
                  <tr> 
                    <td align= "center" style="height:'20px';border:'4px inset #6633FF'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 4px Wide and Inset</td> 
                  </tr> 
                  <tr> 
                   <td align= "center" style="height:'20px';border:'4px double #339900'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 4px Wide and Double</td> 
                  </tr> 
                  <tr> 
                    <td align= "center" style="height:'30px';border:'4px ridge #FF0000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 4px Wide and Ridged</td> 
                  </tr> 
                </table> </TD> 
              <TD align="center" valign="top"><table><tr>
              <TD align="center" valign="top"> <img src = "components/com_swmenupro/images/additional_info_top.gif" width="350" height = "25" border = "0" hspace="0" vspace="0"> </TD> </tr><tr>
            
			<td cellpadding="5">
			 <p>All browsers render border styles and sizes differently. The table to the left shows how your browser has rendered the styles and sizes described.</p> 
			<p>Set border widths to '0' and style to 'none' to display no border.</p>
			<p><I><B>Sub menu opacity</B></I> only applies to the menu item in its normal state and not the mouse over position.</p>
			<p><I><B>Open/Close Delay</B></I> lets you set a delay period between sub menu items opening and closing and is measured in milliseconds.  That is 1000 milliseconds = 1 second.</p>
			
			</td>
			
			</tr></table> </TD> 
            </TR> 
          </TABLE> 
        </div> 
        <div id="page6" class="pagetext"> 
          <table width="750px" height = "320px"> 
            <tr> 
              <td valign="top"> <table width="300px" height = "320px" class="adminForm"> 
                  <tr> 
                    <td align="center"> <img src="components/com_swmenupro/images/swmenupro_box.gif" width="150" height="250"></td> 
                  </tr> 
                </table> 
              <td align="center" valign="top"><table width="420" height = "320px" class="adminForm" > 
                  <tr> 
                    <th ><div align="center" class="style1">Welcome to SWmenuPro</div></th> 
                  </tr> 
                  <td align="left" valign="top"><span  class="adminheader">Features:</span></td> 
                  </tr> <tr> 
                    <td> <p>  
                       <li>Unlimited menus on any page with seperate modules for each</li> 
					   <li>Three independent menu types with seperate configurations</li> 
					   <li>Advanced custom images and animations for each menu items</li> 
                       <li>Vertical or horizontal menu alignment(popout menu only)</li> 
 					   <li>Absolute or Relative positioning(popout and clickmenu only)</li> 
                       
                       <li>Advanced positioning of menu items through offsets</li> 
  
                       <li>Advanced dimensioning of menu item widths, heights and borders </li> 
  
                       <li>Advanced font administration including font families, sizes and weight</li> 
  
                       <li>Advanced color and background image assignment for top menus and sub menus</li> 
  
                       </p></td> 
                  </tr> 
                  <tr> 
                    <td align="center"><p> for support and info on upgrades please visit <a href="http://www.swonline.biz">www.swonline.biz</a> <br> 
                        <br> 
                        swmenupro is &copy;opyright 2004 <a href="http://www.swonline.biz">www.swonline.biz</a></p></td> 
                  </tr> 
                </table> 
            </tr> 
            </td> 
             </table> 
        </div> 
        <input type="hidden" id="main_padding" name="main_padding" value="<?PHP echo $rows->main_padding; ?>" /> 
        <input type="hidden" id="sub_padding" name="sub_padding" value="<?PHP echo $rows->sub_padding; ?>" /> 
        <input type="hidden" id="main_border" name="main_border" value="<?PHP echo $rows->main_border; ?>" /> 
        <input type="hidden" id="sub_border" name="sub_border" value="<?PHP echo $rows->sub_border; ?>" /> 
        <input type="hidden" id="main_border_over" name="main_border_over" value="<?PHP echo $rows->main_border_over; ?>" /> 
        <input type="hidden" id="sub_border_over" name="sub_border_over" value="<?PHP echo $rows->sub_border_over; ?>" /> 
        <input type="hidden" name="option" value="<?PHP echo $option; ?>" /> 
        <input type="hidden" name="pageID" value="tab4" /> 
        <input type="hidden" name="moduleID" value="<?PHP echo $moduleID; ?>" /> 
        <input type="hidden" name="cid[]" value="<?PHP echo $moduleID; ?>" /> 
        <input type="hidden" name="menutype" value="<?PHP echo $menutype; ?>" /> 
		<input type="hidden" name="menustyle" value="popoutmenu" /> 
        <input type="hidden" name="task" value="editDhtmlMenu" /> 
        <input type="hidden" name="boxchecked" value="0" /> 
        <input type="hidden" name="id" value="<?php echo $moduleID; ?>"> 
    </form> 
    </td> 
  </tr> 
</table> 
<script language="javascript" type="text/javascript">
		  

activatePreview();
dhtml.cycleTab('<?php echo $pageID; ?>');

</script> 
</td> 
</tr> 

  </table> 
  <?php

}











function gosuMenuConfig( $rows, $option , $id, $list, $menutype, $moduleID, $pageNav, $levellist, $pageID, $mainpadding, $subpadding, $mainborder, $subborder, $mainborderover, $subborderover, $modulename)
	{
?>
<script type="text/javascript" src="components/com_swmenupro/ImageManager/assets/dialog.js"></script>
<script type="text/javascript" src="components/com_swmenupro/ImageManager/IMEStandalone.js"></script>
<script type="text/javascript" src="components/com_swmenupro/js/swmenupro.js"></script>
<script type="text/javascript" src="components/com_swmenupro/js/preview.js"></script>

<script language="javascript" src="js/dhtml.js"></script>
<script language="javascript">

	
		function submitbutton(pressbutton) {

		doMainBorder();
		doSubBorder();

		submitform( pressbutton );
		}

function activatePreview(){
var counter = <?php echo count($list); ?>;
doMainBorder();
doSubBorder();

for(i=0;i<counter;i++)
			{
			doPreview(i);
			}
}

</script>
 <table cellpadding="4" cellspacing="4" border="0" width="750"> 
  <tr> 
     <td><a href="http://www.swonline.biz"> <img src="components/com_swmenupro/images/swmenupro_logo_small.gif" align="absmiddle" border="0"/> </a></td> 
     <td><span class="sectionname"><?php echo $modulename;?> myGosu Menu Configuration</span> </td> 
   </tr> 
</table> 
<table width="750" style="width='750px';" class="adminForm" align="center"> 
  <tr><td valign="top"> 
    <form action="index2.php" method="POST" name="adminForm"> <table width="100%"> 
      <tr><td align="center"> 
        <table cellpadding="3" cellspacing="0" border="0" width="750"> 
          <tr> 
           <td id="tab1" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Size, Position & Offsets</td> 
            <td id="tab2" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Colors & Backgrounds</td> 
            <td id="tab3" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Fonts & Padding</td> 
            <td id="tab4" class="offtab" onclick="activatePreview(); dhtml.cycleTab(this.id)">Custom Images & Behaviours</td> 
            <td id="tab5" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Borders & Effects</td> 
            <td id="tab6" class="offtab" onclick="dhtml.cycleTab(this.id)">About swmenupro</td> 
          </tr> 
        </table> 
        
		
		
		
		<div id="page1" class="pagetext"> 
          <table width="750px"> 
            <tr> 
              <td valign="top" align="center"> <table width="360px" height = "200" class="adminForm"> 
                  <tr> 
                    <td colspan="2" class="tabheading"> <div align="center">Menu Position and Orientation</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Top Menu - Alignment:</td> 
                    <td width="120" class="adminlist"> <div align="left"> 
                        <select name="position" id="position" style = "width:'120px'"> 
                          <option <?php if ($rows->position == 'left') {echo 'selected';} ?> value = "left">Left</option> 
                          <option <?php if ($rows->position == 'right') {echo 'selected';} ?> value = "right">Right</option> 
						  <option <?php if ($rows->position == 'center') {echo 'selected';} ?> value = "center">Center</option>
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr> 
                    <td>Top Menu - Orientation:</td> 
                    <td width="120" class="adminlist"> <div align="left"> 
                        <select name="orientation" id="orientation" style = "width:'120px'"> 
                          <option <?php if ($rows->orientation == 'horizontal') {echo 'selected';} ?> value = "horizontal">Horizontal</option> 
                          <option <?php if ($rows->orientation == 'vertical') {echo 'selected';} ?> value = "vertical">Vertical</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Menu Item Sizes</div></td> 
                  </tr> 
                   <tr class="menubackgr"> 
                    <td>Top Menu Item Width: <i>(set to '0' to auto size)</i></td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu Elements Width','main_width',0,800,<?php echo $rows->main_width;?>);" size="8" id = "main_width" name = "main_width" value = "<?php echo $rows->main_width;?>" > 
                        px</div></td> 
                  </tr> 
                  <tr > 
                    <td>Top Menu Item Height: <i>(set to '0' to auto size)</i></td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "main_height"  onChange="checkNumberSyntax('Top Menu Elements Height','main_height',0,800,<?php echo $rows->main_height;?>);" name = "main_height" type="text" value = "<?php echo $rows->main_height;?>" size="8"> 
                        px</div></td> 
                  <tr class="menubackgr"> 
                    <td>Sub Menu Item Width: <i>(set to '0' to auto size)</i></td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text"  onChange="checkNumberSyntax('Sub Menu Elements Width','sub_width',0,800,<?php echo $rows->sub_width;?>);" size="8" id = "sub_width" name = "sub_width" value = "<?php echo $rows->sub_width;?>"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td>Sub Menu Item Height: <i>(set to '0' to auto size)</i></td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "sub_height"  onChange="checkNumberSyntax('Sub Menu Elements Height','sub_height',0,800,<?php echo $rows->sub_height;?>);" name = "sub_height" type="text" value = "<?php echo $rows->sub_height;?>" size="8"> 
                        px</div></td> 
                  </tr> 
                </table></td> 
              <td valign="top"> <table width = "360px"  height = "200" class="adminForm" > 
                  <tr> 
                    <td colspan="2" class="tabheading"> <div align="center">Top Menu Offsets</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Top Menu - Top Offset:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu - Top Offset','main_top',-1000,1000,<?php echo $rows->main_top;?>);"  size="8" name = "main_top" value = "<?php echo $rows->main_top;?>"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td>Top Menu - Left Offset:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu - Left Offset','main_left',-1000,1000,<?php echo $rows->main_left;?>);"  size="8"  name = "main_left" value = "<?php echo $rows->main_left;?>"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"> <div align="center">Sub Menu Offsets</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Level 1 Sub Menu - Top Offset:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu - Top Offset','level1_sub_top',-1000,1000,<?php echo $rows->level1_sub_top;?>);"  size="8" name = "level1_sub_top" value = "<?php echo $rows->level1_sub_top;?>"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td>Level 1 Sub Menu - Left Offset:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu - Left Offset','level1_sub_left',-1000,1000,<?php echo $rows->level1_sub_left;?>);"  size="8"  name = "level1_sub_left" value = "<?php echo $rows->level1_sub_left;?>"> 
                        px</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Level 2 Sub Menu - Top Offset:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu - Top Offset','level2_sub_top',-1000,1000,<?php echo $rows->level2_sub_top;?>);"  size="8" name = "level2_sub_top" value = "<?php echo $rows->level2_sub_top;?>"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td>Level 2 Sub Menu - Left Offset:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu - Left Offset','level2_sub_left',-1000,1000,<?php echo $rows->level2_sub_left;?>);"  size="8"  name = "level2_sub_left" value = "<?php echo $rows->level2_sub_left;?>"> 
                        px</div></td> 
                  </tr> 
                </table></td> 
            </tr> 
          </table> 
          <TABLE width="100%"> 
            <TR> 
              <TD align="center"> <img src = "components/com_swmenupro/images/gosu_offsets.gif" width="700" height = "350" border = "0" hspace="0" vspace="0"> </TD> 
             
            </TR> 
          </TABLE> 
        </div> 
        <div id="page2" class="pagetext"> 
          <table width="750px"> 
            <tr><td valign="top" align="center"> 
              <table width="360px"  height = "250" class="adminForm"> 
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Background Images</div></td> 
                </tr> 
                <tr class="menubackgr" > 
                  <td>Top Menu Background:</td> 
                  <td colspan="2"><table id="main_back_image_box" style="border: 1px solid #000000; width:'100px'; height:'15px'" background="../<?php echo $rows->main_back_image;?>" align="left"> 
                      <tr> 
                        <td width="20" height="20">&nbsp</td> 
                      </tr> 
                    </table> 
                    <input type="button" name = "getimage" value = "GET" onclick="BackgroundSelector.select('main_back_image');"> 
                    <input type="hidden" id="main_back_image" name = "main_back_image" value = "<?php echo $rows->main_back_image;?>"> </td> 
                </tr> 
                <tr> 
                  <td>Top Menu Over Background:</td> 
                  <td colspan="2"><table id="main_back_image_over_box" style="border: 1px solid #000000; width:'100px'; height:'15px'" background="../<?php echo $rows->main_back_image_over;?>" align="left"> 
                      <tr> 
                        <td width="20" height="20">&nbsp</td> 
                      </tr> 
                    </table> 
                    <input type="button" name = "getimage" value = "GET" onclick="BackgroundSelector.select('main_back_image_over');"> 
                    <input type="hidden" id="main_back_image_over" name = "main_back_image_over" value = "<?php echo $rows->main_back_image_over;?>"> </td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Sub Menu Background:</td> 
                  <td colspan="2"><table id="sub_back_image_box" style="border: 1px solid #000000; width:'100px'; height:'15px'" background="../<?php echo $rows->sub_back_image;?>" align="left"> 
                      <tr> 
                        <td width="20" height="20">&nbsp</td> 
                      </tr> 
                    </table> 
                    <input type="button" name = "getimage" value = "GET" onclick="BackgroundSelector.select('sub_back_image');"> 
                    <input type="hidden" id="sub_back_image" name = "sub_back_image" value = "<?php echo $rows->sub_back_image;?>"> </td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Over Background:</td> 
                  <td colspan="2"><table id="sub_back_image_over_box" style="border: 1px solid #000000; width:'100px'; height:'15px'" background="../<?php echo $rows->sub_back_image_over;?>" align="left"> 
                      <tr> 
                        <td width="20" height="20">&nbsp</td> 
                      </tr> 
                    </table> 
                    <input type="button" name = "getimage" value = "GET" onclick="BackgroundSelector.select('sub_back_image_over');"> 
                    <input type="hidden" id="sub_back_image_over" name = "sub_back_image_over" value = "<?php echo $rows->sub_back_image_over;?>"> </td> 
                </tr> 
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Background Colors</div></td> 
                </tr> 
                <tr class="menubackgr" > 
                  <td>Top Menu Color:</td> 
                  <td > 
                  <table id="main_back_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_back;?>' > 
                    <tr> 
                      <td width="20" height="20">&nbsp</td>  
                    </tr> 
                    
                  </table> 
                </td> 
                 <td width="120" class="adminlist" > <div align="right"> 
                      <input type="text" onChange="checkColorSyntax('Main Menu Color','main_back','<?php echo $rows->main_back;?>');" size="8"  id="main_back" name = "main_back" value = "<?php echo $rows->main_back;?>"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_back');" > <img src="components/com_swmenupro/images/sel.gif">get</a> </div></td> 
                </tr> <tr> 
                  <td>Top Menu Over Color:</td> 
                  <td > 
                   <table id="main_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_over;?>'> 
                     <tr> 
                       <td width="20" height="20">&nbsp</td>  
                     </tr> 
                    
                   </table> 
                </td> 
                 <td width="120" class="adminlist"> <div align="right"> 
                      <input type="text" onChange="checkColorSyntax('Top Menu Over Color','main_over','<?php echo $rows->main_over;?>');" size="8"  id = "main_over" name = "main_over" value = "<?php echo $rows->main_over;?>"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_over');"><img src="components/com_swmenupro/images/sel.gif">get</a> </div></td> 
                </tr> <tr class="menubackgr"> 
                  <td>Sub Menu Color:</td> 
                  <td > 
                   <table id="sub_back_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->sub_back;?>'> 
                     <tr> 
                      <td width="20" height="20">&nbsp</td>  
                     </tr> 
                     
                   </table> 
                </td> 
                 <td width="120" class="adminlist"> <div align="right"> 
                      <input type="text" onChange="checkColorSyntax('Sub Menu Color','sub_back','<?php echo $rows->sub_back;?>');" size="8"  id = "sub_back" name = "sub_back" value = "<?php echo $rows->sub_back;?>"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_back');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> <tr> 
                  <td>Sub Menu Over Color:</td> 
                  <td > 
                   <table id="sub_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->sub_over;?>'> 
                     <tr> 
                       <td width="20" height="20">&nbsp</td>  
                     </tr> 
                     
                   </table> 
                  </td> 
                   <td width="120" class="adminlist"> <div align="right"> 
                       <input type="text" onChange="checkColorSyntax('Sub Menu Over Color','sub_over','<?php echo $rows->sub_over; ?>');" size="8" id = "sub_over" name = "sub_over" value = "<?php echo $rows->sub_over;?>"> 
                       <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
              </table> 
              </td> 
              <td valign="top"> 
              <table width = "360px"  height = "250" class="adminForm"> 
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Font Colors </div> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Top Menu Font Color:</td> 
                  <td > 
                  <table id="main_font_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_font_color;?>'> 
                    <tr> 
                     <td width="20" height="20">&nbsp</td>  
                    </tr> 
                   
                  </table> 
                </td> 
                 <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "main_font_color" onChange="checkColorSyntax('Top Menu Font Color','main_font_color','<?php echo $rows->main_font_color;?>');" type="text" id="main_font_color" value = "<?php echo $rows->main_font_color;?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_font_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> <tr> 
                  <td>Top Menu Over Font Color:</td> 
                  <td > 
                   <table id="main_font_color_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_font_color_over;?>'> 
                     <tr> 
                       <td width="20" height="20">&nbsp</td>  
                     </tr> 
                     
                   </table> 
                  </td> 
                   <td width="120" class="adminlist"> <div align="right"> 
                       <input name = "main_font_color_over" onChange="checkColorSyntax('Top Menu Over Font Color','main_font_color_over','<?php echo $rows->main_font_color_over;?>');" type="text" id="main_font_color_over" value = "<?php echo $rows->main_font_color_over;?>" size="8"> 
                       <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_font_color_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Sub Menu Font Color:</td> 
                  <td > 
                  <table id="sub_font_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->sub_font_color;?>'> 
                    <tr> 
                      <td width="20" height="20">&nbsp</td>  
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "sub_font_color" onChange="checkColorSyntax('Sub Menu Font Color','sub_font_color','<?php echo $rows->sub_font_color;?>');" type="text" id="sub_font_color" value = "<?php echo $rows->sub_font_color;?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_font_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Over Font Color:</td> 
                  <td > 
                  <table id="sub_font_color_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->sub_font_color_over;?>'> 
                    <tr> 
                      <td width="20" height="20">&nbsp</td>  
                    </tr> 
                    
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input name = "sub_font_color_over" onChange="checkColorSyntax('Sub Menu Over Font Color','sub_font_color_over','<?php echo $rows->sub_font_color_over;?>');" type="text" id="sub_font_color_over" value = "<?php echo $rows->sub_font_color_over;?>"  size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_font_color_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Border Colors</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Top Menu Border Color:</td> 
                  <td > 
                  <table id="main_border_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $mainborder[2];?>'> 
                    <tr> 
                       <td width="20" height="20">&nbsp</td>   
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "main_border_color" onChange="checkColorSyntax('Top Menu Border Color','main_border_color','<?php echo $mainborder[2];?>'); doMainBorder();" type="text" id="main_border_color" value = "<?php echo $mainborder[2];?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_border_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr > 
                  <td>Top Menu Over Border Color:</td> 
                  <td > 
                  <table id="main_border_color_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $mainborderover[2];?>'> 
                    <tr> 
                      <td width="20" height="20">&nbsp</td>  
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "main_border_color_over" onChange="checkColorSyntax('Top Menu Over Border Color','main_border_color_over','<?php echo $mainborderover[2];?>'); doMainBorder();" type="text" id="main_border_color_over" value = "<?php echo $mainborderover[2];?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_border_color_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Sub Menu Border Color:</td> 
                  <td > 
                  <table id="sub_border_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $subborder[2];?>'> 
                    <tr> 
                       <td width="20" height="20">&nbsp</td>   
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "sub_border_color" type="text" onChange="checkColorSyntax('Sub Menu Border Color','sub_border_color','<?php echo $subborder[2];?>'); doSubBorder();" id="sub_border_color" value = "<?php echo $subborder[2];?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_border_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Over Border Color:</td> 
                  <td > 
                  <table id="sub_border_color_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $subborderover[2];?>'> 
                    <tr> 
                       <td width="20" height="20">&nbsp</td>  
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "sub_border_color_over" type="text" onChange="checkColorSyntax('Sub Menu Border Over Color','sub_border_color_over','<?php echo $subborderover[2];?>'); doSubBorder();" id="sub_border_color_over" value = "<?php echo $subborderover[2];?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_border_color_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
              </table> 
              </td> 
            </tr> 
          </table> 
          <TABLE width="100%" valign="top"> 
            <TR> 
              <TD align="center"> <table width = "360px" height = "320px"  valign="top"> 
                  <tr> 
                    <td align="center" valign="top"><img src="components/com_swmenupro/images/color_wheel_top.gif" width="350" height="44"></td> 
                  </tr> 
                  <tr> 
                    <td> <table width = "320px" align="center"> 
                        <tr> 
                          <td id="CPCP_Wheel" ><img src="components/com_swmenupro/images/colorwheel.jpg" width="256" height="256"  onMouseMove="xyOff(event);" onClick="wrtVal();" border="1"></td> 
                          <td>&nbsp;</td> 
                          <td> <table border="0"> 
                              <tr> 
                                <td valign="TOP">Present Color:</td> 
                              </tr> 
                              <tr> 
                                <td id="CPCP_ColorCurrent" height="70"></td> 
                              </tr> 
                              <tr> 
                                <td id="CPCP_ColorSelected">&nbsp;</td> 
                              </tr> 
                              <tr> 
                                <td><br> 
                                  Selected Color:  
                              </tr> 
                              <tr> 
                                <td bgcolor="#FFFFFF" id="CPCP_Input" height="70"  >&nbsp;</td> 
                              <tr> 
                                <td><input name="TEXT" type="TEXT" id="CPCP_Input_RGB" value="#FFFFFF" size="8"></td> 
                              </tr> 
                            </table></td> 
                        </tr> 
                      </table></td> 
                  </tr> 
                </table></TD><td valign="top" align="center"> 
				<table><tr>
              <TD align="center" valign="top"> <img src = "components/com_swmenupro/images/additional_info_top.gif" width="350" height = "25" border = "0" hspace="0" vspace="0"> </TD> </tr><tr>
            
			<td cellpadding="5"><p>All colors should be a valid 6 digit hexadecimal color code with a preceding #. Use the provided color wheel or type values in manually.</p>
			<p>It is possible to set any color value to <B>transparent</B> by simply clearing the appropriate box.</p>
			<p>Background images are tiled across a menu item acording to size and height and will overlay the corresponding color value for the menu item.</p>
			<p>To make a <B>web button</B>, make your menu items size and width the same size and width as the backgound images being used for the normal and mouse over states.</p>
			
			</td>
			
			</tr></table>
			</td></TR> 
          </TABLE> 
        </div> 
        <div id="page3" class="pagetext"> 
          <table width="750px"> 
            <tr> 
              <td valign="top" align="center"> <table style="width:'360px'" width = "360px"  height = "210" class="adminForm"> 
                  <tr> 
                    <td colspan="2" class="tabheading"> <div align="center">Font Family</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td width="100">Top Menu:</td> 
                    <td  width="250" class="adminlist"> <div align="right"> 
                        <select name="font_family" id="font_family" style = "width:'250px'"> 
                          <option <?php if ($rows->font_family == 'Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Arial, Helvetica, sans-serif">Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->font_family == '\'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "'Times New Roman', Times, serif">'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->font_family == 'Georgia, \'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "Georgia, 'Times New Roman', Times, serif">Georgia,'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->font_family == 'Verdana, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Verdana, Arial, Helvetica, sans-serif">Verdana,Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->font_family == 'Geneva, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Geneva, Arial, Helvetica, sans-serif">Geneva,Arial,Helvetica,sans-serif</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr > 
                    <td>Sub Menu:</td> 
                    <td width="250"  class="adminlist"> <div align="right"> 
                        <select name="sub_font_family" id="sub_font_family"  style = "width:'250px'"> 
                          <option <?php if ($rows->sub_font_family == 'Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Arial, Helvetica, sans-serif">Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->sub_font_family == '\'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "'Times New Roman', Times, serif">'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->sub_font_family == 'Georgia, \'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "Georgia, 'Times New Roman', Times, serif">Georgia,'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->sub_font_family == 'Verdana, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Verdana, Arial, Helvetica, sans-serif">Verdana,Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->sub_font_family == 'Geneva, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Geneva, Arial, Helvetica, sans-serif">Geneva,Arial,Helvetica,sans-serif</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Top Menu Padding</div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="adminlist" align="center"> <TABLE> 
                        <TR class="menubackgr"> 
                          <TD width="75" align="center">Top</TD> 
                          <TD width="75" align="center">Right</TD> 
                          <TD width="75" align="center">Bottom</TD> 
                          <TD width="75" align="center">Left</TD> 
                        </TR> 
                        <TR> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Top Padding','main_pad_top',0,100,0); doMainPadding();" size="3" id = "main_pad_top" name = "main_pad_top" value = "<?php echo $mainpadding[0]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Right Padding','main_pad_right',0,100,0);doMainPadding();" size="3" id = "main_pad_right" name = "main_pad_right" value = "<?php echo $mainpadding[1]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Bottom Padding','main_pad_bottom',0,100,0);doMainPadding();" size="3" id = "main_pad_bottom" name = "main_pad_bottom" value = "<?php echo $mainpadding[2]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Left Padding','main_pad_left',0,100,0);doMainPadding();" size="3" id = "main_pad_left" name = "main_pad_left" value = "<?php echo $mainpadding[3]; ?>" maxlength="2"> 
                            px</TD> 
                        </TR> 
                      </TABLE></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Sub Menu Padding</div></td> 
                  </tr> 
                  <tr > 
                    <td colspan="2" class="adminlist" align="center"> <TABLE> 
                        <TR class="menubackgr"> 
                          <TD width="75" align="center">Top</TD> 
                          <TD width="75" align="center">Right</TD> 
                          <TD width="75" align="center">Bottom</TD> 
                          <TD width="75" align="center">Left</TD> 
                        </TR> 
                        <TR> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Top Padding','sub_pad_top',0,100,0);doSubPadding();" size="3" id = "sub_pad_top" name = "sub_pad_top" value = "<?php echo $subpadding[0]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Right Padding','sub_pad_right',0,100,0);doSubPadding(); " size="3" id = "sub_pad_right" name = "sub_pad_right" value = "<?php echo $subpadding[1]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Bottom Padding','sub_pad_bottom',0,100,0);doSubPadding(); " size="3" id = "sub_pad_bottom" name = "sub_pad_bottom" value = "<?php echo $subpadding[2]; ?>" maxlength="2">
						   px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Left Padding','sub_pad_left',0,100,0);doSubPadding(); " size="3" id = "sub_pad_left" name = "sub_pad_left" value = "<?php echo $subpadding[3]; ?>" maxlength="2"> 
                            px</TD> 
                        </TR> 
                      </TABLE></td> 
                  </tr> 
                </table></td> 
              <td valign="top"> 
              <table width = "360px" style="width:'360px'" height = "210"class="adminForm"> 
                <tr> 
                  <td colspan="2" class="tabheading"> <div align="center">Font Size</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Top Menu Font Size:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <input id = "main_font_size" onChange="checkNumberSyntax('Top Menu Font Size:','main_font_size',3,100,<?php echo $rows->main_font_size;?>);" name = "main_font_size" type="text"  value = "<?php echo $rows->main_font_size;?>" size="8"> 
                      px</div></td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Font Size:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <input  id = "sub_font_size" onChange="checkNumberSyntax('Sub Menu Font Size','sub_font_size',3,100,<?php echo $rows->sub_font_size;?>);" name = "sub_font_size" type="text" value = "<?php echo $rows->sub_font_size;?>" size="8"> 
                      px</div></td> 
                </tr> 
                <tr> 
                  <td colspan="2" class="tabheading"> <div align="center">Font Alignment</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Top Menu Text Alignment:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="main_align" id="main_align" onChange="doPreview();" style = "width:'100px'"> 
                        <option <?php if ($rows->main_align == 'left') {echo 'selected';} ?> value = "left">left</option> 
                        <option <?php if ($rows->main_align == 'right') {echo 'selected';} ?> value = "right">right</option> 
                        <option <?php if ($rows->main_align == 'center') {echo 'selected';} ?> value = "center">center</option> 
                      </select> 
                    </div></td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Text Alignment:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="sub_align" id="sub_align" onChange="doPreview();" style = "width:'100px'" > 
                        <option <?php if ($rows->sub_align == 'left') {echo 'selected';} ?> value = "left">left</option> 
                        <option <?php if ($rows->sub_align == 'right') {echo 'selected';} ?> value = "right">right</option> 
                        <option <?php if ($rows->sub_align == 'center') {echo 'selected';} ?> value = "center">center</option> 
                      </select> 
                    </div></td> 
                </tr> 
                <tr> 
                  <td colspan="2" class="tabheading"> <div align="center">Font Weight</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Top Menu Font Weight:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="font_weight" id="font_weight" onChange="doPreview();" style = "width:'100px'"> 
                        <option <?php if ($rows->font_weight == 'normal') {echo 'selected';} ?> value = "normal">normal</option> 
                        <option <?php if ($rows->font_weight == 'bold') {echo 'selected';} ?> value = "bold">bold</option> 
                        <option <?php if ($rows->font_weight == 'bolder') {echo 'selected';} ?> value = "bolder">bolder</option> 
                        <option <?php if ($rows->font_weight == 'lighter') {echo 'selected';} ?> value = "lighter">lighter</option> 
                      </select> 
                    </div></td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Font Weight:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="font_weight_over" id="font_weight_over" onChange="doPreview();" style = "width:'100px'"> 
                        <option <?php if ($rows->font_weight_over == 'normal') {echo 'selected';} ?> value = "normal">normal</option> 
                        <option <?php if ($rows->font_weight_over == 'bold') {echo 'selected';} ?> value = "bold">bold</option> 
                        <option <?php if ($rows->font_weight_over == 'bolder') {echo 'selected';} ?> value = "bolder">bolder</option> 
                        <option <?php if ($rows->font_weight_over == 'lighter') {echo 'selected';} ?> value = "lighter">lighter</option> 
                      </select> 
                    </div></td> 
                </tr> 
                <tr> </tr> 
                </td> 
                 </table> 
              </td> 
            </tr> 
          </table> 
          <TABLE width="100%" align="center"> 
            <TR> 
              <TD align="center" valign="top"> <table width = "360" > 
                  <tr> 
                    <td align="center" valign="top"><img src="components/com_swmenupro/images/menu_fonts_top.gif" width="350" height="25"></td> 
                  </tr> 
				  <tr> 
                    <td align= "center">All browsers render fonts and sizes differently.  The list below shows how your browser has rendered the fonts and sizes described.<br> </td> 
                  </tr> 
                  <tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:10px; font-weight:'normal';font-family:''Times New Roman', Times, serif';">'Times New Roman', Times, serif normal at 10px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:10px; font-weight:'bold';font-family:'Verdana,Arial,Helvetica,sans-serif';">Verdana,Arial,Helvetica,sans-serif Bold at 10px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:12px; font-weight:'normal';font-family:'Arial,Helvetica,sans-serif';">Arial,Helvetica,sans-serif Normal at 12px</span> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center" valign="top"><span  style="color:#1166B0; font-size:12px; font-weight:'normal';font-family:'Georgia, 'Times New Roman', Times, serif';">Georgia, 'Times New Roman', Times, serif Normal at 12px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:12px; font-weight:'bold';font-family:Geneva,Arial,Helvetica,sans-serif';">'Geneva,Arial,Helvetica,sans-serif Bold at 12px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'normal';font-family:''Times New Roman', Times, serif';">'Times New Roman', Times, serif normal at 14px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'bold';font-family:'Verdana,Arial,Helvetica,sans-serif';">Verdana,Arial,Helvetica,sans-serif Bold at 14px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'bold';font-family:'Arial,Helvetica,sans-serif';">Arial,Helvetica,sans-serif Bold at 14px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'normal';font-family:'Geneva,Arial,Helvetica,sans-serif';">Geneva,Arial,Helvetica,sans-serif Normal at 14px</span><br> </td> 
                  </tr> 
                </table></TD> 
              <TD align="center"> <img src = "components/com_swmenupro/images/menu_padding.gif" width="350" height = "274" border = "0" hspace="0" vspace="0"> </TD> 
            </TR> 
          </TABLE> 
        </div> 
       
		
		 <div id="page4" class="pagetext"> 
          <table width="750px"> 
            <tr><td valign="top"> 
              <table cellpadding="4" cellspacing="0" border="0" width="100%"> 
                <tr> 
                  <th width="80%">Auto Menu Item Configuration Utility</th> 
                  <th nowrap="nowrap" align="right">Max Levels</th> 
                  <th><?php echo $levellist;?></th> 
                  <th nowrap="nowrap">Display #</th> 
                  <th><?php $pageNav->writeLimitBox();?></th> 
                </tr> 
              </table> 
              <table> 
                <tr> 
                  <td><b>Step 1. Select Items</b></td> 
                  <td><b>Step 2. Select Attribute</b></td> 
                  <td align="center"><b>Image Preview</b></td> 
                  <td align="center"><b>Step 3. Press Apply</b></td> 
                </tr> 
                <tr> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="autoassign" id="autoassign" style = "width:'200px'"> 
                        <option  value = "">Please Select..</option> 
                        <option  value = "selected">Selected Menu Items</option> 
                        <option  value = "all">All Menu Items</option> 
                        <option  value = "main">Top Menu Items</option> 
                        <option  value = "sub">Sub Menu Items</option> 
                        <option  value = "parent">Parent Menu Items</option> 
                      </select> 
                    </div></td> 
                  <td width="100"> <select name="autoattrib" onchange="doImageChange();" id="autoattrib" style = "width:'200px'"> 
                      <option  value = "">Please Select..</option> 
                      <option  value = "image1">Image</option> 
                      <option  value = "image2">Image Over</option> 
                      <option  value = "showname">Show name</option> 
                      <option  value = "dontshowname">Do Not Show Name</option> 
                      <option  value = "imageleft">Image Align Left</option> 
                      <option  value = "imageright">Image Align Right</option> 
                      <option  value = "islink">Is A Link</option> 
                      <option  value = "isnotlink">Is Not a Link</option> 
                    </select> </td> 
                  <td width="150" align="center"> <img id="globalimage" name="globalimag0" src="components/com_swmenupro/images/blank.png" border = "0"></td> 
                  <input type ="hidden" id="globalimagehidden" name="globalimagehidden" value="" > 
                </td> 
                 <td nowrap="nowrap" align="center"><input type="button" onClick="doAutoAssign(<?php echo count($list); ?>)" value = "apply"></td> 
                </tr> </table> 
              <table cellpadding="4" cellspacing="0" border="0" width="100%"> 
                <tr> 
                  <th nowrap="nowrap" width="500px">Individual Menu Item Configuration</th> 
                  <th  >Preview</th> 
                  <th align="center"><a onMouseOver="this.style.cursor='pointer'" onClick="changePreviewColor(<?php echo count($list); ?>);"><img src="components/com_swmenupro/images/sel.gif">Change Background Color</a></th> 
                </tr> 
              </table> 
              <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminList"> 
                <?
    $k = 0;
    for ($i=0, $n=count($list); $i < $n; $i++) 
    {
    	$row2 = &$list[$i];
        if ($row2->show_name == null){$row2->show_name = 1;}
		if ($row2->target_level == null){$row2->target_level = 1;}
		if ($row2->image_align == null){$row2->image_align = 'left';}
		$img = $row2->show_name ? 'tick.png' : 'publish_x.png';
		$img2 = $row2->target_level ? 'tick.png' : 'publish_x.png';
		
       
	?> 
                <tr class="row<?PHP echo $k; ?>"> 
                  <td width="4%" nowrap="nowrap"><?php echo $i+$pageNav->limitstart+1;?></td> 
                  <td width="4%"  nowrap="nowrap"><input type="checkbox" id="cb<?PHP echo $i; ?>" name="checkid[]" value="<?PHP echo $i; ?>" onclick="isChecked(this.checked);" /></td> 
                  <td width="20%"  nowrap="nowrap"><b><?PHP echo $row2->treename; ?></b></td> 
                  <td width="20%"  nowrap="nowrap"><a  onmouseover="this.style.cursor='pointer'" onclick="swapValue('showname<?PHP echo $i."',".$i; ?>);">Show Name
                    <?PHP
			echo "<img id=\"showname".$i."image\" name=\"showname".$i."image\" src=\"images/".$img."\" border = \"0\"></a>";
			echo "<input type =\"hidden\" id=\"showname".$i."\" name=\"showname[]\" value=\"".$row2->show_name."\" >";
	?></td> 
                  <td width="20%" nowrap="nowrap"><a  onmouseover="this.style.cursor='pointer'" onclick="swapValue('targetlevel<?PHP echo $i."',".$i; ?>);">Is Link
                    <?PHP
			echo "<img id=\"targetlevel".$i."image\" name=\"targetlevel".$i."image\" src=\"images/".$img2."\" border = \"0\"></a>";
			echo "<input type =\"hidden\" id=\"targetlevel".$i."\" name=\"targetlevel[]\" value=\"".$row2->target_level."\" >";
	?></td> 
                  <td  id="preview_back<?PHP echo $i; ?>" rowspan="2" align="center" style="border-bottom:1px dashed #000000" > <?php 
		
	
	if($row2->parent == '0'){
		$previewimage->image = $row2->image ? $row2->image : 'administrator/components/com_swmenupro/images/blank.png';;

		?> 
                    <table id="maintablepreview<?PHP echo $i; ?>" cellpadding="0" cellspacing="0" border="0"> 
                      <tr> 
                        <td id="mainpreview<?php echo $i; ?>"   onmouseover="doMainPreviewOver(<?php echo $i; ?>)" onmouseout="doMainPreviewOut(<?php echo $i; ?>)" valign="top" align="left" ><img id = "imagepreview<?php echo $i; ?>" src="<?PHP echo "../".$previewimage; ?>" align="<?PHP echo $row2->image_align; ?>" cellpadding="0" cellspacing="0" border="0" > 
                          <div id="maindivpreview<?PHP echo $i; ?>" ><?PHP echo $row2->name; ?></div></td> 
                      </tr> 
                    </table> 
                    <?php  } 
		
		else { 
			$previewimage->image = $row2->image ? $row2->image : 'administrator/components/com_swmenupro/images/blank.png';
			
			?> 
                    <table id="subtablepreview<?PHP echo $i; ?>"  cellpadding="0" cellspacing="0" border="0"> 
                      <tr> 
                        <td id="subpreview<?php echo $i; ?>" onmouseover="doSubPreviewOver(<?php echo $i; ?>)" onmouseout="doSubPreviewOut(<?php echo $i; ?>)" valign="top" align="left" ><img id = "imagepreview<?php echo $i; ?>"  src="<?PHP echo "../".$previewimage; ?>" align="<?PHP echo $row2->image_align; ?>"  cellpadding="0" cellspacing="0" border="0"> 
                          <div id="maindivpreview<?PHP echo $i; ?>"><?PHP echo $row2->name; ?></div></td> 
                      </tr> 
                    </table> 
                    <?php } ?> </td> 
                </tr> 
                <tr class="row<?PHP echo $k; ?>"> 
                  <td width="4%"  nowrap="nowrap" style="border-bottom:1px dashed #000000">&nbsp</td> 
                  <td width="4%"  nowrap="nowrap" style="border-bottom:1px dashed #000000">&nbsp</td> 
                  <td  width="20%"  style="border-bottom:1px dashed #000000">Image Align:
                    <?
	echo "<select id=\"imagealign".$i."\" name=\"imagealign[]\" onchange=\"doPreview(".$i.")\">\n";
	echo "<option ";
	if ($row2->image_align == 'left') {echo 'selected';} 
	echo " value=\"left\">Left</option >\n";
	echo "<option ";
	if ($row2->image_align == 'right') {echo 'selected';} 
	echo " value=\"right\">Right</option >\n";
	echo "</select >"; 
	
	?> </td> 
                  <td width="20%" style="border-bottom:1px dashed #000000"><div align="left"> 
                    <a href="#" onclick="ImageSelector.select('menuimage1<?PHP echo $i; ?>');">Edit Image
                    <?PHP if ($row2->image != null){
			echo "<img id=\"menuimage1".$i."\" name=\"menuimage1".$i."\" src=\"../".$row2->image."\" border = \"0\"></a>";
			echo "<input type =\"hidden\" id=\"menuimage1".$i."hidden\" name=\"menuimage1".$i."hidden\" value=\"".$row2->image."\" >";
		}else{
			echo "<img id=\"menuimage1".$i."\" name=\"menuimage1".$i."\" src=\"components/com_swmenupro/images/blank.png\" alt = \"no image\" border=\"0\"></a>";
			echo "<input type =\"hidden\" id=\"menuimage1".$i."hidden\" name=\"menuimage1".$i."hidden\" value=\"\" >";
		}
		?></td> 
                  <td width="20%" style="border-bottom:1px dashed #000000"><div align="left"> 
                    <a href="#" onclick="ImageSelector.select('menuimage2<?PHP echo $i; ?>');">Edit Over Image
                    <?PHP if ($row2->image_over != null){
			echo "<img id=\"menuimage2".$i."\" name=\"menuimage2".$i."\" src=\"../".$row2->image_over."\" border = \"0\"></a>";
			echo "<input type =\"hidden\" id=\"menuimage2".$i."hidden\" name=\"menuimage2".$i."hidden\" value=\"".$row2->image_over."\" >";
		}else{
			echo "<img id=\"menuimage2".$i."\" name=\"menuimage2".$i."\" src=\"components/com_swmenupro/images/blank.png\" alt = \"no image\" border=\"0\"></a>";
			echo "<input type =\"hidden\" id=\"menuimage2".$i."hidden\" name=\"menuimage2".$i."hidden\" value=\"\" >";
		}
		?> </td> 
                  <input type="hidden" id="isparent<?PHP echo $i; ?>" name="isparent[]" value="<?PHP echo $row2->parent; ?>" /> 
                  <input type="hidden" id="numchildren<?PHP echo $i; ?>" name="numchildren[]" value="<?PHP echo $row2->children; ?>" /> 
                  <input type="hidden" id="menuid<?PHP echo $i; ?>" name="menuid[]" value="<?PHP echo $row2->id; ?>" /> 
                  <input type="hidden" id="rowid<?PHP echo $i; ?>" name="rowid[]" value="<?PHP echo $row2->ext_id ? $row2->ext_id : 'null'; ?>" /> 
                </tr> 
                <?PHP 
			$k = 1 - $k;
     	     }
?> 
                <tr> 
                  <th align="center" colspan="6"> <?php echo $pageNav->writePagesLinks(); ?></th> 
                </tr> 
                <tr> 
                  <td align="center" colspan="6"> <?php echo $pageNav->writePagesCounter(); ?></td> 
                </tr> 
              </table> 
              </td> </tr><tr>
			  <td align="center"><span  style="color:#1166B0; font-size:14px; font-weight:'bold';font-family:'arial';">Important info about custom images and behaviours configuration</span></td></tr><tr>
			   <td align="left"><p>Changing the maximum number of levels or items to display with the dropdown boxes above in the right corner, will cause this page to reload and you will lose all unsaved changes.</p>
			   <p>
			   For best performance of this form, change the maximum number of levels and items to display before making any changes to the form.<br>
			   It is important to note that <B>SWmenuPro can not save changes to menu items not displayed on the custom images and behaviours configuration form.</B>  So if you want to apply changes to all top menu and sub menu items then set the Max Levels# and Display# to high values so that every menu item is visible on the form. If you only wante to change top menu items then set the Max Levels# value to 1</p>
			   <p> 
			   Use the <I><B>Auto menu item configuration utility</B></I> to quickly configure menu items.  Parent menu items are any menu item that has sub menus. Please note the <B>apply</B> button does not save changes, it applies the attributes to the selected items.  Always use the <B>Save</B> button to save changes.</p>
			   <p>
			   The preview should be used as a guide only, and might run quite slow or unpredictable on some computers. This in no way affects the speed or reliability of the menus on your sites front end. You can change the preview background color to the currently selected color on the color wheel picker by clicking the <I><b>'Change Background Color'</b></I> button.</p>
			   <p>
			   The <I><B>Is Link</B></I> behaviour alows you to effectively turn a menu items link off.  It will still react dynamically though by showing sub menus, but it will not reload the page when clicked on by a user.  This feature is very handy when developing menu structures that need placeholders to other pages but not necessarily a page for themselves.</p>
			   </td>
            </tr> 
          </table> 
        </div> 
		
		
		<div id="page5" class="pagetext"> 
          <table width="750px"> 
            <tr> 
              <td valign="top" align="center"> <table width="360px"  height = "170" class="adminForm"> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Border Widths </div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Main Menu Border Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "main_border_width" onChange="checkNumberSyntax('Main Menu Border Width','main_border_width',0,200,0); doMainBorder();" name = "main_border_width" type="text" value = "<?php echo $mainborder[0]; ?>" size="8"> 
                        px</div></td> 
                  </tr> 
                  <tr > 
                    <td>Main Menu Over Border Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "main_border_over_width" onChange="checkNumberSyntax('Main Menu Border Over Width','main_border_over_width',0,200,0); doMainBorder();" name = "main_border_over_width" type="text" value = "<?php echo $mainborderover[0]; ?>" size="8"> 
                        px</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Sub Menu Border Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "sub_border_width" onChange="checkNumberSyntax('Sub Menu Border Width','sub_border_width',0,200,0); doSubBorder();" name = "sub_border_width" type="text" value = "<?php echo $subborder[0]; ?>" size="8"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td>Sub Menu Over Border Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "sub_border_over_width" onChange="checkNumberSyntax('Sub Menu Border Over Width','sub_border_over_width',0,200,0); doSubBorder();" name = "sub_border_over_width" type="text" value = "<?php echo $subborderover[0]; ?>" size="8"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Special Effects - Opacity</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td >Sub Menu Opacity:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "specialA" onChange="checkNumberSyntax('Sub Menu Opacity','specialA',0,100,<?php echo $rows->specialA;?>);" name = "specialA" type="text" value = "<?php echo $rows->specialA;?>" size="8"> 
                        %&nbsp</div></td> 
                  </tr> 
                </table></td> 
              <td> <table width="360px"  height = "170" class="adminForm"> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Border Styles </div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Main Menu Border Style:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <select id = "main_border_style" onChange="doMainBorder();" name = "main_border_style" style="width:85px"> 
                          <option <?php if ($mainborder[1] == 'none') {echo 'selected';} ?> value = "none">none</option> 
                         
                          <option <?php if ($mainborder[1] == 'dotted') {echo 'selected';} ?> value = "dotted">dotted</option> 
                          <option <?php if ($mainborder[1] == 'dashed') {echo 'selected';} ?> value = "dashed">dashed</option> 
                          <option <?php if ($mainborder[1] == 'solid') {echo 'selected';} ?> value = "solid">solid</option> 
                          <option <?php if ($mainborder[1] == 'double') {echo 'selected';} ?> value = "double">double</option> 
                          <option <?php if ($mainborder[1] == 'groove') {echo 'selected';} ?> value = "groove">groove</option> 
                          <option <?php if ($mainborder[1] == 'ridge') {echo 'selected';} ?> value = "ridge">ridge</option> 
                          <option <?php if ($mainborder[1] == 'inset') {echo 'selected';} ?> value = "inset">inset</option> 
                          <option <?php if ($mainborder[1] == 'outset') {echo 'selected';} ?> value = "outset">outset</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr > 
                    <td>Main Menu Over Border Style:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <select id = "main_border_over_style" onChange="doMainBorder();" name = "main_border_over_style" style="width:85px"> 
                          <option <?php if ($mainborderover[1] == 'none') {echo 'selected';} ?> value = "none">none</option> 
                         
                          <option <?php if ($mainborderover[1] == 'dotted') {echo 'selected';} ?> value = "dotted">dotted</option> 
                          <option <?php if ($mainborderover[1] == 'dashed') {echo 'selected';} ?> value = "dashed">dashed</option> 
                          <option <?php if ($mainborderover[1] == 'solid') {echo 'selected';} ?> value = "solid">solid</option> 
                          <option <?php if ($mainborderover[1] == 'double') {echo 'selected';} ?> value = "double">double</option> 
                          <option <?php if ($mainborderover[1] == 'groove') {echo 'selected';} ?> value = "groove">groove</option> 
                          <option <?php if ($mainborderover[1] == 'ridge') {echo 'selected';} ?> value = "ridge">ridge</option> 
                          <option <?php if ($mainborderover[1] == 'inset') {echo 'selected';} ?> value = "inset">inset</option> 
                          <option <?php if ($mainborderover[1] == 'outset') {echo 'selected';} ?> value = "outset">outset</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr class="menubackgr" > 
                    <td>Sub Menu Border Style:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <select id = "sub_border_style" onChange="doSubBorder();" name = "sub_border_style" style="width:85px"> 
                          <option <?php if ($subborder[1] == 'none') {echo 'selected';} ?> value = "none">none</option> 
                          
                          <option <?php if ($subborder[1] == 'dotted') {echo 'selected';} ?> value = "dotted">dotted</option> 
                          <option <?php if ($subborder[1] == 'dashed') {echo 'selected';} ?> value = "dashed">dashed</option> 
                          <option <?php if ($subborder[1] == 'solid') {echo 'selected';} ?> value = "solid">solid</option> 
                          <option <?php if ($subborder[1] == 'double') {echo 'selected';} ?> value = "double">double</option> 
                          <option <?php if ($subborder[1] == 'groove') {echo 'selected';} ?> value = "groove">groove</option> 
                          <option <?php if ($subborder[1] == 'ridge') {echo 'selected';} ?> value = "ridge">ridge</option> 
                          <option <?php if ($subborder[1] == 'inset') {echo 'selected';} ?> value = "inset">inset</option> 
                          <option <?php if ($subborder[1] == 'outset') {echo 'selected';} ?> value = "outset">outset</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr > 
                    <td>Sub Menu Over Border Style:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <select id = "sub_border_over_style" onChange="doSubBorder();" name = "sub_border_over_style" style="width:85px"> 
                          <option <?php if ($subborderover[1] == 'none') {echo 'selected';} ?> value = "none">none</option> 
                          
                          <option <?php if ($subborderover[1] == 'dotted') {echo 'selected';} ?> value = "dotted">dotted</option> 
                          <option <?php if ($subborderover[1] == 'dashed') {echo 'selected';} ?> value = "dashed">dashed</option> 
                          <option <?php if ($subborderover[1] == 'solid') {echo 'selected';} ?> value = "solid">solid</option> 
                          <option <?php if ($subborderover[1] == 'double') {echo 'selected';} ?> value = "double">double</option> 
                          <option <?php if ($subborderover[1] == 'groove') {echo 'selected';} ?> value = "groove">groove</option> 
                          <option <?php if ($subborderover[1] == 'ridge') {echo 'selected';} ?> value = "ridge">ridge</option> 
                          <option <?php if ($subborderover[1] == 'inset') {echo 'selected';} ?> value = "inset">inset</option> 
                          <option <?php if ($subborderover[1] == 'outset') {echo 'selected';} ?> value = "outset">outset</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Special Effects - Delay</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td >Sub Menu Open/Close Delay:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "specialB" onChange="checkNumberSyntax('Sub Menu Open/Close Delay','specialB',0,3000,<?php echo $rows->specialB;?>);" name = "specialB" type="text" value = "<?php echo $rows->specialB;?>" size="8"> 
                        ms</div></td> 
                  </tr> 
                </table></td> 
            </tr> 
          </table> 
          <TABLE width="100%"> 
            <TR> 
              <TD align="center" valign="top"> <table width = "300" cellspacing="4"> 
                  <tr> 
                    <td align="center" valign="top"><img src="components/com_swmenupro/images/menu_border_top.gif" width="350" height="25" border = "0" hspace="0" vspace="0"></td> 
                  </tr> 
				 
                  <tr> 
                    <td align= "center" style="height:'20px';border:'1px dashed #000000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 1px Wide and Dashed</td> 
                  </tr> 
                  <tr> 
                   <td align= "center" style="height:'20px';border:'2px dashed #000000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 2px Wide and Dashed</td>  
                  </tr> 
                  <tr> 
                    <td align= "center" style="height:'20px';border:'1px solid #000000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 1px Wide and Solid</td> 
                  </tr> 
                  <tr> 
                   <td align= "center" style="height:'20px';border:'2px solid #000000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 2px Wide and Solid</td> 
                  </tr> 
                  <tr> 
                    <td align= "center" style="height:'20px';border:'2px dotted #669900'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 2px Wide and Dotted</td> 
                  </tr> 
                  <tr> 
                    <td align= "center" style="height:'20px';border:'4px inset #6633FF'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 4px Wide and Inset</td> 
                  </tr> 
                  <tr> 
                   <td align= "center" style="height:'20px';border:'4px double #339900'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 4px Wide and Double</td> 
                  </tr> 
                  <tr> 
                    <td align= "center" style="height:'30px';border:'4px ridge #FF0000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 4px Wide and Ridged</td> 
                  </tr> 
                </table> </TD> 
              <TD align="center" valign="top"><table><tr>
              <TD align="center" valign="top"> <img src = "components/com_swmenupro/images/additional_info_top.gif" width="350" height = "25" border = "0" hspace="0" vspace="0"> </TD> </tr><tr>
            
			<td cellpadding="5">
			 <p>All browsers render border styles and sizes differently. The table to the left shows how your browser has rendered the styles and sizes described.</p> 
			<p>Set border widths to '0' and style to 'none' to display no border.</p>
			<p><I><B>Sub menu opacity</B></I> only applies to the menu item in its normal state and not the mouse over position.</p>
			<p><I><B>Open/Close Delay</B></I> lets you set a delay period between sub menu items opening and closing and is measured in milliseconds.  That is 1000 milliseconds = 1 second.</p>
			
			</td>
			
			</tr></table> </TD> 
            </TR> 
          </TABLE> 
        </div> 
        <div id="page6" class="pagetext"> 
          <table width="750px" height = "320px"> 
            <tr> 
              <td valign="top"> <table width="300px" height = "320px" class="adminForm"> 
                  <tr> 
                    <td align="center"> <img src="components/com_swmenupro/images/swmenupro_box.gif" width="150" height="250"></td> 
                  </tr> 
                </table> 
              <td align="center" valign="top"><table width="420" height = "320px" class="adminForm" > 
                  <tr> 
                    <th ><div align="center" class="style1">Welcome to SWmenuPro</div></th> 
                  </tr> 
                  <td align="left" valign="top"><span  class="adminheader">Features:</span></td> 
                  </tr> <tr> 
                    <td> <p>  
                       <li>Unlimited menus on any page with seperate modules for each</li> 
					   <li>Three independent menu types with seperate configurations</li> 
					   <li>Advanced custom images and animations for each menu items</li> 
                       <li>Vertical or horizontal menu alignment(popout menu only)</li> 
 					   <li>Absolute or Relative positioning(popout and clickmenu only)</li> 
                       
                       <li>Advanced positioning of menu items through offsets</li> 
  
                       <li>Advanced dimensioning of menu item widths, heights and borders </li> 
  
                       <li>Advanced font administration including font families, sizes and weight</li> 
  
                       <li>Advanced color and background image assignment for top menus and sub menus</li> 
  
                       </p></td> 
                  </tr> 
                  <tr> 
                    <td align="center"><p> for support and info on upgrades please visit <a href="http://www.swonline.biz">www.swonline.biz</a> <br> 
                        <br> 
                        swmenupro is &copy;opyright 2004 <a href="http://www.swonline.biz">www.swonline.biz</a></p></td> 
                  </tr> 
                </table> 
            </tr> 
            </td> 
             </table> 
        </div> 
        <input type="hidden" id="main_padding" name="main_padding" value="<?PHP echo $rows->main_padding; ?>" /> 
        <input type="hidden" id="sub_padding" name="sub_padding" value="<?PHP echo $rows->sub_padding; ?>" /> 
        <input type="hidden" id="main_border" name="main_border" value="<?PHP echo $rows->main_border; ?>" /> 
        <input type="hidden" id="sub_border" name="sub_border" value="<?PHP echo $rows->sub_border; ?>" /> 
        <input type="hidden" id="main_border_over" name="main_border_over" value="<?PHP echo $rows->main_border_over; ?>" /> 
        <input type="hidden" id="sub_border_over" name="sub_border_over" value="<?PHP echo $rows->sub_border_over; ?>" /> 
        <input type="hidden" name="option" value="<?PHP echo $option; ?>" /> 
        <input type="hidden" name="pageID" value="tab4" /> 
        <input type="hidden" name="moduleID" value="<?PHP echo $moduleID; ?>" /> 
        <input type="hidden" name="cid[]" value="<?PHP echo $moduleID; ?>" /> 
        <input type="hidden" name="menutype" value="<?PHP echo $menutype; ?>" /> 
		<input type="hidden" name="menustyle" value="gosumenu" /> 
        <input type="hidden" name="task" value="editDhtmlMenu" /> 
        <input type="hidden" name="boxchecked" value="0" /> 
        <input type="hidden" name="id" value="<?php echo $moduleID; ?>"> 
    </form> 
    </td> 
  </tr> 
</table> 
<script language="javascript" type="text/javascript">

dhtml.cycleTab('<?php echo $pageID; ?>');

</script> 
</td> 
</tr> 

  </table> 
  <?php

}





function clickMenuConfig( $rows, $option , $id, $list, $menutype, $moduleID, $pageNav, $levellist, $pageID, $mainpadding, $subpadding, $mainborder, $subborder, $mainborderover, $subborderover, $modulename)
	{
?>
<script type="text/javascript" src="components/com_swmenupro/ImageManager/assets/dialog.js"></script>
<script type="text/javascript" src="components/com_swmenupro/ImageManager/IMEStandalone.js"></script>
<script type="text/javascript" src="components/com_swmenupro/js/swmenupro.js"></script>
<script type="text/javascript" src="components/com_swmenupro/js/preview.js"></script>
<script language="javascript" src="js/dhtml.js"></script>
<script language="javascript">

	
		function submitbutton(pressbutton) {

		doMainBorder();
		doSubBorder();

		submitform( pressbutton );
		}

function activatePreview(){
var counter = <?php echo count($list); ?>;
doMainBorder();
doSubBorder();

for(i=0;i<counter;i++)
			{
			doPreview(i);
			}
}

</script>
 <table cellpadding="4" cellspacing="4" border="0" width="750"> 
  <tr> 
     <td><a href="http://www.swonline.biz"> <img src="components/com_swmenupro/images/swmenupro_logo_small.gif" align="absmiddle" border="0"/> </a></td> 
     <td><span class="sectionname"><?php echo $modulename;?> Click Menu Configuration</span> </td> 
   </tr> 
</table> 
<table width="750" style="width='750px';" class="adminForm" align="center"> 
  <tr><td valign="top"> 
    <form action="index2.php" method="POST" name="adminForm"> <table width="100%"> 
      <tr><td align="center"> 
        <table cellpadding="3" cellspacing="0" border="0" width="750"> 
          <tr> 
            <td id="tab1" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Position Sizes & Offsets</td> 
            <td id="tab2" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Colors & Backgrounds</td> 
            <td id="tab3" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Fonts & Padding</td> 
            <td id="tab4" class="offtab" onclick="activatePreview(); dhtml.cycleTab(this.id)">Custom Images & Behaviours</td> 
            <td id="tab5" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Borders</td> 
            <td id="tab6" class="offtab" onclick="dhtml.cycleTab(this.id)">About SWmenuPro</td> 
          </tr> 
        </table> 
        <div id="page1" class="pagetext"> 
          <table width="750px"> 
            <tr> 
              <td valign="top" align="center"> <table width="360px" height = "180" class="adminForm"> 
			                                  
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Top Menu Item Sizes</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Top Menu Item Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu Elements Width','main_width',5,800,<?php echo $rows->main_width;?>);" size="8" id = "main_width" name = "main_width" value = "<?php echo $rows->main_width;?>" > 
                        px</div></td> 
                  </tr> 
                  <tr > 
                    <td>Top Menu Item Height:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "main_height"  onChange="checkNumberSyntax('Top Menu Elements Height','main_height',5,800,<?php echo $rows->main_height;?>);" name = "main_height" type="text" value = "<?php echo $rows->main_height;?>" size="8"> 
                        px</div></td> 
					<tr> 
                    <td colspan="2" class="tabheading"><div align="center">Sub Menu Item Sizes</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Sub Menu Item Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input type="text"  onChange="checkNumberSyntax('Sub Menu Elements Width','sub_width',5,800,<?php echo $rows->sub_width;?>);" size="8" id = "sub_width" name = "sub_width" value = "<?php echo $rows->sub_width;?>"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td>Sub Menu Item Height:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "sub_height"  onChange="checkNumberSyntax('Sub Menu Elements Height','sub_height',5,800,<?php echo $rows->sub_height;?>);" name = "sub_height" type="text" value = "<?php echo $rows->sub_height;?>" size="8"> 
                        px</div></td> 
                  </tr> 
				   <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Special Effects - Opacity</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td >Sub Menu Opacity:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "specialA" onChange="checkNumberSyntax('Sub Menu Opacity','specialA',0,100,<?php echo $rows->specialA;?>);" name = "specialA" type="text" value = "<?php echo $rows->specialA;?>" size="8"> 
                        %&nbsp</div></td> 
                  </tr> 
				  
                </table></td> 
              <td valign="top" align="center"> <table width = "360"  class="adminForm" > 
                   
                  <TR> 
              
              <TD align="center"> <img src = "components/com_swmenupro/images/clickmenu_dimensions.gif" width="350" height = "300" border = "0" hspace="0" vspace="0" align="center"> </TD> 
            </TR> 
				 
                </table></td> 
            </tr> 
          </table> 
         
        </div>
		


        <div id="page2" class="pagetext"> 
          <table width="750px"> 
            <tr><td valign="top" align="center"> 
              <table width="360px"  height = "250" class="adminForm"> 
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Background Images</div></td> 
                </tr> 
                <tr class="menubackgr" > 
                  <td>Top Menu Background:</td> 
                  <td colspan="2"><table id="main_back_image_box" style="border: 1px solid #000000; width:'100px'; height:'15px'" background="../<?php echo $rows->main_back_image;?>" align="left"> 
                      <tr> 
                        <td width="20" height="20">&nbsp</td> 
                      </tr> 
                    </table> 
                    <input type="button" name = "getimage" value = "GET" onclick="BackgroundSelector.select('main_back_image');"> 
                    <input type="hidden" id="main_back_image" name = "main_back_image" value = "<?php echo $rows->main_back_image;?>"> </td> 
                </tr> 
                <tr> 
                  <td>Top Menu Over Background:</td> 
                  <td colspan="2"><table id="main_back_image_over_box" style="border: 1px solid #000000; width:'100px'; height:'15px'" background="../<?php echo $rows->main_back_image_over;?>" align="left"> 
                      <tr> 
                        <td width="20" height="20">&nbsp</td> 
                      </tr> 
                    </table> 
                    <input type="button" name = "getimage" value = "GET" onclick="BackgroundSelector.select('main_back_image_over');"> 
                    <input type="hidden" id="main_back_image_over" name = "main_back_image_over" value = "<?php echo $rows->main_back_image_over;?>"> </td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Sub Menu Background:</td> 
                  <td colspan="2"><table id="sub_back_image_box" style="border: 1px solid #000000; width:'100px'; height:'15px'" background="../<?php echo $rows->sub_back_image;?>" align="left"> 
                      <tr> 
                        <td width="20" height="20">&nbsp</td> 
                      </tr> 
                    </table> 
                    <input type="button" name = "getimage" value = "GET" onclick="BackgroundSelector.select('sub_back_image');"> 
                    <input type="hidden" id="sub_back_image" name = "sub_back_image" value = "<?php echo $rows->sub_back_image;?>"> </td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Over Background:</td> 
                  <td colspan="2"><table id="sub_back_image_over_box" style="border: 1px solid #000000; width:'100px'; height:'15px'" background="../<?php echo $rows->sub_back_image_over;?>" align="left"> 
                      <tr> 
                        <td width="20" height="20">&nbsp</td> 
                      </tr> 
                    </table> 
                    <input type="button" name = "getimage" value = "GET" onclick="BackgroundSelector.select('sub_back_image_over');"> 
                    <input type="hidden" id="sub_back_image_over" name = "sub_back_image_over" value = "<?php echo $rows->sub_back_image_over;?>"> </td> 
                </tr> 
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Background Colors</div></td> 
                </tr> 
                <tr class="menubackgr" > 
                  <td>Top Menu Color:</td> 
                  <td > 
                  <table id="main_back_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_back;?>' > 
                    <tr> 
                      <td width="20" height="20">&nbsp</td>  
                    </tr> 
                    
                  </table> 
                </td> 
                 <td width="120" class="adminlist" > <div align="right"> 
                      <input type="text" onChange="checkColorSyntax('Main Menu Color','main_back','<?php echo $rows->main_back;?>');" size="8"  id="main_back" name = "main_back" value = "<?php echo $rows->main_back;?>"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_back');" > <img src="components/com_swmenupro/images/sel.gif">get</a> </div></td> 
                </tr> <tr> 
                  <td>Top Menu Over Color:</td> 
                  <td > 
                   <table id="main_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_over;?>'> 
                     <tr> 
                       <td width="20" height="20">&nbsp</td>  
                     </tr> 
                    
                   </table> 
                </td> 
                 <td width="120" class="adminlist"> <div align="right"> 
                      <input type="text" onChange="checkColorSyntax('Top Menu Over Color','main_over','<?php echo $rows->main_over;?>');" size="8"  id = "main_over" name = "main_over" value = "<?php echo $rows->main_over;?>"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_over');"><img src="components/com_swmenupro/images/sel.gif">get</a> </div></td> 
                </tr> <tr class="menubackgr"> 
                  <td>Sub Menu Color:</td> 
                  <td > 
                   <table id="sub_back_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->sub_back;?>'> 
                     <tr> 
                      <td width="20" height="20">&nbsp</td>  
                     </tr> 
                     
                   </table> 
                </td> 
                 <td width="120" class="adminlist"> <div align="right"> 
                      <input type="text" onChange="checkColorSyntax('Sub Menu Color','sub_back','<?php echo $rows->sub_back;?>');" size="8"  id = "sub_back" name = "sub_back" value = "<?php echo $rows->sub_back;?>"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_back');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> <tr> 
                  <td>Sub Menu Over Color:</td> 
                  <td > 
                   <table id="sub_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->sub_over;?>'> 
                     <tr> 
                       <td width="20" height="20">&nbsp</td>  
                     </tr> 
                     
                   </table> 
                  </td> 
                   <td width="120" class="adminlist"> <div align="right"> 
                       <input type="text" onChange="checkColorSyntax('Sub Menu Over Color','sub_over','<?php echo $rows->sub_over; ?>');" size="8" id = "sub_over" name = "sub_over" value = "<?php echo $rows->sub_over;?>"> 
                       <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
              </table> 
              </td> 
              <td valign="top"> 
              <table width = "360px"  height = "250" class="adminForm"> 
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Font Colors </div> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Top Menu Font Color:</td> 
                  <td > 
                  <table id="main_font_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_font_color;?>'> 
                    <tr> 
                     <td width="20" height="20">&nbsp</td>  
                    </tr> 
                   
                  </table> 
                </td> 
                 <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "main_font_color" onChange="checkColorSyntax('Top Menu Font Color','main_font_color','<?php echo $rows->main_font_color;?>');" type="text" id="main_font_color" value = "<?php echo $rows->main_font_color;?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_font_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> <tr> 
                  <td>Top Menu Over Font Color:</td> 
                  <td > 
                   <table id="main_font_color_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_font_color_over;?>'> 
                     <tr> 
                       <td width="20" height="20">&nbsp</td>  
                     </tr> 
                     
                   </table> 
                  </td> 
                   <td width="120" class="adminlist"> <div align="right"> 
                       <input name = "main_font_color_over" onChange="checkColorSyntax('Top Menu Over Font Color','main_font_color_over','<?php echo $rows->main_font_color_over;?>');" type="text" id="main_font_color_over" value = "<?php echo $rows->main_font_color_over;?>" size="8"> 
                       <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_font_color_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Sub Menu Font Color:</td> 
                  <td > 
                  <table id="sub_font_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->sub_font_color;?>'> 
                    <tr> 
                      <td width="20" height="20">&nbsp</td>  
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "sub_font_color" onChange="checkColorSyntax('Sub Menu Font Color','sub_font_color','<?php echo $rows->sub_font_color;?>');" type="text" id="sub_font_color" value = "<?php echo $rows->sub_font_color;?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_font_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Over Font Color:</td> 
                  <td > 
                  <table id="sub_font_color_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->sub_font_color_over;?>'> 
                    <tr> 
                      <td width="20" height="20">&nbsp</td>  
                    </tr> 
                    
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input name = "sub_font_color_over" onChange="checkColorSyntax('Sub Menu Over Font Color','sub_font_color_over','<?php echo $rows->sub_font_color_over;?>');" type="text" id="sub_font_color_over" value = "<?php echo $rows->sub_font_color_over;?>"  size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_font_color_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Border Colors</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Top Menu Border Color:</td> 
                  <td > 
                  <table id="main_border_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $mainborder[2];?>'> 
                    <tr> 
                       <td width="20" height="20">&nbsp</td>   
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "main_border_color" onChange="checkColorSyntax('Top Menu Border Color','main_border_color','<?php echo $mainborder[2];?>'); doMainBorder();" type="text" id="main_border_color" value = "<?php echo $mainborder[2];?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_border_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr > 
                  <td>Top Menu Over Border Color:</td> 
                  <td > 
                  <table id="main_border_color_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $mainborderover[2];?>'> 
                    <tr> 
                      <td width="20" height="20">&nbsp</td>  
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "main_border_color_over" onChange="checkColorSyntax('Top Menu Over Border Color','main_border_color_over','<?php echo $mainborderover[2];?>'); doMainBorder();" type="text" id="main_border_color_over" value = "<?php echo $mainborderover[2];?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_border_color_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Sub Menu Border Color:</td> 
                  <td > 
                  <table id="sub_border_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $subborder[2];?>'> 
                    <tr> 
                       <td width="20" height="20">&nbsp</td>   
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "sub_border_color" type="text" onChange="checkColorSyntax('Sub Menu Border Color','sub_border_color','<?php echo $subborder[2];?>'); doSubBorder();" id="sub_border_color" value = "<?php echo $subborder[2];?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_border_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Over Border Color:</td> 
                  <td > 
                  <table id="sub_border_color_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $subborderover[2];?>'> 
                    <tr> 
                       <td width="20" height="20">&nbsp</td>  
                    </tr> 
                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "sub_border_color_over" type="text" onChange="checkColorSyntax('Sub Menu Border Over Color','sub_border_color_over','<?php echo $subborderover[2];?>'); doSubBorder();" id="sub_border_color_over" value = "<?php echo $subborderover[2];?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('sub_border_color_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> 
              </table> 
              </td> 
            </tr> 
          </table> 
          <TABLE width="100%" valign="top"> 
            <TR> 
              <TD align="center"> <table width = "360px" height = "320px"  valign="top"> 
                  <tr> 
                    <td align="center" valign="top"><img src="components/com_swmenupro/images/color_wheel_top.gif" width="350" height="44"></td> 
                  </tr> 
                  <tr> 
                    <td> <table width = "320px" align="center"> 
                        <tr> 
                          <td id="CPCP_Wheel" ><img src="components/com_swmenupro/images/colorwheel.jpg" width="256" height="256"  onMouseMove="xyOff(event);" onClick="wrtVal();" border="1"></td> 
                          <td>&nbsp;</td> 
                          <td> <table border="0"> 
                              <tr> 
                                <td valign="TOP">Present Color:</td> 
                              </tr> 
                              <tr> 
                                <td id="CPCP_ColorCurrent" height="70"></td> 
                              </tr> 
                              <tr> 
                                <td id="CPCP_ColorSelected">&nbsp;</td> 
                              </tr> 
                              <tr> 
                                <td><br> 
                                  Selected Color:  
                              </tr> 
                              <tr> 
                                <td bgcolor="#FFFFFF" id="CPCP_Input" height="70"  >&nbsp;</td> 
                              <tr> 
                                <td><input name="TEXT" type="TEXT" id="CPCP_Input_RGB" value="#FFFFFF" size="8"></td> 
                              </tr> 
                            </table></td> 
                        </tr> 
                      </table></td> 
                  </tr> 
                </table></TD><td valign="top" align="center"> 
				<table><tr>
              <TD align="center" valign="top"> <img src = "components/com_swmenupro/images/additional_info_top.gif" width="350" height = "25" border = "0" hspace="0" vspace="0"> </TD> </tr><tr>
            
			<td cellpadding="5"><p>All colors should be a valid 6 digit hexadecimal color code with a preceding #. Use the provided color wheel or type values in manually.</p>
			<p>It is possible to set any color value to <B>transparent</B> by simply clearing the appropriate box.</p>
			<p>Background images are tiled across a menu item acording to size and height and will overlay the corresponding color value for the menu item.</p>
			<p>To make a <B>web button</B>, make your menu items size and width the same size and width as the backgound images being used for the normal and mouse over states.</p>
			
			</td>
			
			</tr></table>
			</td></TR> 
          </TABLE> 
        </div> 
        <div id="page3" class="pagetext"> 
          <table width="750px"> 
            <tr> 
              <td valign="top" align="center"> <table style="width:'360px'" width = "360px"  height = "210" class="adminForm"> 
                  <tr> 
                    <td colspan="2" class="tabheading"> <div align="center">Font Family</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td width="100">Top Menu:</td> 
                    <td  width="250" class="adminlist"> <div align="right"> 
                        <select name="font_family" id="font_family" style = "width:'250px'"> 
                          <option <?php if ($rows->font_family == 'Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Arial, Helvetica, sans-serif">Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->font_family == '\'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "'Times New Roman', Times, serif">'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->font_family == 'Georgia, \'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "Georgia, 'Times New Roman', Times, serif">Georgia,'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->font_family == 'Verdana, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Verdana, Arial, Helvetica, sans-serif">Verdana,Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->font_family == 'Geneva, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Geneva, Arial, Helvetica, sans-serif">Geneva,Arial,Helvetica,sans-serif</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr > 
                    <td>Sub Menu:</td> 
                    <td width="250"  class="adminlist"> <div align="right"> 
                        <select name="sub_font_family" id="sub_font_family"  style = "width:'250px'"> 
                          <option <?php if ($rows->sub_font_family == 'Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Arial, Helvetica, sans-serif">Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->sub_font_family == '\'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "'Times New Roman', Times, serif">'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->sub_font_family == 'Georgia, \'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "Georgia, 'Times New Roman', Times, serif">Georgia,'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->sub_font_family == 'Verdana, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Verdana, Arial, Helvetica, sans-serif">Verdana,Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->sub_font_family == 'Geneva, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Geneva, Arial, Helvetica, sans-serif">Geneva,Arial,Helvetica,sans-serif</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Top Menu Padding</div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="adminlist" align="center"> <TABLE> 
                        <TR class="menubackgr"> 
                          <TD width="75" align="center">Top</TD> 
                          <TD width="75" align="center">Right</TD> 
                          <TD width="75" align="center">Bottom</TD> 
                          <TD width="75" align="center">Left</TD> 
                        </TR> 
                        <TR> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Top Padding','main_pad_top',0,100,0); doMainPadding();" size="3" id = "main_pad_top" name = "main_pad_top" value = "<?php echo $mainpadding[0]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Right Padding','main_pad_right',0,100,0);doMainPadding();" size="3" id = "main_pad_right" name = "main_pad_right" value = "<?php echo $mainpadding[1]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Bottom Padding','main_pad_bottom',0,100,0);doMainPadding();" size="3" id = "main_pad_bottom" name = "main_pad_bottom" value = "<?php echo $mainpadding[2]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Left Padding','main_pad_left',0,100,0);doMainPadding();" size="3" id = "main_pad_left" name = "main_pad_left" value = "<?php echo $mainpadding[3]; ?>" maxlength="2"> 
                            px</TD> 
                        </TR> 
                      </TABLE></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Sub Menu Padding</div></td> 
                  </tr> 
                  <tr > 
                    <td colspan="2" class="adminlist" align="center"> <TABLE> 
                        <TR class="menubackgr"> 
                          <TD width="75" align="center">Top</TD> 
                          <TD width="75" align="center">Right</TD> 
                          <TD width="75" align="center">Bottom</TD> 
                          <TD width="75" align="center">Left</TD> 
                        </TR> 
                        <TR> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Top Padding','sub_pad_top',0,100,0);doSubPadding();" size="3" id = "sub_pad_top" name = "sub_pad_top" value = "<?php echo $subpadding[0]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Right Padding','sub_pad_right',0,100,0);doSubPadding(); " size="3" id = "sub_pad_right" name = "sub_pad_right" value = "<?php echo $subpadding[1]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Bottom Padding','sub_pad_bottom',0,100,0);doSubPadding(); " size="3" id = "sub_pad_bottom" name = "sub_pad_bottom" value = "<?php echo $subpadding[2]; ?>" maxlength="2">
						   px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Left Padding','sub_pad_left',0,100,0);doSubPadding(); " size="3" id = "sub_pad_left" name = "sub_pad_left" value = "<?php echo $subpadding[3]; ?>" maxlength="2"> 
                            px</TD> 
                        </TR> 
                      </TABLE></td> 
                  </tr> 
                </table></td> 
              <td valign="top"> 
              <table width = "360px" style="width:'360px'" height = "210"class="adminForm"> 
                <tr> 
                  <td colspan="2" class="tabheading"> <div align="center">Font Size</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Top Menu Font Size:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <input id = "main_font_size" onChange="checkNumberSyntax('Top Menu Font Size:','main_font_size',3,100,<?php echo $rows->main_font_size;?>);" name = "main_font_size" type="text"  value = "<?php echo $rows->main_font_size;?>" size="8"> 
                      px</div></td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Font Size:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <input  id = "sub_font_size" onChange="checkNumberSyntax('Sub Menu Font Size','sub_font_size',3,100,<?php echo $rows->sub_font_size;?>);" name = "sub_font_size" type="text" value = "<?php echo $rows->sub_font_size;?>" size="8"> 
                      px</div></td> 
                </tr> 
                <tr> 
                  <td colspan="2" class="tabheading"> <div align="center">Font Alignment</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Top Menu Text Alignment:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="main_align" id="main_align" onChange="doPreview();" style = "width:'100px'"> 
                        <option <?php if ($rows->main_align == 'left') {echo 'selected';} ?> value = "left">left</option> 
                        <option <?php if ($rows->main_align == 'right') {echo 'selected';} ?> value = "right">right</option> 
                        <option <?php if ($rows->main_align == 'center') {echo 'selected';} ?> value = "center">center</option> 
                      </select> 
                    </div></td> 
                </tr> 
                <tr> 
                  <td>Sub Menu Text Alignment:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="sub_align" id="sub_align" onChange="doPreview();" style = "width:'100px'" > 
                        <option <?php if ($rows->sub_align == 'left') {echo 'selected';} ?> value = "left">left</option> 
                        <option <?php if ($rows->sub_align == 'right') {echo 'selected';} ?> value = "right">right</option> 
                        <option <?php if ($rows->sub_align == 'center') {echo 'selected';} ?> value = "center">center</option> 
                      </select> 
                    </div></td> 
                </tr> 
                <tr> 
                  <td colspan="2" class="tabheading"> <div align="center">Font Weight</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Font Weight:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="font_weight" id="font_weight" onChange="doPreview();" style = "width:'100px'"> 
                        <option <?php if ($rows->font_weight == 'normal') {echo 'selected';} ?> value = "normal">normal</option> 
                        <option <?php if ($rows->font_weight == 'bold') {echo 'selected';} ?> value = "bold">bold</option> 
                        <option <?php if ($rows->font_weight == 'bolder') {echo 'selected';} ?> value = "bolder">bolder</option> 
                        <option <?php if ($rows->font_weight == 'lighter') {echo 'selected';} ?> value = "lighter">lighter</option> 
                      </select> 
                    </div></td> 
                </tr> 
                <tr> 
                  <td>Font Weight Over:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="font_weight_over" id="font_weight_over" onChange="doPreview();" style = "width:'100px'"> 
                        <option <?php if ($rows->font_weight_over == 'normal') {echo 'selected';} ?> value = "normal">normal</option> 
                        <option <?php if ($rows->font_weight_over == 'bold') {echo 'selected';} ?> value = "bold">bold</option> 
                        <option <?php if ($rows->font_weight_over == 'bolder') {echo 'selected';} ?> value = "bolder">bolder</option> 
                        <option <?php if ($rows->font_weight_over == 'lighter') {echo 'selected';} ?> value = "lighter">lighter</option> 
                      </select> 
                    </div></td> 
                </tr> 
                <tr> </tr> 
                </td> 
                 </table> 
              </td> 
            </tr> 
          </table> 
          <TABLE width="100%" align="center"> 
            <TR> 
              <TD align="center" valign="top"> <table width = "360" > 
                  <tr> 
                    <td align="center" valign="top"><img src="components/com_swmenupro/images/menu_fonts_top.gif" width="350" height="25"></td> 
                  </tr> 
				  <tr> 
                    <td align= "center">All browsers render fonts and sizes differently.  The list below shows how your browser has rendered the fonts and sizes described.<br> </td> 
                  </tr> 
                  <tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:10px; font-weight:'normal';font-family:''Times New Roman', Times, serif';">'Times New Roman', Times, serif normal at 10px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:10px; font-weight:'bold';font-family:'Verdana,Arial,Helvetica,sans-serif';">Verdana,Arial,Helvetica,sans-serif Bold at 10px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:12px; font-weight:'normal';font-family:'Arial,Helvetica,sans-serif';">Arial,Helvetica,sans-serif Normal at 12px</span> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center" valign="top"><span  style="color:#1166B0; font-size:12px; font-weight:'normal';font-family:'Georgia, 'Times New Roman', Times, serif';">Georgia, 'Times New Roman', Times, serif Normal at 12px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:12px; font-weight:'bold';font-family:Geneva,Arial,Helvetica,sans-serif';">'Geneva,Arial,Helvetica,sans-serif Bold at 12px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'normal';font-family:''Times New Roman', Times, serif';">'Times New Roman', Times, serif normal at 14px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'bold';font-family:'Verdana,Arial,Helvetica,sans-serif';">Verdana,Arial,Helvetica,sans-serif Bold at 14px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'bold';font-family:'Arial,Helvetica,sans-serif';">Arial,Helvetica,sans-serif Bold at 14px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'normal';font-family:'Geneva,Arial,Helvetica,sans-serif';">Geneva,Arial,Helvetica,sans-serif Normal at 14px</span><br> </td> 
                  </tr> 
                </table></TD> 
              <TD align="center"> <img src = "components/com_swmenupro/images/menu_padding.gif" width="350" height = "274" border = "0" hspace="0" vspace="0"> </TD> 
            </TR> 
          </TABLE> 
        </div> 
        <div id="page4" class="pagetext"> 
          <table width="750px"> 
            <tr><td valign="top"> 
              <table cellpadding="4" cellspacing="0" border="0" width="100%"> 
                <tr> 
                  <th width="80%">Auto Menu Item Configuration Utility</th> 
                  <th nowrap="nowrap" align="right">Max Levels</th> 
                  <th><?php echo $levellist;?></th> 
                  <th nowrap="nowrap">Display #</th> 
                  <th><?php $pageNav->writeLimitBox();?></th> 
                </tr> 
              </table> 
              <table> 
                <tr> 
                  <td><b>Step 1. Select Items</b></td> 
                  <td><b>Step 2. Select Attribute</b></td> 
                  <td align="center"><b>Image Preview</b></td> 
                  <td align="center"><b>Step 3. Press Apply</b></td> 
                </tr> 
                <tr> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="autoassign" id="autoassign" style = "width:'200px'"> 
                        <option  value = "">Please Select..</option> 
                        <option  value = "selected">Selected Menu Items</option> 
                        <option  value = "all">All Menu Items</option> 
                        <option  value = "main">Top Menu Items</option> 
                        <option  value = "sub">Sub Menu Items</option> 
                        <option  value = "parent">Parent Menu Items</option> 
                      </select> 
                    </div></td> 
                  <td width="100"> <select name="autoattrib" onchange="doImageChange();" id="autoattrib" style = "width:'200px'"> 
                      <option  value = "">Please Select..</option> 
                      <option  value = "image1">Image</option> 
                      <option  value = "image2">Image Over</option> 
                      <option  value = "showname">Show name</option> 
                      <option  value = "dontshowname">Do Not Show Name</option> 
                      <option  value = "imageleft">Image Align Left</option> 
                      <option  value = "imageright">Image Align Right</option> 
                      <option  value = "islink">Is A Link</option> 
                      <option  value = "isnotlink">Is Not a Link</option> 
                    </select> </td> 
                  <td width="150" align="center"> <img id="globalimage" name="globalimag0" src="components/com_swmenupro/images/blank.png" border = "0"></td> 
                  <input type ="hidden" id="globalimagehidden" name="globalimagehidden" value="" > 
                </td> 
                 <td nowrap="nowrap" align="center"><input type="button" onClick="doAutoAssign(<?php echo count($list); ?>)" value = "apply"></td> 
                </tr> </table> 
              <table cellpadding="4" cellspacing="0" border="0" width="100%"> 
                <tr> 
                  <th nowrap="nowrap" width="500px">Individual Menu Item Configuration</th> 
                  <th  >Preview</th> 
                  <th align="center"><a onMouseOver="this.style.cursor='pointer'" onClick="changePreviewColor(<?php echo count($list); ?>);"><img src="components/com_swmenupro/images/sel.gif">Change Background Color</a></th> 
                </tr> 
              </table> 
              <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminList"> 
                <?
    $k = 0;
    for ($i=0, $n=count($list); $i < $n; $i++) 
    {
    	$row2 = &$list[$i];
        if ($row2->show_name == null){$row2->show_name = 1;}
		if ($row2->target_level == null){$row2->target_level = 1;}
		if ($row2->image_align == null){$row2->image_align = 'left';}
		$img = $row2->show_name ? 'tick.png' : 'publish_x.png';
		$img2 = $row2->target_level ? 'tick.png' : 'publish_x.png';
		
       
	?> 
                <tr class="row<?PHP echo $k; ?>"> 
                  <td width="4%" nowrap="nowrap"><?php echo $i+$pageNav->limitstart+1;?></td> 
                  <td width="4%"  nowrap="nowrap"><input type="checkbox" id="cb<?PHP echo $i; ?>" name="checkid[]" value="<?PHP echo $i; ?>" onclick="isChecked(this.checked);" /></td> 
                  <td width="20%"  nowrap="nowrap"><b><?PHP echo $row2->treename; ?></b></td> 
                  <td width="20%"  nowrap="nowrap"><a  onmouseover="this.style.cursor='pointer'" onclick="swapValue('showname<?PHP echo $i."',".$i; ?>);">Show Name
                    <?PHP
			echo "<img id=\"showname".$i."image\" name=\"showname".$i."image\" src=\"images/".$img."\" border = \"0\"></a>";
			echo "<input type =\"hidden\" id=\"showname".$i."\" name=\"showname[]\" value=\"".$row2->show_name."\" >";
	?></td> 
                  <td width="20%" nowrap="nowrap"><a  onmouseover="this.style.cursor='pointer'" onclick="swapValue('targetlevel<?PHP echo $i."',".$i; ?>);">Is Link
                    <?PHP
			echo "<img id=\"targetlevel".$i."image\" name=\"targetlevel".$i."image\" src=\"images/".$img2."\" border = \"0\"></a>";
			echo "<input type =\"hidden\" id=\"targetlevel".$i."\" name=\"targetlevel[]\" value=\"".$row2->target_level."\" >";
	?></td> 
                  <td  id="preview_back<?PHP echo $i; ?>" rowspan="2" align="center" style="border-bottom:1px dashed #000000" > <?php 
		
	
	if($row2->parent == '0'){
		$previewimage->image = $row2->image ? $row2->image : 'administrator/components/com_swmenupro/images/blank.png';;

		?> 
                    <table id="maintablepreview<?PHP echo $i; ?>" cellpadding="0" cellspacing="0" border="0"> 
                      <tr> 
                        <td id="mainpreview<?php echo $i; ?>"   onmouseover="doMainPreviewOver(<?php echo $i; ?>)" onmouseout="doMainPreviewOut(<?php echo $i; ?>)" valign="top" align="left" ><img id = "imagepreview<?php echo $i; ?>" src="<?PHP echo "../".$previewimage; ?>" align="<?PHP echo $row2->image_align; ?>" cellpadding="0" cellspacing="0" border="0" > 
                          <div id="maindivpreview<?PHP echo $i; ?>" ><?PHP echo $row2->name; ?></div></td> 
                      </tr> 
                    </table> 
                    <?php  } 
		
		else { 
			$previewimage->image = $row2->image ? $row2->image : 'administrator/components/com_swmenupro/images/blank.png';
			
			?> 
                    <table id="subtablepreview<?PHP echo $i; ?>"  cellpadding="0" cellspacing="0" border="0"> 
                      <tr> 
                        <td id="subpreview<?php echo $i; ?>" onmouseover="doSubPreviewOver(<?php echo $i; ?>)" onmouseout="doSubPreviewOut(<?php echo $i; ?>)" valign="top" align="left" ><img id = "imagepreview<?php echo $i; ?>"  src="<?PHP echo "../".$previewimage; ?>" align="<?PHP echo $row2->image_align; ?>"  cellpadding="0" cellspacing="0" border="0"> 
                          <div id="maindivpreview<?PHP echo $i; ?>"><?PHP echo $row2->name; ?></div></td> 
                      </tr> 
                    </table> 
                    <?php } ?> </td> 
                </tr> 
                <tr class="row<?PHP echo $k; ?>"> 
                  <td width="4%"  nowrap="nowrap" style="border-bottom:1px dashed #000000">&nbsp</td> 
                  <td width="4%"  nowrap="nowrap" style="border-bottom:1px dashed #000000">&nbsp</td> 
                  <td  width="20%"  style="border-bottom:1px dashed #000000">Image Align:
                    <?
	echo "<select id=\"imagealign".$i."\" name=\"imagealign[]\" onchange=\"doPreview(".$i.")\">\n";
	echo "<option ";
	if ($row2->image_align == 'left') {echo 'selected';} 
	echo " value=\"left\">Left</option >\n";
	echo "<option ";
	if ($row2->image_align == 'right') {echo 'selected';} 
	echo " value=\"right\">Right</option >\n";
	echo "</select >"; 
	
	?> </td> 
                  <td width="20%" style="border-bottom:1px dashed #000000"><div align="left"> 
                    <a href="#" onclick="ImageSelector.select('menuimage1<?PHP echo $i; ?>');">Edit Image
                    <?PHP if ($row2->image != null){
			echo "<img id=\"menuimage1".$i."\" name=\"menuimage1".$i."\" src=\"../".$row2->image."\" border = \"0\"></a>";
			echo "<input type =\"hidden\" id=\"menuimage1".$i."hidden\" name=\"menuimage1".$i."hidden\" value=\"".$row2->image."\" >";
		}else{
			echo "<img id=\"menuimage1".$i."\" name=\"menuimage1".$i."\" src=\"components/com_swmenupro/images/blank.png\" alt = \"no image\" border=\"0\"></a>";
			echo "<input type =\"hidden\" id=\"menuimage1".$i."hidden\" name=\"menuimage1".$i."hidden\" value=\"\" >";
		}
		?></td> 
                  <td width="20%" style="border-bottom:1px dashed #000000"><div align="left"> 
                    <a href="#" onclick="ImageSelector.select('menuimage2<?PHP echo $i; ?>');">Edit Over Image
                    <?PHP if ($row2->image_over != null){
			echo "<img id=\"menuimage2".$i."\" name=\"menuimage2".$i."\" src=\"../".$row2->image_over."\" border = \"0\"></a>";
			echo "<input type =\"hidden\" id=\"menuimage2".$i."hidden\" name=\"menuimage2".$i."hidden\" value=\"".$row2->image_over."\" >";
		}else{
			echo "<img id=\"menuimage2".$i."\" name=\"menuimage2".$i."\" src=\"components/com_swmenupro/images/blank.png\" alt = \"no image\" border=\"0\"></a>";
			echo "<input type =\"hidden\" id=\"menuimage2".$i."hidden\" name=\"menuimage2".$i."hidden\" value=\"\" >";
		}
		?> </td> 
                  <input type="hidden" id="isparent<?PHP echo $i; ?>" name="isparent[]" value="<?PHP echo $row2->parent; ?>" /> 
                  <input type="hidden" id="numchildren<?PHP echo $i; ?>" name="numchildren[]" value="<?PHP echo $row2->children; ?>" /> 
                  <input type="hidden" id="menuid<?PHP echo $i; ?>" name="menuid[]" value="<?PHP echo $row2->id; ?>" /> 
                  <input type="hidden" id="rowid<?PHP echo $i; ?>" name="rowid[]" value="<?PHP echo $row2->ext_id ? $row2->ext_id : 'null'; ?>" /> 
                </tr> 
                <?PHP 
			$k = 1 - $k;
     	     }
?> 
                <tr> 
                  <th align="center" colspan="6"> <?php echo $pageNav->writePagesLinks(); ?></th> 
                </tr> 
                <tr> 
                  <td align="center" colspan="6"> <?php echo $pageNav->writePagesCounter(); ?></td> 
                </tr> 
              </table> 
              </td> </tr><tr>
			  <td align="center"><span  style="color:#1166B0; font-size:14px; font-weight:'bold';font-family:'arial';">Important info about custom images and behaviours configuration</span></td></tr><tr>
			   <td align="left"><p>Changing the maximum number of levels or items to display with the dropdown boxes above in the right corner, will cause this page to reload and you will lose all unsaved changes.</p>
			   <p>
			   For best performance of this form, change the maximum number of levels and items to display before making any changes to the form.<br>
			   It is important to note that <B>SWmenuPro can not save changes to menu items not displayed on the custom images and behaviours configuration form.</B>  So if you want to apply changes to all top menu and sub menu items then set the Max Levels# and Display# to high values so that every menu item is visible on the form. If you only wante to change top menu items then set the Max Levels# value to 1</p>
			   <p> 
			   Use the <I><B>Auto menu item configuration utility</B></I> to quickly configure menu items.  Parent menu items are any menu item that has sub menus. Please note the <B>apply</B> button does not save changes, it applies the attributes to the selected items.  Always use the <B>Save</B> button to save changes.</p>
			   <p>
			   The preview should be used as a guide only, and might run quite slow or unpredictable on some computers. This in no way affects the speed or reliability of the menus on your sites front end. You can change the preview background color to the currently selected color on the color wheel picker by clicking the <I><b>'Change Background Color'</b></I> button.</p>
			   <p>
			   The <I><B>Is Link</B></I> behaviour alows you to effectively turn a menu items link off.  It will still react dynamically though by showing sub menus, but it will not reload the page when clicked on by a user.  This feature is very handy when developing menu structures that need placeholders to other pages but not necessarily a page for themselves.</p>
			   </td>
            </tr> 
          </table> 
        </div> 
        <div id="page5" class="pagetext"> 
          <table width="750px"> 
            <tr> 
              <td valign="top" align="center"> <table width="360px"  height = "120" class="adminForm"> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Border Widths </div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Main Menu Border Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "main_border_width" onChange="checkNumberSyntax('Main Menu Border Width','main_border_width',0,200,0); doMainBorder();" name = "main_border_width" type="text" value = "<?php echo $mainborder[0]; ?>" size="8"> 
                        px</div></td> 
                  </tr> 
                  <tr > 
                    <td>Main Menu Over Border Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "main_border_over_width" onChange="checkNumberSyntax('Main Menu Border Over Width','main_border_over_width',0,200,0); doMainBorder();" name = "main_border_over_width" type="text" value = "<?php echo $mainborderover[0]; ?>" size="8"> 
                        px</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Sub Menu Border Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "sub_border_width" onChange="checkNumberSyntax('Sub Menu Border Width','sub_border_width',0,200,0); doSubBorder();" name = "sub_border_width" type="text" value = "<?php echo $subborder[0]; ?>" size="8"> 
                        px</div></td> 
                  </tr> 
                  <tr> 
                    <td>Sub Menu Over Border Width:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <input id = "sub_border_over_width" onChange="checkNumberSyntax('Sub Menu Border Over Width','sub_border_over_width',0,200,0); doSubBorder();" name = "sub_border_over_width" type="text" value = "<?php echo $subborderover[0]; ?>" size="8"> 
                        px</div></td> 
                  </tr> 
                  
                </table></td> 
              <td> <table width="360px"  height = "120" class="adminForm"> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Border Styles </div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Main Menu Border Style:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <select id = "main_border_style" onChange="doMainBorder();" name = "main_border_style" style="width:85px"> 
                          <option <?php if ($mainborder[1] == 'none') {echo 'selected';} ?> value = "none">none</option> 
                         
                          <option <?php if ($mainborder[1] == 'dotted') {echo 'selected';} ?> value = "dotted">dotted</option> 
                          <option <?php if ($mainborder[1] == 'dashed') {echo 'selected';} ?> value = "dashed">dashed</option> 
                          <option <?php if ($mainborder[1] == 'solid') {echo 'selected';} ?> value = "solid">solid</option> 
                          <option <?php if ($mainborder[1] == 'double') {echo 'selected';} ?> value = "double">double</option> 
                          <option <?php if ($mainborder[1] == 'groove') {echo 'selected';} ?> value = "groove">groove</option> 
                          <option <?php if ($mainborder[1] == 'ridge') {echo 'selected';} ?> value = "ridge">ridge</option> 
                          <option <?php if ($mainborder[1] == 'inset') {echo 'selected';} ?> value = "inset">inset</option> 
                          <option <?php if ($mainborder[1] == 'outset') {echo 'selected';} ?> value = "outset">outset</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr > 
                    <td>Main Menu Over Border Style:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <select id = "main_border_over_style" onChange="doMainBorder();" name = "main_border_over_style" style="width:85px"> 
                          <option <?php if ($mainborderover[1] == 'none') {echo 'selected';} ?> value = "none">none</option> 
                         
                          <option <?php if ($mainborderover[1] == 'dotted') {echo 'selected';} ?> value = "dotted">dotted</option> 
                          <option <?php if ($mainborderover[1] == 'dashed') {echo 'selected';} ?> value = "dashed">dashed</option> 
                          <option <?php if ($mainborderover[1] == 'solid') {echo 'selected';} ?> value = "solid">solid</option> 
                          <option <?php if ($mainborderover[1] == 'double') {echo 'selected';} ?> value = "double">double</option> 
                          <option <?php if ($mainborderover[1] == 'groove') {echo 'selected';} ?> value = "groove">groove</option> 
                          <option <?php if ($mainborderover[1] == 'ridge') {echo 'selected';} ?> value = "ridge">ridge</option> 
                          <option <?php if ($mainborderover[1] == 'inset') {echo 'selected';} ?> value = "inset">inset</option> 
                          <option <?php if ($mainborderover[1] == 'outset') {echo 'selected';} ?> value = "outset">outset</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr class="menubackgr" > 
                    <td>Sub Menu Border Style:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <select id = "sub_border_style" onChange="doSubBorder();" name = "sub_border_style" style="width:85px"> 
                          <option <?php if ($subborder[1] == 'none') {echo 'selected';} ?> value = "none">none</option> 
                          
                          <option <?php if ($subborder[1] == 'dotted') {echo 'selected';} ?> value = "dotted">dotted</option> 
                          <option <?php if ($subborder[1] == 'dashed') {echo 'selected';} ?> value = "dashed">dashed</option> 
                          <option <?php if ($subborder[1] == 'solid') {echo 'selected';} ?> value = "solid">solid</option> 
                          <option <?php if ($subborder[1] == 'double') {echo 'selected';} ?> value = "double">double</option> 
                          <option <?php if ($subborder[1] == 'groove') {echo 'selected';} ?> value = "groove">groove</option> 
                          <option <?php if ($subborder[1] == 'ridge') {echo 'selected';} ?> value = "ridge">ridge</option> 
                          <option <?php if ($subborder[1] == 'inset') {echo 'selected';} ?> value = "inset">inset</option> 
                          <option <?php if ($subborder[1] == 'outset') {echo 'selected';} ?> value = "outset">outset</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                  <tr > 
                    <td>Sub Menu Over Border Style:</td> 
                    <td width="120" class="adminlist"> <div align="right"> 
                        <select id = "sub_border_over_style" onChange="doSubBorder();" name = "sub_border_over_style" style="width:85px"> 
                          <option <?php if ($subborderover[1] == 'none') {echo 'selected';} ?> value = "none">none</option> 
                          
                          <option <?php if ($subborderover[1] == 'dotted') {echo 'selected';} ?> value = "dotted">dotted</option> 
                          <option <?php if ($subborderover[1] == 'dashed') {echo 'selected';} ?> value = "dashed">dashed</option> 
                          <option <?php if ($subborderover[1] == 'solid') {echo 'selected';} ?> value = "solid">solid</option> 
                          <option <?php if ($subborderover[1] == 'double') {echo 'selected';} ?> value = "double">double</option> 
                          <option <?php if ($subborderover[1] == 'groove') {echo 'selected';} ?> value = "groove">groove</option> 
                          <option <?php if ($subborderover[1] == 'ridge') {echo 'selected';} ?> value = "ridge">ridge</option> 
                          <option <?php if ($subborderover[1] == 'inset') {echo 'selected';} ?> value = "inset">inset</option> 
                          <option <?php if ($subborderover[1] == 'outset') {echo 'selected';} ?> value = "outset">outset</option> 
                        </select> 
                      </div></td> 
                  </tr> 
                 
                </table></td> 
            </tr> 
          </table> 
          <TABLE width="100%"> 
            <TR> 
              <TD align="center" valign="top"> <table width = "300" cellspacing="4"> 
                  <tr> 
                    <td align="center" valign="top"><img src="components/com_swmenupro/images/menu_border_top.gif" width="350" height="25" border = "0" hspace="0" vspace="0"></td> 
                  </tr> 
				 
                  <tr> 
                    <td align= "center" style="height:'20px';border:'1px dashed #000000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 1px Wide and Dashed</td> 
                  </tr> 
                  <tr> 
                   <td align= "center" style="height:'20px';border:'2px dashed #000000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 2px Wide and Dashed</td>  
                  </tr> 
                  <tr> 
                    <td align= "center" style="height:'20px';border:'1px solid #000000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 1px Wide and Solid</td> 
                  </tr> 
                  <tr> 
                   <td align= "center" style="height:'20px';border:'2px solid #000000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 2px Wide and Solid</td> 
                  </tr> 
                  <tr> 
                    <td align= "center" style="height:'20px';border:'2px dotted #669900'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 2px Wide and Dotted</td> 
                  </tr> 
                  <tr> 
                    <td align= "center" style="height:'20px';border:'4px inset #6633FF'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 4px Wide and Inset</td> 
                  </tr> 
                  <tr> 
                   <td align= "center" style="height:'20px';border:'4px double #339900'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 4px Wide and Double</td> 
                  </tr> 
                  <tr> 
                    <td align= "center" style="height:'30px';border:'4px ridge #FF0000'; background-color:'#3399FF'; color:'#FFFFFF'; font-weight:'bold'">This Border is 4px Wide and Ridged</td> 
                  </tr> 
                </table> </TD> 
              <TD align="center" valign="top"><table><tr>
              <TD align="center" valign="top"> <img src = "components/com_swmenupro/images/additional_info_top.gif" width="350" height = "25" border = "0" hspace="0" vspace="0"> </TD> </tr><tr>
            
			<td cellpadding="5">
			 <p>All browsers render border styles and sizes differently. The table to the left shows how your browser has rendered the styles and sizes described.</p> 
			<p>Set border widths to '0' and style to 'none' to display no border.</p>
			
			</td>
			
			</tr></table> </TD> 
            </TR> 
          </TABLE> 
        </div> 
        <div id="page6" class="pagetext"> 
          <table width="750px" height = "320px"> 
            <tr> 
              <td valign="top"> <table width="300px" height = "320px" class="adminForm"> 
                  <tr> 
                    <td align="center"> <img src="components/com_swmenupro/images/swmenupro_box.gif" width="150" height="250"></td> 
                  </tr> 
                </table> 
              <td align="center" valign="top"><table width="420" height = "320px" class="adminForm" > 
                  <tr> 
                    <th ><div align="center" class="style1">Welcome to SWmenuPro</div></th> 
                  </tr> 
                  <td align="left" valign="top"><span  class="adminheader">Features:</span></td> 
                  </tr> <tr> 
                    <td> <p>  
                       <li>Unlimited menus on any page with seperate modules for each</li> 
					   <li>Three independent menu types with seperate configurations</li> 
					   <li>Advanced custom images and animations for each menu items</li> 
                       <li>Vertical or horizontal menu alignment(popout menu only)</li> 
 					   <li>Absolute or Relative positioning(popout and clickmenu only)</li> 
                       
                       <li>Advanced positioning of menu items through offsets</li> 
  
                       <li>Advanced dimensioning of menu item widths, heights and borders </li> 
  
                       <li>Advanced font administration including font families, sizes and weight</li> 
  
                       <li>Advanced color and background image assignment for top menus and sub menus</li> 
  
                       </p></td> 
                  </tr> 
                  <tr> 
                    <td align="center"><p> for support and info on upgrades please visit <a href="http://www.swonline.biz">www.swonline.biz</a> <br> 
                        <br> 
                        swmenupro is &copy;opyright 2004 <a href="http://www.swonline.biz">www.swonline.biz</a></p></td> 
                  </tr> 
                </table> 
            </tr> 
            </td> 
             </table> 
        </div> 
		
		<input id = "specialB" name = "specialB" type="hidden" value = "<?php echo $rows->specialB;?>"> 
        <input type="hidden" id="main_padding" name="main_padding" value="<?PHP echo $rows->main_padding; ?>" /> 
        <input type="hidden" id="sub_padding" name="sub_padding" value="<?PHP echo $rows->sub_padding; ?>" /> 
        <input type="hidden" id="main_border" name="main_border" value="<?PHP echo $rows->main_border; ?>" /> 
        <input type="hidden" id="sub_border" name="sub_border" value="<?PHP echo $rows->sub_border; ?>" /> 
        <input type="hidden" id="main_border_over" name="main_border_over" value="<?PHP echo $rows->main_border_over; ?>" /> 
        <input type="hidden" id="sub_border_over" name="sub_border_over" value="<?PHP echo $rows->sub_border_over; ?>" /> 
        <input type="hidden" name="option" value="<?PHP echo $option; ?>" /> 
        <input type="hidden" name="pageID" value="tab4" /> 
        <input type="hidden" name="moduleID" value="<?PHP echo $moduleID; ?>" /> 
        <input type="hidden" name="cid[]" value="<?PHP echo $moduleID; ?>" /> 
        <input type="hidden" name="menutype" value="<?PHP echo $menutype; ?>" /> 
		<input type="hidden" name="menustyle" value="clickmenu" /> 
        <input type="hidden" name="task" value="editDhtmlMenu" /> 
        <input type="hidden" name="boxchecked" value="0" /> 
        <input type="hidden" name="id" value="<?php echo $moduleID; ?>"> 
    </form> 
    </td> 
  </tr> 
</table> 
<script language="javascript" type="text/javascript">
		  

activatePreview();
dhtml.cycleTab('<?php echo $pageID; ?>');

</script> 
</td> 
</tr> 

  </table> 
  <?php

}






function treeMenuConfig( $rows, $option , $id, $list, $menutype, $moduleID, $pageNav, $levellist, $pageID, $mainpadding, $subpadding, $mainborder, $subborder, $mainborderover, $subborderover, $modulename)
	{
?>
<script type="text/javascript" src="components/com_swmenupro/ImageManager/assets/dialog.js"></script>
<script type="text/javascript" src="components/com_swmenupro/ImageManager/IMEStandalone.js"></script>
<script type="text/javascript" src="components/com_swmenupro/js/swmenupro.js"></script>
<script language="javascript" src="js/dhtml.js"></script>
<script language="javascript">

	
		function submitbutton(pressbutton) {

		

		submitform( pressbutton );
		}



</script>
 <table cellpadding="4" cellspacing="4" border="0" width="750"> 
  <tr> 
     <td><a href="http://www.swonline.biz"> <img src="components/com_swmenupro/images/swmenupro_logo_small.gif" align="absmiddle" border="0"/> </a></td> 
     <td><span class="sectionname"><?php echo $modulename;?> Tree Menu Configuration</span> </td> 
   </tr> 
</table> 
<table width="750" style="width='750px';" class="adminForm" align="center"> 
  <tr><td valign="top"> 
    <form action="index2.php" method="POST" name="adminForm"> <table width="100%"> 
      <tr><td align="center"> 
        <table cellpadding="3" cellspacing="0" border="0" width="750"> 
          <tr> 
            <td id="tab1" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Size & Offsets</td> 
            <td id="tab2" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Colors & Images</td> 
            <td id="tab3" class="offtab" onclick="dhtml.cycleTab(this.id)">Menu Fonts & Alignments</td> 
           
            <td id="tab4" class="offtab" onclick="dhtml.cycleTab(this.id)">About SWmenuPro</td> 
          </tr> 
        </table> 
        <div id="page1" class="pagetext"> 
          <table width="750px"> 
            <tr> 
              <td valign="top" align="center"> <table width="360px" height = "200" class="adminForm"> 
                 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Menu Width</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td width="260">Menu Width:</td> 
                    <td width="100" class="adminlist" align="right"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu Width','main_width',5,800,<?php echo $rows->main_width;?>);" size="8" id = "main_width" name = "main_width" value = "<?php echo $rows->main_width;?>" > 
                        px</div></td> 
                  </tr> 
				 
                  <tr> 
                    <td colspan="2" class="tabheading"> <div align="center">Menu Offsets</div></td> 
                  </tr> 
                  
                  <tr class="menubackgr"> 
                    <td>Child Menu - Left Indent:</td> 
                    <td width="100" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('Top Menu - Left Offset','level1_sub_left',0,500,<?php echo $rows->level1_sub_left;?>);"  size="8"  name = "level1_sub_left" value = "<?php echo $rows->level1_sub_left;?>"> 
                        px</div></td> 
                  </tr> 
                  
                  <tr> 
                    <td>All Menu Items - Left Margin:</td> 
                    <td width="100" class="adminlist"> <div align="right"> 
                        <input type="text" onChange="checkNumberSyntax('All Menu Items - Left Margin','level2_sub_left',0,500,<?php echo $rows->level2_sub_left;?>);"  size="8"  name = "level2_sub_left" value = "<?php echo $rows->level2_sub_left;?>"> 
                        px</div></td> 
                  </tr> 
				  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Parent Item Padding</div></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="adminlist" align="center"> <TABLE> 
                        <TR class="menubackgr"> 
                          <TD width="75" align="center">Top</TD> 
                          <TD width="75" align="center">Right</TD> 
                          <TD width="75" align="center">Bottom</TD> 
                          <TD width="75" align="center">Left</TD> 
                        </TR> 
                        <TR> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Top Padding','main_pad_top',0,100,0); doMainPadding();" size="3" id = "main_pad_top" name = "main_pad_top" value = "<?php echo $mainpadding[0]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Right Padding','main_pad_right',0,100,0);doMainPadding();" size="3" id = "main_pad_right" name = "main_pad_right" value = "<?php echo $mainpadding[1]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Bottom Padding','main_pad_bottom',0,100,0);doMainPadding();" size="3" id = "main_pad_bottom" name = "main_pad_bottom" value = "<?php echo $mainpadding[2]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Main Left Padding','main_pad_left',0,100,0);doMainPadding();" size="3" id = "main_pad_left" name = "main_pad_left" value = "<?php echo $mainpadding[3]; ?>" maxlength="2"> 
                            px</TD> 
                        </TR> 
                      </TABLE></td> 
                  </tr> 
                  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Child Item Padding</div></td> 
                  </tr> 
                  <tr > 
                    <td colspan="2" class="adminlist" align="center"> <TABLE> 
                        <TR class="menubackgr"> 
                          <TD width="75" align="center">Top</TD> 
                          <TD width="75" align="center">Right</TD> 
                          <TD width="75" align="center">Bottom</TD> 
                          <TD width="75" align="center">Left</TD> 
                        </TR> 
                        <TR> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Top Padding','sub_pad_top',0,100,0);doSubPadding();" size="3" id = "sub_pad_top" name = "sub_pad_top" value = "<?php echo $subpadding[0]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Right Padding','sub_pad_right',0,100,0);doSubPadding(); " size="3" id = "sub_pad_right" name = "sub_pad_right" value = "<?php echo $subpadding[1]; ?>" maxlength="2"> 
                            px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Bottom Padding','sub_pad_bottom',0,100,0);doSubPadding(); " size="3" id = "sub_pad_bottom" name = "sub_pad_bottom" value = "<?php echo $subpadding[2]; ?>" maxlength="2">
						   px</TD> 
                          <TD width="75" align="center"><input type="text"  onChange="checkNumberSyntax('Sub Left Padding','sub_pad_left',0,100,0);doSubPadding(); " size="3" id = "sub_pad_left" name = "sub_pad_left" value = "<?php echo $subpadding[3]; ?>" maxlength="2"> 
                            px</TD> 
                        </TR> 
                      </TABLE></td> 
                  </tr> 
				  <tr> 
                    <td colspan="2" class="tabheading"><div align="center">Menu Border</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                    <td>Menu Border Style:</td> 
                    <td width="100" class="adminlist"> <div align="right"> 
                        <select id = "main_border_style" onChange="doMainBorder();" name = "main_border_style" style="width:85px"> 
                          <option <?php if ($mainborder[1] == 'none') {echo 'selected';} ?> value = "none">none</option> 
                         
                          <option <?php if ($mainborder[1] == 'dotted') {echo 'selected';} ?> value = "dotted">dotted</option> 
                          <option <?php if ($mainborder[1] == 'dashed') {echo 'selected';} ?> value = "dashed">dashed</option> 
                          <option <?php if ($mainborder[1] == 'solid') {echo 'selected';} ?> value = "solid">solid</option> 
                          <option <?php if ($mainborder[1] == 'double') {echo 'selected';} ?> value = "double">double</option> 
                          <option <?php if ($mainborder[1] == 'groove') {echo 'selected';} ?> value = "groove">groove</option> 
                          <option <?php if ($mainborder[1] == 'ridge') {echo 'selected';} ?> value = "ridge">ridge</option> 
                          <option <?php if ($mainborder[1] == 'inset') {echo 'selected';} ?> value = "inset">inset</option> 
                          <option <?php if ($mainborder[1] == 'outset') {echo 'selected';} ?> value = "outset">outset</option> 
                        </select> 
                      </div></td> 
                  </tr> 
				  
                  <tr > 
                    <td>Menu Border Width:</td> 
                    <td width="100" class="adminlist"> <div align="right"> 
                        <input id = "main_border_width" onChange="checkNumberSyntax('Main Menu Border Width','main_border_width',0,200,0); doMainBorder();" name = "main_border_width" type="text" value = "<?php echo $mainborder[0]; ?>" size="8"> 
                        px</div></td> 
                  </tr> 
                
                </table></td> 
              <td valign="top"> <table width = "360px"  height = "200" class="adminForm" > 
                  <td>
				<img src = "components/com_swmenupro/images/treemenu_dimensions.gif" width="350" height = "300" border = "0" hspace="0" vspace="0">
				</td>
                </table></td> 
            </tr> 
          </table> 
          
        </div> 
        
		
		
		
		<div id="page2" class="pagetext"> 
          <table width="750px"> 
            <tr><td valign="top" align="center"> 
              <table width="360px"  height = "330" class="adminForm"> 
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Menu Icons</div></td> 
                </tr> 
                <tr class="menubackgr" > 
                  <td colspan="2" width="300">Parent Item Closed Icon:</td> 
                  <td align="right"><img id="main_back_image" src="../<?php echo $rows->main_back_image;?>" align="left">
                    <input type="button" name = "getimage" value = "GET" onclick="PreviewImageSelector.select('main_back_image');"> 
                    <input type="hidden" id="main_back_imagehidden" name = "main_back_image" value = "<?php echo $rows->main_back_image;?>"> </td> 
                </tr> 
                <tr> 
                  <td colspan="2">Parent Item Open Icon:</td> 
                  <td align="right"><img id="main_back_image_over" src="../<?php echo $rows->main_back_image_over;?>" align="left">
                    <input type="button" name = "getimage" value = "GET" onclick="PreviewImageSelector.select('main_back_image_over');"> 
                    <input type="hidden" id="main_back_image_overhidden" name = "main_back_image_over" value = "<?php echo $rows->main_back_image_over;?>"> </td> 
                <tr class="menubackgr"> 
                  <td colspan="2">Child Item Icon:</td> 
                  <td align="right"><img id="sub_back_image" src="../<?php echo $rows->sub_back_image;?>" align="left">
                    <input type="button" name = "getimage" value = "GET" onclick="PreviewImageSelector.select('sub_back_image');"> 
                    <input type="hidden" id="sub_back_imagehidden" name = "sub_back_image" value = "<?php echo $rows->sub_back_image;?>"> </td> 
                </tr> 
                <tr> 
                  <td colspan="2">Last Child Item Icon:</td> 
                 <td align="right"><img id="sub_back_image_over" src="../<?php echo $rows->sub_back_image_over;?>" align="left">
                    <input type="button" name = "getimage" value = "GET" onclick="PreviewImageSelector.select('sub_back_image_over');"> 
                    <input type="hidden" id="sub_back_image_overhidden" name = "sub_back_image_over" value = "<?php echo $rows->sub_back_image_over;?>"> </td> 
                </tr> 
				
                <tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Menu Colors</div></td> 
                </tr> 
                <tr class="menubackgr" > 
                  <td>Menu Background Color:</td> 
                  <td > 
                  <table id="main_back_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_back;?>' > 
                    <tr> 
                      <td width="20" height="20">&nbsp</td>  
                    </tr> 
                    
                  </table> 
                </td> 
                 <td width="120" class="adminlist" > <div align="right"> 
                      <input type="text" onChange="checkColorSyntax('Main Menu Color','main_back','<?php echo $rows->main_back;?>');" size="8"  id="main_back" name = "main_back" value = "<?php echo $rows->main_back;?>"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_back');" > <img src="components/com_swmenupro/images/sel.gif">get</a> </div></td> 
                </tr> <tr> 
                  <td>Menu Items Over Color:</td> 
                  <td > 
                   <table id="main_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_over;?>'> 
                     <tr> 
                       <td width="20" height="20">&nbsp</td>  
                     </tr> 
                    
                   </table> 
                </td> 
                 <td width="120" class="adminlist"> <div align="right"> 
                      <input type="text" onChange="checkColorSyntax('Top Menu Over Color','main_over','<?php echo $rows->main_over;?>');" size="8"  id = "main_over" name = "main_over" value = "<?php echo $rows->main_over;?>"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_over');"><img src="components/com_swmenupro/images/sel.gif">get</a> </div></td> 
                </tr>
				<tr class="menubackgr"> 
                  <td>Menu Border Color:</td> 
                  <td > 
                  <table id="main_border_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $mainborder[2];?>'> 
                    <tr> 
                       <td width="20" height="20">&nbsp</td>   
                    </tr>                   
                  </table> 
                  </td> 
                  <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "main_border_color" onChange="checkColorSyntax('Top Menu Border Color','main_border_color','<?php echo $mainborder[2];?>'); doMainBorder();" type="text" id="main_border_color" value = "<?php echo $mainborder[2];?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_border_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr>
				<tr> 
                  <td colspan="3" class="tabheading"> <div align="center">Font Colors </div> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Menu Items Font Color:</td> 
                  <td > 
                  <table id="main_font_color_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_font_color;?>'> 
                    <tr> 
                     <td width="20" height="20">&nbsp</td>  
                    </tr> 
                   
                  </table> 
                </td> 
                 <td width="120" class="adminlist"> <div align="right"> 
                      <input  name = "main_font_color" onChange="checkColorSyntax('Top Menu Font Color','main_font_color','<?php echo $rows->main_font_color;?>');" type="text" id="main_font_color" value = "<?php echo $rows->main_font_color;?>" size="8"> 
                      <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_font_color');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr> <tr> 
                  <td>Menu Items Over Font Color:</td> 
                  <td > 
                   <table id="main_font_color_over_box" style="border: 1px solid #000000; width:'20px'; height:'20px'" bgColor='<?php echo $rows->main_font_color_over;?>'> 
                     <tr> 
                       <td width="20" height="20">&nbsp</td>  
                     </tr> 
                     
                   </table> 
                  </td> 
                   <td width="120" class="adminlist"> <div align="right"> 
                       <input name = "main_font_color_over" onChange="checkColorSyntax('Top Menu Over Font Color','main_font_color_over','<?php echo $rows->main_font_color_over;?>');" type="text" id="main_font_color_over" value = "<?php echo $rows->main_font_color_over;?>" size="8"> 
                       <a onMouseOver="this.style.cursor='pointer'" onClick="copyColor('main_font_color_over');"><img src="components/com_swmenupro/images/sel.gif">get</a></div></td> 
                </tr>
              </table> 
              </td> 
              <td valign="top"> 
             
                
                <table width = "360px" height = "330"  valign="top" class="adminForm"> 
                  <tr> 
                    <td align="center" valign="top"><img src="components/com_swmenupro/images/color_wheel_top.gif" width="350" height="44"></td> 
                  </tr> 
                  <tr> 
                    <td> <table width = "320px" align="center"> 
                        <tr> 
                          <td id="CPCP_Wheel" ><img src="components/com_swmenupro/images/colorwheel.jpg" width="256" height="256"  onMouseMove="xyOff(event);" onClick="wrtVal();" border="1"></td> 
                          <td>&nbsp;</td> 
                          <td> <table border="0"> 
                              <tr> 
                                <td valign="TOP">Present Color:</td> 
                              </tr> 
                              <tr> 
                                <td id="CPCP_ColorCurrent" height="70"></td> 
                              </tr> 
                              <tr> 
                                <td id="CPCP_ColorSelected">&nbsp;</td> 
                              </tr> 
                              <tr> 
                                <td><br> 
                                  Selected Color:  
                              </tr> 
                              <tr> 
                                <td bgcolor="#FFFFFF" id="CPCP_Input" height="70"  >&nbsp;</td> 
                              <tr> 
                                <td><input name="TEXT" type="TEXT" id="CPCP_Input_RGB" value="#FFFFFF" size="8"></td> 
                              </tr> 
                            </table></td> 
                        </tr> 
                      </table></td> 
                  </tr> 
                </table>
             
              </td> 
            </tr> 
          </table> 
          
        </div> 


        <div id="page3" class="pagetext"> 
          <table width="750px"> 
            <tr> 
              <td valign="top" align="center"> <table style="width:'360px'" width = "360px"  height = "210" class="adminForm"> 
                  <tr> 
                    <td colspan="2" class="tabheading"> <div align="center">Font Family</div></td> 
                  </tr> 
                  <tr class="menubackgr"> 
                     
                    <td colspan="2" width="250" align="center"> 
                        <select name="font_family" id="font_family" style = "width:'360px'"> 
                          <option <?php if ($rows->font_family == 'Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Arial, Helvetica, sans-serif">Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->font_family == '\'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "'Times New Roman', Times, serif">'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->font_family == 'Georgia, \'Times New Roman\', Times, serif') {echo 'selected';} ?> value = "Georgia, 'Times New Roman', Times, serif">Georgia,'Times New Roman',Times,serif</option> 
                          <option <?php if ($rows->font_family == 'Verdana, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Verdana, Arial, Helvetica, sans-serif">Verdana,Arial,Helvetica,sans-serif</option> 
                          <option <?php if ($rows->font_family == 'Geneva, Arial, Helvetica, sans-serif') {echo 'selected';} ?> value = "Geneva, Arial, Helvetica, sans-serif">Geneva,Arial,Helvetica,sans-serif</option> 
                        </select> 
                      </td> 
                  </tr> 
                 <tr> 
                  <td colspan="2" class="tabheading"> <div align="center">Font Size</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td width="300">All Menu Items Font Size:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <input id = "main_font_size" onChange="checkNumberSyntax('Top Menu Font Size:','main_font_size',3,100,<?php echo $rows->main_font_size;?>);" name = "main_font_size" type="text"  value = "<?php echo $rows->main_font_size;?>" size="8"> 
                      px</div></td> 
                </tr> 
               
                
                
                <tr> 
                  <td colspan="2" class="tabheading"> <div align="center">Font Weight</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>Font Weight:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="font_weight" id="font_weight" onChange="doPreview();" style = "width:'100px'"> 
                        <option <?php if ($rows->font_weight == 'normal') {echo 'selected';} ?> value = "normal">normal</option> 
                        <option <?php if ($rows->font_weight == 'bold') {echo 'selected';} ?> value = "bold">bold</option> 
                        <option <?php if ($rows->font_weight == 'bolder') {echo 'selected';} ?> value = "bolder">bolder</option> 
                        <option <?php if ($rows->font_weight == 'lighter') {echo 'selected';} ?> value = "lighter">lighter</option> 
                      </select> 
                    </div></td> 
                </tr> 
                <tr> 
                  <td>Font Weight Over:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="font_weight_over" id="font_weight_over" onChange="doPreview();" style = "width:'100px'"> 
                        <option <?php if ($rows->font_weight_over == 'normal') {echo 'selected';} ?> value = "normal">normal</option> 
                        <option <?php if ($rows->font_weight_over == 'bold') {echo 'selected';} ?> value = "bold">bold</option> 
                        <option <?php if ($rows->font_weight_over == 'bolder') {echo 'selected';} ?> value = "bolder">bolder</option> 
                        <option <?php if ($rows->font_weight_over == 'lighter') {echo 'selected';} ?> value = "lighter">lighter</option> 
                      </select> 
                    </div></td> 
                </tr> 
				<tr> 
                  <td colspan="2" class="tabheading"> <div align="center">Alignments</div></td> 
                </tr> 
                <tr class="menubackgr"> 
                  <td>All Menu Items Text Alignment:</td> 
                  <td width="100" class="adminlist"> <div align="right"> 
                      <select name="main_align" id="main_align" onChange="doPreview();" style = "width:'100px'"> 
                        <option <?php if ($rows->main_align == 'left') {echo 'selected';} ?> value = "left">left</option> 
                        <option <?php if ($rows->main_align == 'right') {echo 'selected';} ?> value = "right">right</option> 
                        <option <?php if ($rows->main_align == 'center') {echo 'selected';} ?> value = "center">center</option> 
                      </select> 
                    </div></td> 
                </tr>
				<tr > 
                  <td >All Menu Items Image Alignment:</td> 
                  <td align="right" > <div align="right"> 
                      <select name="sub_align" id="sub_align" onChange="doPreview();" style = "width:'100px'" > 
                        <option <?php if ($rows->sub_align == 'left') {echo 'selected';} ?> value = "left">left</option> 
                        <option <?php if ($rows->sub_align == 'right') {echo 'selected';} ?> value = "right">right</option> 
                        <option <?php if ($rows->sub_align == 'center') {echo 'selected';} ?> value = "center">center</option> 
                      </select> 
                    </div></td> 
                </tr> 
                  
                </table></td> 
              <td valign="top"> 
              <table width = "360px" style="width:'360px'" height = "210"class="adminForm"> 
                
                <tr><td>
				<TABLE width="100%" align="center"> 
            <TR> 
              <TD align="center" valign="top"> <table width = "360" > 
                  <tr> 
                    <td align="center" valign="top"><img src="components/com_swmenupro/images/menu_fonts_top.gif" width="350" height="25"></td> 
                  </tr> 
				  <tr> 
                    <td align= "center">All browsers render fonts and sizes differently.  The list below shows how your browser has rendered the fonts and sizes described.<br> </td> 
                  </tr> 
                  <tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:10px; font-weight:'normal';font-family:''Times New Roman', Times, serif';">'Times New Roman', Times, serif normal at 10px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:10px; font-weight:'bold';font-family:'Verdana,Arial,Helvetica,sans-serif';">Verdana,Arial,Helvetica,sans-serif Bold at 10px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:12px; font-weight:'normal';font-family:'Arial,Helvetica,sans-serif';">Arial,Helvetica,sans-serif Normal at 12px</span> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center" valign="top"><span  style="color:#1166B0; font-size:12px; font-weight:'normal';font-family:'Georgia, 'Times New Roman', Times, serif';">Georgia, 'Times New Roman', Times, serif Normal at 12px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:12px; font-weight:'bold';font-family:Geneva,Arial,Helvetica,sans-serif';">'Geneva,Arial,Helvetica,sans-serif Bold at 12px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'normal';font-family:''Times New Roman', Times, serif';">'Times New Roman', Times, serif normal at 14px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'bold';font-family:'Verdana,Arial,Helvetica,sans-serif';">Verdana,Arial,Helvetica,sans-serif Bold at 14px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'bold';font-family:'Arial,Helvetica,sans-serif';">Arial,Helvetica,sans-serif Bold at 14px</span><br> </td> 
                  </tr> 
                  <tr> 
                    <td align= "center"><span  style="color:#1166B0; font-size:14px; font-weight:'normal';font-family:'Geneva,Arial,Helvetica,sans-serif';">Geneva,Arial,Helvetica,sans-serif Normal at 14px</span><br> </td> 
                  </tr> 
                </table>
				
			</td></tr>	</table></td></tr>	
          </TABLE> 
		  </td></tr>	
          </TABLE> 
        </div> 

       

        <div id="page4" class="pagetext"> 
          <table width="750px" height = "320px"> 
            <tr> 
              <td valign="top"> <table width="300px" height = "320px" class="adminForm"> 
                  <tr> 
                    <td align="center"> <img src="components/com_swmenupro/images/swmenupro_box.gif" width="150" height="250"></td> 
                  </tr> 
                </table> 
              <td align="center" valign="top"><table width="420" height = "320px" class="adminForm" > 
                  <tr> 
                    <th ><div align="center" class="style1">Welcome to SWmenuPro</div></th> 
                  </tr> 
                  <td align="left" valign="top"><span  class="adminheader">Features:</span></td> 
                  </tr> <tr> 
                    <td> <p>  
                       <li>Unlimited menus on any page with seperate modules for each</li> 
					   <li>Three independent menu types with seperate configurations</li> 
					   <li>Advanced custom images and animations for each menu items</li> 
                       <li>Vertical or horizontal menu alignment(popout menu only)</li> 
 					   <li>Absolute or Relative positioning(popout and clickmenu only)</li> 
                       
                       <li>Advanced positioning of menu items through offsets</li> 
  
                       <li>Advanced dimensioning of menu item widths, heights and borders </li> 
  
                       <li>Advanced font administration including font families, sizes and weight</li> 
  
                       <li>Advanced color and background image assignment for top menus and sub menus</li> 
  
                       </p></td> 
                  </tr> 
                  <tr> 
                    <td align="center"><p> for support and info on upgrades please visit <a href="http://www.swonline.biz">www.swonline.biz</a> <br> 
                        <br> 
                        swmenupro is &copy;opyright 2004 <a href="http://www.swonline.biz">www.swonline.biz</a></p></td> 
                  </tr> 
                </table> 
            </tr> 
            </td> 
             </table> 
        </div> 
        <input type="hidden" id="main_padding" name="main_padding" value="<?PHP echo $rows->main_padding; ?>" /> 
        <input type="hidden" id="sub_padding" name="sub_padding" value="<?PHP echo $rows->sub_padding; ?>" /> 
        <input type="hidden" id="main_border" name="main_border" value="<?PHP echo $rows->main_border; ?>" /> 
        <input type="hidden" id="sub_border" name="sub_border" value="<?PHP echo $rows->sub_border; ?>" /> 
        <input type="hidden" id="main_border_over" name="main_border_over" value="<?PHP echo $rows->main_border_over; ?>" /> 
        <input type="hidden" id="sub_border_over" name="sub_border_over" value="<?PHP echo $rows->sub_border_over; ?>" /> 
        <input type="hidden" name="option" value="<?PHP echo $option; ?>" /> 
        <input type="hidden" name="pageID" value="tab4" /> 
        <input type="hidden" name="moduleID" value="<?PHP echo $moduleID; ?>" /> 
        <input type="hidden" name="cid[]" value="<?PHP echo $moduleID; ?>" /> 
        <input type="hidden" name="menutype" value="<?PHP echo $menutype; ?>" /> 
		<input type="hidden" name="menustyle" value="treemenu" /> 
        <input type="hidden" name="task" value="editDhtmlMenu" /> 
        <input type="hidden" name="boxchecked" value="0" /> 
        <input type="hidden" name="id" value="<?php echo $moduleID; ?>"> 
    </form> 
    </td> 
  </tr> 
</table> 
<script language="javascript" type="text/javascript">
		  


dhtml.cycleTab('<?php echo $pageID; ?>');

</script> 
</td> 
</tr> 

  </table> 
  <?php

}


function showModules( &$rows, $option, $pageNav ) 
{   
	?> 
  <form action="index2.php" method="post" name="adminForm"> 
    <table cellpadding="4" cellspacing="0" border="0" width="100%"> 
      <tr> 
        <td width="100%"><span class="sectionname"><img src="components/com_swmenupro/images/swmenupro_logo_small.gif" align="left"><center>SWmenuPro Module Manager</center></span></td> 
        <td nowrap>Display #</td> 
        <td> <?php echo $pageNav->writeLimitBox(); ?> </td> 
      </tr> 
    </table> 
    <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist"> 
      <tr> 
        <th>#</th> 
        <th nowrap="nowrap"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" /></th> 
        <th  class="title" nowrap="nowrap">Module Name</th> 
        <th  class="title" nowrap="nowrap">Menu Type</th> 
        <th  class="title" nowrap="nowrap">Menu Name</th> 
        <th  class="title" nowrap="nowrap">Menu Position</th> 
        <th  class="title" nowrap="nowrap">Published</th> 
        <th  class="title" nowrap="nowrap" >Checked Out</th> 
        <th  class="title" nowrap="nowrap" >Access</th> 
      </tr> 
      <?
    $k = 0;
    for ($i=0, $n=count($rows); $i < $n; $i++) 
    {
    	$row = &$rows[$i];
        $img = $row->published ? 'tick.png' : 'publish_x.png';
		$task = $row->published ? 'unpublish' : 'publish';
        
       //Parse parameters
		$params = mosParseParams( $row->params );
		$menutype = @$params->menutype ? $params->menutype : 'mainmenu';
		$moduletype = @$params->menustyle ? $params->menustyle : 'mambo standard';
	?> 
      <tr class="row<?PHP echo $k; ?>"> 
        <td width="20"><?php echo $i+$pageNav->limitstart+1;?></td> 
        <td width="20"><input type="checkbox" id="cb<?PHP echo $i; ?>" name="cid[]" value="<?PHP echo $row->id; ?>" onclick="isChecked(this.checked);" /></td> 
        <td width="30%"><div align="left"> <a href="#edit" onclick="return listItemTask('cb<?PHP echo $i; ?>','moduleEdit')"><?PHP echo $row->title; ?></a></div></td> 
        <td width="30%"><div align="left"> 
          <?PHP 
			if ($moduletype != "mambo standard"){
			echo "<a href=\"#edit\" onclick=\"return listItemTask('cb".$i."','editDhtmlMenu')\">".$moduletype." (edit)</a></div></td>\n";
		}else{
			echo $moduletype."</div></td>\n";
		}
		?> 
        <td width="30%"><div align="left"><a href="index2.php?option=com_menus&menutype=<?PHP echo $menutype; ?>"><?PHP echo $menutype; ?> (edit)</a></div></td> 
        <td width="10%" align="center"> <?PHP echo $row->position; ?></td> 
        <td width="10%" align="center"><a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')"><img src="images/<?php echo $img;?>" border="0" alt="" /></a></td> 
        <td width="10%" align="center"><?php echo $row->editor; ?>&nbsp;</td> 
        <td width="10%" align="center"><?php echo $row->groupname;?></td> 
      </tr> 
      <?PHP 
			$k = 1 - $k;
     	     }
?> 
      </tr> 
       <tr> 
        <th align="center" colspan="9"> <?php echo $pageNav->writePagesLinks(); ?></th> 
      </tr> 
      <tr> 
        <td align="center" colspan="9"> <?php echo $pageNav->writePagesCounter(); ?></td> 
      </tr> 
    </table> 
    <input type="hidden" name="option" value="<?PHP echo $option; ?>" /> 
    <input type="hidden" name="task" value="" /> 
    <input type="hidden" name="boxchecked" value="0" /> 
  </form> 
  <?
}



function editModule( &$row, &$orders2, &$glist, &$menulist, &$poslist, &$titlelist, &$publishlist, $option, $menu_type ) {
		
		
		$limit = intval( mosGetParam( $_REQUEST, 'limit', 10 ) );
		$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
		$params = mosParseParams( $row->params );
		$menutype = $params->menutype ;
		$menustyle = $params->menustyle ;
		$moduleID = $params->moduleID ;
?> 
  <script language="javascript" type="text/javascript">
		

function submitbutton(pressbutton) {
var form = document.adminForm;

	if ((pressbutton == 'save') && document.adminForm.title.value == ""){
			alert("Module must have a title");
			}else{
	if ((pressbutton == 'save') && ((form.oldmenutype.value=="Please Select...")||(( form.oldmenutype.value=="Create new menu" ) && (form.newmenutype.value == "")))){

		alert("Module must have an existing or a new menu");
	}else{
		if (pressbutton == 'save'){
		saveModule();
	}else{
		form.submit();
	}
	}
}}

function saveModule(){
	var form = document.adminForm;
	if (form.oldmenutype.value=="Create new menu"){
		var menutype = "menutype=" + form.newmenutype.value;
	   }else{
		var menutype = "menutype=" + form.oldmenutype.value;
		}

	if (form.menustyle.value == "standard"){
		
		form.module.value = "mod_mainmenu";
	    form.iscore.value = "1"; 
	    form.params.value = menutype;
	    form.task.value="save";
		form.submit();
	   
	   } else {   
		var menustyle = "menustyle=" + form.menustyle.value;
		var moduleID = "moduleID=<?php echo $row->id; ?>";
			
		form.module.value= "mod_swmenupro";
		form.params.value+=  menutype + "\n" ;
		form.params.value+=  menustyle + "\n" ;
		form.params.value+=  moduleID + "\n" ;
        form.task.value="save";
		form.submit();
		}
}


	function doNewMenu(){

	var temp_menu = document.getElementById('oldmenutype').value;

	if (temp_menu=="Create new menu"){
		document.getElementById('newmenuname').style.visibility = "visible";
		
	}else{
		document.getElementById('newmenuname').style.visibility = "hidden";
		
	}
	}
		</script> 
  <script language="javascript" text="text/javascript">
		<!--
			var originalOrder = '<?php echo $row->ordering;?>';
			var originalPos = '<?php echo $row->position;?>';
			var orders = new Array();	// array in the format [key,value,text]
<?php	$i = 0;
foreach ($orders2 as $k=>$items) {
	foreach ($items as $v) {
		echo "\n	orders[".$i++."] = new Array( '$k','$v->value','$v->text' );";
	}
}
?>
		//-->
		</script> 
  <table cellpadding="4" cellspacing="1" border="0" width="750" style="width='750px';" align="center"> 

  
    <tr> 
      <td width="100%" class="sectionname" ><img src="components/com_swmenupro/images/swmenupro_logo_small.gif" align="middle" alt="SWmenuPro Module Manager"><?php echo $row->id ? 'Edit' : 'Add';?> Module -> <?php echo $row->title; ?></td> 
    </tr> 
  </table> 
  <table cellpadding="2" cellspacing="0" border="0" width="750" class="adminform" style="width='750px';"><tr><td>
  <table width="360"> <form action="index2.php" method="POST" name="adminForm"> 
     <tr> 
      <td width="150" align="left">Title:</td> 
      <td> <input class="inputbox" style="width:200px" type="text" name="title" size="20" value="<?php echo $row->title; ?>" /> </td> 
    <tr> 
      <td  align="left">Menu Style:</td> 
      <td> <?
	echo "<select name=\"menustyle\" style=\"width:200px\">\n";
	echo "<option";
	if ($menustyle == 'standard') {echo 'selected';} 
	echo " value=\"standard\">Mambo Standard</option >\n";
	echo "<option ";
	if ($menustyle == 'popoutmenu') {echo 'selected';} 
	echo " value=\"popoutmenu\">DHTML Tigra Pop-Out Menu</option >\n";
	echo "<option ";
	if ($menustyle == 'gosumenu') {echo 'selected';} 
	echo " value=\"gosumenu\">DHTML MyGosu Pop-Out Menu</option >\n";
	echo "<option ";
	
	if ($menustyle == 'clickmenu') {echo 'selected';} 
	echo " value=\"clickmenu\">DHTML Click Menu</option >\n";
	echo "<option ";
	if ($menustyle == 'treemenu') {echo 'selected';} 
	echo " value=\"treemenu\">DHTML Tree Menu</option >\n";
	echo "</select >";
	echo "</td></tr><tr><td width=\"100\" align=\"left\">Menu Type:</td><td>\n";
	
		
		echo "<select id=\"oldmenutype\" name=\"oldmenutype\" type=\"text\" onchange=\"doNewMenu()\" style=\"width:200px\">\n";

		for($i=0;$i < count($menu_type);$i++)
		{
		echo "<option ";
		if ($menutype == $menu_type[$i]) {echo 'selected ';}
		echo "value = '".$menu_type[$i]."'>".$menu_type[$i]."</option>"; 
		}
		echo "</select>\n"; 
		?> 
    </tr> 
    <tr id="newmenuname" style="visibility:hidden; height:0px"> 
      <td >Menu Name:</td> 
      <td > <input id="newmenutype" class="inputbox" style="width:200px" type="text" name="newmenutype" size="30" value="" /> </td> 
     
    </tr> 
    <tr> 
      <td width="150" align="left">Show title:</td> 
      <td> <?php echo $titlelist; ?> </td> 
    </tr> 
    <!-- START selectable pages --> 
    <tr> 
      <td valign="top" align="left">Page(s):</td> 
      <td> <?php echo $menulist; ?> </td> 
    </tr> 
    <!-- END selectable pages --> 
    <tr> 
      <td valign="top" align="left">Position:</td> 
      <td> <?php echo $poslist; ?> </td> 
    </tr> 
    <tr> 
      <td valign="top" align="left">Module Order:</td> 
      <td> <script language="javascript" type="text/javascript">
					<!--
						writeDynaList( 'class="inputbox" name="ordering" size="1"',
							orders, originalPos, originalPos, originalOrder );
					//-->
					</script> </td> 
    </tr> 
    <tr> 
      <td valign="top" align="left">Access Level:</td> 
      <td> <?php echo $glist; ?> </td> 
    </tr> 
    <tr> 
      <td valign="top">Published:</td> 
      <td><?php echo $publishlist; ?></td> 
    </tr> 
    <tr> 
      <td colspan="2">&nbsp;</td> 
    </tr> 
  </table> </td><td><table width="360">
  <tr><td>
<img src = "components/com_swmenupro/images/menu_styles.gif" width="340" height = "380" border = "0" hspace="0" vspace="0">
  </td>
  </tr>
  </table>
  </td></tr></table>
  <input type="hidden" name="option" value="<?php echo $option; ?>" /> 
  <input type="hidden" name="menutype" value="<?php echo $menutype; ?>" /> 
  <input type="hidden" name="id" value="<?php echo $row->id; ?>" /> 
  <input type="hidden" name="iscore" value="0" /> 
  <input type="hidden" name="original" value="<?php echo $row->ordering; ?>" /> 
  <input type="hidden" name="params" value="" /> 
  <input type="hidden" name="module" value="<?php echo $row->module; ?>" /> 
  <input type="hidden" name="task" value="" /> 
  <input type="hidden" name="limit" value="<?php echo $limit; ?>" /> 
  <input type="hidden" name="limitstart" value="<?php echo $limitstart; ?>" /> 
  </form> 
  <?php
	} 
}
?> 
