<?php
/* file: add_entry.php
 * Created on Mar 19, 2006 by @author az
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
$vItems['image'] = "required";
$vItems['url'] = "";
$vItems['interests'] = "";

$PK = 0;

// process the form
if ($_REQUEST["save"]) {
	// save the data

	$file = $_FILES["image"];
	$image = $_FILES["image"]['name'];
	$url = mysql_real_escape_string($_POST["url"]);
	$interests = mysql_real_escape_string($_POST["interests"]);

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
		// process the file uploads

		$facebook_sql = "select pk, image_pk from facebook_entries where users_pk='$USER_PK'";
		$result = mysql_query($facebook_sql) or die("facebook pk query failed: ".mysql_error().": ".$facebook_sql);
		$row = mysql_fetch_assoc($result); // first result is all we care about

		$PK = $row['pk'];
		$image_pk = $row['image_pk'];

		if($file['size'] > 0 && $file['name']) {
			$fileName = $file['name'];
			$fileSize = $file['size'];
			$fileType = $file['type'];
			
			$fp      = fopen($file['tmp_name'], 'r');
			$content = fread($fp, filesize($file['tmp_name']));
			$content = addslashes($content);
			fclose($fp);
			
			if(!get_magic_quotes_gpc()) { $fileName = addslashes($fileName); }

			// TODO - remove the old image first or make this an update
			if($PK && $image_pk) {
				// entry exists already
				$files_query = "UPDATE facebook_images SET name='$fileName'," .
						"size='$fileSize', type='$fileType', content='$content' " .
						"where pk='$image_pk'";
				mysql_query($files_query) or die("Entry upload query failure: ".mysql_error());
			} else {
				// new entry
				$files_query = "INSERT INTO facebook_images (name, size, type, content) ".
					"VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
				mysql_query($files_query) or die("Entry upload query failure: ".mysql_error());
				$image_pk = mysql_insert_id();
			}

			$Message .= "$fileName uploaded: size: $fileSize, type: $fileType <br>";
		}

		// now create or modify the facebook entry
		if ($PK) {
			$image_sql = "";
			if ($image_pk) {
				$image_sql = " image_pk='$image_pk', ";
			}
			// update old entry
			$entry_sql = "UPDATE facebook_entries set " . $image_sql .
				"url='$url', interests='$interests' " .
				"where pk='$PK'";
			mysql_query($entry_sql) or die("Entry update failed: ".mysql_error().": ".$entry_sql);
			$Message .= "Updated existing entry<br>";
		} else {
			// new entry
			$entry_sql = "insert into facebook_entries " .
				"(users_pk, image_pk, url, interests) values " .
				"('$USER_PK','$image_pk','$url','$interests')";
			mysql_query($entry_sql) or die("Entry query failed: ".mysql_error().": ".$entry_sql);
			$PK = mysql_insert_id();
			$Message .= "Saved new entry<br>";
		}
	} // end no errors
} // end save

// now fetch the current facebook entry
$inst_sql = "select * from facebook_entries where users_pk='$USER_PK'";
$result = mysql_query($inst_sql) or die("Entry fetch query failed: ".mysql_error().": ".$entry_sql);
$thisItem = mysql_fetch_assoc($result); // first result is all we care about
$PK = $thisItem['pk'];

// get image from the database
$image_sql = "select * from facebook_images where pk='$thisItem[image_pk]'";
$result = mysql_query($image_sql) or die("Image fetch query failed: ".mysql_error().": ".$image_sql);
$thisImage = mysql_fetch_assoc($result); // first result is all we care about

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

<fieldset><legend>Facebook Entry</legend>

<div class="required" id="requiredMessage"></div>

<form name="adminform" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;" enctype="multipart/form-data">
<input type="hidden" name="save" value="1" />
<input type="hidden" name="MAX_FILE_SIZE" value="1000000" /> <!-- 1 MB -->

<table border="0" width="100%">

<?php if ($thisItem['image_pk']) { ?>
	<tr>
		<td nowrap="y" width="15%"><b>Current Image:</b></td>
		<td nowrap="y" class="field" width="15%">
			<img src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="spacer"/>
			<img src="include/drawImage.php?pk=<?= $thisItem['image_pk'] ?>" alt="facebook image" />
		</td>
		<td nowrap="y" width="70%">
			<b>Name:</b> <?= $thisImage['name'] ?><br/>
			<b>Type:</b> <?= $thisImage['type'] ?><br/>
			<b>Size:</b> <?= $thisImage['size'] ?> bytes<br/>
		</td>
	</tr>
<?php } ?>

	<tr>
		<td nowrap="y"><b>Image:</b></td>
		<td colspan="2" class="field">
			<img id="imageImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="file" name="image" size="25" accept="image/jpg, image/gif, image/png, image/bmp"/>
<?php if (!$thisItem['image_pk']) { ?>
			<input type="hidden" id="imageValidate" value="<?= $vItems['image'] ?>" />
			<span id="imageMsg"></span>
<?php } ?>
		</td>
	</tr>

	<tr>
		<td><b>Homepage&nbsp;URL:</b></td>
		<td colspan="2" class="field">
			<img id="urlImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="url" value="<?= $thisItem['url'] ?>" size="60" maxlength="150"/>
			<input type="hidden" id="urlValidate" value="<?= $vItems['url'] ?>" />
			<span id="urlMsg"></span>
		</td>
	</tr>

	<tr>
		<td colspan="3">
			<b>Interests:</b>
			<img id="interestsImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="field">
			<textarea name="interests" rows="3" cols="80"><?= $thisItem['interests'] ?></textarea>
			<input type="hidden" id="interestsValidate" value="<?= $vItems['interests'] ?>" />
			<span id="interestsMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="field" colspan="3">
			<input type="submit" name="account" value="Save information" tabindex="8">
		</td>
	</tr>
</table>
</form>
</fieldset>

<script type="text/javascript">document.adminform.title.focus();</script>

<?php include 'include/footer.php'; // Include the FOOTER ?>