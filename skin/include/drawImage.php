<?php
/* file: drawImage.php
 * Created on Mar 26, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

// connect to database
require '../sql/mysqlconnect.php';

if (!$_REQUEST['pk']) {
	// no image pk specified
	exit();
}

$PK = $_REQUEST['pk'];

// get image from the database
$image_sql = "select name,type,content from skin_files where pk='$PK'";
$result = mysql_query($image_sql) or die("Image fetch query failed: ".mysql_error().": ".$image_sql);
$thisImage = mysql_fetch_assoc($result); // first result is all we care about

if (!empty($thisImage['content'])) {
	// Output the MIME header
	header("Content-Type: ".$thisImage['type']."\n");
	header("Content-disposition: inline; filename=".$thisImage['name']."\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0"); 

	// Output the image
	echo $thisImage['content'];
}
?>