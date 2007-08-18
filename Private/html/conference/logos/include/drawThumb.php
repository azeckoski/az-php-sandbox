<?php
/* drawThumb.php
 * Created on Mar 20, 2006 by az - Aaron Zeckoski
 * copyright 2006 Virginia Tech 
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
$image_sql = "select type,content,thumb,thumbtype from logo_images where pk='$PK'";
$result = mysql_query($image_sql) or die("Image fetch query failed: ".mysql_error().": ".$image_sql);
$thisImage = mysql_fetch_assoc($result); // first result is all we care about

if (!empty($thisImage['thumb'])) {
	// Output the MIME header
	header("Content-Type: {$thisImage['thumbtype']}");
	// Output the image
	echo $thisImage['thumb'];
} else if (!empty($thisImage['content'])) {
	// if no thumb then output the actual image instead
	// Output the MIME header
	header("Content-Type: {$thisImage['type']}");
	// Output the image
	echo $thisImage['content'];
}
?>