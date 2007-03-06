<?php
/*
 * file: check_in.php
 * Created on Apr 15, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Arrivals Check In";
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("admin_conference")) {
	$allowed = 0;
	$Message = "Only admins with <b>admin_conference</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_URL/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}


// handle check in
if ($_REQUEST['check_in']) {
	$checkUser = $_REQUEST['check_in'];
	$sql = "select * from users where users.pk = '$checkUser'";
	//print "SQL=$sql<br/>";
	$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
	$userInfo = mysql_fetch_assoc($result);

	if (!empty($userInfo)) {
		$sql = "update conferences set arrived = NOW() where users_pk='$checkUser'";
		//print "SQL=$sql<br/>";
		$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());

		if (mysql_affected_rows()) {
			$Message = "<span style='color:green'>" .
				"Checked in user: <strong>" . $userInfo['firstname'] . " " . $userInfo['lastname'] .
				"</strong> on " . date($DATE_FORMAT,time()) . "</span>";
		} else {
			$Message = "<span style='color:red;font-weight:bold;'>" .
				"Could not check in user with pk: $checkUser (could not update conference table)</span>";
		}
	} else {
		$Message = "<span style='color:red;font-weight:bold;'>" .
			"Could not check in user with pk: $checkUser (user pk invalid)</span>";
	}
} else if ($_REQUEST['check_out']) {
	$checkUser = $_REQUEST['check_out'];
		$sql = "update conferences set arrived = null where users_pk='$checkUser'";
		//print "SQL=$sql<br/>";
		$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());

		if (mysql_affected_rows()) {
			$Message = "<span style='color:green'>" .
				"Checked out user with PK: $checkUser</span>";
		} else {
			$Message = "<span style='color:red;font-weight:bold;'>" .
				"Could not check in user with pk: $checkUser (could not update conference table)</span>";
		}
}

// handle the filters
$sql_filter = "";
if ($_REQUEST['show_in']) {
	$sql_filter = " and arrived is not null ";
} else if ($_REQUEST['show_na']) {
	$sql_filter = " and arrived is null ";
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
if ($_REQUEST["searchtext"] && (!$_REQUEST["clearall"]) ) { $searchtext = $_REQUEST["searchtext"]; }
$sqlsearch = "";
if ($searchtext) {
	$sqlsearch = " and (U1.username like '%$searchtext%' or U1.firstname like '%$searchtext%' or " .
		"U1.lastname like '%$searchtext%' or U1.email like '%$searchtext%' or " .
		"CONCAT(U1.firstname,' ',U1.lastname) like '%$searchtext%' or " .
		"U1.institution like '%$searchtext%') ";
}

// sorting
$sortorder = "date_created desc";
if ($_REQUEST["sortorder"]  && (!$_REQUEST["clearall"]) ) { $sortorder = $_REQUEST["sortorder"]; }
$sqlsorting = " order by $sortorder ";

// main SQL to fetch all items
$from_sql = " from users U1 join conferences C1 on U1.pk=C1.users_pk " .
		"where C1.activated='Y' and C1.confID='$CONF_ID' " ;

// counting number of items
// **************** NOTE - APPLY THE FILTERS TO THE COUNT AS WELL
$count_sql = "select count(*) " . $from_sql . $sqlsearch;
$result = mysql_query($count_sql) or die('Count query failed: ' . mysql_error());
$row = mysql_fetch_array($result);
$total_items = $row[0];

// pagination control
$num_limit = 25;
if ($_REQUEST["num_limit"]) { $num_limit = $_REQUEST["num_limit"]; }
if ($_REQUEST["show_all"] && (!$_REQUEST["clearall"]) ) { $num_limit = $total_items; }

if ($num_limit <= 0) { $num_limit = 1; } // for division by zero
$total_pages = ceil($total_items / $num_limit);

$default_page = 1;
if ($_REQUEST["page"] && (!$_REQUEST["clearall"]) ) { $page = $_REQUEST["page"]; }

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

// the main fetching query
$sql = "select U1.pk as userpk, U1.firstname, U1.lastname, U1.email, " .
		"U1.institution, U1.institution_pk, C1.* " .
	$from_sql . $sql_filter . $filter_roles_sql . $sqlsearch . $sqlsorting . $mysql_limit;
//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$items_displayed = mysql_num_rows($result);

// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
$DATE_FORMAT = "M d, Y h:i A";


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
			echo "\"Conference Check-in Export:\",,\"$CONF_NAME\",\"$CONF_ID\"\n";
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
	"<br/><span style='font-size:9pt;'>" .
	"<a href='index.php'>Admin:</a> " .
	"<a href='attendees.php'>Attendees</a> - " .
	"<a href='proposals.php'>Proposals</a> - " .
	"<a href='check_in.php'><strong>Check In</strong></a> " .
		"(<em>" .
		"<a href='create_badge.php?USERS_PK[]=all' target='new'>All Badges [pdf]</a>" .
		"</em>) - " .
	"<a href='schedule.php'>Schedule</a> - " .
	"<a href='volunteers.php'>Volunteers</a> " .
	"</span>";
?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
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

function checkInUser(num) {
	var response = window.confirm("Check in this user now?");
	if (response) {
		document.adminform.check_in.value = num;
		document.adminform.submit();
		return false;
	}
}

function unCheckInUser(num) {
	var response = window.confirm("Reset this user to Not checked in?");
	if (response) {
		document.adminform.check_out.value = num;
		document.adminform.submit();
		return false;
	}
}
// -->
</script>
<?php include $TOOL_PATH.'include/admin_header.php'; ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $TOOL_PATH.'include/admin_footer.php';
		exit;
	}
?>


<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>"/>
<input type="hidden" name="check_in" value=""/>
<input type="hidden" name="check_out" value=""/>

<div class="filterarea">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
		<td nowrap="y"><b style="font-size:1.1em;">Info:</b></td>
		<td nowrap="y" colspan="2">
			<div style="float:left;">
				<strong><?= $CONF_NAME ?></strong>
				(<?= date($SHORT_DATE_FORMAT,strtotime($CONF_START_DATE)) ?> - <?= date($SHORT_DATE_FORMAT,strtotime($CONF_END_DATE)) ?>)
			</div>
			<div style="float:right;">

<?php
	$count_sql = "SELECT count(*) FROM conferences where arrived is not NULL and confId = '$CONF_ID'";
	$count_result = mysql_query($count_sql) or die("Count failed ($count_sql): " . mysql_error());
	$row = mysql_fetch_array($count_result);
	$total_arrived = $row[0];

	$count_sql = "SELECT count(*) FROM conferences where activated='Y' and confId = '$CONF_ID'";
	$count_result = mysql_query($count_sql) or die("Count failed ($count_sql): " . mysql_error());
	$row = mysql_fetch_array($count_result);
	$total_registered = $row[0];

	$count_sql = "SELECT count(*) FROM conferences where arrived > curdate()-INTERVAL 1 DAY and confId = '$CONF_ID'";
	$count_result = mysql_query($count_sql) or die("Count failed ($count_sql): " . mysql_error());
	$row = mysql_fetch_array($count_result);
	$total_today = $row[0];

	$count_sql = "SELECT count(*) from conferences C1 join users U1 on U1.pk = C1.users_pk " .
			"and institution_pk = '1' where arrived is not NULL and confId = '$CONF_ID'";
	$count_result = mysql_query($count_sql) or die("Count failed ($count_sql): " . mysql_error());
	$row = mysql_fetch_array($count_result);
	$non_members = $row[0];
?>
			<strong>Arrivals:</strong> 
			<label title="total people who have checked in"><?= $total_arrived ?></label>
			<span style="font-size:.9em;">
			(<label title="total number of active registrations"><?= $total_registered ?> registered</label>, 
			<label title="people who have checked in today"><?= $total_today ?> today</label>,
			<label title="members of Sakai partner institutions"><?= $total_arrived - $non_members ?> members</label> /
			<label style="color:#990099;" title="not members of Sakai partner institutions"><?= $non_members ?> non-members</label>)
			</span>
			</div>
		</td>
	</tr>

	<tr>
		<td nowrap="y"><b style="font-size:1.1em;">Paging:</b></td>
		<td nowrap="y">
			<input type="hidden" name="page" value="<?= $page ?>" />
			<input class="filter" type="submit" name="paging" value="prev" title="Go to the previous page" />
			<span class="keytext">Page <?= $page ?> of <?= $total_pages ?></span>
			<input class="filter" type="submit" name="paging" value="next" title="Go to the next page" />
			<span class="keytext">&nbsp;-&nbsp;
			Displaying <?= $start_item ?> - <?= $end_item ?> of <?= $total_items ?> items (<?= $items_displayed ?> shown)
			</span>&nbsp;&nbsp;
			<strong>Show:</strong> 
<?php if ($_REQUEST["show_all"]) { ?>
			<input class="filter" type="submit" name="num_limit" value="25" />
<?php } else { ?>
			<input class="filter" type="submit" name="show_all" value="All" />
<?php } ?>
<?php
	$show_in_style = "";
	$show_na_style = "";
	if ($_REQUEST["show_in"]) {
		$show_in_style = "style='background:red;'";
	} else if ($_REQUEST["show_na"]) {
		$show_na_style = "style='background:red;'";
	}
?>
			<input <?= $show_in_style ?> class="filter" type="submit" name="show_in" value="IN" title="show all users who have checked in" />
			<input <?= $show_na_style ?> class="filter" type="submit" name="show_na" value="NA" title="show all users who have not arrived yet" />
		</td>
	
		<td nowrap="y" align="right">
			<input class="filter" type="submit" name="clearall" value="Clear" title="Reset display to defaults" />
			<input class="filter" type="submit" name="export" value="Export" title="Export results based on current filters" />
	        <input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>"
	        	size="20" title="Enter search text here" />
	        <script type="text/javascript">document.adminform.searchtext.focus();</script>
	        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements" />
		</td>
	</tr>
		<tr>
		<td>
			<strong style="font-size:1.1em;">Filter:</strong>
		</td>
		<td>
			<select name="filter_roles" title="Filter the items by role">
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
		    <input class="filter" type="submit" name="filter" value="Filter" title="Apply the current filter settings to the page">
			&nbsp;&nbsp;
		</td>
		<td>
			<strong>Badges:</strong>
			<a href='one_badge.php' target='new'>Create special badge</a>
			-
			<a href='create_badge.php?USERS_PK[]=all' target='new'>Print all Badges [pdf]</a>
		</td>
	</tr>
	

	</table>
</div>

<table border="0" cellspacing="0" width="100%">
<tr class='tableheader'>
<td></td>
<td><a href="javascript:orderBy('lastname');">Name</a></td>
<td><a href="javascript:orderBy('institution');">Institution</a></td>
<td><a href="javascript:orderBy('shirt');">Shirt</a></td>
<td align="center"><a href="javascript:orderBy('date_created');">Registration Date</a></td>
<td align="center"><a href="javascript:orderBy('arrived');">Arrival Date</a></td>
<td align="center" width="10%"><a href="javascript:orderBy('printed_badge');">Badge</a></td>
</tr>

<?php
$line = 0;
$row_num=$total_items;
while($row=mysql_fetch_assoc($result)) {
	$line++;
	
	if (strlen($row["institution"]) > 38) {
		$row["institution"] = substr($row["institution"],0,40) . "...";
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
	<td class="line" style="text-align:center;"><?= $line ?>&nbsp;</td>

	<td class="line">
		<?= $row["firstname"] ?> <?= $row["lastname"] ?>
	</td>

	<td class="line"><?= $row["institution"] ?></td>

	<td class="line">
		<?= $row["shirt"] ?>
<?php if ($row['special']) { ?>
		<label style="font-size:.9em;color:darkblue;" title="Special Needs: <?= $row['special'] ?>">[special]</label>
<?php } ?>
	</td>
<td class="line" align="center"><?= date($DATE_FORMAT,strtotime($row["date_created"])) ?></td>
	<td class="line" align="center">
<?php 
	if($row["arrived"]) {
		echo date($DATE_FORMAT,strtotime($row["arrived"]));
		echo "&nbsp;<input style='font-size:7pt;' type='button' name='check' value='X' " .
				"onClick='javascript:unCheckInUser(".$row['userpk'].");return false;' />";
	} else {
		echo "<em>Not arrived</em> - " .
				"<input style='font-size:7pt;' type='button' name='check' value='Check In' " .
				"onClick='javascript:checkInUser(".$row['userpk'].");return false;' />";
	}
?>
	</td>

	<td class="line" align="center">
		<input type="checkbox" name="USERS_PK[]" value="<?= $row['userpk'] ?>"/>
<?php if($row['printed_badge'] == "Y") { ?>
		<image width="20" height="20" src="../include/images/printer_r.gif" alt="printed" />
<?php } else { ?>
		<image width="20" height="20" src="../include/images/printer_g.gif" alt="not printed yet" />
<?php } ?>
	</td>
</tr>

<?php } ?>

<tr>
<td colspan="5">&nbsp;</td>
<td align="center">
<input type="submit" value="Print Badges" onClick="document.adminform.action='create_badge.php';"/>
</td>
</tr>
</table>
</form>

<br/>
<div class="right">
<div class="rightheader">How to use the conference check-in and badge printer</div>
<div style="padding:3px;">
<div>Users are listed in the order they registered by default, resort them by clicking on the headers for each column</div>
<div>To check-in a user click on the <strong>Check In</strong> button (only visible if the user is not checked in)<br/>
To undo a check-in, click on the <strong>X</strong> button (only visible if the user is checked in)</div>
<div>To only show all users, click the <strong>ALL</strong> button at the top</div>
<div>To only show users who have not checked in yet, click the <strong>NA</strong> button at the top</div>
<div>To only show users who have already checked in, click the <strong>IN</strong> button at the top</div>
<div>If a badge has not been printed for a user yet then a <font color="green">green</font> printer image <image width="20" height="20" src="../include/images/printer_g.gif" alt="not printed yet" /> will appear in the badge column.  If a badge has been printed, a <font color="red">red</font> printer image <image width="20" height="20" src="../include/images/printer_r.gif" alt="already printed " /> will appear in the badge column.  </div>
<div>To print badges for every activated and registered person, click the <strong>(All Badges [pdf])</strong> link at the top</div>
<div>To print badges for a select group of users, check the box(es) in the badge column and click the <strong>Print Badges</strong> button at the bottom of the page</div>
<div>To create a special badge for a key-note speaker or guest who is not a registered attendee, use the <strong>Create special badge</strong> link at the top</div>
</div>
</div>

<?php include $TOOL_PATH.'include/admin_footer.php'; ?>

