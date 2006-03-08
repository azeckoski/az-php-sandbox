<?php/* * Created on March 2, 2006 by @author aaronz * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/) */?><?php	require_once ("tool_vars.php");	$PAGE_NAME = "Admin Control";	$Message = "";		// connect to database	require "mysqlconnect.php";	// get the passkey from the cookie if it exists	$PASSKEY = $_COOKIE["SESSION_ID"];	// check the passkey	$USER_PK = 0;	if (isset($PASSKEY)) {		$sql1 = "SELECT users_pk FROM sessions WHERE passkey = '$PASSKEY'";		$result = mysql_query($sql1) or die('Query failed: ' . mysql_error());		$row = mysql_fetch_assoc($result);		if( !$result ) {			// no valid key exists, user not authenticated			$USER_PK = -1;		} else {			// authenticated user			$USER_PK = $row["users_pk"];		}		mysql_free_result($result);	}	if( $USER_PK <= 0 ) {		// no user_pk, user not authenticated		// redirect to the login page		header('location:'.$ACCOUNTS_PATH.'login.php?ref='.$_SERVER['PHP_SELF']);		exit;	}	// if we get here, user should be authenticated	// get the authenticated user information	$authsql = "SELECT * FROM users WHERE pk = '$USER_PK'";	$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());	$USER = mysql_fetch_assoc($result);	$allowed = 0; // assume user is NOT allowed unless otherwise shown	if (!$USER["admin_reqs"]) {		$allowed = 0;		$Message = "Only admins with <b>admin_reqs</b> may view this page.<br/>" .			"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";	} else {		$allowed = 1;	}// Do the export as requested by the userif ($_REQUEST["export_insts"] && $allowed) {	$date = date("Ymd-Hi",time());	$filename = "institutions-" . $date . ".csv";	header("Content-type: text/x-csv");	header("Content-disposition: inline; filename=$filename\n\n");	header("Pragma: no-cache");	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	header("Expires: 0"); 		// generate the export file	$export_sql = "select I1.name, I1.abbr, I1.type, U1.username, U1.firstname, U1.lastname, U1.email, count(*) as official_votesfrom institution I1 left join users U1 on U1.pk=I1.repvote_pk left join requirements_vote RV on RV.users_pk=U1.pk and RV.round='$ROUND' and RV.official='1'group by RV.users_pk";	$result = mysql_query($export_sql) or die('Export query failed: ' . mysql_error());	$line = 0;	while($itemrow=mysql_fetch_assoc($result)) {		$line++;		// print out EXPORT format instead of display		if ($line == 1) {			print "\"Institions and Reps Export\"\n";			print join(',', array_keys($itemrow)) . "\n"; // add header line		}				foreach ($itemrow as $name=>$value) {			$value = str_replace("\"", "\"\"", $value); // fix for double quotes			$itemrow[$name] = '"' . $value . '"'; // put quotes around each item		}		print join(',', $itemrow) . "\n";	}		// add extra stuff at the bottom	print "\n\"Exported on:\",\"" . date($DATE_FORMAT,time()) . "\"\n";		print "\"Voting round:\",\"" . $ROUND . "\"\n";		exit;}$EXTRA_LINKS = "<br><span style='font-size:9pt;'>Requirements Admin</span>";?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title><link href="<?= $CSS_FILE ?>" rel="stylesheet" type="text/css"></head><body><? // Include the HEADER -AZinclude 'header.php'; ?><?= $Message ?><?php	// This part will punt the user out if they are not allowed to vote right now	// this is a nice punt in that it simply stops the rest of the page from loading -AZ	if (!$allowed) {		include 'footer.php';		exit;	}?><?php// process form actionsif ($_REQUEST["rescore"]) {	// recalculate all scores	$get_reqs_sql = "select pk from requirements_data where round='$ROUND'";	$result_items = mysql_query($get_reqs_sql) or die('Query failed: ' . mysql_error());	$output = "Recalculated all scores, " . mysql_num_rows($result_items) . " items affected.";	while($item = mysql_fetch_array($result_items)) {		$itemPk = $item[0];		$writeScore = 0;		$score_calc_sql="select vote as VOTE, COUNT(pk) as COUNT from requirements_vote " .			"where round='$ROUND' and req_data_pk = '$itemPk' group by vote";		$result = mysql_query($score_calc_sql) or die('Query failed: ' . mysql_error());		while($row = mysql_fetch_row($result)) {			$writeScore += $row[1] * $SCORE_MOD[ $row[0] ];			//print " -- ". $VOTE_TEXT[$row[0]] .": $writeScore += ".$row[1]." * ".$SCORE_MOD[ $row[0] ]."<br/>";		}		mysql_free_result($result);		//print "$itemPk = $writeScore<br/>";				$update_score_sql="update requirements_data set score = '$writeScore' where pk = '$itemPk'";		$result = mysql_query($update_score_sql) or die('Query failed: ' . mysql_error());	}	print "<h3 style='color:darkblue;'>$output</h3>";	mysql_free_result($result_items);}?><strong><?= $TOOL_NAME ?> Admin Operations</strong><br/><div style="margin:6px;"></div><form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;"><input type="submit" name="rescore" value="Recalculate scores"/> - This will recalculate all requirements data scores<br/><i style="font-size:.9em;">This is not very fast and puts heavy load on the database, do not use this unless scores are out of sync!</i><br/><br/><input type="submit" name="export_insts" value="Export Institutions and Reps" title="Export Institutions and Reps">- This will export all the institutions and reps for each one, it will also show the official votes for this voting round<br/></form><?php // Include the FOOTER -AZinclude 'footer.php'; ?></body></html>