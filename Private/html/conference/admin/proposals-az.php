<?php
/* proposals.php
 * Created on Apr 6, 2006 by az - Aaron Zeckoski
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech 
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Proposals Voting and Viewing";
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
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}

// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
$CSS_FILE2 = "../include/proposals.css";

// set header links
$EXTRA_LINKS = 
	"<br/><span style='font-size:9pt;'>" .
	"<a href='index.php'>Admin:</a> " .
	"<a href='attendees.php'>Attendees</a> - " .
	"<a href='proposals.php'><strong>Proposals</strong></a> " .
	"</span>";


// this restricts the voting by date
$EXTRA_LINKS .= "<div class='date_message'>";
if (strtotime($VOTE_CLOSE_DATE) < time()) {
	// No one can access after the close date
	$allowed = false;
	$Message = "Voting closed on " . date($DATE_FORMAT,strtotime($VOTE_CLOSE_DATE));
	$EXTRA_LINKS .= "Voting closed " . date($SHORT_DATE_FORMAT,strtotime($VOTE_CLOSE_DATE));
} else if (strtotime($VOTE_OPEN_DATE) > time()) {
	// No access until voting opens
	$allowed = false;
	$Message = "Voting is not allowed until " . date($DATE_FORMAT,strtotime($VOTE_OPEN_DATE));
	$EXTRA_LINKS .= "Voting opens " . date($SHORT_DATE_FORMAT,strtotime($VOTE_OPEN_DATE));
} else {
	// open voting is allowed
	$allowed = true;
	$EXTRA_LINKS .= "Voting open from " . date($SHORT_DATE_FORMAT,strtotime($VOTE_OPEN_DATE)) .
		" to " . date($SHORT_DATE_FORMAT,strtotime($VOTE_CLOSE_DATE));
}
$EXTRA_LINKS .= "</div>";

?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<!-- <script type="text/javascript" src="/accounts/ajax/validate.js"></script> -->
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
            return i
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

	// Get current selection
	var rbuttons = document.getElementsByName('vr'+num);
	var curSelect = getSelectedRadio(rbuttons);

	// Compare values
	if (curVote >= 0) {
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


function setUnsaved(num) {
	var item = document.getElementById('vb'+num);
	item.className='unsaved';

	var sbutton = document.getElementById('vs'+num);
	sbutton.disabled=false;

	var cbutton = document.getElementById('vc'+num);
	cbutton.disabled=false;
}

function setSaved(num) {
	var item = document.getElementById('vb'+num);
	item.className='saved';

	var sbutton = document.getElementById('vs'+num);
	sbutton.disabled=true;

	var cbutton = document.getElementById('vc'+num);
	cbutton.disabled=true;
}

function setCleared(num) {
	// get current vote
	var voteItem = document.getElementById('vh'+num);
	var curVote = voteItem.value;

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
// -->
</script>
<?php include $TOOL_PATH.'include/admin_header.php'; ?>

<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $TOOL_PATH.'include/admin_footer.php';
		exit;
	} else {
?>

<?php
//processing the posted values for saving
$Keys = array();
$Keys = array_keys($_POST);
foreach( $Keys as $key)
{
	if (!$_POST[$key]) { continue; } // skip blank values

	$check = strpos($key,'vr');
	$check2 = strpos($key,'cmnt');
	if ( $check !== false && $check == 0 ) {
		$itemPk = substr($key, 2);
		$newVote = $_POST[$key];
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
		$comment = $_POST[$key];

		$insert_sql="insert into conf_proposals_comments " .
			"(users_pk,conf_proposals_pk,comment_text,confID) values " .
			"('$User->pk','$itemPk','$comment','$CONF_ID')";
		$result = mysql_query($insert_sql) or die("Query failed ($insert_sql): " . mysql_error());
	}
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
	"where CP.confID = '$CONF_ID'" . $sqlsorting;
	
print "SQL=$sql<br/>";
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

foreach ($items as $item) {
	// these add an array to each proposal item which contains the relevant topics/audiences
	$items[$item['pk']]['topics'] = $topics_items[$item['pk']];
	$items[$item['pk']]['audiences'] = $audience_items[$item['pk']];
}

//echo "<pre>",print_r($items),"</pre><br/>";

?>

<form name="voteform" method="post" action="<?= $_SERVER['PHP_SELF'] ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>" />

<table id="proposals_vote" width="100%" cellspacing="0" cellpadding="0">

<tr class='tableheader'>
<td>&nbsp;<a href="javascript:orderBy('vote');">VOTE</a></td>
<!-- <td width='10%'>&nbsp;<a href="javascript:orderBy('comment');">Comment</a></td>-->
<td><a href="javascript:orderBy('title');">Title</a>&nbsp;/&nbsp;<a href="javascript:orderBy('lastname');">Submitted&nbsp;by</a> </td>
<td>Abstract&nbsp;/&nbsp;Description&nbsp;/&nbsp;Speakers</td>
<!-- <td width='49%'><a href="javascript:orderBy('type');">Format/Length</a> </td>-->
<td>Topic&nbsp;/&nbsp;Audience&nbsp;Rank</td>
</tr>

<?php // now dump the data we currently have
$line = 0;

foreach ($items as $item) { // loop through all of the proposal items
	$line++;
	$pk = $item['pk'];
	$vote = $item['vote'];
	if ($item['type']=='demo'){
		$demo++;
	} else {
		$presentation++;
	}

	if (!isset($item['lastname'])) {
		$item['lastname'] = "<em>unknown user</em>";
	}

	$printInst = $item['institution'];
/***
 * 
 *	if (strlen($printInst) > 33) {
 *	$printInst = substr($printInst,0,30) . "...";
 *	}
***/

	$linestyle = "oddrow";
	if ($line % 2 == 0) {
		$linestyle = "evenrow";
	} else {
		$linestyle = "oddrow";
	}

	// voting check
	if (!isset($vote)) { $vote = -1; }
	$checked = array("","","","","");

	$tdstyle = "";
	if (isset($VOTE_SCORE[$vote])) {
		// item has been voted on and saved
		$checked[$VOTE_SCORE[$vote]] = " checked='y' ";
		$tdstyle = " class='saved' ";
	}
?>

<tr class="<?= $linestyle ?>" valign="top">
	<td id="vb<?= $pk ?>" <?= $tdstyle ?> nowrap='y' style='border-right:1px dotted #ccc;'>
		<a name="anchor<?= $pk ?>"></a>
<?php	for ($vi = 0; $vi < count($VOTE_TEXT); $vi++) { ?>
		<input id="vr<?= $pk ?>_<?= $vi ?>" name="vr<?= $pk ?>" type="radio" value="<?= $VOTE_SCORE[$vi] ?>" <?= $checked[$VOTE_SCORE[$vi]] ?> onClick="checkSaved('<?= $pk ?>')" title="<?= $VOTE_HELP[$vi] ?>" /><label for="vr<?= $pk ?>_<?= $vi ?>" title="<?= $VOTE_HELP[$vi] ?>"><?= $VOTE_TEXT[$vi] ?></label><br/>
<?php	} ?>
		<div style="margin:8px;"></div>
			
	
		<input id="vh<?= $pk ?>" type="hidden" name="cur<?= $pk ?>" value="<?= $VOTE_SCORE[$vote] ?>" />
		<input id="vc<?= $pk ?>"  class="button" type="button" value="Reset" onClick="setCleared('<?= $pk ?>')"
			disabled='y' title="Clear the radio buttons for this item or reset to the saved vote" />
		<input id="vs<?= $pk ?>"  class="button" type="submit" name="save" value="Save" onClick="setAnchor('<?= $pk ?>');this.disabled=true;return false;"
			disabled='y' title="Save all votes, votes cannot be removed once they are saved" />
	</td>

	<td>
		<div class="summary"><strong><?= $item['title'] ?></strong><br/><br/></div>
		<div nowrap='y'>
			<a href="mailto:<?= $item['email'] ?>">	<?= $item['firstname']." ".$item['lastname'] ?></a><br/>
			<?= $printInst ?><br/><br /><strong>Date Submitted: </strong><br/><?= $item['date_created'] ?><br/><br/>
		</div>		
	</td>

	<td style="border-bottom:1px solid black;" rowspan="2">
		<div class="description"><strong>Abstract:</strong><br/><?= $item['abstract'] ?><br/><br/></div>
		<?php if ($item['URL']) { /* a project URL was provided */
			echo"<div><strong>Project URL: </strong><a href=\"$url\"><img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 width=10px height=10px></a><br/><br/></div>";
		}
		
		if ($item['type']!='demo')  { ?>
			<div class="description"><strong>Speaker Bio:</strong><br/><?= $item['bio'] ?><br/><br/></div>
     	<?php } ?>
     	
		<div class="description"><strong>Co-Speaker:</strong><br/><?= $item['co_speaker'] ?><br/><br/>
		 <span style="padding-right: 20px;">	<strong>Format: </strong><?= $item['type'] ?></span>
		 <span style="padding-right: 20px;" ><strong>Length:</strong>
	 		<?php if ($item['length']=='0') {  echo "n/a<br/>"; } //this is a demo with no time limit
	 		else { echo  $item['length'] ." min. </span>"; 
			 }   ?>
	    </div>
	</td>	

	<td style="border-bottom:1px solid black;" rowspan="2">
	<?php if ($item['type']=='demo') {  /* only non-demo types use the following data */ ?>
		n/a:  demo
	<?php }else {
		$topic = 0; //start with the first array which is  topics ranking
		foreach($item as $key=>$value) {
			if (is_array($value)) {
				if ($topic=='0') {
					echo "<strong>Topic ranking: </strong><br/>"; 
					$topic++;  // next array is audience ranking 
				} else {
					echo "<br/><strong>Audience ranking: </strong><br/>"; 
				}

				foreach($value as $v) {
					 //only display those with value higher than 1
					 if ($v['choice'] == 3) { //high ranking
					 	echo "<div style=\"white-space: nowrap; color:#333;\">" . $v['topic_name'],$v['role_name']," </div>";
					 }
					 if ($v['choice'] == 2) { // medium ranking
					 	echo "<div style=\"white-space: nowrap; color: #999; \">" . $v['topic_name'],$v['role_name']," </div>"; 
					 }
				}
			}
		}
	}
?>
	</td>
</tr>

<tr class="<?= $linestyle ?>" valign="top">
	<td colspan="2" style="border-bottom:1px solid black;border-right:1px dotted #999;border-top:1px dotted #999;border-left:1px dotted #999;">
		<div>
			Reviewer Comments:
			<a href="<?= $_SERVER['PHP_SELF'] ?>" onClick="setAnchor('<?= $pk ?>');return false;" title="Save comments and any current votes">Save</a>
			<textarea name="cmnt<?= $pk ?>" cols="40" rows="3"></textarea>
		</div>
	</td>
</tr>

<?php } /* end the foreach loop */ ?>
</table>

</form>
<?php } ?>
<?php include $TOOL_PATH.'include/admin_footer.php'; // Include the FOOTER ?>