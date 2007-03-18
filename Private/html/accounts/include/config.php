<?php
/*
 * Created on Mar 18, 2007 
 *by Susan Hardin shardin@umich.edu
 * moved non-environment dependent globals out of the system vars
 * 
 */
?>
<?php 
// Non-environment dependent globals
$ACCOUNTS_URL = '/accounts';
$ACCOUNTS_PAGE = "myaccount.php";
$LOGIN_PAGE = "login.php";
$LOGOUT_PAGE = "logout.php";
$CONFADMIN_URL ='/conference';


$admin_logo= "$ACCOUNTS_URL/include/images/logoslate160x89.jpg";

$mediaOnionLogo= "$ACCOUNTS_URL/include/images/logoslate160x89.jpg";


//modify admin features
$adminID="Dec2007";  //allows  roles and other admin labels to change

$INST_REP=false;
$VOTE_REP=false;


$CONF_LOC = "Amsterdam Movenpick, Amsterdam, The Netherlands";
$CONF_NAME = "7th Sakai Conference";
$CONF_DETAILS = ""; 
$CONF_MGR= "Susan Hardin";
$CONF_MGR_EMAIL= "shardin@umich.edu";

//this is the event main web page
$CONF_URL = "http://sakaiproject.org/conference";
$CONF_DAYS= "June 7-9, 2007";



// proposals voting

$VOTE_TEXT = array("yes", "maybe", "no");
$VOTE_HELP = array(
	"Proposal is appropriate",
	"Proposal needs work but idea is sound",
	"Proposal is inappropriate");
$VOTE_SCORE = array("2", "1", "0");

// dates below in format: YYYY/MM/DD HH24:MI
$VOTE_OPEN_DATE = "2007/1/1 8:00";
$VOTE_CLOSE_DATE = "2007/3/30 5:00";

// conference attendee reports
$CONF_REPORT_PATH = realpath($_SERVER["DOCUMENT_ROOT"]."/../reports/");
if ($ENVIRONMENT == "prod") {
	//$CONF_REPORT_TO = "hardin@umich.edu,BCassidy@sefas.com,mmiles@umich.edu";
	//$CONF_REPORT_CC = "shardin@umich.edu,kreister@umich.edu";
} elseif ($ENVIRONMENT == "test") {
	// TESTING
//	$CONF_REPORT_TO = "shardin@umich.edu";
//	$CONF_REPORT_CC = "aaronz@vt.edu";
} else { // assume dev environment
//	$CONF_REPORT_TO = "aaronz@vt.edu";
//	$CONF_REPORT_CC = "aaron@vt.edu";
}

// tool functions



//what type of event is this -- used in messages regarding the event
$EVENT_TYPE="conference";  //or conference, or event, or meeting

//proposals configuration - unique to each installation
$ACCEPT_PMT=true;  //no payment required for this event

		
$VOLUNTEER=false; //do not show the volunteer tools or menu link

$SCHEDULE=true; //do not show the schedule tool or menu link

$REGISTRATION=true; //do not show the schedule tool or menu link

$PROPOSALS=true; //do not show the scheule tool or menu link


$FACEBOOK=false; //do not show the scheule tool or menu link

$SUBMIT_PAPER= false;
$PAPER_MSG="";

$SUBMIT_PRES=true;
$PRESENT_MSG="Select the most appropriate Presentation Topic Areas," .
		" Intend Audiences, and Format for your presentation from the " .
		"options provided below. Please note that these classifications " .
		"and titles will be used by the program commitee for the proposal " .
		"review and conference planning process, and may not be the " .
		"classifications or titles used for the final conference program. ";

$SUBMIT_BOF=false;
$BOF_MSG="BOFs (Birds of a Feather meetings) are self-formed meetings set up by any conference attendee." .
		"The meetings may take place at any time during the conference. " .
		" We have a limited group of rooms and timeslots which you may choose from. " .
		" When rooms are filled, we will do our best to locate community areas" .
		" within the hotel where you may gather for impromptu BOFS. ";
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
$POSTER_MSG=""; //Instructions for submitting a poster
$POSTER_TEMPL="http://sakaiproject.org/conference/sakai_poster_templateAtlanta06.ppt";
$POSTER_REQS="<strong>Please Note:</strong>   We will provide one easel/stand for each poster you plan to submit." .
		"The maximum poster size we can accomodate is 24 x 36 inches. You may bring more than one poster for a" .
		" given topic. However, if you plan to present on multiple projects or topics, please complete a " .
		"separate submission form for each additional topic. <br/><br/>" .
		"<strong>Poster Designs: </strong> You may design your own poster or use the " .
		"simple PowerPoint poster template we have created for you. <br/><blockquote>" .
		" [ <a href='$POSTER_TEMPL'>download template now </a>] </blockquote>";
$SUBMIT_DEMO=true;
$DEMO_MSG="Instructions for submitting a demo";

$RANKING=true; //ask for topic or audience ranking for sessions
$AVAILABLE=true; //find out when a speaker can present
$not_available="availability message here"; 

$P_LENGTH=true; //user can select presentation length 
$P_LAYOUT=true; //user can select presentation length 
$P_FORMAT=true; //user can select presentation length 



//set filter options for proposal review
$FILTER_TRACK=true;
$track_list=array('Implementation', 'Technical', 'Research', 
	'Teaching &amp; Learning', 'User Experience');

$FILTER_SUBTRACK=false;
$subtrack_list=array('OSP', 'Cool New Tool', 'Cool Commercial Tool', 'Library');

$FILTER_TYPE=true;
$type_list=array('lecture', 'discussion', 'panel', 'workshop', 'demo', 'bof', 'paper');


$OTHER_P_ROLE=false; // allow user to enter a primary role other than the preset roles

$SECONDARY_ROLE=true; // request a secondary role
$OTHER_S_ROLE=false; // allow user to enter a secondary role other than the preset roles

$CONF_ROLES=false; //this is used for paper presentations by Mitsui
$conf_role_list=array('Author', 'Discussant', 'Moderator', 'Co-Author', 'Keynote');



$MED2_DATE_FORMAT = "M d, Y ";
//registration configuration
$HOME_ADD=false;
?>