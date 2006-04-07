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

// set header links
$EXTRA_LINKS = 
	"<br/><span style='font-size:9pt;'>" .
	"<a href='index.php'>Admin:</a> " .
	"<a href='attendees.php'>Attendees</a> - " .
	"<a href='proposals.php'><strong>Proposals</strong></a> " .
	"</span>";

?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript">
<!--
function orderBy(newOrder) {
	if (document.adminform.sortorder.value == newOrder) {
		document.adminform.sortorder.value = newOrder + " desc";
	} else {
		document.adminform.sortorder.value = newOrder;
	}
	document.adminform.submit();
	return false;
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
	}
?>

<?php
// Time to do the fun stuff -AZ

// First get the list of proposals for the current conf (maybe limit this using a search later on)
$sql = "select CP.* from conf_proposals CP where CP.confID = '$CONF_ID'";
//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$items = array();

// put all of the query results into an array first
while($row=mysql_fetch_assoc($result)) { $items[$row['pk']] = $row; }

// Use the user pks to get the user info for these proposal users
$userPks = array();
foreach ($items as $item) {
	// this should produce a nice unique list of user pks
	$userPks[$item['users_pk']] = $item['users_pk'];
}
// use the current User object to get the userinfo
$userInfo = $User->getUsersByPkList($userPks, "fullname,email,institution");
//echo "<pre>",print_r($userInfo),"</pre><br/>";

// TODO - add in the audiences and topics of that nature (should require 2 more queries)
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

// put the userInfo into the items array
foreach ($items as $item) {
	$items[$item['pk']]['fullname'] = $userInfo[$item['users_pk']]['fullname'];
	$items[$item['pk']]['email'] = $userInfo[$item['users_pk']]['email'];
	$items[$item['pk']]['institution'] = $userInfo[$item['users_pk']]['institution'];
	// these add an array to each proposal item which contains the relevant topics/audiences
	$items[$item['pk']]['topics'] = $topics_items[$item['pk']];
	$items[$item['pk']]['audiences'] = $audience_items[$item['pk']];
}

//echo "<pre>",print_r($items),"</pre><br/>";

?>

<table cellspacing="0" cellpadding="3" border="0">
<?php // now dump the data we currently have
$line = 0;
foreach ($items as $item) { // loop through all of the proposal items
	$line++;

	$linestyle = "oddrow";
	if ($line % 2 == 0) {
		$linestyle = "evenrow";
	} else {
		$linestyle = "oddrow";
	}

	if ($line==1) { // print the header row quick style
		foreach($item as $key=>$value) { echo "<th>$key</th>"; }
	}
?>

<tr class="<?= $linestyle ?>">
<?php // write out the values quick style
	foreach($item as $key=>$value) {
		if (is_array($value)) {
			echo "<td>";
			foreach($value as $v) { echo $v['topic_name'],$v['role_name'],":",$v['choice'],"<br/>"; }
			echo "</td>";
		} else {
			echo "<td>$value</td>";
		}
	}
?>
</tr>

<?php } /* end the foreach loop */ ?>
</table>

<?php include $TOOL_PATH.'include/admin_footer.php'; // Include the FOOTER ?>
