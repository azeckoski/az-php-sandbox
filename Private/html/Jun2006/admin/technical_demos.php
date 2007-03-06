<?php
/*
 * file: schedule.php
 * Created on May 09, 8:00 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Technical Demo info and email";
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated - not required
//require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// THIS PAGE IS ACCESSIBLE BY ANYONE
// Make sure user is authorized for admin perms
$isAdmin = false; // assume user is NOT allowed unless otherwise shown
$hide_bof_rooms = false; // flag to hide the BOF rooms
if (!$User->checkPerm("admin_conference")) {
	$isAdmin = false;
	$hide_bof_rooms = true;
} else {
	$isAdmin = true;
	$hide_bof_rooms = false;
}

// get the passed message if there is one
if($_GET['msg']) {
	$Message = "<div class='message'>".$_GET['msg']."</div>";
}

// get the passed message if there is one
if($_REQUEST['hbr']) {
	$hide_bof_rooms = true;
}
// First get the list of proposals and related users for the current conf 
// (maybe limit this using a search later on)
$sql = "select U1.firstname, U1.lastname, U1.email, U1.institution, " .
	"U1.firstname||' '||U1.lastname as fullname, CV.vote, " .
	"CP.* from conf_proposals CP left join users U1 on U1.pk = CP.users_pk " .
	"left join conf_proposals_vote CV on CV.conf_proposals_pk = CP.pk " .
	"and CV.users_pk='$User->pk' " .
	"where CP.confID = '$CONF_ID'" . $sqlsorting . $mysql_limit;

//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$items = array();

// put all of the query results into an array first
while($row=mysql_fetch_assoc($result)) { $items[$row['pk']] = $row; }

//echo "<pre>",print_r($items),"</pre>"; 

// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
$CSS_FILE2 = $TOOL_URL."/include/schedule.css";
$DATE_FORMAT = "M d, Y h:i A";

	if ($_REQUEST['send'])   {
		echo "DONE";

//echo "<pre>",print_r($items),"</pre>"; 
	
	
 foreach ($items as $item) { // loop through all of the proposal items
 if ($item['type']== "demo")  { 
			
	 	 
 $this_email=$item['email'];
 
	//for email
		$msg="Technical Demo Proposal submitted by: "	. $item['firstname'] . ' ' .$item['lastname'] ." ( $this_email )"."\r\n\r\n";

	$msg.="Title: " . $item['title'] ."\r\n";
	$msg.="Description: " . $item['description'] ."\r\n";
	$msg.="Presenter(s): " . $item['speaker'] ."\r\n";
	
	$msg.="Technical Demos are schedule for:  Thursday, June 1st, from 5:30 pm to 7:30 pm in Rooms JR ABCD\r\n\r\n";
	
$msg .=" Technical Demo details can be seen at http://sakaiproject.org/index.php?option=com_content&task=blogcategory&id=173&Itemid=523. \r\n\r\n" .
		" The draft schedule for the Sakai Vancouver conference Presentation is also now available at https://www.sakaiproject.org/conference/admin/schedule.php. \r\n\r\n " .
		"  Please email Wende Morgaine at wendemm@gmail.com or Susan Hardin at shardin@umich.edu with any corrections or comments regarding this information.  \r\n";
	 
	 	 $msg.="\r\nThank You\r\n      Susan Hardin\r\nwww.sakaiproject.org webmaster\r\n";
	 	
 
	
// This is a better set of mail headers -AZ
ini_set(SMTP, $MAIL_SERVER);
$headers  = 'From: ' . $HELP_EMAIL . "\n";
$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
$headers .= 'Reply-To: ' . 'wendemm@gmail.com' . "\n";
$headers .= 'MIME-Version: 1.0' ."\n";
$headers .= 'Content-type: text/plain; charset=ISO-8859-1' ."\n";
$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";
	
			
//set up mail for the speaker
$recipient = $this_email;
$subject= "Your Sakai Vancouver Conference Technical Demo";
//send the mail to attendee
//mail($recipient, $subject, $msg, $headers);

		
//set up mail for the susan
$recipient = "shardin@umich.edu";
$subject= "Your Sakai Vancouver Conference Technical Demo ";
//send the mail to attendee
//mail($recipient, $subject, $msg, $headers);



 }
 		}
	}
	
?>
	

<script type="text/javascript">
<!--
function orderBy(newOrder) {
	if (document.adminform.sortorder.value == newOrder) {
		document.adminform.sortorder.value = newOrder + " desc";
	} else {
		document.adminform.sortorder.value = newOrder;
	}
	document.adminform.submit();
	return false;
}
// -->
</script>
<?php include $TOOL_PATH.'include/admin_header.php'; ?>


<?= $Message ?>
<!-- <form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="send" value="1"/>
<table> -->


<?php 
$count=1;

foreach ($items as $item) { // loop through all of the proposal items
 if ($item['type']== "demo")  { 
			
	 	 
 $this_email=$item['email'];
 
	//for email
	$URL=$item['URL'];
	$msg="<strong>" .$item['title'] ."</strong><br/>" ;
	$msg.="<strong>Description:</strong> " . $item['abstract'] ."<br/>";
		
$msg.="<strong>Presenter: </strong>" .$item['speaker'] ."<br/>";
	
 if ($URL){
	$msg.= "<strong>Project url: </strong> <a href=\"$URL\"><img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 width=10px height=10px></a>";
			
	}
	 

?>
<?php
	echo $msg;
	echo "<br/><br/>";
	
	echo "=====================<br/><br/>";
	
$count++;

?>
	
<?php 
		}
}
		
?>
</table>
			<input class="filter" type="submit" name="demoEmail" value="Send Demo Emails" title="Go to the previous page" />

</form>
<?php include $TOOL_PATH.'include/admin_footer.php'; ?>


