<?php
/*
 * Created on Febrary 18, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
	require_once ("tool_vars.php");

	// Introduction or main page
	$PAGE_NAME = "Introduction";

	// connect to database
	require "mysqlconnect.php";

	// get the passkey from the cookie if it exists
	$PASSKEY = $_COOKIE["SESSION_ID"];

	// check the passkey
	$USER_PK = 0;
	if (isset($PASSKEY)) {
		$sql1 = "SELECT users_pk FROM sessions WHERE passkey = '$PASSKEY'";
		$result = mysql_query($sql1) or die('Query failed: ' . mysql_error());
		$count = mysql_num_rows($result);
		$row = mysql_fetch_assoc($result);

		if( empty($result) || ($count < 1)) {
			// no valid key exists, user not authenticated
			$USER_PK = 0;
		} else {
			// authenticated user
			$USER_PK = $row["users_pk"];
		}
		mysql_free_result($result);
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title>
<link href="./requirements_vote.css" rel="stylesheet" type="text/css">

</head>
<body>

<?php
	$USER = "";
	if ($USER_PK) {
		// get the authenticated user information
		$authsql = "SELECT * FROM users WHERE pk = '$USER_PK'";
		$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());
		$USER = mysql_fetch_assoc($result);
	}
?>

<? // Include the HEADER -AZ
include 'header.php'; ?>

<table border=0 cellpadding=0 cellspacing=3 width="100%">
<tr>
<td valign="top" width="80%">
<div class="info">
The REQ Workgroup is coordinating a three-step process by which the
Sakai community can participate in defining, prioritizing and
resourcing requirements for the next release of Sakai, targeted for
July 2006.<br/>
<br/>
<h4>Step 1:</h4>
The open call for requirements closed on <b>February 8</b>.
To review and/or add requirements, please visit:<br/>
<a href="http://bugs.sakaiproject.org/jira/secure/CreateIssue!default.jspa">
http://bugs.sakaiproject.org/jira/secure/CreateIssue!default.jspa</a><br/>
<br/>
<h4>Step 2:</h4>
Volunteers working with the REQ-WG are doing an initial
analysis of the requirements in order to cluster them, look for
overlaps, etc. The final list of clustered requirements will be
available for a community poll starting <b>February 27th</b>. The poll will
close at <b>midnight (EST) on March 5</b>.<br/>
<br/>
You will be able to submit your individual response to the poll using the <a href="vote.php">Voting form</a>.<br/>
<br/>
You will be able to review (using various filters) the poll results
by visiting <a href="results.php">View Results</a>.<br/>
<br/>
<h4>Step 3:</h4>
The expectation is that Sakai participants will follow their
established local processes for achieving consensus on requirements
prioritization and considering the resources they are able to commit
to items they consider of the highest priority.
<a href="http://sakaiproject.org/index.php?option=com_content&task=view&id=104&Itemid=203#reps" target="_REPS">
Institutional representatives</a> will submit a
formal vote on the requirements for their institution. The voting
period will open <b>March 6</b> and close on <b>March 13 at midnight(EST)</b>.
The results of the vote will be available by <b>TBD-date</b> at <a href=""><b>TBD</b></a>.<br/>
<br/>
The results will be reviewed and aligned with available resources or
working groups. The Sakai Project Coordinator will work with the members of the Sakai
community to identify needed resources. To track the progress of
requirements under active development for the next Sakai release, visit
the <a href="http://bugs.sakaiproject.org/confluence/display/MGT" target="_OPS">online project summary</a>.
If you have questions about a
particular requirement or would like to volunteer resources to work on a
requirement, contact the Project Coordinator, <a href="mailto:knoop@umich.edu">Peter Knoop</a>.<br/>
</div>
</td>
<td valign="top" width="20%">
	<div class="right">
	<div class="rightheader"><?= $TOOL_NAME ?> information</div>
	<div class="padded">

	<b>Voting Round:</b> <?= $ROUND ?><br/>
	<b>Open voting begins:</b><br/>
	<?= date($ROUND_DATE_FORMAT,strtotime($ROUND_OPEN_DATE)) ?><br/>
	<b>Rep voting begins:</b><br/>
	<?= date($ROUND_DATE_FORMAT,strtotime($ROUND_SWITCH_DATE)) ?><br/>
	<b>Voting closes:</b><br/>
	<?= date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE)) ?><br/>
	<br/>

<?php
	// fetch helpful information about this tool
	$data_sql = "select count(*) from requirements_data where round='$ROUND'";
	$result = mysql_query($data_sql) or warn('Query failed: ' . mysql_error());
	$req_round_data = mysql_fetch_row($result);
	mysql_free_result($result);

	$vote_sql = "select count(*) from requirements_vote where round='$ROUND'";
	$result = mysql_query($vote_sql) or warn('Query failed: ' . mysql_error());
	$req_round_votes = mysql_fetch_row($result);
	mysql_free_result($result);

	$vote_types = "select count(pk) from requirements_vote where round='$ROUND' " .
		"group by vote order by vote desc";
	$result = mysql_query($vote_types) or warn('Query failed: ' . mysql_error());
	$critical_votes = mysql_fetch_row($result);
	$essential_votes = mysql_fetch_row($result);
	$desirable_votes = mysql_fetch_row($result);
	$na_votes = mysql_fetch_row($result);
	mysql_free_result($result);

	$vote_users_sql = "select count(distinct(users_pk)) from requirements_vote where round='$ROUND'";
	$result = mysql_query($vote_users_sql) or warn('Query failed: ' . mysql_error());
	$req_round_users = mysql_fetch_row($result);
	mysql_free_result($result);
?>

	<span style="font-weight:bold;text-decoration:underline;">Statistics:</span><br/>
	<b>Requirements:</b> <?= $req_round_data[0] ?><br/>
	<b>Total users:</b> <?= $req_round_users[0] ?><br/>	
	<b>Total votes:</b> <?= $req_round_votes[0] ?><br/>
	- <b>Critical:</b> <?= $critical_votes[0] ?><br/>
	- <b>Essential:</b> <?= $essential_votes[0] ?><br/>
	- <b>Desirable:</b> <?= $desirable_votes[0] ?><br/>
	- <b>Not Applicable:</b> <?= $na_votes[0] ?><br/>

	</div>
	</div>
</td>
</tr>
</table>

<?php if (!$USER_PK) { ?>
<div class="help">
	<b>Help:</b>
	<a class="pwhelp" href="<?= $ACCOUNTS_PATH ?>createaccount.php">I need to create an account</a> -
	<a class="pwhelp" href="<?= $ACCOUNTS_PATH ?>login.php">I need to login</a> -
	<a class="pwhelp" href="<?= $ACCOUNTS_PATH ?>forgot_password.php">I forgot my password</a>
</div>
<?php } ?>

<? // Include the FOOTER -AZ
include 'footer.php'; ?>

</body>
</html>