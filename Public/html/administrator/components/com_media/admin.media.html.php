<?php
/**
* @version $Id: admin.media.html.php,v 1.1 2005/07/22 01:52:35 eddieajau Exp $
* @package Mambo
* @subpackage Massmail
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Massmail
*/
class HTML_Media {
	function showMedia($dirPath,$listdir ) {

	?>
	<html style="width: 580; height: 440;">
	<style type="text/css">
	<!--
	.buttonHover {
		border: 1px solid;
		border-color: ButtonHighlight ButtonShadow ButtonShadow ButtonHighlight;
		cursor: hand;
	}
	.buttonOut
	{
		border: 1px solid ButtonFace;
	}

	.separator {
	  position: relative;
	  margin: 3px;
	  border-left: 1px solid ButtonShadow;
	  border-right: 1px solid ButtonHighlight;
	  width: 0px;
	  height: 16px;
	  padding: 0px;
	}
	.manager
	{
	}
	.statusLayer
	{
		background:#FFFFFF;
		border: 1px solid #CCCCCC;
	}
	.statusText {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 15px;
		font-weight: bold;
		color: #6699CC;
		text-decoration: none;
	}
	-->
	</style>
	</head>

	<script language="javascript" type="text/javascript">
	function dirup(){
		var urlquery=frames['imgManager'].location.search.substring(1);
		var curdir= urlquery.substring(urlquery.indexOf('listdir=')+8);
		var listdir=curdir.substring(0,curdir.lastIndexOf('/'));
		frames['imgManager'].location.href='index3.php?option=com_media&task=list&listdir=' + listdir;
	}


	function goUpDir()
	{
		var selection = document.forms[0].dirPath;
		var dir = selection.options[selection.selectedIndex].value;
		frames['imgManager'].location.href='index3.php?option=com_media&task=list&listdir=' + dir;
	}

	</script>
	<body>
	<form action="index2.php" name="adminForm" method="post" enctype="multipart/form-data" >
	  <table class="adminheading">
		<tr>
	    <th class="mediamanager">Media Manager</th>
	    <tr>
	      <td align="center">	  <fieldset>
	        <table width="99%" align="center" border="0" cellspacing="2" cellpadding="2">
	          <tr>
	            <td><table border="0" cellspacing="1" cellpadding="3">
    	            <tr>
	                  <td>Directory</td>
	                  <td>
					  <?php echo $dirPath;?>
					  </td>
	                  <td class="buttonOut">
					  <a href="javascript:dirup()"><img src="components/com_media/images/btnFolderUp.gif" width="15" height="15" border="0" alt="Up"></a></td>
    	            </tr>
	              </table></td>
    	      </tr>
	          <tr>
    	        <td align="center" bgcolor="white"><div name="manager" class="manager">
		        <iframe src="index3.php?option=com_media&task=list&listdir=<?php echo $listdir?>" name="imgManager" id="imgManager" width="100%" height="170" marginwidth="0" marginheight="0" align="top" scrolling="auto" frameborder="0" hspace="0" vspace="0" background="white"></iframe>
				</div>
				</td>
	          </tr>
	        </table>
	        </fieldset></td>
	    </tr>
	    <tr>
	      <td><table border="0" align="center" cellpadding="2" cellspacing="2" width="100%">
	      		<tr>
	            <td align="left">Upload</td>
	            <td>
	            	<input class="inputbox" type="file" name="upload" id="upload" size="79">&nbsp;
	            	Max size = <?php echo ini_get( 'post_max_size' );?>
	            	</td>
    	        </tr>
        	  <tr>
			  <td align="left">Code</td>
			<td><input class="inputbox" type="text" name="imagecode" size="80" /></td>
        	  </tr>
			  <tr>
			  <td align="left">Create Directory</td>
   				<td><input class="inputbox" type="text" name="foldername" size="80" />
				 </td>
	          </tr>
    	    </table>

	      </td>
	    </tr>
	    <tr>
	      <td><div style="text-align: right;">
        	</div></td>
	    </tr>
	  </table>
	  <input type="hidden" name="option" value="com_media" />
	  <input type="hidden" name="task" value="" />
	  <input type="hidden" name="cb1" id="cb1" value="0">
	</form>
	</body>
	</html>

	<?php
	}


	//Built in function of dirname is faulty
	//It assumes that the directory nane can not contain a . (period)
	function dir_name($dir){
		$lastSlash = intval(strrpos($dir, '/'));
		if($lastSlash == strlen($dir)-1){
			return substr($dir, 0, $lastSlash);
		}
		else {
			return dirname($dir);
		}
	}

	function draw_no_results(){
	?>
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td><div align="center" style="font-size:large;font-weight:bold;color:#CCCCCC;font-family: Helvetica, sans-serif;">No Images Found</div></td>
	  </tr>
	</table>
	<?php
	}

	function draw_no_dir() {
		global $BASE_DIR, $BASE_ROOT;
	?>
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td><div align="center" style="font-size:small;font-weight:bold;color:#CC0000;font-family: Helvetica, sans-serif;">Configuration Problem: &quot;<?php echo $BASE_DIR.$BASE_ROOT; ?>&quot; does not exist.</div></td>
	  </tr>
	</table>
	<?php
	}


	function draw_table_header() {
		echo '<table border="0" cellpadding="0" cellspacing="2">';
		echo '<tr>';
	}

	function draw_table_footer() {
		echo '</tr>';
		echo '</table>';
	}

	function show_image($img, $file, $info, $size, $listdir) {
		global $mosConfig_live_site;

		$img_file = basename($img);
		$img_url = $mosConfig_live_site.'/images/stories'.$listdir.'/'.$img_file;

		$filesize = HTML_Media::parse_size($size);
	?>
	<td>
	<table width="102" border="0" cellpadding="0" cellspacing="2">
	  <tr>
    	<td align="center" class="imgBorder">
		<a href="javascript:;" onclick="javascript:window.top.document.forms[0].imagecode.value = '<img src=&quot;<?php echo $img_url;?>&quot; align=&quot;left&quot; hspace=&quot;6&quot; alt=&quot;<?php echo $img_file;?>&quot; />';"><img src="<?php echo $img_url; ?>" <?php echo HTML_Media::imageResize($info[0], $info[1], 80); ?> alt="<?php echo $file; ?> - <?php echo $filesize; ?>" border="0"></a></td>
	  </tr>
	  <tr>
	  <td> <?php echo $file; ?> </td>
	  </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
    	    <tr>
        	  <td width="1%" class="buttonOut">
				<a href="javascript:;" onClick="javascript:window.top.document.forms[0].imagecode.value = '<img src=&quot;<?php echo $img_url;?>&quot; align=&quot;left&quot; hspace=&quot;6&quot; alt=&quot;Code&quot; />';"><img src="components/com_media/images/edit_pencil.gif" width="15" height="15" border="0" alt="Code"></a></td>
	          <td width="1%" class="buttonOut">
				<a href="index2.php?option=com_media&task=delete&delFile=<?php echo $file; ?>&listdir=<?php echo $listdir; ?>" target="_top" onClick="return deleteImage('<?php echo $file; ?>');"><img src="components/com_media/images/edit_trash.gif" width="15" height="15" border="0" alt="Delete"></a></td>
	          <td width="98%" class="imgCaption"><?php echo $info[0].'x'.$info[1]; ?></td>
	        </tr>
	      </table></td>
	  </tr>
	</table>
	</td>
	<?php
	}

	function show_dir($path, $dir,$listdir) {
		global $mosConfig_absolute_path;

		$num_files = HTML_Media::num_files($mosConfig_absolute_path.$path);

		// Fix for Bug [0000577]
		if ($listdir=='/') {
			$listdir='';
		}

	?>
	<td>
	<table width="102" border="0" cellpadding="0" cellspacing="2">
	  <tr>
    	<td align="center" class="imgBorder")">
		  <a href="index3.php?option=com_media&task=list&listdir=<?php echo $listdir.$path; ?>" target="imgManager" onClick="javascript:updateDir();">
			<img src="components/com_media/images/folder.gif" width="80" height="80" border="0" alt="<?php echo $dir; ?>">
		  </a>
		</td>
	  </tr>
	  <tr>
	  <td> <?php echo $dir; ?> </td>
	  </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="1" cellpadding="2">
	        <tr>
	          <td width="1%" class="buttonOut">
				<a href="index2.php?option=com_media&task=deletefolder&delFolder=<?php echo $path; ?>&listdir=<?php echo $listdir; ?>" target="_top" onClick="return deleteFolder('<?php echo $dir; ?>', <?php echo $num_files; ?>);"><img src="components/com_media/images/edit_trash.gif" width="15" height="15" border="0" alt="Delete"></a></td>
	          <td width="99%" class="imgCaption"></td>
	        </tr>
	      </table></td>
	  </tr>
	</table>
	</td>
	<?php
	}

	function show_doc($doc, $listdir, $icon) {
		global $mosConfig_absolute_path,$mosConfig_live_site;

	?>

	<td>
	<table width="102" border="0" cellpadding="0" cellspacing="2">
	  <tr>
	    <td align="center" class="imgBorder">
		  <a href="index3.php?option=com_media&task=list&listdir=<?php echo $listdir; ?>" onClick="javascript:window.top.document.forms[0].imagecode.value = '<a href=&quot;<?php echo $mosConfig_live_site.'/images/stories'.$listdir.'/'.$doc;?>&quot;>Insert your text here</a>';">
		  <img border="0" src="<?php echo $icon ?>" alt="<?php echo $doc; ?>"></a>
		</td>
	  </tr>
	  <tr>
	  <td> <?php echo $doc; ?> </td>
	  </tr>
	  <tr>
	      <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
	        <tr>
	          <td width="1%" class="buttonOut">
				<a href="javascript:;" onClick="javascript:window.top.document.forms[0].imagecode.value = '<a href=&quot;<?php echo $mosConfig_live_site.'/images/stories'.$listdir.'/'.$doc;?>&quot;>Insert your text here</a>';"><img src="components/com_media/images/edit_pencil.gif" width="15" height="15" border="0" alt="Code"></a></td>
	          <td width="1%" class="buttonOut">
				<a href="index2.php?option=com_media&task=delete&delFile=<?php echo $doc; ?>&listdir=<?php echo $listdir; ?>" target="_top" onClick="return deleteImage('<?php echo $doc; ?>');"><img src="components/com_media/images/edit_trash.gif" width="15" height="15" border="0" alt="Delete"></a></td>
	          <td width="98%" class="imgCaption"></td>
	        </tr>
	      </table></td>
	  </tr>
	</table>
	</td>
	<?php
	}

	function parse_size($size){
		if($size < 1024) {
			return $size.' bytes';
		}
		else if($size >= 1024 && $size < 1024*1024)
		{
			return sprintf('%01.2f',$size/1024.0).' Kb';
		}
		else
		{
			return sprintf('%01.2f',$size/(1024.0*1024)).' Mb';
		}
	}

	function imageResize($width, $height, $target) {

		//takes the larger size of the width and height and applies the
		//formula accordingly...this is so this script will work
		//dynamically with any size image

		if ($width > $height) {
			$percentage = ($target / $width);
		} else {
			$percentage = ($target / $height);
		}

		//gets the new value and applies the percentage, then rounds the value
		$width = round($width * $percentage);
		$height = round($height * $percentage);

		//returns the new sizes in html image tag format...this is so you
		//can plug this function inside an image tag and just get the

		return "width=\"$width\" height=\"$height\"";

	}

	function num_files($dir)
	{
		$total = 0;

		if(is_dir($dir))
		{
			$d = @dir($dir);

			while (false !== ($entry = $d->read()))
			{
				//echo $entry."<br>";
				if(substr($entry,0,1) != '.') {
					$total++;
				}
			}
			$d->close();
		}
		return $total;
	}


	function imageStyle($listdir){

	?>
	<script language="javascript" type="text/javascript">
	function updateDir(){
		var allPaths = window.top.document.forms[0].dirPath.options;
		for(i=0; i<allPaths.length; i++)
		{
			allPaths.item(i).selected = false;
			if((allPaths.item(i).value)== '<?php if (strlen($listdir)>0) { echo $listdir ;} else { echo '/';}  ?>')
			{
				allPaths.item(i).selected = true;
			}
		}
	}

	function deleteImage(file)
	{
		if(confirm("Delete file \""+file+"\"?"))
		return true;

		return false;
	}
	function deleteFolder(folder, numFiles)
	{
		if(numFiles > 0) {
			alert("There are "+numFiles+" files/folders in \""+folder+"\".\n\nPlease delete all files/folder in \""+folder+"\" first.");
			return false;
		}

		if(confirm("Delete folder \""+folder+"\"?"))
		return true;

		return false;
	}
	</script>
	</head>
	<body onload="updateDir()">
	<style type="text/css">
	<!--
	.imgBorder {
		height: 96px;
		border: 1px solid threedface;
		vertical-align: middle;
	}
	.imgBorderHover {
		height: 96px;
		border: 1px solid threedface;
		vertical-align: middle;
		background: #FFFFCC;
		cursor: hand;
	}

	.buttonHover {
		border: 1px solid;
		border-color: ButtonHighlight ButtonShadow ButtonShadow ButtonHighlight;
		cursor: hand;
		background: #FFFFCC;
	}

	.buttonOut
	{
	 border: 0px;
	}

	.imgCaption {
		font-size: 9pt;
		font-family: "MS Shell Dlg", Helvetica, sans-serif;
		text-align: center;
	}
	.dirField {
		font-size: 9pt;
		font-family: "MS Shell Dlg", Helvetica, sans-serif;
		width:110px;
	}
	-->
	</style>

	<?php
	}

}
?>