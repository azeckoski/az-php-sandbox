<?php
/*
 * file: admin_insts.php
 * Created on Mar 5, 2006 8:26:54 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
	require_once ("tool_vars.php");

	// Form to allow user admin control
	$PAGE_NAME = "Admin Institutions";

	// connect to database
	require "mysqlconnect.php";

	// get the passkey from the cookie if it exists
	$PASSKEY = $_COOKIE["SESSION_ID"];

	// check the passkey
	$USER_PK = 0;
	if (isset($PASSKEY)) {
		$sql1 = "SELECT users_pk FROM sessions WHERE passkey = '$PASSKEY'";
		$result = mysql_query($sql1) or die('Query failed: ' . mysql_error());
		$row = mysql_fetch_assoc($result);

		if( !$result ) {
			// no valid key exists, user not authenticated
			$USER_PK = -1;
		} else {
			// authenticated user
			$USER_PK = $row["users_pk"];
		}
		mysql_free_result($result);
	}

	if( $USER_PK <= 0 ) {
		// no user_pk, user not authenticated
		// redirect to the login page
		header('location:'.$ACCOUNTS_PATH.'login.php?ref='.$_SERVER['PHP_SELF']);
		exit;
	}

	// if we get here, user should be authenticated
	// get the authenticated user information
	$authsql = "SELECT * FROM users WHERE pk = '$USER_PK'";
	$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());
	$USER = mysql_fetch_assoc($result);

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
		"Institutions admin</span>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title>
<link href="<?= $CSS_FILE ?>" rel="stylesheet" type="text/css">

<script>
<!--
function focus(){document.adminform.searchtext.focus();}

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

</head>
<body onLoad="focus()">

<? // Include the HEADER -AZ
include 'header.php'; ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include 'footer.php';
		exit;
	}
?>

<?php

// get the search
$searchtext = "";
if ($_REQUEST["searchtext"]) { $searchtext = $_REQUEST["searchtext"]; }
$sqlsearch = "";
if ($searchtext) {
	$sqlsearch = " where (CONCAT_WS(' ',I1.abbr, I1.name, I1.type,U1.username,U1.firstname,U1.lastname) like '%$searchtext%') ";
}

// sorting
$sortorder = "name";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }
$sqlsorting = " order by $sortorder ";

// main SQL to fetch all users
$from_sql = " from institution I1 left join users U1 on U1.pk=I1.rep_pk ";

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

// the main user fetching query
$users_sql = "select I1.*, U1.username " . 
	$from_sql . $sqlsearch . $sqlsorting . $mysql_limit;
//print "SQL=$users_sql<br/>";
$result = mysql_query($users_sql) or die('User query failed: ' . mysql_error());
$items_displayed = mysql_num_rows($result);
?>

<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>">

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>

	<td nowrap="y"><b style="font-size:1.1em;">Paging:</b></td>
	<td nowrap="y">
		<input type="hidden" name="page" value="<?= $page ?>">
		<input class="filter" type="submit" name="paging" value="first" title="Go to the first page">
		<input class="filter" type="submit" name="paging" value="prev" title="Go to the previous page">
		<span class="keytext">Page <?= $page ?> of <?= $total_pages ?></span>
		<input class="filter" type="submit" name="paging" value="next" title="Go to the next page">
		<input class="filter" type="submit" name="paging" value="last" title="Go to the last page">
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
        	length="20" title="Enter search text here">
        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements">
	</td>

	</tr>
	</table>
</div>

<table border="0" cellspacing="0" width="100%">
<tr class='tableheader'>
<td><a href="javascript:orderBy('name');">Name</a></td>
<td><a href="javascript:orderBy('abbr');">Abbr</a></td>
<td><a href="javascript:orderBy('type');">Type</a></td>
<td>Rep</td>
<td align="center"><a title="Add a new institution" href="admin_inst.php?pk=0&add=1">add</a></td>
</tr>

<?php 
$line = 0;
while($row=mysql_fetch_assoc($result)) {
	$line++;

	$rowstyle = "";
	if (!$row["rep_pk"]) {
		$rowstyle = " style = 'color:red;' ";
	}
	
	$linestyle = "oddrow";
	if ($line % 2 == 0) {
		$linestyle = "evenrow";
	} else {
		$linestyle = "oddrow";
	}
?>

<tr id="<?= $linestyle ?>" <?= $rowstyle ?> >
	<td class="line"><?= $row["name"] ?></td>
	<td class="line"><?= $row["abbr"] ?></td>
	<td class="line"><?= $row["type"] ?></td>
	<td class="line" align="left">
<?php 
if ($row["rep_pk"]) {
	$short_name = $row["username"];
	if (strlen($row["username"]) > 12) {
		$short_name = substr($row["username"],0,9) . "...";
	}
	echo "<label title='".$row["username"]."'>".$short_name."</label>";
} else {
	echo "<i>none</i>";
} ?>
	</td>
	<td class="line" align="center">
		<a href="admin_inst.php?pk=<?= $row['pk']?>">edit</a>
	</td>
</tr>

<?php } ?>

</table>
</form>

<?php // Include the FOOTER -AZ
include 'footer.php'; ?>

</body>
</html>