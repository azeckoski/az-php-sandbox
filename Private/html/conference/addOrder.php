<?php
/*
 * Created on Mar 19, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php



require_once '../accounts/include/tool_vars.php';

$PAGE_NAME = "Call for Proposals";
$Message = "";

// connect to database
require '../accounts/sql/mysqlconnect.php';


			$sql = "select * from conf_proposals where confID='Jun2007' ";
			$result = mysql_query($sql) or die('count query failed: ' . mysql_error());
		
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$items = array ();
while ($row = mysql_fetch_assoc($result)) {
	$items[$row['pk']] = $row;
}		

$proposal_num=0;
foreach ($items as $item) {
	// these add an array to each proposal item which contains the relevant topics/audiences
	$pk = $item['pk'];
	$proposal_num++;
	
			//first add presentation information into --all data except role and topic data
		echo $pk . "and" .$proposal_num;
		
			$proposal_sql = "Update  `conf_proposals` set `order`='$proposal_num' where pk='$pk' " ; 
					

			$result = mysql_query($proposal_sql) or die("Error:<br/>" . mysql_error() );

		}


?>