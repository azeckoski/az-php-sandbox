<?php
/*
 * Created on Febrary 18, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Introduction";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// add in the help link
$EXTRA_LINKS = " - <a style='font-size:.8em;' href='$HELP_LINK' target='_HELP'>Help</a><br/>";
?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<script>
<!--
// -->
</script>
<?php include 'include/header.php'; // INCLUDE THE HEADER ?>


<table border=0 cellpadding=0 cellspacing=3 width="100%">
<tr>
<td valign="top" width="75%">
<div class="info">
The <a href="http://bugs.sakaiproject.org/confluence/x/9yc">Default Skin WG</a> is coordinating a contest to
create the next default skin for Sakai. <a href="skin_contest_rules.php">Complete details and rules</a> 
for the contest are available online.<br>
<br>
<b>Contest Summary:</b><br>
<b>Purpose</b><br>
The purpose of the contest is to solicit creative new ideas for a default skin with the goal of improving the 
Sakai out-of-the box usability and visual appeal. The new default skin will be used in the Sakai 2.2 release. 
The top contest entry will be included in the Sakai 2.2 bundle as the default skin. 
The 2nd and 3rd place entries will be included in the enterprise bundle as options.<br>
<br>
<b>Process</b><br>
<a href="submit.php">Submit your skin</a> by <?= date($DATE_FORMAT,strtotime($ROUND_CLOSE_DATE)) ?><br>
<a href="vote.php">Cast votes</a> for best skins between <?= date($DATE_FORMAT,strtotime($ROUND_VOTE_DATE)) ?> and <?= date($DATE_FORMAT,strtotime($ROUND_END_DATE)) ?><br>
Announce the winning skins at the <a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=319&Itemid=527">Sakai Vancouver Conference<a/><br>
<br/>
<b>Contest Details:</b><br>
<a href="skin_contest_rules.php">Complete details and rules for the contest are available here</a><br>
</div>
</td>
<td valign="top" width="25%">
	<div class="right">
	<div class="rightheader"><?= $TOOL_NAME ?> information</div>
	<div class="padded">

	<b>Contest Round:</b> <?= $ROUND ?><br/>
	<b>Contest begins:</b><br/>
	&nbsp;&nbsp;<?= date($DATE_FORMAT,strtotime($ROUND_START_DATE)) ?><br/>
	<b>Submission ends:</b><br/>
	&nbsp;&nbsp;<?= date($DATE_FORMAT,strtotime($ROUND_CLOSE_DATE)) ?><br/>
	<b>Voting begins:</b><br/>
	&nbsp;&nbsp;<?= date($DATE_FORMAT,strtotime($ROUND_VOTE_DATE)) ?><br/>
	<b>Voting ends:</b><br/>
	&nbsp;&nbsp;<?= date($DATE_FORMAT,strtotime($ROUND_END_DATE)) ?><br/>
	<br/>

<?php
	// fetch helpful information about this tool
	$entry_sql = "select count(*) from skin_entries where round='$ROUND'";
	$result = mysql_query($entry_sql) or die('Query failed: ' . mysql_error());
	$entry_count = mysql_fetch_row($result);
	mysql_free_result($result);

	$vote_sql = "select count(*) from skin_vote where round='$ROUND'";
	$result = mysql_query($vote_sql) or die('Query failed: ' . mysql_error());
	$round_votes = mysql_fetch_row($result);
	mysql_free_result($result);

	$vote_users_sql = "select count(distinct(users_pk)) from skin_vote where round='$ROUND'";
	$result = mysql_query($vote_users_sql) or die('Query failed: ' . mysql_error());
	$round_users = mysql_fetch_row($result);
	mysql_free_result($result);
?>

	<span style="font-weight:bold;text-decoration:underline;">Statistics:</span><br/>
	<b>Submitted Skins:</b> <?= $entry_count[0]+0 ?><br/>
	<b>Total votes:</b> <?= $round_votes[0]+0 ?><br/>
	<b>Users Voted:</b> <?= $round_users[0]+0 ?><br/>
	</div>
	</div>
</td>
</tr>
</table>

<?php if (!$USER_PK) { ?>
<div class="help">
	<b>Help:</b>
	<a class="pwhelp" href="<?= $ACCOUNTS_URL ?>/createaccount.php">I need to create an account</a> -
	<a class="pwhelp" href="<?= $ACCOUNTS_URL ?>/login.php">I need to login</a> -
	<a class="pwhelp" href="<?= $ACCOUNTS_URL ?>/forgot_password.php">I forgot my password</a>
</div>
<?php } ?>

<?php include 'include/footer.php'; // Include the FOOTER ?>