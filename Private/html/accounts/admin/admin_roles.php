<?php
/*
 * file: admin_roles.php
 * Created on October 2, 2006 8:03 AM by @author aatkins
 * 
 * Anthony Atkins (anthony.atkins@vt.edu)
 * Adapted from institution management page written by Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Admin Roles";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("admin_accounts")) {
	$allowed = 0;
	$message = "Only admins with <b>admin_accounts</b> or <b>admin_insts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
	$messageColor="#ff0000";
} else {
	$allowed = 1;
}

// delete an item
if ($_REQUEST["delPK"] && $allowed) {
	$delPK = mysql_real_escape_string($_REQUEST["delPK"]);
	$delName = mysql_real_escape_string($_REQUEST["delName"]);
	$delete_sql = "delete from roles where pk='$delPK'";
	$result = mysql_query($delete_sql);
	if ($result) {
		$message = "Removed role &quot;$delName&quot;...";
		$messageColor="#00cc00";
	}
	else {
		$message = "Error: Could not remove role &quot;$delName&quot;:<br/>$delete_sql<br/>".mysql_error();
		$messageColor="#ff0000";
	}
}

// add new records
if ($_REQUEST["action"] == "Add" && $allowed) {
	if ($_REQUEST["newName"]) { $newName = mysql_real_escape_string($_REQUEST["newName"]); }
	if ($_REQUEST["newOrder"]) { $newOrder = mysql_real_escape_string($_REQUEST["newOrder"]); }
	if ($_REQUEST["newColor"]) { $newColor = mysql_real_escape_string($_REQUEST["newColor"]); }

	if ($newName && $newOrder && $newColor) {
		$insert_sql = 
			"insert into roles (role_name, role_order, color) \n" . 
			"values ('$newName','$newOrder','$newColor')";
		
		$result = mysql_query($insert_sql);
		if (!$result) {
			$message = "Error adding Role &quot;$newName&quot;<br/>$insert_statement<br/>" . mysql_error();
			$messageColor="#ff0000";
		}
		else {
			$message = "Role &quot;$newName&quot; added successfully...";
			$messageColor="#00cc00";
		}
	}

}

// save changes to a record
if ($_REQUEST["action"] == "Save" && $allowed) {
	$editPK = mysql_real_escape_string($_REQUEST["editPK"]);

	if ($_REQUEST["editName"]) { $editName = mysql_real_escape_string($_REQUEST["editName"]); }
	if ($_REQUEST["editOrder"]) { $editOrder = mysql_real_escape_string($_REQUEST["editOrder"]); }
	if ($_REQUEST["editColor"]) { 
		$editColor = mysql_real_escape_string($_REQUEST["editColor"]); 
		$editColor = preg_replace("/^#/", '', $editColor);
	}

	if ($editPK && $editName && $editOrder && $editColor) {
		$save_sql = 
			"update roles " .
			"set role_name='$editName', role_order='$editOrder', color='$editColor' " .
			"where pk='$editPK'";		

		$result = mysql_query($save_sql);
		if (!$result) {
			$message .= "Error saving changes to role &quot;$editName&quot;<br/>$insert_statement<br/>" . mysql_error();
			$messageColor="#ff0000";
		}
		else {
			$message .= "Saved changes to role &quot;$editName&quot;...";
			$messageColor="#00cc00";
		}
	}
	else {
		$message .= "Can't save changes, one or more required fields is blank";
		$messageColor="#ff0000";
	}
}


// get the search
$searchtext = "";
if ($_REQUEST["searchtext"]) { $searchtext = $_REQUEST["searchtext"]; }
$sqlsearch = "";
if ($searchtext) {
	$sqlsearch = " where lower(roles.role_name) like lower('%$searchtext%')";
}

// sorting
$sortorder = "role_order,role_name";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }
$sqlsorting = " order by $sortorder ";

// main SQL to fetch all users
$from_sql = " from roles ";



// counting number of items
// **************** NOTE - APPLY THE FILTERS TO THE COUNT AS WELL
$count_sql = "select count(*) " . $from_sql . $sqlsearch;
$result = mysql_query($count_sql) or die('Count query failed: ' . mysql_error());
$row = mysql_fetch_array($result);
$total_items = $row[0];

// pagination control
$num_limit = 25;
if ($_REQUEST["num_limit"]) { $num_limit = $_REQUEST["num_limit"]; }

$total_pages = ceil($total_items / $num_limit);

$page = 1;
$PAGE = $_REQUEST["page"];
if ($PAGE) { $page = $PAGE; }

$PAGING = $_REQUEST["paging"];
if ($PAGING) {
	if ($PAGING == 'first') { $page = 1; }
	else if ($PAGING == 'prev') { $page--; }
	else if ($PAGING == 'next') { $page++; }
	else if ($PAGING == 'last') { $page = $total_pages; }
}

if ($page > $total_pages) { $page = $total_pages; }
if ($page <= 0) { $page = 1; }

$limitvalue = $page * $num_limit - ($num_limit);
$mysql_limit = " LIMIT $limitvalue, $num_limit";

$start_item = $limitvalue + 1;
$end_item = $limitvalue + $num_limit;
if ($end_item > $total_items) { $end_item = $total_items; }

// the main insr fetching query
$sql = "select pk, role_name, role_order, color " . $from_sql . $sqlsearch . $sqlsorting . $mysql_limit;
//print "SQL=$users_sql<br/>";
$result = mysql_query($sql) or die('User query failed: ' . mysql_error());
$items_displayed = mysql_num_rows($result);


// top header links
$EXTRA_LINKS = "<br/><span style='font-size:9pt;'>" .
	"<a href='index.php'>Admin</a>: " .
	"<a href='admin_users.php'>Users</a> - " .
	"<a href='admin_insts.php'>Institutions</a> - " .
	"<a href='admin_perms.php'>Permissions</a> - " .
	"<a href='admin_roles.php'>Roles</a>" .
	"</span>";


?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<!-- these are needed for the Javascript color picker, see javascript source for attribution -->
<script type="text/javascript" src="/accounts/ajax/AnchorPosition.js"></script>
<script type="text/javascript" src="/accounts/ajax/PopupWindow.js"></script>
<script type="text/javascript" src="/accounts/ajax/ColorPicker2.js"></script>

<script type="text/javascript">
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
function showHide(id) {
  div = document.getElementById(id);
  if (div.style.display == 'none') {
     div.style.display='';
  }
  else {
     div.style.display='none';
  }		
}
function deleteRole(pk,name) {
	var response = window.confirm("Are you sure you want to remove the role '"+name+"'?");
	if (response) {
		document.adminform.delPK.value = pk;
		document.adminform.delName.value = name;
		document.adminform.submit();
		return false;
	}
}
function saveRole(pk,nameField,orderField,colorField) {
	document.adminform.editPK.value=pk;
	document.adminform.editName.value=nameField.value;
	document.adminform.editOrder.value=orderField.value;
	document.adminform.editColor.value=colorField.value;
}

var cp = new ColorPicker();
// -->
</script>

<?php include $ACCOUNTS_PATH.'include/header.php'; // INCLUDE THE HEADER ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $ACCOUNTS_PATH.'include/footer.php';
		exit;
	}
?>


<?php
	if ($message) { 
		print "<div style=\"width:95%;border:1px solid $messageColor;color: $messageColor;padding: 18px; margin:0px;\">$message</div>"; 		
	}
?>

<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">

<!-- hidden variables for delete form -->
<input type="hidden" name="delPK" value=""/>
<input type="hidden" name="delName" value=""/>

<!-- hidden variables for edit form -->
<input type="hidden" name="editPK" value=""/>
<input type="hidden" name="editName" value=""/>
<input type="hidden" name="editOrder" value=""/>
<input type="hidden" name="editColor" value=""/>

<input type="hidden" name="sortorder" value="<?= $sortorder ?>" />

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>

	<td nowrap="y"><b style="font-size:1.1em;">Paging:</b></td>
	<td nowrap="y">
		<input type="hidden" name="page" value="<?= $page ?>" />
		<input class="filter" type="submit" name="paging" value="first" title="Go to the first page" />
		<input class="filter" type="submit" name="paging" value="prev" title="Go to the previous page" />
		<span class="keytext">Page <?= $page ?> of <?= $total_pages ?></span>
		<input class="filter" type="submit" name="paging" value="next" title="Go to the next page" />
		<input class="filter" type="submit" name="paging" value="last" title="Go to the last page" />
		<span class="keytext">&nbsp;-&nbsp;
		Displaying <?= $start_item ?> - <?= $end_item ?> of <?= $total_items ?> items (<?= $items_displayed ?> shown)
		&nbsp;-&nbsp;
		Max of</span>
		<select name="num_limit" title="Choose the max items to view per page">
			<option value="<?= $num_limit ?>"><?= $num_limit ?></option>
			<option value="10">10</option>
			<option value="25">25</option>
			<option value="50">50</option>
			<option value="100">100</option>
			<option value="150">150</option>
			<option value="200">200</option>
			<option value="300">300</option>
		</select>
		<span class="keytext">items per page</span>
	</td>

	<td nowrap="y" align="right">
        <input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>"
        	size="20" title="Enter search text here" />
        <script type="text/javascript">document.adminform.searchtext.focus();</script>
        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements" />
	</td>

	</tr>
	</table>
</div>

<table border="0" cellspacing="0" width="100%">
<tr class='tableheader'>
<td width="5%"><a href="javascript:orderBy('role_order');">Order</a></td>
<td width="5%"><a href="javascript:orderBy('color');">Color</a></td>
<td width="70%"><a href="javascript:orderBy('role_name');">Role Name</a></td>
<td width="20%" align="center"><a title="Add a new role" href="#" onClick="showHide('addForm');return false;">Add</a></td>
</tr>

<tr id="addForm" style="display:none;background-color:#ccccff;">
<td style="padding-bottom:1em;padding-top:.25em;"><input type="text" name="newOrder" value="<?= $total_items + 1 ?>" size="3"/></td>
<td style="padding-bottom:1em;padding-top:.25em;"><input type="hidden" name="newColor" value="#cccccc"/>
<div style="width:1em;height:1em;background-color:#cccccc;border:1px solid #000000;">&nbsp;</div></td>
<td style="padding-bottom:1em;padding-top:.25em;"><input type="text" name="newName" value="New Name" size="40"/></td>
<td style="padding-bottom:1em;padding-top:.25em;" align="center"><input type="submit" name="action" value="Add"/></td>
</tr>

<?php

$line = 0;
while($itemrow=mysql_fetch_assoc($result)) {
	$line++;

	// display normally
	$rowstyle = "";
	if (!$itemrow["rep_pk"]) {
		$rowstyle = " style = 'color:red;' ";
	}
	
	$linestyle = "oddrow";
	if ($line % 2 == 0) {
		$linestyle = "evenrow";
	} else {
		$linestyle = "oddrow";
	}
?>

<tr id="view_<?= $itemrow['pk'] ?>" class="<?= $linestyle ?>" <?= $rowstyle ?> >
	<td class="line"><?= $itemrow["role_order"] ?>&nbsp;</td>
	<td class="line"><div style="width:1em;height:1em;border:1px solid #000000;background-color:#<?= $itemrow["color"] ?>;"></div></td>
	<td class="line"><?= $itemrow["role_name"] ?></td>
	<td class="line" align="center" style="color:black;">
		<input style="width:5em;" type="button" value="Edit" onClick="showHide('view_<?= $itemrow['pk'] ?>');showHide('edit_<?= $itemrow['pk'] ?>');"/> 
		<input style="width:5em;" type="button" value="Del" onClick="deleteRole('<?= $itemrow['pk'] ?>','<?= $itemrow["role_name"] ?>');"/>
	</td>
</tr>
<tr id="edit_<?= $itemrow['pk'] ?>" class="<?= $linestyle ?>" style="display:none">
	<td class="line"><input id="order_<?= $itemrow["pk"] ?>" name="order_<?= $itemrow["pk"] ?>" type="text" size="3" value="<?= $itemrow["role_order"] ?>"></td>
	<td class="line"><input id="color_<?= $itemrow["pk"] ?>" name="color_<?= $itemrow["pk"] ?>" type="hidden" value="<?= $itemrow["color"] ?>"/>
	<div id="pick_<?= $itemrow["pk"] ?>" name="pick_<?= $itemrow["pk"] ?>" style="width:1em;height:1em;border:1px solid #000000;background-color:#<?= $itemrow["color"] ?>;" onClick="cp.select(document.adminform.color_<?= $itemrow["pk"] ?>,'pick_<?= $itemrow["pk"] ?>');return false;"></div></td>
	<td class="line"><input name="name_<?= $itemrow["pk"] ?>"type="text" size="40" value="<?= $itemrow["role_name"] ?>"/></td>
	<td class="line" align="center">
		<input style="width:5em;" name="action" type="submit" value="Save" onClick="saveRole('<?= $itemrow['pk'] ?>',document.adminform.name_<?= $itemrow['pk']?>,document.adminform.order_<?= $itemrow['pk']?>,document.adminform.color_<?= $itemrow['pk']?>)"/>
		<input style="width:5em;" type="button" value="Cancel" onClick="showHide('view_<?= $itemrow['pk'] ?>');showHide('edit_<?= $itemrow['pk'] ?>');"/>
	</td>
</tr>

<?php 
} // end while

?>

</table>
</form>
<!-- create the DIV used by the javascript color picker -->
<SCRIPT>cp.writeDiv()</SCRIPT>
<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>