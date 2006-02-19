<?php
	require_once ("globals.php");

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

<script>
<!--
function focus(){document.login.username.focus();}
// -->
</script>

</head>
<body onLoad="focus();">

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


<div class="info">
The REQ Workgroup is coordinating a three-step process by which the
Sakai community can participate in defining, prioritizing and
resourcing requirements for the next release of Sakai, targeted for
June 2006.<br/>
<br/>
<h4>Step 1:</h4>
An open call for requirements is in progress and closes on
<b>February 8</b>.  To review and add requirements, please visit:<br/>
<a href="http://bugs.sakaiproject.org/jira/secure/CreateIssue!default.jspa">
http://bugs.sakaiproject.org/jira/secure/CreateIssue!default.jspa</a><br/>
<br/>
<h4>Step 2:</h4>
Volunteers working with the REQ-WG will do an initial
analysis of the requirements in order to cluster them, look for
overlaps, etc. The final list of clustered requirements will be
available for a community poll starting February 24th. The poll will
close at <b>midnight (EST) on March 5</b>.<br/>
<br/>
You will be able to submit your individual response to the poll using the <a href="vote.php">Voting form</a>.<br/>
<br/>
You will be able to review (using various filters) the poll results
to date by visiting <a href="results.php">View Results</a>.<br/>
<br/>
<h4>Step 3:</h4>
The expectation is that the Sakai participants at each
institution will follow their established campus processes for coming
to consensus on their institutional priorities and consider resources
they are able to commit to items of highest priority to their
institution. Reps (hot link or pointer to rep list) will submit a
formal vote on the requirements for their institution. The voting
period will open <b>March 6</b> and close on <b>March 13 at midnight(EST)</b>.
The results of the vote will be available by <b>TBD-date</b> at <a href=""><b>TBD</b></a>.<br/>
<br/>
The results will be reviewed and aligned with available resources or
working groups. The final commitments for the Sakai 2.2 release will
be negotiated by Sakai Foundation staff and community resources.
Information about the release features and commitment of resources
will be available by <b>TBD-date</b> at <a href=""><b>TBD</b></a>.<br/>
</div>


<div class="help">
	<b>Help:</b>
	<a class="pwhelp" href="createaccount.php">I need to create an account</a> -
	<a class="pwhelp" href="login.php">I need to login</a> -
	<a class="pwhelp" href="forgot_password.php">I forgot my password</a>
</div>

<? // Include the FOOTER -AZ
include 'footer.php'; ?>

</body>
</html>