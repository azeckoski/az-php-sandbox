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
	curSelect = 3 - curSelect; // make it line up with the radio buttons

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
		if (i == (3 - curVote)) {
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
	$check = strpos($key,'vr');
	if ( $check !== false && $check == 0 ) {
		$itemPk = substr($key, 2);
		$newVote = $_POST[$key];
		//print "key=$key : item_pk=$item_pk : value=$value <br/>";

		// Check to see if this vote already exists
		$check_exists_sql="select pk, vote from conf_proposals_vote where " .
			"users_pk='$User->pk' and conf_proposals_pk='$itemPk'" . $rep_sql;
		$result = mysql_query($check_exists_sql) or die('Query failed: ' . mysql_error());

		$writeScore = 0;
		if ($result && (mysql_num_rows($result) > 0) ) {
			$row = mysql_fetch_assoc($result);
			$existingVote = $row["vote"];
			$votePk = $row["pk"];

			// vote exists, now see if it changed
			if ($newVote == $existingVote) {
				// vote not changed so continue
				//print "vote not changed: $existingPk : $existingVote <br/>";
				continue;
			} else {
				// vote changed so write update
				$update_vote_sql="update conf_proposals_vote set vote='$newVote' where pk='$votePk'";
				$result = mysql_query($update_vote_sql) or die('Query failed: ' . mysql_error());
				mysql_free_result($result);
			}

		} else {
			// vote does not exist, insert it
			//print "New vote: $User->pk : $item_pk : $value <br/>";
			$insert_vote_sql="insert into conf_proposals_vote (users_pk,conf_proposals_pk,vote,confID) values " .
				"('$User->pk','$itemPk','$newVote','$CONF_ID')";
			$result = mysql_query($insert_vote_sql) or die('Query failed: ' . mysql_error());
		}
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
	
	
//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$items = array();

// put all of the query results into an array first
while($row=mysql_fetch_assoc($result)) { $items[$row['pk']] = $row; }

// add in the audiences and topics of that nature (should require 2 more queries)
$sql = "select PA.pk, PA.proposals_pk, R.role_name, PA.choice from proposals_audiences PA " .
	"join conf_proposals CP on CP.pk = PA.proposals_pk and confID='$CONF_ID' " .
	"join roles R on R.pk = PA.roles_pk";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$audience_items = array();
while($row=mysql_fetch_assoc($result)) {
	$audience_items[$row['proposals_pk']][$row['pk']] = $row;
}

$sql = "select PT.pk, PT.proposals_pk, T.topic_name, PT.choice from proposals_topics PT " .
	"join conf_proposals CP on CP.pk = PT.proposals_pk and confID='$CONF_ID' " .
	"join topics T on T.pk = PT.topics_pk";
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

<table id="proposals_vote" width="100%" cellspacing="0" cellpadding="3">

<tr class='tableheader'>
<td width='10%'>&nbsp;<a href="javascript:orderBy('vote');">VOTE</a></td>
<td width='10%'>&nbsp;<a href="javascript:orderBy('comment');">Comment</a></td>
<td width='10%' align="center"><a href="javascript:orderBy('title');">Title</a> /<a href="javascript:orderBy('lastname');">Submitted by</a> </td>
<td width='49%'>Abstract-Descript.-Speakers</td>
<td width='49%'><a href="javascript:orderBy('type');">Format/Length</a> </td>
<td width='49%'>Topic/Audience Rank</td>
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
	if ($vote < 0) {
		// item has not been voted on and saved
	} else {
		// item has been voted on and saved
		$checked[$vote] = " checked ";
		$tdstyle = " class='saved' ";
	}
?>

<tr class="<?= $linestyle ?>" valign="top">
	<td id="vb<?= $pk ?>" <?= $tdstyle ?> nowrap='y' style='border-right:1px dotted #ccc;border-bottom:1px solid black;'>
		<a name="anchor<?= $pk ?>"></a>
<?php	for ($vi = count($VOTE_TEXT)-1; $vi >= 0; $vi--) { ?>
		<input id="vr<?= $pk ?>_<?= $vi ?>" name="vr<?= $pk ?>" type="radio" value="<?= $vi ?>" <?= $checked[$vi] ?> onClick="checkSaved('<?= $pk ?>')" title="<?= $VOTE_HELP[$vi] ?>" /><label for="vr<?= $pk ?>_<?= $vi ?>" title="<?= $VOTE_HELP[$vi] ?>"><?= $VOTE_TEXT[$vi] ?></label><br />
<?php	} ?>
		<div style="margin:8px;"></div>
		<input id="vh<?= $pk ?>" type="hidden" name="cur<?= $pk ?>" value="<?= $vote ?>" />
		<input id="vc<?= $pk ?>"  class="button" type="button" value="Reset" onClick="setCleared('<?= $pk ?>')"
			disabled='y' title="Clear the radio buttons for this item or reset to the saved vote" />
		<input id="vs<?= $pk ?>"  class="button" type="submit" name="save" value="Save" onClick="setAnchor('<?= $pk ?>');this.disabled=true;return false;"
			disabled='y' title="Save all votes, votes cannot be removed once they are saved" />
	</td>
	
<td style="padding-right:10px; border-right:1px dotted #ccc; border-bottom:1px solid black;">
<textarea name="comments" cols="25" rows="6">add comments....</textarea>

</td>

	<td style="border-bottom:1px solid black;">
	<div class="summary"><strong><?= $item['title'] ?></strong><br/><br/></div>
	<div nowrap='y'>	<?= $item['firstname']." ".$item['lastname'] ?><br/>
		<span style="font-size:10pt;">
			<a href="mailto:<?= $item['email'] ?>"><?= $item['email'] ?></a>
		</span><br/>
		<span><br/><?= $printInst ?></span><br/></div>
			<strong>Format: </strong><br/><?= $item['type'] ?><br/><br/>
	<strong>Length:</strong><br/>
	 <?php if ($item['length']=='0') {  echo "n/a<br/>"; } //this is a demo with no time limit
	 else { echo  $item['type'] ." min.<br/>"; 
	 }   ?>
	<br/><strong>Date Submitted: </strong><?= $item['date_created'] ?>
		
		
	</td>



	<td style="border-bottom:1px solid black;">
		<div class="description"><strong>Abstract:</strong><br/><?= $item['abstract'] ?><br/><br/></div>
	
	<?php
	if ($item['URL']) { //a project URL was provided
	echo"<div><strong>Project URL: </strong><a href=\"$url\"><img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 width=10px height=10px></a><br/><br/></div>";
	}
	 if ($item['type']!='demo')  {  ?>
		<div class="description"><strong>Speaker Bio:</strong><br/><?= $item['bio'] ?><br/><br/></div>
     <?php } ?>
		<div class="description"><strong>Co-Speaker:</strong><br/><?= $item['co_speaker'] ?><br/><br/></div>
	</td>	
	

	
	
<?php if ($item['type']=='demo')  //only non-demo types use the following data
	{ 
	?>
	<td style="border-bottom:1px solid black;">n/a:  demo</td>
   <?php
	}else{	echo "<td style=\"border-bottom:1px solid black;\" >";
		$topic = 0; //start with the first array which is  topics ranking
		
		foreach($item as $key=>$value) {
			
		if (is_array($value)) {
	
		if ($topic=='0') {
			 echo "<strong>Topic ranking: </strong><br/>"; 
			 $topic++;  // next array is audience ranking 
		}
		else { echo "<br/><strong>Audience ranking: </strong><br/>"; }
			
			foreach($value as $v) { 
				
				if ($v['choice'] > 1) { //only display those with value higher than 1
					echo "<div style=\"white-space: nowrap; \">" . $v['topic_name'],$v['role_name']," (",$v['choice'],")</div>"; 
				}

				}
			
		 }
}
	echo "</td>";}
?>
</tr>

<?php } /* end the foreach loop */ ?>
</table>

</form>
<?php } ?>
<?php include $TOOL_PATH.'include/admin_footer.php'; // Include the FOOTER ?>