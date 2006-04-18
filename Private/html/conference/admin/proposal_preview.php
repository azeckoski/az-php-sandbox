<?php
/* proposals_preview.php   
 * for viewing full proposal details during voting
 * Created on Apr 6, 2006 by az - Aaron Zeckoski
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech 
 * 
 */
?>
<?php


$PK=$_REQUEST['pk'];
//echo $PK;

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

// First get the list of proposals and related users for the current conf 
// (maybe limit this using a search later on)
$sql = "select U1.firstname, U1.lastname, U1.email, U1.institution, " .
	"U1.firstname||' '||U1.lastname as fullname, CV.vote, " .
	"CP.* from conf_proposals CP left join users U1 on U1.pk = CP.users_pk " .
	"left join conf_proposals_vote CV on CV.conf_proposals_pk = CP.pk " .
	"and CV.users_pk='$User->pk' " .
	"where CP.confID = '$CONF_ID' and CP.pk = '$PK' " . $sqlsearch . 
	$filter_type_sql . $filter_items_sql . $sqlsorting . $mysql_limit;

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

foreach ($items as $item) {
	// these add an array to each proposal item which contains the relevant topics/audiences
	$items[$item['pk']]['topics'] = $topics_items[$item['pk']];
	$items[$item['pk']]['audiences'] = $audience_items[$item['pk']];
	$items[$item['pk']]['comments'] = $comments_items[$item['pk']];
}

//echo "<pre>",print_r($items),"</pre><br/>";

?>




<table id="proposals_vote" width="100%" cellspacing="0" cellpadding="0">

<tr class='tableheader'>

<!-- <td width='10%'>&nbsp;<a href="javascript:orderBy('comment');">Comment</a></td>-->
<td>Title</a>&nbsp;/&nbsp;Submitted&nbsp;by</a> </td>
<td>Abstract&nbsp;/&nbsp;Description&nbsp;/&nbsp;Speakers&nbsp;/&nbsp; Format</a></td>
<!-- <td width='49%'><a href="javascript:orderBy('type');">Format/Length</a> </td>-->
<td>Topic&nbsp;/&nbsp;Audience&nbsp;Rank</td>
</tr>

<?php // now dump the data we currently have
$line = 0;
foreach ($items as $item) { // loop through all of the proposal items
	$line++;

	$pk = $item['pk'];
	$vote = $item['vote'];

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
	if (($line % 2) == 0) { $linestyle = "evenrow"; } else { $linestyle = "oddrow"; }

	

?>
<tr class="<?= $linestyle ?>" valign="top">
	<td  width="25%">
	<strong><a href="proposals.php#anchor<?=$PK?>"> [ BACK ] </a></strong>
<//td>
</tr>
<tr class="<?= $linestyle ?>" valign="top">
	<td  style="border-bottom:1px solid black;" width="25%">
		<div class="summary"><a name="anchor<?= $pk ?>"></a><strong><?= $item['title'] ?></strong><br/><br/></div>
		<div>
			<a href="mailto:<?= $item['email'] ?>">	<?= $item['firstname']." ".$item['lastname'] ?></a><br/>
			<?= $printInst ?><br/><br /><strong>Date Submitted: </strong><br/><?= $item['date_created'] ?><br/><br/>
		</div>		
	</td>

	<td style="border-bottom:1px solid black;"  width="40%">
		<div class="description"><strong>Abstract:</strong><br/><?= $item['abstract'] ?><br/><br/></div>
		<?php if ($item['URL']) { /* a project URL was provided */
			echo"<div><strong>Project URL: </strong><a href=\"$url\"><img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 width=10px height=10px></a><br/><br/></div>";
		}
		
		if ($item['type']!='demo')  { ?>
			<div class="description"><strong>Description:</strong><br/><?= $item['desc'] ?><br/><br/></div>
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

	<td style="border-bottom:1px solid black;" width="25%">
	<?php if ($item['type']=='demo') {  /* only non-demo types use the following data */ ?>
		n/a:  demo
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


<?php } /* end the foreach loop */ ?>
</table>

</form>
<?php } ?>
<?php include $TOOL_PATH.'include/admin_footer.php'; // Include the FOOTER ?>