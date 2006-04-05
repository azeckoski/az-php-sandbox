<?php
/**
* @version $Id: admin.media.php,v 1.1 2005/07/22 01:52:35 eddieajau Exp $
* @package Mambo
* @subpackage Massmail
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
		| $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_media' ))) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );
//require_once( $mainframe->getPath( 'class' ) );

$cid = mosGetParam( $_POST, 'cid', array(0) );
if (!is_array( $cid )) {
	$cid = array(0);
}

if (!(isset($listdir))){
	$listdir='';
	}

if (is_int(strpos ($listdir, "..")) && $listdir<>'') {
	mosRedirect( "index2.php?option=com_media&listdir=".$_POST['dirPath'], "NO HACKING PLEASE" );
	}

switch ($task) {

	case "upload":
		upload();
		showMedia($dirPath);
		break;

	case "newdir":
		if (ini_get('safe_mode')=="On") {
			mosRedirect( "index2.php?option=com_media&listdir=".$_POST['dirPath'], "Directory creation not allowed while running in SAFE MODE as this can cause problems." );
			}
		else {
			create_folder($foldername,$dirPath);
		}
		showMedia($dirPath);
		break;

	case "delete":
		delete_file($delFile,$listdir);
		showMedia($listdir);
		break;

	case "deletefolder":
		delete_folder($delFolder,$listdir);
		showMedia($listdir);
		break;

	case "list":
		listImages($listdir);
		break;

	default:
		showMedia($listdir);
		break;
}




function delete_file($delfile, $listdir)
{
	global $mosConfig_absolute_path;
	$del_image = $mosConfig_absolute_path."/images/stories".$listdir."/".$delfile;
	unlink($del_image);
}

function create_folder($folder_name,$dirPath)
{
	global $mosConfig_absolute_path;

	if(strlen($folder_name) >0)
	{
		if (eregi("[^0-9a-zA-Z_]", $folder_name)) {
			mosRedirect( "index2.php?option=com_media&listdir=".$_POST['dirPath'], "Directory name must only contain alphanumeric characters and no spaces please." );
		}
		$folder = $mosConfig_absolute_path."/images/stories".$dirPath."/".$folder_name;
		if(!is_dir($folder) && !is_file($folder))
		{
			mosMakePath($folder);
			$fp = fopen($folder."/index.html", "w" );
			fwrite( $fp, "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>" );
			fclose( $fp );
			mosChmod($folder."/index.html");
			$refresh_dirs = true;
		}
	}
}

function delete_folder($delFolder,$listdir)
{
	global $mosConfig_absolute_path;

	$del_html = $mosConfig_absolute_path.'/images/stories'.$listdir.$delFolder.'/index.html';
	$del_folder = $mosConfig_absolute_path.'/images/stories'.$listdir.$delFolder;

	$entry_count = 0;
	$dir = opendir( $del_folder );
	while ( $entry = readdir( $dir ))
	{
		if( $entry != "." & $entry != ".." & strtolower($entry) != "index.html" )
		$entry_count++;
	}
	closedir( $dir );

	if( $entry_count < 1 )
	{
		@unlink($del_html);
		rmdir($del_folder);
	} else {
		echo '<font color="red">Unable to delete: not empty!</font>';
	}
}

function upload(){

	global $mosConfig_absolute_path;

	if(isset($_FILES['upload']) && is_array($_FILES['upload']) && isset($_POST['dirPath']))
	{
		$dirPathPost = $_POST['dirPath'];

		if(strlen($dirPathPost) > 0)
		{
			if(substr($dirPathPost,0,1)=='/')
				$IMG_ROOT .= $dirPathPost;
			else
				$IMG_ROOT = $dirPathPost;
		}

		if(strrpos($IMG_ROOT, '/')!= strlen($IMG_ROOT)-1)
			$IMG_ROOT .= '/';

	do_upload( $_FILES['upload'], $mosConfig_absolute_path.'/images/stories/'.$dirPathPost.'/');
	}
}

function do_upload($file, $dest_dir)
{
	global $clearUploads;

		if (file_exists($dest_dir.$file['name'])) {
			mosRedirect( "index2.php?option=com_media&listdir=".$_POST['dirPath'], "Upload FAILED.File allready exists" );
		}

		if ((strcasecmp(substr($file['name'],-4),".gif")) && (strcasecmp(substr($file['name'],-4),".jpg")) && (strcasecmp(substr($file['name'],-4),".png")) && (strcasecmp(substr($file['name'],-4),".bmp")) &&(strcasecmp(substr($file['name'],-4),".doc")) && (strcasecmp(substr($file['name'],-4),".xls")) && (strcasecmp(substr($file['name'],-4),".ppt")) && (strcasecmp(substr($file['name'],-4),".swf")) && (strcasecmp(substr($file['name'],-4),".pdf"))) {
			mosRedirect( "index2.php?option=com_media&listdir=".$_POST['dirPath'], "Only files of type gif, png, jpg, bmp, pdf, swf, doc, xls or ppt can be uploaded" );
		}

		if (!move_uploaded_file($file['tmp_name'], $dest_dir.strtolower($file['name']))){
			mosRedirect( "index2.php?option=com_media&listdir=".$_POST['dirPath'], "Upload FAILED" );
			}
		else {
			mosChmod($dest_dir.strtolower($file['name']));
			mosRedirect( "index2.php?option=com_media&listdir=".$_POST['dirPath'], "Upload complete" );
		}

	$clearUploads = true;
}

function recursive_listdir($base) {
    static $filelist = array();
    static $dirlist = array();

    if(is_dir($base)) {
       $dh = opendir($base);
       while (false !== ($dir = readdir($dh))) {
           if (is_dir($base ."/". $dir) && $dir !== '.' && $dir !== '..' && strtolower($dir) !== 'cvs') {
                $subbase = $base ."/". $dir;
                $dirlist[] = $subbase;
                $subdirlist = recursive_listdir($subbase);
            }
        }
        closedir($dh);
    }
    return $dirlist;
 }


/**
* Show media manager
* @param string The image directory to display
*/
function showMedia($listdir) {

	global $mosConfig_absolute_path, $mosConfig_live_site;

	// get list of directories
	$imgFiles = recursive_listdir( $mosConfig_absolute_path."/images/stories" );
	$images = array();
	$folders = array();
	$folders[] = mosHTML::makeOption( "/" );
	foreach ($imgFiles as $file) {
			$folders[] = mosHTML::makeOption( substr($file,strlen($mosConfig_absolute_path."/images/stories")) );
	}
	if (is_array($folders)) {
		sort( $folders );
	}
	// create folder selectlist
	$dirPath = mosHTML::selectList( $folders, 'dirPath', "class=\"inputbox\" size=\"1\" "
	."onchange=\"goUpDir()\" ",
	'value', 'text', $listdir );

	HTML_Media::showMedia($dirPath,$listdir);
}


/**
* Build imagelist
* @param string The image directory to display
*/
function listImages($listdir) {
	global $mosConfig_absolute_path, $mosConfig_live_site;

	// get list of images
	$d = @dir($mosConfig_absolute_path."/images/stories/".$listdir);

	if($d)
	{

	//var_dump($d);
	$images = array();
	$folders = array();
	$docs = array();

	while (false !== ($entry = $d->read()))
	{
		$img_file = $entry;
		if(is_file($mosConfig_absolute_path."/images/stories".$listdir.'/'.$img_file) && substr($entry,0,1) != '.' && strtolower($entry) !== 'index.html')
		{
			if (eregi( "bmp|gif|jpg|png", $img_file )) {
				$image_info = @getimagesize($mosConfig_absolute_path."/images/stories/".$listdir.'/'.$img_file);
				$file_details['file'] = $mosConfig_absolute_path."/images/stories".$listdir."/".$img_file;
				$file_details['img_info'] = $image_info;
				$file_details['size'] = filesize($mosConfig_absolute_path."/images/stories".$listdir."/".$img_file);
				$images[$entry] = $file_details;
			}
			else {
				// file is document
				$docs[$entry] = $img_file;
			}
		}
		else if(is_dir($mosConfig_absolute_path."/images/stories/".$listdir.'/'.$img_file) && substr($entry,0,1) != '.' && strtolower($entry) !== 'cvs')
		{
			$folders[$entry] = $img_file;
		}
	}
	$d->close();

	HTML_Media::imageStyle($listdir);

	if(count($images) > 0 || count($folders) > 0 || count($docs) > 0)
	{
		//now sort the folders and images by name.
		ksort($images);
		ksort($folders);
		ksort($docs);


		HTML_Media::draw_table_header();

		for($i=0; $i<count($folders); $i++)
		{
			$folder_name = key($folders);
			HTML_Media::show_dir('/'.$folders[$folder_name], $folder_name,$listdir);
			next($folders);
		}
		for($i=0; $i<count($docs); $i++)
		{
			$doc_name = key($docs);
			$iconfile= $mosConfig_absolute_path."/administrator/components/com_media/images/".substr($doc_name,-3)."_16.png";
			if (file_exists($iconfile))	{
				$icon = "components/com_media/images/".(substr($doc_name,-3))."_16.png"	; }
			else {
				$icon = "components/com_media/images/con_info.png";
			}
			HTML_Media::show_doc($docs[$doc_name], $listdir, $icon);
			next($docs);
		}
		for($i=0; $i<count($images); $i++)
		{
			$image_name = key($images);
			HTML_Media::show_image($images[$image_name]['file'], $image_name, $images[$image_name]['img_info'], $images[$image_name]['size'],$listdir);
			next($images);
		}
		HTML_Media::draw_table_footer();
	}
	else
	{
		HTML_Media::draw_no_results();
	}
}
else
{
	HTML_Media::draw_no_dir();
}



function rm_all_dir($dir)
{
	//$dir = dir_name($dir);
	//echo "OPEN:".$dir.'<Br>';
	if(is_dir($dir))
	{
		$d = @dir($dir);

		while (false !== ($entry = $d->read()))
		{
			//echo "#".$entry.'<br>';
			if($entry != '.' && $entry != '..')
			{
				$node = $dir.'/'.$entry;
				//echo "NODE:".$node;
				if(is_file($node)) {
					//echo " - is file<br>";
					unlink($node);
				}
				else if(is_dir($node)) {
					//echo " -	is Dir<br>";
					rm_all_dir($node);
				}
			}
		}
		$d->close();

		rmdir($dir);
	}
	//echo "RM: $dir <br>";
}





}




?>
