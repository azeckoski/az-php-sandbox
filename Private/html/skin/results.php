<?php/* * Created on Febrary 18, 2006 by @author aaronz * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/) */?><?phprequire_once 'include/tool_vars.php';$PAGE_NAME = "View Results";$Message = "";// connect to databaserequire 'sql/mysqlconnect.php';// check authenticationrequire $ACCOUNTS_PATH.'include/check_authentic.php';// add in the help link$EXTRA_LINKS = " - <a style='font-size:.8em;' href='$HELP_LINK' target='_HELP'>Help</a><br/>";// add in the display to let people know how long they have to vote$EXTRA_LINKS .= "<br/><div class='date_message'>";$allowed = 0; // assume user is NOT allowed unless otherwise shownif (strtotime($ROUND_END_DATE) < time()) {	// Everyone can access results after end date	$allowed = 1;	$viewAll = 1;	$EXTRA_LINKS .= "All voting closed " . date($DATE_FORMAT,strtotime($ROUND_END_DATE));} else {	// No results viewing allowed	$allowed = 0;	$EXTRA_LINKS .= "Voting closes on " . date($DATE_FORMAT,strtotime($ROUND_END_DATE));	$Message = "Voting results cannot be viewed until " . date($DATE_FORMAT,strtotime($ROUND_END_DATE));}$EXTRA_LINKS .= "</div>";// admin access checkif ($User->checkPerm("admin_skin")) { $allowed = 1; }// institution filtering$institution = "";if ($_REQUEST["institution"] && (!$_REQUEST["clearall"]) ) { $institution = $_REQUEST["institution"]; }$instSql = "";if ($institution && is_numeric($institution)) {	// use the inst pk	$instSql = " join users on users.pk = users_pk and institution_pk='$institution' ";} else {	// default to all	$institution = "all";	$instSql = "";}// first get the votes and drop them into a hash$votes_sql = "select skin_entries_pk, vote_usability, vote_asthetic, " .	"count(V.pk) as votes from skin_vote V " . $instSql .	"where round='$ROUND' group by skin_entries_pk, vote_usability, vote_asthetic";//print "VOTE_SQL=$votes_sql<br/>";$result = mysql_query($votes_sql) or die('Votes query failed: ' . mysql_error());$allvotes = array();while($row = mysql_fetch_array($result)) {	//print "Votes:" . $row[0] . ":" . $row[1] . "=" . $row[2] . "<br/>";	$allvotes[$row[0] . ":" . $row[1]] = $row[2];}mysql_free_result($result);// the SQL to fetch the requirements and related votes$from_sql = "from skin_entries D left join skin_vote V on " .	"skin_entries_pk = D.pk and V.users_pk='$User->pk' " .	"and V.round='$ROUND' where D.round='$ROUND' ";// Voting Filter$filter_items_default = "show all items";$filter_items = "";if ($_REQUEST["filter_items"] && (!$_REQUEST["clearall"]) ) { $filter_items = $_REQUEST["filter_items"]; }$special_filter = "";$filter_items_sql = "";if ($filter_items == "show my voted items") {	$filter_items_sql = " and vote is not null ";} else if ($filter_items == "show my unvoted items") {	$filter_items_sql = " and vote is null ";} else if ($filter_items == "show my critical items") {	$filter_items_sql = " and vote = '3' "; // critical = 3} else if ($filter_items == "show my essential items") {	$filter_items_sql = " and vote = '2' "; // essential = 2} else if ($filter_items == "show my desirable items") {	$filter_items_sql = " and vote = '1' "; // desirable = 1} else if ($filter_items == "show my not applicable items") {	$filter_items_sql = " and vote = '0' "; // NA = 0} else if ($filter_items == "show all voted items") {	$filter_items_sql = " and score > '0' ";} else if ($filter_items == "show all unvoted items") {	$filter_items_sql = " and score = '0' ";} else {	// show all items	$filter_items = $filter_items_default;	$filter_items_sql = "";}$sqlfilters = $filter_items_sql;// get the search$searchtext = "";if ($_REQUEST["searchtext"] && (!$_REQUEST["clearall"]) ) { $searchtext = $_REQUEST["searchtext"]; }$sqlsearch = "";if ($searchtext) {	$sqlsearch = " and (summary like '%$searchtext%' OR description like '%$searchtext%') ";}// set sorting$sorting_default = "DATE_CREATED";$sorting = "";if ($_REQUEST["sorting"] && (!$_REQUEST["clearall"]) ) { $sorting = $_REQUEST["sorting"]; }$sqlsorting = "";if ($sorting == "Date") {	$sqlsorting = " order by DATE_CREATED ";} else if ($sorting == "Date (reverse)") {	$sqlsorting = " order by DATE_CREATED desc ";} else {	$sorting = "Date";	$sqlsorting = " order by $sorting_default ";}// counting number of items// **************** NOTE - APPLY THE FILTERS TO THE COUNT AS WELL$count_sql = "select count(*) " . $from_sql . $sqlfilters . $sqlsearch;$result = mysql_query($count_sql) or die("Count query failed ($count_sql): " . mysql_error());$row = mysql_fetch_array($result);$total_items = $row[0];// pagination control$num_limit = 25;if ($_REQUEST["num_limit"]) { $num_limit = $_REQUEST["num_limit"]; }$total_pages = ceil($total_items / $num_limit);$page = 1;$PAGE = $_REQUEST["page"];if ($PAGE) { $page = $PAGE; }$PAGING = $_REQUEST["paging"];if ($PAGING) {	if ($PAGING == 'first') { $page = 1; }	else if ($PAGING == 'prev') { $page--; }	else if ($PAGING == 'next') { $page++; }	else if ($PAGING == 'last') { $page = $total_pages; }}if ($page > $total_pages) { $page = $total_pages; }if ($page <= 0) { $page = 1; }$limitvalue = $page * $num_limit - ($num_limit);$mysql_limit = " LIMIT $limitvalue, $num_limit";$start_item = $limitvalue + 1;$end_item = $limitvalue + $num_limit;if ($end_item > $total_items) { $end_item = $total_items; }// fetching all data items and votes for user$sql="select D.*, V.vote_usability, V.vote_asthetic " . $from_sql .		$sqlfilters . $sqlsearch . $sqlsorting . $mysql_limit;//print "Query=$sql<br>";$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());$items_displayed = mysql_num_rows($result);// Do the export as requested by the userif ($_REQUEST["export"] && $allowed) {	$date = date("Ymd-Hi",time());	$filename = $SHORT_NAME."_results-" . $date . ".csv";	header("Content-type: text/x-csv");	header("Content-disposition: inline; filename=$filename\n\n");	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	header("Expires: 0"); } else { 	// display the page normally?><?php include $ACCOUNTS_PATH.'include/top_header.php'; // INCLUDE THE HTML HEAD ?><script><!--// --></script><?php include 'include/header.php'; // INCLUDE THE HEADER ?><?= $Message ?><?php	// display footer and exit if not allowed	if (!$allowed) {		include 'include/footer.php';		exit;	}?><form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;"><div class="filterarea">	<table border=0 cellspacing=0 cellpadding=0 width="100%">	<tr>	<td nowrap="y">	<strong style="font-size:1.1em;">Filters:</strong>&nbsp;&nbsp;	</td>	<td nowrap="y">		<select name="filter_items" title="Filter the requirements by my votes">			<option value="<?= $filter_items ?>" selected><?= $filter_items ?></option>			<option value="show all items">show all items</option>			<option value="show all voted items">show all voted items</option>			<option value="show all unvoted items">show all unvoted items</option><?php if($User->pk) { ?>			<option value="show my voted items">show my voted items</option>			<option value="show my unvoted items">show my unvoted items</option>			<option value="show my critical items">show my critical items</option>			<option value="show my essential items">show my essential items</option>			<option value="show my desirable items">show my desirable items</option>			<option value="show my not applicable items">show my not applicable items</option><?php } ?>		</select>		&nbsp;	    <input class="filter" type="submit" name="filter" value="Filter" title="Apply the current filter settings to the page">	</td>	<td nowrap="y" align="right">        <input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>"        	length="20" title="Enter search text here">        <script>document.adminform.searchtext.focus();</script>        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements">	</td>	</tr>	<tr>	<td nowrap="y"><b style="font-size:1.1em;">Paging:</b></td>	<td nowrap="y">		<input type="hidden" name="page" value="<?= $page ?>" />		<input class="filter" type="submit" name="paging" value="first" title="Go to the first page" />		<input class="filter" type="submit" name="paging" value="prev" title="Go to the previous page" />		<span class="keytext">Page <?= $page ?> of <?= $total_pages ?></span>		<input class="filter" type="submit" name="paging" value="next" title="Go to the next page" />		<input class="filter" type="submit" name="paging" value="last" title="Go to the last page" />		<span class="keytext">&nbsp;-&nbsp;		Displaying <?= $start_item ?> - <?= $end_item ?> of <?= $total_items ?> items (<?= $items_displayed ?> shown)		&nbsp;-&nbsp;		Max of</span>		<select name="num_limit" title="Choose the max items to view per page">			<option value="<?= $num_limit ?>"><?= $num_limit ?></option>			<option value="10">10</option>			<option value="25">25</option>			<option value="50">50</option>			<option value="100">100</option>			<option value="200">200</option>			<option value="500">500</option>		</select>		<span class="keytext">items per page</span>	</td>	<td align="right">		<input class="filter" type="submit" name="export" value="Export" title="Export results based on current filters">		<input class="filter" type="submit" name="clearall" value="Clear All Filters" title="Reset all filters">	</td>	</tr>		</table>	<table width="100%" border="0" cellpadding="0">	<tr>		<td nowrap="y">		<b style="font-size:1.0em;">Institution:</b>		<select name="institution">			<option value='all' <?php if ($institution == "all") { echo "selected='Y'"; } ?>>All institutions</option>			<?php $institutionDropdownText = generate_partner_dropdown( $institution, 1 ); ?>			<?= $institutionDropdownText ?>		</select>	</td>		<td align="right" nowrap="y">		<b style="font-size:1.0em;">Sort:</b>		<select name="sorting" title="Choose the order to display items in">			<option value="<?= $sorting ?>"><?= $sorting ?></option>			<option value="Date">Date</option>			<option value="Date (reverse)">Date (reverse)</option>		</select>		<input class="filter" type="submit" name="sort" value="Sort" title="Sort items by the sort order">	</td>	</tr>	</table></div></form><table width=100% border=0 cellspacing=0><tr class='tableheader'><td width='10%'>&nbsp;VOTE</td><td width='10%'>&nbsp;Results</td><td width='5%' align="center">Item</td><td width='35%'>Summary</td><td width='40%'>Description</td></tr><?php } // end export else // Iterate through the items from the SQL$line = 0;while($itemrow=mysql_fetch_assoc($result)) {	$line++;	$pk=$itemrow["pk"];	// voting check	if (!isset($itemrow["vote"])) { $itemrow["vote"] = -1; }	// get votes counts	$total = 0;	for ($i=0; $i<count($VOTE_TEXT); $i++) {		$total += $allvotes["$pk:$i"];	}	$itemrow["Total Votes"] = $total;		$votes = array();	$percents = array();	$numerator = 0;	for ($i=0; $i<count($VOTE_TEXT); $i++) {		$votes[$i] = $allvotes["$pk:$i"]+0;		$itemrow[$VOTE_TEXT[$i]] = $votes[$i];		$percents[$i] = round(($votes[$i]/$total)*100,1);		$itemrow[$VOTE_TEXT[$i]."%"] = $percents[$i];		$numerator += ($i+1) * $votes[$i];	}	$checked = array();	$itemrow["Average"] = round($numerator/$total) - 1;	$itemrow["AvgText"] = $VOTE_TEXT[ $itemrow["Average"] ];	$checked[$itemrow["Average"]] = " class='avgvote' ";	// array_search(max($votes),$votes)	if ($_REQUEST["export"]) {		// print out EXPORT format instead of display		if ($line == 1) {			$output = "\"REQ vote export\",\"KEY:\",";			for ($i=0; $i<count($VOTE_TEXT); $i++) {				$output .= "\"" . $VOTE_TEXT[$i] . "=" . $i . "\",";			}			print $output . "\n";			print join(',', array_keys($itemrow)) . "\n"; // add header line		}				foreach ($itemrow as $name=>$value) {			$value = str_replace("\"", "\"\"", $value); // fix for double quotes			$itemrow[$name] = '"' . $value . '"'; // put quotes around each item		}		print join(',', $itemrow) . "\n";	} else {		// extra stuff for DISPLAY		$tdstyle = "";		if ($vote >= 0) {			// item has been voted on and saved			if ($checked[$itemrow["vote"]]) {				$checked[$itemrow["vote"]] = " class='matchvote' ";			} else {				$checked[$itemrow["vote"]] = " class='myvote' ";			}			$tdstyle = " class='saved' ";		}			$linestyle = "oddrow";		if ($line % 2 == 0) {			$linestyle = "evenrow";		} else {			$linestyle = "oddrow";		}?>	<tr class="<?= $linestyle ?>" valign="top">		<td id="vb<?= $pk ?>" <?= $tdstyle ?> nowrap='y' style='text-align:right;border-right:1px dotted #ccc;border-bottom:1px solid black;' rowspan="2"><?php	for ($vi = count($VOTE_TEXT)-1; $vi >= 0; $vi--) { ?>			<div <?= $checked[$vi] ?> >&nbsp;<label title="<?= $VOTE_HELP[$vi] ?>"><?= $VOTE_TEXT[$vi] ?></label>&nbsp;</div><?php	} ?>			<input id="vh<?= $pk ?>" type="hidden" name="cur<?= $pk ?>" value="<?= $itemrow["vote"] ?>">			<div style="margin:6px;"></div>			&nbsp;<label title="Total number of votes for this item">Total:</label>&nbsp;<br />			<div style="margin:12px;"></div>		</td>		<td nowrap="y" style='border-right:1px dotted #ccc;border-bottom:1px solid black;' rowspan="2">			<div style="margin-left:6px;"><?php	for ($vi = count($VOTE_TEXT)-1; $vi >= 0; $vi--) { ?>				<?= $votes[$vi] ?> (<?= $percents[$vi] ?>%)<br/><?php	} ?>				<div style='margin:6px;'></div>				<b><?= $total ?></b><br/>			</div>		</td>		<td nowrap='y'>			<?= $items["pk"] ?>		</td>		<td height="30px">			<div class="summary"><?= $items["summary"] ?></div>		</td>		<td rowspan="2" style="padding:2px;border-bottom:1px solid black;">			<div class="description"><?= $items["description"] ?></div>		</td>	</tr><?php		} //end display	} //end of while		if ($_REQUEST["export"]) {		print "\n\"Exported on:\",\"" . date($DATE_FORMAT,time()) . "\"\n";		print "\"Voting end date:\",\"" . date($DATE_FORMAT,strtotime($ROUND_END_DATE)) . "\"\n";	} else {?></table><div class="definitions"><div class="defheader">Color Key</div>		<b style="font-size:1.1em;">Key:</b> 	<?php if($User->pk) { ?>		<div class="myvote" style='display:inline;'>&nbsp;Your vote&nbsp;</div>		<div class="matchvote" style='display:inline;'><label title="Your vote matches the average">&nbsp;Your vote matches the average&nbsp;</label></div>	<?php } ?>		<div class="avgvote" style='display:inline;'>&nbsp;Average vote&nbsp;</div></div><?php include 'include/footer.php'; // Include the FOOTER ?><?php	} ?>