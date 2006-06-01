<?php
/*
 * file: results2.php
 * Created on May 18, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "View Results";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// add in the help link
$EXTRA_LINKS = " - <a style='font-size:.8em;' href='$HELP_LINK' target='_HELP'>Help</a><br/>";

// add in the display to let people know how long they have to vote
$EXTRA_LINKS .= "<div class='date_message'>";

$allowed = 0; // assume user is NOT allowed unless otherwise shown
if (strtotime($ROUND_END_DATE) < time()) {
	// Everyone can access results after end date
	$allowed = 1;
	$viewAll = 1;
	$EXTRA_LINKS .= "All voting closed " . date($DATE_FORMAT,strtotime($ROUND_END_DATE));
} else {
	// No results viewing allowed
	$allowed = 0;
	$EXTRA_LINKS .= "Voting closes on " . date($DATE_FORMAT,strtotime($ROUND_END_DATE));
	$Message = "Voting results cannot be viewed until " . date($DATE_FORMAT,strtotime($ROUND_END_DATE));
}

$EXTRA_LINKS .= "</div>";

// admin access check
if ($User->checkPerm("admin_skin")) { $allowed = 1; }

// get the flipped array
$SCORE_VOTE = array_flip($VOTE_SCORE);

// institution filtering
$institution = "";
if ($_REQUEST["institution"] && (!$_REQUEST["clearall"]) ) { $institution = $_REQUEST["institution"]; }
$instSql = "";
if ($institution && is_numeric($institution)) {
	// use the inst pk
	$instSql = " join users on users.pk = users_pk and institution_pk='$institution' ";
} else {
	// default to all
	$institution = "all";
	$instSql = "";
}

// first get the votes and drop them into a hash
$votes_sql = "select skin_entries_pk, vote_usability, count(V.pk) as votes " .
	"from skin_vote V where round='1' group by skin_entries_pk, vote_usability";
//print "VOTE_SQL=$votes_sql<br/>";
$result = mysql_query($votes_sql) or die('Votes query failed: ' . mysql_error());
$allvotesU = array();
while($row = mysql_fetch_array($result)) {
	$allvotesU[$row[0] . ":" . $row[1]] = $row[2];
}
mysql_free_result($result);

$votes_sql = "select skin_entries_pk, vote_asthetic, count(V.pk) as votes " .
	"from skin_vote V where round='1' group by skin_entries_pk, vote_asthetic";
//print "VOTE_SQL=$votes_sql<br/>";
$result = mysql_query($votes_sql) or die('Votes query failed: ' . mysql_error());
$allvotesA = array();
while($row = mysql_fetch_array($result)) {
	$allvotesA[$row[0] . ":" . $row[1]] = $row[2];
}
mysql_free_result($result);

//echo "<pre>",print_r($allvotesU),"</pre>";
//echo "<pre>",print_r($allvotesA),"</pre>";

// the SQL to fetch the requirements and related votes
$from_sql = "from skin_entries D left join skin_vote V on " .
	"skin_entries_pk = D.pk and V.users_pk='$User->pk' " .
	"and V.round='$ROUND' where D.round='$ROUND' ";

// Voting Filter
$filter_items_default = "show all items";
$filter_items = "";
if ($_REQUEST["filter_items"] && (!$_REQUEST["clearall"]) ) { $filter_items = $_REQUEST["filter_items"]; }

$special_filter = "";
$filter_items_sql = "";
if ($filter_items == "show my voted items") {
	$filter_items_sql = " and vote is not null ";
} else if ($filter_items == "show my unvoted items") {
	$filter_items_sql = " and vote is null ";
} else if ($filter_items == "show my critical items") {
	$filter_items_sql = " and vote = '3' "; // critical = 3
} else if ($filter_items == "show my essential items") {
	$filter_items_sql = " and vote = '2' "; // essential = 2
} else if ($filter_items == "show my desirable items") {
	$filter_items_sql = " and vote = '1' "; // desirable = 1
} else if ($filter_items == "show my not applicable items") {
	$filter_items_sql = " and vote = '0' "; // NA = 0
} else if ($filter_items == "show all voted items") {
	$filter_items_sql = " and score > '0' ";
} else if ($filter_items == "show all unvoted items") {
	$filter_items_sql = " and score = '0' ";
} else {
	// show all items
	$filter_items = $filter_items_default;
	$filter_items_sql = "";
}

$sqlfilters = $filter_items_sql;

// get the search
$searchtext = "";
if ($_REQUEST["searchtext"] && (!$_REQUEST["clearall"]) ) { $searchtext = $_REQUEST["searchtext"]; }
$sqlsearch = "";
if ($searchtext) {
	$sqlsearch = " and (summary like '%$searchtext%' OR description like '%$searchtext%') ";
}

// set sorting
$sorting_default = "DATE_CREATED";
$sorting = "";
if ($_REQUEST["sorting"] && (!$_REQUEST["clearall"]) ) { $sorting = $_REQUEST["sorting"]; }

$sqlsorting = "";
if ($sorting == "Date") {
	$sqlsorting = " order by DATE_CREATED ";
} else if ($sorting == "Date (reverse)") {
	$sqlsorting = " order by DATE_CREATED desc ";
} else {
	$sorting = "Date";
	$sqlsorting = " order by $sorting_default ";
}


// counting number of items
// **************** NOTE - APPLY THE FILTERS TO THE COUNT AS WELL
$count_sql = "select count(*) " . $from_sql . $sqlfilters . $sqlsearch;
$result = mysql_query($count_sql) or die("Count query failed ($count_sql): " . mysql_error());
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

// fetching all data items and votes for user
$sql="select D.*, V.vote_usability, V.vote_asthetic " . $from_sql .
		$sqlfilters . $sqlsearch . $sqlsorting . $mysql_limit;
//print "Query=$sql<br>";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$items_displayed = mysql_num_rows($result);


// Do the export as requested by the user
if ($_REQUEST["export"] && $allowed) {
	$date = date("Ymd-Hi",time());
	$filename = $SHORT_NAME."_results-" . $date . ".csv";
	header("Content-type: text/x-csv");
	header("Content-disposition: inline; filename=$filename\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0"); 
} else { 
	// display the page normally
?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script>
<!--
// -->
</script>
<?php include 'include/header.php'; ?>

<?= $Message ?>

<?php
	// display footer and exit if not allowed
	if (!$allowed) {
		include 'include/footer.php';
		exit;
	}
?>

<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">

<div class="filterarea">

	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
	<td nowrap="y">
	<strong style="font-size:1.1em;">Filters:</strong>&nbsp;&nbsp;
	</td>
	<td nowrap="y">
		<select name="filter_items" title="Filter the requirements by my votes">
			<option value="<?= $filter_items ?>" selected><?= $filter_items ?></option>
			<option value="show all items">show all items</option>
			<option value="show all voted items">show all voted items</option>
			<option value="show all unvoted items">show all unvoted items</option>
		</select>
		&nbsp;
	    <input class="filter" type="submit" name="filter" value="Filter" title="Apply the current filter settings to the page">
	</td>

	<td nowrap="y" align="right">
		<input class="filter" type="submit" name="clearall" value="Clear All Filters" title="Reset all filters" />
        <input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>"
        	length="20" title="Enter search text here" />
        <script>document.adminform.searchtext.focus();</script>
        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements" />
	</td>
	</tr>
	
	</table>

</div>

</form>


<table width=100% border=0 cellspacing=0>

<tr class='tableheader'>
<td width='10%' align="right">Usability&nbsp;</td>
<td width='10%'>&nbsp;Results</td>
<td width='10%' align="right">Asthetic&nbsp;</td>
<td width='10%'>&nbsp;Results</td>
<td width='40%'>Title / Description</td>
<td width='20%'></td>
</tr>

<?php } // end export else 
// Iterate through the items from the SQL
$line = 0;
while($itemrow=mysql_fetch_assoc($result)) {
	$line++;
	$pk=$itemrow["pk"];

	// TODO - verify that the votes line up with the results

	$total_usability = 0;
	$total_asthetic = 0;
	for ($i=0; $i<count($VOTE_TEXT); $i++) {
		$num = $VOTE_SCORE[$i];
		$total_usability += $allvotesU["$pk:$num"];
		$total_asthetic += $allvotesA["$pk:$num"];
	}
	$itemrow["Total Usability"] = $total_usability;
	$itemrow["Total Asthetic"] = $total_asthetic;

	$votes_usability = array();
	$percents_usability = array();
	$numerator_usability = 0;
	if ($total_usability) {
		for ($i=0; $i<count($VOTE_TEXT); $i++) {
			$num = $VOTE_SCORE[$i];
			$votes_usability[$i] = $allvotesU["$pk:$num"]+0;
			$itemrow[$VOTE_TEXT[$i]] = $votes_usability[$i];
			$percents_usability[$i] = round(($votes_usability[$i]/$total_usability)*100,1);
			$itemrow[$VOTE_TEXT[$i]."%"] = $percents_usability[$i];
			$numerator_usability += ($i+1) * $votes_usability[$i];
		}
	}

	$votes_asthetic = array();
	$percents_asthetic = array();
	$numerator_asthetic = 0;
	if ($total_asthetic) {
		for ($i=0; $i<count($VOTE_TEXT); $i++) {
			$num = $VOTE_SCORE[$i];
			$votes_asthetic[$i] = $allvotesA["$pk:$num"]+0;
			$itemrow[$VOTE_TEXT[$i]] = $votes_asthetic[$i];
			$percents_asthetic[$i] = round(($votes_asthetic[$i]/$total_asthetic)*100,1);
			$itemrow[$VOTE_TEXT[$i]."%"] = $percents_asthetic[$i];
			$numerator_asthetic += ($i+1) * $votes_asthetic[$i];
		}
	}

	$checked_usability = array();
	$itemrow["Average Usability"] = round($numerator_usability/$total_usability) - 1;
	$itemrow["AvgText Usability"] = $VOTE_TEXT[ $itemrow["Average Usability"] ];
	$checked_usability[$itemrow["Average Usability"]] = " class='avgvote' ";
	// array_search(max($votes),$votes)

	$checked_asthetic = array();
	$itemrow["Average Asthetic"] = round($numerator_asthetic/$total_asthetic) - 1;
	$itemrow["AvgText Asthetic"] = $VOTE_TEXT[ $itemrow["Average Asthetic"] ];
	$checked_asthetic[$itemrow["Average Asthetic"]] = " class='avgvote' ";
	// array_search(max($votes),$votes)


	if ($_REQUEST["export"]) {
		// print out EXPORT format instead of display
		if ($line == 1) {
			$output = "\"REQ vote export\",\"KEY:\",";
			for ($i=0; $i<count($VOTE_TEXT); $i++) {
				$output .= "\"" . $VOTE_TEXT[$i] . "=" . $i . "\",";
			}
			print $output . "\n";
			print join(',', array_keys($itemrow)) . "\n"; // add header line
		}
		
		foreach ($itemrow as $name=>$value) {
			$value = str_replace("\"", "\"\"", $value); // fix for double quotes
			$itemrow[$name] = '"' . $value . '"'; // put quotes around each item
		}
		print join(',', $itemrow) . "\n";
	} else {
		// extra stuff for DISPLAY
		$tdstyle_usability = "";
		if (isset($itemrow["vote_usability"])) {
			// item has been voted on and saved
			$num = $SCORE_VOTE[$itemrow["vote_usability"]];
			if ($checked_usability[$num]) {
				$checked_usability[$num] = " class='matchvote' ";
			} else {
				$checked_usability[$num] = " class='myvote' ";
			}
			$tdstyle_usability = " class='saved' ";
		}

		$tdstyle_asthetic = "";
		if (isset($itemrow["vote_asthetic"])) {
			// item has been voted on and saved
			$num = $SCORE_VOTE[$itemrow["vote_asthetic"]];
			if ($checked_asthetic[$num]) {
				$checked_asthetic[$num] = " class='matchvote' ";
			} else {
				$checked_asthetic[$num] = " class='myvote' ";
			}
			$tdstyle_asthetic = " class='saved' ";
		}


		$linestyle = "oddrow";
		if ($line % 2 == 0) {
			$linestyle = "evenrow";
		} else {
			$linestyle = "oddrow";
		}
?>

	<tr class="<?= $linestyle ?>" valign="top">
		<td id="vb<?= $pk ?>" <?= $tdstyle_usability ?> nowrap='y' style='text-align:right;border-right:1px dotted #ccc;border-bottom:1px solid black;' rowspan="2">
<?php	for ($vi = count($VOTE_TEXT)-1; $vi >= 0; $vi--) { ?>
			<div <?= $checked_usability[$vi] ?> >&nbsp;<label title="<?= $VOTE_HELP[$vi] ?>"><?= $VOTE_TEXT[$vi] ?></label>&nbsp;</div>
<?php	} ?>
			<input id="vh<?= $pk ?>" type="hidden" name="cur<?= $pk ?>" value="<?= $itemrow["vote"] ?>">
			<div style="margin:6px;"></div>
			&nbsp;<label title="Total number of votes for this item">Total:</label>&nbsp;<br />
			<div style="margin:12px;"></div>
		</td>

		<td nowrap="y" style='border-right:1px dotted #ccc;border-bottom:1px solid black;' rowspan="2">
			<div style="margin-left:6px;">
<?php	for ($vi = count($VOTE_TEXT)-1; $vi >= 0; $vi--) { ?>
				<?= $votes_usability[$vi] ?> (<?= $percents_usability[$vi] ?>%)<br/>
<?php	} ?>
				<div style='margin:6px;'></div>
				<b><?= $total_usability ?></b><br/>
			</div>
		</td>

		<td id="vb<?= $pk ?>" <?= $tdstyle_asthetic ?> nowrap='y' style='text-align:right;border-right:1px dotted #ccc;border-bottom:1px solid black;' rowspan="2">
<?php	for ($vi = count($VOTE_TEXT)-1; $vi >= 0; $vi--) { ?>
			<div <?= $checked_asthetic[$vi] ?> >&nbsp;<label title="<?= $VOTE_HELP[$vi] ?>"><?= $VOTE_TEXT[$vi] ?></label>&nbsp;</div>
<?php	} ?>
			<input id="vh<?= $pk ?>" type="hidden" name="cur<?= $pk ?>" value="<?= $itemrow["vote"] ?>" />
			<div style="margin:6px;"></div>
			&nbsp;<label title="Total number of votes for this item">Total:</label>&nbsp;<br />
			<div style="margin:12px;"></div>
		</td>

		<td nowrap="y" style='border-right:1px dotted #ccc;border-bottom:1px solid black;' rowspan="2">
			<div style="margin-left:6px;">
<?php	for ($vi = count($VOTE_TEXT)-1; $vi >= 0; $vi--) { ?>
				<?= $votes_asthetic[$vi] ?> (<?= $percents_asthetic[$vi] ?>%)<br/>
<?php	} ?>
				<div style='margin:6px;'></div>
				<b><?= $total_asthetic ?></b><br/>
			</div>
		</td>

		<td>
			<strong><?= $itemrow["title"] ?></strong><br/>
			<div class="description"><?= nl2br($itemrow["description"]) ?></div>
		</td>

		<td nowrap='y'>
			<a style="text-decoration:underline;" href="include/getFile.php?pk=<?= $itemrow['skin_zip'] ?>">Download skin</a>
		</td>
	</tr>
<?php
		} //end display
	} //end of while
	
	if ($_REQUEST["export"]) {
		print "\n\"Exported on:\",\"" . date($DATE_FORMAT,time()) . "\"\n";
		print "\"Voting end date:\",\"" . date($DATE_FORMAT,strtotime($ROUND_END_DATE)) . "\"\n";
	} else {
?>

</table>

<div class="definitions">
<div class="defheader">Color Key</div>
		<b style="font-size:1.1em;">Key:</b> 
	<?php if($User->pk) { ?>
		<div class="myvote" style='display:inline;'>&nbsp;Your vote&nbsp;</div>
		<div class="matchvote" style='display:inline;'><label title="Your vote matches the average">&nbsp;Your vote matches the average&nbsp;</label></div>
	<?php } ?>
		<div class="avgvote" style='display:inline;'>&nbsp;Average vote&nbsp;</div>
</div>

<?php include 'include/footer.php'; ?>

<?php	} ?>