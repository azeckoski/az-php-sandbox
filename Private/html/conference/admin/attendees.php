<?php
/*
 * file: index.php
 * Created on Mar 23, 2006 10:39:51 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Attendee List";
$ACTIVE_MENU="REGISTER";  //for managing active links on multiple menus

$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
//require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("admin_conference")) {
	$allowed = 0;
	$Message = "Only admins with <b>admin_conference</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_URL/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}


// handle activation/deactivation controls
if ($allowed) {
	if ($_REQUEST['activate']) {
		$sql = "update conferences set activated='Y' where id='".$_REQUEST['activate']."'";
		$result = mysql_query($sql) or die("Update query failed ($sql): " . mysql_error());
	} else if ($_REQUEST['deactivate']) {
		$sql = "update conferences set activated='N' where id='".$_REQUEST['deactivate']."'";
		$result = mysql_query($sql) or die("Update query failed ($sql): " . mysql_error());
	}
}


// Roles Filter
$filter_roles_default = "show all Roles";
$filter_roles = "";
if ($_REQUEST["filter_roles"] && (!$_REQUEST["clearall"]) ) { $filter_roles = $_REQUEST["filter_roles"]; }

$filter_roles_sql = "";
if ($filter_roles && ($filter_roles != $filter_roles_default)) {
	$filter_roles_sql = " and primaryRole='$filter_roles' ";
} else {
	$filter_roles = $filter_roles_default;
}

// get the search
$searchtext = "";
if ($_REQUEST["searchtext"]) { $searchtext = $_REQUEST["searchtext"]; }
$sqlsearch = "";
if ($searchtext) {
	$sqlsearch = " and (U1.username like '%$searchtext%' or U1.firstname like '%$searchtext%' or " .
		"U1.lastname like '%$searchtext%' or U1.email like '%$searchtext%' or U1.institution like '%$searchtext%') ";
}

// sorting
$sortorder = "date_created desc";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }
$sqlsorting = " order by $sortorder ";

// main SQL to fetch all items
$from_sql = " from users U1 join conferences C1 on U1.pk=C1.users_pk where confID='$CONF_ID' " ;

// counting number of items
// **************** NOTE - APPLY THE FILTERS TO THE COUNT AS WELL
$count_sql = "select count(*) " . $from_sql . $sqlsearch;
$result = mysql_query($count_sql) or die('Count query failed: ' . mysql_error());
$row = mysql_fetch_array($result);
$total_items = $row[0];

// pagination control
$num_limit = 25;
if ($_REQUEST["num_limit"] == "All") { 
	$num_limit = $total_items;  
	$total_pages = 1;
}
else { 
	$num_limit = $_REQUEST["num_limit"];
	if ($num_limit <= 0) { $num_limit = 1; }
	$total_pages = ceil($total_items / $num_limit);
}


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

// we only want to limit the number of rows if we're not doing an export
if ($_REQUEST["export"]) {	$mysql_limit = "";	}
else {	$mysql_limit = " LIMIT $limitvalue, $num_limit"; }

$start_item = $limitvalue + 1;
$end_item = $limitvalue + $num_limit;
if ($end_item > $total_items) { $end_item = $total_items; }

// the main fetching query
$sql = "select U1.username, U1.firstname, U1.lastname, U1.email, " .
		"U1.primaryRole, U1.institution, U1.institution_pk, U1.address, U1.city, U1.state, U1.zipcode, U1.country,  U1.phone,  C1.* " .
	$from_sql . $sqlsearch . $filter_roles_sql . $sqlsorting . $mysql_limit;
//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$items_displayed = mysql_num_rows($result);

// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";

$DATE_FORMAT = "M d, Y h:i a";


// Do the export as requested by the user
if ($_REQUEST["export"] && $allowed) {
	$date = date("Ymd-Hi",time());
	$filename = "conf_attendees-" . $date . ".csv";
	header("Content-type: text/x-csv");
	header("Content-disposition: attachment; filename=$filename\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0");

	$line = 0;
	while ($item = mysql_fetch_assoc($result)) {
		$line++;
		if ($line == 1) {
			echo "\"Conference Attendees Export:\",,\"$CONF_NAME\",\"$CONF_ID\"\n";
			print join(',', array_keys($item)) . "\n"; // add header line
		}

		foreach ($item as $name=>$value) {
			$value = str_replace("\"", "\"\"", $value); // fix for double quotes
			$item[$name] = '"' . trim($value) . '"'; // put quotes around each item
		}
		echo join(',', $item) . "\n";
	}
	echo "\n\"Exported on:\",\"" . date($DATE_FORMAT,time()) . "\"\n";

	exit;
} // END EXPORT

// set header links
$EXTRA_LINKS = 
	"<span class='extralinks'>" .
	"<a class='active' href='$CONFADMIN_URL/admin/attendees.php'>Attendee List</a>" .
	"<a href='$CONFADMIN_URL/admin/payment_info.php'>Payments</a>" .
	"<a href='$CONFADMIN_URL/admin/check_in.php'>Onsite Check-in</a>" .
	"</span>";


?>

<?php // INCLUDE THE HTML HEAD
require $ACCOUNTS_PATH.'include/top_header.php'; ?>
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

function doConfirm(item, type, action) {
	var response = window.confirm("Are you sure you want to "+action+" this "+type+" ("+item+")?");
	if (response) {
		return true;
	}
	return false;
}
// -->
</script>
<?php include $ACCOUNTS_PATH.'include/header.php' ?>
<div id="maindata">
<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $ACCOUNTS_PATH.'include/footer.php';
		exit;
	}
?>


<form name="adminform" method="post" action="<?= $_SERVER['PHP_SELF'] ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>"/>

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
		<td>
			<strong>Filter:</strong>
		</td>
		<td>
			<select style="font-size:.9em;"name="filter_roles" title="Filter the items by role">
				<option value="<?= $filter_roles ?>" selected><?= $filter_roles ?></option>
				<option value="Developer/Programmer">Developer/Programmer</option>
				<option value="Faculty">Faculty</option>
				<option value="Faculty Development">Faculty Development</option>
				<option value="Implementor">Implementor</option>
				<option value="Instructional Designer">Instructional Designer</option>
				<option value="Instructional Technologist">Instructional Technologist</option>
				<option value="Librarian">Librarian</option>
				<option value="Manager">Manager</option>
				<option value="System Administrator">System Administrator</option>
				<option value="UI/Interaction Designer">UI/Interaction Designer</option>
				<option value="University Administration">University Administration</option>
				<option value="User Support">User Support</option>
				<option value="show all Roles">show all Roles</option>
			</select>
		    <input class="filter" type="submit" name="filter" value="Filter" title="Apply the current filter settings to the page" />
			&nbsp;&nbsp;
			
				</td>	<td align="right">

<?php
	$count_sql = "SELECT count(*) FROM conferences where activated = 'Y' and confId = '$CONF_ID'";
	$count_result = mysql_query($count_sql) or die("Count failed ($count_sql): " . mysql_error());
	$row = mysql_fetch_array($count_result);
	$total_activated = $row[0];

	$count_sql = "SELECT count(*) FROM conferences where date_created > curdate()-INTERVAL 7 DAY and confId = '$CONF_ID'";
	$count_result = mysql_query($count_sql) or die("Count failed ($count_sql): " . mysql_error());
	$row = mysql_fetch_array($count_result);
	$total_week = $row[0];

	$count_sql = "SELECT count(*) from conferences C1 join users U1 on U1.pk = C1.users_pk " .
			"and institution_pk = '1' where confId = '$CONF_ID'";
	$count_result = mysql_query($count_sql) or die("Count failed ($count_sql): " . mysql_error());
	$row = mysql_fetch_array($count_result);
	$non_members = $row[0];
?>
			<strong>Attendees:</strong> 
			<label title="number of active registrations\n(i.e. signed up and paid)"><?= $total_activated ?></label>
			<span style="font-size:.9em;">
			(<label title="total number of registrations\n(including those who have not paid yet)"><?= $total_items ?> total</label> 
			{<label style="color:red;" title="non-members that have not paid yet"><?= $total_items - $total_activated ?> inactive</label>},
			<label title="registrations in the past 7 days"><?= $total_week ?> recent</label>,
			<label title="members of Sakai partner institutions"><?= $total_items - $non_members ?> members</label> /
			<label style="color:#990099;" title="not members of Sakai partner institutions"><?= $non_members ?> non-members</label>)
			</span>
			
			
		</td>
	</tr>
	<tr>
		<td nowrap="y" style="padding-top:8px;" ><strong >Paging:</strong></td>
		<td nowrap="y" style="padding-top:8px;">
<?php if ($_REQUEST["num_limit"] == "All") { ?>
		<input type="hidden" name="num_limit" value="All"/>
		<span class="keytext">
			Displaying all <?= $total_items ?> items
			</span>&nbsp;&nbsp;
				<strong>Show </strong> <input class="filter" type="submit" name="num_limit" value="25" /> per page
<?php } else {  ?>
					<input type="hidden" name="page" value="<?= $page ?>" />
			<input class="filter" type="submit" name="paging" value="first" title="Go to the first page" />
			<input class="filter" type="submit" name="paging" value="prev" title="Go to the previous page" />
			<span class="keytext">Page <?= $page ?> of <?= $total_pages ?></span>
			<input class="filter" type="submit" name="paging" value="next" title="Go to the next page" />
			<input class="filter" type="submit" name="paging" value="last" title="Go to the last page" />
			<span class="keytext">&nbsp;-&nbsp;
			Displaying <?= $start_item ?> - <?= $end_item ?> of <?= $total_items ?> items (<?= $items_displayed ?> shown)
			</span>&nbsp;&nbsp;
		<strong>Show </strong> 	<input class="filter" type="submit" name="num_limit" value="All" />
<?php } ?>
		</td>
	
		<td nowrap="y" align="right" style="padding-top:8px;">
			<input class="filter" type="submit" name="clearall" value="Clear" title="Reset display to defaults" />
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
<td>&nbsp;&nbsp;&nbsp;</td>
<td><a href="javascript:orderBy('lastname');">Name</a></td>
<td><a href="javascript:orderBy('email');">Email</a></td>
<td><a href="javascript:orderBy('primaryRole');">Primary Role</a></td>
<td><a href="javascript:orderBy('institution');">Institution</a></td>
<td align="center"><a href="javascript:orderBy('date_created');">Date</a></td>
<td align="center">#</td>
</tr>

<?php
//TO DO  calculations for members vs non members 
//TO DO  report on the number of registrations each day (for Joseph's projections') 

$line = 0;
$row_num=$total_items;
while($row=mysql_fetch_assoc($result)) {
	$line++;

	//echo "<pre>",print_r($row),"</pre>"; 

	if (strlen($row["institution"]) > 33) {
		$row["institution"] = substr($row["institution"],0,35) . "...";
	}

	$rowstyle = "";
	if ($row["activated"] == 'N') {
		$rowstyle = " style = 'color:red;' ";
	} else if ($row["institution_pk"] == "1") {
		$rowstyle = " style = 'color:#990099;' ";
	}
	
	$linestyle = "oddrow";
	if ($line % 2 == 0) {
		$linestyle = "evenrow";
	} else {
		$linestyle = "oddrow";
	}
?>

<tr class="<?= $linestyle ?>" <?= $rowstyle ?> >
	<td>
<?php if ($row['activated'] == 'Y') { ?>
		<a title="Deactivate this user" 
			onClick="return confirm('Are you sure you want to deactivate this user (<?= $row['username'] ?>)')"
			href="<?= $_SERVER['PHP_SELF'] ?>?deactivate=<?= $row['id'] ?>">x</a>
<?php } else { ?>
		<a title="Activate this user" 
			onClick="return confirm('Are you sure you want to activate this user (<?= $row['username'] ?>)')"
			href="<?= $_SERVER['PHP_SELF'] ?>?activate=<?= $row['id'] ?>">+</a>	
<?php } ?>
	</td>
	<td class="line"><?= $row["firstname"] ?> <?= $row["lastname"] ?></td>
	<td class="line"><?= $row["email"] ?></td>
	<td class="line"><?= $row['primaryRole'] ?> </td>
	<td class="line"><?= $row["institution"] ?></td>
	<td class="line" align="center" nowrap="y" ><?= date($DATE_FORMAT,strtotime($row["date_created"])) ?></td>
	<td class="line"><?= $row_num ?></td>
</tr>

<?php 
	$row_num--;  
}   ?>

</table>
</form>

<div class="padding50"></div>
<br/>
<div class="definitions">
<div class="defheader">How to use attendees page</div>
<div style="padding:3px;">
The attendees page is primarily for viewing a report of attendees.<br/>
Use the export button to generate a spreadsheet of all attendees.<br/>
<span style="color:red;">Non-member users</span> are color coded and indicate 
anyone is not part of a Sakai partner institution.<br/>
<span style="color:#990099;">Inactive users</span> are color coded 
and represent anyone who has not paid the registration fee yet.<br/>
To activate a user even if they have not paid, use the <strong>+</strong> link to the left of their name.<br/>
To deactivate a user (basically disables their registration), use the <strong>x</strong> link to the left of their name.<br/>
</div>
</div>
</div>
<?php require $ACCOUNTS_PATH.'include/footer.php'; ?>
