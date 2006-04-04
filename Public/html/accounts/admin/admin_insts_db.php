<?php
/*
 * file: admin_insts.php
 * Created on Mar 5, 2006 8:26:54 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Admin Institutions";
$Message = "";

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
	$Message = "Only admins with <b>admin_accounts</b> or <b>admin_insts</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}


// get the search
$searchtext = "";
if ($_REQUEST["searchtext"]) { $searchtext = $_REQUEST["searchtext"]; }
$sqlsearch = "";
if ($searchtext) {
	$sqlsearch = " where (I1.name like '%$searchtext%' or I1.abbr like '%$searchtext%' or " .
		"I1.type like '%$searchtext%' or U1.username like '%$searchtext%' or " .
		"U1.firstname like '%$searchtext%' or U1.lastname like '%$searchtext%' or " .
		"U2.username like '%$searchtext%' or U2.firstname like '%$searchtext%' or " .
		"U2.lastname like '%$searchtext%') ";
}

// sorting
$sortorder = "name";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }
$sqlsorting = " order by $sortorder ";

// main SQL to fetch all users
$from_sql = " from institution I1 left join users U1 on U1.pk=I1.rep_pk " .
	"left join users U2 on U2.pk=I1.repvote_pk ";

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
$sql = "select I1.*, U1.username as rep_username, U1.email as rep_email, " . 
	"U2.username as repvote_username, U2.email as repvote_email " .
	$from_sql . $sqlsearch . $sqlsorting . $mysql_limit;
//print "SQL=$users_sql<br/>";
$result = mysql_query($sql) or die('User query failed: ' . mysql_error());
$items_displayed = mysql_num_rows($result);


// header top links
$EXTRA_LINKS = "<br/><span style='font-size:9pt;'>";
$EXTRA_LINKS .= "<a href='index.php'>Admin</a>: ";
if ($USE_LDAP) {
	$EXTRA_LINKS .=	"<a href='admin_ldap.php'>LDAP</a> - ";
}
$EXTRA_LINKS .= "<a href='admin_users.php'>Users</a> - " .
	"<a href='admin_insts.php'><strong>Institutions</strong></a> - " .
	"<a href='admin_perms.php'>Permissions</a>" .
	"</span>";

// Do an LDIF export
if ($_REQUEST["ldif"] && $allowed) {
	$date = date("Ymd-Hi",time());
	$filename = "institutions-" . $date . ".ldif";
	header("Content-type: text/plain; charset=utf-8");
	header("Content-disposition: inline; filename=$filename\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0");

	// get everything except the "other" inst
	$sql = "select * from institution where pk > 1 order by pk";
	//print "SQL=$sql<br/>";
	$result = mysql_query($sql) or die("Inst ldif query failed ($sql): " . mysql_error());
	$items_count = mysql_num_rows($result);

	echo "# LDIF export of institutions on $date - includes $items_count items\n";
	echo "# Use the following command to insert this export into ldap:\n";
	echo "# ldapadd -x -D \"cn=Manager,dc=sakaiproject,dc=org\" -W -f $filename\n";
	echo "# Use the following command to modify ldap using this export:\n";
	echo "# ldapmodify -x -D \"cn=Manager,dc=sakaiproject,dc=org\" -W -f $filename\n";
	echo "\n";
	while($itemrow=mysql_fetch_assoc($result)) {
		echo "# Institution: $itemrow[name]\n";
		echo "dn: iid=$itemrow[pk],ou=institutions,dc=sakaiproject,dc=org\n";
		echo "objectClass: sakaiInst\n";
		echo "iid: $itemrow[pk]\n";
		echo "o: $itemrow[name]\n";
		echo "instType: $itemrow[type]\n";
		if ($itemrow['city']) { echo "l: $itemrow[city]\n"; }
		if ($itemrow['state']) { echo "st: $itemrow[state]\n"; }
		if ($itemrow['zipcode']) { echo "postalCode: $itemrow[zipcode]\n"; }
		if ($itemrow['country']) { echo "c: $itemrow[country]\n"; }
		if ($itemrow['rep_pk']) { echo "repUid: $itemrow[rep_pk]\n"; }
		if ($itemrow['repvote_pk']) { echo "voteUid: $itemrow[repvote_pk]\n"; }
		echo "\n"; // blank line to separate entries
	}
	exit();
}

// Do the export as requested by the user
if ($_REQUEST["export"] && $allowed) {
	$date = date("Ymd-Hi",time());
	$filename = "institutions-" . $date . ".csv";
	header("Content-type: text/x-csv");
	header("Content-disposition: inline; filename=$filename\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0"); 
} else {
	// display the page normally
?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
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
// -->
</script>
<?php include $ACCOUNTS_PATH.'include/header.php'; // INCLUDE THE HEADER ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $ACCOUNTS_PATH.'include/footer.php';
		exit;
	}
?>


<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
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
		<input class="filter" type="submit" name="ldif" value="LDIF" title="Export an LDIF (ldap) file of all institutions" />
		<input class="filter" type="submit" name="export" value="Export" title="Export results based on current filters" />
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
<td><a href="javascript:orderBy('name');">Name</a></td>
<td><a href="javascript:orderBy('abbr');">Abbr</a></td>
<td><a href="javascript:orderBy('type');">Type</a></td>
<td>InstRep</td>
<td>VoteRep</td>
<td align="center"><a title="Add a new institution" href="admin_inst.php?pk=-1&amp;add=1">add</a></td>
</tr>

<?php } // end export else 
$line = 0;
while($itemrow=mysql_fetch_assoc($result)) {
	$line++;

	if ($_REQUEST["export"]) {
		// print out EXPORT format instead of display
		if ($line == 1) {
			$output = "\"Institutions Export:\",\n";
			print join(',', array_keys($itemrow)) . "\n"; // add header line
		}
		
		foreach ($itemrow as $name=>$value) {
			$value = str_replace("\"", "\"\"", $value); // fix for double quotes
			$itemrow[$name] = '"' . $value . '"'; // put quotes around each item
		}
		print join(',', $itemrow) . "\n";
		
	} else {
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

<tr class="<?= $linestyle ?>" <?= $rowstyle ?> >
	<td class="line"><?= $itemrow["name"] ?></td>
	<td class="line"><?= $itemrow["abbr"] ?>&nbsp;</td>
	<td class="line"><?= $itemrow["type"] ?></td>
	<td class="line" align="left">
<?php 
if ($itemrow["rep_pk"]) {
	$short_name = $itemrow["rep_username"];
	if (strlen($itemrow["rep_username"]) > 12) {
		$short_name = substr($itemrow["rep_username"],0,9) . "...";
	}
	echo "<label title='".$itemrow["rep_username"]."'>".$short_name."</label>";
} else {
	echo "<i>none</i>";
} ?>
	</td>
	<td class="line" align="left">
<?php 
if ($itemrow["repvote_pk"]) {
	$short_name = $itemrow["repvote_username"];
	if (strlen($itemrow["repvote_username"]) > 12) {
		$short_name = substr($itemrow["repvote_username"],0,9) . "...";
	}
	echo "<label title='".$itemrow["repvote_username"]."'>".$short_name."</label>";
} else {
	echo "<i>none</i>";
} ?>
	</td>
	<td class="line" align="center">
		<a href="admin_inst.php?pk=<?= $itemrow['pk']?>">edit</a>
	</td>
</tr>

<?php 
	} // end display else
} // end while

if ($_REQUEST["export"]) {
	print "\n\"Exported on:\",\"" . date($DATE_FORMAT,time()) . "\"\n";
} else { // display only
?>

</table>
</form>

<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>

<?php } // end display ?>
