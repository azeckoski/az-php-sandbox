<?php
/* file: getFile.php
 * Created on Mar 26, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

// connect to database
require '../sql/mysqlconnect.php';

if (!$_REQUEST['pk']) {
	// no file pk specified
	exit();
}

$PK = $_REQUEST['pk'];

// get image from the database
$file_sql = "select name,type,content from skin_files where pk='$PK'";
$result = mysql_query($file_sql) or die("File fetch query failed ($file_sql): ".mysql_error());
$thisFile = mysql_fetch_assoc($result); // first result is all we care about

if (!empty($thisFile['content'])) {
	// Output the MIME header
	header("Content-Type: {".$thisFile['type']."}");
	header("Content-disposition: inline; filename=".$thisFile['name']."\n\n");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0"); 

	// Output the data
	echo $thisFile['content'];
}
?>