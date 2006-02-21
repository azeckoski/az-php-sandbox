<?php
/**
* SWmenuPro v1.5
* http://swonline.biz
* Copyright 2004 Sean White
* DHTML Menu Component for Mambo Open Source
* Mambo Open Source is Free Software
* Released under GNU/GPL License: http://www.gnu.org/copyleft/gpl.html
**/

$menustyle = ($_REQUEST['menustyle']);


switch($menustyle){

	case "popoutmenu":
		tigraPreview();
	break;

	case "gosumenu":
		gosuPreview();
	break;

	case "clickmenu":
		clickPreview();
	break;

	case "treemenu":
		treePreview();
	break;

	default:
		gosuPreview();
	break;

}




function gosuPreview(){

	$q = explode("&",$_SERVER["QUERY_STRING"]);
foreach ($q as $qi)
{
  if ($qi != "")
  {
    $qa = explode("=",$qi);
    list ($key, $val) = $qa;
    if ($val)
      $$key = urldecode($val);
  }
}
 
reset ($_POST);
while (list ($key, $val) = each ($_POST))
{
  if ($val)
    $$key = $val;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SWmenuPro MyGosuMenu Preview</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script type="text/javascript" src="js/ie5.js"></script>
<script type="text/javascript" src="js/DropDownMenuX.js"></script>

<script language="JavaScript">
<!--


function changeBG(){
document.bgColor = document.getElementById('back_color').value;
}

-->
</script>

<style type="text/css">
<!--

.ddmx {
    font: 11px tahoma;
	
}
.ddmx a.item1,
.ddmx a.item1:hover,
.ddmx a.item1-active,
.ddmx a.item1-active:hover {
    padding: <?php echo $main_padding; ?>;
	
	
	font-size: <?php echo $main_font_size; ?>px;
    font-family: <?php echo $font_family; ?>;
    text-align: <?php echo $main_align; ?>;
	font-weight: <?php echo $font_weight; ?>;
    text-decoration: none;
    display: block;
    white-space: nowrap;
    position: relative;
	<?php  if ($main_width!=0){echo "width:".$main_width."px;";} ?>
	<?php  if ($main_height!=0){echo "height:".$main_height."px;";} ?>
}
.ddmx a.item1 {
	background-image: URL("../../../<?php echo $main_back_image; ?>");
	background-color: #<?php echo $main_back; ?>;
	border:  <?php echo $main_border_width."px ".$main_border_style." #".$main_border_color; ?>;
    color: #<?php echo $main_font_color; ?>;
	white-space: nowrap;

}
.ddmx a.item1:hover,
.ddmx a.item1-active,
.ddmx a.item1-active:hover {
	border:  <?php echo $main_border_over_width."px ".$main_border_over_style." #".$main_border_color_over; ?>;
    background-image: URL("../../../<?php echo $main_back_image_over; ?>");
    background-color: #<?php echo $main_over; ?>;
    color: #<?php echo $main_font_color_over; ?>;
	white-space: nowrap;
}
.ddmx a.item2,
.ddmx a.item2:hover,
.ddmx a.item2-active,
.ddmx a.item2-active:hover {
    padding: <?php echo $sub_padding; ?>;
	font-size: <?php echo $sub_font_size; ?>px;
    font-family: <?php echo $sub_font_family; ?>;
    text-align: <?php echo $sub_align; ?>;
	font-weight: <?php echo $font_weight_over; ?>;
    text-decoration: none;
    display: block;
   white-space: nowrap;
    position: relative;
    z-index: 500;
	<?php  if ($sub_width!=0){echo "width:".$sub_width."px;";} ?>
	<?php  if ($sub_height!=0){echo "height:".$sub_height."px;";} ?>
	filter: alpha(opacity=<?php echo $specialA; ?>)
}
.ddmx a.item2 {
    background-image: URL("../../../<?php echo $sub_back_image; ?>");
	background-color: #<?php echo $sub_back; ?>;
    color: #<?php echo $sub_font_color; ?>;
	border:  <?php echo $sub_border_width."px ".$sub_border_style." #".$sub_border_color; ?>;
}
.ddmx a.item2:hover,
.ddmx a.item2-active,
.ddmx a.item2-active:hover {
    background-image: URL("../../../<?php echo $sub_back_image_over; ?>");
    background-color: #<?php echo $sub_over; ?>;
    color: #<?php echo $sub_font_color_over; ?>;
	border:  <?php echo $main_border_over_width."px ".$main_border_over_style." #".$main_border_color_over; ?>;
}

.ddmx .section {
    border: 0px #ffffff none;
    position: absolute;
    visibility: hidden;
	display: block;
    z-index: -1;
}


* html .ddmx td { position: relative; } /* ie 5.0 fix */
-->
</style>

</head>

<body>

<table width="100%" height="450"><tr><td valign="top">
<div align="<?PHP echo $position; ?>" >
<table cellspacing="0" cellpadding="0" id="menu1" class="ddmx">
    <tr>
      <td>
            <a class="item1" href="javascript:void(0)">Products</a>
            <div class="section">
                <a class="item2" href="#">Product One</a>
                <a class="item2 arrow" href="javascript:void(0)">Product Two</a>
                <div class="section">
                    <a class="item2" href="#">Overview</a>
                    <a class="item2" href="#">Features</a>
                    <a class="item2" href="#">Requirements</a>
                    <a class="item2" href="#">Flash Demos</a>
                </div>
                <a class="item2 arrow" href="javascript:void(0)">Product Three</a>
                <div class="section">
                    <a class="item2" href="#">Overview</a>
                    <a class="item2" href="#">Features</a>
                    <a class="item2" href="#">Requirements</a>
                    <a class="item2" href="#">Screenshots</a>
                    <a class="item2" href="#">Flash Demos</a>
                    <a class="item2 arrow" href="javascript:void(0)">Live Demo</a>
                    <div class="section">
                        <a class="item2" href="#">Create Account</a>
                        <a class="item2 arrow" href="javascript:void(0)">Test Drive</a>
                        <div class="section">
                            <a class="item2" href="#">Test One</a>
                            <a class="item2" href="#">Test Two</a>
                            <a class="item2" href="#">Test Three</a>
                        </div>
                    </div>
                </div>
                <a class="item2 arrow" href="javascript:void(0)">Product Four</a>
                <div class="section">
                    <a class="item2" href="#">Overview</a>
                    <a class="item2" href="#">Features</a>
                    <a class="item2" href="#">Requirements</a>
                </div>
                <a class="item2" href="#">Product Five</a>
            </div>
       <?php if ($orientation=="horizontal"){echo "</td><td>";} ?>
            <a class="item1" href="javascript:void(0)">Downloads</a>
            <div class="section">
                <a class="item2" href="#">30-day Demo Key</a>
                <a class="item2 arrow" href="javascript:void(0)">Product One Download</a>
                <div class="section">
                    <a class="item2" href="#">Linux Download</a>
                    <a class="item2" href="#">Solaris Download</a>
                    <a class="item2" href="#">Windows Download</a>
                </div>
                <a class="item2 arrow" href="javascript:void(0)">Product Two Download</a>
                <div class="section">
                    <a class="item2" href="#">Linux Download</a>
                </div>
            </div>
       <?php if ($orientation=="horizontal"){echo "</td><td>";} ?>
            <a class="item1" href="javascript:void(0)">Support</a>
            <div class="section">
                <a class="item2" href="#">E-mail Support</a>
                <a class="item2" href="#">Phone Support</a>
                <a class="item2" href="#">WWW support</a>
            </div>
        <?php if ($orientation=="horizontal"){echo "</td><td>";} ?>
            <a class="item1" href="javascript:void(0)">Partners</a>
            <div class="section">
                <a class="item2" href="#">Benefits</a>
                <a class="item2 arrow" href="javascript:void(0)">Applications</a>
                <div class="section">
                    <a class="item2" href="#">Application One</a>
                    <a class="item2" href="#">Application Two</a>
                    <a class="item2" href="#">Application Three</a>
                    <a class="item2" href="#">Application Four</a>
                    <a class="item2" href="#">Application Five</a>
                    <a class="item2" href="#">Application Six</a>
                    <a class="item2" href="#">Application Seven</a>
                </div>
                <a class="item2" href="#">Listing</a>
            </div>
        <?php if ($orientation=="horizontal"){echo "</td><td>";} ?>
            <a class="item1" href="javascript:void(0)">Customers</a>
            <div class="section">
                <a class="item2" href="#">Customer One</a>
                <a class="item2" href="#">Customer Two</a>
                <a class="item2" href="#">Customer Three</a>
            </div>
        <?php if ($orientation=="horizontal"){echo "</td><td>";} ?>
            <a class="item1" href="javascript:void(0)">About Us</a>
            <div class="section">
                <a class="item2" href="#">Executive Team</a>
                <a class="item2" href="#">Investors</a>
                <a class="item2" href="#">Career Opportunities</a>
                <a class="item2 arrow" href="javascript:void(0)">Press Center</a>
                <div class="section">
                    <a class="item2" href="#">Products Information</a>
                </div>
                <a class="item2" href="#">Success Stories</a>
                <a class="item2" href="#">Contact Us</a>
            </div>
       </td>
    </tr>
    </table></div>
	</td></tr><tr><td valign="bottom">

	<table width="300" height="100" style="border:'1px solid blue';" bgcolor="yellow" align="center" ><tr>
	<td align="center">Please Select Preview Background Color</td></tr><tr>
	<td align="center">
	<select name="back_color" id="back_color" onChange="changeBG();" style = "width:'200px'"> 
                        <option  value = "white">white</option> 
                        <option  value = "red">red</option> 
                        <option  value = "blue">blue</option> 
                        <option  value = "green">green</option> 
						<option  value = "aqua">aqua</option> 
                        <option  value = "black">black</option> 
                        <option  value = "fishsia">fushsia</option> 
                        <option  value = "gray">gray</option> 
						<option  value = "lime">lime</option> 
                        <option  value = "maroon">maroon</option> 
                        <option  value = "navy">navy</option> 
                        <option  value = "olive">olive</option> 
						<option  value = "purple">purple</option> 
                        <option  value = "silver">silver</option> 
                        <option  value = "teal">teal</option> 
                        <option  value = "yellow">yellow</option> 
                      </select>
	</td></tr>
	<tr>
	    <td align="center"><a href="#" onClick="window.close()">Close Window</a></td>
	</tr>
	</table>
    </td></tr></table>

	 <script type="text/javascript">
  
	 var ddmx = new DropDownMenuX('menu1');
	 <?php if ($orientation=="vertical"){echo "ddmx.type = \"vertical\"; \n";} ?>
    ddmx.delay.show = 0;
    ddmx.delay.hide = <?PHP echo $specialB; ?>;
    ddmx.position.level1.left = <?PHP echo $level1_sub_left ? $level1_sub_left : "0"; ?>;
	ddmx.position.level1.top = <?PHP echo $level1_sub_top ? $level1_sub_top : "0"; ?>;
	ddmx.position.levelX.left = <?PHP echo $level2_sub_left ? $level2_sub_left : "0"; ?>;
	ddmx.position.levelX.top = <?PHP echo $level2_sub_top ? $level2_sub_top : "0"; ?>;
    ddmx.init();
	
    </script>


</body>
</html>

<?


}


function clickPreview(){

	$q = explode("&",$_SERVER["QUERY_STRING"]);
foreach ($q as $qi)
{
  if ($qi != "")
  {
    $qa = explode("=",$qi);
    list ($key, $val) = $qa;
    if ($val)
      $$key = urldecode($val);
  }
}
 
reset ($_POST);
while (list ($key, $val) = each ($_POST))
{
  if ($val)
    $$key = $val;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SWmenuPro Click Menu Preview</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<script type="text/javascript" src="js/ClickShowHideMenu.js"></script>

<script language="JavaScript">
<!--


function changeBG(){
document.bgColor = document.getElementById('back_color').value;
}

-->
</script>

<style type="text/css">
<!--
.click-menu {
    width: <?php echo $main_width; ?>;
	
}
.click-menu .box1 {
    background-image: URL("<?php echo "../../../".$main_back_image; ?>");
	background-color: #<?php echo $main_back; ?>;
    color: #<?php echo $main_font_color; ?>;
    font-weight: <?php echo $font_weight; ?>;
    font-size: <?php echo $main_font_size; ?>px;
    font-family: <?php echo $font_family; ?>;
    text-align: <?php echo $main_align; ?>;
	padding: <?php echo $main_padding; ?>;
   border:  <?php echo $main_border_width."px ".$main_border_style." #".$main_border_color; ?>;
	width: <?php echo $main_width.'px'; ?>;
	height: <?php echo $main_height.'px'; ?>;
    cursor: default;
    position: relative;
	
}
.click-menu .box1-hover {
	 background-image: URL("<?php echo "../../../".$main_back_image_over; ?>");
    background-color: #<?php echo $main_over; ?>;
    color: #<?php echo $main_font_color_over; ?>;
    font-weight: <?php echo $font_weight_over; ?>;
    font-size: <?php echo $main_font_size; ?>px;
    font-family: <?php echo $font_family; ?>;
    text-align: <?php echo $main_align; ?>;
	padding: <?php echo $main_padding; ?>;
    border:  <?php echo $main_border_over_width."px ".$main_border_over_style." #".$main_border_color_over; ?>;
	height: <?php echo $main_height.'px'; ?>;
    cursor: default;
    position: relative;
	
}
.click-menu .box1-open {
	 background-image: URL("<?php echo "../../../".$main_back_image_over; ?>");
   background-color: #<?php echo $main_over; ?>;
    color: #<?php echo $main_font_color_over; ?>;
    font-weight: <?php echo $font_weight_over; ?>;
    font-size: <?php echo $main_font_size; ?>px;
    font-family: <?php echo $font_family; ?>;
    text-align: <?php echo $main_align; ?>;
	padding: <?php echo $main_padding; ?>;
    border:  <?php echo $main_border_over_width."px ".$main_border_over_style." #".$main_border_color_over; ?>;
	height: <?php echo $main_height.'px'; ?>;
    cursor: default;
    position: relative;
	
}
.click-menu .box1-open-hover {
	 background-image: URL("<?php echo "../../../".$main_back_image_over; ?>");
   background-color: #<?php echo $main_over; ?>;
    color: #<?php echo $main_font_color_over; ?>;
    font-weight: <?php echo $font_weight_over; ?>;
    font-size: <?php echo $main_font_size; ?>px;
    font-family: <?php echo $font_family; ?>;
    text-align: <?php echo $main_align; ?>;
	padding: <?php echo $main_padding; ?>;
   border:  <?php echo $main_border_over_width."px ".$main_border_over_style." #".$main_border_color_over; ?>;
	height: <?php echo $main_height.'px'; ?>;
    cursor: default;
    position: relative;
	
}

.click-menu .section {
	background-image: URL("<?php echo "../../../".$sub_back_image; ?>");
    background-color: #<?php echo $sub_back; ?>;
    color: #<?php echo $sub_font_color; ?>;
    font-weight: <?php echo $font_weight; ?>;
    font-size: <?php echo $sub_font_size; ?>px;
    font-family: <?php echo $sub_font_family; ?>;
    text-align: <?php echo $sub_align; ?>;
	padding: <?php echo $sub_padding; ?>;
    border:  <?php echo $sub_border_width."px ".$sub_border_style." #".$sub_border_color; ?>;
	width: <?php echo $sub_width.'px'; ?>;
    display: none;
	filter: alpha(opacity=<?php echo $specialA; ?>)
}
.click-menu .section a {
    color: #<?php echo $sub_font_color; ?>;
    text-decoration: none;
    white-space: nowrap;
}
.click-menu .section a:hover {
    color: #<?php echo $sub_font_color_over; ?>;
    text-decoration: none;
    white-space: nowrap;
}
.click-menu .box2 {
	background-image: URL("<?php echo "../../../".$sub_back_image; ?>");
	 background-color: #<?php echo $sub_back; ?>;
    color: #<?php echo $sub_font_color; ?>;
    font-weight: <?php echo $font_weight; ?>;
    font-size: <?php echo $sub_font_size; ?>px;
    font-family: <?php echo $sub_font_family; ?>;
    text-align: <?php echo $sub_align; ?>;
	padding: <?php echo $sub_padding; ?>;
   border:  <?php echo $sub_border_width."px ".$sub_border_style." #".$sub_border_color; ?>;
	height: <?php echo $sub_height.'px'; ?>;
}
.click-menu .box2-hover {
	 background-image: URL("<?php echo "../../../".$sub_back_image_over; ?>");
    background-color: #<?php echo $sub_over; ?>;
    color: #<?php echo $sub_font_color_over; ?>;
    font-weight: <?php echo $font_weight_over; ?>;
    font-size: <?php echo $sub_font_size; ?>px;
    font-family: <?php echo $sub_font_family; ?>;
    text-align: <?php echo $sub_align; ?>;
	padding: <?php echo $sub_padding; ?>;
   border:  <?php echo $sub_border_over_width."px ".$sub_border_over_style." #".$sub_border_color_over; ?>;
	height: <?php echo $sub_height.'px'; ?>;
}


.click-menu .box1 .clickseq1,
.click-menu .box2 .clickseq1

{
	display:	inline;
}

.click-menu .box1-hover .clickseq2,
.click-menu .box1-active .clickseq2,
.click-menu .box2-hover .clickseq2,
.click-menu .box2-active .clickseq2


{
	display:	inline;
}

.click-menu .box1-hover .clickseq1,
.click-menu .box1-open .clickseq1,
.click-menu .box1-open-hover .clickseq1,
.click-menu .box1 .clickseq2,
.click-menu .box2-hover .clickseq1,
.click-menu .box2 .clickseq2

{
	display:	none;
}
-->
</style>


</head>

<body>

<table width="100%" height="450"><tr><td valign="top" align="center">
<table cellspacing="0" cellpadding="0" id="click-menu1" class="click-menu">
    <tr>
        <td>
            <div class="box1">Products </div>
            <div class="section">
                <div class="box2"><a href="#">Product One</a></div>
                <div class="box2"><a href="#">Product Two</a></div>
                <div class="box2"><a href="#">Product Three</a></div>
                <div class="box2"><a href="#">Product Four</a></div>
                <div class="box2"><a href="#">Product Five</a></div>
            </div>
        </td>
    </tr>
    <tr><td height="2"></td></tr>
    <tr>
        <td>
            <div class="box1">Downloads</div>
            <div class="section">
                <div class="box2"><a href="#">Product One</a></div>
                <div class="box2"><a href="#">Product Two</a></div>
                <div class="box2"><a href="#">Product Three</a></div>
            </div>
        </td>
    </tr>
    <tr><td height="2"></td></tr>
    <tr>
        <td>
            <div class="box1">Support </div>
            <div class="section">
                <div class="box2"><a href="#">E-mail Support</a></div>
            </div>
        </td>
    </tr>
    <tr><td height="2"></td></tr>
    <tr>
        <td>
            <div class="box1">Partners </div>
            <div class="section">
                <div class="box2"><a href="#">Partner Benefits</a></div>
                <div class="box2"><a href="#">Partner Application</a></div>
                <div class="box2"><a href="#">Partner Listing</a></div>
            </div>
        </td>
    </tr>
    <tr><td height="2"></td></tr>
    <tr>
        <td>
            <div class="box1">Customers </div>
            <div class="section">
                <div class="box2"><a href="#">Customer One</a></div>
                <div class="box2"><a href="#">Customer Two</a></div>
                <div class="box2"><a href="#">Customer Three</a></div>
                <div class="box2"><a href="#">Customer Four</a></div>
                <div class="box2"><a href="#">Customer Five</a></div>
                <div class="box2"><a href="#">Customer Six</a></div>
                <div class="box2"><a href="#">Customer Seven</a></div>
            </div>
        </td>
    </tr>
    <tr><td height="2"></td></tr>
    <tr>
        <td>
            <div class="box1">About Us </div>
            <div class="section">
                <div class="box2"><a href="#">Executive Team</a></div>
                <div class="box2"><a href="#">Investors</a></div>
                <div class="box2"><a href="#">Career</a></div>
                <div class="box2"><a href="#">Press Center</a></div>
                <div class="box2"><a href="#">Success Stories</a></div>
                <div class="box2"><a href="#">Contact Us</a></div>
            </div>
        </td>
    </tr>
    </table>

    <script type="text/javascript">
    var clickMenu1 = new ClickShowHideMenu('click-menu1');
    clickMenu1.init();
    </script>
	</td></tr><tr><td valign="bottom">

	<table width="300" height="100" style="border:'1px solid blue';" bgcolor="yellow" align="center" ><tr>
	<td align="center">Please Select Preview Background Color</td></tr><tr>
	<td align="center">
	<select name="back_color" id="back_color" onChange="changeBG();" style = "width:'200px'"> 
                        <option  value = "white">white</option> 
                        <option  value = "red">red</option> 
                        <option  value = "blue">blue</option> 
                        <option  value = "green">green</option> 
						<option  value = "aqua">aqua</option> 
                        <option  value = "black">black</option> 
                        <option  value = "fishsia">fushsia</option> 
                        <option  value = "gray">gray</option> 
						<option  value = "lime">lime</option> 
                        <option  value = "maroon">maroon</option> 
                        <option  value = "navy">navy</option> 
                        <option  value = "olive">olive</option> 
						<option  value = "purple">purple</option> 
                        <option  value = "silver">silver</option> 
                        <option  value = "teal">teal</option> 
                        <option  value = "yellow">yellow</option> 
                      </select>
	</td></tr>
	<tr>
	    <td align="center"><a href="#" onClick="window.close()">Close Window</a></td>
	</tr>
	</table>
    </td></tr></table>

	 <script type="text/javascript">
  
	 var ddmx = new DropDownMenuX('menu1');
	 <?php if ($orientation=="vertical"){echo "ddmx.type = \"vertical\"; \n";} ?>
    ddmx.delay.show = 0;
    ddmx.delay.hide = <?PHP echo $specialB; ?>;
    ddmx.position.level1.left = <?PHP echo $level1_sub_left ? $level1_sub_left : "0"; ?>;
	ddmx.position.level1.top = <?PHP echo $level1_sub_top ? $level1_sub_top : "0"; ?>;
	ddmx.position.levelX.left = <?PHP echo $level2_sub_left ? $level2_sub_left : "0"; ?>;
	ddmx.position.levelX.top = <?PHP echo $level2_sub_top ? $level2_sub_top : "0"; ?>;
    ddmx.init();
	
    </script>


</body>
</html>

<?


}



function tigraPreview(){

$q = explode("&",$_SERVER["QUERY_STRING"]);
foreach ($q as $qi)
{
  if ($qi != "")
  {
    $qa = explode("=",$qi);
    list ($key, $val) = $qa;
    if ($val)
      $$key = urldecode($val);
  }
}
 
reset ($_POST);
while (list ($key, $val) = each ($_POST))
{
  if ($val)
    $$key = $val;
}


	



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SWmenuPro Tigra Pop-Out Preview</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<script type="text/javascript" src="js/menu.js"></script>

<script language="JavaScript">
<!--


function changeBG(){
document.bgColor = document.getElementById('back_color').value;
}

-->
</script>

<style type="text/css">
<!--


.m0l0iout {
	font-family: <?php echo $font_family; ?>;
	font-size: <?php echo $main_font_size.'px'; ?>;
	text-decoration: none;
	padding: <?php echo $main_padding; ?>;
	color: #<?php echo $main_font_color; ?>;
	font-weight: <?php echo $font_weight; ?>;
	text-align: <?php echo $main_align; ?>;
	
}
.m0l0iover {
	font-family: <?php echo $font_family; ?>;
	font-size: <?php echo $main_font_size.'px'; ?>;
	text-decoration: none;
	padding: <?php echo $main_padding; ?>;
	color: #<?php echo $main_font_color_over; ?>;
	font-weight: <?php echo $font_weight_over; ?>;
	text-align: <?php echo $main_align; ?>;
		
}

.m0l0oout {
	background-image: URL("../../../<?php echo $main_back_image; ?>");
	text-decoration : none;
	border: <?php echo $main_border_width."px ".$main_border_style." #".$main_border_color; ?>;
	background-color: #<?php echo $main_back; ?>;
}

.m0l0oover {
	background-image: URL("../../../<?php echo $main_back_image_over; ?>");
	text-decoration : none;
	border: <?php echo $main_border_over_width."px ".$main_border_over_style." #".$main_border_color_over; ?>;
	background-color: #<?php echo $main_over; ?>;
}

.m0l1iout {
	font-family: <?php echo $sub_font_family; ?>;
	font-size: <?php echo $sub_font_size.'px'; ?>;
	text-decoration: none;
	padding: <?php echo $sub_padding; ?>;
	color: #<?php echo $sub_font_color; ?>;
	font-weight: <?php echo $font_weight; ?>;
	text-align: <?php echo $sub_align; ?>;
}
.m0l1iover {
	font-family: <?php echo $sub_font_family; ?>;
	font-size: <?php echo $sub_font_size.'px'; ?>;
	text-decoration: none;
	padding: <?php echo $sub_padding; ?>;
	color: #<?php echo $sub_font_color_over; ?>;
	font-weight: <?php echo $font_weight_over; ?>;
	text-align: <?php echo $sub_align; ?>;
	
}

.m0l1oout {
	background-image: URL("../../../<?php echo $sub_back_image; ?>");
	text-decoration : none;
	border: <?php echo $sub_border_width."px ".$sub_border_style." #".$sub_border_color; ?>;
	background-color: #<?php echo $sub_back; ?>;
	filter: alpha(opacity=<?php echo $specialA; ?>)

}
.m0l1oover {
	background-image: URL("../../../<?php echo $sub_back_image_over; ?>");
	text-decoration : none;
	border: <?php echo $sub_border_over_width."px ".$sub_border_over_style." #".$sub_border_color_over; ?>;
	background-color: #<?php echo $sub_over; ?>;
}

-->
</style>
<script language="javascript">

var MENU_ITEMS = [
   ['Top Item1','#',{ 'tw' : '_self' , 'sb' : 'Top Item1'},
   ['Sub Item1','#',{ 'tw' : '_self' , 'sb' : 'Sub Item1'},
   ['Sub Item18','#',{ 'tw' : '_self' , 'sb' : 'Sub Item18'}],
   ['Sub Item19','#',{ 'tw' : '_self' , 'sb' : 'Sub Item19'}],
   ['Sub Item20','#',{ 'tw' : '_self' , 'sb' : 'Sub Item20'}],],
   ['Sub Item2','#',{ 'tw' : '_self' , 'sb' : 'Sub Item2'}],
   ['Sub Item3','#',{ 'tw' : '_self' , 'sb' : 'Sub Item3'},
   ['Sub Item21','#',{ 'tw' : '_self' , 'sb' : 'Sub Item21'}],
   ['Sub Item22','#',{ 'tw' : '_self' , 'sb' : 'Sub Item22'}],],
   ['Sub Item4','#',{ 'tw' : '_self' , 'sb' : 'Sub Item4'}],],
   ['Top Item2','#',{ 'tw' : '_self' , 'sb' : 'Top Item2'},
   ['Sub Item5','#',{ 'tw' : '_self' , 'sb' : 'Sub Item5'},
   ['Sub Item23','#',{ 'tw' : '_self' , 'sb' : 'Sub Item23'}],],
   ['Sub Item6','#',{ 'tw' : '_self' , 'sb' : 'Sub Item6'},
   ['Sub Item24','#',{ 'tw' : '_self' , 'sb' : 'Sub Item24'}],
   ['Sub Item25','#',{ 'tw' : '_self' , 'sb' : 'Sub Item25'}],
   ['Sub Item26','#',{ 'tw' : '_self' , 'sb' : 'Sub Item26'}],
   ['Sub Item27','#',{ 'tw' : '_self' , 'sb' : 'Sub Item27'}],],
   ['Sub Item7','#',{ 'tw' : '_self' , 'sb' : 'Sub Item7'}],],
   ['Top Item3','#',{ 'tw' : '_self' , 'sb' : 'Top Item3'},
   ['Sub Item8','#',{ 'tw' : '_self' , 'sb' : 'Sub Item8'},
   ['Sub Item28','#',{ 'tw' : '_self' , 'sb' : 'Sub Item28'}],
   ['Sub Item29','#',{ 'tw' : '_self' , 'sb' : 'Sub Item29'}],],
   ['Sub Item9','#',{ 'tw' : '_self' , 'sb' : 'Sub Item9'}],
   ['Sub Item10','#',{ 'tw' : '_self' , 'sb' : 'Sub Item10'},
   ['Sub Item30','#',{ 'tw' : '_self' , 'sb' : 'Sub Item30'}],
   ['Sub Item31','#',{ 'tw' : '_self' , 'sb' : 'Sub Item31'}],],
   ['Sub Item11','#',{ 'tw' : '_self' , 'sb' : 'Sub Item11'}],
   ['Sub Item12','#',{ 'tw' : '_self' , 'sb' : 'Sub Item12'}],],
   ['Top Item4','#',{ 'tw' : '_self' , 'sb' : 'Top Item4'},
   ['Sub Item13','#',{ 'tw' : '_self' , 'sb' : 'Sub Item13'},
   ['Sub Item32','#',{ 'tw' : '_self' , 'sb' : 'Sub Item32'}],
   ['Sub Item33','#',{ 'tw' : '_self' , 'sb' : 'Sub Item33'}],
   ['Sub Item34','#',{ 'tw' : '_self' , 'sb' : 'Sub Item34'}],
   ['Sub Item35','#',{ 'tw' : '_self' , 'sb' : 'Sub Item35'}],
   ['Sub Item36','#',{ 'tw' : '_self' , 'sb' : 'Sub Item36'}],],
   ['Sub Item14','#',{ 'tw' : '_self' , 'sb' : 'Sub Item14'}],],
   ['Top Item5','#',{ 'tw' : '_self' , 'sb' : 'Top Item5'},
   ['Sub Item15','#',{ 'tw' : '_self' , 'sb' : 'Sub Item15'}],
   ['Sub Item16','#',{ 'tw' : '_self' , 'sb' : 'Sub Item16'}],
   ['Sub Item17','#',{ 'tw' : '_self' , 'sb' : 'Sub Item17'}],],
 ];


var MENU_POS = [
{
	
	'height': <?php echo $main_height; ?>,
	'width':  <?php echo $main_width; ?>,
	
	'block_top': 0,
	'block_left': 0,
	
	'top':  <?php if ($orientation=="vertical"){echo $main_height;}
	else {echo "0";} ?>,
	'left': <?php if ($orientation=="vertical"){echo "0";}
	else {echo $main_width;} ?>,
	
	'hide_delay': <?php echo $specialB; ?>,
	'expd_delay': <?php echo $specialB; ?>,
	'css' : {
		'outer': ['m0l0oout', 'm0l0oover'],
		'inner': ['m0l0iout', 'm0l0iover']
	}
},
{
	'height': <?php echo $sub_height; ?>,
	'width': <?php echo $sub_width; ?>,
	'block_top': <?php echo $level1_sub_top; ?>,
	'block_left':<?php echo $level1_sub_left; ?>,
	'top': <?php echo $sub_height; ?>,
	'left': 0,
	'css': {
		'outer' : ['m0l1oout', 'm0l1oover'],
		'inner' : ['m0l1iout', 'm0l1iover']
	}
},
{
	
	'block_top': <?php echo $level2_sub_top; ?>,
	'block_left':<?php echo $level2_sub_left; ?>,
	'css': {
		'outer' : ['m0l1oout', 'm0l1oover'],
		'inner' : ['m0l1iout', 'm0l1iover']
	}

}
]
</script>
</head>

<body >
<table align="center" width="100%" cellspacing="0" cellpadding="0" border="0" height="400">
	<tr>
	    <td align="center">


		<?
	echo "<div style=\"position:relative; top:0px; left:0px; width:";

if ($orientation=="vertical")
	{
	echo $main_width."px; height:".($main_height * 5)."px \" >";}
	
else {
	echo ($main_width * 5)."px; height:".$main_height."px \">";} 
	?>


<script language = "JavaScript">
<!--
 new menu (MENU_ITEMS, MENU_POS);
-->
</script>

</div></td>
	</tr>
	<tr><td align="center" valign="bottom">
	<table width="300" height="100" style="border:'1px solid blue';" bgcolor="yellow" align="center" ><tr>
	<td align="center">Please Select Preview Background Color</td></tr><tr>
	<td align="center">
	<select name="back_color" id="back_color" onChange="changeBG();" style = "width:'200px'"> 
                        <option  value = "white">white</option> 
                        <option  value = "red">red</option> 
                        <option  value = "blue">blue</option> 
                        <option  value = "green">green</option> 
						<option  value = "aqua">aqua</option> 
                        <option  value = "black">black</option> 
                        <option  value = "fishsia">fushsia</option> 
                        <option  value = "gray">gray</option> 
						<option  value = "lime">lime</option> 
                        <option  value = "maroon">maroon</option> 
                        <option  value = "navy">navy</option> 
                        <option  value = "olive">olive</option> 
						<option  value = "purple">purple</option> 
                        <option  value = "silver">silver</option> 
                        <option  value = "teal">teal</option> 
                        <option  value = "yellow">yellow</option> 
                      </select>
	</td></tr>
	<tr>
	    <td align="center"><a href="#" onClick="window.close()">Close Window</a></td>
	</tr>
	</table></td></tr>
</table>
</body>
</html>
<?
}





function treePreview(){

	$q = explode("&",$_SERVER["QUERY_STRING"]);
foreach ($q as $qi)
{
  if ($qi != "")
  {
    $qa = explode("=",$qi);
    list ($key, $val) = $qa;
    if ($val)
      $$key = urldecode($val);
  }
}
 
reset ($_POST);
while (list ($key, $val) = each ($_POST))
{
  if ($val)
    $$key = $val;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SWmenuPro Tree Menu Preview</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<script type="text/javascript" src="js/TreeMenu.js"></script>

<script language="JavaScript">
<!--


function changeBG(){
document.bgColor = document.getElementById('back_color').value;
}

-->
</script>

<style type="text/css">
<!--

ul.tree-menu {
	list-style-type: none;
	font-family: <?php echo $font_family; ?>;
	font-size: <?php echo $main_font_size.'px'; ?>;
	text-decoration: none;
	color: #<?php echo $main_font_color; ?>;
	font-weight: <?php echo $font_weight; ?>;
	text-align: <?php echo $main_align; ?>;
    width: <?php echo $main_width.'px'; ?>;
    line-height: 16px;
	border: <?php echo $main_border_width."px ".$main_border_style." #".$main_border_color; ?>;
	background-color: #<?php echo $main_back; ?>;
    margin: 0;
    padding: 0;
	
}
ul.tree-menu ul {
	
	list-style-type: none;
    margin: 0 0 0 <?php echo $level1_sub_left.'px'; ?>;
    padding: 0px 0 0 0;
}
ul.tree-menu li {
	
	
    list-style-type: none;
    margin: 0;
    padding: 0;
}
ul.tree-menu li.section {

    background-image: url("<?php echo "../../../".$main_back_image; ?>");
    background-repeat: no-repeat;
    background-position: top <?php echo $sub_align; ?>;
    padding: <?php echo $main_padding; ?>;
	
}
ul.tree-menu li.section-open {
    background-image: url("<?php echo "../../../".$main_back_image_over; ?>");
    background-repeat: no-repeat;
    background-position: top <?php echo $sub_align; ?>;
   padding: <?php echo $main_padding; ?>;
}
ul.tree-menu li.box {
	
    background-image: url("<?php echo "../../../".$sub_back_image; ?>");
    background-repeat: no-repeat;
    background-position: top <?php echo $sub_align; ?>;
    padding: <?php echo $sub_padding; ?>;
	
	
}

ul.tree-menu li.lastbox  {
	
    background-image: URL("<?php echo "../../../".$sub_back_image_over; ?>");
    background-repeat: no-repeat;
    background-position: top <?php echo $sub_align; ?>;
    padding: <?php echo $sub_padding; ?>;
	
}

ul.tree-menu a.tree-menu {
	margin-left: <?php echo $level2_sub_left.'px'; ?>;
    font-family: <?php echo $font_family; ?>;
	font-size: <?php echo $main_font_size.'px'; ?>;
	text-decoration: none;
	background-color: #<?php echo $main_back; ?>;
	color: #<?php echo $main_font_color; ?>;
	font-weight: <?php echo $font_weight; ?>;
	text-align: <?php echo $main_align; ?>;
    white-space: nowrap;
}
ul.tree-menu a.tree-menu:hover {
    margin-left: <?php echo $level2_sub_left.'px'; ?>;
    font-family: <?php echo $font_family; ?>;
	font-size: <?php echo $main_font_size.'px'; ?>;
	text-decoration: none;
	
	color: #<?php echo $main_font_color_over; ?>;
	font-weight: <?php echo $font_weight_over; ?>;
	text-align: <?php echo $main_align; ?>;
	background-color: #<?php echo $main_over; ?>;
    white-space: nowrap;
}

-->
</style>

</head>

<body>

<table width="100%" height="450"><tr><td valign="top">

<script type="text/javascript">
window.onload = function() {
    new TreeMenu("menu1");
}
</script>

<ul id="menu1" class="tree-menu">
    <li><a  class="tree-menu" href="javascript:void(0)">Products</a>
        <ul>
            <li><a class="tree-menu" href="#">Product One</a></li>
            <li><a class="tree-menu" href="javascript:void(0)">Product Two</a>
                <ul>
                    <li><a  class="tree-menu" href="#">Overview</a></li>
                    <li><a class="tree-menu" href="#">Features</a></li>
                    <li><a class="tree-menu" href="#">Requirements</a></li>
                    <li><a class="tree-menu" href="#">Flash Demos</a></li>
                </ul>
            </li>
            <li><a class="tree-menu" href="javascript:void(0)">Product Three</a>
                <ul>
                    <li><a class="tree-menu" href="#">Overview</a></li>
                    <li><a class="tree-menu" href="#">Features</a></li>
                    <li><a class="tree-menu" href="#">Requirements</a></li>
                    <li><a class="tree-menu" href="#">Screenshots</a></li>
                    <li><a class="tree-menu" href="#">Flash Demos</a></li>
                    <li><a class="tree-menu" href="javascript:void(0)">Live Demo</a>
                        <ul>
                            <li><a class="tree-menu" href="#">Create Account</a></li>
                            <li><a class="tree-menu" href="javascript:void(0)">Test Drive</a>
                                <ul>
                                    <li><a class="tree-menu" href="#">Test One</a></li>
                                    <li><a class="tree-menu" href="#">Test Two</a></li>
                                    <li><a class="tree-menu" href="#">Test Three</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a class="tree-menu" href="javascript:void(0)">Product Four</a>
                <ul>
                    <li><a class="tree-menu" href="#">Overview</a></li>
                    <li><a class="tree-menu" href="#">Features</a></li>
                    <li><a class="tree-menu" href="#">Requirements</a></li>
                </ul>
            </li>
            <li><a class="tree-menu" href="#">Product Five</a></li>
        </ul>
    </li>
    <li><a class="tree-menu" href="javascript:void(0)">Downloads</a>
        <ul>
            <li><a class="tree-menu" href="#">30-day Demo Key</a></li>
            <li><a class="tree-menu" href="javascript:void(0)">Product One Download</a>
                <ul>
                    <li><a class="tree-menu" href="#">Windows Download</a></li>
                    <li><a class="tree-menu" href="#">Solaris Download</a></li>
                    <li><a class="tree-menu" href="#">Linux Download</a></li>
                </ul>
            </li>
            <li><a class="tree-menu" href="javascript:void(0)">Product Two Download</a>
                <ul>
                    <li><a class="tree-menu" href="#">Linux Download</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li><a class="tree-menu" href="javascript:void(0)">Support</a>
        <ul>
            <li><a class="tree-menu" href="#">E-mail Support</a></li>
        </ul>
    </li>
    <li><a class="tree-menu" href="javascript:void(0)">Partners</a>
        <ul>
            <li><a class="tree-menu" href="#">Partner Benefits</a></li>
            <li><a class="tree-menu" href="javascript:void(0)">Partner Application</a>
                <ul>
                    <li><a class="tree-menu" href="#">Application One</a></li>
                    <li><a class="tree-menu" href="#">Application Two</a></li>
                    <li><a class="tree-menu" href="#">Application Three</a></li>
                    <li><a class="tree-menu" href="#">Application Four</a></li>
                    <li><a class="tree-menu" href="#">Application Five</a></li>
                    <li><a class="tree-menu" href="#">Application Six</a></li>
                    <li><a class="tree-menu" href="#">Application Seven</a></li>
                    <li><a class="tree-menu" href="#">Application Eight</a></li>
                </ul>
            </li>
            <li><a class="tree-menu" href="#">Partner Listing</a></li>
        </ul>
    </li>
    <li><a class="tree-menu" href="javascript:void(0)">Customers</a>
        <ul>
            <li><a class="tree-menu" href="#">Customer One</a></li>
            <li><a class="tree-menu" href="#">Customer Two</a></li>
            <li><a class="tree-menu" href="#">Customer Three</a></li>
        </ul>
    </li>
    <li><a class="tree-menu" href="javascript:void(0)">About Us</a>
        <ul>
            <li><a class="tree-menu" href="#">Executive Team</a></li>
            <li><a class="tree-menu" href="#">Investors</a></li>
            <li><a class="tree-menu" href="#">Career Opportunities</a></li>
            <li><a class="tree-menu" href="javascript:void(0)">Press Center</a>
                <ul>
                    <li><a class="tree-menu" href="#">Products Information</a></li>
                </ul>
            </li>
            <li><a class="tree-menu" href="#">Success Stories</a></li>
            <li><a class="tree-menu" href="#">Contact Us</a></li>
        </ul>
    </li>
</ul>


	<table width="300" height="100" style="border:'1px solid blue';" bgcolor="yellow" align="center" ><tr>
	<td align="center">Please Select Preview Background Color</td></tr><tr>
	<td align="center">
	<select name="back_color" id="back_color" onChange="changeBG();" style = "width:'200px'"> 
                        <option  value = "white">white</option> 
                        <option  value = "red">red</option> 
                        <option  value = "blue">blue</option> 
                        <option  value = "green">green</option> 
						<option  value = "aqua">aqua</option> 
                        <option  value = "black">black</option> 
                        <option  value = "fishsia">fushsia</option> 
                        <option  value = "gray">gray</option> 
						<option  value = "lime">lime</option> 
                        <option  value = "maroon">maroon</option> 
                        <option  value = "navy">navy</option> 
                        <option  value = "olive">olive</option> 
						<option  value = "purple">purple</option> 
                        <option  value = "silver">silver</option> 
                        <option  value = "teal">teal</option> 
                        <option  value = "yellow">yellow</option> 
                      </select>
	</td></tr>
	<tr>
	    <td align="center"><a href="#" onClick="window.close()">Close Window</a></td>
	</tr>
	</table>
   


</body>
</html>

<?


}
?>