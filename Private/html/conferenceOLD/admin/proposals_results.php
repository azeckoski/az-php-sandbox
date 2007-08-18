<?php
/* proposals.php
 * Created on Apr 6, 2006 by az - Aaron Zeckoski
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech 
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Proposals Results and Editing";

$ACTIVE_MENU="PROPOSALS";  //for managing active links on multiple menus
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = false; // assume user is NOT allowed unless otherwise shown
if ( (!$User->checkPerm("admin_accounts")) && (!$User->checkPerm("proposals_dec2006")) && (!$User->checkPerm("admin_conference")) ) {
	$allowed = false;
	$Message = "Only admins and the conference committee  may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = true;
}
// this restricts the viewing by date
$viewing = false;

$commenting = true;

$Message .= "<div class='date_message' style='text-align:left;'><a href='#colorkey'> View Color Key </a> &nbsp;&nbsp;&nbsp; ";
if (strtotime($VOTE_CLOSE_DATE) < time()) {
	// Results viewable after close date
	$viewing = true;
	$Message .= "Voting closed " . date($SHORT_DATE_FORMAT,strtotime($VOTE_CLOSE_DATE));
} else {
	// no viewing allowed
	$viewing = false;
	$EXTRA_LINKS .= "Results visible after " . date($SHORT_DATE_FORMAT,strtotime($VOTE_CLOSE_DATE));
	//$Message .= "Results cannot be viewed until after " . date($DATE_FORMAT,strtotime($VOTE_CLOSE_DATE));
}
$Message .= "</div>";

// Do the export as requested by the user
if ($_REQUEST["export"] && $allowed) {
	$date = date("Ymd-Hi",time());
	$filename = "proposal_results-" . $date . ".csv";
	header("Content-type: text/x-csv");
	header("Content-disposition: inline; filename=$filename\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0"); 
	print "\n\"Exported on:\",\"" . date($DATE_FORMAT,time()) . "\"\n";
	print "\"Voting end date:\",\"" . date($DATE_FORMAT,strtotime($ROUND_END_DATE)) . "\"\n";	
	
} else if (!$_REQUEST["export"]){ 
	// display the page normally

// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
$CSS_FILE2 = $TOOL_URL. "/include/proposals.css";


// set header links
$EXTRA_LINKS = "<span class='extralinks'>" ;
	if ($PROPOSALS) {  
		$EXTRA_LINKS .= "<a  href='$CONFADMIN_URL/admin/proposals.php'>Proposals-Voting</a>";		
		$EXTRA_LINKS .= "<a class='active' href='$CONFADMIN_URL/admin/proposals_results.php'>Proposals-Results</a>";  }
	$EXTRA_LINKS .="</span>";


?>

<?php // INCLUDE THE HTML HEAD 
include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript">
<!--

function showAddComment(num) {
	var commentItem = document.getElementById('addComment'+num);
	if (commentItem != null) {
		commentItem.style.display = "";
	}
	var triggerItem = document.getElementById('onComment'+num);
	if (triggerItem != null) {
		triggerItem.style.display = "none";
	}
}
function orderBy(newOrder) {
	if (document.voteform.sortorder.value == newOrder) {
		if (newOrder.match("^.* desc$")) {
			document.voteform.sortorder.value = newOrder.replace(" desc","");
		} else {
			document.voteform.sortorder.value = newOrder;
		}
	} else {
		document.voteform.sortorder.value = newOrder;
	}
	document.voteform.submit();
	return false;
}


// These are the voting functions
function setAnchor(num) {

	document.voteform.action += "#anchor"+num;
	document.voteform.submit();
	return false;
}



// -->
</script>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>

<?php include $ACCOUNTS_PATH.'include/header.php'; // INCLUDE THE HEADER ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		echo $Message;
		include $ACCOUNTS_PATH.'include/footer.php';
		exit;
	}

} /* export check */


//processing the posted values for saving
$Keys = array();
$Keys = array_keys($_POST);
foreach( $Keys as $key)
{
	if ($_POST[$key] == "") { continue; } // skip blank values

	$check = strpos($key,'vr');
	$check2 = strpos($key,'cmnt');
	if ( $check !== false && $check == 0 ) {
		$itemPk = substr($key, 2);
		$newVote = $VOTE_SCORE[$_POST[$key]];
		//print "key=$key : item_pk=$itemPk : vote=$newVote <br/>";

		// Check to see if this vote already exists
		$check_exists_sql="select pk, vote from conf_proposals_vote where " .
			"users_pk='$User->pk' and conf_proposals_pk='$itemPk'";
		$result = mysql_query($check_exists_sql) or die("Query failed ($check_exists_sql): " . mysql_error());

		if ($result && (mysql_num_rows($result) > 0) ) {
			$row = mysql_fetch_assoc($result);
			$existingVote = $row['vote'];
			$votePk = $row['pk'];

			// vote exists, now see if it changed
			if ($newVote == $existingVote) {
				// vote not changed so continue
				//print "vote not changed: $votePk : $existingVote <br/>";
				continue;
			} else {
				// vote changed so write update
				//print "vote changed: $votePk : $existingVote <br/>";
				$update_vote_sql="update conf_proposals_vote set vote='$newVote' where pk='$votePk'";
				$result = mysql_query($update_vote_sql) or die("Query failed ($update_vote_sql): " . mysql_error());
			}

		} else {
			// vote does not exist, insert it
			//print "New vote: $User->pk : $item_pk : $value <br/>";
			$insert_vote_sql="insert into conf_proposals_vote (users_pk,conf_proposals_pk,vote,confID) values " .
				"('$User->pk','$itemPk','$newVote','$CONF_ID')";
			$result = mysql_query($insert_vote_sql) or die('Query failed: ' . mysql_error());
		}
	} else if ($check2 !== false && $check2 == 0 ) {
		$itemPk = substr($key, 4);
		$comment = mysql_real_escape_string($_POST[$key]);

		$insert_sql="insert into conf_proposals_comments " .
			"(users_pk,conf_proposals_pk,comment_text,confID) values " .
			"('$User->pk','$itemPk','$comment','$CONF_ID')";
		$result = mysql_query($insert_sql) or die("Query failed ($insert_sql): " . mysql_error());
	}
}
// first get the votes and drop them into a hash
$votes_sql = "select conf_proposals_pk, vote, " .
	"count(V.pk) as votes from conf_proposals_vote V " .
	"where confID='$CONF_ID' group by conf_proposals_pk, vote";
//print "VOTE_SQL=$votes_sql<br/>";
$result = mysql_query($votes_sql) or die('Votes query failed: ' . mysql_error());
$allvotes = array();
while($row = mysql_fetch_array($result)) {
	//print "Votes:" . $row[0] . ":" . $row[1] . "=" . $row[2] . "<br/>";
	$allvotes[$row[0] . ":" . $row[1]] = $row[2];
}
mysql_free_result($result);


// get the search
$searchtext = "";
if ($_REQUEST["searchtext"] && (!$_REQUEST["clearall"]) ) { $searchtext = $_REQUEST["searchtext"]; }
$sqlsearch = "";
if ($searchtext) {
	$sqlsearch = " and (title like '%$searchtext%' OR abstract like '%$searchtext%' " .
		"OR firstname like '%$searchtext%' OR lastname like '%$searchtext%'" .
		"OR institution like '%$searchtext%') ";
}


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
} else {
	// show all items
	$filter_items = $filter_items_default;
	$filter_items_sql = "";
}



// Session Length Filter
$filter_length_default = "show all";
$filter_length = "";
if ($_REQUEST["filter_length"] && (!$_REQUEST["clearall"]) ) { $filter_length = $_REQUEST["filter_length"]; }

$special_filter = "";
$filter_length_sql = "";
if ($filter_length == "30 min") {
	$filter_length_sql = " and length='30' ";
} else if ($filter_length == "60 min") {
	$filter_length_sql = " and length='60' ";
} else if ($filter_length == "90 min") {
	$filter_length_sql = " and length='90' ";
}else {
	// show all length
	$filter_length = $filter_length_default;
	$filter_length_sql = "";
}

// Type Filter
$filter_type_default = "show all types";
$filter_type = "";
if ($_REQUEST["filter_type"] && (!$_REQUEST["clearall"]) ) { $filter_type = $_REQUEST["filter_type"]; }

$filter_type_sql = "";
if ($filter_type && ($filter_type != $filter_type_default)) {
	if ($filter_type=="all presentation types") {
		$filter_type_sql = " and type!='demo' and type!='poster' and type !='BOF' ";
	} else {
	$filter_type_sql = " and type='$filter_type' ";
	}
} else {
	$filter_type = $filter_type_default;
}


// Approval Status Filter
$filter_status_default = "show all status";
$filter_status = "";
if ($_REQUEST["filter_status"] && (!$_REQUEST["clearall"]) ) { $filter_status = $_REQUEST["filter_status"]; }

$special_filter = "";
$filter_status_sql = "";
switch ($filter_status){
   	case "approved": $filter_status_sql = " and approved ='Y' and type!='demo' and type!='poster' and type !='BOF'"; break;
  	case "not approved": $filter_status_sql = " and approved !='Y' and approved !='B' and approved !='P' "; break;
  	case "pending": $filter_status_sql = " and approved ='P' "; break;
 	case "pending + approved": $filter_status_sql = " and approved !='N' and approved!='B' and approved!='' and type!='demo' and type!='poster' and type !='BOF' "; break;
	case "bundled": $filter_status_sql = " and approved ='B'"; $msg.=" ** These BUNDLED proposals have been combined with others and replaced by a new combined proposal.";  break;
 	case "bundled + approved": $filter_status_sql = "  and approved !='N' and approved!='P' and approved!=''  and type!='demo' and type!='poster' and type !='BOF' "; break;
	case ""; // show all items
		$filter_status = $filter_status_default;
		$filter_status_sql = "";
		break;
}
// Track Filter
$filter_track_default = "show all tracks";
$filter_track = "";

if ($_REQUEST["filter_track"] && (!$_REQUEST["clearall"]) ) { $filter_track = $_REQUEST["filter_track"]; }
$filter_track_sql = "";
if ($filter_track && ($filter_track != $filter_track_default)) {
	$filter_track_sql = " and track='$filter_track' ";
} else {
	$filter_track = $filter_track_default;
}

// SubTrack Filter
$filter_sub_track_default = "show all subtracks";
$filter_sub_track = "";
if ($_REQUEST["filter_sub_track"] && (!$_REQUEST["clearall"]) ) { $filter_sub_track = $_REQUEST["filter_sub_track"]; }

$special_filter = "";
$filter_sub_track_sql = "";
switch ($filter_sub_track){
   	case "OSP": $filter_sub_track_sql = " and sub_track='OSP' "; break;
  	case "Cool Commercial Tool": $filter_sub_track_sql = " and sub_track='Cool Commercial Tool' "; break;
 	case "User Experience": $filter_sub_track_sql = " and sub_track='User Experience' "; break;
 	case "Library": $filter_sub_track_sql = " and sub_track='Library' "; break;
 	case "Cool New Tools": $filter_sub_track_sql = " and sub_track='Cool New Tools' "; break;
 	
		case ""; // show all items
		$filter_sub_track = $filter_sub_track_default;
		$filter_sub_track_sql = "";
		break;
}
  
  // SubTrack Filter
$filter_bundle="";
if ( ($_REQUEST['filter_bundle']=='Y') && (!$_REQUEST["clearall"])) {
$filter_bundle_sql = " and bundle='Y' ";
}

// sorting
$sortorder = "order_num";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }
$sqlsorting = " order by $sortorder ";
// First get the list of proposals and related users for the current conf 
// (maybe limit this using a search later on)

$sql = "select U1.firstname, U1.lastname, U1.email, U1.institution, " .
	"U1.firstname||' '||U1.lastname as fullname, CV.vote, " .
	"CP.* from conf_proposals CP left join users U1 on U1.pk = CP.users_pk " .
	"left join conf_proposals_vote CV on CV.conf_proposals_pk = CP.pk " .
	"and CV.users_pk='$User->pk' " .
	"where CP.confID = '$CONF_ID' and CP.approved!='D'  and CP.track!='unavailable' " . $sqlsearch . 
	$filter_type_sql . $filter_items_sql . $filter_track_sql .$filter_sub_track_sql .$filter_status_sql .$filter_bundle_sql .$filter_length_sql .$sqlsorting . $mysql_limit;

//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$items = array();

// put all of the query results into an array first
while($row=mysql_fetch_assoc($result)) { $items[$row['pk']] = $row; }

// add in the audiences and topics of that nature (should require 2 more queries)
$sql = "select PA.pk, PA.proposals_pk, R.role_name, PA.choice from proposals_audiences PA " .
	"join conf_proposals CP on CP.pk = PA.proposals_pk and confID='$CONF_ID' " .
	"join roles R on R.pk = PA.roles_pk order by PA.choice desc";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$audience_items = array();
while($row=mysql_fetch_assoc($result)) {
	$audience_items[$row['proposals_pk']][$row['pk']] = $row;
}

$sql = "select PT.pk, PT.proposals_pk, T.topic_name, PT.choice from proposals_topics PT " .
	"join conf_proposals CP on CP.pk = PT.proposals_pk and confID='$CONF_ID' " .
	"join topics T on T.pk = PT.topics_pk order by PT.choice desc";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$topics_items = array();
while($row=mysql_fetch_assoc($result)) {
	$topics_items[$row['proposals_pk']][$row['pk']] = $row;
}

// now bring in the comments
$sql = "select CC.pk, CC.conf_proposals_pk, CC.comment_text, CC.date_created, " .
	"U1.username, U1.email from conf_proposals_comments CC " .
	"left join users U1 on U1.pk = CC.users_pk " .
	"where CC.confID like '$CONF_ID' order by CC.conf_proposals_pk";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$comments_items = array();
while($row=mysql_fetch_assoc($result)) {
	$comments_items[$row['conf_proposals_pk']][$row['pk']] = $row;
}

foreach ($items as $item) {
	// these add an array to each proposal item which contains the relevant topics/audiences
	$items[$item['pk']]['topics'] = $topics_items[$item['pk']];
	$items[$item['pk']]['audiences'] = $audience_items[$item['pk']];
	$items[$item['pk']]['comments'] = $comments_items[$item['pk']];
}

//echo "<pre>",print_r($items),"</pre><br/>";
if (!$_REQUEST["export"]) {
?>

<div id="maindata">




<form name="voteform" method="post" action="<?= $_SERVER['PHP_SELF'] ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>" />

<div style="background:#fff;border:0px solid #ccc;padding:3px;margin-bottom:10px;">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
	<td style="whitespace:nowrap;" valign=top>
	<strong>Filters:</strong>&nbsp;&nbsp;
	</td>
	<td nowrap="y" style="padding-right:10px;">
		<strong>Vote:</strong>
		<select name="filter_items" title="Filter the items by my votes">
			<option value="<?= $filter_items ?>" selected><?= $filter_items ?></option>
			<option value="show all items">show all items</option>
			<option value="show my voted items">show my voted items</option>
			<option value="show my unvoted items">show my unvoted items</option>
		</select>
		&nbsp;&nbsp;
		<strong>Status:</strong>
		<select name="filter_status" title="Filter the items by approval status">
			<option value="<?= $filter_status ?>" selected><?= $filter_status ?></option>
			<option value="approved">approved</option>
			<option value="pending">pending</option>
			<option value="pending + approved">pending + approved</option>
			<option value="bundled">bundled</option>
			<option value="bundled + approved">bundled + approved</option>
			<option value="not approved">not approved</option>
			<option value="show all status">show all status</option>
		</select>
		&nbsp;
		&nbsp;	
	
		<strong>Type:</strong>
		<select name="filter_type" title="Filter the items by type">
			<option value="<?= $filter_type ?>" selected><?= $filter_type ?></option>
	        <?php foreach ($type_list as $key => $value ) { ?>
	        	<option value="<?=$value?>"><?=$value?></option>
	        	<?php } ?>
	        	<option value="all presentation types">all presentation types</option>
	        	
			<option value="show all types">show all types</option>
		</select>
		&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= count($items) ?> proposals shown<br/><br/>
		
		 
		<strong>Track:</strong>
		<select name="filter_track" title="Filter the items by track">
			<option value="<?= $filter_track ?>" selected><?= $filter_track ?></option>
			    <?php foreach ($track_list as $key => $value ) { ?>
	        	<option value="<?=$value?>"><?=$value?></option>
	        	<?php } ?>	
	       	<option value="show all tracks">show all tracks</option>
		</select>
		
		
			&nbsp;
		&nbsp;
		<strong>SubTrack:</strong>
		<select name="filter_sub_track" title="Filter the items by subtrack">
			<option value="<?= $filter_sub_track ?>" selected><?= $filter_sub_track ?></option>
			    <?php foreach ($subtrack_list as $key => $value ) { ?>
	        	<option value="<?=$value?>"><?=$value?></option>
	        	<?php } ?>	
			<option value="show all subtracks">show all subtracks</option>
		</select>
		&nbsp;
		&nbsp;
		&nbsp;
		
		
		
		&nbsp;
	  	<strong>Length:</strong>
		<select name="filter_length" title="Filter the items by session length">
			<option value="<?= $filter_length ?>" selected><?= $filter_length ?></option>
	       	<option value="30 min">30 min</option>
			<option value="60 min">60 min</option>
			<option value="90 min">90 min</option>
			<option value="show all status">show all </option>
		</select>
		&nbsp;
		&nbsp;
		&nbsp;  
		<strong>bundle candidate?</strong> <input name="filter_bundle" type="checkbox" value="Y" <?php if ($_POST['filter_bundle']=="Y") { echo "checked"; } ?> /> 
     &nbsp;&nbsp;
	    <input class="filter" type="submit" name="filter" value="Filter" title="Apply the current filter settings to the page" />
		&nbsp;&nbsp;&nbsp;<input class="filter" type="submit" name="clearall" value="Clear Filters" title="Reset all filters" />
   
    <td valign="top" style="border-left:1px dotted #ccc; padding-left:15px;" >
		

	<input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>" maxlength="20" title="Enter search text here" />
        <script type="text/javascript">document.voteform.searchtext.focus();</script>
        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements" />
       	<br/><br/>
       <input class="filter" type="submit" name="export" value="Export" title="Export results based on current filters" />
 
	</td>
	</tr>
	</table>
</div>


<table id="proposals_vote" width="100%" cellspacing="0" cellpadding="0">
<tr><td colspan="4"><div>
<?= $Message ?> </div></td>
<td colspan=3><div style="color:#660000;text-align:center;"> &nbsp;&nbsp;<?= $msg ?></div>
</td></tr>
<tr class="tableheader">
<td><a href="javascript:orderBy('order_num');">#</a></td>
<td>&nbsp;Voting</td>
<td>Results</td>

<td><a href="javascript:orderBy('title');"title="sort by Title" >Title</a>&nbsp;/&nbsp;<a href="javascript:orderBy('lastname');" title="sort by submitter last name">Submitted&nbsp;by</a> &nbsp;/&nbsp;<a href="javascript:orderBy('approved');">Approval Status</a> </td>
<td><a href="javascript:orderBy('speaker');"title="sort by primary speaker FIRST name" >Speaker(s)</a></td>
<td>Details</td>
<?php // if topic or audience ranking is required
	 if ($RANKING){  ?>
	 <td>Topic&nbsp;/&nbsp;Audience&nbsp;Rank</td>
	 <?php }  ?>
	
</tr>

<?php 
} /* export check */

// now dump the data we currently have
$line = 0;
foreach ($items as $item) { // loop through all of the proposal items


	$line++;

	$pk = $item['pk'];
	$vote = $item['vote'];

	if (!isset($item['lastname'])) {
		$item['lastname'] = "<em>unknown user</em>";
	}

	$printInst = $item['institution'];
/*
 *	if (strlen($printInst) > 33) {
 *	$printInst = substr($printInst,0,30) . "...";
 *	}
 */

	$linestyle = "oddrow";
	if (($line % 2) == 0) { $linestyle = "evenrow"; } else { $linestyle = "oddrow"; }

	// voting check
	if (!isset($vote)) { $vote = -1; }
	$checked = array("","","","","");

	if (isset($VOTE_SCORE[$vote])) {
		// item has been voted on and saved
		$checked[$VOTE_SCORE[$vote]] = " checked='y' ";
	}

	// get votes counts
	$total = 0;
	for ($i=0; $i<count($VOTE_TEXT); $i++) {
		$total += $allvotes["$pk:$i"];
	}
	$item["Total Votes"] = $total;

	$votes = array();
	$percents = array();
	$numerator = 0;
	for ($i=0; $i<count($VOTE_TEXT); $i++) {
		$votes[$i] = $allvotes["$pk:$i"]+0;
		$item[$VOTE_TEXT[$i]] = $votes[$i];
		if (!$total) {
			$percents[$i] = 0;
		} else {
			$percents[$i] = round(($votes[$i]/$total)*100,1);
		}
		$item[$VOTE_TEXT[$i]."%"] = $percents[$i];
		$numerator += ($i+1) * $votes[$i];
	}

	$checked = array();
	if (!$total) {
		$item["Average"] = 0;
	} else {
		$item["Average"] = round($numerator/$total) - 1;
	}
	$item["AvgText"] = $VOTE_TEXT[ $item["Average"] ];
	if (!$total) {
		$checked[$item["Average"]] = "";
	} else { $checked[$item["Average"]] = " class='avgvote' ";
	}
	
	// array_search(max($votes),$votes)

	
	// this selects the background so that it highlights
	// red if there are any red votes, yellow if any yellows
	// if approved then the color is set to blue
	if ($item['type']=='demo'){
		$tdstyle = " class='demo' ";
	} else if ($item['type']=='BOF'){
		$tdstyle = " class='bof' ";
	} else if ($item['type']=='poster'){
		$tdstyle = " class='poster' ";
	} else if ($item["red"]) {
		if ($item["approved"] == "N") {
			$tdstyle = " class='saved_red' ";
		} else {
			$tdstyle = " class='saved_red' ";
		}
	} else if ($item["yellow"]) {
		if ($item["approved"] == "N") {
			$tdstyle = " class='saved_yellow' ";
		} else {
			$tdstyle = " class='saved_yellow' ";
		}
	} else if ($item["green"]) {
		if ($item["approved"] == "N") {
			$tdstyle = " class='saved_green' ";
		} else {
			$tdstyle = " class='saved_green ' ";
		}
	} else {
		$tdstyle = " class='saved' ";
	}

//if (!$total) { $tdstyle = " class='no_vote' ";  }
	if ($_REQUEST["export"]) {
	
		
		if ($line == 1) {
			$output = "\"Proposal vote export\",\"KEY:\",";
			for ($i=0; $i<count($VOTE_TEXT); $i++) {
				$output .= "\"" . $VOTE_TEXT[$i] . "=" . $i . "\",";
			}
			print $output . "\n";
			print join(',', array_keys($item)) . "\n"; // add header line
		}
		
		foreach ($item as $name=>$value) {
			$value = str_replace("\"", "\"\"", $value); // fix for double quotes
			$item[$name] = '"' . $value . '"'; // put quotes around each item
		}
		print join(',', $item);

			
	} else {
		// normal display
?>

<tr class="<?= $linestyle ?>" valign="top">
	<td style="padding-left:1px;" ><div><strong style="text-align:center;font-size: .9em; border:1px dotted #333333; background:#e9d06f; margin:0; margin-right:2px; padding: 3px 3px; "><?=$item['order_num']?></strong>&nbsp;</div></td>
	<td <?= $tdstyle ?> nowrap='y' style="text-align:right;">
		<a name="anchor<?= $pk ?>"></a><a name="num<?= $item['order_num']?>"></a>
<?php if ($item['type']=='demo')  {
		echo "<strong>Demo:</strong><br/>No voting";
	} else if ($item['type']=='poster')  {
		echo "<strong>Poster:</strong><br/>No voting";
	} else if ($item['type']=='BOF')  {
		echo "<strong>BOF:</strong><br/>No voting";
	} else  {
?>
<?php	for ($vi = 0; $vi < count($VOTE_TEXT); $vi++) { ?>
		<div <?= $checked[$vi] ?> >&nbsp;<label title="<?= $VOTE_HELP[$vi] ?>"><?= $VOTE_TEXT[$vi] ?></label>&nbsp;</div>
<?php	} ?>
		<div style='margin:6px;'></div>
		&nbsp;<label title="Total number of votes for this item"><br/>Total:</label>&nbsp;<br />
		<div style="margin:12px;"></div>
<?php } /* end demo check */ ?>
	</td>

	<td nowrap="y" style="border-right:1px dotted #ccc;">
<?php if($item['type']=='demo') {
	echo "<strong>Demo:</strong><br/>No results<br/>for demos";
	} else if ($item['type']=='BOF') {
	echo "<strong>BOF:</strong><br/>No results<br/>for BOFs";
	} else {
?>
		<div style="margin-left:6px;">
<?php	for ($vi = 0; $vi < count($VOTE_TEXT); $vi++) { ?>
			<?= $votes[$vi] ?> (<?= $percents[$vi] ?>%)<br/>
<?php	} ?>
			<div style='margin:6px;'></div>
			<b><br/><?= $total ?></b><br/>
			<div style="margin:12px;"></div>
		</div>
<?php } /* end demo check */ ?>
	</td>
	<td width="25%">
<?php
if (($item['type'] != 'demo') && ($item['type'] != 'BOF') &&($item['type'] != 'poster')){ 
	if ($item['approved'] == "Y") {
		echo "<div class='approved'  style='white-space:nowrap;'>" .
				"APPROVED &nbsp; &nbsp; &nbsp; ";
				$editcolor="color:#336699;";
	}
	 else if ($item['approved'] == "P"){
		echo "<div class='pending'>" .
				"PENDING &nbsp; &nbsp; &nbsp; ";
				$editcolor="color:#336699;";
	} else if ($item['approved'] == "B"){

		echo "<div class='bundled'>" .
				"BUNDLED &nbsp; &nbsp; &nbsp; ";
				$editcolor="color:#eeeeee;";
	} else {
		echo "<div class='unapproved'>" .
				"NOT APPROVED &nbsp; &nbsp; &nbsp; ";
				$editcolor="color:#336699;";
	}		if ($User->checkPerm("admin_conference")) {
		
	 ?>	( <a style="<?=$editcolor?> font-weight:normal;" title="Edit this proposal" href="<?= "edit_proposal.php?pk=$item[pk]&amp;edit=1&amp;location=0" ?>"> EDIT </a>  )
	
		 
<!--	&nbsp;&nbsp;( <a style="color:red;" href="edit_proposal.php?pk=<?= $item['pk'] ?>&amp;delete=1&amp;type=<?=$item['type']?>" 
			title="Delete this proposal"
			onClick="return confirm('Are you sure you want to delete this proposal?');" >X </a>) 
-->			
<?php	echo "</div>";
  }  else {  echo "</div>";
	 }
	
	
	//TODO  
	//provide a javascript or ajax warning for the delete link below  before
	//letting people use this feature
	
}
	?>
	
<?php if ($item['approved']=="B") { ?>
<div class="summary" style="color:red">**This proposal has been replaced by a larger bundled proposal -
<?php if (!$item['new_pk']){ echo "<span style='color: #333333;'>(TBD).</span>"; } else { ?>
 # <a href="#num<?=$item['new_pk']?>"><?=$item['new_pk']?></a> </div>
<?php } 
} ?>
	<div class="summary"><br/><strong><?= $item['title'] ?></strong><br/><br/></div>
		<div class="item_info"><strong>Submitted by:</strong><br/></div>
		<div style="padding-left:20px;"> <a href="mailto:<?= $item['email'] ?>">
			<?= $item['firstname']." ".$item['lastname'] ?></a><br/>
			<?= $printInst ?><br/><br /></div>
		<div class="item_info"><strong>Date Submitted: </strong><br/></div>
		<div style="padding-left:20px;">	<?= date($MED2_DATE_FORMAT,strtotime($item['date_created'])) ?><br/><br/></div>
		
	</td>
<td style="border-bottom:1px solid black;" rowspan="2" width="20%">
	<div class="description">
	<?php if ($item['type']=='paper')  { ?>
	<br/><br/><br/>	<strong>Author:</strong><br/> 
	<?php } else  { ?>
		<br/><br/><br/>	<strong>Speaker:</strong><br/>
	<?php } ?>
		<a href="mailto:<?=$item['email']?>"><?= $item['speaker']  ?> </a> 
	 </div><br/>
	<?php if ($item['type']=='paper')  { ?>
		<div class="description"><strong>Co Author(s):</strong></div>
	<?php } else  {  ?>
		<div class="description"><strong>Co Speaker(s):</strong></div>
	<?php } if ($item['co_speaker'])   {  ?>
		<div><?=$item['co_speaker']?></div>
		<?php }  else { 
		 echo "<span class='item_info'> &nbsp; &nbsp;  n/a<br/><br/><br/></span>";    } 
		 if ($item['author_other']){ 
		echo $item['author_other'] ;   
		}?>
	
		<br/><br/>

	 <?php  if ($AVAILABLE) {  ?>
	 	<div class='description'>
	 <?php
	  if ($item['conflict']) {
	  	echo "<strong>Availability: </strong>  <br/>" .
	  			"NOT on: "  ;
	  	?>
	  	<span style="color:red;"> <?= $item['conflict'] ?></span>
	  	
	  	<?php
	  } else {
	  	echo "<br/>  <strong>Availability:  </strong><br/>   available all days";
	  }  
	 }echo "</div>";
	
	  ?>
	</td>
	
	<td style="border-bottom:1px solid black;" rowspan="2" width="40%"><br/><br/>
		<div class="description"><br/><strong>
	<?php	if ($item['type']=='paper')  {
				echo "Paper ";
		} else {
				echo "Presentation ";}  ?>
			Abstract:</strong><?php if (!$item['abstract']) { 
			  echo "<span class='item_info'> &nbsp; &nbsp;  not available<br/><br/><br/></span>";    }
	?><br/><?php $abstract= nl2br(trim(htmlspecialchars($item['abstract']))); 
				echo stripslashes($abstract);?><br/><br/></div>
			<?php if ($item['type']=="paper") { 
				if ($item['paper_url']) {
					
					$paper_url=$PAPER_LOC.$item['paper_url'];
				?>
			<div class="description"><strong>Download Paper:</strong>&nbsp; &nbsp;
		<?php	echo"<a href='$paper_url'><img src='../include/images/download_f2.png'  alt='download image'  border='0' width='19' height='19'  /> &nbsp;" .$item['paper_url'] ." </a><br/><br/></div>";
		
				}}?>
		<?php if ($item['URL']) { /* a project URL was provided */
			$url=$item['URL'];
			echo"<div><strong>Project URL: </strong><a href=\"$url\"><img src=\"../include/images/weblink.png\" alt=\"weblink\" border=0 width=10 height=10 /> " .
			$url ."</a><br/><br/></div>";
		}
		
if (($item['type']!='demo') && ($item['type'] != 'BOF'))  { 
	
		?>
	<br/>	<div class="description"><strong>Comments/Additional Information:</strong>
		<?php if (!$item['desc']) { 
			  echo "<span class='item_info'> &nbsp; &nbsp;  not available<br/><br/><br/></span></div>";    } else { ?>	
			  <a href="" onClick="javascript:this.style.display='inline';getElementById('desc<?= $pk ?>').style.display='inline';return false;" 
			title="Click to reveal the description">[ show ]</a> &nbsp; 
			<a href="" onClick="javascript:this.style.display='inline';getElementById('desc<?= $pk ?>').style.display='none';return false;" 
			title="Click to hide the description">[ hide ]</a> <br/></div>
			<div id='desc<?= $pk ?>' style='display:none;'><?= $item['desc'] ?></div>
		<br/>	
		<br/>
		<?php if ($item['type']!="paper") { ?>
     	<div class="description"><strong>Speaker Bio:</strong><br/> 
     	<?= $item['bio'] ?><br/><br/></div>
     	<?php }  ?>
     	
<?php } }?>
<div class="description"> 
	<?php	if ($item['type']!="paper") { ?>
		
		 <span style="padding-right: 20px;">
		 	<strong>Format: </strong><?= $item['type'] ?></span>
		 <span style="padding-right: 20px;" ><strong>Length:</strong>
<?php if ($item['approved']=='B') { 
		$item['length']="0"; 
		}
 if ($item['length']=='0') {  echo "n/a "; } //this is a demo with no time limit
	 		else { echo  $item['length'] ." min. "; 
} echo "</span>";
		}
		?>
	 <br/><br/><span style="padding-right: 20px;"><strong>Track:</strong>&nbsp;&nbsp;
	 <?php  if ($item['type']=="paper") {
	  if ($item['track']) {
			 	 echo $item['track'] ."<br/><br/>";
			 } else { 
			 	  echo "<span style='color: #666666;'>not set </span><br/><br/>";  
		
			 }
	 } else {
	 if ($item['track']) {
			 	 echo $item['track'];
			 }
			 else {
			  echo "<span style='color: #666666;'>not set </span><br/><br/>";  
			 } 
	
		?></span>
		
			 <span style="padding-right: 20px;"><strong>Sub Track:</strong>
	 <?php  
	 if ($item['sub_track']) {
			 	 echo $item['sub_track'];
			 }
			 else {
			  echo "<span style='color: #666666;'>not set </span>";  
			 } 
	 }
		
		?></span>
		
		<br/><br/><span style="padding-right: 20px;"><strong>Bundle Candidate?&nbsp;&nbsp;</strong>
	 <?php  //check to see if the proposal should be bundled with another proposal
	 if ($item['bundle']=='Y') {
			 	 echo "<span style='color: #666666;'>YES</span>";  
			 	
		
		 if ($item['bundle_id']) {
				$bundleArray = explode(":",trim($item['bundle_id']));
			if (is_array($bundleArray)) {
				echo "&nbsp;&nbsp;&nbsp;&nbsp;<strong>suggested proposals:</strong> "; 
			
		 	 foreach ($bundleArray as $value) {
				if ($value) {
			
			 	 echo "&nbsp; <span style='color:#333'>#</span><a href='#num$value'> $value </a>&nbsp; ";
					}
			 	 }
			 }
		 }
	 }
			 else {
			  echo "<span style='color: #666666;'>NO</span>";  
			 } 
	 
		
		?></span>
		
	    </div>
	 
	
	</td>	

	<?php // if topic or audience ranking is required
	 if ($RANKING){  ?>
		
	<td style="border-bottom:1px solid black;" rowspan="2" width="25%">
	<?php if ($item['type']=='demo') {  /* only non-demo types use the following data */ ?>
		n/a:  demo
	<?php } else if ($item['type']=='BOF') {  /* only non-demo types use the following data */ ?>
		n/a:  BOF
	<?php } else {

		if (is_array($item['topics'])) {
			echo "<br/><br/><br/><strong>Topic ranking:</strong><br/>";

			foreach($item['topics'] as $v) {
				 //only display those with value higher than 1
				 if ($v['choice'] == 3) { //high ranking
				 	echo "<div style=\"white-space: nowrap; color:#000;\">" . $v['topic_name'],$v['role_name']," </div>";
				 }
				 if ($v['choice'] == 2) { // medium ranking
				 	echo "<div style=\"white-space: nowrap; color: #666; \">" . $v['topic_name'],$v['role_name']," </div>"; 
				 }
			}
		}
		if (is_array($item['audiences'])) {
			echo "<br/><strong>Audience ranking:</strong><br/>"; 

			foreach($item['audiences'] as $v) {
				 //only display those with value higher than 1
				 if ($v['choice'] == 3) { //high ranking
				 	echo "<div style=\"white-space: nowrap; color:#000;\">" . $v['topic_name'],$v['role_name']," </div>";
				 }
				 if ($v['choice'] == 2) { // medium ranking
				 	echo "<div style=\"white-space: nowrap; color: #666; \">" . $v['topic_name'],$v['role_name']," </div>"; 
				 }
			}
		}
	}
?>
	</td>
	<?php } ?>

</tr>
<tr class="<?= $linestyle ?>" valign="top">
	<td colspan="4" style="border-bottom:1px solid black;border-right:1px dotted #999;border-top:1px dotted #999;border-left:1px dotted #999;">
		<div>
			<strong>Reviewer Comments</strong> (<?= count($item['comments']) ?>):
<?php if ($commenting)  { ?>
			<a id="onComment<?= $pk ?>" href="<?= $_SERVER['PHP_SELF'] ?>" onClick="showAddComment('<?= $pk ?>');return false;" title="Reveal a comment box so you can enter comments">Add Comment</a>
			<br/>
<?php } ?>

<?php
	if (!empty($item['comments'])) {
		$cline = 0;
		foreach($item['comments'] as $comment) {
			$cline++;
			$lineclass = "evenrow";
			if (($cline+($line % 2)) % 2 == 0) { $lineclass = "evenrow"; } else { $lineclass = "oddrow"; }

			$short_comment = $comment['comment_text'];
			if (strlen($short_comment) > 43) {
				$short_comment = substr($short_comment,0,40) . "...";
			}
			$short_username = $comment['username'];
			if (strlen($short_username) > 13) {
				$short_username = substr($short_username,0,10) . "...";
			}

			echo "<div style='width:100%;font-size:1em;' class='$lineclass'>\n" .
				"&nbsp;<label title='Entered by $comment[username] on " .
				date($DATE_FORMAT,strtotime($comment['date_created']))."' >&nbsp;</label>\n" .
				"<em><a href='mailto:$comment[email]'>$short_username</a></em>" .
				" - <label style='cursor:pointer;' title='Click to reveal the entire comment' " .
				"onClick=\"javascript:this.style.display='none';getElementById('fullcmnt$pk$cline').style.display='inline';\">$short_comment</label>\n" .
				"<div id='fullcmnt$pk$cline' style='display:none;'>$comment[comment_text]</div></div>";
		}
	}
?>
			<div id="addComment<?= $pk ?>" style="display:none;">
			<a href="<?= $_SERVER['PHP_SELF'] ?>" onClick="setAnchor('<?= $pk ?>');return false;" title="Save comments and any current votes" style="color:red;">Save New Comment</a><br/>
			<textarea name="cmnt<?= $pk ?>" cols="40" rows="3"></textarea>
			</div>
		</div>
	</td>
</tr>

<?php 	} /* export check */ ?>

<?php 
 } /* end the foreach loop */ ?>

<?php if (!$_REQUEST["export"]) { ?>
</table>

</form>
<a name="colorkey"> </a>
<div class="definitions">
	<div class="defheader">Color Key</div>
	<div style="padding:3px;">
		<b style="font-size:1.1em;">Key:</b> 
	<?php if($User->pk) { ?>
<!--		<div class="myvote" style='display:inline;'>&nbsp;Your vote&nbsp;</div>
		&nbsp;
		<div class="matchvote" style='display:inline;'><label title="Your vote matches the average">&nbsp;Your vote matches the average&nbsp;</label></div>
		&nbsp;    --> 
	<?php } ?> 
<!--		<div class="avgvote" style='display:inline;'>&nbsp;Average vote&nbsp;</div>  -->
		&nbsp;&nbsp; &nbsp;<div style='display:inline; padding-left:30px;'><strong>Status:&nbsp;&nbsp;</strong></div>
		<div class="unapproved" style='display:inline;'>&nbsp;Unapproved&nbsp;</div>
		&nbsp;
		<div class="approved" style='display:inline;'>&nbsp;Approved&nbsp;</div>
		&nbsp;
		<div class="pending" style='display:inline;'>&nbsp;Pending&nbsp;</div>
		&nbsp;
	
<?php if ($DEMO)	{ ?>
		<div class="demo" style='display:inline;'>&nbsp;Demo&nbsp;</div>
		&nbsp;   <?php } ?>
	&nbsp; &nbsp;<div style='display:inline; padding-left:30px;'><strong>Voting:&nbsp;&nbsp;</strong></div>	<div class="saved_green" style='display:inline;'>&nbsp;yes&nbsp;</div>
		&nbsp;
		<div class="saved_yellow" style='display:inline;'>&nbsp;maybe&nbsp;</div>
		&nbsp;
		<div class="saved_red" style='display:inline;'>&nbsp;no&nbsp;</div>
		&nbsp;	&nbsp;<div style='display:inline; padding-left:30px;'><strong>Not voted on:&nbsp;&nbsp;</strong></div>	
			<div  style='background:#eee; display:inline;'>&nbsp;no vote&nbsp;</div>
			&nbsp; 	<div  style='background:#ffffff; display:inline;'>&nbsp;no vote&nbsp;</div>
	</div>
</div>
</div>
<?php include $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>

<?php } /* export check */ ?>