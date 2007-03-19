<?php
/*
 * file: schedule.php
 * Created on May 09, 8:00 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Scheduling";
$ACTIVE_MENU="HOME";  //for managing active links on multiple menus

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
//opening up the bof viewing to all a week before the conference
$hide_bof_rooms = false;

// get the passed message if there is one
if($_GET['msg']) {
	$Message = "<div class='message'>".$_GET['msg']."</div>";
}

// hide BOF rooms
if($_REQUEST['hbr']) {
	$hide_bof_rooms = true;
}
// show BOF rooms
if($_REQUEST['sbr']) {
	$hide_bof_rooms = false;
}

// fetch the conference rooms
$sql = "select * from conf_rooms where confID = '$CONF_ID'";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_rooms = array();
while($row=mysql_fetch_assoc($result)) { $conf_rooms[$row['pk']] = $row; }

// fetch the conference timeslots
$sql = "select * from conf_timeslots where confID = '$CONF_ID' order by ordering";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_timeslots = array();
while($row=mysql_fetch_assoc($result)) { $conf_timeslots[$row['pk']] = $row; }

// fetch the conf sessions
$sql = "select * from conf_sessions where confID = '$CONF_ID' order by ordering";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_sessions = array();
while($row=mysql_fetch_assoc($result)) { $conf_sessions[$row['pk']] = $row; }

// fetch the proposals that have sessions assigned
$sql = "select CP.pk, CP.title, CP.abstract, CP.track, CP.sub_track, CP.speaker, CP.co_speaker, CP.URL, CP.wiki_url, CP.podcast_url, CP.slides_url," .
		"CP.type, CP.length from conf_proposals CP " .
		"join conf_sessions CS on CS.proposals_pk = CP.pk " .
		"where CP.confID = '$CONF_ID' and CP.approved='Y'";
$result = mysql_query($sql) or die("Fetch query failed ($sql): " . mysql_error());
$conf_proposals = array();
while($row=mysql_fetch_assoc($result)) { $conf_proposals[$row['pk']] = $row; }


// now put these together into a 3D array
$timeslots = array();
foreach($conf_timeslots as $conf_timeslot) {
	$rooms = array();
	if ($conf_timeslot['type'] != 'event') {
		// we don't need all the rooms inserted for rows that don't use them
		$rooms['0'] = '0'; // placeholder
	} else {
		foreach($conf_rooms as $conf_room) {
			$sessions = array();
			foreach($conf_sessions as $conf_session) {
				if ($conf_session['timeslots_pk'] == $conf_timeslot['pk'] &&
					$conf_session['rooms_pk'] == $conf_room['pk']) {
						$sessions[$conf_session['pk']] = $conf_session;
				}
			}
			$rooms[$conf_room['pk']] = $sessions;
		}
	}
	$timeslots[$conf_timeslot['pk']] = $rooms;
}


//echo "<pre>",print_r($timeslots),"</pre>"; 

// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
$CSS_FILE2 = $TOOL_URL."/include/schedule.css";
$DATE_FORMAT = "M d, Y h:i A";


// set header links
$EXTRA_LINKS = "<span class='extralinks'>" ;
	
			
		
$EXTRA_LINKS.="<a  href='$ACCOUNTS_URL/index.php'><strong>Home</strong></a>:";
		
$EXTRA_LINKS.=	"<a href='$CONFADMIN_URL/registration/index.php'>Register</a>" .
		"<a  href='$CONFADMIN_URL/proposals/index.php'>Call for Proposals</a>" ;
		
	if ($SCHEDULE_PUBLISHED) { 
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
		 }  else {
		 		$EXTRA_LINKS .= "<a class='active' href='$CONFADMIN_URL/admin/draft_schedule.php'>Schedule</a>";
	
		 	
		 }
		
		
		
	$EXTRA_LINKS .="</span>";
	

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
// -->
</script>

<?php include $ACCOUNTS_PATH.'include/header.php'; // INCLUDE THE HEADER ?>


<?= $Message ?>
<h3>Draft Schedule</h3><p>For more information please visit the <a href="http://sakaiproject.org/conference/index.html">conference website.</a></p> 
<table width="500px" cellpadding="0" border="0">
<tbody><tr style="background-color: rgb(204, 204, 153);" align="center"><td valign="top" colspan="2">
<p><strong><font color="#000000">PRE-CONFERENCE WORKSHOPS <br />
 </font></strong><font color="#990000"><strong><font color="#000000">Location:</font>&nbsp; University of Amsterdam</strong></font> </p></td></tr><tr><td width="200" valign="top"><strong>Monday, June 11<br />
</strong></td><td width="398"><br />
</td></tr><tr><td valign="top" align="left">9:00 a.m. - 5:00 p.m.</td><td valign="top">
<p><strong>Half-Day and Full-Day Workshops:</strong></p>
<ul>
<li>Programmer's Cafe&nbsp; (full day) </li>
<li>
Introduction to Sakai (1/2 day)<br />
 </li>
<li>UI Camp -- User Support folks and Programmers welcome! (full day)<br />
</li></ul></td></tr><tr><td valign="top" colspan="2"><br />
</td></tr><tr style="background-color: rgb(204, 204, 153);" align="center"><td valign="top" colspan="2">
<p><strong><font color="#000000">MAIN CONFERENCE SCHEDULE<br />
</font></strong><font color="#990000"><strong><font color="#000000">Location:</font>&nbsp;&nbsp; Movenpick Hotel </strong></font><br />
 </p></td></tr><tr><td valign="top"><strong><u>Tuesday, June 12</u><br />
</strong></td><td valign="top"><br />
</td></tr><tr><td valign="top">8:00 a.m</td><td valign="top">
<p><strong>Registration Opens<br />
</strong></p></td></tr><tr><td valign="top">9:00 a.m. - 5:00 p.m.&nbsp; </td><td valign="top"><strong>Presentations and Breakout Sessions</strong></td></tr><tr><td valign="top">
5:30 p.m. - 6:30 p.m.</td><td valign="top"><strong>Welcome Reception</strong></td></tr><tr><td valign="top" colspan="1">
<p>6:30 pm&nbsp;&nbsp;&nbsp; - &nbsp; (?)&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;</p></td><td valign="top" colspan="1"><strong>Post-reception activities:&nbsp;&nbsp; TBA</strong><br />
</td></tr><tr><td valign="top" colspan="2">&nbsp;</td></tr><tr><td valign="top"><u><strong>Wednesday, June 13<br />
</strong></u></td><td valign="top"><br />
</td></tr><tr><td valign="top">8:00 a.m.</td><td valign="top"><strong>Registration Opens</strong></td></tr><tr><td valign="top">9:00 a.m. - 10:15 a.m. </td><td valign="top"><strong>Welcome and&nbsp; Conference Updates </strong></td></tr><tr><td valign="top">10:30 a.m. - 11:30 a.m.</td><td valign="top">
<p><font color="#660000"><strong><em>Keynote Speaker: <br />
</em></strong></font></p>
<blockquote><font color="#660000"><strong><em> <font color="#000000">Hal Abelson, MIT</font></em></strong></font><br />
</blockquote></td></tr><tr><td valign="top">11:45 a.m. - 5:00 p.m. </td><td valign="top"><strong>Presentations and Breakout Sessions</strong></td></tr><tr><td valign="top" colspan="1">
<p>5:30 p.m. - 8:00 p.m. </p></td><td valign="top" rowspan="1">
<p><strong>Technical Demonstrations and Posters Reception</strong> <br />
</p></td></tr><tr><td valign="top" colspan="2">&nbsp;</td></tr><tr><td valign="top"><u><strong>Thursday, June&nbsp; 14<br />
</strong></u></td><td valign="top"><br />
</td></tr><tr><td valign="top">8:30 a.m.</td><td valign="top"><strong>Registration Opens</strong></td></tr><tr><td valign="top">9:00 a.m. - 10:00 a.m</td><td valign="top">
<p><strong><em><font color="#660000">Keynote Speaker:&nbsp;</font> TBA</em></strong><strong><em><br />
</em></strong><br />
</p></td></tr><tr><td valign="top">10:15 a.m. - 4:30 p.m. </td><td valign="top"><strong>Presentations and Breakout Sessions</strong></td></tr><tr><td valign="top"> 4:30 p.m. - 5:00 p.m.<br />
</td><td valign="top"><strong>Closing Session<br />
</strong></td></tr><tr><td valign="top" align="left">
<p>&nbsp;</p></td><td valign="top"><strong><br />
</strong></td></tr><tr><td valign="top" colspan="1">
<p>&nbsp;</p></td><td valign="top" colspan="1">
<p>&nbsp;</p></td></tr><tr style="background-color: rgb(204, 204, 153);" align="center"><td align="center" colspan="2"><strong> POST-CONFERENCE MEETINGS</strong><br />
<font color="#990000"><strong><font color="#000000">Location:</font> TBA</strong></font></td></tr><tr><td valign="top" align="left">
<p><u><strong>Friday, June 15<br />
</strong></u></p></td><td valign="top"><br />
</td></tr><tr><td valign="top">Times TBA
</td><td valign="top"><strong>Birds of a Feather meeting space may be available<br />
</strong></td></tr><tr><td valign="top"><br />
</td><td valign="top"><br />
</td></tr></tbody></table>
<p>&nbsp;</p>

<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>"/>
<div class="padding50"></div>
<table border="0" cellspacing="0" style='width:100%;height:100%;'>

<?php include $ACCOUNTS_PATH.'include/footer.php'; ?>
