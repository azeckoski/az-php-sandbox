<?php
/*
 * file: conf_attendee_report.php
 * Created on Apr 15, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech
 */
?>
<?php
/*
 * You will want to create a crontab entry like this to generate the reports automatically

# min    hour    dayMonth    monthYear    dayWeek
# 0-59   0-23    1-31        1-12         0-6 (0=Sunday)
#
# Send a daily report on conference attendees (to help Susan)
00 19 * * * wget https://sakaitest.org/conference/admin/conf_attendee_report.php?gen=email -O conf_report_output
# Don't forget to turn this off after the conference is over!

 * options for gen are:
 * file - generate a file in the reports directory (should be ~sakai/Private/reports)
 * email - send an email to the list of users defined in the tool_vars file ($CONF_REPORT_TO and $CONF_REPORT_CC)
 * both - generate a file and send an email
 * 
 * TODO: maybe make this function only generate a report before the CONF_END_DATE?
 */

require_once '../include/tool_vars.php';

if (!$_REQUEST['gen']) {
	header('location:'."/conference");
	exit();
} else if ($_REQUEST['gen'] != "file" && 
	$_REQUEST['gen'] != "email" &&
	$_REQUEST['gen'] != "both") {
		echo "Invalid gen option: ".$_REQUEST['gen'];
		exit();
}

require $ACCOUNTS_PATH.'sql/mysqlconnect.php';


// do stats calculations
$count_sql = "SELECT count(*) FROM conferences where confId = '$CONF_ID'";
$count_result = mysql_query($count_sql) or die("Count failed ($count_sql): " . mysql_error());
$row = mysql_fetch_array($count_result);
$total_reg = $row[0];

$count_sql = "SELECT count(*) FROM conferences where activated = 'Y' and confId = '$CONF_ID'";
$count_result = mysql_query($count_sql) or die("Count failed ($count_sql): " . mysql_error());
$row = mysql_fetch_array($count_result);
$total_activated = $row[0];
$total_inactive = $total_reg - $total_activated;

$count_sql = "SELECT count(*) FROM conferences where date_created > curdate()-INTERVAL 7 DAY and confId = '$CONF_ID'";
$count_result = mysql_query($count_sql) or die("Count failed ($count_sql): " . mysql_error());
$row = mysql_fetch_array($count_result);
$total_week = $row[0];

$count_sql = "SELECT count(*) from conferences C1 join users U1 on U1.pk = C1.users_pk " .
		"and institution_pk = '1' where confId = '$CONF_ID'";
$count_result = mysql_query($count_sql) or die("Count failed ($count_sql): " . mysql_error());
$row = mysql_fetch_array($count_result);
$non_members = $row[0];
$members = $total_reg - $non_members;

$sql = "select U1.firstname, U1.lastname, U1.email, I1.name as institution, " .
	"U1.institution_pk, C1.* from users U1 " .
	"join conferences C1 on U1.pk=C1.users_pk " .
	"left join institution I1 on U1.institution_pk=I1.pk " .
	"where confID='$CONF_ID' order by date_created desc";
//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$items_count = mysql_num_rows($result);

$date = date("Ymd-Hi",time());
$filename = "institutions-" . $date . ".csv";

ob_start(); // create buffer

$line = 0;
while ($item = mysql_fetch_assoc($result)) {
	$line++;
	if ($line == 1) {
		echo ("\"Conference Attendees Report:\",,\"$CONF_NAME\",\"$CONF_ID\"\n");
		echo ("\"SUMMARY:\"\n");
		echo ("\"Registered:\",\"$total_reg\",\"total number of registrations (including those who have not paid yet)\"\n");
		echo ("\"Active:\",\"$total_activated\",\"number of active registrations (i.e. signed up and paid)\"\n");
		echo ("\"Inactive:\",\"$total_inactive\",\"non-members that have not paid yet\"\n");
		echo ("\"Recent:\",\"$total_week\",\"registrations in the past 7 days\"\n");
		echo ("\"Members:\",\"$members\",\"members of Sakai partner institutions\"\n");
		echo ("\"Non-members:\",\"$non_members\",\"not members of Sakai partner institutions\"\n");
		echo ("\n");
		echo (join(',', array_keys($item)) . "\n"); // add header line
	}

	foreach ($item as $name=>$value) {
		$value = str_replace("\"", "\"\"", $value); // fix for double quotes
		$item[$name] = '"' . trim($value) . '"'; // put quotes around each item
	}
	echo (join(',', $item) . "\n");
}
echo ("\n\"Generated on:\",\"" . date($DATE_FORMAT,time()) . "\"\n");

$fileContent = ob_get_contents(); // put buffer into variable
ob_end_clean(); // purge the buffer


// create a file if requested
if($_REQUEST['gen'] == "file" || $_REQUEST['gen'] == "both") {
	$file = $CONF_REPORT_PATH."/".$filename;
	$fhandle = fopen($file,"w");
	if (!$fhandle) { echo "ERROR: Could not open file: $file <br/>"; }
	else {
		if (!fwrite($fhandle, $fileContent)) {
			echo "ERROR: Could not write contents to file<br/>";
		} else {
			echo "Wrote new report file: $file<br/>";
		}
		fclose($fhandle);
	}
}

if($_REQUEST['gen'] == "email" || $_REQUEST['gen'] == "both") {

	// now mail this to someone
	ini_set(SMTP, $MAIL_SERVER);
	$headers  = 'From: ' . $HELP_EMAIL . "\n";
	$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
	$headers .= 'Reply-To: ' . "donotreply@sakaiproject.org" . "\n";
	$headers .= 'Cc: ' . $CONF_REPORT_CC . "\n";
	$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";
	$headers .= 'MIME-Version: 1.0' . "\n";
	$mime_boundary=md5(time());
	$headers .= "Content-Type: multipart/mixed; boundary=\"$mime_boundary\"\n";
	
	$recipient = $CONF_REPORT_TO;
	$subject= "Attendee Report: " . date($SHORT_DATE_FORMAT,time());
	
	// put in the attachment
	$msg .= "--".$mime_boundary."\n";
	$msg .= "Content-Type: text/x-csv; name=\"".$filename."\""."\n";
	$msg .= "Content-Transfer-Encoding: base64"."\n";
	$msg .= "Content-Disposition: attachment; filename=\"".$filename."\""."\n"."\n";
	$msg .= chunk_split(base64_encode($fileContent)) ."\n"."\n";
	
	// put in a short message
	$msg .= "--".$mime_boundary."\n";
	$msg .= "Content-Type: text/plain; charset=\"iso-8859-1\""."\n";
	$msg .= "Content-Transfer-Encoding: 8bit"."\n";
	$msg .= "This mail is generated automatically by the sakaiproject.org website.\n" .
		"This is a report of the current conference attendees for: $CONF_NAME ($CONF_ID).\n" .
		"Report is attached as $filename and was generated: " . date($SHORT_DATE_FORMAT,time()) . "\n";
	$msg .= "\n";
	$msg .= "SUMMARY:\n";
	$msg .= "Registered: $total_reg   (total number of registrations (including those who have not paid yet))\n";
	$msg .= "Active: $total_activated   (number of active registrations (i.e. signed up and paid))\n";
	$msg .= "Inactive: $total_inactive   (non-members that have not paid yet)\n";
	$msg .= "Recent: $total_week   (registrations in the past 7 days)\n";
	$msg .= "Members: $members   (members of Sakai partner institutions)\n";
	$msg .= "Non-members: $non_members   (not members of Sakai partner institutions)\n";
	$msg .= "\n";
	$msg .= "-- Sakai Webmaster\n";
	$msg .= "--".$mime_boundary."--\n\n";
	
	//echo "Subject: $subject <br/>Message: $msg <br/>";

	//send the mail
	if(mail($recipient, $subject, $msg, $headers)) {
		echo "Conf report email sent...<br/>";
	} else {
		echo "ERROR: Conf report email failure...<br/>";
	}
}
?>