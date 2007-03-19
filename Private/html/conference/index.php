<?php
/*
 * Created on March 8, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * This is the main page for the accounts system
 */
?>
<?php
require_once 'include/tool_vars.php';

//require_once '../conference/include/tool_vars.php';

// Introduction or main page
$PAGE_NAME = "Main";
$ACTIVE_MENU="HOME";  //for managing active links on multiple menus
$msg=$_REQUEST['msg'];
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';


$CSS_FILE = $ACCOUNTS_URL.'/include/accounts.css';
// top header links
$EXTRA_LINKS = "<span class='extralinks'>";
	$EXTRA_LINKS .= "<a  class='active' href='$ACCOUNTS_URL/index.php' title='Sakai accounts home'><strong>Home</strong></a>:";

$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/registration/index.php'>Register</a>" .
"<a  href='$CONFADMIN_URL/proposals/index.php'>Call for Proposals</a>" ;
if ($SCHEDULE_PUBLISHED) { 
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
		 }  else {
		 		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/draft_schedule.php'>Schedule</a>";
	
		 	
		 }
	
	$EXTRA_LINKS.="</span>";


?>

<?php //INCLUDE THE HEADER
 include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript">
<!--
// -->
</script>
<?php include $ACCOUNTS_PATH.'include/header.php'; ?>
<table id="maincontent" border=0 cellpadding=0 cellspacing=5 width="100%">
<tr>
<td valign=top style="padding-left: 20px;"><? if($msg) { echo $msg;} ?>
	<?php if($User->pk) { ?><br/>
<strong> Please select one of the following options:<br/></strong>
<?php } else { ?>
<br/>
<?php } echo "<br/><div>";

	if ($REGISTRATION) {  
 echo "<a class='mainlevellinks' href='../conference/registration/index.php' >Register for this conference</a><br/>";
	}
	if ($PROPOSALS) {  
echo "<a class='mainlevellinks' href='../conference/proposals/index.php' >Submit a Proposal</a><br/>" ;
	}
	if ($SCHEDULE) { 
echo "<a class='mainlevellinks' href='../conference/admin/schedule.php'>View the Conference Schedule</a><br/>" ;
	}
	if ($VOLUNTEER) { 
echo "<a class='mainlevellinks' href='../conference/volunteer.php'>Volunteer to help at the conference</a><br/>" ;
	}
	if ($FACEBOOK) { 
echo "<a class='mainlevellinks' href='../facebook/'>View the Facebook</a><br/>" ; 
	}
	echo "<a class='mainlevellinks' href='http://sakaiproject.org/sakaiamsterdam07' >Visit the Amsterdam conference website</a><br/>";
	
	if ( ($User->checkPerm("admin_conference")) ||  ($User->checkPerm("admin_accounts")) || ($User->checkPerm("proposals_dec2006")) || ($User->checkPerm("registration_dec2006")) ) {
echo "<br/><br/><br/><strong>You may access the following Admin Tools: </strong><br/><br/>";   //need to see admin links
	if ($User->checkPerm("admin_accounts")) {
	
 echo "<a class='mainlevellinks' href='../conference/admin/proposals.php' >Accounts Administration</a> <br/>";

}

if (($User->checkPerm("admin_conference")) || ($User->checkPerm("proposals_dec2006")) ) {
	
 echo "<a class='mainlevellinks' href='../conference/admin/proposals.php' >Proposals Voting</a> <br/>";
echo "<a class='mainlevellinks' href='../conference/admin/proposals_results.php' >Proposals Results</a> <br/>";

}
if (($User->checkPerm("admin_conference")) || ($User->checkPerm("registration_dec2006")) ) {
	
 echo "<a class='mainlevellinks' href='../conference/admin/registration_admin.php' >Conference Registration administration</a> <br/>";

} 
}
echo "</div><br/>";


?>

</td> <td valign=top style="padding:20px 30px;">
<div style="text-align:left;font-size: 1.05em; line-height:1.1em; border:1px solid #808000; padding:10px; width:300px; " >
<p >
<strong>Conference Dates: </strong> <br/> Tuesday, June 12th - Thursday, June 14th 2007</p>
<br/>
<p><strong>Pre-conference workshops:</strong><br/> Monday, June 11th</p>
<blockquote>
<ul>
    <li>* Programmer's Cafe  (full day)</li>
    <li>* Introduction to Sakai (1/2 day)</li>
    <li>* UI Camp -- User Support folks and Programmers welcome! (full day)</li>
    </ul>
    </blockquote>
     <p><br/><br/>For more information please visit the <a href="http://sakaiproject.org/conference/index.html">conference website.<img src="include/images/arrow.gif" border="0" /></a></p> 
    
    </div>
   
</td>

<td valign="top" width="20%">
<?php  if ($User->checkPerm("admin_accounts")) {
	
?>	<br/><br/><div class="login" style="padding:5px 15px;"><h3 align=center>Statistics:</h3>
	<div class="loginheader">Accounts Admin</div>
	<div class="padded">

<?php
$user_count = $User->getUsersBySearch("*","","pk",true);
$Inst = new Institution();
$inst_count = $Inst->getInstsBySearch("*","","pk",true);
?>

	<strong>Accounts:</strong> <?= $user_count['db'] ?><br/>
<?php if ($USE_LDAP) { ?>
	&nbsp;&nbsp;- LDAP: <?= $user_count['ldap'] ?><br/>
<?php } ?>
	<strong>Institutions:</strong> <?= $inst_count['db'] ?><br/>
<?php if ($USE_LDAP) { ?>
	&nbsp;&nbsp;- LDAP: <?= $inst_count['ldap'] ?><br/>
<?php } ?>
	<br/>

	
	</div>  
	<div class="loginheader">Registration Admin</div>
	<div class="padded">

<?php
	//attendance statistics
	
?>
	<br/>


	</div>  
	<div class="loginheader">Proposals Admin</div>
	<div class="padded">

<?php//  get number of proposals submitted, number approved
	
	
?>
	<br/>


	</div> 
	</div>
	<?php } ?>
</td>
</tr>
</table>
<div class="padding50"></div>

<?php include $ACCOUNTS_PATH.'/include/footer.php'; // Include the FOOTER ?>
