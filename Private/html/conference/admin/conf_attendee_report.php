<?php
/*
 * file: conf_attendee_export.php
 * Created on Apr 15, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech
 */
?>
<?php
require_once '../include/tool_vars.php';

require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

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

//$filePath = $ACCOUNTS_PATH."admin/conf_exports/";
//$filename = $filePath.$filename;
//$fhandle = fopen($filename,"w");

ob_start(); // create buffer

$line = 0;
while ($item = mysql_fetch_assoc($result)) {
	$line++;
	if ($line == 1) {
		echo ("\"Conference Attendees Report:\",,\"$CONF_NAME\",\"$CONF_ID\"\n");
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

//fclose($fhandle);

// now mail this to someone
ini_set(SMTP, $MAIL_SERVER);
$headers  = 'From: ' . $HELP_EMAIL . "\n";
$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
$headers .= 'Reply-To: ' . "donotreply@sakaiproject.org" . "\n";
$headers .= 'Cc: ' . $CONF_REPORT_CC . "\n";
$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";
$headers .= 'MIME-Version: 1.0' . "\n";
$mime_boundary=md5(time());
$headers .= "Content-Type: multipart/related; boundary=\"$mime_boundary\"\n";

$recipient = $CONF_REPORT_TO;
$subject= "Attendee Report: " . date($SHORT_DATE_FORMAT,time());

// put in the attachment
$msg .= "--".$mime_boundary."\n";
$msg .= "Content-Type: text/x-csv; name=\"".$filename."\""."\n";
$msg .= "Content-Transfer-Encoding: base64"."\n";
$msg .= "Content-Disposition: attachment; filename=\"".$filename."\""."\n"."\n";
$msg .= base64_encode($fileContent)."\n"."\n";

// put in a short message
$msg .= "--".$mime_boundary."\n";
$msg .= "Content-Type: text/plain; charset=\"iso-8859-1\""."\n";
$msg .= "Content-Transfer-Encoding: 8bit"."\n";
$msg .= "This mail is generated automatically by the sakaiproject.org website.\n" .
	"This is a report of the current conference attendees for: $CONF_NAME ($CONF_ID).\n" .
	"Report is attached as $filename and was generated: " . date($SHORT_DATE_FORMAT,time()) . "\n" .
	"-- Sakai Webmaster\n";
$msg .= "--".$mime_boundary."--\n\n";

//send the mail
mail($recipient, $subject, $msg, $headers);

//echo "Subject: $subject <br/>Message: $msg <br/>";
?>