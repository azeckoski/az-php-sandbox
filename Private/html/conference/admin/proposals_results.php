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
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = false; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("proposals_dec2006")) {
	$allowed = false;
	$Message = "Only admins with <b>admin_conference</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = true;
}
// this restricts the viewing by date
$viewing = false;
$EXTRA_LINKS .= "<div class='date_message'>";
if (strtotime($VOTE_CLOSE_DATE) < time()) {
	// Results viewable after close date
	$viewing = true;
	$EXTRA_LINKS .= "Voting closed " . date($SHORT_DATE_FORMAT,strtotime($VOTE_CLOSE_DATE));
} else {
	// no viewing allowed
	$viewing = false;
	$EXTRA_LINKS .= "Results visible after " . date($SHORT_DATE_FORMAT,strtotime($VOTE_CLOSE_DATE));
	$Message = "Results cannot be viewed until after " . date($DATE_FORMAT,strtotime($VOTE_CLOSE_DATE));
}
$EXTRA_LINKS .= "</div>";

// Do the export as requested by the user
if ($_REQUEST["export"] && $allowed && $viewing) {
	$date = date("Ymd-Hi",time());
	$filename = "proposal_results-" . $date . ".csv";
	header("Content-type: text/x-csv");
	header("Content-disposition: inline; filename=$filename\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0"); 
} else { 
	// display the page normally

// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
$CSS_FILE2 = "../include/proposals.css";

// set header links
$EXTRA_LINKS = 
	"<br/><span style='font-size:9pt;'>" .
	"<a href='index.php'>Admin:</a> " .
	"<a href='attendees.php'>Attendees</a> - " .
	"<a href='proposals.php'><strong>Proposals</strong></a> " .
		"(<em>" .
		"<a href='proposals.php'>Viewing / Voting</a> - " .
		"<a href='proposals_results.php'><strong>Results / Editing</strong></a>" .
		"</em>)" .
	"</span>";

?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript">
<!--
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
// -->
</script>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>

<?php include $TOOL_PATH.'include/admin_header.php'; ?>
<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		echo $Message;
		include $TOOL_PATH.'include/admin_footer.php';
		exit;
	}

} /* export check */

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

// Type Filter
$filter_type_default = "show all types";
$filter_type = "";
if ($_REQUEST["filter_type"] && (!$_REQUEST["clearall"]) ) { $filter_type = $_REQUEST["filter_type"]; }

$filter_type_sql = "";
if ($filter_type && ($filter_type != $filter_type_default)) {
	$filter_type_sql = " and type='$filter_type' ";
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
   	case "approved": $filter_status_sql = " and approved ='Y' "; break;
  	case "not approved": $filter_status_sql = " and approved ='N' "; break;
	case ""; // show all items
		$filter_status = $filter_status_default;
		$filter_status_sql = "";
		break;
}
// Track Filter
$filter_track_default = "show all tracks";
$filter_track = "";
if ($_REQUEST["filter_track"] && (!$_REQUEST["clearall"]) ) { $filter_track = $_REQUEST["filter_track"]; }

$special_filter = "";
$filter_track_sql = "";
switch ($filter_track){
   	case "Community": $filter_track_sql = " and track='Community' "; break;
  	case "Faculty": $filter_track_sql = " and track='Faculty' "; break;
 	case "Implementors": $filter_track_sql = " and track='Implementors' "; break;
 	case "Technology": $filter_track_sql = " and track='Technology' "; break;
 	case "Tool Overview": $filter_track_sql = " and track='Tool Overview' "; break;
  	case "Multiple Audiences": $filter_track_sql = " and track='Multiple Audiences' "; break;
 	case "BOF": $filter_track_sql = " and track='BOF' "; break;
 	case "Demo": $filter_track_sql = " and track='Demo' "; break;
	case "Poster": $filter_track_sql = " and track='Poster' "; break;
		case ""; // show all items
		$filter_track = $filter_track_default;
		$filter_track_sql = "";
		break;
}
  

// sorting
$sortorder = "date_created";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }
$sqlsorting = " order by $sortorder ";

// First get the list of proposals and related users for the current conf 
// (maybe limit this using a search later on)
$sql = "select U1.firstname, U1.lastname, U1.email, U1.institution, " .
	"U1.firstname||' '||U1.lastname as fullname, CV.vote, " .
	"CP.* from conf_proposals CP left join users U1 on U1.pk = CP.users_pk " .
	"left join conf_proposals_vote CV on CV.conf_proposals_pk = CP.pk " .
	"and CV.users_pk='$User->pk' " .
	"where CP.confID = '$CONF_ID'" . $sqlsearch . 
	$filter_type_sql . $filter_items_sql . $filter_status_sql . $filter_track_sql. $sqlsorting . $mysql_limit;

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

<?= $Message ?>

<?= $msg ?>



<form name="voteform" method="post" action="<?= $_SERVER['PHP_SELF'] ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>" />

<div style="background:#ECECEC;border:1px solid #ccc;padding:3px;margin-bottom:10px;">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
	<td nowrap="y" valign=top>
	<strong>Filters:</strong>&nbsp;&nbsp;
	</td>
	<td nowrap="y" style="font-size:0.9em;">
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
			<option value="not approved">not approved</option>
			<option value="show all status">show all status</option>
		</select>
		&nbsp;
		&nbsp;	
		<strong>Type:</strong>
		<select name="filter_type" title="Filter the items by type">
			<option value="<?= $filter_type ?>" selected><?= $filter_type ?></option>
	
			<option value="lecture">lecture</option>
			<option value="discussion">discussion</option>
			<option value="workshop">workshop</option>
			<option value="panel">panel</option>
			<option value="Tool Overview">Tool Overview</option>
			<option value="demo">demo</option>
			<option value="poster">poster</option>
			<option value="show all types">show all types</option>
		</select>
		&nbsp;
		&nbsp;
		<strong>Track:</strong>
		<select name="filter_track" title="Filter the items by track">
			<option value="<?= $filter_track ?>" selected><?= $filter_track ?></option>
			<option value="Community">Community</option>
			<option value="Faculty">Faculty</option>
			<option value="Implementors">Implementors</option>
			<option value="Technology">Technology</option>
			<option value="Tool Overview">Tool Overview</option>
			<option value="Multiple Audiences">Multiple Audiences</option>
			<option value="BOF">BOF</option>
			<option value="Demo">Demo</option>
			<option value="Poster">Poster</option>
			<option value="show all tracks">show all tracks</option>
		</select>
		
			&nbsp;
		
	    <input class="filter" type="submit" name="filter" value="Filter" title="Apply the current filter settings to the page">
		&nbsp;&nbsp;&nbsp; <?= count($items) ?> proposals shown<br/><br/>
		

		<input class="filter" type="submit" name="export" value="Export" title="Export results based on current filters">
		<input class="filter" type="submit" name="clearall" value="Clear Filters" title="Reset all filters" />
        <input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>"
        	length="20" title="Enter search text here" />
        <script type="text/javascript">document.voteform.searchtext.focus();</script>
        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements" />
	</td>
	</tr>
	</table>
</div>


<table id="proposals_vote" width="100%" cellspacing="0" cellpadding="0">

<tr class='tableheader'>
<td>&nbsp;<a href="javascript:orderBy('vote');">VOTE</a></td>
<td>&nbsp;</td>
<!-- <td width='10%'>&nbsp;<a href="javascript:orderBy('comment');">Comment</a></td>-->
<td><a href="javascript:orderBy('title');">Title</a>&nbsp;/&nbsp;<a href="javascript:orderBy('lastname');">Submitted&nbsp;by</a> </td>
<td>Abstract&nbsp;/&nbsp;Description&nbsp;/&nbsp;Speakers&nbsp;/&nbsp; <a href="javascript:orderBy('type');">Format</a>&nbsp;/&nbsp;<a href="javascript:orderBy('track');">Track</a></td>
<!-- <td width='49%'><a href="javascript:orderBy('type');">Format/Length</a> </td>-->
<td>Topic&nbsp;/&nbsp;Audience&nbsp;Rank</td>
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
	$checked[$item["Average"]] = " class='avgvote' ";
	// array_search(max($votes),$votes)

	// Added this in for special coloring
	$tdstyle = "";
	if ($vote >= 0) {
		// item has been voted on and saved
		if ($checked[$vote]) {
			$checked[$vote] = " class='matchvote' ";
		} else {
			$checked[$vote] = " class='myvote' ";
		}
		$tdstyle = " class='saved' ";
	}

	// this selects the background so that it highlights
	// red if there are any red votes, yellow if any yellows
	// if approved then the color is set to blue
	if ($item['type']=='demo'){
		$tdstyle = " class='demo' ";
	} else if ($item['type']=='BOF'){
		$tdstyle = " class='bof' ";
	} else if ($item['type']=='poster'){
		$tdstyle = " class='poster' ";
	} else  if ($item["approved"] == "Y") {
		$tdstyle = " class='approved' ";
	} else if ($item["red"]) {
		if ($item["approved"] == "N") {
			$tdstyle = " class='saved_red unapproved' ";
		} else {
			$tdstyle = " class='saved_red' ";
		}
	} else if ($item["yellow"]) {
		if ($item["approved"] == "N") {
			$tdstyle = " class='saved_yellow unapproved' ";
		} else {
			$tdstyle = " class='saved_yellow' ";
		}
	} else if ($item["green"]) {
		if ($item["approved"] == "N") {
			$tdstyle = " class='saved_green unapproved' ";
		} else {
			$tdstyle = " class='saved_green' ";
		}
	} else {
		$tdstyle = " class='saved' ";
	}

	if ($_REQUEST["export"]) {
		// print out EXPORT format instead of display
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
		print join(',', $item) . "\n";

		print "\n\"Exported on:\",\"" . date($DATE_FORMAT,time()) . "\"\n";
		print "\"Voting end date:\",\"" . date($DATE_FORMAT,strtotime($ROUND_END_DATE)) . "\"\n";		
	} else {
		// normal display
?>

<tr class="<?= $linestyle ?>" valign="top">
	<td <?= $tdstyle ?> nowrap='y' style="text-align:right;">
		<a name="anchor<?= $pk ?>"></a>
<?php if ($item['type']=='demo')  {
		echo "<strong>Demo:</strong><br/>No voting<br/>on demos, posters<br/> or BOFs";
	} else if ($item['type']=='poster')  {
		echo "<strong>Poster:</strong><br/>No voting<br/>on demos, posters<br/> or BOFs";
	} else if ($item['type']=='BOF')  {
		echo "<strong>BOF:</strong><br/>No voting<br/>on BOFs";
	} else  {
?>
<?php	for ($vi = 0; $vi < count($VOTE_TEXT); $vi++) { ?>
		<div <?= $checked[$vi] ?> >&nbsp;<label title="<?= $VOTE_HELP[$vi] ?>"><?= $VOTE_TEXT[$vi] ?></label>&nbsp;</div>
<?php	} ?>
		<div style='margin:6px;'></div>
		&nbsp;<label title="Total number of votes for this item">Total:</label>&nbsp;<br />
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
			<b><?= $total ?></b><br/>
			<div style="margin:12px;"></div>
		</div>
<?php } /* end demo check */ ?>
	</td>

	<td width="25%">
<?php
if (($item['type'] != 'demo') && ($item['type'] != 'BOF')){ 
	if ($item['approved'] == "Y") {
		echo "<div style='width:100%;background-color:blue;color:white;padding:2px;font-weight:bold;text-align:center;'>" .
				"APPROVED</div>";
	} else {
		echo "<div style='width:100%;background-color:red;color:white;padding:2px;font-weight:bold;text-align:center;'>" .
				"UNAPPROVED</div>";
	}
	echo "<div style='text-align:center;'>";
	
	//TODO  
	//provide a javascript or ajax warning for the delete link below  before
	//letting people use this feature
	
}
	?>
	<?php if ($User->checkPerm("admin_conference")) {
		
	 ?>	( <a href="<?= "edit_proposal.php?pk=$item[pk]&amp;edit=1&amp;location=0" ?>">edit</a>  )
	
	<?php  } ?>

		<!--	 | 
		 
	<a style="color:red;" href="edit_proposal.php?pk=<?= $item['pk'] ?>&amp;delete=1&amp;type=<?=$item['type']?>" 
			title="Delete this proposal"
			onClick="return confirm('Are you sure you want to delete this proposal?');" >delete</a> --> 
			</div>
	<?php
		
	echo "<div style='margin:6px;'></div>";

?>
		<div class="summary"><strong><?= $item['title'] ?></strong><br/><br/></div>
		<div>
			<strong>Submitted by:</strong> <a href="mailto:<?= $item['email'] ?>">	<?= $item['firstname']." ".$item['lastname'] ?></a><br/>
			<?= $printInst ?><br/><br /><strong>Date Submitted: </strong><br/>
			<?= date($MED_DATE_FORMAT,strtotime($item['date_created'])) ?><br/><br/>
		</div>		
	</td>

	<td style="border-bottom:1px solid black;" rowspan="2" width="40%">
	<div class="description"><strong>Speaker(s):</strong><br/><?= $item['speaker'] ?> 
	<?php if ($item['co_speaker']) {   echo "with " .$item['co_speaker'] ;      }
	?><br/><br/></div>
		<div class="description"><strong>Abstract:</strong><?php if (!$item['abstract']) { 
			  echo "not available";    }
	?><br/><?= $item['abstract'] ?><br/><br/></div>
		<?php if ($item['URL']) { /* a project URL was provided */
			echo"<div><strong>Project URL: </strong><a href=\"$url\"><img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 width=10px height=10px></a><br/><br/></div>";
		}
		
if (($item['type']!='demo') && ($item['type'] != 'BOF'))  { ?>
		<div class="description"><strong>Description:</strong>
			<a href="" onClick="javascript:this.style.display='inline';getElementById('desc<?= $pk ?>').style.display='inline';return false;" 
			title="Click to reveal the description">[ show ]</a> &nbsp; 
			<a href="" onClick="javascript:this.style.display='inline';getElementById('desc<?= $pk ?>').style.display='none';return false;" 
			title="Click to hide the description">[ hide ]</a> <br/>
			<div id='desc<?= $pk ?>' style='display:none;'><?= $item['desc'] ?></div>
		<br/>	
		<br/>
     	<div class="description"><strong>Speaker Bio:</strong><br/>
     	<?= $item['bio'] ?><br/><br/>
     	</div>
<?php } ?>

<?php if ($item['co_speaker'])  { ?>
		<div class="description"><strong>Co-Speaker:</strong><br/>
		<?= $item['co_speaker'] ?><br/><br/>
<?php } ?>
		<div class="description">
		 <span style="padding-right: 20px;">
		 	<strong>Format: </strong><?= $item['type'] ?></span>
		 <span style="padding-right: 20px;" ><strong>Length:</strong>
<?php if ($item['length']=='0') {  echo "n/a </span>"; } //this is a demo with no time limit
	 		else { echo  $item['length'] ." min. </span>"; 
} ?>

 
		 	
	 <span style="padding-right: 20px;"><strong>Track:</strong>
	 <?php  
	 if ($item['track']) {
			 	 echo $item['track'];
			 }
			 else {
			  echo "<span style='color: #666666;'>not set </span>";  
			 } 
			  if ($User->checkPerm("admin_conference")) {
		?>
	 (<a style="color:#336699;" href="<?= "edit_proposal.php" . "?pk=" . $item['pk'] . "&amp;edit=1" ."&amp;type=". $item['type'] ; ?>" >edit</a>)
		<?php	 }
		?>
	    </div>
	    <div>
	  <br>
	 
	  <?php if ($item['conflict']) {
	  	echo "<strong>Availability: </strong>  Can NOT present on "  ;
	  	?>
	  	<span style="color:red;"> <?= $item['conflict'] ?></span>
	  	
	  	<?php
	  } else {
	  	echo "  <strong>Availability:  </strong>   available all days";
	  }
	
	  ?>
	 
	    
	    </div>
	</td>	

	<td style="border-bottom:1px solid black;" rowspan="2" width="25%">
	<?php if ($item['type']=='demo') {  /* only non-demo types use the following data */ ?>
		n/a:  demo
	<?php } else if ($item['type']=='BOF') {  /* only non-demo types use the following data */ ?>
		n/a:  BOF
	<?php } else {

		if (is_array($item['topics'])) {
			echo "<strong>Topic ranking:</strong><br/>";

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

</tr>

<tr class="<?= $linestyle ?>" valign="top">
	<td colspan="3" style="border-bottom:1px solid black;border-right:1px dotted #999;border-top:1px dotted #999;border-left:1px dotted #999;">
		<div>
			Reviewer Comments (<?= count($item['comments']) ?>):
			<br/>
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

			echo "<div style='width:100%;font-size:8pt;' class='$lineclass'>\n" .
				"&nbsp;<label title='Entered by $comment[username] on " .
				date($DATE_FORMAT,strtotime($comment['date_created']))."'>\n" .
				"<em><a href='mailto:$comment[email]'>$short_username</a></em>" .
				" - <label style='cursor:pointer;' title='Click to reveal the entire comment' " .
				"onClick=\"javascript:this.style.display='none';getElementById('fullcmnt$pk$cline').style.display='inline';\">$short_comment</label>\n" .
				"<div id='fullcmnt$pk$cline' style='display:none;'>$comment[comment_text]</div></div>";
		}
	}
?>
		</div>
	</td>
</tr>

<?php 	} /* export check */ ?>

<?php } /* end the foreach loop */ ?>

<?php if (!$_REQUEST["export"]) { ?>
</table>

</form>

<div class="definitions">
	<div class="defheader">Color Key</div>
	<div style="padding:3px;">
		<b style="font-size:1.1em;">Key:</b> 
	<?php if($User->pk) { ?>
		<div class="myvote" style='display:inline;'>&nbsp;Your vote&nbsp;</div>
		&nbsp;
		<div class="matchvote" style='display:inline;'><label title="Your vote matches the average">&nbsp;Your vote matches the average&nbsp;</label></div>
		&nbsp;
	<?php } ?>
		<div class="avgvote" style='display:inline;'>&nbsp;Average vote&nbsp;</div>
		&nbsp;
		<div class="unapproved" style='display:inline;'>&nbsp;Unapproved&nbsp;</div>
		&nbsp;
		<div class="approved" style='display:inline;'>&nbsp;Approved&nbsp;</div>
		&nbsp;
		<div class="demo" style='display:inline;'>&nbsp;Demo&nbsp;</div>
		&nbsp;
		<div class="saved_green" style='display:inline;'>&nbsp;Green&nbsp;</div>
		&nbsp;
		<div class="saved_yellow" style='display:inline;'>&nbsp;Yellow&nbsp;</div>
		&nbsp;
		<div class="saved_red" style='display:inline;'>&nbsp;Red&nbsp;</div>
		&nbsp;
	</div>
</div>

<?php include $TOOL_PATH.'include/admin_footer.php'; // Include the FOOTER ?>

<?php } /* export check */ ?>