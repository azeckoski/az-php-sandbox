<?php
/*
 * file: admin_inst.php
 * Created on Mar 6, 2006 8:59:17 AM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
 /***** LDAP
  * objectClass (
    1.3.6.1.4.1.6760.6.2.9
    NAME 'sakaiInst'
    DESC 'An institution in sakai'
    SUP top
    AUXILIARY
    MAY ( iid $ o $ repUid $ voteUid ))
  */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Institution Edit";
$Message = "Edit the information below to adjust the institution.<br/>";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require 'include/check_authentic.php';

// login if not autheticated
require 'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
$Message = "";
if (!$USER["admin_insts"]) {
	$allowed = 0;
	$Message = "Only admins with <b>admin_insts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}

$EXTRA_LINKS = "<br><span style='font-size:9pt;'><a href='admin.php'>Users admin</a> - " .
	"<a href='admin_insts.php'>Institutions admin</a></span>";

// get the form variables
$PK = $_REQUEST["pk"];
if (!$PK) {
	$Message = "You cannot come here without an institution pk set!<br/>";
	$Message .= "<a href='admin_insts.php'>Go back</a>";
	$allowed = 0;
}

// process post vars
$SAVE = $_POST["saving"]; // this indicates we are saving values

$NAME = $_POST["name"];
$ABBR = $_POST["abbr"];
$TYPE = $_POST["type"];


// this matters when the form is submitted
if ($SAVE) {
	// Check for form completeness
	$errors = 0;
	if (!strlen($NAME)) {
		$Message .= "<span class='error'>Error: Name cannot be blank</span><br/>";
		$errors++;
	}
	if (!strlen($TYPE)) {
		$Message .= "<span class='error'>Error: Type cannot be blank</span><br/>";
		$errors++;
	}

	// check if the name is unique
	$sql_name_check = mysql_query("SELECT pk FROM institution WHERE name='$NAME'");
	$row = mysql_fetch_row($sql_name_check);
	if ($row[0] > 0 && $row[0] != $PK) {
		$Message .= "<span class='error'>Error: This name ($NAME) is already in use.</span><br/>";
		$errors++;
	}
	mysql_free_result($sql_name_check);

	if ($errors == 0) {
		if ($_REQUEST["add"]) {
			// insert new institution
			$sqlinsert = "INSERT into institution (name,abbr,type) values ('$NAME','$ABBR','$TYPE')";
			$result = mysql_query($sqlinsert) or die('Inst insert query failed: ' . mysql_error());
			$PK = mysql_insert_id();
			$Message = "<b>Added new institution</b><br/>";
			$_REQUEST["add"] = "";
		} else if ($_REQUEST["remove"]) {
			// remove this institution if no users are in it
			$sqlremove = "DELETE from institution where pk='$PK' and rep_pk is null and repvote_pk is null";
			$result = mysql_query($sqlremove) or die('Inst remove query failed: ' . mysql_error());
			$Message = "<b>Remove institution $NAME</b><br/>";
		} else {
			// write the new values to the DB
			$sqledit = "UPDATE institution set name='$NAME', abbr='$ABBR', " .
					"type='$TYPE' where pk='$PK'";
			$result = mysql_query($sqledit) or die('Inst update query failed: ' . mysql_error());
			$Message = "<b>Updated institution information</b><br/>";

			// clear all values
			$NAME = "";
			$ABBR = "";
			$TYPE = "";
		}
	} else {
		$Message = "<div class='error'>Please fix the following errors:\n<blockquote>\n$Message</blockquote>\n</div>\n";
	}
}


// get the item information from the DB
$itemsql = "SELECT I1.*, U1.firstname,U1.lastname,U1.email," .
	"U2.firstname as vfirstname,U2.lastname as vlastname,U2.email as vemail " .
	"from institution I1 left join users U1 on U1.pk=I1.rep_pk " .
	"left join users U2 on U2.pk=I1.repvote_pk WHERE I1.pk = '$PK'";
$result = mysql_query($itemsql) or die('Query failed: ' . mysql_error());
$thisItem = mysql_fetch_assoc($result);

if (!empty($result)) {
	if (!strlen($NAME)) { $NAME = $thisItem["name"]; }
	if (!strlen($ABBR)) { $ABBR = $thisItem["abbr"]; }
	if (!strlen($TYPE)) { $TYPE = $thisItem["type"]; }
}
mysql_free_result($result);
?>

<?php include 'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<script>
<!--
function orderBy(newOrder) {
	if (document.adminform.sortorder.value == newOrder) {
		document.adminform.sortorder.value = newOrder + " desc";
	} else {
		document.adminform.sortorder.value = newOrder;
	}
	document.adminform.submit();
	return false;
}
// -->
</script>
<?php include 'include/header.php'; // INCLUDE THE HEADER ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include 'include/footer.php';
		exit;
	}
?>

<i style="font-size:9pt;">All fields are required</i><br/>
<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" name="adminform" style="margin:0px;">
<input type="hidden" name="pk" value="<?= $PK ?>">
<input type="hidden" name="add" value="<?= $_REQUEST["add"] ?>">
<input type="hidden" name="saving" value="1">

<table border="0" class="padded">
	<tr>
		<td class="account"><b>Name:</b></td>
		<td><input type="text" name="name" tabindex="1" value="<?= $thisItem["name"] ?>" size="40" maxlength="250"></td>
		<script>document.adminform.name.focus();</script>
	</tr>
	<tr>
		<td class="account"><b>Abbreviation:</b></td>
		<td><input type="text" name="abbr" tabindex="2" value="<?= $thisItem["abbr"] ?>" size="10" maxlength="50"></td>
	</tr>
	<tr>
		<td class="account"><b>Type:</b></td>
		<td>
			<input type="radio" name="type" tabindex="3" value="educational" <?php
				if (!$thisItem["type"] || $thisItem["type"] == "educational") { echo " checked='Y' "; }
			?>> educational
			&nbsp;
			<input type="radio" name="type" tabindex="3" value="commercial" <?php
				if ($thisItem["type"] == "commercial") { echo " checked='Y' "; }
			?>> commercial
		</td>
	</tr>
<?php if (!$_REQUEST["add"]) { ?>
	<tr>
		<td class="account"><b>Inst Rep:</b></td>
		<td>
<?php
	if ($thisItem["rep_pk"]) {
		echo $thisItem["firstname"]." ".$thisItem["lastname"]." (<a href='mailto:".$thisItem["email"]."'>".$thisItem["email"]."</a>)";
	} else {
		echo "<i style='color:red;'>none</i>";
	}
?>
		</td>
	</tr>
	<tr>
		<td class="account"><b>Voting Rep:</b></td>
		<td>
<?php
	if ($thisItem["repvote_pk"]) {
		echo $thisItem["vfirstname"]." ".$thisItem["vlastname"]." (<a href='mailto:".$thisItem["vemail"]."'>".$thisItem["vemail"]."</a>)";
	} else {
		echo "<i style='color:red;'>none</i>";
	}
?>
		</td>
	</tr>
<?php } // end add check ?>

	<tr>
		<td colspan="2">
			<input type="submit" name="account" value="Save information" tabindex="4">
		</td>
	</tr>
</table>

</form>

<?php include 'include/footer.php'; // Include the FOOTER ?>