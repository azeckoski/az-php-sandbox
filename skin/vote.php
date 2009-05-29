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

// get the flipped array
$SCORE_VOTE = array_flip($VOTE_SCORE);

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

	//alert("vote: " + curVote + " selected: " + curSelect);

	// Compare values
	if (curVote >= 0 && curSelect != 2) {
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
	if (curVote < 0 || curVote == 2) {
		var item = document.getElementById('vb'+num);
		item.className='clear';

		var sbutton = document.getElementById('vs'+num);
		sbutton.disabled=true;
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
}


function checkSaved2(num) {
	// Get current vote for this item
	var voteItem = document.getElementById('vha'+num);
	var curVote = voteItem.value;
	if (curVote == "") { curVote = -1; }

	// Get current selection
	var rbuttons = document.getElementsByName('va'+num);
	var curSelect = getSelectedRadio(rbuttons);

	//alert("vote: " + curVote + " selected: " + curSelect);

	// Compare values
	if (curVote >= 0 && curSelect != 2) {
		if (curVote == curSelect) {
			setSaved2(num);
		} else {
			setUnsaved2(num);
		}
	} else {
		// no vote saved for this item
		setUnsaved2(num);
	}
}

function setSaved2(num) {
	var item = document.getElementById('vba'+num);
	item.className='saved'

	var sbutton = document.getElementById('vs'+num);
	sbutton.disabled=true;
}

function setCleared2(num) {
	// get current vote
	var voteItem = document.getElementById('vha'+num);
	var curVote = voteItem.value;
	if (curVote == "") { curVote = -1; }

	// reset radio buttons
	var rbuttons = document.getElementsByName('va'+num);
	for (i=0;i<rbuttons.length;i++) {
		rbuttons[i].checked=false;
		if (i == curVote) {
			rbuttons[i].checked=true;
		}
	}

	// reset style if not returning to saved vote
	if (curVote < 0 || curVote == 2) {
		var item = document.getElementById('vba'+num);
		item.className='clear';

		var sbutton = document.getElementById('vs'+num);
		sbutton.disabled=true;
	} else {
		// reset to saved value
		setSaved2(num);
	}
}

function setUnsaved2(num) {
	var item = document.getElementById('vba'+num);
	item.className='unsaved';

	var sbutton = document.getElementById('vs'+num);
	sbutton.disabled=false;
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

	$checkU = strpos($key,'vr');
	if ( $checkU !== false && $checkU == 0 ) {
		$itemPk = substr($key, 2);
		$newUsabilityVote = mysql_real_escape_string($_POST[$key]);
		$newAstheticVote = mysql_real_escape_string($_POST["va".$itemPk]);
		//print "<br/>key=$key : item_pk=$itemPk : voteU=$newUsabilityVote : voteA=$newAstheticVote <br/>";

		// Check to see if this vote already exists
		$check_exists_sql="select pk, vote_usability, vote_asthetic from skin_vote where " .
			"users_pk='$User->pk' and skin_entries_pk='$itemPk'";
		$result = mysql_query($check_exists_sql) or die("Query failed ($check_exists_sql): " . mysql_error());

		if ($result && (mysql_num_rows($result) > 0) ) {
			$row = mysql_fetch_assoc($result);
			$existingUsabilityVote = $row['vote_usability'];
			$existingAstheticVote = $row['vote_asthetic'];
			$votePk = $row['pk'];

			// purge this vote if both votes are 0
			if ($newUsabilityVote == '0' && $newAstheticVote == '0') {
				$remove_sql="delete from skin_vote where pk='$votePk'";
				$result = mysql_query($remove_sql) or die("Query failed ($remove_sql): " . mysql_error());
				continue;
			}

			// vote exists, now see if it changed
			if ($newUsabilityVote == $existingUsabilityVote && 
				$newAstheticVote == $existingAstheticVote) {
				// vote not changed so continue
				//print "vote not changed: $votePk : $existingVote <br/>";
				continue;
			} else {
				// vote changed so write update
				//print "vote changed: $votePk : $existingVote <br/>";
				$update_vote_sql="update skin_vote set " .
						"vote_usability='$newUsabilityVote', " .
						"vote_asthetic='$newAstheticVote'" .
						"where pk='$votePk'";
				$result = mysql_query($update_vote_sql) or die("Query failed ($update_vote_sql): " . mysql_error());
			}

		} else {
			// vote does not exist, insert it if the values are not both 0
			//print "New vote: $User->pk : $item_pk : $value <br/>";
			if ($newUsabilityVote == '0' && $newAstheticVote == '0') { continue; }

			$insert_vote_sql="insert into skin_vote " .
				"(users_pk,skin_entries_pk,vote_usability,vote_asthetic,round) values " .
				"('$User->pk','$itemPk','$newUsabilityVote','$newAstheticVote','$ROUND')";
			$result = mysql_query($insert_vote_sql) or die("Query failed ($insert_vote_sql): " . mysql_error());
		}
	}
}




// get the search
$searchtext = "";
if ($_REQUEST["searchtext"] && (!$_REQUEST["clearall"]) ) { $searchtext = $_REQUEST["searchtext"]; }
$sqlsearch = "";
if ($searchtext) {
	$sqlsearch = " and (title like '%$searchtext%' " .
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
<?php if ($item['url']) { ?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a style="text-decoration:underline;" href="<?= $item['url'] ?>">View skin in action</a>
<?php } ?>
<?php if ($item['allow_download'] == 'Y') { ?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a style="text-decoration:underline;" href="include/getFile.php?pk=<?= $item['skin_zip'] ?>">Download skin</a>
<?php } ?>
		</div>
	</td>
</tr>

<tr class="<?= $linestyle ?>" valign="top">
	<td>
		<div style="margin:3px;">
			<strong style="font-size:.9em;">Description:</strong>
			<span style="font-size:.8em;">
				<?= nl2br($item['description']) ?>
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
			(<a style="text-decoration:underline;font-size:.9em;" href="http://bugs.sakaiproject.org/confluence/x/kDQ" target="new">suggested criteria</a>)
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
			<div id="vba<?= $pk ?>" style="padding:3px;" <?= $style2 ?> >
				<?= $VOTE_TEXT[0] ?>
<?php	for ($vi = 0; $vi < count($VOTE_TEXT); $vi++) { ?>
			<label title="<?= $VOTE_HELP2[$vi] ?>">
				<input <?= $vote_disable ?> id="va<?= $pk ?>_<?= $vi ?>" name="va<?= $pk ?>" type="radio" value="<?= $VOTE_SCORE[$vi] ?>" <?= $checked2[$vi] ?> onClick="checkSaved2('<?= $pk ?>')" />
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
		<input id="vha<?= $pk ?>" type="hidden" name="cura<?= $pk ?>" value="<?= $SCORE_VOTE[$vote2] ?>" />
	</td>
</tr>

<tr class="<?= $linestyle ?>" valign="top">
	<td colspan="3" style="padding:4px;font-size:.9em;">
		<div style="display:inline;float:left;padding:3px;">
			<strong>Portal screenshot</strong><br/>
			<a href="include/drawImage.php?pk=<?= $item['image1'] ?>" target="new">
				<img src="include/drawThumb.php?pk=<?= $item['image1'] ?>" alt="Portal image" />
			</a>
		</div>

		<div style="display:inline;float:left;padding:3px;">
			<strong>Workspace screenshot</strong><br/>
			<a href="include/drawImage.php?pk=<?= $item['image2'] ?>" target="new">
				<img src="include/drawThumb.php?pk=<?= $item['image2'] ?>" alt="Workspace image" />
			</a>
		</div>

		<div style="display:inline;float:left;padding:3px;">
			<strong>Resources screenshot</strong><br/>
			<a href="include/drawImage.php?pk=<?= $item['image3'] ?>" target="new">
				<img src="include/drawThumb.php?pk=<?= $item['image3'] ?>" alt="Resources image" />
			</a>
		</div>

		<div style="display:inline;float:left;padding:3px;">
			<strong>Gradebook screenshot</strong><br/>
			<a href="include/drawImage.php?pk=<?= $item['image4'] ?>" target="new">
				<img src="include/drawThumb.php?pk=<?= $item['image4'] ?>" alt="Gradebook image" />
			</a>
		</div>
	</td>
</tr>

<?php } /* end the foreach loop */ ?>
</table>

</form>
<?php } ?>
<?php include $TOOL_PATH.'include/footer.php'; // Include the FOOTER ?>