<?php	require_once ("tool_vars.php");	// Form to allow users to review the votes so far	$PAGE_NAME = "View Results";	// connect to database	require "mysqlconnect.php";	// get the passkey from the cookie if it exists	$PASSKEY = $_COOKIE["SESSION_ID"];	// check the passkey	$USER_PK = 0;	if (isset($PASSKEY)) {		$sql1 = "SELECT users_pk FROM sessions WHERE passkey = '$PASSKEY'";		$result = mysql_query($sql1) or die('Query failed: ' . mysql_error());		$count = mysql_num_rows($result);		$row = mysql_fetch_assoc($result);		if( empty($result) || ($count < 1)) {			// no valid key exists, user not authenticated			$USER_PK = 0;		} else {			// authenticated user			$USER_PK = $row["users_pk"];		}	mysql_free_result($result);	}	$USER = "";	if ($USER_PK) {		// get the authenticated user information		$authsql = "SELECT * FROM users WHERE pk = '$USER_PK'";		$result = mysql_query($authsql) or die('Query failed: ' . mysql_error());		$USER = mysql_fetch_assoc($result);	}?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title><link href="./requirements_vote.css" rel="stylesheet" type="text/css"><script><!--function focus(){document.filter.searchtext.focus();}// --></script></head><body onLoad="focus();"><?php	// add in the display to let people know how long they have to vote	$EXTRA_LINKS = "<br/><div class='date_message'>";	$not_allowed = 1; // assume user is NOT allowed unless otherwise shown	$Message = "";	if (strtotime($ROUND_CLOSE_DATE) < time()) {		// Normal folks cannot access until after the close date		$not_allowed = 0;		$Message = "Voting closed on " . date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));		$EXTRA_LINKS .= "Voting closed " . date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));	} else if (strtotime($ROUND_SWITCH_DATE) < time()) {		// User must be a rep or no access		// *************** CHECK DB TO SEE IF USER IS A REP		$Message = "Voting is currently open to institutional representatives only";		$EXTRA_LINKS .= "Rep voting from " . date($ROUND_DATE_FORMAT,strtotime($ROUND_SWITCH_DATE)) .			" to " . date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));	} else {		// No results viewing allowed		$Message = "Voting results cannot be viewed until voting is over on " .			date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));		$EXTRA_LINKS .= "Voting closes on " . date($ROUND_DATE_FORMAT,strtotime($ROUND_CLOSE_DATE));	}	$EXTRA_LINKS .= "</div>";?><? // Include the HEADER -AZinclude 'header.php'; ?><?= $Message ?><?php	// This part will punt the user out if they are not allowed to vote right now	// this is a nice punt in that it simply stops the rest of the page from loading -AZ	if ($not_allowed) {		include 'footer.php';		exit;	}?><table class=main cellspacing="0"  border="0" >  <td  valign=top style="background:#ECECEC; padding-bottom: 10px; border: 1px solid #ccc; white-space: n"><!--   <strong>CONFERENCE REGISTRATION:</strong>  --><FORM ACTION="<?php echo($PHP_SELF); ?>" METHOD="POST"name="FORM_select_type" id="FORM_select_type"><p>Filter Requirements by:</p>Rank:<select name="rank">                <option value="all">show all rankings</option>                <option value="critical">Critical items</option>                <option value="essential">Essential items</option>                <option value="desireable">Desireable items</option>            </select>&nbsp; &nbsp; &nbsp; Contributions:          <select name="contribute"><option value="all">show all</option>                <option value="critical">show Contribute Resources</option>                <option value="essential">show Do not Contribute Resources</option>          </select>     &nbsp; &nbsp; &nbsp;Filter by Organization:                     <input tupe="text" name="organization" size=30 value=""><script language="JavaScript" type="text/javascript"><!--function function_submit_select_type(){document.FORM_select_type.submit();	}//--></script><noscript><input type="submit" value="submit" name="SUBMIT_select_type"></noscript></FORM> <br /></td></tr></table><?phprequire "mysqlconnect.php";	 	$sql="Select * from requirement_vote";			$reportName="All Requirement voting results";$result= mysql_query($sql);$resultsnumber=mysql_numrows($result);$line = "1";$row="0";echo"<table cellpadding=0 cellspacing=0 width=700px bgcolor:#fff  align=center border=0>		<tr><td border=0><br /><br /><strong>$reportName</strong></td></tr></table> <table  cellspacing=0><tr class=tableheader>	<td>Req#</td>	<td>Summary</td>	<td>Rank</td>	<td>Contribute</td>	<td>Describe Resources</td>	<td>Voter Name</td><td>Voter Organization</td></tr>";while($links=mysql_fetch_array($result)){$row++;$key=$links["key"];$summary=$links["summary"];$rank=$links["rank"];$contribute=$links["contribute"];$resource_info=$links["resource_info"];$name=$links["name"];$organization=$links["organization"];if ($line == 1) {	echo "<tr id=oddrow valign=top>";   $line='2';} else {	echo "<tr id=evenrow valign=top>";	$line='1';}	echo"	<td class=line_no>$key</td>	<td width=200px>$summary</td>	<td>$rank</td>	<td>$contribute</td>	<td>$resource_info</td>	<td>$name</td><td>$organization</td></tr>"; //end row, so change color} //end of whileecho"</table>";?></body></html>