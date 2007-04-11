<?php
/*
 * Created on Nov 4, 2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
/*
 * file: send_scheduleEmail.php
 * Created on May 09, 8:00 PM by shardin@umich.edu
 * modified from the check_in.php code written by 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * 
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Send Schedule Emails";
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';


// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
if (!$User->checkPerm("admin_conference")) {
	$allowed = 0;
	$Message = "Only admins with <b>admin_conference</b> may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_URL/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}
if ($_REQUEST['send_emails']){
 }

 // First get the list of proposals and related users for the current conf 
// (maybe limit this using a search later on)
$sql = "select U1.firstname, U1.lastname, U1.email, U1.institution, " .
	"U1.firstname||' '||U1.lastname as fullname,  " .
	"CP.* from conf_proposals CP left join users U1 on U1.pk = CP.users_pk " .
	"where CP.confID =  '$CONF_ID' and approved='Y' and type!='BOF' and type!='demo' and type!='poster'";
	$filter_type_sql . $filter_items_sql . $sqlsorting . $mysql_limit;

//print "SQL=$sql<br/>";
$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());
$conf_proposals = array();

while($row=mysql_fetch_assoc($result)) { $conf_proposals[$row['pk']] = $row; }


// now put these together into a 3D array
$timeslots = array();



//echo "<pre>",print_r($conf_proposals),"</pre>"; 

// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
$CSS_FILE2 = $TOOL_URL."/include/schedule.css";
$DATE_FORMAT = "M d, Y h:i A";



?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
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

function checkInUser(num) {
	var response = window.confirm("Check in this user now?");
	if (response) {
		document.adminform.check_in.value = num;
		document.adminform.submit();
		return false;
	}
}

function unCheckInUser(num) {
	var response = window.confirm("Reset this user to Not checked in?");
	if (response) {
		document.adminform.check_out.value = num;
		document.adminform.submit();
		return false;
	}
}
// -->
</script>
<?php include $TOOL_PATH.'include/admin_header.php'; ?>

<?= $msg ?>
<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $TOOL_PATH.'include/admin_footer.php';
		exit;
	}
?>
	
	<div>
<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>"/>
<input type="hidden" name="send_emails" value="1"/>
<input type="hidden" name="check_all" value=""/>

<table border="0" cellspacing="0" width="100%">
<tr class='tableheader'>
<td>#</td>
<td align="left"><a href="javascript:orderBy('email_sent');">Send</a></td>
<td align="left"><a href="javascript:orderBy('title');">Title</a></td>
<td align="left"><a href="javascript:orderBy('track');">Track</a></td>
<td align="left"><a href="javascript:orderBy('approved');">Status</a></td>
<td align="left"><a href="javascript:orderBy('lastname');">Name</a></td>
<td align="left"><a href="javascript:orderBy('email');">Email</a></td>

<td></td>
</tr>




<?php


?>


<?php	
	
	
	$line=0;		
foreach ($conf_proposals as $proposal) {
				$trackclass = "";
				if($proposal['track']) {
					$trackclass = str_replace(" ","_",strtolower($proposal['track']));
				}

				$total_length += $proposal['length'];
				
		
			
				//formatting stuff here
				$line++;		
								
				$rowstyle = "";
				if ($proposal["email_sent"] == 'N') {
					$rowstyle = " style = 'color:red;' ";
				} else  {
					$rowstyle = " style = 'color:#990099;' ";
				}
				
				$linestyle = "oddrow";
				if ($line % 2 == 0) {
					$linestyle = "evenrow";
				} else {
					$linestyle = "oddrow";
				}
				
				//now display the presentation information
			?>
				<tr class="<?= $linestyle ?>" <?= $rowstyle ?> >
					
					<td><?=$proposal['order_num']?></span></td><td class="line" align="left">
							
					<?php if($proposal['email_sent'] == "Y") { ?>
							 <input type="hidden" name="Proposals_PK[]" value="<?=$proposal['pk']?>" />
							<img  src="../include/images/redMail.jpg" alt="printed" width="30" height="30" />
								<?php } else {
						
							 ?>
						 <input type="checkbox" name="checked[]" value="<?=$proposal['pk']?>" />
						 <input type="hidden" name="Proposals_PK[]" value="<?=$proposal['pk']?>" />
							
							<img src="../include/images/mail.jpg" width="30" height="20" alt="not emailed yet" />
					
					<?php  } ?>
							
						</td>
					<td class="line" align="left"><?=$proposal['title']?>
						<input type="hidden" name="Proposals_title[]" value="<?= $proposal['title'] ?>"/>
						</td>
						<td class="line" align="left"><?=$proposal['track']?>
						<input type="hidden" name="Proposals_track[]" value="<?= $proposal['track'] ?>"/>
						</td>
					<td class="line" align="left"><?=$proposal['approved']?>
						<input type="hidden" name="approved" value="<?=$proposal['approved']?>"/>
						</td>
					<td class="line" align="left"><?=$proposal['firstname'] .' ' . $proposal['lastname']?>
						<input type="hidden" name="Proposals_speaker[]" value="<?= $proposal['firstname'] .' ' . $proposal['lastname']?>"/>
						</td>
					<td><?=$proposal['email']?>
						<input type="hidden" name="Proposals_email[]" value="<?= $proposal['email'] ?>"/>
						</td>
						<td><span style="color:#ccc; font-size: .9em;"><?=$line?></span></td><td class="line" align="left">
					
			</tr>
			<tr><td colspan=4>
			<?php  
				
			//the variables are from the old code and will need to be changed
	$msg ="We are pleased to notify you that your presentation has been accepted for the\r\n".
			"Sakai Amsterdam Conference, Jun 12 - 14, 2007.  More details regarding the date and\r\n" .
			"time of your presentation will be sent out soon.  If you have any questions,\r\n" .
			"please contact the track lead for your session.   \r\n\r\n";
	
		$msg.="---------Your Session Information-----------\r\n\r\n";
		
	$msg.="Title: " . $proposal['title'] ."\r\n";
	$msg.="Speaker: " . $proposal['speaker'] ."\r\n";
//	$msg.="Scheduled for: " . $current_date . ": " .date('g:i a',strtotime($timeslot['start_time']))."\r\n";
//	$msg.="Session Length: " . $proposal['length'] ." minutes"."\r\n";
//	$msg.="Session Type: " . $proposal['type']."\r\n";
	

	switch ($proposal['track']) {
	
		case "Implementation": $track_lead="Anthony Whyte - arwhyte@umich.edu"; break;
		case "Technical": $track_lead="Aaron Zeckoski - aaronz@vt.edu"; break;
		case "Research": $track_lead="HarrietTruscott- harriet@caret.cam.ac.uk"; break;
		case "Teaching & Learning": $track_lead="Anastasia Morrone- amorrone@iupui.edu"; break;
		case "User Experience": $track_lead="Colin Clark - colin.clark@utoronto.ca"; break;
		case "Tool Carousel": $track_lead="Aaron Zeckoski - aaronz@vt.edu"; break;
		case "Other": $track_lead="Peter Knooop - knoop@umich.edu";  $track="Multiple Audiences"; break;

	}
	$msg.="Track: " . $proposal['track']."\r\n\r\n"; 

	$msg.="Track Lead: $track_lead \r\n\r\n\r\n";
	
	$msg.="---Important Reminders---\r\n\r\n";
	$msg.="- Hotel Information:  The Sakai room block is filling up, make your reservations now!\r\n See http://sakaiproject.org/conference/hotel.html \r\n\r\n";
	
	$msg.="- Have you registered for the conference?  If not, please do so now at \r\nhttp://sakaiproject.org/conference/register.html \r\n\r\n";
	//$msg.="- The draft conference schedule is available at \r\nhttps://sakaiproject.org/conference/admin/draft_schedule.php. \r\n\r\n\r\n";
	
	//$msg.="A wiki page for your session has been created on the Sakai Atlanta conference confluence site at http://bugs.sakaiproject.org/confluence/display/CONF06/Conference+Sessions. We strongly encourage you to begin adding presentation material and other information regarding your session to your wiki page as soon as possible. \r\n\r\n";

	$msg.="\r\nThank You\r\n\r\n    Mary Miles \r\n Sakai Conference Coordinator\r\n";
	 	
	$this_email=$proposal['email'];
	
	//end of email message
			
		// mail headers -AZ
		ini_set(SMTP, $MAIL_SERVER);
		$headers  = 'From: ' . $HELP_EMAIL . "\n";
		$headers .= 'Return-Path: ' . $HELP_EMAIL . "\n";
		$headers .= 'Reply-To: ' . 'mmiles@umich.edu' . "\n";
		$headers .= 'MIME-Version: 1.0' ."\n";
		$headers .= 'Content-type: text/plain; charset=ISO-8859-1' ."\n";
		$headers .= 'X-Mailer: PHP/' . phpversion() ."\n";
			
					
		//set up mail for the speaker
	//	$recipient = $this_email;
	//	$subject= "Sakai Conference Presentation";
		//send the mail to attendee
	//	@mail($recipient, $subject, $msg, $headers);
		
				
		//set up mail for susan
		//$recipient = "shardin@umich.edu";
		//$subject= "Copy-Your Sakai Conference Presentation schedule";
		//send the mail to attendee
		//mail($recipient, $subject, $msg, $headers);

		//set up mail for susan
		$recipient = "shardin@umich.edu";
		$subject= "COPY-Presentation email";
		//send the mail to susan
		@mail($recipient, $subject, $msg, $headers);

	//	echo $this_email ."<br/>";
	//	echo "<pre>$msg <br/><br/></pre>";	
			
			
			?>
			
			</tr></tr>
			
		<?php 
		}  //end foreach session 
	
?>

<tr>

<td colspan="2"><input type="submit" value="Check All"/>
</td>
<td colspan="2">&nbsp;</td>
<td align="center">
<input type="submit" value="Send Email"/>
</td>
</tr>
</table>
</form>
</div>


<br/>
<div class="right">
<div class="rightheader">How to use the Presenter Email tool</div>
<div style="padding:3px;">
<div>Speakers are listed in the order of their sessions re-sort them by clicking on the headers for each column</div>
<div>To send a speaker the default message shown  at the top of the page, check the <strong>Send Email</strong> box next to the speaker's session.<br/></div>
<div>To only show all speakers, click the <strong>ALL</strong> button at the top</div>
<div>To only show speakers who have not checked in been sent an email, click the <strong>NOT SENT</strong> button at the top</div>
<div>To only show users who have already been emailed, click the <strong>SENT</strong> button at the top</div>
<div>If a speaker has <strong>not</strong> been emailed yet, then an <font color="#ffcc66">orange</font> mail icon <img width="30" height="20" src="../include/images/mail.jpg" alt="not emailed yet" /> will appear in the SENT column.  If a badge has been printed, a <font color="red">red</font> mail icon <img width="30" height="30" src="../include/images/redMail.jpg" alt="already printed " /> will appear in the Sent column.  </div>
<div><br/>To send email to all speakers at once, click the <strong>(Send All Email)</strong> link at the top</div>
<div>To send email messages for a select group of users, check the box(es) in the SENT column and click the <strong>Send Email</strong> button at the bottom of the page</div>
</div>
</div>

<?php include $TOOL_PATH.'include/admin_footer.php'; ?>

