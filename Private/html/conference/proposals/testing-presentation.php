<?php
/*
 * Created on March 16, 2006 by @author aaronz
 * Modified from code by Susan Hardin (shardin@umich.edu)
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Testing-Presentation";
$Message = "";

// connect to database
require '../sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
$AUTH_MESSAGE = "You must login to create proposals for the $CONF_NAME conference. If you do not have an account, please create one.";
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// bring in inst and conf data
require '../registration/include/getInstConf.php';

// TODO - why are these variables set? -AZ
$firstname=$User->firstname;
$lastname=$User->lastname;
$email=$User->email;

// get the passed message if there is one
if($_GET['msg']) {
	$Message .= "<br/>" . $_GET['msg'];
}



if (isset($_POST['submit'])) {
	
	include ('include/validate_pres.php');
	
//	$validated=TRUE;
	
	if ($validated) {
	
		require ('include/submit_presentation.php');
		
		

		//	require ('include/send_proposalEmail.php');
			header("Location:testing-next.php");
		
	}
}
?>

<!-- // INCLUDE THE HTML HEAD -->
<?php include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript">
</script>
<!-- // INCLUDE THE HEADER -->
<?php include '../include/header.php';  ?>

<table width="100%"  cellpadding="0" cellspacing="0">
 <tr>
    <td><div class="componentheading">Call for Proposals - Submission Form</div></td>
  </tr>
  <tr>
	  <td height="25" bgcolor="#ffffff" style=" border-top: 5px solid #FFFFFF;">
	  	<span class="pathway">
	  		<img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />Start &nbsp; &nbsp; &nbsp;
	  		<img src="../include/images/arrow.png" height="12" width="12" alt="arrow" /><span class="activestep">Proposal Details &nbsp; &nbsp; &nbsp;</span> 
	  		<img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />Contact Information&nbsp; &nbsp; &nbsp; 
	  		<img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />Confirmation
	  	</span>
	  </td>
  </tr>
</table>

<!-- <?= $Message ?> -->
    
<div id="cfp">

  <form name="form1" id="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table width="100%"  cellpadding="0" cellspacing="0">
          <?php 
if ($message) {
	echo "<tr><td colspan=2><div class=\"errors\" align=\"left\"><blockquote><font color=red><strong>Please provide the following information:</strong></font><ul class=small>";	
	foreach ($message as $key => $value) {
		echo $value;	
	}
	echo "</ul></blockquote></div> </td></tr>";
}


?>
      <tr>
        <td colspan=2><div><strong> Proposal for Conference Presentation </strong></div>
          <div>Select the most appropriate Presentation Topic Areas, Intend Audiences, and Format for your presentation from the options provided below.
          Please note that these classifications and titles will be used by the program commitee for the proposal review and conference
          planning process, and may not be the classifications or titles used for the final conference program. </div>
          <br/>
          <span class="required"><strong>* = Required fields</strong></span> </td>
      </tr>
      <tr>        <td><strong>Presentation Title* </strong><br/>
        </td>
        <td><input type="text" name="title" size="40" maxlength="75" value="<?php echo $_POST['title'];?>" /> <br/>(75 max chars)</td>
      </tr>
      <tr>
        <td colspan=2><strong>Presentation Summary* </strong>
         ( 50 word max.)  <br/> This summary will appear on the conference program. <br/>
       <br/><textarea name="abstract" cols="75" rows="6"><?php echo $_POST['abstract'];?></textarea>
          <br/>
          <br/></td>
      </tr>
      <tr>
        <td colspan=2><strong>Presentation Description:* </strong>( 150 word max.)
          <br/>This description is used by the program committee for a more in-depth review of your session. <br/>
       <textarea name="desc" cols="75" rows="6" ><?php echo $_POST['desc']; ?></textarea></td>
      </tr>
      <tr>
        <td><strong>Presenter's name* </strong></td><td>
          (lead presenter and main contact for this proposal)<br/>
    
        <input type="text" name="speaker" size="40" value="<?php echo $_POST['speaker']; ?>" maxlength="100"/></td>
      </tr>
      <tr>
        <td colspan=2><strong>Brief Text Bio* </strong><br/>
          (for primary presenter only - for online and 
          print program. 
          (50 word max.)<br/>
        <br/><textarea name="bio" cols="75" rows="4" ><?php echo $_POST['bio']; ?></textarea></td>
      </tr>
      <tr>
        <td><strong><br/>Co-Presenters</strong><br/>(if any)</td><td>
          
      <div id="co_presenters">  List the names of your co-presenters, one name per line. 
       <textarea name="co_speaker" cols="60" rows="4"><?php echo $_POST['co_speaker']; ?></textarea><br/>
          </div></td>
      </tr>
      <!--<tr>
        <td colspan=2><strong>Co-Presenter bio(s)</strong><br/>
          Short bios for other presenters (200 word max.)</span><br/><br/><textarea name="co_bio" cols="75" rows="4"><?php echo $_POST['co_bio']; ?></textarea>
          </td>
      </tr>-->
      <tr>
        <td><strong>Project URL </strong></td>
        <td>http://www.example.com<br/><input type="text" name="url" size="35" value="<?php echo $_POST['url']; ?>" maxlength="100" /></td>
      </tr>


      <tr>
        <td colspan=2><div id="topicInfo">
        <div><strong>Topic Areas* </strong></div>
          <div>Although in the last Call for Proposals (for the 4th Sakai conference in Austin) presenters were asked to categorize their proposal 
          within one of five tracks, for the Vancouver conference, presenters are being asked to rank the relevance of their proposal to a list of
          topic areas. Once the deadline for submitting proposals has passed, the Vancouver Program Committee will review all the proposals and see 
          which topic areas have emerged as most relevant for the Sakai community.  Those topic areas will become the tracks for the 5th Sakai 
          conference (part of Community Source Week) in Vancouver.<br/><br/>Rank <strong>at least one</strong> of the topics below on their
          relationship to your proposed presentation.

           <br/><br/></div>
                      <div class=topic_row_header> <div class=topic_type_header>TOPIC AREAS *</div><div class=topic_vote_header>
                         <span>n/a&nbsp;&nbsp;&nbsp;&nbsp;</span><span>low&nbsp;&nbsp;&nbsp;</span><span>med&nbsp;&nbsp;&nbsp;</span> <span>high&nbsp;&nbsp;&nbsp;</span> </div></div> 
          <?php 
          
          //populate form with topic information
          
   require_once('../sql/mysqlconnect.php');
$topic_sql="select pk, topic_name from topics order by topic_order";
$result = mysql_query($topic_sql) or die(mysql_error());

 while($topic_items=mysql_fetch_array($result)) {
	$topic_pk=$topic_items['pk'];
	$topic_name=$topic_items['topic_name'];
	$topicID="topic_" . $topic_pk;
	echo" <div class=topic_row>  <div class=topic_type>$topic_name</div><div class=topic_vote>
             <span> <input name=$topic_pk type=\"radio\" value=\"0\" ";
              if ($_POST[$topicID]=="0") { echo "checked"; } 
              echo" />&nbsp;&nbsp;&nbsp;</span>
               <span> <input name=$topicID type=\"radio\" value=\"1\" ";
              if ($_POST[$topicID]=="1") { echo "checked"; } 
              echo" />&nbsp;&nbsp;&nbsp;</span>
              <span><input name=$topicID type=\"radio\" value=\"2\"  ";
              if ($_POST[$topicID]=="2") { echo "checked"; } 
              echo" />&nbsp;&nbsp;&nbsp;</span><span>
              <input name=$topicID type=\"radio\" value=\"3\"  ";
              if ($_POST[$topicID]=="3") { echo "checked"; } 
              echo" />&nbsp;&nbsp;&nbsp;&nbsp;</span></div></div>  ";
}
   


?>
    </div>
    </tr>
      <tr>
        <td colspan=2><div id="audienceInfo">
        <div><strong>Intended Audience(s)* </strong></div>
          <div> Please indicate your intended audience by selecting an interest level <strong>for at least one </strong>of the audience groups listed below. 
           For example, a session on your campus implementation might be of high interest to Implementors and of medium 
           interest to Senior Administration, etc. <br/><br/></div>
          
           <div class=topic_row_header> <div class=topic_type_header>AUDIENCE</div><div class=topic_vote_header>
                        <span>n/a&nbsp;&nbsp;&nbsp;&nbsp;</span><span>low &nbsp;&nbsp;&nbsp;</span><span>med &nbsp;&nbsp;&nbsp;</span> <span>high &nbsp;&nbsp;&nbsp;</span> </div></div> 
              
<?php
   //populate form with audience information
$audience_sql="select pk,role_name from roles order by role_order";
$result = mysql_query($audience_sql) or die(mysql_error());

 while($audience_items=mysql_fetch_array($result)) {
 	$audience_pk=$audience_items['pk'];
	$audience_name=$audience_items['role_name'];
 	$audienceID="audience_" .$audience_pk;
 	echo" <div class=topic_row>  <div class=topic_type>$audience_name</div><div class=topic_vote>
           <span> <input name=$audienceID type=\"radio\" value=\"0\" ";
              if ($_POST[$audienceID]=="0") { echo "checked"; } 
              echo" />&nbsp;&nbsp;&nbsp;</span>
               <span> <input name=$audienceID type=\"radio\" value=\"1\" ";
              if ($_POST[$audienceID]=="1") { echo "checked"; } 
              echo" />&nbsp;&nbsp;&nbsp;</span>
              <span><input name=$audienceID type=\"radio\" value=\"2\"  ";
              if ($_POST[$audienceID]=="2") { echo "checked"; } 
              echo" />&nbsp;&nbsp;&nbsp;</span><span>
              <input name=$audienceID type=\"radio\" value=\"3\"  ";
              if ($_POST[$audienceID]=="3") { echo "checked"; } 
              echo" />&nbsp;&nbsp;&nbsp;&nbsp;</span></div></div>  ";
}


?>
      

           </div>
           
            <!-- end audienceinfo-->
        </td>
      </tr>
      <tr>
        <td><strong> Presentation Format* </strong></td>
        <td><div class=small>see sidebar for <a href="#getformat">format descriptions</a></div>
          <br/>
          <input name="type" type="radio" value="discussion" <?php if ($_POST['type']=="discussion") { echo "checked"; } ?> />
          Discussion <br/>
          <input name="type" type="radio" value="lecture" <?php if ($_POST['type']=="lecture") { echo "checked"; } ?> />
          Lecture <br/>
          <input name="type" type="radio" value="panel" <?php if ($_POST['type']=="panel") { echo "checked"; } ?> />
          Panel <br/>
          <input name="type" type="radio" value="workshop" <?php if ($_POST['type']=="workshop") { echo "checked"; } ?> />
          Workshop (How-to) <br/>
          <br/>
        </td>
      </tr>
      <tr>
        <td><strong>Room setup desired* </strong></td>
        <td><div class=small>We will do our best to accomodate your request</div>
          <br/>
          <input name="layout" type="radio" value="class" <?php if ($_POST['layout']=="class") { echo "checked"; } ?> />
          <strong>classroom </strong>(rows of narrow tables w/chairs)<br/>
          <input name="layout" type="radio" value="theater" <?php if ($_POST['layout']=="theater") { echo "checked"; } ?> />
          <strong>theater </strong>(rows of chairs only)<br/>
          <input name="layout" type="radio" value="conference" <?php if ($_POST['layout']=="conference") { echo "checked"; } ?> />
          <strong>conference</strong> (roundtables or conference room setup)<br/>
        </td>
      </tr>
      <tr>
        <td><strong>Presentation Length* </strong></td>
        <td><div class=small>Times are not guaranteed. We will do our best to match each session with an appropriate time block</div>
          <br/>
          <input name="length" type="radio" value="30" <?php if ($_POST['length']=="30") { echo "checked"; } ?> />
          30 minutes  <br/>
            <input name="length" type="radio" value="60" <?php if ($_POST['length']=="60") { echo "checked"; } ?> />
          60 minutes  <br/>
          <input name="length" type="radio" value="90" <?php if ($_POST['length']=="90") { echo "checked"; } ?> />
          90 minutes  <br/>
          <input name="length" type="radio" value="120" <?php if ($_POST['length']=="120") { echo "checked"; } ?> />
          120 minutes  <br/>
          <br/>
        </td>
      </tr>
      <tr>
        <td><strong>Availability</strong></td>
        <td><div class=small> Please check the days that the
presenter(s)<br/>CANNOT present due to a travel conflict</div>
          <br/>
          <strong> I am NOT available:</strong><br/>
          <input name="conflict_tues" type="checkbox" value="1" <?php if ($_POST['conflict_tues']=="1") { echo "checked"; } ?> /> Tuesday, May 30 <br/>
          <input name="conflict_wed" type="checkbox" value="1" <?php if ($_POST['conflict_wed']=="1")  { echo "checked"; } ?> /> Wednesday, May 31 <br/>
          <input name="conflict_thurs" type="checkbox" value="1" <?php if ($_POST['conflict_thurs']=="1")  { echo "checked"; } ?> /> Thursday, May 1 <br/>
          <input name="conflict_fri" type="checkbox" value="1" <?php if ($_POST['conflict_fri']=="1") { echo "checked"; } ?> /> Friday, May 2 <br/>
          <br/>
        </td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td style="padding-top: 5px;">Click on <strong>Add this proposal</strong> to submit this proposal item and continue with the submission process.<br/>
          <br/>
          <input type="submit" name="submit" value="Add this proposal" />
          <br/>
          <br/>
          <br/>
        </td>
      </tr>
    </table>
  </form>
</div>
<!-- end cfp -->
</div>
<!-- end  content_main  -->
</div>
<!-- end container-inner -->
</div>
<!--end of outer left -->
<!-- start outerright -->
<div id=outerright>
  <!-- start of rightcol_top -->
  <!-- end of rightcol_top-->
  <!--end rightcol -->
  <div id=rightcol>
<!--    <div id=gettrack class="componentheading">Conference Tracks</div>
    <div class="contentheading"> Teaching, Learning, and Assessment </div>
    <div class="contentpaneopen">The Teaching, Learning, and Assessment track will offer opportunities to share experiences with and plans for using Sakai or OSP for teaching and learning. These sessions will include presentations on the impact of OSP (or portfolios in general) on teaching practices; discussions regarding the value of a Collaborative Learning Environment (CLE) and its integrated toolset for students and the learning process; assessment management systems for tracking student progress toward learning goals; online learning using Sakai/OSP; and supporting reflective practices.</div>
    <div class="contentheading"> Management & Campus Implementation </div>
    <div class="contentpaneopen">This track highlights issues of concern to those managing current or upcoming pilot implementations; campus impact and implications; project assessment implications; training; coordination and leadership; and institutional change. This is appropriate for implementations of Sakai, OSP, or any interest regarding other strategies for integration of Sakai tools.</div>
    <div class="contentheading"> Research and Collaboration </div>
    <div class="contentpaneopen">The Research and Collaboration track will focus on using the Sakai Collaboration and Learning Environment (CLE) and its tools such as OSP or Melete, can be used to support research collaborations. We are looking for existing examples, current or upcoming projects, uses cases, and plans.</div>
    <div class="contentheading"> Sakai Foundation, Community Source & Governance </div>
    <div class="contentpaneopen">These sessions will focus on the transition from the current organization to the Sakai Foundation as the operational, governance, and legal framework for Sakai and OSPI. Issues and process around open and community source licensing and copyright will also be covered here.</div>
    <div class="contentheading"> Technology and User Interface</div>
    <div class="contentpaneopen">The Technology and User Interface track will offer sessions, panels, and round-tables that cover features and requirements; technical challenges and lessons learned for installing and implementing Sakai and integrated tools such as OSP, Samigo, and Melete; contributing code; tech support; commercial tech support; future releases; usability, user-interface design, and user-testing.</div>
    <div id=barRight> </div>
    <br/>
    <br/>-->
    <div id=getformat class="componentheading">Presentation Formats</div>
    <div class="contentheading"> Discussion </div>
    <div class="contentpaneopen"> This type of session involves a very brief presentation of a topic and immediately opens for discussion of the topic by attendees.</div>
    <div class="contentheading"> Lecture </div>
    <div class="contentpaneopen">This type of session consists mostly of presenting information to the attendees. Sufficient time for follow-up questions must be included. </div>
    <div class="contentheading"> Panel </div>
    <div class="contentpaneopen">This type of session typically brings together panelists from diverse background to address a topic from multiple points of view.</div>
    <div class="contentheading"> Workshop (How-to) </div>
    <div class="contentpaneopen"> This type of session is highly interactive, relaying skills as well as information to attendees.</div>
    <div class="contentheading"> Showcase/Poster </div>
    <div class="contentpaneopen"> Please note that we will <strong>not</strong> be soliciting proposals for Showcase/Poster sessions using this call for proposals form. We do, however, encourage you to create a poster that showcases your campus implementation or toolset. You can use the template we will provide (sometime in March) or use your own design. We will provide more details in March. </div>
  </div>

  <!--end rightcol -->
</div>
<!-- end outerright -->

</div><!-- end containerbg -->

<?php include '../include/footer.php'; // Include the FOOTER ?>