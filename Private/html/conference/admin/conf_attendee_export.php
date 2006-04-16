<?php
/*
 * file: conf_attendee_export.php
 * Created on Apr 15, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * copyright 2006 Virginia Tech
 */
?>
<?php
	$date = date("Ymd-Hi",time());
	$filename = "institutions-" . $date . ".csv";
	header("Content-type: text/x-csv");
	header("Content-disposition: attachment; filename=$filename\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0");

	$exportItems = $opInst->getInstsBySearch($search,$sortorder,"*");
	$fields = $opInst->getFields();

	$line = 0;
	foreach ($exportItems as $item) {
		$line++;
		if ($line == 1) {
			echo "\"Conference Attendees Export:\",,\"$CONF_ID\"\n";
			print join(',', array_keys($item)) . "\n"; // add header line
		}

		foreach ($item as $name=>$value) {
			$value = str_replace("\"", "\"\"", $value); // fix for double quotes
			$item[$name] = '"' . trim($value) . '"'; // put quotes around each item
		}
		echo join(',', $item) . "\n";
	}
	echo "\n\"Exported on:\",\"" . date($DATE_FORMAT,time()) . "\"\n";

	exit;
?>