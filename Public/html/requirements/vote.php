<?php/* * Created on Febrary 18, 2006 by @author aaronz * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/) */?><?phprequire_once 'include/tool_vars.php';$PAGE_NAME = "Voting Form";$Message = "";// connect to databaserequire 'sql/mysqlconnect.php';// check authenticationrequire $ACCOUNTS_PATH.'include/check_authentic.php';// login if not autheticatedrequire $ACCOUNTS_PATH.'include/auth_login_redirect.php';// add in the help link$EXTRA_LINKS = " - <a style='font-size:.8em;' href='$HELP_LINK' target='_HELP'>Help</a><br/>";// add in the display to let people know how long they have to vote$EXTRA_LINKS .= "<div class='date_message'>";$allowed = 0; // assume user is NOT allowed unless otherwise shown$isRep = 0; // assume user is not an institutional repif (strtotime($ROUND_CLOSE_DATE) < time()) {	// No one can access after the close date	$allowed = 0;	$Message = "Voting closed on " . date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));	$EXTRA_LINKS .= "Voting closed " . date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));} else if (strtotime($ROUND_OPEN_DATE) > time()) {	// No access until voting opens	$allowed = 0;	$Message = "Voting is not allowed until " . date($ROUND_DATE_FORMAT,strtotime($ROUND_OPEN_DATE));	$EXTRA_LINKS .= "Voting opens " . date($ROUND_DATE_FORMAT,strtotime($ROUND_OPEN_DATE));} else if (strtotime($ROUND_SWITCH_DATE) < time()) {	// User must be a rep or no access	$check_rep_sql="select pk from institution where repvote_pk = '$User->pk'";	$result = mysql_query($check_rep_sql) or die('Query failed: ' . mysql_error());		if (mysql_num_rows($result) == 0) {		$allowed = 0;		$Message = "Voting is currently open to voting representatives only.<br/>";				// get info on their voting rep		$get_rep_sql="select U2.firstname, U2.lastname, U2.email, institution.name from institutionjoin users U1 on U1.institution_pk = institution.pk and U1.pk = '$User->pk'left join institution I1 on I1.pk = U1.institution_pkleft join users U2 on U2.pk = I1.repvote_pk";		$result = mysql_query($get_rep_sql) or die('Rep info Query failed: ' . mysql_error());		$line = mysql_fetch_row($result);		if (!empty($line) && (isset($line[2])) ) {			$Message .= "Your voting representative for ".$line[3]." is " . $line[0] . " " . $line[1] . " (".$line[2].").";		} else {			$Message .= "There is no voting representative defined for institution: " . $line[3];		}	} else {		// user is an institutional rep		$allowed = 1;		$isRep = 1;		writeLog($TOOL_SHORT,$User->username,"rep access to voting");	}		$EXTRA_LINKS .= "Rep voting from " . date($ROUND_DATE_FORMAT,strtotime($ROUND_SWITCH_DATE)) .		" to " . date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));} else {	// open voting is allowed	$allowed = 1;	$EXTRA_LINKS .= "Open voting from " . date($ROUND_DATE_FORMAT,strtotime($ROUND_OPEN_DATE)) .		" to " . date($ROUND_DATE_FORMAT,strtotime($ROUND_SWITCH_DATE));	writeLog($TOOL_SHORT,$User->username,"access to poll");}$EXTRA_LINKS .= "</div>";// set the official vote check sql$rep_sql = " and requirements_vote.official = '$isRep' ";// admin access checkif ($User->checkPerm("admin_reqs")) { $allowed = 1; }	?><?php include $ACCOUNTS_PATH.'include/top_header.php'; // INCLUDE THE HTML HEAD ?><script><!--function setAnchor(num) {	document.voteform.action += "#anchor"+num;	document.voteform.submit();	return false;}function getSelectedRadio(buttonGroup) {   // returns the array number of the selected radio button or -1 if no button is selected   if (buttonGroup[0]) { // if the button group is an array (one button is not an array)      for (var i=0; i<buttonGroup.length; i++) {         if (buttonGroup[i].checked) {            return i         }      }   } else {      if (buttonGroup.checked) { return 0; } // if the one button is checked, return zero   }   // if we get to this point, no radio button is selected   return -1;}function checkSaved(num) {	// Get current vote for this item	var voteItem = document.getElementById('vh'+num);	var curVote = voteItem.value;	// Get current selection	var rbuttons = document.getElementsByName('vr'+num);	var curSelect = getSelectedRadio(rbuttons);	curSelect = 3 - curSelect; // make it line up with the radio buttons	// Compare values	if (curVote >= 0) {		if (curVote == curSelect) {			setSaved(num);		} else {			setUnsaved(num);		}	} else {		// no vote saved for this item		setUnsaved(num);	}}function setUnsaved(num) {	var item = document.getElementById('vb'+num);	item.className='unsaved';	var sbutton = document.getElementById('vs'+num);	sbutton.disabled=false;	var cbutton = document.getElementById('vc'+num);	cbutton.disabled=false;}function setSaved(num) {	var item = document.getElementById('vb'+num);	item.className='saved';	var sbutton = document.getElementById('vs'+num);	sbutton.disabled=true;	var cbutton = document.getElementById('vc'+num);	cbutton.disabled=true;}function setCleared(num) {	// get current vote	var voteItem = document.getElementById('vh'+num);	var curVote = voteItem.value;	// reset radio buttons	var rbuttons = document.getElementsByName('vr'+num);	for (i=0;i<rbuttons.length;i++) {		rbuttons[i].checked=false;		if (i == (3 - curVote)) {			rbuttons[i].checked=true;		}	}	// reset style if not returning to saved vote	if (curVote < 0) {		var item = document.getElementById('vb'+num);		item.className='clear';		var sbutton = document.getElementById('vs'+num);		sbutton.disabled=true;		var cbutton = document.getElementById('vc'+num);		cbutton.disabled=true;	} else {		// reset to saved value		setSaved(num);	}}// --></script><?php include 'include/header.php'; // INCLUDE THE HEADER ?><?= $Message ?><?php	// This part will punt the user out if they are not allowed to vote right now	// this is a nice punt in that it simply stops the rest of the page from loading -AZ	if (!$allowed) {		include 'include/footer.php';		exit;	}?><?php//processing the posted values for saving$Keys = array();$Keys = array_keys($_POST);foreach( $Keys as $key){	$check = strpos($key,'vr');	if ( $check !== false && $check == 0 ) {		$itemPk = substr($key, 2);		$newVote = $_POST[$key];		//print "key=$key : item_pk=$item_pk : value=$value <br/>";		// Check to see if this vote already exists		$check_exists_sql="select pk, vote from requirements_vote where " .			"users_pk='$User->pk' and req_data_pk='$itemPk'" . $rep_sql;		$result = mysql_query($check_exists_sql) or die('Query failed: ' . mysql_error());		$writeScore = 0;		if ($result && (mysql_num_rows($result) > 0) ) {			$row = mysql_fetch_assoc($result);			$existingVote = $row["vote"];			$votePk = $row["pk"];			// vote exists, now see if it changed			if ($newVote == $existingVote) {				// vote not changed so continue				//print "vote not changed: $existingPk : $existingVote <br/>";				continue;			} else {				// vote changed so write update				$update_vote_sql="update requirements_vote set vote='$newVote' where pk='$votePk'" . $rep_sql;				$result = mysql_query($update_vote_sql) or die('Query failed: ' . mysql_error());				// calculate the new score				$score_calc_sql="select vote as VOTE, COUNT(pk) as COUNT from requirements_vote " .					"where round='$ROUND' and req_data_pk = '$itemPk' group by vote";				$result = mysql_query($score_calc_sql) or die('Query failed: ' . mysql_error());				while($row = mysql_fetch_row($result)) {					$writeScore += $row[1] * $SCORE_MOD[ $row[0] ];				}				mysql_free_result($result);			}		} else {			// vote does not exist, insert it			//print "New vote: $User->pk : $item_pk : $value <br/>";			$writeScore = $newVote * $SCORE_MOD[$newVote];			$insert_vote_sql="insert into requirements_vote (users_pk,req_data_pk,vote,official) values " .				"('$User->pk','$itemPk','$newVote','$isRep')";			$result = mysql_query($insert_vote_sql) or die('Query failed: ' . mysql_error());		}				if ($writeScore > 0) {			$update_score_sql="update requirements_data set score = '$writeScore' where pk = '$itemPk'";			$result = mysql_query($update_score_sql) or die('Query failed: ' . mysql_error());		}	}}// the SQL to fetch the requirements and related votes for this user$from_sql = "from requirements_data left join requirements_vote on " .	"req_data_pk = requirements_data.pk and users_pk='$User->pk' " . $rep_sql .	"and requirements_vote.round='$ROUND' where requirements_data.round='$ROUND' ";// Voting Filter$filter_items_default = "show all items";$filter_items = "";if ($_REQUEST["filter_items"] && (!$_REQUEST["clearall"]) ) { $filter_items = $_REQUEST["filter_items"]; }$filter_items_sql = "";if ($filter_items == "show my voted items") {	$filter_items_sql = " and vote is not null ";} else if ($filter_items == "show my unvoted items") {	$filter_items_sql = " and vote is null ";} else if ($filter_items == "show my critical items") {	$filter_items_sql = " and vote = '3' "; // critical = 3} else if ($filter_items == "show my essential items") {	$filter_items_sql = " and vote = '2' "; // essential = 2} else if ($filter_items == "show my desirable items") {	$filter_items_sql = " and vote = '1' "; // desirable = 1} else if ($filter_items == "show my not applicable items") {	$filter_items_sql = " and vote = '0' "; // NA = 0} else {	// show all items	$filter_items = $filter_items_default;	$filter_items_sql = "";}// Components Filter$filter_components_default = "show all components";$filter_components = "";if ($_REQUEST["filter_components"] && (!$_REQUEST["clearall"]) ) { $filter_components = $_REQUEST["filter_components"]; }$filter_components_sql = "";if ($filter_components && ($filter_components != $filter_components_default)) {	$filter_components_sql = " and component like '%$filter_components%' ";} else {	$filter_components = $filter_components_default;}// Audience Filter$filter_audience_default = "show all audiences";$filter_audience = "";if ($_REQUEST["filter_audience"] && (!$_REQUEST["clearall"]) ) { $filter_audience = $_REQUEST["filter_audience"]; }$filter_audience_sql = "";if ($filter_audience && ($filter_audience != $filter_audience_default)) {	$filter_audience_sql = " and audience like '%$filter_audience%' ";} else {	$filter_audience = $filter_audience_default;}$sqlfilters = $filter_items_sql . $filter_components_sql . $filter_audience_sql;// get the search$searchtext = "";if ($_REQUEST["searchtext"] && (!$_REQUEST["clearall"]) ) { $searchtext = $_REQUEST["searchtext"]; }$sqlsearch = "";if ($searchtext) {	$sqlsearch = " and (jirakey like '%$searchtext%' OR summary like '%$searchtext%' " .		"OR description like '%$searchtext%') ";}// set sorting$default_sort = " order by JIRANUM ";$sorting = "";if ($_REQUEST["sorting"] && (!$_REQUEST["clearall"]) ) { $sorting = $_REQUEST["sorting"]; }$sqlsorting = $default_sort;if ($sorting) {	$sqlsorting = " order by $sorting ";}if ($_REQUEST["clearall"]) {	$filter_items = $filter_items_default;	$filter_components = $filter_components_default;	$filter_audience = $filter_audience_default;	$sqlfilters = "";	$searchtext = "";	$sqlsearch = "";	$sorting = "";	$sqlsorting = $default_sort;}// counting number of items// **************** NOTE - APPLY THE FILTERS TO THE COUNT AS WELL$count_sql = "select count(*) " . $from_sql . $sqlfilters . $sqlsearch;$result = mysql_query($count_sql) or die('Count query failed: ' . mysql_error());$row = mysql_fetch_array($result);$total_items = $row[0];// pagination control$num_limit = 25;$NUM_LIMIT = $_REQUEST["num_limit"];if ($NUM_LIMIT) { $num_limit = $NUM_LIMIT; }$total_pages = ceil($total_items / $num_limit);$page = 1;$PAGE = $_REQUEST["page"];if ($PAGE) { $page = $PAGE; }$PAGING = $_REQUEST["paging"];if ($PAGING) {	if ($PAGING == 'first') { $page = 1; }	else if ($PAGING == 'prev') { $page--; }	else if ($PAGING == 'next') { $page++; }	else if ($PAGING == 'last') { $page = $total_pages; }}if ($page > $total_pages) { $page = $total_pages; }if ($page <= 0) { $page = 1; }$limitvalue = $page * $num_limit - ($num_limit);$mysql_limit = " LIMIT $limitvalue, $num_limit";$start_item = $limitvalue + 1;$end_item = $limitvalue + $num_limit;if ($end_item > $total_items) { $end_item = $total_items; }// fetching all requirements data items$sql="select requirements_data.*,requirements_vote.vote " . $from_sql .		$sqlfilters . $sqlsearch . $sqlsorting  . $mysql_limit;//print "Query=$sql<br>";$result = mysql_query($sql) or die('Query failed: ' . mysql_error());$items_displayed = mysql_num_rows($result);?><form name="voteform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;"><div style="background:#ECECEC;border:1px solid #ccc;padding:3px;margin-bottom:10px;">	<table border=0 cellspacing=0 cellpadding=0 width="100%">	<tr>	<td nowrap="y">	<strong>Filters:</strong>&nbsp;&nbsp;	</td>	<td nowrap="y">		<select name="filter_items" title="Filter the requirements by my votes">			<option value="<?= $filter_items ?>" selected><?= $filter_items ?></option>			<option value="show all items">show all items</option>			<option value="show my voted items">show my voted items</option>			<option value="show my unvoted items">show my unvoted items</option>			<option value="show my critical items">show my critical items</option>			<option value="show my essential items">show my essential items</option>			<option value="show my desirable items">show my desirable items</option>			<option value="show my not applicable items">show my not applicable items</option>		</select>		<select name="filter_components" title="Filter the requirements by affected component">			<option value="<?= $filter_components ?>" selected><?= $filter_components ?></option>			<option value="show all components">show all components</option>			<option value="New Tool">New Tool</option>			<option value="Account">Account</option>			<option value="Aliases (Admin Site Management)">(Admin Site Management)</option>			<option value="Announcements">Announcements</option>			<option value="Assignments">Assignments</option>			<option value="Attachment Widget">Attachment Widget</option>			<option value="CRUD">CRUD</option>			<option value="Calendar Widget">Calendar Widget</option>			<option value="Chat Room">Chat Room</option>			<option value="Database">Database</option>			<option value="Discussion">Discussion</option>			<option value="Documentation (other than Help)">Documentation (other than Help)</option>			<option value="Drop box">Drop box</option>			<option value="E-mail Archive">E-mail Archive</option>			<option value="Gateway">Gateway</option>			<option value="Global">Global</option>			<option value="Gradebook">Gradebook</option>			<option value="Help">Help</option>			<option value="Home">Home</option>			<option value="Install">Install</option>			<option value="JSF">JSF</option>			<option value="Licensing">Licensing</option>			<option value="MOTD">MOTD</option>			<option value="Membership">Membership</option>			<option value="Memory (Admin Site Management)">Memory (Admin Site Management)</option>			<option value="My Workspace">My Workspace</option>			<option value="News (RSS)">News (RSS)</option>			<option value="OSIDs">OSIDs</option>			<option value="On-Line (Admin Site Management)">On-Line (Admin Site Management)</option>			<option value="Page Wrapper Widget">Page Wrapper Widget</option>			<option value="Permission Widget">Permission Widget</option>			<option value="Portal">Portal</option>			<option value="Preferences">Preferences</option>			<option value="Presence">Presence</option>			<option value="Presentation">Presentation</option>			<option value="Profile">Profile</option>			<option value="Providers">Providers</option>			<option value="Quartz Scheduler">Quartz Scheduler</option>			<option value="Realms (Admin Site Management)">Realms (Admin Site Management)</option>			<option value="Resources">Resources</option>			<option value="Roster">Roster</option>			<option value="Rwiki">Rwiki</option>			<option value="SUTool">SUTool</option>			<option value="Sakai APIs">Sakai APIs</option>			<option value="Sakai Application Framework">Sakai Application Framework</option>			<option value="Samigo - Authoring">Samigo - Authoring</option>			<option value="Samigo - Delivery">Samigo - Delivery</option>			<option value="Samigo - Global">Samigo - Global</option>			<option value="Samigo - Grading">Samigo - Grading</option>			<option value="Samigo - Question Pools">Samigo - Question Pools</option>			<option value="Samigo - Templates">Samigo - Templates</option>			<option value="Schedule">Schedule</option>			<option value="Section Info">Section Info</option>			<option value="Site Archive (Admin Site Management)">Site Archive (Admin Site Management)</option>			<option value="Site Info">Site Info</option>			<option value="Sites (Admin Site Management)">Sites (Admin Site Management)</option>			<option value="Sites (Gateway)">Sites (Gateway)</option>			<option value="Skins (CSS)">Skins (CSS)</option>			<option value="Style Guide">Style Guide</option>			<option value="Syllabus">Syllabus</option>			<option value="Tab Management">Tab Management</option>			<option value="Tests & Quizzes (Samigo)">Tests & Quizzes (Samigo)</option>			<option value="Twin Peaks">Twin Peaks</option>			<option value="Users (Admin User Management)">Users (Admin User Management)</option>			<option value="WYSIWYG Widget">WYSIWYG Widget</option>			<option value="Web Content">Web Content</option>			<option value="Web Services">Web Services</option>			<option value="WebDAV">WebDAV</option>			<option value="Worksite Information">Worksite Information</option>			<option value="Worksite Setup">Worksite Setup</option>		</select>		<select name="filter_audience" title="Filter the requirements by intended audience">			<option value="<?= $filter_audience ?>" selected><?= $filter_audience ?></option>            <option value="show all audiences">show all audiences</option>			<option value="Students"> Students</option>			<option value="Instructors">Instructors </option>			<option value="Researchers">Researchers</option>			<option value="Staff(administrative)">Staff(administrative)</option>			<option value="Sakai administrators">Sakai Administrators </option>			<option value="Sakai developers">Sakai Developers</option>		</select>		&nbsp;	    <input class="filter" type="submit" name="filter" value="Filter" title="Apply the current filter settings to the page">	</td>	<td nowrap="y" align="right">        <input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>"        	length="20" title="Enter search text here">        <script>document.voteform.searchtext.focus();</script>        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements">	</td>	</tr>	<tr>	<td nowrap="y"><b>Paging:</b></td>	<td nowrap="y">		<input type="hidden" name="page" value="<?= $page ?>" />		<input class="filter" type="submit" name="paging" value="first" title="Go to the first page" />		<input class="filter" type="submit" name="paging" value="prev" title="Go to the previous page" />		<span class="keytext">Page <?= $page ?> of <?= $total_pages ?></span>		<input class="filter" type="submit" name="paging" value="next" title="Go to the next page" />		<input class="filter" type="submit" name="paging" value="last" title="Go to the last page" />		<span class="keytext">&nbsp;-&nbsp;		Displaying <?= $start_item ?> - <?= $end_item ?> of <?= $total_items ?> items (<?= $items_displayed ?> shown)		&nbsp;-&nbsp;		Max of</span>		<select name="num_limit" title="Choose the max items to view per page">			<option value="<?= $num_limit ?>"><?= $num_limit ?></option>			<option value="10">10</option>			<option value="25">25</option>			<option value="50">50</option>			<option value="75">75</option>			<option value="100">100</option>		</select>		<span class="keytext">items per page</span>	</td>	<td align="right">		<input class="filter" type="submit" name="clearall" value="Clear All Filters" title="Reset all filters">	</td>	</tr>	</table></div><table width=100% border=0 cellspacing=0><tr class='tableheader'><td width='10%'>&nbsp;VOTE</td><td width='5%' align="center">Req#</td><td width='35%'>Summary</td><td width='50%'>Description</td></tr><?php$line = 0;while($links=mysql_fetch_array($result)) {	$line++;	$pk=$links["pk"];	$key=$links["jirakey"];	$summary=$links["summary"];	$description=$links["description"];	$component=$links["component"];	$audience=$links["audience"];	$vote=$links["vote"];	// description cleanup	$description = trim($description);	// component cleanup (turn pipe seperators into breaks)	$component = str_replace("|",",<br/>",trim($component));	// audience cleanup (turn pipe seperators into breaks)	$audience = str_replace("|",",<br/>",trim($audience));	// voting check	if (!isset($vote)) { $vote = -1; }	$checked = array("","","","","");	$tdstyle = "";	if ($vote < 0) {		// item has not been voted on and saved	} else {		// item has been voted on and saved		$checked[$vote] = " checked ";		$tdstyle = " class='saved' ";	}	$linestyle = "oddrow";	if ($line % 2 == 0) {		$linestyle = "evenrow";	} else {		$linestyle = "oddrow";	}?>	<tr class="<?= $linestyle ?>" valign="top">		<td id="vb<?= $pk ?>" <?= $tdstyle ?> nowrap='y' style='border-right:1px dotted #ccc;border-bottom:1px solid black;' rowspan="2">			<a name="anchor<?= $pk ?>"></a><?php	for ($vi = count($VOTE_TEXT)-1; $vi >= 0; $vi--) { ?>			<input id="vr<?= $pk ?>_<?= $vi ?>" name="vr<?= $pk ?>" type="radio" value="<?= $vi ?>" <?= $checked[$vi] ?> onClick="checkSaved('<?= $pk ?>')" title="<?= $VOTE_HELP[$vi] ?>"><label for="vr<?= $pk ?>_<?= $vi ?>" title="<?= $VOTE_HELP[$vi] ?>"><?= $VOTE_TEXT[$vi] ?></label><br /><?php	} ?>			<div style="margin:8px;"></div>			<input id="vh<?= $pk ?>" type="hidden" name="cur<?= $pk ?>" value="<?= $vote ?>">			<input id="vc<?= $pk ?>" type="button" value="Reset" onClick="setCleared('<?= $pk ?>')"				disabled='y' title="Clear the radio buttons for this item or reset to the saved vote">			<input id="vs<?= $pk ?>" type="submit" name="submit" value="Save" onClick="setAnchor('<?= $pk ?>');this.disabled=true;return false;"				disabled='y' title="Save all votes, votes cannot be removed once they are saved">		</td>		<td nowrap='y'>			&nbsp;			<a href='<?= $JIRA_REQ ?><?= $key ?>' title='link to Jira requirement <?= $key ?>' target='_JIRA'><?= $key ?></a>			&nbsp;		</td>		<td height="30px";>			<div class="summary"><?= $summary ?></div>		</td>		<td rowspan="2" style="padding:2px;border-bottom:1px solid black;">			<div class="description"><?= $description ?></div>		</td>	</tr>	<tr class="<?= $linestyle ?>" valign="top">		<td colspan="2" style="border-bottom:1px solid black;">			<table>			<tr>				<td align=right valign="top"><b>Component:</b></td>				<td align="left" valign="top"><?= $component ?></td>			</tr>			<tr>				<td align=right valign="top"><b>Audience:</b></td>				<td align="left" valign="top"><?= $audience ?></td>			</tr>			</table>		</td>	</tr><?php } //end of while ?></table></form><?php include 'include/defineterms.html'; // Include the defined terms -AZ ?><?php include 'include/footer.php'; // Include the FOOTER ?></body></html>