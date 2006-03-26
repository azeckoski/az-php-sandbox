<?php
/*
 * file: submit.php
 * Created on Mar 10, 2006 3:20:03 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Facebook Entry";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['skin_zip'] = "required:focus";
$vItems['image1'] = "required";
$vItems['image2'] = "required";
$vItems['image3'] = "required";
$vItems['image4'] = "required";


// item PK
$PK = $_REQUEST["pk"];
if (!$PK) { // one entry per person so check for an existing entry
	$entry_sql = "select pk from skin_entries where users_pk='$USER_PK'";
	$result = mysql_query($entry_sql) or die("entry query failed ($entry_sql): ".mysql_error());
	if (mysql_num_rows($result) > 0) {
		$row = mysql_fetch_assoc($result);
		$PK = $row['pk'];
	}
}


// process the form
if ($_REQUEST["save"]) {
	// save the data

	$description = mysql_real_escape_string($_POST["description"]);
	$allow_download = mysql_real_escape_string($_POST["allow_download"]);

	// DO SERVER SIDE VALIDATION
	$errors = 0;
	$validationOutput = ServerValidate($vItems, "return");
	if ($validationOutput) {
		$errors++;
		$Message = "<fieldset><legend>Validation Errors</legend>".
			"<span style='color:red;'>Please fix the following errors:</span><br/>".
			$validationOutput."</fieldset>";
	}

	if ($errors == 0) {

		// get the current file PKs (if they exist)
		$file_pks;
		if ($PK) {
			$item_sql = "select skin_zip, image1, image2, image3, image4 " .
				"from skin_entries where pk='$PK'";
			$result = mysql_query($item_sql) or die("item pk query failed ($item_sql): ".mysql_error());
			$file_pks = mysql_fetch_assoc($result); // first result is all we care about
		}

		// process the file uploads
		$file_keys = array();
		foreach ($_FILES as $key=>$file) {
			// key is the item form name, file is the file array
			//print "processing $key file: ".$file['name'].":".$file['size'].":".$file['type']." <br>";

			// see if the upload is valid
			if($file['size'] > 0 && $file['name']) {
				$fileName = $file['name'];
				$fileSize = $file['size'];
				$fileType = $file['type'];

				$fp      = fopen($file['tmp_name'], 'r');
				$content = fread($fp, filesize($file['tmp_name']));
				$content = mysql_real_escape_string($content);
				fclose($fp);

				if(!get_magic_quotes_gpc()) { $fileName = addslashes($fileName); }

				// check if this seems to be an image
				$isImage = false;
				if ($IMAGE_MIMES[$file['type']] != "") {
					$isImage = true;
				}

				if ($isImage) {
					// get the image dimensions
					list($width, $height) = getimagesize($file['tmp_name']);
					$fileDimensions = $width."x".$height;

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
				}

				// updates the old image or creates a new one
				if($item_pk && $file_pks[$key]) {
					// entry exists already
					$thumbSql = "";
					if ($thumbType) {
						$thumbSql = " thumb='$thumbContent', thumbtype='$thumbType', ";
					}

					$files_query = "UPDATE skin_files SET name='$fileName'," . $thumbSql .
							"size='$fileSize', type='$fileType', content='$content', " .
							"dimensions='$fileDimensions' where pk='$file_pks[$key]'";
					mysql_query($files_query) or die("Entry upload query failure ($files_query) :".mysql_error() );
					$file_keys[$key] = $file_pks[$key];
				} else {
					// new entry
					$thumbSql = " NULL, NULL ";
					if ($thumbType) {
						$thumbSql = " '$thumbContent', '$thumbType' ";
					}

					$files_query = "INSERT INTO skin_files (date_created, name, size, type, " .
						"dimensions, content, thumb, thumbtype) ".
						"VALUES (NOW(), '$fileName', '$fileSize', '$fileType', " .
						"'$fileDimensions', '$content', $thumbSql)";
					mysql_query($files_query) or die("Entry upload query failure: ".mysql_error());
					$file_keys[$key] = mysql_insert_id();
				}

				$Message .= "<strong>$fileName uploaded:</strong> size: $fileSize, type: $fileType <br>";
			} else {
				// blank file upload (this is ok)
				continue;
			}
		}
	}

	if ($errors == 0) {
		// now create or modify the skin entry
		if ($PK) {
			$files_sql = "";
			if ($file_keys['skin_zip']) { $files_sql .= " skin_zip='$file_keys[skin_zip]', "; }
			if ($file_keys['image1']) { $files_sql .= " image1='$file_keys[image1]', "; }
			if ($file_keys['image2']) { $files_sql .= " image2='$file_keys[image2]', "; }
			if ($file_keys['image3']) { $files_sql .= " image3='$file_keys[image3]', "; }
			if ($file_keys['image4']) { $files_sql .= " image4='$file_keys[image4]', "; }

			// update old entry
			$entry_sql = "UPDATE skin_entries set " . $files_sql .
				"description='$description', allow_download='$allow_download' " .
				"where pk='$PK'";
			//print "$entry_sql<br>";
			mysql_query($entry_sql) or die("Entry update failed: ".mysql_error().": ".$entry_sql);
			$Message .= "<strong>Updated existing entry</strong><br>";
		} else {
			// new entry
			$entry_sql = "insert into skin_entries " .
				"(users_pk, description, skin_zip, " .
				"image1, image2, image3, image4," .
				"round, allow_download, date_created) values " .
				"('$USER_PK','$description','$file_keys[skin_zip]'," .
				"'$file_keys[image1]','$file_keys[image2]','$file_keys[image3]','$file_keys[image4]'," .
				"'$ROUND','$allow_download', NOW())";
			//print "$entry_sql<br>";
			mysql_query($entry_sql) or die("Entry query failed: ".mysql_error().": ".$entry_sql);
			$PK = mysql_insert_id();
			$Message .= "<strong>Saved new entry</strong><br>";
		}
	} // end no errors
} // end save


// TODO - Fetch the entry based on the PK if it is set

// now fetch the current facebook entry
$inst_sql = "select * from skin_entries where pk='$PK'";
$result = mysql_query($inst_sql) or die("Entry fetch query failed: ".mysql_error().": ".$entry_sql);
$thisItem = mysql_fetch_assoc($result); // first result is all we care about

// add in the help link
$EXTRA_LINKS = " - <a style='font-size:.8em;' href='$HELP_LINK' target='_HELP'>Help</a><br/>";

// add in the display to let people know how long they have to submit
$EXTRA_LINKS .= "<div class='date_message'>";

$allowed = 0; // assume user is NOT allowed unless otherwise shown
if (strtotime($ROUND_START_DATE) > time()) {
	// No one can access until start date
	$allowed = 0;
	$Message = "Submission opens on " . date($DATE_FORMAT,strtotime($ROUND_START_DATE));
	$EXTRA_LINKS .= "Submission opens " . date($DATE_FORMAT,strtotime($ROUND_START_DATE));
} else if (strtotime($ROUND_CLOSE_DATE) < time()) {
	// No submits after close date
	$allowed = 0;
	$Message = "Submission closed on " . date($DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));
	$EXTRA_LINKS .= "Submission closed " . date($DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));
} else {
	// submit is allowed
	$allowed = 1;
	$EXTRA_LINKS .= "Submit from " . date($DATE_FORMAT,strtotime($ROUND_START_DATE)) .
		" to " . date($DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));
	writeLog($TOOL_SHORT,$USER["username"],"access to submit");
}

$EXTRA_LINKS .= "</div>";

// admin access check
if ($USER["admin_skin"]) { $allowed = 1; }

?>
<?php include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<script>
<!--
// -->
</script>
<!-- // INCLUDE THE HEADER -->
<?php include 'include/header.php';  ?>

<?= $Message ?>

<?php
	// display footer if user is not allowed
	if (!$allowed) {
		include 'include/footer.php';
		exit;
	}
?>

<div class="required" id="requiredMessage"></div>
<form name="adminform" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;" enctype="multipart/form-data">
<input type="hidden" name="save" value="1" />
<input type="hidden" name="pk" value="<?= $PK ?>" />
<input type="hidden" name="MAX_FILE_SIZE" value="2000000" /> <!-- 2 MB -->

<table border="0" class="padded">
	<tr>
		<td colspan="3">
			<strong>Description:</strong>
			<em style="font-size:10pt;">(This field should contain details about why this skin should be chosen)</em>
		</td>
	</tr>
	<tr>
		<td colspan="3"><textarea name="description" tabindex="2" rows="3" cols="80"><?= $thisItem['description'] ?></textarea></td>
	</tr>

	<tr>
		<td nowrap="y" valign="top" width="20%">
			<strong>Skin zip file:</strong>
			<img id="skin_zipImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
		</td>
		<td width="1%" style="font-size:9pt;">
<?php if ($thisItem['skin_zip']) { ?>
		<a href="include/getFile.php?pk=<?= $thisItem['skin_zip'] ?>">
		<?php $file_pk = $thisItem['skin_zip']; require 'include/file_info.php'; ?>
		</a>
<?php } ?>
		</td>
		<td class="field" width="79%">
			<input type="file" name="skin_zip" tabindex="3" size="15">
			<br/><em>zip file which contains the skin css files and any needed images</em>
<?php if (!$thisItem['skin_zip']) { ?>
			<input type="hidden" id="skin_zipValidate" value="<?= $vItems['skin_zip'] ?>" />
			<br/><span id="skin_zipMsg"></span>
<?php } ?>
		</td>
	</tr>

	<tr>
		<td nowrap="y" valign="top">
			<strong>Portal image:</strong>
			<img id="image1Img" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
		</td>
		<td nowrap="y">
<?php if ($thisItem['image1']) { ?>
			<a href="include/drawImage.php?pk=<?= $thisItem['image1'] ?>" target="_new">
			<img src="include/drawThumb.php?pk=<?= $thisItem['image1'] ?>" alt="portal image" />
			</a>
<?php } ?>
		</td>
		<td class="field">
			<input type="file" name="image1" tabindex="4" size="15">
			<br/><em>image of the Sakai gateway page (/portal)</em>
<?php if (!$thisItem['image1']) { ?>
			<input type="hidden" id="image1Validate" value="<?= $vItems['image1'] ?>" />
			<br/><span id="image1Msg"></span>
<?php } ?>
		</td>
	</tr>

	<tr>
		<td nowrap="y" valign="top">
			<strong>Workspace image:</strong>
			<img id="image2Img" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
		</td>
		<td nowrap="y">
<?php if ($thisItem['image2']) { ?>
			<a href="include/drawImage.php?pk=<?= $thisItem['image2'] ?>" target="_new">
			<img src="include/drawThumb.php?pk=<?= $thisItem['image2'] ?>" alt="portal image" />
			</a>
<?php } ?>
		</td>
		<td class="field">
			<input type="file" name="image2" tabindex="5" size="15">
			<br/><em>image of the My Workspace -> Home</em>
<?php if (!$thisItem['image2']) { ?>
			<input type="hidden" id="image2Validate" value="<?= $vItems['image2'] ?>" />
			<br/><span id="image2Msg"></span>
<?php } ?>
		</td>
	</tr>

	<tr>
		<td nowrap="y" valign="top">
			<strong>Resources image:</strong>
			<img id="image3Img" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
		</td>
		<td nowrap="y">
<?php if ($thisItem['image3']) { ?>
			<a href="include/drawImage.php?pk=<?= $thisItem['image3'] ?>" target="_new">
			<img src="include/drawThumb.php?pk=<?= $thisItem['image3'] ?>" alt="portal image" />
			</a>
<?php } ?>
		</td>
		<td class="field">
			<input type="file" name="image3" tabindex="6" size="15">
			<br/><em>image of Resources (Legacy Tool)</em>
<?php if (!$thisItem['image3']) { ?>
			<input type="hidden" id="image3Validate" value="<?= $vItems['image3'] ?>" />
			<br/><span id="image3Msg"></span>
<?php } ?>
		</td>
	</tr>

	<tr>
		<td nowrap="y" valign="top">
			<strong>Gradebook image:</strong>
			<img id="image4Img" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
		</td>
		<td nowrap="y">
<?php if ($thisItem['image4']) { ?>
			<a href="include/drawImage.php?pk=<?= $thisItem['image4'] ?>" target="_new">
			<img src="include/drawThumb.php?pk=<?= $thisItem['image4'] ?>" alt="portal image" />
			</a>
<?php } ?>
		</td>
		<td class="field">
			<input type="file" name="image4" tabindex="7" size="15">
			<br/><em>image of Gradebook (New Tool)</em>
<?php if (!$thisItem['image4']) { ?>
			<input type="hidden" id="image4Validate" value="<?= $vItems['image4'] ?>" />
			<br/><span id="image4Msg"></span>
<?php } ?>
		</td>
	</tr>

	<tr>
		<td nowrap="y">
			<strong>Allow download:</strong>
		</td>
		<td colspan="2">&nbsp;
			<input name="allow_download" type="radio" value="Y" 
				<?php if (!$thisItem["allow_download"] || 
					$thisItem["allow_download"] == "Y") { echo " checked='y' "; } ?> /> Yes
			<input name="allow_download" type="radio" value="Y" 
				<?php if ($thisItem["allow_download"] == "N") { echo " checked='y' "; } ?> /> No
			<em style="font-size:10pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				(Allow others to download your skin zip file)</em>
		</td>
	</tr>

	<tr>
		<td class="field" colspan="3">
			<input type="submit" name="account" value="Save information" tabindex="8"><br>
			<em>You may modify your submission after saving until <?= date($DATE_FORMAT,strtotime($ROUND_CLOSE_DATE)) ?></em>
		</td>
	</tr>
</table>
</form>


<?php include 'include/footer.php'; // Include the FOOTER ?>