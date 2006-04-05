<?
/**
* swmenupro v1.5
* http://swonline.biz
* Copyright 2004 Sean White
* DHTML Menu Component for Mambo Open Source
* Mambo Open Source is Free Software
* Released under GNU/GPL License: http://www.gnu.org/copyleft/gpl.html
**/


function ClickMenu($ordered, $swmenupro){
$name = "";
$link = "";
$topcounter = 0;
$counter = 0;
$doMenu = 1;
$uniqueID = $swmenupro['id'];
$number = count($ordered);


echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id=\"click-menu".$uniqueID."\" class=\"click-menu".$uniqueID."\" > \n";
  

while ($doMenu){

if ($ordered[$counter]['indent'] == 0){
	$hasSub = 0;
	$topcounter++;
	$image_url = "";
	$name = "";

	if ($ordered[$counter]['IMAGE'])
	{
	$image_url = "<img class = \"clickseq".$uniqueID."1\" src=\"".$ordered[$counter]['IMAGE']."\" border = \"0\" align=\"".$ordered[$counter]['IMAGEALIGN']."\"> \n";
	}
	if ($ordered[$counter]['IMAGEOVER'])
	{
	$image_url.= "<img class = \"clickseq".$uniqueID."2\" src=\"".$ordered[$counter]['IMAGEOVER']."\" border = \"0\" align=\"".$ordered[$counter]['IMAGEALIGN']."\" > \n";
	}

	if ($ordered[$counter]['SHOWNAME'] || $ordered[$counter]['SHOWNAME']==null){$name = $image_url.$ordered[$counter]['TITLE'];}else{$name = $image_url;}
	
	echo "<tr><td> \n";



	if ($counter+1 == $number){
		$doSubMenu = 0;
		$doMenu = 0;
	}elseif($ordered[$counter+1]['indent'] == 0){
		$doSubMenu = 0;
	}else{$doSubMenu = 1;}




	if ($ordered[$counter]['TARGETLEVEL']==1 || $ordered[$counter]['TARGETLEVEL']==null ){
		echo "<a href='".$ordered[$counter]['URL']."'";
	if ($ordered[$counter]['TARGET'] == "1"){echo " target = \"_blank\" >";}else{ echo " target = \"_self\" > \n";}
		echo "<div class='box1'>".$name."</div></a> \n";
		
		}else {
		echo "<div class='box1'>".$name;
		echo "</div> \n";
		} 
		


	$counter++;
	
while ($doSubMenu){
	if ($ordered[$counter]['indent'] != 0){
		if ($ordered[$counter]['indent'] > 1){
			if (($counter+1 == $number) || ($ordered[$counter+1]['indent'] == 0) ){
			$doSubMenu = 0;
			}	
			$counter++;}
		else{
			
	if (($ordered[$counter]['indent'] == 1) && ($ordered[$counter-1]['indent'] == 0)){ echo '<div class="section"> ';}

	$image_url = "";
	$name = "";

	if ($ordered[$counter]['IMAGE'])
	{
		$image_url = "<img class = \"clickseq".$uniqueID."1\" src=\"".$ordered[$counter]['IMAGE']."\" border = \"0\" align=\"".$ordered[$counter]['IMAGEALIGN']."\"> \n";
	}
	if ($ordered[$counter]['IMAGEOVER'])
	{
	$image_url.= "<img class = \"clickseq".$uniqueID."2\" src=\"".$ordered[$counter]['IMAGEOVER']."\" border = \"0\" align=\"".$ordered[$counter]['IMAGEALIGN']."\" > \n";
	}

	if ($ordered[$counter]['SHOWNAME'] || $ordered[$counter]['SHOWNAME']==null){$name = $image_url.$ordered[$counter]['TITLE'];}else{$name = $image_url;}
	
	if (($counter+1 == $number) || ($ordered[$counter+1]['indent'] == 0) ){
		$doSubMenu = 0;
		
	}
	if ($ordered[$counter]['TARGETLEVEL']==1 || $ordered[$counter]['TARGETLEVEL']==null ){
		echo "<a href='".$ordered[$counter]['URL']."'";
		if ($ordered[$counter]['TARGET'] == "1"){echo " target = \"_blank\" >";}else{ echo " target = \"_self\" > \n";}
		echo "<div class='box2'>".$name."</div></a> \n";
		
	}
	else {
		echo "<div class='box2'>".$name;
		echo "</div> \n";
		} 
	
	$counter++;
	$hasSub = 1;
	}
	}
	}
}
if ($hasSub == 1){echo "</div></td></tr> \n";}else{echo "</td></tr> \n";}
if ($counter == ($number)){ $doMenu = 0;}
}

echo "</td></tr></table> \n";
?>
 <script type="text/javascript">
	<!--
//window.onload=function(){   
var clickMenu1 = new ClickShowHideMenu('click-menu<?php echo $uniqueID; ?>');
    clickMenu1.init();
//}
-->
    </script>
	<?

}



function TreeMenu($ordered, $swmenupro){
$name = "";
$link = "";
$counter = 0;
$doMenu = 1;
$uniqueID = $swmenupro['id'];
$number = count($ordered);



echo '<ul id="menu'.$uniqueID.'" class="tree-menu'.$uniqueID.'">';
while ($doMenu){

if ($ordered[$counter]['indent'] == 0){
	$hasSub = 0;
	
	
	if ($counter+1 == $number){
		$doSubMenu = 0;
		$doMenu = 0;
		echo "<li ><a class=\"tree-menu".$uniqueID."\" href='".$ordered[$counter]['URL']."'> \n";
		echo $ordered[$counter]['TITLE']."</a></li> \n";
	}elseif($ordered[$counter+1]['indent'] == 0){
		$doSubMenu = 0;
		if (($ordered[$counter+1]['indent'] < $ordered[$counter]['indent']) ){
			echo "<li class=\"last\"><a class=\"tree-menu".$uniqueID."\" href='".$ordered[$counter]['URL']."'>";
			echo $ordered[$counter]['TITLE']."</a></li>";
		}else{
			echo "<li ><a class=\"tree-menu".$uniqueID."\" href='".$ordered[$counter]['URL']."'>";
			echo $ordered[$counter]['TITLE']."</a></li>";
		}
	}else{
		$doSubMenu = 1;
		echo "<li ><a class=\"tree-menu".$uniqueID."\" href='javascript:void(0);'>".$ordered[$counter]['TITLE']."</a>";
		}

	$counter++;
	
	while($doSubMenu){
	if ($ordered[$counter]['indent'] != 0){
		
		if ($ordered[$counter]['indent'] > $ordered[$counter-1]['indent']){ echo '<ul>';}
		if ($ordered[$counter]['indent'] < $ordered[$counter-1]['indent']){ echo "</ul>";}
		
		if ($counter+1 == $number){
		$doSubMenu = 0;
		$doMenu = 0;
		echo "<li ><a class=\"tree-menu".$uniqueID."\" href='".$ordered[$counter]['URL']."'> \n";
		echo $ordered[$counter]['TITLE']."</a></li> \n";
		}elseif ($ordered[$counter]['indent'] < $ordered[$counter + 1]['indent']){ 
			echo "<li ><a class=\"tree-menu".$uniqueID."\" href='javascript:void(0);'>".$ordered[$counter]['TITLE']."\n";
			echo "</a>\n";
			}
		else {
			
			if ($ordered[$counter+1]['indent'] < $ordered[$counter]['indent']){
			echo "<li class=\"last\"><a class=\"tree-menu".$uniqueID."\" href='".$ordered[$counter]['URL']."'> \n";
			echo $ordered[$counter]['TITLE']."</a></li>";
		}else{
			echo "<li ><a class=\"tree-menu".$uniqueID."\" href='".$ordered[$counter]['URL']."'> \n";
			echo $ordered[$counter]['TITLE']."</a></li>";
		}
		if (($counter+1 == $number) || ($ordered[$counter+1]['indent'] == 0)){
		$doSubMenu = 0;
		}
		}
		
		$counter++;
		$hasSub++;
	}}
	if ($hasSub > 0){echo str_repeat("</ul></li> \n",$ordered[$counter-1]['indent']);}
}
if ($counter == ($number)){ $doMenu = 0;}
}
?>
<script type="text/javascript">
<!--
    new TreeMenu("menu<?php echo $uniqueID; ?>");
-->
</script>
<?
}


function TigraMenu($ordered, $swmenupro){

$topcounter = 0;
$counter = 0;
$doMenu = 1;
$uniqueID = $swmenupro['id'];
$number = count($ordered);

$mymenu_content ="<script language = \"JavaScript\">\n";
$mymenu_content.="<!--\n";
$mymenu_content.="var MENU_ITEMS".$uniqueID." = [";


while ($doMenu){

if ($ordered[$counter]['indent'] == 0){
	
	$hasSub = 0;	
	$topcounter++;
	$image_url = "";
	$name = "";
	if ($ordered[$counter]['IMAGE'])
	{
	$image_url = "<img class = \"seq".$uniqueID."1\" src=\"".$ordered[$counter]['IMAGE']."\" border = \"0\" align=\"".$ordered[$counter]['IMAGEALIGN']."\" vspace=\"0\" hspace=\"0\">";
	}
	if ($ordered[$counter]['IMAGEOVER'] != "")
	{
	$image_url.= "<img class = \"seq".$uniqueID."2\" src=\"".$ordered[$counter]['IMAGEOVER']."\" border = \"0\" align=\"".$ordered[$counter]['IMAGEALIGN']."\" vspace=\"0\" hspace=\"0\">";
	}

	if ($ordered[$counter]['SHOWNAME'] || $ordered[$counter]['SHOWNAME']==null){$name = addslashes($image_url.$ordered[$counter]['TITLE']);}else{$name = $image_url;}
	
	if ($ordered[$counter]['TARGETLEVEL']==1 || $ordered[$counter]['TARGETLEVEL']==null ){$name.= "','".$ordered[$counter]['URL']."',";}else{$name.= "','',";}

	if ($ordered[$counter]['TARGET'] >= "1"){$name.= "{ 'tw' : '_blank' , 'sb' : '".addslashes($ordered[$counter]['TITLE'])."'}";}else{$name.= "{ 'tw' : '_self' , 'sb' : '".addslashes($ordered[$counter]['TITLE'])."'}";}

	
	
	if ($counter+1 == $number){
		$mymenu_content.="\n   ['".$name."],";
		$doSubMenu = 0;
		$doMenu = 0;
	}elseif($ordered[$counter+1]['indent'] == 0){
		$mymenu_content.="\n   ['".$name."],";
		$doSubMenu = 0;
	}else{
		$mymenu_content.="\n   ['".$name.",";
		$doSubMenu = 1;
		
		} 
	$counter++;
	
	
	while ($doSubMenu){
	
	if ($ordered[$counter]['indent'] != 0) {
		$image_url = "";
		$name = "";
	
	if ($ordered[$counter]['IMAGE'] != "")
	{
	$image_url = "<img class = \"seq".$uniqueID."1\" src=\"".$ordered[$counter]['IMAGE']."\" border = \"0\" align=\"".$ordered[$counter]['IMAGEALIGN']."\"vspace=\"0\" hspace=\"0\">";
	}
	if ($ordered[$counter]['IMAGEOVER'] != "")
	{
	$image_url.= "<img class = \"seq".$uniqueID."2\" src=\"".$ordered[$counter]['IMAGEOVER']."\" border = \"0\" align=\"".$ordered[$counter]['IMAGEALIGN']."\" vspace=\"0\" hspace=\"0\" >";
	}

	if ($ordered[$counter]['SHOWNAME'] || $ordered[$counter]['SHOWNAME']==null){$name = addslashes($image_url.$ordered[$counter]['TITLE']);}else{$name = $image_url;}

	if ($ordered[$counter]['TARGETLEVEL']==1 || $ordered[$counter]['TARGETLEVEL']==null ){$name.= "','".$ordered[$counter]['URL']."',";}else{$name.= "','',";}

	if ($ordered[$counter]['TARGET'] >= "1"){$name.= "{ 'tw' : '_blank' , 'sb' : '".addslashes($ordered[$counter]['TITLE'])."'}";}else{$name.= "{ 'tw' : '_self' , 'sb' : '".addslashes($ordered[$counter]['TITLE'])."'}";}

	if ($counter+1 == $number){
		$mymenu_content.="\n   ['".$name.str_repeat('],',($ordered[$counter]['indent']+1));	
		$doSubMenu = 0;
		$doMenu = 0;
	}elseif ($ordered[$counter]['indent'] < $ordered[$counter+1]['indent']){ 
		$mymenu_content.="\n   ['".$name.",";
		if ($ordered[$counter+1]['indent'] == 0){ $doSubMenu = 0;}
		}
	elseif ($ordered[$counter]['indent'] == $ordered[$counter+1]['indent']){ 
		$mymenu_content.="\n   ['".$name."],";
		if ($ordered[$counter+1]['indent'] == 0){ $doSubMenu = 0;}
		}
	elseif (($ordered[$counter]['indent'] > $ordered[$counter+1]['indent'])){ 
	   $mymenu_content.="\n   ['".$name.str_repeat('],',(($ordered[$counter]['indent'])-($ordered[$counter+1]['indent'])+1));	
	   if ($ordered[$counter+1]['indent'] == 0){ $doSubMenu = 0;}
		}	
	
	$counter++;
	$hasSub++;
	
	}
}
}
}

$mymenu_content .= "\n ];";
$mymenu_content .= "\n -->";
$mymenu_content .= "\n </SCRIPT> \n";

echo $mymenu_content;
?>
<script language = "JavaScript">
<!--
var MENU_POS<?php echo $uniqueID; ?> = [
{
	// item sizes
	'height': <?php 
		if ((getBrowser()=="ie") || (getBrowser()=="ie6")){
		$border1 = explode(" ", $swmenupro['main_border']);	
		$offset=rtrim(trim($border1[0]),'px');
	}else{ $offset=0;}
		echo ($swmenupro['main_height']+$offset);
	?>,
	'width':  <?php	echo ($swmenupro['main_width']+$offset);
	?>,
	// menu block offset from the origin:
	//	for root level origin is upper left corner of the page
	//	for other levels origin is upper left corner of parent item
	'block_top': <?php echo $swmenupro['main_top']; ?>,
	'block_left':  <?php echo $swmenupro['main_left']; ?>,
	// offsets between items of the same level
	'top':  <?php if ($swmenupro['orientation']=="vertical"){
	if ((getBrowser()=="ns") || (getBrowser()=="ns6")){
		$border1 = explode(" ", $swmenupro['main_border']);	
		$offset3=rtrim(trim($border1[0]),'px');
	}else{ $offset3=0;}
		echo ($swmenupro['main_height']+$offset3);
	
	}else {echo "0";} ?>,
	'left': <?php if ($swmenupro['orientation']=="vertical"){echo "0";}
	else {echo $swmenupro['main_width'];} ?>,
	// time in milliseconds before menu is hidden after cursor has gone out
	// of any items
	'hide_delay': <?php echo $swmenupro['specialB']; ?>,
	'expd_delay': <?php echo $swmenupro['specialB']; ?>,
	'css' : {
		'outer': ['m0l0oout<?php echo $uniqueID; ?>', 'm0l0oover<?php echo $uniqueID; ?>'],
		'inner': ['m0l0iout<?php echo $uniqueID; ?>', 'm0l0iover<?php echo $uniqueID; ?>']
	}
},
{
	'height': <?php 
		if ((getBrowser()=="ie") || (getBrowser()=="ie6")){
		$border2 = explode(" ", $swmenupro['sub_border']);	
		$offset2=rtrim(trim($border2[0]),'px');
		}else{ $offset2=0;}
		echo ($swmenupro['sub_height']+$offset2);
	?>,
	'width': <?php 	echo ($swmenupro['sub_width']+$offset2);
	?>,
	'block_top': <?php echo $swmenupro['level1_sub_top']; ?>,
	'block_left':<?php echo $swmenupro['level1_sub_left']; ?>,
	'top': <?php 
		if ((getBrowser()=="ns") || (getBrowser()=="ns6")){
		$border1 = explode(" ", $swmenupro['sub_border']);	
		$offset3=rtrim(trim($border1[0]),'px');
	}else{ $offset3=0;}
		echo ($swmenupro['sub_height']+$offset3); ?>,
	'left': 0,
	'css': {
		'outer' : ['m0l1oout<?php echo $uniqueID; ?>', 'm0l1oover<?php echo $uniqueID; ?>'],
		'inner' : ['m0l1iout<?php echo $uniqueID; ?>', 'm0l1iover<?php echo $uniqueID; ?>']
	}
},
{
	
	'block_top': <?php echo $swmenupro['level2_sub_top']; ?>,
	'block_left':<?php echo $swmenupro['level2_sub_left']; ?>,
	'css': {
		'outer' : ['m0l1oout<?php echo $uniqueID; ?>', 'm0l1oover<?php echo $uniqueID; ?>'],
		'inner' : ['m0l1iout<?php echo $uniqueID; ?>', 'm0l1iover<?php echo $uniqueID; ?>']
	}

}
]
-->
</script>
<?
	if ((getBrowser()=="ns") || (getBrowser()=="ns6")){
	$border1 = explode(" ", $swmenupro['main_border']);	
	$offset3=rtrim(trim($border1[0]),'px');
	$swmenupro['main_height'] = $swmenupro['main_height'] + $offset3;
	//$swmenupro['main_width'] = $swmenupro['main_width'] + $offset3;
}
	echo "<div style=\"position:".$swmenupro['position'].";z-index:1; top:0px; left:0px; width:";

if ($swmenupro['orientation']=="vertical"){echo $swmenupro['main_width']."px; height:".(($swmenupro['main_height']*$topcounter))."px \" >";}
	else {echo (($swmenupro['main_width']*$topcounter))."px; height:".$swmenupro['main_height']."px \">";} 
	?>



<script language = "JavaScript">
<!--
 new menu (MENU_ITEMS<?php echo $uniqueID; ?>, MENU_POS<?php echo $uniqueID; ?>);
-->
</script>

</div>
<?php
}

function chain($primary_field, $parent_field, $sort_field, $rows, $root_id=0, $maxlevel=25)
{
   $c = new chain($primary_field, $parent_field, $sort_field, $rows, $root_id, $maxlevel);
   return $c->chain_table;
}

class chain
{
   var $table;
   var $rows;
   var $chain_table;
   var $primary_field;
   var $parent_field;
   var $sort_field;

   function chain($primary_field, $parent_field, $sort_field, $rows, $root_id, $maxlevel)
   {
       $this->rows = $rows;
       $this->primary_field = $primary_field;
       $this->parent_field = $parent_field;
       $this->sort_field = $sort_field;
       $this->buildChain($root_id,$maxlevel);
   }

   function buildChain($rootcatid,$maxlevel)
   {
       foreach($this->rows as $row)
       {
           $this->table[$row[$this->parent_field]][ $row[$this->primary_field]] = $row;
       }
       $this->makeBranch($rootcatid,0,$maxlevel);
   }

   function makeBranch($parent_id,$level,$maxlevel)
   {
       $rows=$this->table[$parent_id];
       foreach($rows as $key=>$value)
       {
           $rows[$key]['key'] = $this->sort_field;
       }

       usort($rows,'chainCMP');
       foreach($rows as $item)
       {
           $item['indent'] = $level;
           $this->chain_table[] = $item;
           if((isset($this->table[$item[$this->primary_field]])) && (($maxlevel>$level+1) || ($maxlevel==0)))
           {
               $this->makeBranch($item[$this->primary_field], $level+1, $maxlevel);
           }
       }
   }
}

function chainCMP($a,$b)
{
   if($a[$a['key']] == $b[$b['key']])
   {
       return 0;
   }
   return($a[$a['key']]<$b[$b['key']])?-1:1;
}







function doClickMenu($ordered, $swmenupro){

include_once( "modules/mod_swmenupro/load_script_click.php" );
if ((getBrowser()=="ns") || (getBrowser()=="ns6")){fixPadding(&$swmenupro);}
echo ClickMenuStyle($swmenupro);
echo ClickMenu($ordered, $swmenupro);
}


function doTreeMenu($ordered, $swmenupro){

include_once( "modules/mod_swmenupro/load_script_tree.php" );
echo TreeMenuStyle($swmenupro);
echo TreeMenu($ordered, $swmenupro);
}


function doPopoutMenu($ordered, $swmenupro){

include_once( "modules/mod_swmenupro/load_script.php" );
echo TigraMenuStyle($swmenupro);
echo TigraMenu($ordered, $swmenupro);
}


function doGosuMenu($ordered, $swmenupro){

include_once( "modules/mod_swmenupro/load_script_gosu.php" );
if ((getBrowser()=="ns") || (getBrowser()=="ns6")){fixPadding(&$swmenupro);}
echo gosuMenuStyle($swmenupro);
echo GosuMenu($ordered, $swmenupro);
}




function GosuMenu($ordered, $swmenupro){


?>



<div align="<?php echo $swmenupro['position']; ?>">

<?
$name = "";
$link = "";
$topcounter = 0;
$counter = 0;
$doMenu = 1;
$uniqueID = $swmenupro['id'];
$number = count($ordered);


echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id=\"menu".$uniqueID."\" class=\"ddmx".$uniqueID."\" ><tr> \n";
if ($swmenupro['orientation']=="vertical"){echo "<td> \n";}

while ($doMenu){

if ($ordered[$counter]['indent'] == 0){
	$image_url = "";
	$name = "";
	
	if ($ordered[$counter]['IMAGE'] != "")
	{
	$image_url = "<img class=\"seq1\" src=\"".$ordered[$counter]['IMAGE']."\" border = \"0\" align=\"top\" vspace=\"0\" hspace=\"0\">";
	}
	if ($ordered[$counter]['IMAGEOVER'] != "")
	{
	$image_url.= "<img class=\"seq2\" src=\"".$ordered[$counter]['IMAGEOVER']."\" border = \"0\" align=\"top\" vspace=\"0\" hspace=\"0\" >";
	}

	if ($ordered[$counter]['SHOWNAME'] || $ordered[$counter]['SHOWNAME']==null){
		
		if ($ordered[$counter]['IMAGEALIGN']=="left"){
		$name = $image_url.addslashes($ordered[$counter]['TITLE']);
		}else{

		$name = addslashes($ordered[$counter]['TITLE']).$image_url;
		}
		
		}else{$name = $image_url;}

	
	
	if ($swmenupro['orientation']=="horizontal"){echo "<td> \n";}

	if (($ordered[$counter]['TARGET'] == "1") && (($ordered[$counter]['TARGETLEVEL'] == "1") || $ordered[$counter]['TARGETLEVEL']==null )){
		echo "<a class='item1' href='".$ordered[$counter]['URL']."' target = \"_blank\" >";
		
	}elseif(($ordered[$counter]['TARGET'] != "1") && (($ordered[$counter]['TARGETLEVEL'] == "1") || $ordered[$counter]['TARGETLEVEL']==null )){
		echo "<a class='item1' href='".$ordered[$counter]['URL']."' target = \"_self\" > \n";
	}else{ 
		echo "<a class='item1' href=\"javascript: void(0)\" > \n";
	}
	
	echo $name." </a> \n";



	if ($counter+1 == $number){
		$doSubMenu = 0;
		$doMenu = 0;
	}elseif($ordered[$counter+1]['indent'] == 0){
		$doSubMenu = 0;
	}else{$doSubMenu = 1;}


	$counter++;
	
while ($doSubMenu){
	if ($ordered[$counter]['indent'] != 0){
	if ($ordered[$counter]['indent'] > $ordered[$counter-1]['indent']){ echo '<div class="section"> ';}
	
	$image_url = "";
	$name = "";
	
	if ($ordered[$counter]['IMAGE'] != "")
	{
	$image_url = "<img class=\"seq1\" src=\"".$ordered[$counter]['IMAGE']."\" border = \"0\" align=\"top\" vspace=\"0\" hspace=\"0\">";
	}
	if ($ordered[$counter]['IMAGEOVER'] != "")
	{
	$image_url.= "<img class=\"seq2\" src=\"".$ordered[$counter]['IMAGEOVER']."\" border = \"0\" align=\"top\" vspace=\"0\" hspace=\"0\" >";
	}

	if ($ordered[$counter]['SHOWNAME'] || $ordered[$counter]['SHOWNAME']==null){
		
		if ($ordered[$counter]['IMAGEALIGN']=="left"){
		$name = $image_url.addslashes($ordered[$counter]['TITLE']);
		}else{

		$name = addslashes($ordered[$counter]['TITLE']).$image_url;
		}
		
		}else{$name = $image_url;}

	
	
	if (($counter+1 == $number) || ($ordered[$counter+1]['indent'] == 0) ){
		$doSubMenu = 0;
		
	}
	if (($ordered[$counter]['TARGET'] == "1") && (($ordered[$counter]['TARGETLEVEL'] == "1") || $ordered[$counter]['TARGETLEVEL']==null )){
		echo "<a class='item2' href='".$ordered[$counter]['URL']."' target = \"_blank\" >";
		
	}elseif(($ordered[$counter]['TARGET'] != "1") && (($ordered[$counter]['TARGETLEVEL'] == "1") || $ordered[$counter]['TARGETLEVEL']==null )){
		echo "<a class='item2' href='".$ordered[$counter]['URL']."' target = \"_self\" > \n";
		
	}else{ 
		echo "<a class='item2'  href=\"javascript: void(0)\" > \n";
	}
	
	echo $name." </a> \n";

	


	if (($counter+1 == $number) || ($ordered[$counter+1]['indent'] < $ordered[$counter]['indent'])){

	echo str_repeat('</div>',(($ordered[$counter]['indent'])-(@$ordered[$counter+1]['indent'])));
	
	}
	$counter++;
	}
	
	}
}
if ($swmenupro['orientation']=="horizontal"){echo "</td> \n";}
if ($counter == ($number)){ $doMenu = 0;}
}
if ($swmenupro['orientation']=="vertical"){echo "<td> \n";}
echo "</tr></table></div> \n";
?>
 <script type="text/javascript">
	<!--
window.onload=function(){
	


var ddmx<?php echo $uniqueID; ?> = new DropDownMenuX('menu<?php echo $uniqueID; ?>');
    <?PHP if ($swmenupro['orientation']=="vertical"){echo "ddmx".$uniqueID.".type = \"vertical\"; \n";} ?>
	ddmx<?php echo $uniqueID; ?>.delay.show = 0;
    ddmx<?php echo $uniqueID; ?>.delay.hide = <?php echo $swmenupro['specialB']; ?>;
    ddmx<?php echo $uniqueID; ?>.position.levelX.left = <?php echo$swmenupro['level2_sub_left']; ?>;
	ddmx<?php echo $uniqueID; ?>.position.levelX.top = <?php echo $swmenupro['level2_sub_top']; ?>;
	ddmx<?php echo $uniqueID; ?>.position.level1.left = <?php echo $swmenupro['level1_sub_left']; ?>;
	ddmx<?php echo $uniqueID; ?>.position.level1.top = <?php echo $swmenupro['level1_sub_top']; ?>;
    ddmx<?php echo $uniqueID; ?>.init();
	}
	-->
    </script>



	<?
}
function getBrowser(){
  unset($browser);
  $browser = 'ns'; // Default browser
  if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera')) $browser = 'op';   
  elseif (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 6')) $browser = 'ie6'; 
  elseif (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie')) $browser = 'ie'; 
  elseif (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mozilla')) $browser = 'ns'; 
  if (stristr($_SERVER['HTTP_USER_AGENT'], 'Gecko/200') && (!(stristr($HTTP_USER_AGENT, 'compatible')))) $browser = 'ns6';
  return($browser);
}

function fixPadding(&$swmenupro){

	$padding1 = explode("px", $swmenupro['main_padding']);
	$padding2 = explode("px", $swmenupro['sub_padding']);
	for($i=0;$i<4; $i++){
	$padding1[$i]=trim($padding1[$i]);
	$padding2[$i]=trim($padding2[$i]);
	}
$swmenupro['main_width'] = ($swmenupro['main_width'] - ($padding1[1]+$padding1[3]));
$swmenupro['main_height'] = ($swmenupro['main_height'] - ($padding1[0]+$padding1[2]));
$swmenupro['sub_width'] = ($swmenupro['sub_width'] - ($padding2[1]+$padding2[3]));
$swmenupro['sub_height'] = ($swmenupro['sub_height'] - ($padding2[0]+$padding2[2]));
return($swmenupro);


}


?>