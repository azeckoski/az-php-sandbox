<?php/* * Created on Febrary 18, 2006 by @author aaronz * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/) */?><?phprequire_once 'include/tool_vars.php';$PAGE_NAME = "View Results";$Message = "";// connect to databaserequire 'sql/mysqlconnect.php';// check authenticationrequire $ACCOUNTS_PATH.'include/check_authentic.php';// add in the help link$EXTRA_LINKS = " - <a style='font-size:.8em;' href='$HELP_LINK' target='_HELP'>Help</a><br/>";// add in the display to let people know how long they have to vote$EXTRA_LINKS .= "<br/><div class='date_message'>";$isRep = 0; // assume user is not an institutional rep$viewAll = 0; // assume viewing limited$allowed = 0; // assume user is NOT allowed unless otherwise shownif (strtotime($ROUND_CLOSE_DATE) < time()) {	// Everyone can access everything after close date	$allowed = 1;	$viewAll = 1;	$EXTRA_LINKS .= "All voting closed " . date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));} else if (strtotime($ROUND_SWITCH_DATE) < time()) {	// Everyone can access after this date	$allowed = 1;	$EXTRA_LINKS .= "Community poll closed " . date($ROUND_DATE_FORMAT,strtotime($ROUND_SWITCH_DATE));} else if (strtotime($ROUND_OPEN_DATE) < time() && $USER_PK) {	// User must be a voting or institution rep for access	$check_rep_sql="select pk from institution where rep_pk = '$USER_PK' or repvote_pk = '$USER_PK'";	$result = mysql_query($check_rep_sql) or die('Query failed: ' . mysql_error());		if (mysql_num_rows($result) == 0) {		$allowed = 0;		$Message = "Results viewing is currently open to voting representatives only.<br/>";				// get info on their institutional rep		$get_rep_sql="select U2.firstname, U2.lastname, U2.email, institution.name from institutionjoin users U1 on U1.institution_pk = institution.pk and U1.pk = '$USER_PK'left join institution I1 on I1.pk = U1.institution_pkleft join users U2 on U2.pk = I1.repvote_pk";		$result = mysql_query($get_rep_sql) or die('Rep info Query failed: ' . mysql_error());		$line = mysql_fetch_row($result);		if (!empty($line) && (isset($line[2])) ) {			$Message .= "Your voting representative for ".$line[3]." is " . $line[0] . " " . $line[1] . " (".$line[2].").";		} else {			$Message .= "There is no voting representative defined for institution: " . $line[3];		}		$Message .= "<br>Open viewing starts " . date($ROUND_DATE_FORMAT,strtotime($ROUND_SWITCH_DATE));		writeLog($TOOL_SHORT,$USER["username"],"(nonrep) denied access to results");	} else {		// user is an institutional rep		$allowed = 1;		$isRep = 1;		writeLog($TOOL_SHORT,$USER["username"],"rep access to results");	}		$EXTRA_LINKS .= "Rep viewing only from " . date($ROUND_DATE_FORMAT,strtotime($ROUND_OPEN_DATE)) .		" to " . date($ROUND_DATE_FORMAT,strtotime($ROUND_SWITCH_DATE));} else {	// No results viewing allowed	$allowed = 0;	$EXTRA_LINKS .= "Open poll closes on " . date($ROUND_DATE_FORMAT,strtotime($ROUND_SWITCH_DATE));	$Message = "Community poll results cannot be viewed until " . date($ROUND_DATE_FORMAT,strtotime($ROUND_SWITCH_DATE));	$Message .= "<br>Rep voting results cannot be viewed until " . date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));	if ($USER["username"]) {		writeLog($TOOL_SHORT,$USER["username"],"denied access to results");	} else {		writeLog($TOOL_SHORT,$_SERVER["REMOTE_ADDR"],"denied access to results:".$_SERVER["REMOTE_HOST"]);	}}$EXTRA_LINKS .= "</div>";// admin access checkif ($USER["admin_reqs"]) { $allowed = 1; $viewAll = 1; }// vote type filtering$voteTypeSql_default = " and official='0' ";$select = array();$voteType = "";if ($_REQUEST["votetype"] && (!$_REQUEST["clearall"]) ) { $voteType = $_REQUEST["votetype"]; }$voteTypeSql = "";// protect rep votes until after closeif ($viewAll || $isRep) {	if ($voteType == "all") {		$voteTypeSql = "";		$select[2] = " checked ";	} else if ($voteType == "rep") {		$voteTypeSql = " and official='1' ";		$select[1] = " checked ";	} else {		// community and not set		$voteTypeSql = $voteTypeSql_default;		$select[0] = " checked ";		}} else {	// hide the rep and both choices	$voteTypeSql = $voteTypeSql_default;	$select[0] = " checked ";		$select[1] = " disabled='Y' ";		$select[2] = " disabled='Y' ";	}// institution filtering$institution = "";if ($_REQUEST["institution"] && (!$_REQUEST["clearall"]) ) { $institution = $_REQUEST["institution"]; }$instSql = "";if ($institution && is_numeric($institution)) {	// use the inst pk	$instSql = " join users on users.pk = users_pk and institution_pk='$institution' ";} else {	// default to all	$institution = "all";	$instSql = "";}// first get the votes and drop them into a hash$votes_sql = "select req_data_pk, vote, count(RV.pk) as votes from requirements_vote RV " . $instSql .	"where round='$ROUND' " . $voteTypeSql . " group by req_data_pk, vote;";//print "VOTE_SQL=$votes_sql<br/>";$result = mysql_query($votes_sql) or die('Query failed: ' . mysql_error());$allvotes = array();while($row = mysql_fetch_array($result)) {	//print "Votes:" . $row[0] . ":" . $row[1] . "=" . $row[2] . "<br/>";	$allvotes[$row[0] . ":" . $row[1]] = $row[2];}mysql_free_result($result);// the SQL to fetch the requirements and related votes$from_sql = "from requirements_data left join requirements_vote on " .	"req_data_pk = requirements_data.pk and users_pk='$USER_PK' and official = '$isRep' " .	"and requirements_vote.round='$ROUND' where requirements_data.round='$ROUND' ";// Voting Filter$filter_items_default = "show all items";$filter_items = "";if ($_REQUEST["filter_items"] && (!$_REQUEST["clearall"]) ) { $filter_items = $_REQUEST["filter_items"]; }$special_filter = "";$filter_items_sql = "";if ($filter_items == "show my voted items") {	$filter_items_sql = " and vote is not null ";} else if ($filter_items == "show my unvoted items") {	$filter_items_sql = " and vote is null ";} else if ($filter_items == "show my critical items") {	$filter_items_sql = " and vote = '3' "; // critical = 3} else if ($filter_items == "show my essential items") {	$filter_items_sql = " and vote = '2' "; // essential = 2} else if ($filter_items == "show my desirable items") {	$filter_items_sql = " and vote = '1' "; // desirable = 1} else if ($filter_items == "show my not applicable items") {	$filter_items_sql = " and vote = '0' "; // NA = 0} else if ($filter_items == "show all voted items") {	$filter_items_sql = " and score > '0' ";} else if ($filter_items == "show all unvoted items") {	$filter_items_sql = " and score = '0' ";} else {	// show all items	$filter_items = $filter_items_default;	$filter_items_sql = "";}// Components Filter$filter_components_default = "show all components";$filter_components = "";if ($_REQUEST["filter_components"] && (!$_REQUEST["clearall"]) ) { $filter_components = $_REQUEST["filter_components"]; }$filter_components_sql = "";if ($filter_components && ($filter_components != $filter_components_default)) {	$filter_components_sql = " and component like '%$filter_components%' ";} else {	$filter_components = $filter_components_default;}// Audience Filter$filter_audience_default = "show all audiences";$filter_audience = "";if ($_REQUEST["filter_audience"] && (!$_REQUEST["clearall"]) ) { $filter_audience = $_REQUEST["filter_audience"]; }$filter_audience_sql = "";if ($filter_audience && ($filter_audience != $filter_audience_default)) {	$filter_audience_sql = " and audience like '%$filter_audience%' ";} else {	$filter_audience = $filter_audience_default;}$sqlfilters = $filter_items_sql . $filter_components_sql . $filter_audience_sql;// get the search$searchtext = "";if ($_REQUEST["searchtext"] && (!$_REQUEST["clearall"]) ) { $searchtext = $_REQUEST["searchtext"]; }$sqlsearch = "";if ($searchtext) {	$sqlsearch = " and (jirakey like '%$searchtext%' OR summary like '%$searchtext%' " .		"OR description like '%$searchtext%') ";}// set sorting$sorting_default = "JIRA key";$sorting = "";if ($_REQUEST["sorting"] && (!$_REQUEST["clearall"]) ) { $sorting = $_REQUEST["sorting"]; }$sqlsorting = "";if ($sorting == "Ranking") {	$sqlsorting = " order by SCORE desc ";} else if ($sorting == "Ranking (reverse)") {	$sqlsorting = " order by SCORE asc ";} else if ($sorting == "JIRA key (reverse)") {	$sqlsorting = " order by JIRANUM desc ";} else {	$sorting = $sorting_default;	$sqlsorting = " order by JIRANUM asc ";}if ($_REQUEST["clearall"]) {	$filter_items = $filter_items_default;	$filter_components = $filter_components_default;	$filter_audience = $filter_audience_default;	$sqlfilters = "";	$searchtext = "";	$sqlsearch = "";	$sorting = $sorting_default;}// counting number of items// **************** NOTE - APPLY THE FILTERS TO THE COUNT AS WELL$count_sql = "select count(*) " . $from_sql . $sqlfilters . $sqlsearch;$result = mysql_query($count_sql) or die('Count query failed: ' . mysql_error());$row = mysql_fetch_array($result);$total_items = $row[0];// pagination control$num_limit = 25;if ($_REQUEST["num_limit"]) { $num_limit = $_REQUEST["num_limit"]; }$total_pages = ceil($total_items / $num_limit);$page = 1;$PAGE = $_REQUEST["page"];if ($PAGE) { $page = $PAGE; }$PAGING = $_REQUEST["paging"];if ($PAGING) {	if ($PAGING == 'first') { $page = 1; }	else if ($PAGING == 'prev') { $page--; }	else if ($PAGING == 'next') { $page++; }	else if ($PAGING == 'last') { $page = $total_pages; }}if ($page > $total_pages) { $page = $total_pages; }if ($page <= 0) { $page = 1; }$limitvalue = $page * $num_limit - ($num_limit);$mysql_limit = " LIMIT $limitvalue, $num_limit";$start_item = $limitvalue + 1;$end_item = $limitvalue + $num_limit;if ($end_item > $total_items) { $end_item = $total_items; }// fetching all requirements data items$sql="select requirements_data.*,requirements_vote.vote " . $from_sql .		$sqlfilters . $sqlsearch . $sqlsorting . $mysql_limit;//print "Query=$sql<br>";$result = mysql_query($sql) or die('Query failed: ' . mysql_error());$items_displayed = mysql_num_rows($result);// Do the export as requested by the userif ($_REQUEST["export"] && $allowed) {	$date = date("Ymd-Hi",time());	$filename = "req_results-" . $date . ".csv";	header("Content-type: text/x-csv");	header("Content-disposition: inline; filename=$filename\n\n");	header("Pragma: no-cache");	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	header("Expires: 0"); } else { 	// display the page normally?><?php include $ACCOUNTS_PATH.'include/top_header.php'; // INCLUDE THE HTML HEAD ?><script><!--// --></script><?php include 'include/header.php'; // INCLUDE THE HEADER ?><?= $Message ?><?php	// This part will punt the user out if they are not allowed to vote right now	// this is a nice punt in that it simply stops the rest of the page from loading -AZ	if (!$allowed) {		include 'include/footer.php';		exit;	}?><form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;"><div class="filterarea">	<table border=0 cellspacing=0 cellpadding=0 width="100%">	<tr>	<td nowrap="y">	<strong style="font-size:1.1em;">Filters:</strong>&nbsp;&nbsp;	</td>	<td nowrap="y">		<select name="filter_items" title="Filter the requirements by my votes">			<option value="<?= $filter_items ?>" selected><?= $filter_items ?></option>			<option value="show all items">show all items</option>			<option value="show all voted items">show all voted items</option>			<option value="show all unvoted items">show all unvoted items</option><?php if($USER_PK) { ?>			<option value="show my voted items">show my voted items</option>			<option value="show my unvoted items">show my unvoted items</option>			<option value="show my critical items">show my critical items</option>			<option value="show my essential items">show my essential items</option>			<option value="show my desirable items">show my desirable items</option>			<option value="show my not applicable items">show my not applicable items</option><?php } ?>		</select>		<select name="filter_components" title="Filter the requirements by affected component">			<option value="<?= $filter_components ?>" selected><?= $filter_components ?></option>			<option value="show all components">show all components</option>			<option value="New Tool">New Tool</option>			<option value="Account">Account</option>			<option value="Aliases (Admin Site Management)">(Admin Site Management)</option>			<option value="Announcements">Announcements</option>			<option value="Assignments">Assignments</option>			<option value="Attachment Widget">Attachment Widget</option>			<option value="CRUD">CRUD</option>			<option value="Calendar Widget">Calendar Widget</option>			<option value="Chat Room">Chat Room</option>			<option value="Database">Database</option>			<option value="Discussion">Discussion</option>			<option value="Documentation (other than Help)">Documentation (other than Help)</option>			<option value="Drop box">Drop box</option>			<option value="E-mail Archive">E-mail Archive</option>			<option value="Gateway">Gateway</option>			<option value="Global">Global</option>			<option value="Gradebook">Gradebook</option>			<option value="Help">Help</option>			<option value="Home">Home</option>			<option value="Install">Install</option>			<option value="JSF">JSF</option>			<option value="Licensing">Licensing</option>			<option value="MOTD">MOTD</option>			<option value="Membership">Membership</option>			<option value="Memory (Admin Site Management)">Memory (Admin Site Management)</option>			<option value="My Workspace">My Workspace</option>			<option value="News (RSS)">News (RSS)</option>			<option value="OSIDs">OSIDs</option>			<option value="On-Line (Admin Site Management)">On-Line (Admin Site Management)</option>			<option value="Page Wrapper Widget">Page Wrapper Widget</option>			<option value="Permission Widget">Permission Widget</option>			<option value="Portal">Portal</option>			<option value="Preferences">Preferences</option>			<option value="Presence">Presence</option>			<option value="Presentation">Presentation</option>			<option value="Profile">Profile</option>			<option value="Providers">Providers</option>			<option value="Quartz Scheduler">Quartz Scheduler</option>			<option value="Realms (Admin Site Management)">Realms (Admin Site Management)</option>			<option value="Resources">Resources</option>			<option value="Roster">Roster</option>			<option value="Rwiki">Rwiki</option>			<option value="SUTool">SUTool</option>			<option value="Sakai APIs">Sakai APIs</option>			<option value="Sakai Application Framework">Sakai Application Framework</option>			<option value="Samigo - Authoring">Samigo - Authoring</option>			<option value="Samigo - Delivery">Samigo - Delivery</option>			<option value="Samigo - Global">Samigo - Global</option>			<option value="Samigo - Grading">Samigo - Grading</option>			<option value="Samigo - Question Pools">Samigo - Question Pools</option>			<option value="Samigo - Templates">Samigo - Templates</option>			<option value="Schedule">Schedule</option>			<option value="Section Info">Section Info</option>			<option value="Site Archive (Admin Site Management)">Site Archive (Admin Site Management)</option>			<option value="Site Info">Site Info</option>			<option value="Sites (Admin Site Management)">Sites (Admin Site Management)</option>			<option value="Sites (Gateway)">Sites (Gateway)</option>			<option value="Skins (CSS)">Skins (CSS)</option>			<option value="Style Guide">Style Guide</option>			<option value="Syllabus">Syllabus</option>			<option value="Tab Management">Tab Management</option>			<option value="Tests & Quizzes (Samigo)">Tests & Quizzes (Samigo)</option>			<option value="Twin Peaks">Twin Peaks</option>			<option value="Users (Admin User Management)">Users (Admin User Management)</option>			<option value="WYSIWYG Widget">WYSIWYG Widget</option>			<option value="Web Content">Web Content</option>			<option value="Web Services">Web Services</option>			<option value="WebDAV">WebDAV</option>			<option value="Worksite Information">Worksite Information</option>			<option value="Worksite Setup">Worksite Setup</option>		</select>		<select name="filter_audience" title="Filter the requirements by intended audience">			<option value="<?= $filter_audience ?>" selected><?= $filter_audience ?></option>            <option value="show all audiences">show all audiences</option>			<option value="Students"> Students</option>			<option value="Instructors">Instructors </option>			<option value="Researchers">Researchers</option>			<option value="Staff(administrative)">Staff(administrative)</option>			<option value="Sakai administrators">Sakai Administrators </option>			<option value="Sakai developers">Sakai Developers</option>		</select>		&nbsp;	    <input class="filter" type="submit" name="filter" value="Filter" title="Apply the current filter settings to the page">	</td>	<td nowrap="y" align="right">        <input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>"        	length="20" title="Enter search text here">        <script>document.adminform.searchtext.focus();</script>        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements">	</td>	</tr>	<tr>	<td nowrap="y"><b style="font-size:1.1em;">Paging:</b></td>	<td nowrap="y">		<input type="hidden" name="page" value="<?= $page ?>">		<input class="filter" type="submit" name="paging" value="first" title="Go to the first page">		<input class="filter" type="submit" name="paging" value="prev" title="Go to the previous page">		<span class="keytext">Page <?= $page ?> of <?= $total_pages ?></span>		<input class="filter" type="submit" name="paging" value="next" title="Go to the next page">		<input class="filter" type="submit" name="paging" value="last" title="Go to the last page">		<span class="keytext">&nbsp;-&nbsp;		Displaying <?= $start_item ?> - <?= $end_item ?> of <?= $total_items ?> items (<?= $items_displayed ?> shown)		&nbsp;-&nbsp;		Max of</span>		<select name="num_limit" title="Choose the max items to view per page">			<option value="<?= $num_limit ?>"><?= $num_limit ?></option>			<option value="10">10</option>			<option value="25">25</option>			<option value="50">50</option>			<option value="100">100</option>			<option value="200">200</option>			<option value="500">500</option>		</select>		<span class="keytext">items per page</span>	</td>	<td align="right">		<input class="filter" type="submit" name="export" value="Export" title="Export results based on current filters">		<input class="filter" type="submit" name="clearall" value="Clear All Filters" title="Reset all filters">	</td>	</tr>		</table>	<table width="100%" border="0" cellpadding="0">	<tr>		<td nowrap="y">		<b style="font-size:1.0em;">Institution:</b>		<select name="institution">			<option value='all' <?php if ($institution == "all") { echo "selected='Y'"; } ?>>All institutions</option>			<?php $institutionDropdownText = generate_partner_dropdown( $institution, 1 ); ?>			<?= $institutionDropdownText ?>		</select>	</td>	<td nowrap="y">		<b style="font-size:1.0em;">Vote type:</b>		<input class="filter" id="ctype" type="radio" name="votetype" <?= $select[0] ?> value="community"><label for="ctype">Community</label>&nbsp; 		<input class="filter" id="rtype" type="radio" name="votetype" <?= $select[1] ?> value="rep"><label for="rtype">Representative</label>&nbsp;		<input class="filter" id="atype" type="radio" name="votetype" <?= $select[2] ?> value="all"><label for="atype">Both</label> 	</td>		<td align="right" nowrap="y">		<b style="font-size:1.0em;">Sort:</b>		<select name="sorting" title="Choose the order to display items in">			<option value="<?= $sorting ?>"><?= $sorting ?></option>			<option value="Ranking">Ranking</option>			<option value="Ranking (reverse)">Ranking (reverse)</option>			<option value="JIRA key">JIRA key</option>			<option value="JIRA key (reverse)">JIRA key (reverse)</option>		</select>		<input class="filter" type="submit" name="sort" value="Sort" title="Sort reqs by the sort order">	</td>	</tr>	</table></div></form><table width=100% border=0 cellspacing=0><tr class='tableheader'><td width='10%'>&nbsp;VOTE</td><td width='10%'>&nbsp;Results</td><td width='5%' align="center">Req-#</td><td width='35%'>Summary</td><td width='40%'>Description</td></tr><?php } // end export else // Iterate through the items from the SQL$line = 0;while($itemrow=mysql_fetch_assoc($result)) {	$line++;	$pk=$itemrow["pk"];	$key=$itemrow["jirakey"];	$summary=$itemrow["summary"];	$description=$itemrow["description"];	$component=$itemrow["component"];	$audience=$itemrow["audience"];	$score=$itemrow["score"];	$vote=$itemrow["vote"];	// description cleanup for display	$description = trim($description);	if (strlen($description) > 500) {		$description = substr($description,0,500) . "...<br>(" .			"<a href='$JIRA_REQ$key' title='link to Jira requirement $key' target='_JIRA'>" .			"<i>See JIRA for complete description</i>)";	}		// component cleanup for display (turn pipe seperators into breaks)	$component = str_replace("|",",<br/>",trim($component));	// audience cleanup for display (turn pipe seperators into breaks)	$audience = str_replace("|",",<br/>",trim($audience));	// voting check	if (!isset($vote)) { $vote = -1; }	// get votes counts	$total = 0;	for ($i=0; $i<count($VOTE_TEXT); $i++) {		$total += $allvotes["$pk:$i"];	}	$itemrow["Total Votes"] = $total;		$votes = array();	$percents = array();	$numerator = 0;	for ($i=0; $i<count($VOTE_TEXT); $i++) {		$votes[$i] = $allvotes["$pk:$i"]+0;		$itemrow[$VOTE_TEXT[$i]] = $votes[$i];		$percents[$i] = round(($votes[$i]/$total)*100,1);		$itemrow[$VOTE_TEXT[$i]."%"] = $percents[$i];		$numerator += ($i+1) * $votes[$i];	}	$checked = array();	$itemrow["Average"] = round($numerator/$total) - 1;	$itemrow["AvgText"] = $VOTE_TEXT[ $itemrow["Average"] ];	$checked[$itemrow["Average"]] = " class='avgvote' ";	// array_search(max($votes),$votes)	if ($_REQUEST["export"]) {		// print out EXPORT format instead of display		if ($line == 1) {			$output = "\"REQ vote export\",\"KEY:\",";			for ($i=0; $i<count($VOTE_TEXT); $i++) {				$output .= "\"" . $VOTE_TEXT[$i] . "=" . $i . "\",";			}			print $output . "\n";			print join(',', array_keys($itemrow)) . "\n"; // add header line		}				foreach ($itemrow as $name=>$value) {			$value = str_replace("\"", "\"\"", $value); // fix for double quotes			$itemrow[$name] = '"' . $value . '"'; // put quotes around each item		}		print join(',', $itemrow) . "\n";	} else {		// extra stuff for DISPLAY		$tdstyle = "";		if ($vote >= 0) {			// item has been voted on and saved			if ($checked[$vote]) {				$checked[$vote] = " class='matchvote' ";			} else {				$checked[$vote] = " class='myvote' ";			}			$tdstyle = " class='saved' ";		}			$linestyle = "oddrow";		if ($line % 2 == 0) {			$linestyle = "evenrow";		} else {			$linestyle = "oddrow";		}?>	<tr id="<?= $linestyle ?>" valign="top">		<td id="vb<?= $pk ?>" <?= $tdstyle ?> nowrap='y' style='text-align:right;border-right:1px dotted #ccc;border-bottom:1px solid black;' rowspan="2"><?php	for ($vi = count($VOTE_TEXT)-1; $vi >= 0; $vi--) { ?>			<div <?= $checked[$vi] ?> >&nbsp;<label title="<?= $VOTE_HELP[$vi] ?>"><?= $VOTE_TEXT[$vi] ?></label>&nbsp;</div><?php	} ?>			<input id="vh<?= $pk ?>" type="hidden" name="cur<?= $pk ?>" value="<?= $vote ?>">			<div style="margin:6px;"></div>			&nbsp;<label title="Total number of votes for this item">Total:</label>&nbsp;<br />			<div style="margin:12px;"></div>		</td>		<td nowrap="y" style='border-right:1px dotted #ccc;border-bottom:1px solid black;' rowspan="2">			<div style="margin-left:6px;"><?php	for ($vi = count($VOTE_TEXT)-1; $vi >= 0; $vi--) { ?>				<?= $votes[$vi] ?> (<?= $percents[$vi] ?>%)<br/><?php	} ?>				<div style='margin:6px;'></div>				<b><?= $total ?></b><br/>			</div>		</td>		<td nowrap='y'>			&nbsp;			<a href='<?= $JIRA_REQ ?><?= $key ?>' title='link to Jira requirement <?= $key ?>' target='_JIRA'><?= $key ?></a>			&nbsp;		</td>		<td height="30px";>			<div class="summary"><?= $summary ?></div>		</td>		<td rowspan="2" style="padding:2px;border-bottom:1px solid black;">			<div class="description"><?= $description ?></div>		</td>	</tr>	<tr id="<?= $linestyle ?>" valign="top">		<td colspan="2" style="border-bottom:1px solid black;">			<table>			<tr>				<td align=right valign="top"><b>Component:</b></td>				<td align="left" valign="top"><?= $component ?></td>			</tr>			<tr>				<td align=right valign="top"><b>Audience:</b></td>				<td align="left" valign="top"><?= $audience ?></td>			</tr>			</table>		</td>	</tr><?php		} //end display	} //end of while		if ($_REQUEST["export"]) {		print "\n\"Exported on:\",\"" . date($ROUND_DATE_FORMAT,time()) . "\"\n";		print "\"Open poll ends:\",\"" . date($ROUND_DATE_FORMAT,strtotime($ROUND_SWITCH_DATE)) . "\"\n";		print "\"Rep vote ends:\",\"" . date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE)) . "\"\n";	} else {?></table><div class="definitions"><div class="defheader">Color Key</div>		<b style="font-size:1.1em;">Key:</b> 	<?php if($USER_PK) { ?>		<div class="myvote" style='display:inline;'>&nbsp;Your vote&nbsp;</div>		<div class="matchvote" style='display:inline;'><label title="Your vote matches the average">&nbsp;Your vote matches the average&nbsp;</label></div>	<?php } ?>		<div class="avgvote" style='display:inline;'>&nbsp;Average vote&nbsp;</div></div><?php include 'include/footer.php'; // Include the FOOTER ?><?php	} ?>