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

$filePath = $ACCOUNTS_PATH."admin/conf_exports/";
$filename = $filePath.$filename;
$fhandle = fopen($filename,"w");

$line = 0;
while ($item = mysql_fetch_assoc($result)) {
	$line++;
	if ($line == 1) {
		fwrite("\"Conference Attendees Export:\",,\"$CONF_NAME\",\"$CONF_ID\"\n");
		fwrite(join(',', array_keys($item)) . "\n"); // add header line
	}

	foreach ($item as $name=>$value) {
		$value = str_replace("\"", "\"\"", $value); // fix for double quotes
		$item[$name] = '"' . trim($value) . '"'; // put quotes around each item
	}
	fwrite(join(',', $item) . "\n");
}
fwrite("\n\"Exported on:\",\"" . date($DATE_FORMAT,time()) . "\"\n");

fclose($fhandle);
?>