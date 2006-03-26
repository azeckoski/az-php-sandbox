<?php
/* file: file_info.php
 * Created on Mar 26, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
if (!$file_pk) {
	echo "ERROR: No file_pk specified";
}

// get file info from the database
$sql = "select name,type,size,dimensions from skin_files where pk='$file_pk'";
$result = mysql_query($sql) or die("File info fetch query failed: ".mysql_error().": ".$image_sql);
$thisFile = mysql_fetch_assoc($result); // first result is all we care about

$output  = "<strong>Name:</strong> $thisFile[name]<br/>";
$output .= "<strong>Type:</strong> $thisFile[type]<br/>";
$output .= "<strong>Size:</strong> $thisFile[size] bytes<br/>";
if($thisFile[dimensions]) {
	$output .= "<strong>Dimensions:</strong> $thisFile[dimensions]<br/>";
}
echo $output;
?>