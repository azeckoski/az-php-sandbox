<?php
/*
 * Created on Febrary 20, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php

// Bring in the system variables
// You must verify the path to the system_vars and the
// user control directory are correct or many things will break -AZ
$ACCOUNTS_PATH = $_SERVER["DOCUMENT_ROOT"].'/accounts/';
require_once ($ACCOUNTS_PATH.'include/system_vars.php');

// Tool variables
$TOOL_URL = "/Jun2007";
$TOOL_PATH = $TOOL_URL;
$TOOL_NAME = "Jun2007";
$TOOL_SHORT = "conf";


//modify admin features
$adminID="Jun2007";  //allows  roles and other admin labels to change

$INST_REP=false;
$VOTE_REP=false;


$CONF_LOC = "Amsterdam Movenpick, Amsterdam, The Netherlands";
$CONF_NAME = "7th Sakai Conference";
$CONF_DETAILS = ""; 
$CONF_MGR= "Susan Hardin";
$CONF_MGR_EMAIL= "shardin@umich.edu";

//this is the event main web page
$CONF_URL = "http://sakaiproject.org/conference";
$CONF_DAYS= "June 12-14, 2007";
//$HELP_LINK = "include/help.php";

$CONF_ID = "Jun2007";
$CONF_URL = "http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=190&Itemid=615";
$REG_START_DATE = "2007/03/12 8:00";
$CFP_START_DATE = "2007/02/01 8:00";

$CFP_END_DATE = "2007/03/15 17:00";

$CONF_START_DATE = "2007/07/12 8:00";
$CONF_END_DATE = "2007/07/14 17:00";

// date format for display
$DATE_FORMAT = "l, F dS, Y g:i A";
$MED_DATE_FORMAT = "M d, Y (g A)";
$SHORT_DATE_FORMAT = "g A M d, y";

// proposals voting

$VOTE_TEXT = array("green", "yellow", "red");
$VOTE_HELP = array(
	"Proposal is appropriate",
	"Proposal needs work but idea is sound",
	"Proposal is inappropriate");
$VOTE_SCORE = array("2", "1", "0");

// dates below in format: YYYY/MM/DD HH24:MI
$VOTE_OPEN_DATE = "2007/02/01 8:00";
$VOTE_CLOSE_DATE = "2007/5/30 5:00";

// conference attendee reports
$CONF_REPORT_PATH = realpath($_SERVER["DOCUMENT_ROOT"]."/../reports/");
if ($ENVIRONMENT == "prod") {
	$CONF_REPORT_TO = "hardin@umich.edu,BCassidy@sefas.com,mmiles@umich.edu";
	$CONF_REPORT_CC = "shardin@umich.edu";
} elseif ($ENVIRONMENT == "test") {
	// TESTING
	$CONF_REPORT_TO = "shardin@umich.edu";
	$CONF_REPORT_CC = "aaronz@vt.edu";
} else { // assume dev environment
	$CONF_REPORT_TO = "aaronz@vt.edu";
	$CONF_REPORT_CC = "aaron@vt.edu";
}

// tool functions

//what type of event is this -- used in messages regarding the event
$EVENT_TYPE="conference";  //or conference, or event, or meeting

//proposals configuration - unique to each installation
$ACCEPT_PMT=true;  //no payment required for this event

		
$VOLUNTEER=true; //do not show the volunteer tools or menu link

$SCHEDULE=true; //do not show the schedule tool or menu link
$SCHEDULE_PUBLISHED=true; //the schedule is not available to the public yet

$REGISTRATION=true; //do not show the schedule tool or menu link

$PROPOSALS=true; //do not show the scheule tool or menu link


$FACEBOOK=false; //do not show the scheule tool or menu link

$SUBMIT_PAPER= false;
$PAPER_MSG="";

$SUBMIT_PRES=true;
$PRESENT_MSG="<strong>NOTE:</strong> Presentation call for proposals is now closed.  This option is left open for those who have been contacted by a committee member to update or submit a  proposal. <br/><br/> " .
		"    Presentations Presentations will take place at the conference hotel, during the conference's normal" .
		" daytime schedule for June 12-14. You may choose from the following presentation types: " .
		"Panel, Workshop, Discussion/Roundtable, Lecture/Presentation or Tool Carousel. ";
$ACCEPT_BOF=false;
$SUBMIT_BOF=true;
$BOF_MSG="BOFs (Birds of a Feather meetings) are self-formed meetings set up by any conference attendee." .
		"The meetings may take place at any time during the conference. " .
		" We have a limited group of rooms available for BOFs.  " .
		" When rooms are filled, we will do our best to locate community areas" .
		" within the hotel where you may gather for impromptu BOFS. <br/><br/>" .
		"SCHEDULING:  We will not begin scheduling BOFS until after May 1st, when the main schedule is finalized. ";
$BOF_INSTRUCTIONS ="<blockquote style='width:70%;'><strong>Select a room/timeslot: </strong><br/><br/>
		       Please select the room that has a capacity which best matches
		      your expected BOF group size. Contact Mary Miles at mmiles@sakaifoundation.org 
		      if you cannot find a timeslot or room that fits your group's needs.<br/><br/>
		      <strong>NOTE:  </strong>You may submit this form without selecting a timeslot.  
		      You may return later and select from the available rooms.<br/>
			  <br/><strong>Special Timeslot: </strong> Thursday, December 7th from 4:30 -5:30 pm. 
			 <br/> These 60 minute blocks must be scheduled manually by our staff.  To reserve a BOF 
			 meeting room during this timeslot, please contact shardin@umich.edu.        
		</blockquote>";
$SUBMIT_POSTER=true;
$POSTER_MSG="Posters will be displayed during the conference in the main dining/gathering hall.  Posters will also be displayed during the Technical Demonstrations on Wednesday evening, June 13th."; //Instructions for submitting a poster
$POSTER_TEMPL="";
$POSTER_REQS="<strong>Please Note:</strong>   We will provide one easel/stand for each poster you plan to submit." .
		"The maximum poster size we can accomodate is 24 x 36 inches. You may bring more than one poster for a" .
		" given topic. However, if you plan to present on multiple projects or topics, please complete a " .
		"separate submission form for each additional topic. <br/><br/>" .
		"<strong>Poster Designs: </strong> You may design your own poster or use the " .
		"simple PowerPoint poster template we have created for you. <br/><blockquote>" .
		" [ <a href='$POSTER_TEMPL'>download template now </a>] </blockquote>";
$SUBMIT_DEMO=true;
$DEMO_MSG="Technology Demos will take place on Wednesday evening, June 13th.";

$RANKING=true; //ask for topic or audience ranking for sessions
$AVAILABLE=true; //find out when a speaker can present
$not_available="<input name='conflict_tue' type='checkbox' value='Tue'  /> Tuesday, June 12 <br/>
          <input name='conflict_wed' type='checkbox' value='Wed' /> Wednesday, June 13 <br/>
          <input name='conflict_thu' type='checkbox' value='Thu'  /> Thursday, June 14 <br/       "; 

$P_LENGTH=true; //user can select presentation length 
$P_LAYOUT=true; //user can select presentation length 
$P_FORMAT=true; //user can select presentation length 



//set filter options for proposal review
$FILTER_TRACK=true;
$track_list=array('Implementation', 'Technical', 'Research', 
	'Teaching &amp; Learning', 'User Experience', 'Tool Carousel', 'Other', 'Pre-conference');

$FILTER_SUBTRACK=true;
$subtrack_list=array('OSP', 'Cool New Tool', 'Cool Commercial Tool', 'Library', 'Other');

$FILTER_TYPE=true;
$type_list=array('lecture', 'discussion', 'panel', 'workshop', 'demo', 'bof', 'poster', 'paper');


$OTHER_P_ROLE=false; // allow user to enter a primary role other than the preset roles

$SECONDARY_ROLE=true; // request a secondary role
$OTHER_S_ROLE=false; // allow user to enter a secondary role other than the preset roles

$CONF_ROLES=false; //this is used for paper presentations by Mitsui
$conf_role_list=array('Author', 'Discussant', 'Moderator', 'Co-Author', 'Keynote');



$MED2_DATE_FORMAT = "M d, Y ";
//registration configuration
$HOME_ADD=false;


?>
