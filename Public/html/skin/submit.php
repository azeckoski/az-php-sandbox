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
<form name="adminform" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;">
<input type="hidden" name="saving" value="1">
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
		<td class="field"><input type="file" name="portal_image" tabindex="3" value="<?= $SKIN_ZIP ?>">
			<br><i>This should be a zip file which contains the skin css files and any needed images</i>
		</td>
	</tr>
	<tr>
		<td class="required" nowrap="y"><b>Portal image:</b></td>
		<td class="field">
			<input type="file" name="portal_image" tabindex="4" value="<?= $PORTAL_IMAGE ?>">
			- <i>image of the Sakai gateway page (/portal)</i>
		</td>
	</tr>
	<tr>
		<td class="required" nowrap="y"><b>Workspace image:</b></td>
		<td class="field">
			<input type="file" name="workspace_image" tabindex="5" value="<?= $WORKSPACE_IMAGE ?>">
			- <i>image of the My Workspace -> Home</i>
		</td>
	</tr>
	<tr>
		<td class="required" nowrap="y"><b>Resources image:</b></td>
		<td class="field">
			<input type="file" name="legacy_image" tabindex="6" value="<?= $RESOURCES_IMAGE ?>">
			- <i>image of Resources (Legacy Tool)</i>
		</td>
	</tr>
	<tr>
		<td class="required" nowrap="y"><b>Gradebook image:</b></td>
		<td class="field">
			<input type="file" name="gradebook_image" tabindex="7" value="<?= $GRADEBOOK_IMAGE ?>">
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


<? include 'include/footer.php'; // Include the FOOTER ?>