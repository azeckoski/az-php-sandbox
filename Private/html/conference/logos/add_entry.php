<?php
/* file: add_entry.php
 * Created on Mar 19, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * modified from Aarons logo code for the conference logo entries
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Logo Entry";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';


// login if not autheticated
$AUTH_MESSAGE = "You must login to submit a logo or theme for the $CONF_NAME conference. If you do not have an account, please create one.";

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// Define the array of items to validate and the validation strings
$vItems = array();


$PK = 0;
//TODO
//allow multiple entries and display multiple entries
// process the form
if ($_REQUEST["save"]) {
	// save the data

	$file = $_FILES["image"];
	$image = $_FILES["image"]['name'];
	$themes = mysql_real_escape_string($_POST["themes"]);

	// DO SERVER SIDE VALIDATION
	$errors = 0;
	
	if ((!$image) && (!$themes))  {
		$errors=1;
		$Message = "<fieldset>".
			"<span style='color:red;'>" .
			"You must enter a theme or an image</span><br/></fieldset>";
		
	}
	if ($errors == 0) {
		// process the file uploads
	
		if($file['size'] > 0 && $file['name']) {
			$fileName = $file['name'];
			$fileSize = $file['size'];
			$fileType = $file['type'];
			list($width, $height) = getimagesize($file['tmp_name']);
			$fileDimensions = $width."x".$height;
			
			$fp      = fopen($file['tmp_name'], 'r');
			$content = fread($fp, filesize($file['tmp_name']));
			$content = mysql_real_escape_string($content);
			fclose($fp);
			
			if(!get_magic_quotes_gpc()) { $fileName = addslashes($fileName); }

			// now create a thumbnail of the image if we need to
			// no thumbnail is created or entered if the image is below maxheight and maxwidth
			$maxWidth = $MAX_THUMB_WIDTH;
			$maxHeight = $MAX_THUMB_HEIGHT;

			$thumbContent = "";
			$thumbType = "";
			if ($width > $maxWidth || $height > $maxHeight) {

				// Get new dimensions
				if ($width/$maxWidth < $height/$maxHeight) {
				   $maxWidth = round( ($maxHeight / $height) * $width);
				} else {
				   $maxHeight = round( ($maxWidth / $width) * $height);
				}

				//print "new size: ".$maxWidth."x".$maxHeight."<br/>";

				$image_input = "";
				switch($IMAGE_MIMES[$file['type']]) {
					case 'jpg': $image_input = imagecreatefromjpeg($file['tmp_name']); break;
					case 'png': $image_input = imagecreatefrompng($file['tmp_name']);  break;
					case 'gif': $image_input = imagecreatefromgif($file['tmp_name']);  break;
					case 'bmp': $image_input = imagecreatefromwbmp($file['tmp_name']); break;
					default: die("Invalid MIME type used...."); break;
				}

				$image_p = imagecreatetruecolor($maxWidth, $maxHeight); // create empty image of thumb size
				imagecopyresampled($image_p, $image_input, 0, 0, 0, 0, $maxWidth, $maxHeight, $width, $height);
				$thumbType = "image/gif";

				ob_start(); // create buffer
				imagegif($image_p); // generate gif from image
				$thumbContent = mysql_real_escape_string(ob_get_contents()); // put escaped buffer into variable
				ob_end_clean(); // purge the buffer

				imagedestroy($image_input); // destroy original image
				imagedestroy($image_p); // destroy thumb image
			}

			$thumbSql = "";
			// creates a new logo image entry
			
				$thumbSql = " NULL, NULL ";
				if ($thumbType) {
					$thumbSql = " '$thumbContent', '$thumbType' ";
				}

				$files_query = "INSERT INTO logo_images (name, size, type, dimensions, content, thumb, thumbtype) ".
					"VALUES ('$fileName', '$fileSize', '$fileType', '$fileDimensions', '$content', $thumbSql)";
				mysql_query($files_query) or die("Entry upload query failure: ".mysql_error());
				$image_pk = mysql_insert_id();
			

			$Message .= "<span style='color:red;'>" ."$fileName uploaded: size: $fileSize, type: $fileType <br></span>";
		}

		// now create logo theme entry
		
			$entry_sql = "insert into logo_entries " .
				"(users_pk, image_pk, themes, date_modified) values " .
				"('$User->pk','$image_pk','$themes', NOW())";
			mysql_query($entry_sql) or die("Entry query failed: ".mysql_error().": ".$entry_sql);
			$PK = mysql_insert_id();
			$Message .= "<span style='color:red;'>" ."Saved new entry<br></span>";
	
		
	} // end no errors
} // end save


?>
<?php include $ACCOUNTS_PATH.'/include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<script type="text/javascript">
<!--
function orderBy(newOrder) {
	if (document.adminform.sortorder.value == newOrder) {
		if (newOrder.match("^.* desc$")) {
			document.adminform.sortorder.value = newOrder.replace(" desc","");
		} else {
			document.adminform.sortorder.value = newOrder;
		}
	} else {
		document.adminform.sortorder.value = newOrder;
	}
	document.adminform.submit();
	return false;
}
// -->
</script>
<!-- // INCLUDE THE HEADER -->
<?php include '../include/header.php';  ?>
<?php include 'include/contest_LeftCol.php';  ?>


<!-- this form is just here to make it easy to sort from this page -->
<form name="adminform" action="index.php" method="post" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>" />
</form>

<fieldset><legend><strong>Conference Logo Entry</strong><br/><br/></legend>



<form name="addform" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;" enctype="multipart/form-data">
<input type="hidden" name="save" value="1" />
<input type="hidden" name="MAX_FILE_SIZE" value="1000000" /> <!-- 1 MB -->

<table border="0" width="100%">


<?php if($Message) {  ?>
<tr><td><div style="padding:5px; "><?= $Message ?></div>
</td></tr>  
<?php }  ?>
	<tr>
		<td colspan="3">
			<b>Theme or logo idea:</b> (100 characters, max.)
	</td>
	</tr>
	<tr>
		<td colspan="3" class="field">
		<input type="text" name="themes" size="60" maxlength="100"><?= $thisItem['themes'] ?></textarea>
		<br/><br/>
		</td>
	</tr>
	
		<tr>
		<td nowrap="y"><b>Image: </b> (optional)</td>
		<td colspan="2" class="field">
	<input type="file" name="image" size="25" accept="image/jpg, image/gif, image/png, image/bmp"/>

<br/><br/>
		</td>
	</tr>
	

   	<tr>
		<td class="field" colspan="3">
		<input type="hidden" id="viewableValidate" value="1" />
			
			<input type="submit" name="account" value="Save information" tabindex="8" />
		</td>
	</tr>
</table>
</form>
</fieldset>


<?php include '../include/footer.php'; // Include the FOOTER ?>