<?php
/*
 * file: admin_users.php
 * Created on Mar 8, 2006 10:39:51 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Admin User Control";
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


// Do an LDIF export
if ($_REQUEST["ldif"] && $allowed) {
	$date = date("Ymd-Hi",time());
	$filename = "users-" . $date . ".ldif";
	header("Content-type: text/x-csv");
	header("Content-disposition: inline; filename=$filename\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0");

	// get everything except the "other" inst
	$sql = "select * from users order by pk";
	//print "SQL=$sql<br/>";
	$result = mysql_query($sql) or die("User ldif query failed ($sql): " . mysql_error());
	$items_count = mysql_num_rows($result);

	echo "# LDIF export of users on $date - includes $items_count items\n";
	echo "# Note that password CAN NOT transfer so users will have to reset them\n";
	echo "# Use the following command to insert this export into ldap:\n";
	echo "# ldapadd -x -D \"cn=Manager,dc=sakaiproject,dc=org\" -W -f $filename\n";
	echo "# Use the following command to modify ldap using this export:\n";
	echo "# ldapmodify -x -D \"cn=Manager,dc=sakaiproject,dc=org\" -W -f $filename\n";
	echo "\n";
	while($itemrow=mysql_fetch_assoc($result)) {
		echo "# User: $itemrow[firstname] $itemrow[lastname]\n";
		echo "dn: uid=$itemrow[pk],ou=users,dc=sakaiproject,dc=org\n";
		echo "objectClass: top\n";
		echo "objectClass: person\n";
		echo "objectClass: organizationalPerson\n";
		echo "objectClass: inetOrgPerson\n";
		echo "objectClass: sakaiAccount\n";
		echo "uid: $itemrow[pk]\n";
		echo "userPassword: {MD5}wEzZhXMc+aSKrvl2hq+S2g==\n";
		echo "cn: $itemrow[firstname] $itemrow[lastname]\n";
		echo "givenname: $itemrow[firstname]\n";
		echo "sn: $itemrow[lastname]\n";
		echo "sakaiUser: $itemrow[username]\n";
		// convert the string of perms to mutiple lines
		$permArray = explode(":",$itemrow['sakaiPerms']);
		if (is_array($permArray)) {
			foreach ($permArray as $value) {
				echo "sakaiPerm: $value\n";
			}
		}
		echo "mail: $itemrow[email]\n";
		echo "iid: $itemrow[institution_pk]\n";
		if ($itemrow['institution']) { echo "o: $itemrow[institution]\n"; }
		if ($itemrow['primaryRole']) { echo "primaryRole: $itemrow[primaryRole]\n"; }
		if ($itemrow['secondaryRole']) { echo "secondaryRole: $itemrow[secondaryRole]\n"; }
		if ($itemrow['phone']) { echo "telephoneNumber: $itemrow[phone]\n"; }
		if ($itemrow['fax']) { echo "facsimileTelephoneNumber: $itemrow[fax]\n"; }
		if ($itemrow['address']) { echo "postalAddress: $itemrow[address]\n"; }
		if ($itemrow['city']) { echo "l: $itemrow[city]\n"; }
		if ($itemrow['state']) { echo "st: $itemrow[state]\n"; }
		if ($itemrow['zipcode']) { echo "postalCode: $itemrow[zipcode]\n"; }
		if ($itemrow['country']) { echo "c: $itemrow[country]\n"; }
		echo "\n"; // blank line to separate entries
	}
	exit();
}


// top header links
$EXTRA_LINKS = "<br/><span style='font-size:9pt;'>";
$EXTRA_LINKS .= "<a href='index.php'>Admin</a>: ";
if ($USE_LDAP) {
	$EXTRA_LINKS .=	"<a href='admin_ldap.php'>LDAP</a> - ";
}
$EXTRA_LINKS .= "<a href='admin_users.php'><strong>Users</strong></a> - " .
	"<a href='admin_insts.php'>Institutions</a> - " .
	"<a href='admin_perms.php'>Permissions</a>" .
	"</span>";

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

<?php

// get the search
$searchtext = "";
if ($_REQUEST["searchtext"]) { $searchtext = $_REQUEST["searchtext"]; }
$sqlsearch = "";
if ($searchtext) {
	$sqlsearch = " where (U1.username like '%$searchtext%' or U1.firstname like '%$searchtext%' or " .
		"U1.lastname like '%$searchtext%' or U1.email like '%$searchtext%') ";
}

// sorting
$sortorder = "username";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }
$sqlsorting = " order by $sortorder ";

// main SQL to fetch all users
$from_sql = " from users U1 left join institution I1 on U1.institution_pk=I1.pk " .
	"left join users U2 on U2.pk = I1.rep_pk left join users U3 on U3.pk = I1.repvote_pk ";

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
$users_sql = "select U1.*, I1.name as institution, U2.username as rep_username, U2.email as rep_email, " .
	" U3.username as vote_username, U3.email as vote_email " .
	$from_sql . $sqlsearch . $sqlsorting . $mysql_limit;
//print "SQL=$users_sql<br/>";
$result = mysql_query($users_sql) or die('User query failed: ' . mysql_error());
$items_displayed = mysql_num_rows($result);
?>

<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>"/>

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>

	<td nowrap="y"><b style="font-size:1.1em;">Paging:</b></td>
	<td nowrap="y">
		<input type="hidden" name="page" value="<?= $page ?>"/>
		<input class="filter" type="submit" name="paging" value="first" title="Go to the first page"/>
		<input class="filter" type="submit" name="paging" value="prev" title="Go to the previous page"/>
		<span class="keytext">Page <?= $page ?> of <?= $total_pages ?></span>
		<input class="filter" type="submit" name="paging" value="next" title="Go to the next page"/>
		<input class="filter" type="submit" name="paging" value="last" title="Go to the last page"/>
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
		<input class="filter" type="submit" name="ldif" value="LDIF" title="Export an LDIF (ldap) file of all users" />
        <input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>"
        	size="20" title="Enter search text here"/>
        <script type="text/javascript">document.adminform.searchtext.focus();</script>
        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements"/>
	</td>

	</tr>
	</table>
</div>

<table border="0" cellspacing="0" width="100%">
<tr class='tableheader'>
<td><a href="javascript:orderBy('username');">username</a></td>
<td><a href="javascript:orderBy('lastname');">Name</a></td>
<td><a href="javascript:orderBy('email');">Email</a></td>
<td><a href="javascript:orderBy('institution');">Institution</a></td>
<td align="center">Rep</td>
<td align="center"><a href="javascript:orderBy('date_created');">Date</a></td>
</tr>

<?php 
$line = 0;
while($row=mysql_fetch_assoc($result)) {
	$line++;
	
	if (strlen($row["institution"]) > 38) {
		$row["institution"] = substr($row["institution"],0,35) . "...";
	}

	$rowstyle = "";
	if (strpos($row["sakaiPerms"],"active") === false) {
		$rowstyle = " style = 'color:red;' ";
	} else if (strpos($row["sakaiPerms"],"admin_reqs") !== false) {
		$rowstyle = " style = 'color:darkgreen;' ";
	} else if (strpos($row["sakaiPerms"],"admin_insts") !== false) {
		$rowstyle = " style = 'color:darkblue;' ";
	} else if (strpos($row["sakaiPerms"],"admin_accounts") !== false) {
		$rowstyle = " style = 'color:#330066;' ";
	}
	
	$linestyle = "oddrow";
	if ($line % 2 == 0) {
		$linestyle = "evenrow";
	} else {
		$linestyle = "oddrow";
	}
?>

<tr class="<?= $linestyle ?>" <?= $rowstyle ?> >
	<td class="line"><?= $row["username"] ?></td>
	<td class="line"><?= $row["firstname"] ?> <?= $row["lastname"] ?></td>
	<td class="line"><?= $row["email"] ?></td>
	<td class="line"><?= $row["institution"] ?></td>
	<td class="line" align="center">
<?php 
if ($row["username"] == $row["rep_username"]) { 
	echo "<b style='color:#000066;'>Inst Rep</b>";
} else if ($row["username"] == $row["vote_username"]) { 
	echo "<b style='color:#006600;'>Vote Rep</b>";
} else {
	if ($row["rep_username"]) {
		$short_name = $row["rep_username"];
		if (strlen($row["rep_username"]) > 12) {
			$short_name = substr($row["rep_username"],0,9) . "...";
		}
		echo "<label title='".$row["rep_username"]."'>".$short_name."</label>";
	} else {
		echo "<i style='color:#CC0000;'>none</i>";
	}
} ?>
	</td>
	<td class="line" align="center">
		<a href="admin_user.php?pk=<?= $row['pk']?>">edit</a>
	</td>
</tr>

<?php } ?>

</table>
</form>

<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>