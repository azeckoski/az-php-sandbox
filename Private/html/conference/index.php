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
if ($SCHEDULE) { 
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule.php'>Schedule (table view)</a>";
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule_details.php'>Schedule (list view)</a>";
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
<td style="padding-left: 20px;"><? if($msg) { echo $msg;} ?>
	<?php if($User->pk) { ?>
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
	
	if (($User->checkPerm("admin_conference")) || ($User->checkPerm("proposals_dec2006")) || ($User->checkPerm("registration_dec2006")) ) {
echo "<br/><br/><br/><strong>Administrative Tools: </strong><br/><br/>";   //need to see admin links
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

</td>

<td valign="top" width="20%">
<?php  if ($User->checkPerm("admin_accounts")) {
	
?>	<br/><br/><div class="login">
	<div class="loginheader"><?= $TOOL_NAME ?></div>
	<div class="padded">

<?php
$user_count = $User->getUsersBySearch("*","","pk",true);
$Inst = new Institution();
$inst_count = $Inst->getInstsBySearch("*","","pk",true);
?>

	<span style="font-weight:bold;text-decoration:underline;">Statistics:</span><br/>
	<b>Accounts:</b> <?= $user_count['db'] ?><br/>
<?php if ($USE_LDAP) { ?>
	&nbsp;&nbsp;- LDAP: <?= $user_count['ldap'] ?><br/>
<?php } ?>
	<b>Institutions:</b> <?= $inst_count['db'] ?><br/>
<?php if ($USE_LDAP) { ?>
	&nbsp;&nbsp;- LDAP: <?= $inst_count['ldap'] ?><br/>
<?php } ?>
	<br/>

	</div>
	</div>  
	<?php } ?>
</td>
</tr>
</table>
<div class="padding50"></div>

<?php include $ACCOUNTS_PATH.'/include/footer.php'; // Include the FOOTER ?>
