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



//what type of event is this -- used in messages regarding the event
$EVENT_TYPE="conference";  //or conference, or event, or meeting

//proposals configuration - unique to each installation
$ACCEPT_PMT=true;  //no payment required for this event

		
$VOLUNTEER=false; //do not show the volunteer tools or menu link

$SCHEDULE=true; //do not show the schedule tool or menu link
$SCHEDULE_PUBLISHED=true; //the schedule is not available to the public yet

$REGISTRATION=true; //do not show the schedule tool or menu link

$PROPOSALS=true; //do not show the scheule tool or menu link


$FACEBOOK=false; //do not show the scheule tool or menu link

$SUBMIT_PAPER= false;
$PAPER_MSG="";

$SUBMIT_PRES=true;
$PRESENT_MSG="Presentations will take place at the conference hotel, during the conference's normal" .
		" daytime schedule for June 12-14. You may choose from the following presentation types: " .
		"Panel, Workshop, Discussion/Roundtable, Lecture/Presentation or Tool Carousel. ";

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