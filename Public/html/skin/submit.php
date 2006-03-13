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

$PAGE_NAME = "Introduction";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';


// get post vars
$NEW = 0;
$PK = $_REQUEST["pk"];
if (!$PK) { $NEW = 1; } // if no PK provided, we are making a new entry
$TITLE = $_POST["title"];
$DESCRIPTION = $_POST["description"];
$SKIN_ZIP = $_FILES["skin_zip"]['name'];
$IMAGE1 = $_FILES["image1"]['name'];
$IMAGE2 = $_FILES["image2"]['name'];
$IMAGE3 = $_FILES["image3"]['name'];
$IMAGE4 = $_FILES["image4"]['name'];

// process the form
if ($_REQUEST["saving"]) {
	// save the data

	// Check for form completeness
	$errors = 0;
	if (!$TITLE) {
		$Message .= "<span class='error'>Error: Title cannot be blank</span><br/>";
		$errors++;
	}
	if ($NEW) {
		// creating a new submission
		if (!$SKIN_ZIP) {
			$Message .= "<span class='error'>Error: Skin Zip file must be uploaded</span><br/>";
			$errors++;
		}
	/**
		if (!strlen($IMAGE1)) {
			$Message .= "<span class='error'>Error: Portal image must be uploaded</span><br/>";
			$errors++;
		}
		if (!strlen($IMAGE2)) {
			$Message .= "<span class='error'>Error: Workspace image must be uploaded</span><br/>";
			$errors++;
		}
		if (!strlen($IMAGE3)) {
			$Message .= "<span class='error'>Error: Resources image must be uploaded</span><br/>";
			$errors++;
		}
		if (!strlen($IMAGE4)) {
			$Message .= "<span class='error'>Error: Gradebook image must be uploaded</span><br/>";
			$errors++;
		}
	**/
	}

	if ($errors == 0) {
		// process the file uploads
		
		$file_keys = array();
		foreach ($_FILES as $key=>$file) {
			// key is the item form name, file is the file array
			if (!$file["name"]) { continue; } // the file var was not filled in by the user
			print "processing $key file: ".$file['name'].":".$file['size'].":".$file['type']." <br>";
			if($file['size'] > 0)
			{
				$fileName = $file['name'];
				$fileSize = $file['size'];
				$fileType = $file['type'];
				
				$fp      = fopen($file['tmp_name'], 'r');
				$content = fread($fp, filesize($file['tmp_name']));
				$content = addslashes($content);
				fclose($fp);
				
				if(!get_magic_quotes_gpc()) { $fileName = addslashes($fileName); }

				$files_query = "INSERT INTO files (name, size, type, content ) ".
					"VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
				mysql_query($files_query) or die('Error, upload query failed');
				$file_keys["$key"] = mysql_insert_id();

				$Message .= "$fileName uploaded: size: $fileSize, type: $fileType <br>";
			} else {
				$Message .= "File empty, could not process<br>";
			}
		}
/**
	users_pk			int(10) NOT NULL,
	title			varchar(50) NOT NULL,
    description		text,
    zip_pk			int(10) NOT NULL,
    image1_pk		int(10),
    image2_pk		int(10),
    image3_pk		int(10),
    image4_pk		int(10),
	round			int(4) NOT NULL default 1,
**/
		// now create or modify the skin entry
		$entry_sql = "insert into skin_data (users_pk,title,description,zip_pk,round) values " .
				"('$USER_PK','$TITLE','$DESCRIPTION','".$file_keys['skin_zip']."','$ROUND')";
/**
		if ($NEW) {
			$entry_sql = "insert into skin_data (users_pk,title,description,zip_pk,image1_pk," .
				"image2_pk,image3_pk,image4_pk,round) values " .
				"('$USER_PK','$TITLE','$DESCRIPTION','".$file_keys['skin_zip']."','".$file_keys['image1']."'," .
				"'".$file_keys['image2']."','".$file_keys['image3']."','".$file_keys['image4']."','$ROUND')";
		}
**/
		print "$entry_sql<br>";
		mysql_query($entry_sql) or die('Entry query failed');
		$PK = mysql_insert_id();
		$Message .= "Saved new entry<br>";
		
	} // end no errors
} // end save


// TODO - CHECK AND SEE IF THERE IS ALREADY AN ENTRY FOR THIS USER?


// TODO - Fetch the entry based on the PK if it is set



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

<?php include $ACCOUNTS_PATH.'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<script>
<!--
// -->
</script>
<?php include 'include/header.php'; // INCLUDE THE HEADER ?>

<?= $Message ?>

<?php
	// display footer if user is not allowed
	if (!$allowed) {
		include 'include/footer.php';
		exit;
	}
?>

<i style="font-size:9pt;color:red;">Required fields in red</i><br/>
<form name="adminform" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;" enctype="multipart/form-data">
<input type="hidden" name="saving" value="1">
<input type="hidden" name="MAX_FILE_SIZE" value="2000000" /> <!-- 2 MB -->
<table border="0" class="padded">
	<tr>
		<td class="required" width="5%"><b>Title:</b></td>
		<td width="95%"><input type="text" name="title" tabindex="1" value="<?= $TITLE ?>" size="30" maxlength="50"></td>
		<script>document.adminform.title.focus();</script>
	</tr>
	<tr>
		<td class="optional" colspan="2"><b>Description:</b></td>
	</tr>
	<tr>
		<td colspan="2"><textarea name="description" tabindex="2" rows="3" cols="80"><?= $DESCRIPTION ?></textarea></td>
	</tr>
	<tr>
		<td class="required" nowrap="y"><b>Skin zip file:</b></td>
		<td class="field">
			<span class="filename"><?= $SKIN_ZIP ?></span>
			<input type="file" name="skin_zip" tabindex="3" size="15">
			<br><i>This should be a zip file which contains the skin css files and any needed images</i>
		</td>
	</tr>
	<tr>
		<td class="required" nowrap="y"><b>Portal image:</b></td>
		<td class="field">
			<span class="filename"><?= $IMAGE1 ?></span>
			<input type="file" name="image1" tabindex="4" size="15">
			- <i>image of the Sakai gateway page (/portal)</i>
		</td>
	</tr>
	<tr>
		<td class="required" nowrap="y"><b>Workspace image:</b></td>
		<td class="field">
			<span class="filename"><?= $IMAGE2 ?></span>
			<input type="file" name="image2" tabindex="5" size="15">
			- <i>image of the My Workspace -> Home</i>
		</td>
	</tr>
	<tr>
		<td class="required" nowrap="y"><b>Resources image:</b></td>
		<td class="field">
			<span class="filename"><?= $IMAGE3 ?></span>
			<input type="file" name="image3" tabindex="6" size="15">
			- <i>image of Resources (Legacy Tool)</i>
		</td>
	</tr>
	<tr>
		<td class="required" nowrap="y"><b>Gradebook image:</b></td>
		<td class="field">
			<span class="filename"><?= $IMAGE4 ?></span>
			<input type="file" name="image4" tabindex="7" size="15">
			- <i>image of Gradebook (New Tool)</i>
		</td>
	</tr>

	<tr>
		<td  class="field" colspan="2">
			<input type="submit" name="account" value="Save information" tabindex="8"><br>
			<i>You may modify your submission after saving until <?= date($DATE_FORMAT,strtotime($ROUND_CLOSE_DATE)) ?></i>
		</td>
	</tr>
</table>
</form>


<?php include 'include/footer.php'; // Include the FOOTER ?>