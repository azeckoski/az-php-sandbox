<?php/* * Created on Febrary 18, 2006 by @author aaronz * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/) */?><?php	require_once ("tool_vars.php");	// Form to allow user to vote	$PAGE_NAME = "Voting Form";	// connect to database	require "mysqlconnect.php";	// get the passkey from the cookie if it exists	$PASSKEY = $_COOKIE["SESSION_ID"];	// check the passkey	$USER_PK = 0;	if (isset($PASSKEY)) {		$sql1 = "SELECT users_pk FROM sessions WHERE passkey = '$PASSKEY'";		$result = mysql_query($sql1) or die('Query failed: ' . mysql_error());		$row = mysql_fetch_assoc($result);		if( !$result ) {			// no valid key exists, user not authenticated			$USER_PK = -1;		} else {			// authenticated user			$USER_PK = $row["users_pk"];		}		mysql_free_result($result);	}	if( $USER_PK <= 0 ) {		// no user_pk, user not authenticated		// redirect to the login page		header('location:'.$ACCOUNTS_PATH.'login.php?ref='.$_SERVER['PHP_SELF']);		exit;	}	// if we get here, user should be authenticated	// get the authenticated user information	$authsql = "SELECT * FROM users WHERE pk = '$USER_PK'";	$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());	$USER = mysql_fetch_assoc($result);?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title><link href="./requirements_vote.css" rel="stylesheet" type="text/css"><script><!--function focus(){document.voteform.searchtext.focus();}function getSelectedRadio(buttonGroup) {   // returns the array number of the selected radio button or -1 if no button is selected   if (buttonGroup[0]) { // if the button group is an array (one button is not an array)      for (var i=0; i<buttonGroup.length; i++) {         if (buttonGroup[i].checked) {            return i         }      }   } else {      if (buttonGroup.checked) { return 0; } // if the one button is checked, return zero   }   // if we get to this point, no radio button is selected   return -1;}function checkSaved(num) {	// Get current vote for this item	var voteItem = document.getElementById('vh'+num);	var curVote = voteItem.value;	// Get current selection	var rbuttons = document.getElementsByName('vr'+num);	var curSelect = getSelectedRadio(rbuttons);	curSelect = 3 - curSelect; // make it line up with the radio buttons	// Compare values	if (curVote >= 0) {		if (curVote == curSelect) {			setSaved(num);		} else {			setUnsaved(num);		}	} else {		// no vote saved for this item		setUnsaved(num);	}}function setUnsaved(num) {	var item = document.getElementById('vb'+num);	item.className='unsaved';	var sbutton = document.getElementById('vs'+num);	sbutton.disabled=false;	var cbutton = document.getElementById('vc'+num);	cbutton.disabled=false;}function setSaved(num) {	var item = document.getElementById('vb'+num);	item.className='saved';	var sbutton = document.getElementById('vs'+num);	sbutton.disabled=true;	var cbutton = document.getElementById('vc'+num);	cbutton.disabled=true;}function setCleared(num) {	// get current vote	var voteItem = document.getElementById('vh'+num);	var curVote = voteItem.value;	// reset radio buttons	var rbuttons = document.getElementsByName('vr'+num);	for (i=0;i<rbuttons.length;i++) {		rbuttons[i].checked=false;		if (i == (3 - curVote)) {			rbuttons[i].checked=true;		}	}	// reset style if not returning to saved vote	if (curVote < 0) {		var item = document.getElementById('vb'+num);		item.className='clear';		var sbutton = document.getElementById('vs'+num);		sbutton.disabled=true;		var cbutton = document.getElementById('vc'+num);		cbutton.disabled=true;	} else {		// reset to saved value		setSaved(num);	}}// --></script></head><body onLoad="focus();"><?php	// add in the help link	$EXTRA_LINKS = " - <a style='font-size:.8em;' href='help.php' target='_HELP'>Help</a><br/>";	// add in the display to let people know how long they have to vote	$EXTRA_LINKS .= "<div class='date_message'>";	$not_allowed = 0; // assume user is allowed unless otherwise shown	$isRep = 0; // assume user is not an institutional rep	$Message = "";	if (strtotime($ROUND_CLOSE_DATE) < time()) {		// No one can access after the close date		$not_allowed = 1;		$Message = "Voting closed on " . date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));		$EXTRA_LINKS .= "Voting closed " . date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));	} else if (strtotime($ROUND_OPEN_DATE) > time()) {		// No access until voting opens		$not_allowed = 1;		$Message = "Voting is not allowed until " . date($ROUND_DATE_FORMAT,strtotime($ROUND_OPEN_DATE));		$EXTRA_LINKS .= "Voting opens " . date($ROUND_DATE_FORMAT,strtotime($ROUND_OPEN_DATE));	} else if (strtotime($ROUND_SWITCH_DATE) < time()) {		// User must be a rep or no access		$check_rep_sql="select pk from institution where rep_pk = '$USER_PK'";		$result = mysql_query($check_rep_sql) or die('Query failed: ' . mysql_error());				if (mysql_num_rows($result) == 0) {			$not_allowed = 1;			$Message = "Voting is currently open to institutional representatives only.<br/>";						// get info on their institutional rep			$get_rep_sql="select U2.firstname, U2.lastname, U2.email, institution.name from institutionjoin users U1 on U1.institution_pk = institution.pk and U1.pk = '$USER_PK'left join institution I1 on I1.pk = U1.institution_pkleft join users U2 on U2.pk = I1.rep_pk";			$result = mysql_query($get_rep_sql) or die('Rep info Query failed: ' . mysql_error());			$line = mysql_fetch_row($result);			if (!empty($line) && (isset($line[2])) ) {				$Message .= "Your institutional representative for ".$line[3]." is " . $line[0] . " " . $line[1] . " (".$line[2].").";			} else {				$Message .= "There is no institutional representative defined for instituion: " . $line[3];			}		} else {			// user is an institutional rep			$isRep = 1;		}				$EXTRA_LINKS .= "Rep voting from " . date($ROUND_DATE_FORMAT,strtotime($ROUND_SWITCH_DATE)) .			" to " . date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));	} else {		// open voting is allowed		$EXTRA_LINKS .= "Open voting from " . date($ROUND_DATE_FORMAT,strtotime($ROUND_OPEN_DATE)) .			" to " . date($ROUND_DATE_FORMAT,strtotime($ROUND_SWITCH_DATE));	}	$EXTRA_LINKS .= "</div>";	// set the official vote check sql	$rep_sql = " and requirements_vote.official = '$isRep' ";	?><? // Include the HEADER -AZinclude 'header.php'; ?><?= $Message ?><?php	// This part will punt the user out if they are not allowed to vote right now	// this is a nice punt in that it simply stops the rest of the page from loading -AZ	if ($not_allowed) {		include 'footer.php';		exit;	}?><?php//processing the posted values for saving$Keys = array();$Keys = array_keys($_POST);foreach( $Keys as $key){	$check = strpos($key,'vr');	if ( $check !== false && $check == 0 ) {		$item_pk = substr($key, 2);		$value = $_POST[$key];		//print "key=$key : item_pk=$item_pk : value=$value <br/>";		// Check to see if this vote already exists		$check_exists_sql="select pk, vote from requirements_vote where " .			"users_pk='$USER_PK' and req_data_pk='$item_pk'" . $rep_sql;		$result = mysql_query($check_exists_sql) or die('Query failed: ' . mysql_error());		if ($result && (mysql_num_rows($result) > 0) ) {			$row = mysql_fetch_assoc($result);			$existingVote = $row["vote"];			$existingPk = $row["pk"];			// vote exists, now see if it changed			if ($value == $existingVote) {				// vote not changed so continue				//print "vote not changed: $existingPk : $existingVote <br/>";				continue;			} else {				// vote changed so write update				//print "vote changed: $existingPk : $existingVote : $value<br/>";				$update_vote_sql="update requirements_vote set vote='$value' where pk='$existingPk'" . $rep_sql;				$result = mysql_query($update_vote_sql) or die('Query failed: ' . mysql_error());			}		} else {			// vote does not exist, insert it			//print "New vote: $USER_PK : $item_pk : $value <br/>";			$insert_vote_sql="insert into requirements_vote (users_pk,req_data_pk,vote,official) values " .				"('$USER_PK','$item_pk','$value','$isRep')";			$result = mysql_query($insert_vote_sql) or die('Query failed: ' . mysql_error());		}	}}$from_sql = "from requirements_data left join requirements_vote on " .	"req_data_pk = requirements_data.pk and users_pk='$USER_PK' " . $rep_sql .	"and requirements_vote.round='$ROUND' where requirements_data.round='$ROUND' ";// Voting Filter$filter_items_default = "show all items";$filter_items = "";$FILTER_ITEMS = $_REQUEST["filter_items"];if ($FILTER_ITEMS) { $filter_items = $FILTER_ITEMS; }$filter_items_sql = "";if ($filter_items == "show my voted items") {	$filter_items_sql = " and vote is not null ";} else if ($filter_items == "show my unvoted items") {	$filter_items_sql = " and vote is null ";} else if ($filter_items == "show my critical items") {	$filter_items_sql = " and vote = '3' "; // critical = 3} else if ($filter_items == "show my essential items") {	$filter_items_sql = " and vote = '2' "; // essential = 2} else if ($filter_items == "show my desirable items") {	$filter_items_sql = " and vote = '1' "; // desirable = 1} else if ($filter_items == "show my not applicable items") {	$filter_items_sql = " and vote = '0' "; // NA = 0} else {	// show all items	$filter_items = $filter_items_default;	$filter_items_sql = "";}// Components Filter$filter_components_default = "show all components";$filter_components = "";$FILTER_COMPONENTS = $_REQUEST["filter_components"];if ($FILTER_COMPONENTS) { $filter_components = $FILTER_COMPONENTS; }$filter_components_sql = "";if ($filter_components && ($filter_components != $filter_components_default)) {	$filter_components_sql = " and component like '%$filter_components%' ";} else {	$filter_components = $filter_components_default;}// Audience Filter$filter_audience_default = "show all audiences";$filter_audience = "";$FILTER_AUDIENCE = $_REQUEST["filter_audience"];if ($FILTER_AUDIENCE) { $filter_audience = $FILTER_AUDIENCE; }$filter_audience_sql = "";if ($filter_audience && ($filter_audience != $filter_audience_default)) {	$filter_audience_sql = " and audience like '%$filter_audience%' ";} else {	$filter_audience = $filter_audience_default;}$sqlfilters = $filter_items_sql . $filter_components_sql . $filter_audience_sql;// get the search$searchtext = "";$SEARCHTEXT = $_REQUEST["searchtext"];if ($SEARCHTEXT) { $searchtext = $SEARCHTEXT; }$sqlsearch = "";if ($searchtext) {	$sqlsearch = " and (jirakey like '%$searchtext%' OR summary like '%$searchtext%' " .		"OR description like '%$searchtext%') ";}// set sorting$default_sort = " order by JIRANUM ";$sorting = "";$SORTING = $_REQUEST["sorting"];if ($SORTING) { $sorting = $SORTING; }$sqlsorting = $default_sort;if ($sorting) {	$sqlsorting = " order by $sorting ";}if ($_REQUEST["clearall"]) {	$filter_items = $filter_items_default;	$filter_components = $filter_components_default;	$filter_audience = $filter_audience_default;	$sqlfilters = "";	$searchtext = "";	$sqlsearch = "";	$sorting = "";	$sqlsorting = $default_sort;}// counting number of items// **************** NOTE - APPLY THE FILTERS TO THE COUNT AS WELL$count_sql = "select count(*) " . $from_sql . $sqlfilters . $sqlsearch;$result = mysql_query($count_sql) or die('Count query failed: ' . mysql_error());$row = mysql_fetch_array($result);$total_items = $row[0];// pagination control$num_limit = 25;$NUM_LIMIT = $_REQUEST["num_limit"];if ($NUM_LIMIT) { $num_limit = $NUM_LIMIT; }$total_pages = ceil($total_items / $num_limit);$page = 1;$PAGE = $_REQUEST["page"];if ($PAGE) { $page = $PAGE; }$PAGING = $_REQUEST["paging"];if ($PAGING) {	if ($PAGING == 'first') { $page = 1; }	else if ($PAGING == 'prev') { $page--; }	else if ($PAGING == 'next') { $page++; }	else if ($PAGING == 'last') { $page = $total_pages; }}if ($page > $total_pages) { $page = $total_pages; }if ($page <= 0) { $page = 1; }$limitvalue = $page * $num_limit - ($num_limit);$mysql_limit = " LIMIT $limitvalue, $num_limit";$start_item = $limitvalue + 1;$end_item = $limitvalue + $num_limit;if ($end_item > $total_items) { $end_item = $total_items; }// fetching all requirements data items$sql="select requirements_data.*,requirements_vote.vote " . $from_sql .		$sqlfilters . $sqlsearch . $sqlsorting  . $mysql_limit;//print "Query=$sql<br>";$result = mysql_query($sql) or die('Query failed: ' . mysql_error());$items_displayed = mysql_num_rows($result);?><form name="voteform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;"><div style="background:#ECECEC;border:1px solid #ccc;padding:3px;margin-bottom:10px;">	<table border=0 cellspacing=0 cellpadding=0 width="100%">	<tr>	<td nowrap="y">	<strong>Filters:</strong>&nbsp;&nbsp;	</td>	<td nowrap="y">		<select name="filter_items" title="Filter the requirements by my votes">			<option value="<?= $filter_items ?>" selected><?= $filter_items ?></option>			<option value="show all items">show all items</option>			<option value="show my voted items">show my voted items</option>			<option value="show my unvoted items">show my unvoted items</option>			<option value="show my critical items">show my critical items</option>			<option value="show my essential items">show my essential items</option>			<option value="show my desirable items">show my desirable items</option>			<option value="show my not applicable items">show my not applicable items</option>		</select>		<select name="filter_components" title="Filter the requirements by affected component">			<option value="<?= $filter_components ?>" selected><?= $filter_components ?></option>			<option value="show all components">show all components</option>			<option value="New Tool">New Tool</option>			<option value="Account">Account</option>			<option value="Aliases (Admin Site Management)">(Admin Site Management)</option>			<option value="Announcements">Announcements</option>			<option value="Assignments">Assignments</option>			<option value="Attachment Widget">Attachment Widget</option>			<option value="CRUD">CRUD</option>			<option value="Calendar Widget">Calendar Widget</option>			<option value="Chat Room">Chat Room</option>			<option value="Database">Database</option>			<option value="Discussion">Discussion</option>			<option value="Documentation (other than Help)">Documentation (other than Help)</option>			<option value="Drop box">Drop box</option>			<option value="E-mail Archive">E-mail Archive</option>			<option value="Gateway">Gateway</option>			<option value="Global">Global</option>			<option value="Gradebook">Gradebook</option>			<option value="Help">Help</option>			<option value="Home">Home</option>			<option value="Install">Install</option>			<option value="JSF">JSF</option>			<option value="Licensing">Licensing</option>			<option value="MOTD">MOTD</option>			<option value="Membership">Membership</option>			<option value="Memory (Admin Site Management)">Memory (Admin Site Management)</option>			<option value="My Workspace">My Workspace</option>			<option value="News (RSS)">News (RSS)</option>			<option value="OSIDs">OSIDs</option>			<option value="On-Line (Admin Site Management)">On-Line (Admin Site Management)</option>			<option value="Page Wrapper Widget">Page Wrapper Widget</option>			<option value="Permission Widget">Permission Widget</option>			<option value="Portal">Portal</option>			<option value="Preferences">Preferences</option>			<option value="Presence">Presence</option>			<option value="Presentation">Presentation</option>			<option value="Profile">Profile</option>			<option value="Providers">Providers</option>			<option value="Quartz Scheduler">Quartz Scheduler</option>			<option value="Realms (Admin Site Management)">Realms (Admin Site Management)</option>			<option value="Resources">Resources</option>			<option value="Roster">Roster</option>			<option value="Rwiki">Rwiki</option>			<option value="SUTool">SUTool</option>			<option value="Sakai APIs">Sakai APIs</option>			<option value="Sakai Application Framework">Sakai Application Framework</option>			<option value="Samigo - Authoring">Samigo - Authoring</option>			<option value="Samigo - Delivery">Samigo - Delivery</option>			<option value="Samigo - Global">Samigo - Global</option>			<option value="Samigo - Grading">Samigo - Grading</option>			<option value="Samigo - Question Pools">Samigo - Question Pools</option>			<option value="Samigo - Templates">Samigo - Templates</option>			<option value="Schedule">Schedule</option>			<option value="Section Info">Section Info</option>			<option value="Site Archive (Admin Site Management)">Site Archive (Admin Site Management)</option>			<option value="Site Info">Site Info</option>			<option value="Sites (Admin Site Management)">Sites (Admin Site Management)</option>			<option value="Sites (Gateway)">Sites (Gateway)</option>			<option value="Skins (CSS)">Skins (CSS)</option>			<option value="Style Guide">Style Guide</option>			<option value="Syllabus">Syllabus</option>			<option value="Tab Management">Tab Management</option>			<option value="Tests & Quizzes (Samigo)">Tests & Quizzes (Samigo)</option>			<option value="Twin Peaks">Twin Peaks</option>			<option value="Users (Admin User Management)">Users (Admin User Management)</option>			<option value="WYSIWYG Widget">WYSIWYG Widget</option>			<option value="Web Content">Web Content</option>			<option value="Web Services">Web Services</option>			<option value="WebDAV">WebDAV</option>			<option value="Worksite Information">Worksite Information</option>			<option value="Worksite Setup">Worksite Setup</option>		</select>		<select name="filter_audience" title="Filter the requirements by intended audience">			<option value="<?= $filter_audience ?>" selected><?= $filter_audience ?></option>            <option value="show all audiences">show all audiences</option>			<option value="Students"> Students</option>			<option value="Instructors">Instructors </option>			<option value="Researchers">Researchers</option>			<option value="Staff(administrative)">Staff(administrative)</option>			<option value="Sakai administrators">Sakai Administrators </option>			<option value="Sakai developers">Sakai Developers</option>		</select>		&nbsp;	    <input type="submit" name="filter" value="Filter" title="Apply the current filter settings to the page">	</td>	<td nowrap="y" align="right">        <input type="text" name="searchtext" value="<?= $searchtext ?>"        	length="20" title="Enter search text here">        <input type="submit" name="search" value="Search" title="Search the requirements">	</td>	</tr>	<tr>	<td nowrap="y"><b>Paging:</b></td>	<td nowrap="y" style="font-size:8pt;">		<input type="hidden" name="page" value="<?= $page ?>">		<input type="submit" name="paging" value="first" title="Go to the first page">		<input type="submit" name="paging" value="prev" title="Go to the previous page">		Page <?= $page ?> of <?= $total_pages ?>		<input type="submit" name="paging" value="next" title="Go to the next page">		<input type="submit" name="paging" value="last" title="Go to the last page">		&nbsp;-&nbsp;		Displaying <?= $start_item ?> - <?= $end_item ?> of <?= $total_items ?> items (<?= $items_displayed ?> shown)		&nbsp;-&nbsp;		Max of		<select name="num_limit" title="Choose the max items to view per page">			<option value="<?= $num_limit ?>"><?= $num_limit ?></option>			<option value="10">10</option>			<option value="25">25</option>			<option value="50">50</option>			<option value="100">100</option>		</select>		items per page	</td>	<td align="right">		<input type="submit" name="clearall" value="Clear All Filters" title="Reset all filters">	</td>	</tr>	</table></div><table width=100% border=0 cellspacing=0><tr class='tableheader'><td width='10%'>&nbsp;VOTE</td><td width='5%' align="center">Req#</td><td width='35%'>Summary</td><td width='50%'>Description</td></tr><?phpwhile($links=mysql_fetch_array($result)) {	$line++;	$pk=$links["pk"];	$key=$links["jirakey"];	$summary=$links["summary"];	$description=$links["description"];	$component=$links["component"];	$audience=$links["audience"];	$vote=$links["vote"];	// description cleanup	$description = trim($description);	// component cleanup (turn pipe seperators into breaks)	$component = str_replace("|",",<br/>",trim($component));	// audience cleanup (turn pipe seperators into breaks)	$audience = str_replace("|",",<br/>",trim($audience));	// voting check	if (!isset($vote)) { $vote = -1; }	$checked = array("","","","","");	$tdstyle = "";	if ($vote < 0) {		// item has not been voted on and saved	} else {		// item has been voted on and saved		$checked[$vote] = " checked ";		$tdstyle = " class='saved' ";	}	$linestyle = "oddrow";	if ($line % 2 == 0) {		$linestyle = "evenrow";	} else {		$linestyle = "oddrow";	}?>	<tr id="<?= $linestyle ?>" valign="top">		<td id="vb<?= $pk ?>" <?= $tdstyle ?> nowrap='y' style='border-right:1px dotted #ccc;border-bottom:1px solid black;' rowspan="2">			<input name="vr<?= $pk ?>" type="radio" value="3" <?= $checked[3] ?> onClick="checkSaved('<?= $pk ?>')" title="Cannot use Sakai without it">critical<br />			<input name="vr<?= $pk ?>" type="radio" value="2" <?= $checked[2] ?> onClick="checkSaved('<?= $pk ?>')" title="Can use Sakai but need this as soon as possible">essential<br />			<input name="vr<?= $pk ?>" type="radio" value="1" <?= $checked[1] ?> onClick="checkSaved('<?= $pk ?>')" title="Can use Sakai but would like this">desirable<br />			<input name="vr<?= $pk ?>" type="radio" value="0" <?= $checked[0] ?> onClick="checkSaved('<?= $pk ?>')" title="Does not impact our use of Sakai">not&nbsp;applicable&nbsp;<br />			<div style="margin:8px;"></div>			<input id="vh<?= $pk ?>" type="hidden" name="cur<?= $pk ?>" value="<?= $vote ?>">			<input id="vc<?= $pk ?>" type="button" value="Reset" onClick="setCleared('<?= $pk ?>')"				disabled='y' title="Clear the radio buttons for this item or reset to the saved vote">			<input id="vs<?= $pk ?>" type="submit" name="submit" value="Save"				disabled='y' title="Save all votes, votes cannot be removed once they are saved">		</td>		<td nowrap='y'>			&nbsp;			<a href='<?= $JIRA_REQ ?><?= $key ?>' title='link to Jira requirement <?= $key ?>' target='_JIRA'><?= $key ?></a>			&nbsp;		</td>		<td height="30px";>			<div class="summary"><?= $summary ?></div>		</td>		<td rowspan="2" style="padding:2px;border-bottom:1px solid black;">			<div class="description"><?= $description ?></div>		</td>	</tr>	<tr id="<?= $linestyle ?>" valign="top">		<td colspan="2" style="border-bottom:1px solid black;">			<table>			<tr>				<td align=right valign="top"><b>Component:</b></td>				<td align="left" valign="top"><?= $component ?></td>			</tr>			<tr>				<td align=right valign="top"><b>Audience:</b></td>				<td align="left" valign="top"><?= $audience ?></td>			</tr>			</table>		</td>	</tr><?php } //end of while ?></table></form><?php // Include the defined terms -AZinclude 'defineterms.html'; ?><?php // Include the FOOTER -AZinclude 'footer.php'; ?></body></html>