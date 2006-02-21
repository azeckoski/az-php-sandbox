<?
/**
* swmenupro v1.5
* http://swonline.biz
* Copyright 2004 Sean White
* DHTML Menu Component for Mambo Open Source
* Mambo Open Source is Free Software
* Released under GNU/GPL License: http://www.gnu.org/copyleft/gpl.html
**/


function ClickMenuStyle($swmenupro){
?>

<style type="text/css">
<!--
.click-menu<?php echo $swmenupro['id']; ?> {
    width: <?php echo $swmenupro['main_width']; ?>;
	
}
.click-menu<?php echo $swmenupro['id']; ?> .box1 {
    background-image: URL("<?php echo $swmenupro['main_back_image']; ?>");
	background-color: <?php echo $swmenupro['main_back']; ?>;
    color: <?php echo $swmenupro['main_font_color']; ?>;
    font-weight: <?php echo $swmenupro['font_weight']; ?>;
    font-size: <?php echo $swmenupro['main_font_size']; ?>px;
    font-family: <?php echo $swmenupro['font_family']; ?>;
    text-align: <?php echo $swmenupro['main_align']; ?>;
	padding: <?php echo $swmenupro['main_padding']; ?>;
    border: <?php echo $swmenupro['main_border']; ?>;
	width: <?php echo $swmenupro['main_width'].'px'; ?>;
	height: <?php echo $swmenupro['main_height'].'px'; ?>;
    cursor: default;
    position: relative;
	
}
.click-menu<?php echo $swmenupro['id']; ?> .box1-hover {
	 background-image: URL("<?php echo $swmenupro['main_back_image_over']; ?>");
    background-color: <?php echo $swmenupro['main_over']; ?>;
    color: <?php echo $swmenupro['main_font_color_over']; ?>;
    font-weight: <?php echo $swmenupro['font_weight_over']; ?>;
    font-size: <?php echo $swmenupro['main_font_size']; ?>px;
    font-family: <?php echo $swmenupro['font_family']; ?>;
    text-align: <?php echo $swmenupro['main_align']; ?>;
	padding: <?php echo $swmenupro['main_padding']; ?>;
    border: <?php echo $swmenupro['main_border_over']; ?>;
	height: <?php echo $swmenupro['main_height'].'px'; ?>;
    cursor: default;
    position: relative;
	
}
.click-menu<?php echo $swmenupro['id']; ?> .box1-open {
	 background-image: URL("<?php echo $swmenupro['main_back_image_over']; ?>");
   background-color: <?php echo $swmenupro['main_over']; ?>;
    color: <?php echo $swmenupro['main_font_color_over']; ?>;
    font-weight: <?php echo $swmenupro['font_weight_over']; ?>;
    font-size: <?php echo $swmenupro['main_font_size']; ?>px;
    font-family: <?php echo $swmenupro['font_family']; ?>;
    text-align: <?php echo $swmenupro['main_align']; ?>;
	padding: <?php echo $swmenupro['main_padding']; ?>;
    border: <?php echo $swmenupro['main_border_over']; ?>;
	height: <?php echo $swmenupro['main_height'].'px'; ?>;
    cursor: default;
    position: relative;
	
}
.click-menu<?php echo $swmenupro['id']; ?> .box1-open-hover {
	 background-image: URL("<?php echo $swmenupro['main_back_image_over']; ?>");
   background-color: <?php echo $swmenupro['main_over']; ?>;
    color: <?php echo $swmenupro['main_font_color_over']; ?>;
    font-weight: <?php echo $swmenupro['font_weight_over']; ?>;
    font-size: <?php echo $swmenupro['main_font_size']; ?>px;
    font-family: <?php echo $swmenupro['font_family']; ?>;
    text-align: <?php echo $swmenupro['main_align']; ?>;
	padding: <?php echo $swmenupro['main_padding']; ?>;
    border: <?php echo $swmenupro['main_border_over']; ?>;
	height: <?php echo $swmenupro['main_height'].'px'; ?>;
    cursor: default;
    position: relative;
	
}

.click-menu<?php echo $swmenupro['id']; ?> .section {
	background-image: URL("<?php echo $swmenupro['sub_back_image']; ?>");
    background-color: <?php echo $swmenupro['sub_back']; ?>;
    color: <?php echo $swmenupro['sub_font_color']; ?>;
    font-weight: <?php echo $swmenupro['font_weight']; ?>;
    font-size: <?php echo $swmenupro['sub_font_size']; ?>px;
    font-family: <?php echo $swmenupro['sub_font_family']; ?>;
    text-align: <?php echo $swmenupro['sub_align']; ?>;
	padding: <?php echo $swmenupro['sub_padding']; ?>;
    border: <?php echo $swmenupro['sub_border']; ?>;
	width: <?php echo $swmenupro['sub_width'].'px'; ?>;
    display: none;
	filter: alpha(opacity=<?php echo $swmenupro['specialA']; ?>)
}
.click-menu<?php echo $swmenupro['id']; ?> .section a {
    color: <?php echo $swmenupro['sub_font_color']; ?>;
    text-decoration: none;
    white-space: nowrap;
}
.click-menu<?php echo $swmenupro['id']; ?> .section a:hover {
    color: <?php echo $swmenupro['sub_font_color_over']; ?>;
    text-decoration: none;
    white-space: nowrap;
}
.click-menu<?php echo $swmenupro['id']; ?> .box2 {
	background-image: URL("<?php echo $swmenupro['sub_back_image']; ?>");
	 background-color: <?php echo $swmenupro['sub_back']; ?>;
    color: <?php echo $swmenupro['sub_font_color']; ?>;
    font-weight: <?php echo $swmenupro['font_weight']; ?>;
    font-size: <?php echo $swmenupro['sub_font_size']; ?>px;
    font-family: <?php echo $swmenupro['sub_font_family']; ?>;
    text-align: <?php echo $swmenupro['sub_align']; ?>;
	padding: <?php echo $swmenupro['sub_padding']; ?>;
    border: <?php echo $swmenupro['sub_border']; ?>;
	height: <?php echo $swmenupro['sub_height'].'px'; ?>;
}
.click-menu<?php echo $swmenupro['id']; ?> .box2-hover {
	 background-image: URL("<?php echo $swmenupro['sub_back_image_over']; ?>");
    background-color: <?php echo $swmenupro['sub_over']; ?>;
    color: <?php echo $swmenupro['sub_font_color_over']; ?>;
    font-weight: <?php echo $swmenupro['font_weight_over']; ?>;
    font-size: <?php echo $swmenupro['sub_font_size']; ?>px;
    font-family: <?php echo $swmenupro['sub_font_family']; ?>;
    text-align: <?php echo $swmenupro['sub_align']; ?>;
	padding: <?php echo $swmenupro['sub_padding']; ?>;
    border: <?php echo $swmenupro['sub_border_over']; ?>;
	height: <?php echo $swmenupro['sub_height'].'px'; ?>;
}


.click-menu<?php echo $swmenupro['id']; ?> .box1 .clickseq<?php echo $swmenupro['id']; ?>1,
.click-menu<?php echo $swmenupro['id']; ?> .box2 .clickseq<?php echo $swmenupro['id']; ?>1

{
	display:	inline;
}

.click-menu<?php echo $swmenupro['id']; ?> .box1-hover .clickseq<?php echo $swmenupro['id']; ?>2,
.click-menu<?php echo $swmenupro['id']; ?> .box1-active .clickseq<?php echo $swmenupro['id']; ?>2,
.click-menu<?php echo $swmenupro['id']; ?> .box2-hover .clickseq<?php echo $swmenupro['id']; ?>2,
.click-menu<?php echo $swmenupro['id']; ?> .box2-active .clickseq<?php echo $swmenupro['id']; ?>2


{
	display:	inline;
}

.click-menu<?php echo $swmenupro['id']; ?> .box1-hover .clickseq<?php echo $swmenupro['id']; ?>1,
.click-menu<?php echo $swmenupro['id']; ?> .box1-open .clickseq<?php echo $swmenupro['id']; ?>1,
.click-menu<?php echo $swmenupro['id']; ?> .box1-open-hover .clickseq<?php echo $swmenupro['id']; ?>1,
.click-menu<?php echo $swmenupro['id']; ?> .box1 .clickseq<?php echo $swmenupro['id']; ?>2,
.click-menu<?php echo $swmenupro['id']; ?> .box2-hover .clickseq<?php echo $swmenupro['id']; ?>1,
.click-menu<?php echo $swmenupro['id']; ?> .box2 .clickseq<?php echo $swmenupro['id']; ?>2

{
	display:	none;
}
-->
</style>

<?
}


function TigraMenuStyle($swmenupro){
?>

<style type="text/css">
<!--


.m0l0iout<?php echo $swmenupro['id']; ?> {
	font-family: <?php echo $swmenupro['font_family']; ?>;
	font-size: <?php echo $swmenupro['main_font_size'].'px'; ?>;
	text-decoration: none;
	padding: <?php echo $swmenupro['main_padding']; ?>;
	color: <?php echo $swmenupro['main_font_color']; ?>;
	font-weight: <?php echo $swmenupro['font_weight']; ?>;
	text-align: <?php echo $swmenupro['main_align']; ?>;
	
}
.m0l0iover<?php echo $swmenupro['id']; ?> {
	font-family: <?php echo $swmenupro['font_family']; ?>;
	font-size: <?php echo $swmenupro['main_font_size'].'px'; ?>;
	text-decoration: none;
	padding: <?php echo $swmenupro['main_padding']; ?>;
	color: <?php echo $swmenupro['main_font_color_over']; ?>;
	font-weight: <?php echo $swmenupro['font_weight_over']; ?>;
	text-align: <?php echo $swmenupro['main_align']; ?>;
		
}


.m0l0oout<?php echo $swmenupro['id']; ?> {
	text-decoration : none;
	border: <?php echo $swmenupro['main_border']; ?>;
	background-image: URL("<?php echo $swmenupro['main_back_image']; ?>");
	background-color: <?php echo $swmenupro['main_back']; ?>;
	
}
.m0l0oover<?php echo $swmenupro['id']; ?> {
	text-decoration : none;
	border: <?php echo $swmenupro['main_border_over']; ?>;
	background-image: URL("<?php echo $swmenupro['main_back_image_over']; ?>");
	background-color: <?php echo $swmenupro['main_over']; ?>;
	
}


.m0l1iout<?php echo $swmenupro['id']; ?> {
	font-family: <?php echo $swmenupro['sub_font_family']; ?>;
	font-size: <?php echo $swmenupro['sub_font_size'].'px'; ?>;
	text-decoration: none;
	padding: <?php echo $swmenupro['sub_padding']; ?>;
	color: <?php echo $swmenupro['sub_font_color']; ?>;
	font-weight: <?php echo $swmenupro['font_weight']; ?>;
	text-align: <?php echo $swmenupro['sub_align']; ?>;
}
.m0l1iover<?php echo $swmenupro['id']; ?> {
	font-family: <?php echo $swmenupro['sub_font_family']; ?>;
	font-size: <?php echo $swmenupro['sub_font_size'].'px'; ?>;
	text-decoration: none;
	padding: <?php echo $swmenupro['sub_padding']; ?>;
	color: <?php echo $swmenupro['sub_font_color_over']; ?>;
	font-weight: <?php echo $swmenupro['font_weight_over']; ?>;
	text-align: <?php echo $swmenupro['sub_align']; ?>;
	
}


.m0l1oout<?php echo $swmenupro['id']; ?> {
	text-decoration : none;
	border: <?php echo $swmenupro['sub_border']; ?>;
	background-image: URL("<?php echo $swmenupro['sub_back_image']; ?>");
	background-color: <?php echo $swmenupro['sub_back']; ?>;
	filter: alpha(opacity=<?php echo $swmenupro['specialA']; ?>);
	-moz-opacity:<?php echo ($swmenupro['specialA']/100); ?>;

}
.m0l1oover<?php echo $swmenupro['id']; ?> {
	text-decoration : none;
	border: <?php echo $swmenupro['sub_border_over']; ?>;
	background-image: URL("<?php echo $swmenupro['sub_back_image_over']; ?>");
	background-color: <?php echo $swmenupro['sub_over']; ?>;
}

.m0l0oout<?php echo $swmenupro['id']; ?> img.seq<?php echo $swmenupro['id']; ?>1,
.m0l1oout<?php echo $swmenupro['id']; ?> img.seq<?php echo $swmenupro['id']; ?>1
{
	display:	inline;
}

.m0l1oover<?php echo $swmenupro['id']; ?>Hover seq<?php echo $swmenupro['id']; ?>2,
.m0l1oover<?php echo $swmenupro['id']; ?>Active seq<?php echo $swmenupro['id']; ?>2,
.m0l0oover<?php echo $swmenupro['id']; ?>Hover seq<?php echo $swmenupro['id']; ?>2,
.m0l0oover<?php echo $swmenupro['id']; ?>Active seq<?php echo $swmenupro['id']; ?>2
{
	display:	inline;
}

.m0l0oout<?php echo $swmenupro['id']; ?> .seq<?php echo $swmenupro['id']; ?>2,
.m0l0oout<?php echo $swmenupro['id']; ?> .seq<?php echo $swmenupro['id']; ?>1,
.m0l0oover<?php echo $swmenupro['id']; ?> .seq<?php echo $swmenupro['id']; ?>1,
.m0l1oout<?php echo $swmenupro['id']; ?> .seq<?php echo $swmenupro['id']; ?>2,
.m0l1oout<?php echo $swmenupro['id']; ?> .seq<?php echo $swmenupro['id']; ?>1,
.m0l1oover<?php echo $swmenupro['id']; ?> .seq<?php echo $swmenupro['id']; ?>1
{
	display:	none;
}
-->
</style>

<?
}

function TreeMenuStyle($swmenupro){
?>

<style type="text/css">
<!--

ul.tree-menu<?php echo $swmenupro['id']; ?> {
	list-style-type: none;
	font-family: <?php echo $swmenupro['font_family']; ?>;
	font-size: <?php echo $swmenupro['main_font_size'].'px'; ?>;
	text-decoration: none;
	color: <?php echo $swmenupro['main_font_color']; ?>;
	font-weight: <?php echo $swmenupro['font_weight']; ?>;
	text-align: <?php echo $swmenupro['main_align']; ?>;
    width: <?php echo $swmenupro['main_width'].'px'; ?>;
    line-height: 16px;
	border: <?php echo $swmenupro['main_border']; ?>;
	background-color: <?php echo $swmenupro['main_back']; ?>;
    margin: 0;
    padding: 0;
	
}
ul.tree-menu<?php echo $swmenupro['id']; ?> ul {
	
	list-style-type: none;
    margin: 0 0 0 <?php echo $swmenupro['level1_sub_left'].'px'; ?>;
    padding: 0px 0 0 0;
}
ul.tree-menu<?php echo $swmenupro['id']; ?> li {
	
	
    list-style-type: none;
    margin: 0;
    padding: 0;
}
ul.tree-menu<?php echo $swmenupro['id']; ?> li.section {

    background-image: url("<?php echo $swmenupro['main_back_image']; ?>");
    background-repeat: no-repeat;
    background-position: top <?php echo $swmenupro['sub_align']; ?>;
    padding: <?php echo $swmenupro['main_padding']; ?>;
	
}
ul.tree-menu<?php echo $swmenupro['id']; ?> li.section-open {
    background-image: url("<?php echo $swmenupro['main_back_image_over']; ?>");
    background-repeat: no-repeat;
    background-position: top <?php echo $swmenupro['sub_align']; ?>;
   padding: <?php echo $swmenupro['main_padding']; ?>;
}
ul.tree-menu<?php echo $swmenupro['id']; ?> li.box {
	
    background-image: url("<?php echo $swmenupro['sub_back_image']; ?>");
    background-repeat: no-repeat;
    background-position: top <?php echo $swmenupro['sub_align']; ?>;
    padding: <?php echo $swmenupro['sub_padding']; ?>;
	
	
}

ul.tree-menu<?php echo $swmenupro['id']; ?> li.lastbox  {
	
    background-image: URL("<?php echo $swmenupro['sub_back_image_over']; ?>");
    background-repeat: no-repeat;
    background-position: top <?php echo $swmenupro['sub_align']; ?>;
    padding: <?php echo $swmenupro['sub_padding']; ?>;
	
}

ul.tree-menu<?php echo $swmenupro['id']; ?> a.tree-menu<?php echo $swmenupro['id']; ?> {
	margin-left: <?php echo $swmenupro['level2_sub_left'].'px'; ?>;
    font-family: <?php echo $swmenupro['font_family']; ?>;
	font-size: <?php echo $swmenupro['main_font_size'].'px'; ?>;
	text-decoration: none;
	background-color: <?php echo $swmenupro['main_back']; ?>;
	color: <?php echo $swmenupro['main_font_color']; ?>;
	font-weight: <?php echo $swmenupro['font_weight']; ?>;
	text-align: <?php echo $swmenupro['main_align']; ?>;
    white-space: nowrap;
}
ul.tree-menu<?php echo $swmenupro['id']; ?> a.tree-menu<?php echo $swmenupro['id']; ?>:hover {
    margin-left: <?php echo $swmenupro['level2_sub_left'].'px'; ?>;
    font-family: <?php echo $swmenupro['font_family']; ?>;
	font-size: <?php echo $swmenupro['main_font_size'].'px'; ?>;
	text-decoration: none;
	
	color: <?php echo $swmenupro['main_font_color_over']; ?>;
	font-weight: <?php echo $swmenupro['font_weight_over']; ?>;
	text-align: <?php echo $swmenupro['main_align']; ?>;
	background-color: <?php echo $swmenupro['main_over']; ?>;
    white-space: nowrap;
}

-->
</style>

<?
}






function gosuMenuStyle($swmenupro){
?>

<style type="text/css">
<!--

.ddmx<?php echo $swmenupro['id']; ?> {
    font: 11px tahoma;
	border-top: <?php echo $swmenupro['main_border']; ?>;
	border-left: <?php echo $swmenupro['main_border']; ?>;
	border-right: <?php echo $swmenupro['main_border']; ?>;
	
}
.ddmx<?php echo $swmenupro['id']; ?> a.item1,
.ddmx<?php echo $swmenupro['id']; ?> a.item1:hover,
.ddmx<?php echo $swmenupro['id']; ?> a.item1-active,
.ddmx<?php echo $swmenupro['id']; ?> a.item1-active:hover {
    padding: <?php echo $swmenupro['main_padding']; ?>;
	top: <?php echo $swmenupro['main_top']; ?>px;
	left: <?php echo $swmenupro['main_left']; ?>px;
	font-size: <?php echo $swmenupro['main_font_size']; ?>px;
    font-family: <?php echo $swmenupro['font_family']; ?>;
    text-align: <?php echo $swmenupro['main_align']; ?>;
	font-weight: <?php echo $swmenupro['font_weight']; ?>;
    text-decoration: none;
    display: block;
    white-space: nowrap;
    position: relative;
	<?php  if ($swmenupro['main_width']!=0){echo "width:".$swmenupro['main_width']."px;";} ?>
	<?php  if ($swmenupro['main_height']!=0){echo "height:".$swmenupro['main_height']."px;";} ?>
}
.ddmx<?php echo $swmenupro['id']; ?> a.item1 {
	background-image: URL("<?php echo $swmenupro['main_back_image']; ?>");
	background-color: <?php echo $swmenupro['main_back']; ?>;
	border-bottom: <?php echo $swmenupro['main_border']; ?>;
    color: <?php echo $swmenupro['main_font_color']; ?>;
	white-space: nowrap;

}
.ddmx<?php echo $swmenupro['id']; ?> a.item1:hover,
.ddmx<?php echo $swmenupro['id']; ?> a.item1-active,
.ddmx<?php echo $swmenupro['id']; ?> a.item1-active:hover {
	border-bottom: <?php echo $swmenupro['main_border']; ?>;
    background-image: URL("<?php echo $swmenupro['main_back_image_over']; ?>");
    background-color: <?php echo $swmenupro['main_over']; ?>;
    color: <?php echo $swmenupro['main_font_color_over']; ?>;
	white-space: nowrap;
}
.ddmx<?php echo $swmenupro['id']; ?> a.item2,
.ddmx<?php echo $swmenupro['id']; ?> a.item2:hover,
.ddmx<?php echo $swmenupro['id']; ?> a.item2-active,
.ddmx<?php echo $swmenupro['id']; ?> a.item2-active:hover {
    padding: <?php echo $swmenupro['sub_padding']; ?>;
	font-size: <?php echo $swmenupro['sub_font_size']; ?>px;
    font-family: <?php echo $swmenupro['sub_font_family']; ?>;
    text-align: <?php echo $swmenupro['sub_align']; ?>;
	font-weight: <?php echo $swmenupro['font_weight_over']; ?>;
    text-decoration: none;
    display: block;
   white-space: nowrap;
    position: relative;
    z-index: 500;
	
	<?php  if ($swmenupro['sub_width']!=0){echo "width:".$swmenupro['sub_width']."px;";} ?>
	<?php  if ($swmenupro['sub_height']!=0){echo "height:".$swmenupro['sub_height']."px;";} ?>
	filter: alpha(opacity=<?php echo $swmenupro['specialA']; ?>);
	-moz-opacity:<?php echo ($swmenupro['specialA']/100); ?>;
	
	}
.ddmx<?php echo $swmenupro['id']; ?> a.item2 {
    background-image: URL("<?php echo $swmenupro['sub_back_image']; ?>");
	background-color: <?php echo $swmenupro['sub_back']; ?>;
    color: <?php echo $swmenupro['sub_font_color']; ?>;
	
	
	
}
.ddmx<?php echo $swmenupro['id']; ?> a.item2:hover,
.ddmx<?php echo $swmenupro['id']; ?> a.item2-active,
.ddmx<?php echo $swmenupro['id']; ?> a.item2-active:hover {
    background-image: URL("<?php echo $swmenupro['sub_back_image_over']; ?>");
    background-color: <?php echo $swmenupro['sub_over']; ?>;
    color: <?php echo $swmenupro['sub_font_color_over']; ?>;
	
}

.ddmx<?php echo $swmenupro['id']; ?> .section {
   border: <?php echo $swmenupro['sub_border']; ?>;
  
	
	
	
    position: absolute;
    visibility: hidden;
	display: block;
    z-index: -1;
}

.ddmx<?php echo $swmenupro['id']; ?> img.seq1

{
	display:	inline;
}


.ddmx<?php echo $swmenupro['id']; ?> a.item2:hover img.seq2,
.ddmx<?php echo $swmenupro['id']; ?> a.item2-active img.seq2,
.ddmx<?php echo $swmenupro['id']; ?> a.item2-active:hover img.seq2,
.ddmx<?php echo $swmenupro['id']; ?> a.item1:hover img.seq2,
.ddmx<?php echo $swmenupro['id']; ?> a.item1-active img.seq2,
.ddmx<?php echo $swmenupro['id']; ?> a.item1-active:hover img.seq2
{
	display:	inline;
}

.ddmx<?php echo $swmenupro['id']; ?> img.seq2,
.ddmx<?php echo $swmenupro['id']; ?> a.item2:hover img.seq1,
.ddmx<?php echo $swmenupro['id']; ?> a.item2-active img.seq1,
.ddmx<?php echo $swmenupro['id']; ?> a.item2-active:hover img.seq1,
.ddmx<?php echo $swmenupro['id']; ?> a.item1:hover img.seq1,
.ddmx<?php echo $swmenupro['id']; ?> a.item1-active img.seq1,
.ddmx<?php echo $swmenupro['id']; ?> a.item1-active:hover img.seq1

{
	display:	none;
}

* html .ddmx<?php echo $swmenupro['id']; ?> td { position: relative; } /* ie 5.0 fix */
-->
</style>
<?
}

?>
