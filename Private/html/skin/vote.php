<?php
/*
 * file: vote2.php
 * Created on Apr 26, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Default Skin Voting";
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';


// this restricts the voting by date
$voting = false;
$EXTRA_LINKS .= "<div class='date_message'>";
if (strtotime($ROUND_END_DATE) < time()) {
	// No one can access after the close date
	$voting = false;
	$Message = "Voting closed on " . date($DATE_FORMAT,strtotime($ROUND_END_DATE));
	$EXTRA_LINKS .= "Voting closed " . date($SHORT_DATE_FORMAT,strtotime($ROUND_END_DATE));
} else if (strtotime($ROUND_VOTE_DATE) > time()) {
	// No access until voting opens
	$voting = false;
	$Message = "Voting is not allowed until " . date($DATE_FORMAT,strtotime($ROUND_VOTE_DATE));
	$EXTRA_LINKS .= "Voting opens " . date($SHORT_DATE_FORMAT,strtotime($ROUND_VOTE_DATE));
} else {
	// open voting is allowed
	$voting = true;
	$EXTRA_LINKS .= "Voting open from " . date($SHORT_DATE_FORMAT,strtotime($ROUND_VOTE_DATE)) .
		" to " . date($SHORT_DATE_FORMAT,strtotime($ROUND_END_DATE));
}
$EXTRA_LINKS .= "</div>";

if ($User->checkPerm("admin_skin")) {
	$voting = true;
}
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

// These are the voting functions
function setAnchor(num) {

	document.voteform.action += "#anchor"+num;
	document.voteform.submit();
	return false;
}

function getSelectedRadio(buttonGroup) {
   // returns the array number of the selected radio button or -1 if no button is selected
   if (buttonGroup[0]) { // if the button group is an array (one button is not an array)
      for (var i=0; i<buttonGroup.length; i++) {
         if (buttonGroup[i].checked) {
            return i;
         }
      }
   } else {
      if (buttonGroup.checked) { return 0; } // if the one button is checked, return zero
   }
   // if we get to this point, no radio button is selected
   return -1;
}

function checkSaved(num) {
	// Get current vote for this item
	var voteItem = document.getElementById('vh'+num);
	var curVote = voteItem.value;
	if (curVote == "") { curVote = -1; }

	// Get current selection
	var rbuttons = document.getElementsByName('vr'+num);
	var curSelect = getSelectedRadio(rbuttons);

	// Compare values
	if (curVote >= 0 && curSelect >= 0) {
		if (curVote == curSelect) {
			setSaved(num);
		} else {
			setUnsaved(num);
		}
	} else {
		// no vote saved for this item
		setUnsaved(num);
	}
}

function setSaved(num) {
	var item = document.getElementById('vb'+num);
	item.className='saved'

	var sbutton = document.getElementById('vs'+num);
	sbutton.disabled=true;

	var cbutton = document.getElementById('vc'+num);
	cbutton.disabled=true;
}

function setCleared(num) {
	// get current vote
	var voteItem = document.getElementById('vh'+num);
	var curVote = voteItem.value;
	if (curVote == "") { curVote = -1; }

	// reset radio buttons
	var rbuttons = document.getElementsByName('vr'+num);
	for (i=0;i<rbuttons.length;i++) {
		rbuttons[i].checked=false;
		if (i == curVote) {
			rbuttons[i].checked=true;
		}
	}

	// reset style if not returning to saved vote
	if (curVote < 0) {
		var item = document.getElementById('vb'+num);
		item.className='clear';

		var sbutton = document.getElementById('vs'+num);
		sbutton.disabled=true;

		var cbutton = document.getElementById('vc'+num);
		cbutton.disabled=true;
	} else {
		// reset to saved value
		setSaved(num);
	}
}

function setUnsaved(num) {
	var item = document.getElementById('vb'+num);
	item.className='unsaved';

	var sbutton = document.getElementById('vs'+num);
	sbutton.disabled=false;

	var cbutton = document.getElementById('vc'+num);
	cbutton.disabled=false;
}

// -->
</script>
<?php include $TOOL_PATH.'include/header.php'; ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$voting) {
		include $TOOL_PATH.'include/footer.php';
		exit;
	} else {
?>

<?php
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

// sorting
$sortorder = "date_created";
if ($_REQUEST["sortorder"]) { $sortorder = $_REQUEST["sortorder"]; }
$sqlsorting = " order by $sortorder ";

// First get the list of items
$sql = "select U1.firstname, U1.lastname, U1.email, U1.institution, " .
	"U1.firstname||' '||U1.lastname as fullname, SV.vote_asthetic, SV.vote_usability, " .
	"SE.* from skin_entries SE left join users U1 on U1.pk = SE.users_pk " .
	"left join skin_vote SV on SV.skin_entries_pk = SE.pk and SV.users_pk='$User->pk' " .
	"where approved='Y' " . 
	$sqlsearch . $filter_type_sql . $filter_items_sql . $sqlsorting . $mysql_limit;

//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$items = array();

// put all of the query results into an array first
while($row=mysql_fetch_assoc($result)) { $items[$row['pk']] = $row; }

// now bring in the comments - TODO
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

?>

<form name="voteform" method="post" action="<?= $_SERVER['PHP_SELF'] ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>" />


<div style="background:#ECECEC;border:1px solid #ccc;padding:3px;margin-bottom:10px;">
	<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
	<td nowrap="y" style="font-size:0.9em;">
		<strong>View votes:</strong>
		<select name="filter_items" title="Filter the items by my votes">
			<option value="<?= $filter_items ?>" selected><?= $filter_items ?></option>
			<option value="show all items">show all items</option>
			<option value="show my voted items">show my voted items</option>
			<option value="show my unvoted items">show my unvoted items</option>
		</select>
		&nbsp;
	    <input class="filter" type="submit" name="filter" value="View" title="Apply the current filter settings to the page">
		&nbsp;&nbsp;&nbsp;
		<?= count($items) ?> entries shown
	</td>

	<td nowrap="y" align="right">
		<input class="filter" type="submit" name="clearall" value="Clear Filters" title="Reset all filters" />
        <input class="filter" type="text" name="searchtext" value="<?= $searchtext ?>"
        	length="20" title="Enter search text here" />
        <script type="text/javascript">document.voteform.searchtext.focus();</script>
        <input class="filter" type="submit" name="search" value="Search" title="Search the requirements" />
	</td>
	</tr>
	</table>
</div>


<table width="100%" cellspacing="0" cellpadding="0">

<!--
<tr class='tableheader'>
<td>&nbsp;<a href="javascript:orderBy('vote');">VOTE</a></td>
<td><a href="javascript:orderBy('title');">Title</a></td>
<td>Description</td>
</tr>
-->

<?php // now dump the data we currently have
$line = 0;
foreach ($items as $item) { // loop through all of the proposal items
	$line++;

	$pk = $item['pk'];
	$vote1 = $item['vote_usability'];
	$vote2 = $item['vote_asthetic'];

	$linestyle = "oddrow";
	if (($line % 2) == 0) { $linestyle = "evenrow"; } else { $linestyle = "oddrow"; }

	// voting check
	$SCORE_VOTE = array_flip($VOTE_SCORE);

	if (!$vote1) { $vote1 = "0"; }
	$checked = array();
	$style1 = "";
	if (isset($SCORE_VOTE[$vote1])) {
		// item has been voted on and saved
		$checked[$SCORE_VOTE[$vote1]] = " checked='y' ";
		if ($vote1 != 0)
			$style1 = " class='saved' ";
	}

	if (!$vote2) { $vote2 = "0"; }
	$checked2 = array();
	$style2 = "";
	if (isset($SCORE_VOTE[$vote2])) {
		// item has been voted on and saved
		$checked2[$SCORE_VOTE[$vote2]] = " checked='y' ";
		if ($vote2 != 0)
			$style2 = " class='saved' ";
	}

	$vote_disable = "";
	if (!$voting) {
		$vote_disable = "disabled='y'";
	}
?>

<tr class="tableheader" valign="top">
	<td>
		<div style="margin:3px;">
			<a href="javascript:orderBy('title');">Title</a>:
			<strong><?= $item['title'] ?></strong>
			&nbsp;&nbsp;
			<a style="text-decoration:underline;" href="<?= $item['url'] ?>">View skin in action</a>
		</div>
	</td>

<tr class="<?= $linestyle ?>" valign="top">
	<td>
		<div style="margin:3px;">
			<strong style="font-size:.9em;">Description:</strong>
			<span style="font-size:.8em;">
				<?= $item['description'] ?>
			</span>
		</div>
	</td>
</tr>

<tr class="<?= $linestyle ?>" valign="top">
	<td width="34%" nowrap='y' style='border:1px dotted #ccc;;'>
		<a name="anchor<?= $pk ?>"></a>

		<table width="70%">
		<tr>
		<td nowrap="y" width="10%">
			<strong>Usability</strong>
			(<a style="text-decoration:underline;font-size:.9em;" href="" target="new">suggested criteria</a>)
			&nbsp;&nbsp;
		</td>
		<td nowrap="y" width="50%">
			<div id="vb<?= $pk ?>" style="padding:3px;" <?= $style1 ?> >
				<?= $VOTE_TEXT[0] ?>
<?php	for ($vi = 0; $vi < count($VOTE_TEXT); $vi++) { ?>
				<label title="<?= $VOTE_HELP1[$vi] ?>">
					<input <?= $vote_disable ?> id="vr<?= $pk ?>_<?= $vi ?>" name="vr<?= $pk ?>" type="radio" value="<?= $VOTE_SCORE[$vi] ?>" <?= $checked[$vi] ?> onClick="checkSaved('<?= $pk ?>')" />
				</label>
<?php	} ?>
				<?= $VOTE_TEXT[count($VOTE_TEXT)-1] ?>
			</div>
		</td>
		<td nowrap="y" width="10%"></td>
		</tr>

		<tr>
		<td nowrap="y">
			<strong>Asthetic Appeal</strong>
		</td>
		<td nowrap="y">
			<div id="vb2<?= $pk ?>" style="padding:3px;" <?= $style2 ?> >
				<?= $VOTE_TEXT[0] ?>
<?php	for ($vi = 0; $vi < count($VOTE_TEXT); $vi++) { ?>
			<label title="<?= $VOTE_HELP2[$vi] ?>">
				<input <?= $vote_disable ?> id="vr2<?= $pk ?>_<?= $vi ?>" name="vr2<?= $pk ?>" type="radio" value="<?= $VOTE_SCORE[$vi] ?>" <?= $checked2[$vi] ?> onClick="checkSaved('<?= $pk ?>')" />
			</label>
<?php	} ?>
				<?= $VOTE_TEXT[count($VOTE_TEXT)-1] ?>
			</div>
		</td>
		<td nowrap="y" width="10%">
			<input id="vs<?= $pk ?>"  class="button" type="submit" name="save" value="Save Votes" onClick="setAnchor('<?= $pk ?>');this.disabled=true;return false;"
				disabled='y' title="Save all votes, votes cannot be removed once they are saved" />
		</td>
		</tr>
		</table>

		<input id="vh<?= $pk ?>" type="hidden" name="cur<?= $pk ?>" value="<?= $SCORE_VOTE[$vote1] ?>" />
		<input id="vh2<?= $pk ?>" type="hidden" name="cur<?= $pk ?>" value="<?= $SCORE_VOTE[$vote2] ?>" />
	</td>
</tr>

<tr class="<?= $linestyle ?>" valign="top">
	<td colspan="3" style="padding:4px;font-size:.9em;">
		<div style="display:inline;float:left;padding:3px;">
			<strong>Portal screenshot</strong><br/>
			<a href="include/drawImage.php?pk=<?= $item['image1'] ?>" target="_new">
				<img src="include/drawThumb.php?pk=<?= $item['image1'] ?>" alt="Portal image" />
			</a>
		</div>

		<div style="display:inline;float:left;padding:3px;">
			<strong>Workspace screenshot</strong><br/>
			<a href="include/drawImage.php?pk=<?= $item['image2'] ?>" target="_new">
				<img src="include/drawThumb.php?pk=<?= $item['image2'] ?>" alt="Workspace image" />
			</a>
		</div>

		<div style="display:inline;float:left;padding:3px;">
			<strong>Resources screenshot</strong><br/>
			<a href="include/drawImage.php?pk=<?= $item['image3'] ?>" target="_new">
				<img src="include/drawThumb.php?pk=<?= $item['image3'] ?>" alt="Resources image" />
			</a>
		</div>

		<div style="display:inline;float:left;padding:3px;">
			<strong>Gradebook screenshot</strong><br/>
			<a href="include/drawImage.php?pk=<?= $item['image4'] ?>" target="_new">
				<img src="include/drawThumb.php?pk=<?= $item['image4'] ?>" alt="Gradebook image" />
			</a>
		</div>
	</td>
</tr>

<tr class="<?= $linestyle ?>" valign="top">
	<td colspan="3" style="border-bottom:1px solid black;border-right:1px dotted #999;border-top:1px dotted #999;border-left:1px dotted #999;">
		<div style="font-size:10pt;">
			Comments (<?= count($item['comments']) ?>):
			<a id="onComment<?= $pk ?>" href="<?= $_SERVER['PHP_SELF'] ?>" onClick="showAddComment('<?= $pk ?>');return false;" title="Reveal a comment box so you can enter comments">Add Comment</a>
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

			echo "<div style='width:100%;font-size:9pt;' class='$lineclass'>\n" .
				"&nbsp;<label title='Entered by $comment[username] on " .
				date($DATE_FORMAT,strtotime($comment['date_created']))."'>\n" .
				"<em><a href='mailto:$comment[email]'>$short_username</a></em>" .
				" - <label style='cursor:pointer;' title='Click to reveal the entire comment' " .
				"onClick=\"javascript:this.style.display='none';getElementById('fullcmnt$pk$cline').style.display='inline';\">$short_comment</label>\n" .
				"<div id='fullcmnt$pk$cline' style='display:none;'>$comment[comment_text]</div></div>";
		}
	}
?>
			<div id="addComment<?= $pk ?>" style="display:none;">
			<a href="<?= $_SERVER['PHP_SELF'] ?>" onClick="setAnchor('<?= $pk ?>');return false;" title="Save comments and any current votes">Save New Comment</a><br/>
			<textarea name="cmnt<?= $pk ?>" cols="80" rows="3"></textarea>
			</div>
		</div>
	</td>
</tr>

<?php } /* end the foreach loop */ ?>
</table>

</form>
<?php } ?>
<?php include $TOOL_PATH.'include/footer.php'; // Include the FOOTER ?>