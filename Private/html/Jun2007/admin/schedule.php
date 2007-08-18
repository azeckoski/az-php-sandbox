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
$CONF_ID="Jun2007";
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
		"CP.type, CP.length, CP.order_num from conf_proposals CP " .
		"join conf_sessions CS on CS.proposals_pk = CP.pk " .
		"where CP.confID = '$CONF_ID' and CP.approved='Y' and track!='unavailable'";
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
$CSS_FILE2 = "../include/schedule.css";

$CSS_FILE3 = $TOOL_URL."/include/print_scheduleTabloidWidecss.css";
$DATE_FORMAT = "M d, Y h:i A";

if ( ($User->checkPerm("admin_accounts")) || ($User->checkPerm("admin_conference")) || ($User->checkPerm("proposals_dec2006")) || ($User->checkPerm("registration_dec2006"))   ) {
// top header links for admins
	$EXTRA_LINKS = "<span class='extralinks'>" ;
	$EXTRA_LINKS .= "<a class='active' href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
			if ($VOLUNTEER) { 
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/volunteer.php'>Volunteer</a>"; 
			$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/volunteers.php'>Convener List</a>"; 
	
	
		}
	$EXTRA_LINKS .="</span>";
} else {
// set header links
$EXTRA_LINKS = "<span class='extralinks'>" ;
	
//$EXTRA_LINKS.="<a  href='/conference/index.php'><strong>Home</strong></a>:";
		
//$EXTRA_LINKS.=	"<a href='$CONFADMIN_URL/registration/index.php'>Register</a>" .
	//	"<a  href='$CONFADMIN_URL/proposals/index.php'>Call for Proposals</a>" ;
		
	if ($SCHEDULE_PUBLISHED) { 
		$EXTRA_LINKS .= "<a class='active' href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
//			$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/volunteer.php'>Volunteer</a>";
	
			 }  else {
		 		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/draft_schedule.php'>Schedule</a>";
			//header('Location:draft_schedule.php');
		 	
		 }
		
		
	$EXTRA_LINKS .="</span>";
	
}
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

<?php // INCLUDE THE HEADER 
include $ACCOUNTS_PATH.'include/Jun2007header.php'; ?>


<?= $Message ?>
<div style="background:#fff;  border: 1px solid #336699; text-align:center;"><h3>This is the schedule from the 7th Sakai Conference, held in Amsterdam, The Netherlands in June 2007</h2>
<h3>You are invited to attend the <a href="/conference/index.php">8th Sakai Conference in Newport Beach California</a></h3> </div>

<?php
echo "<div class='page'>" .
			"" ;
	
		
			echo "<div class='program_legend' style=' padding:0px 10px;'>" .
					"<div class='graphic_legend'><strong>Special Interest: </strong>" .
			"<span><img src='../include/images/book06.gif' alt='' height=17 /> - Library </span>" .
			"<span><img src='../include/images/coolToolicon.gif' alt='' height=16 /> - Cool New Tool </span>" .
		
				"<span><img src='../include/images/ospiNEWicon2.jpg' alt='' height=15 /> - OSP (Open Source Portfolio) </span></div>" .
				"<div class='color_legend'>" .
				"<strong>Color Legend: </strong><span class='technology'>Technical</span>" .
				"<span class='other'>Multiple Audiences</span><span class='implementation'>Implementation</span><span class='research'>Research</span><span class='tool_carousel'>Tool Carousel</span>" .
				"<span class='pedagogy'>Teaching &amp; Learning</span><span class='user_experience'>User Experience</span></div></div>" ;
	
echo "</div>";
?>
<form name="adminform" method="post" action="<?=$_SERVER['PHP_SELF']; ?>" style="margin:0px;">
<input type="hidden" name="sortorder" value="<?= $sortorder ?>"/>
<table border='0' cellspacing='0' cellpadding="2" style='width:100%;height:100%;  padding:10px;'>

 <tr><td colspan=5 style="font-size:1.1em;">
	 <br/>
		 <table border='0' cellspacing='0' cellpadding="2" width=100%>
			<tr><td colspan=3 style="font-size:1em;">
			<span id="special"></span><strong>Go to: </strong>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#special'>Special Events <img src="../include/images/arrow.gif" border="0"></a>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#preconf'>Pre-Conference <img src="../include/images/arrow.gif" border="0"></a> 
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#1'>Day 1 <img src="../include/images/arrow.gif" border="0"></a>
			 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#2'>Day 2 <img src="../include/images/arrow.gif" border="0"></a>
			  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#3'>Day 3 <img src="../include/images/arrow.gif" border="0"></a>
			  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='https://collab.sakaiproject.org/direct/eval-evalcategory/Sakai%20Amsterdam%2007' style="color:green; font-weight:bold;">*Evaluations &nbsp;<img src="../include/images/arrow.gif" border="0"></a></td></tr>
			<tr>
				<td colspan=3 class="grid" style="border: 1px solid #ccc;"><span id="special"> </span>
			 <h1>Special Events</h1>
			 	</td>
			 </tr>
			 <tr>
				 <td class="grid_event_med" valign=top  style="padding:2px 15px; border:1px dotted #ccc;; width:28%; text-align:left; background:#ffffff; ">
					 <br/><div><strong> Keynote Speaker: <em style="color:#660000;"> Hal Abelson</em>  </strong>
					 <br/><em>09:00 to 10:00 - Tuesday, June 12 <br/> (Matterhorn 1, 2, & 3)</em><br/>
					 <br/>Hal Abelson is a founding director of the Free Software Foundation and of Creative Commons.
					  He also serves as consultant to Hewlett-Packard Laboratories.  At MIT, Abelson is co-director 
					  of the MIT-Microsoft Research Alliance in educational technology and co-head of MIT's Council on Educational Technology.
					  He is also active in MIT's OpenCourseWare and DSpace (institutional digital archiving) initiatives.
					 </div>
			 	</td>
				 <td class="grid_event_med" valign=top style="padding:2px 15px; border:1px dotted #ccc;  width:28%; text-align:left; background:#ffffff;  ">
					<br/> <div><strong>Local Welcome and Reception<br/></strong><em>18:00 to 19:30 - Tuesday, June 12  </em>
					 <br/><em>(Matterhorn 1, 2, &amp; 3)</em><br/><br/>
					 Paul Doop, Vice Chancellor of the University of Amsterdam will provide a local welcome to all, in the Matterhorn
					 rooms at 18:00, which will be followed by the Welcome Reception in the atrium.<br/><br/>
					 <br/><br/><br/>
					 <strong>Event Sponsored by:</strong>  Thomson Learning<br/>
					 
					 </div>
					 </td>
				 <td class="grid_event_med" valign=top style="padding:2px 15px; border:1px dotted #ccc; width:28%; text-align:left; background:#ffffff;  ">
					<br/>		<div><strong>Technology Demonstrations<br/></strong><em>18:00 to 20:30 - Wednesday, June 13  </em>
							<br/><em>(Matterhorn 1, 2, & 3)</em><br/><br/>
						 The Technology Demos and Reception continues to be one of the most highly anticipated events of the conference.  
						   It's a chance to relax, network, and share in the success and growth of so many Sakai projects.  Technology demos 
						 have added significant value to previous Sakai conferences and we know that it will be 
						 true of this conference as well. <br/>
						 
						 	 <br/>
					 <strong>Event Sponsored by:</strong> rSmart, IBM, and Stoas<br/>
				 </div>
						
				  </td>
		  </tr><tr>
				<td colspan=3 class="grid" style="border: 1px solid #ccc; padding:3px">
			<div style="font-size:.95em;"><strong>Enhanced Internet Services Sponsored by</strong> :  SURF</div>
			 	</td>
			 </tr></table>
  
</td></tr><tr><td colspan=5 style="font-size:1em;">&nbsp;
<tr><td><div style="height:30px;">&nbsp;</div></td></tr>	
		<tr><td colspan=5 style="font-size:1.1em;"><span id="preconf"></span><strong>Go to: </strong>
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#special'>Special Events <img src="../include/images/arrow.gif" border="0"></a>
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#preconf'>Pre-Conference <img src="../include/images/arrow.gif"  border="0"></a>
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#1'>Day 1 <img src="../include/images/arrow.gif" border="0"></a>
		 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#2'>Day 2 <img src="../include/images/arrow.gif" border="0"></a> 
		  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#3'>Day 3 <img src="../include/images/arrow.gif" border="0"></a>
		  	  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='https://collab.sakaiproject.org/direct/eval-evalcategory/Sakai%20Amsterdam%2007' style="color:green; font-weight:bold;">*Evaluations &nbsp;<img src="../include/images/arrow.gif" border="0"></a>
		  	  </td></tr>
		
	 <tr><td class='date_header page' nowrap='y' colspan='5'>Pre-Conference  - Monday, Jun 11, 2007</td></tr>
	<tr><td class='time_header' nowrap='y'>Jun 12</td><td class='schedule_header' nowrap='y'>Matterhorn 1</td>
	<td class='schedule_header' nowrap='y'>Matterhorn 2</td><td class='schedule_header' nowrap='y'>Zurich 2</td><td class='schedule_header' nowrap='y'>Winterthur</td></tr>
	
	<tr class="event">
	<td class="time" nowrap='y'>
		09:00 - 
		12:40
	</td>
       		
 		
		     <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%>
		     <tr><td  class='grid_event_med' style="height:250px; padding: 2px 5px;"> 		
		     			<div class='grid_event_header techincal'>Programmer's Cafe</div>
		     			<div class='grid_event_text' style="text-align:left"><div>
<strong>Full Day Workshop</strong> (part 1)<br/><br/>
We will be doing a hands-on workshop (by popular demand) and will be writing a functional tool (similar to Vancouver) in RSF. <br/><br/>

There will be short special sessions after lunch.<br/>
1) Developer involvement in Sakai (Peter Knoop)<br/>
2) Licensing issues in Sakai development (TBD) (maybe)<br/>

There will also be a combined Designer/Developer session at the
end of the day.
  </div></div><div class='grid_event_speakerDay1'></div></table></td>       		
		     <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr><td  class='grid_event_med' style="height:250px; padding: 2px 5px;"> 				
		     	<div class='grid_event_header implementation'>Introduction to Sakai</div><div class='grid_event_text ' >
		     	<div style="text-align:left;"><strong>1/2 Day Workshop</strong><br/><div class='grid_event_speakerDay1'>Anthony Whyte</div><br/>Newcomers to the Sakai Community and those looking to understand Sakai's Collaboration and Learning Environment (CLE) should consider attending this session. It traces the evolution of Sakai from project to foundation; describes Sakai's community-source approach to software design, development, and distribution; showcases Sakai's CLE feature set with a live demonstration; outlines current community processes covering design, development,
		      documentation, and testing; and ends with a discussion on ways to get involved in the community.
		      <br/><br/><a href="http://confluence.sakaiproject.org/confluence/pages/viewpageattachments.action?pageId=45506" title="download presentation materials">
							<img src='../include/images/pptIcon.jpg' border=0 height=13 width=15 style='padding: 7px 10px;' alt='link to presentation' /></a>
		      </div></div></table></td>       		
		      <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr>
		    <td  class='grid_event_med' style="height:250px; padding: 2px 5px;"> 				
		    	<div class='grid_event_header user_experience'>U-Camp</div><div class='grid_event_text '>
		    	<div style="text-align:left;"><strong>Full day workshop.</strong> (part 1)<br/><br/>
		    	This full-day workshop will provide an opportunity for those interested in the user 
		    	experience of Sakai to meet, learn, and contribute to the future of Sakai. The U-Camp 
		    	includes a combination of talks and hands-on workshops that will provide effective techniques 
		    	for how to design more usable and inclusive user interfaces. 
		    	<br/><br/>See workshop topics listed in afternoon session. 
		    	Introduction to S
		    	</div>
		    	
	    	</div>
		    	<div class='grid_event_speakerDay1'></div></table></td>   <td  class='grid'>&nbsp;</td>       		
		    </tr>
		    
<tr class="coffee">
	<td class="time" nowrap='y'>
		12:40 - 
		13:40	
	</td>
<td align='center' colspan='4'><div style='padding: 3px; '><strong>LUNCH</strong></div></td></tr>

	<tr class="event">
	<td class="time" nowrap='y'>
		13:40  - 
		17:40	
	</td>
       		
	    <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr>
	    <td  class='grid_event_med' style="height:340px; padding: 2px 5px;"> 			
	    		<div class='grid_event_header techincal'>Programmer's Cafe</div><div class='grid_event_text' style="text-align:left"><div><strong>Full Day Workshop</strong> (part 2)<br/><br/>

Continuation of the Programmers'
Cafe<br/><br/>

Complete the development of the RSF tool.
<br/><br/>
<strong>Combined session:</strong><br/>
We will be bringing together the U-Camp attendees and the Programmers Cafe attendees and talking about Designers and Developers working together to
improve the Sakai user experience. Practical tips and examples will be presented to help both groups work together more closely and to assist developers
without the benefit of a local UI expert. Combined session led by Colin Clark,
Daphne Ogle, Harriet Truscott, Aaron Zeckoski
</div></div></table></td>       		
		    <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr>
		    <td  class='grid_event_med' style="height:340px; padding: 2px 5px;"> 			
		    		<div class='grid_event_header pedagogy'>Introduction to OSP </div><div class='grid_event_text ' style="text-align:left">
		    		<div><strong>1/2 day workshop</strong><br/><br/></div>Explore the varied uses of portfolios (from institutional assessment 
		    		to achieving learning goals to personal presentations), recieve a tour of several OSP implementations, 
		    		and gain a detailed overview of the functionality of each component of OSP. 
		    		
		    		 The session 
		    		will begin with an overview of the goals and motivations universities have for using portfolios, and include 
		    		examples of different types of portfolios implemented at various institutions.Ê
<br/><br/>
The session will also provide a roadmap for the rest of the OSP conference sessions to help participants make the best use of their time during the conference. 
<br/><br/> <a href="http://bugs.sakaiproject.org/confluence/pages/viewpageattachments.action?pageId=45149" title="download presentation materials">
							<img src='../include/images/pptIcon.jpg' border=0 height=13 width=15 style='padding: 7px 10px;' alt='link to presentation' /></a>
</table></td>       		
		    <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr>
		    <td  class='grid_event_med' style="height:340px; padding: 2px 5px;"> 				
		    	<div class='grid_event_header user_experience'>U-Camp</div><div class='grid_event_text '>
		    	<div style="text-align:left; padding: 2px 5px;"><strong>Full day workshop.</strong> (part 2)<br/><br/>
		    	Full day workshop topics  include:
<ul>
<li> - Design Patterns</li>
<li> - Accessibility & Design</li>
<li> - RSF</li>
<li> - The Fluid Project</li>
<li> - Panel Discussion: Design that Works</li>
<li> - Hands-on design workshop with Mark Notess</li>
<li> - Redesigning Sakai tools based on requirements</li>
</ul>
There will also be a combined session with the Programmers Cafe at the end of the day. We will be bringing together attendees of the U-Camp and the Programmers Cafe to talk about how designers and developers can work together to improve the Sakai user experience. Practical tips and examples will be presented to help both groups work together more effectively. We hope this will result in questions, discussion, and new friendships and alliances.
	</div>
		    	
	    	</div>
		    	<div class='grid_event_speakerDay1'></div></table></td>       		
			    <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr>
			    <td  class='grid_event_med' style="height:340px;"> <div class='grid_event_header technical'><strong> Special Workshop</strong></div>
			    
			    <div class='grid_event_text '><div style="text-align:left; padding: 2px 5px;"><strong>
ContentHostingHandler &amp; ResourceTypeRegistry</strong><br/><div class='grid_event_speakerDay1'>Ian Boston, John Ellis, Jim Eng</div><br/>
This workshop will explore these two features new in the 2.4.0 release, that allow developers to define new
 functionality for Sakai's Content Hosting Service and Resources tool.  A CHH might act as a proxy for  an external 
 repository or file system, 
 giving remote access to folders and files.  Another CHH might mediate interactions with a packaged resource, to 
 provide direct access to their contents without downloading or unpacking the entire resource. ResourceTypeRegistry 
 manages definitions types of resources for the Resources tool. The registration for a resource type can define custom 
 actions and behaviors for resources.<br/><br/>   We will give an overview of the features in these two APIs and some possible uses, and work through 
    examples in which a CHH is used to enable access to parts of a packaged resource and in which type 
    registrations define the way in which the Resources tool affords user access to resources.
</div></div></table></td>       		
		</tr>

</table>
<table border='0' cellspacing='0' cellpadding="2" style='width:100%;'>
 
 <tr><td><div style="height:30px;">&nbsp;</div></td></tr>	<tr><td class='date_header page' nowrap='y' colspan='4'>Post-Conference - Friday, Jun 15, 2007</td></tr>
	<tr><td class='time_header' nowrap='y'>Jun 12</td><td class='schedule_header' nowrap='y'><strong>LOCATION: </strong> Universiteit van Amsterdam</td><td class='schedule_header' nowrap='y'><strong>LOCATION: </strong> TBA</td></tr>
	
	<tr class="event">
	<td class="time" nowrap='y'>
		09:00 - 
		15:00
	</td>
       		
 		
		    <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr><td  class='grid_event_short' style="padding: 2px 5px; height:130px;"> 					<div class='grid_event_header implementation'>OSP Post-Conference Workshop</div><div class='grid_event_text '><div style="text-align:left;"><strong>OSP post conference meeting</strong><br/><br/>
This day long meeting is being hosted by Universiteit van Amsterdam<br/><br/>
<strong>Time: </strong>	09:00 - 15:00	<br/>
<strong>Location:</strong>	Universiteit van Amsterdam, Herengracht 182, room 007	<br/>
<strong>Features:</strong>	Wireless (and probably wired also) Beamer, Whiteboard, Flipover and Lunch.
</div></div><div class='grid_event_speakerDay1'></div></table></td>       		
		   <td  class='grid'><table border=0 cellpadding='0' cellspacing='0' width=100%><tr><td  class='grid_event_short' style="padding: 2px 5px; height:130px;"> 					<div class='grid_event_header implementation'>TBA</div><div class='grid_event_text '><div><strong>Other post-conference meetings...
TBA
</strong></div></div><div class='grid_event_speakerDay1'></div></table></td>     </tr>
		    
<tr style='page-break-before:always;'><td colspan=8>&nbsp;</td></tr>
</table>

<table border="0" cellspacing="0" style='width:100%;height:100%;'>
<?php
// create the grid
$line = 0;
$last_date = 0;
$conference_day = 0;
foreach ($timeslots as $timeslot_pk=>$rooms) {
	$line++;

	$timeslot = $conf_timeslots[$timeslot_pk];
	// HANDLE HEADER
	$current_date = date('M d',strtotime($timeslot['start_time']));
	if ($line == 1 || $current_date != $last_date) {
		// next date
		$conference_day++;

		// create a blank line if after first one
		if ($line > 1) {
			echo "<tr><td style='page-break-before: always;'>&nbsp;</td></tr>\n";
		}
		echo "<tr><td><br/><br/><span id=$conference_day></span></td></tr>";
		echo "<tr><td colspan=5 style='font-size:1.1em;'>" .
				"<strong>Go to: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .
				"<a href='#special'>Special Events <img src='../include/images/arrow.gif'  border='0'></a>" .
				" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#preconf'>Pre-Conference <img src='../include/images/arrow.gif' border='0'></a>" .
				" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#1'>Day 1 <img src='../include/images/arrow.gif'  border='0'></a> " .
				" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#2'>Day 2 <img src='../include/images/arrow.gif'  border='0'></a>" .
				" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='#3'>Day 3 <img src='../include/images/arrow.gif'  border='0'></a>" .
				" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='https://collab.sakaiproject.org/direct/eval-evalcategory/Sakai%20Amsterdam%2007' style='color:green; font-weight:bold;'>*Evaluations &nbsp;<img src='../include/images/arrow.gif' border='0'></a></td></tr>";
		// print date header
		echo "<tr>\n";
		echo "<td class='date_header' nowrap='y' colspan='" .
				(count($conf_rooms) + 1) . "'>" .
				"Conference day $conference_day - " .
				date('l, M j, Y',strtotime($timeslot['start_time'])) .
				"</td>\n";
		echo "</tr>\n\n";
		
		// print the room header
		echo "<tr>";
		echo "<td class='time_header' nowrap='y'>$current_date</td>\n";
		foreach($conf_rooms as $conf_room) {
			$type = "schedule_header";
			if ($conf_room['BOF'] == 'Y') {
				if ($hide_bof_rooms) { continue; }
				$type = "bof_header";
			}
			echo "<td class='$type' width=12%  nowrap='y'>".$conf_room['title']."</td>\n";
		}
		echo "</tr>\n\n";
	}
	$last_date = $current_date;
   
	$linestyle = "event";
	switch ($timeslot['type']) {
		case "break": $linestyle = "break"; break;
		case "bof": $linestyle = "bof"; break;
		case "lunch": $linestyle = "lunch"; break;
		case "coffee": $linestyle = "coffee"; break;
		case "keynote": $linestyle = "keynote"; break;
		case "special": $linestyle = "keynote"; break;
		case "closed": $linestyle = "closed"; break;
		default: $linestyle = "event";
	}
	if ($timeslot['type'] == "event") {
	$block++;
	$block_id="block".$block;
		// print the room header
		echo "<tr>";
		echo "<td class='time' nowrap='y' id='$block_id'></td>\n";
		foreach($conf_rooms as $conf_room) {
			$type = "schedule_header";
			if ($conf_room['BOF'] == 'Y') {
				if ($hide_bof_rooms) { continue; }
				$type = "bof_header";
			}
			echo "<td class='$type' width=12%  nowrap='y'>".$conf_room['title']."</td>\n";
		}
		echo "</tr>\n\n";
	}
?>
<tr class="<?= $linestyle ?>">
	<td class="time" nowrap='y'>

		
		 <?=  date('H:i ',strtotime($timeslot['start_time'])) ?>
		 - 
		<?= date('H:i ',strtotime($timeslot['start_time']) + ($timeslot['length_mins']*60)) ?>

	</td>


<?php
	if ($timeslot['type'] != "event") {
			
			echo "<td align='center' colspan='".count($conf_rooms)."'>" .
					"<div style='font-size:1em; padding: 3px;'>";
				if ($isAdmin) { echo 	"<br/>"; }
				if ($timeslot['type'] == "lunch" || $timeslot['type'] == "break") {
					echo "<strong>".$timeslot['title']." - ". date('l, M d, Y',strtotime($timeslot['start_time'])) ."</strong> </div></td>";
				}
				else {
					echo "<strong>".$timeslot['title']."</strong> </div></td>";
				}			    
		
	} else {
		// print the grid selector
		foreach ($rooms as $room_pk=>$room) {
			
			$conf_room = $conf_rooms[$room_pk];
			if ($conf_room && $conf_room['BOF'] == 'Y' && $hide_bof_rooms) { continue; }

			// TODO - try to get the sessions to fill the cells
			echo "<td valign='top' class='grid' style='height:10%;'>";
			// try tables instead of divs
			echo "<table style='width:100%;height:100%;' cellpadding='0' cellspacing='0'>";
				
		// session check here
			$total_length = 0;
			if (is_array($room)) {
				$counter = 0;
					$start_time1="";
					$start_time2="";
					$start_time3="";
					
				foreach ($room as $session_pk=>$session) {
					$counter++;
					$proposal = $conf_proposals[$session['proposals_pk']];
					
				  if ($counter=="1") {	//get the starttime for this timeslot
					$start_time1=date('H:i',strtotime($timeslot['start_time']) );
					
					//clear any previous time set for second and 3rd timeslots
				 
					$proposal = $conf_proposals[$session['proposals_pk']];
					$end_time1=date('H:i',strtotime($timeslot['start_time']) + (($proposal['length']) *60));
						$total_length += $proposal['length'];
            	
				  }
				 if (!$proposal==NULL){ //do not show the empty bof spaces as sessions
                     	
					//echo "<div class='grid_event'>";
                 	if ($counter>1){	 //more than one session in this room block
				  
					$breaktime="5 min";
					//print the break block	
?>
				<tr>
					<td valign='top' style="line-height:5px;">&nbsp;
					</td>
				</tr>
<?php
					}
					
				  
					if ( $proposal['length']=='90') {
					
					echo "<tr><td class='grid_event_long' >" ;
						
						
					} else  if ( $proposal['length']=='30')  {
					echo "<tr><td  class='grid_event_short'> ";
					}
					else  if ( $proposal['length']=='60')  {
					echo "<tr><td  class='grid_event_med'>";
					}
					//	echo $proposal['length'];
				
					?>
					<?php
				
					if($proposal['track']) { 
					  
					   $trackclass = str_replace(" ","_",strtolower($proposal['track']));
					   
					   if ($proposal['track']=="Other") {
					   	echo "<div class='grid_event_header $trackclass'>"."Multiple Audiences";
					
					echo "</div>";
						
					   } else {
					   	
					    		 if ($proposal['track']=="Teaching & Learning") {
					   	$trackclass="pedagogy";
					   }
					   	
						echo "<div class='grid_event_header $trackclass'>".$proposal['track'];
					echo "</div>";
					
					}
					}
					   
					

					if($proposal['type']=="BOF") { //don't list the type on the schedule
						$typeclass = "";
					}
					
						
					if  ($counter=="2") {  //there is a second session so print that start time
					$break_time="5 min. ";
						$proposal = $conf_proposals[$session['proposals_pk']];
				
						$start_time2=date('H:i',strtotime($timeslot['start_time']) + (($total_length + 5) *60));
						$end_time2=date('H:i',strtotime($start_time2) + (( $proposal['length']) *60));	
						echo "&nbsp;<strong> "  . $start_time2 . " - " .$end_time2 ."</strong>&nbsp; &nbsp;( " .$proposal['length'] ." min. )";
						$total_length += $proposal['length'] +5;
            	
					
						}
					else	if  ($counter=="3") {  //there is a second session so print that start time
							$break_time="5 min. ";
					$proposal = $conf_proposals[$session['proposals_pk']];
				
						$start_time3=date('H:i',strtotime($timeslot['start_time']) + (($total_length + 5) *60));
						$end_time3=date('H:i',strtotime($start_time3) + (( $proposal['length']) *60));
							$total_length += $proposal['length'];
            	
				echo "&nbsp;<strong> "  . $start_time3 . " - " .$end_time3 ."</strong>&nbsp;&nbsp;( " .$proposal['length'] ." min. )";
					
							
						} else { 
							echo "<div class='session_time'>&nbsp;<strong> "  . $start_time1 . " - " .$end_time1."</strong>&nbsp; &nbsp;";
							echo "<br/>(" .$conf_room['title'] .") " .$proposal['length'] ." min.";
							echo "</div>"; 
					
							
					}
					echo "<div class='grid_event_text $typeclass'>";
					
					//echo "<label title=\"".str_replace("\"","'",htmlspecialchars($proposal['abstract']))."\">";
					
					if($proposal['sub_track']) { 
						//echo "<br/> (" .$proposal['sub_track'] .")";
						$image_file="";
						switch ($proposal['sub_track']) {
								case "OSP": $image_file = "ospiNEWicon.jpg"; $width="width=12"; break;
							case "Cool New Tool": $image_file = "coolToolicon.gif"; $width="height=17 width=17"; break;
							case "Cool Commercial Tool": $image_file = "coolCommercialToolicon.gif"; $width="height=17 width=17"; break;
							case "User Experience": $image_file = "people_icon.jpg"; $width="height=17 width=17"; break;
							case "Library": $image_file = "book06.gif"; $width="height=17 width=17"; break;
						
	}
						?>
						<img style="padding: 0px 4px 0px 0px;" src="../include/images/<?=$image_file?>" <?=$width?> align="left" alt="img" />
						
			<?php		}
								if ($proposal['wiki_url']) {
						
						echo "<div><strong><a href='" .$proposal['wiki_url'] ."' title='this session wiki page'>"  .htmlspecialchars($proposal['title']) . "</a></strong>";
							if (($isAdmin) && ($isActive)){
						echo "&nbsp;<a href='delete_session.php?pk=".$session_pk ."&amp;type=" .$proposal['type'] ." ' style='color:red'>x</a>";
					}
					echo "</div>";
				 }
				 else  {
				 echo "<div><strong>"  .htmlspecialchars($proposal['title']) . "</strong>";
				 		if (($isAdmin) && ($isActive)) {
						echo "&nbsp;<a href='delete_session.php?pk=".$session_pk ."&amp;type=" .$proposal['type'] ." ' style='color:red'>x</a>";
					}
                 echo "</div>";
				}
				
					//echo "</label>";

					
					echo "</div>";
				

					if($proposal['speaker']) {
						echo "<div class='grid_event_speaker'>".
							htmlspecialchars($proposal['speaker']);
					
					if ($proposal['co_speaker']) {
						echo ", ". htmlspecialchars($proposal['co_speaker']);
						
					} 
					echo "</div>";
					
				}
				echo "<div style='text-align:left;'>";
				
				if ($proposal['slides_url']) { /* a wiki URL was provided */
						echo "<a href='".$proposal['slides_url']."' title='download presentation materials'>" .
							"<img src='../include/images/pptIcon.jpg' border=0 height=13 width=15 style='padding: 7px 10px;' alt='link to presentation' /></a>";
					}
				if ($proposal['podcast_url']) { /* a wiki URL was provided */
						echo "<a href='".$proposal['podcast_url'] ."' title='listen to the podcast'>" .
							"<img src='../include/images/soundIcon-1.jpg' alt='link to podcast' border=0 height=15 width=17 style='padding: 5px 10px;'  /></a>";
					}
					echo "</div>";
					 
				 
                     }
					
				}
				
			}
		
			echo "</table>";
			
			// time check here
			$remaining_time = $timeslot['length_mins'] - $total_length;
			if (($isAdmin) && ($isActive)){
				
			if ($remaining_time > 0 && $isAdmin) {
				echo "<span  class='remaining' style='font-size:.9em;'>$remaining_time</span>";
				echo "&nbsp;<a href='add_session.php?room=$room_pk&amp;time=$timeslot_pk' style='color:yellow;'>+</a><br/>";
			}
			}
					
			
			echo "</td>";
					
			
		}
		
		echo "</tr>";
		
	}
	
} 
?>

</table>
</form>

<?php if($isAdmin) { ?>
<br/>
<div class="right">
<div class="rightheader">How to use the scheduling grid</div>
<div style="padding:3px;">
<div style="padding:3px 0px;"><span class="schedule_header">Rooms</span> are shown across the top of the grid, 
<span class="bof_header">BOF rooms</span> are indicated.</div>
<div>The numbers in each <span class="event">event cell</span> indicate
the unused time available in that cell.</div>
<div>When no more time remains in an event timeslot, the number and + will not be shown.</div>
<div>
<ul>
<li><strong>Adding sessions to the schedule:</strong> Clicking on the 
<strong><a href="" class="grid" style="font-size:1.1em;">+</a></strong> will take you to 
a screen with a list of the currently approved proposals.</li>
<li><strong>Removing sessions form the schedule:</strong> 
Clicking on the <strong><a href="" class="grid" style="font-size:1.1em;">x</a></strong>
to the right of a session title will take you to a delete confirmation screen.
</li>
</ul>
</div>
</div>
</div>
<?php } ?>


<?php include $ACCOUNTS_PATH.'include/footer.php'; ?>
