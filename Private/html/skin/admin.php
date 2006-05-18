<?php
/* skin_admin.php
 * Created on May 18, 2006 by @author az - Aaron Zeckoski
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech 
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Admin Control";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

$allowed = 0; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("admin_skin")) {
	$allowed = 0;
	$Message = "Only admins with <b>admin_skin</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_URL/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}

// Do the export as requested by the user
if ($_REQUEST["export_insts"] && $allowed) {
	$date = date("Ymd-Hi",time());
	$filename = "institutions-" . $date . ".csv";
	header("Content-type: text/x-csv");
	header("Content-disposition: inline; filename=$filename\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0"); 
	
	// generate the export file
	$export_sql = "select I1.name, I1.abbr, I1.type, U1.username, U1.firstname, U1.lastname, U1.email,
count(RV.pk) as official_votes from institution I1 
left join users U1 on U1.pk=I1.repvote_pk 
left join requirements_vote RV on RV.users_pk=U1.pk and RV.round='$ROUND' and RV.official='1'
group by I1.name, RV.users_pk";
	$result = mysql_query($export_sql) or die('Export query failed: ' . mysql_error());
	$line = 0;
	while($itemrow=mysql_fetch_assoc($result)) {
		$line++;
		// print out EXPORT format instead of display
		if ($line == 1) {
			print "\"Institutions and Reps Export\"\n";
			print join(',', array_keys($itemrow)) . "\n"; // add header line
		}
		
		foreach ($itemrow as $name=>$value) {
			$value = str_replace("\"", "\"\"", $value); // fix for double quotes
			$itemrow[$name] = '"' . $value . '"'; // put quotes around each item
		}
		print join(',', $itemrow) . "\n";
	}
	
	// add extra stuff at the bottom
	print "\n\"Exported on:\",\"" . date($DATE_FORMAT,time()) . "\"\n";	
	print "\"Voting round:\",\"" . $ROUND . "\"\n";	
	exit;
}

$EXTRA_LINKS = "<br><span style='font-size:9pt;'><strong>Skin Admin</strong></span>";
?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript">
<!--
// -->
</script>
<?php include 'include/header.php'; ?>

<?= $Message ?>

<?php
// This part will punt the user out if they are not allowed
if (!$allowed) {
	include 'include/footer.php';
	exit;
}
?>

<?php
//processing the posted values for saving
if ($_REQUEST['save']) {
	$Keys = array();
	$Keys = array_keys($_POST);
	foreach( $Keys as $key)
	{
		if ($_POST[$key] == "") { continue; } // skip blank values
	
		$check = strpos($key,'url');
		if ( $check !== false && $check == 0 ) {
			$itemPk = substr($key, 3);
			$newUrl = mysql_real_escape_string($_POST[$key]);

			$update_sql="update skin_entries set url='$newUrl' where pk='$itemPk'";
			$result = mysql_query($update_sql) or die("Query failed ($update_sql): " . mysql_error());
		}
	}
}

// process approval
if ($_REQUEST['approve']) {
	if ($_REQUEST['pk']) {
		$sql = sprintf("update skin_entries set approved='%s' where pk='%s'",
			mysql_real_escape_string($_REQUEST['approve']),
			mysql_real_escape_string($_REQUEST['pk']) );
		$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
	}
}

// process tested
if ($_REQUEST['tested']) {
	if ($_REQUEST['pk']) {
		$sql = sprintf("update skin_entries set tested='%s' where pk='%s'",
			mysql_real_escape_string($_REQUEST['tested']),
			mysql_real_escape_string($_REQUEST['pk']) );
		$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
	}
}

// fetch the current skin entries data
$sql = "select skin_entries.*, users.username, users.firstname, users.lastname, " .
	"users.email from skin_entries join users on users.pk = skin_entries.users_pk " .
	"where round = '$ROUND' order by date_created";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$skin_entries = array();
while($row=mysql_fetch_assoc($result)) { $skin_entries[$row['pk']] = $row; }

?>

<strong><?= $TOOL_NAME ?> Admin Operations</strong><br/>
<div style="margin:6px;"></div>

<form name="adminform" method="post" action="<?= $_SERVER['PHP_SELF'] ?>" style="margin:0px;">

<table border="0" cellspacing="0" style='width:100%;height:100%;'>

<tr class='tableheader'>
<td>#&nbsp;&nbsp;</td>
<td width="10%">&nbsp;Title</td>
<td width="60%">&nbsp;Description / URL</td>
<td width="10%" align="center">&nbsp;Approved</td>
<td width="10%" align="center">&nbsp;Tested</td>
<td width="10%">&nbsp;Date</td>
</tr>

<?php
$line = 0;
foreach ($skin_entries as $skin_pk=>$skin_entry) {
	$line++;

	$linestyle = "oddrow";
	if (($line % 2) == 0) { $linestyle = "evenrow"; } else { $linestyle = "oddrow"; }
?>

	<tr class="<?= $linestyle ?>" valign="top">
		<td valign="top">
			<?= $line ?>
		</td>
		<td valign="top" nowrap="y">
		<label title="<?= $skin_entry['firstname']." ".$skin_entry['lastname']." (".$skin_entry['email'].")" ?>">
			<a href="submit.php?pk=<?= $skin_pk ?>"><?= $skin_entry['title'] ?></a>
		</label>
		<br/>
<?php if ($skin_entry['skin_zip']) { ?>
		<a style="font-size:.8em;" href="include/getFile.php?pk=<?= $skin_entry['skin_zip'] ?>">
		(DL&nbsp;entry)
		</a>
<?php } ?>
		</td>
		<td valign="top">
			<?= $skin_entry['description'] ?><br/>
<?php 
if ($skin_entry['url']) {
	echo "<a href='".$skin_entry['url']."' target='new'>url</a>: ";
} else {
	echo "url: ";
}
?>
			<input type="text" name="url<?= $skin_pk ?>" size="50" value="<?= $skin_entry['url'] ?>" />
		</td>
		<td align="center">
<?php
	if ($skin_entry['approved'] == 'Y') {
		echo "<a href='".$_SERVER['PHP_SELF']."?approve=N&amp;pk=$skin_pk'>Yes</a>";
	} else {
		echo "<a style='color:red;text-decoration:underline;font-weight:bold;'" .
			"href='".$_SERVER['PHP_SELF']."?approve=Y&amp;pk=$skin_pk'>NO</a>";
	}
?>
		</td>
		<td align="center">
<?php
	if ($skin_entry['tested'] == 'Y') {
		echo "<a href='".$_SERVER['PHP_SELF']."?tested=N&amp;pk=$skin_pk'>Yes</a>";
	} else {
		echo "<a style='color:red;text-decoration:underline;font-weight:bold;'" .
			"href='".$_SERVER['PHP_SELF']."?tested=Y&amp;pk=$skin_pk'>NO</a>";
	}
?>
		</td>
		<td valign="top" style="font-size:.9em;" nowrap="y">
			<?= date('M j, Y',strtotime($skin_entry['date_created'])) ?>
			<br/>
			<?= date('(D) g:i a',strtotime($skin_entry['date_created'])) ?>
		</td>
	</tr>

<?php
} // end foreach
?>

</table>

<input type="submit" name="save" value="Save Information" />

</form>

<?php include 'include/footer.php'; ?>