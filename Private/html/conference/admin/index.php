<?php
/*
 * file: admin.php
 * Created on Mar 3, 2006 9:45:03 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Conference Control";

$ACTIVE_MENU="REGIST";  //for managing active links on multiple menus
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
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = 1;
}

// custom CSS file

$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
// set header links
$EXTRA_LINKS = 
	"<span class='extralinks'>".
	"<a class='active' href='$CONFADMIN_URL/admin/index.php'>User Forms:</a>";
	if ($PROPOSALS) {  $EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/proposals.php'>Proposals Admin</a>"; }
	if ($REGISTRATION) {  $EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/registration.php'>Registraton Admin</a>"; }
	if ($SCHEDULE) {  $EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/schedule.php'>Schedule Admin</a>"; }
$EXTRA_LINKS .= "</span>";

?>

<?php  // INCLUDE THE HTML HEAD 
include $ACCOUNTS_PATH.'include/top_header.php'; ?>

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
  include $ACCOUNTS_PATH.'include/header.php'; ?>
<div id="maincontent">
<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $ACCOUNTS_PATH.'/include/footer.php';
		exit;
	}
?>
<div id="maindata">
<table border=0 cellpadding=5 cellspacing=5>

<?php 	if ($REGISTRATION) {  ?>
    <tr>
      <td valign="top"><a class="mainlevel" href="registration.php">Registration</a></td>
      <td>View the current list of conference attendees </td>
    </tr>
<?php } else {?>
<tr>
      <td valign="top"> <td valign="top"><a href="#" class="mainlevel" style="color:#333;" title="this feature not active">Volunteer</a></td>
     Registration</td>
      <td > <span style="color: #666;"> (this feature has not been activated for this event) </td>
    </tr>
<?php } ?>
<?php 	if ($PROPOSALS) {  ?>
    <tr>
      <td valign="top"><a class="mainlevel" href="proposals_admin.php">Proposals</a></td>
      <td >View and vote on the current list of <br/>conference proposals. </td>
    </tr>

<?php } else {?>
<tr>
      <td valign="top"> <td valign="top"><a href="#" class="mainlevel" style="color:#333;" title="this feature not active">Proposals</a></td>
     Proposals</a></td>
      <td ><span style="color: #666;"> (this feature has not been activated for this event) </td>
    </tr>
<?php }  	if ($REGISTRATION)  {  ?>
    <tr>
      <td valign="top"><a class="mainlevel" href="check_in.php">Onsite Check In</a></td>
      <td>Conference admins can handle check in and badges </td>
    </tr>

<?php } else {?>
<tr>
  <td valign="top"><a href="#" class="mainlevel" style="color:#333;" title="this feature not active">Onsite Check-In</a></td>
           <td ><span style="color: #666;"> (this feature has not been activated for this event) </td>
    </tr>
<?php }   	if ($SCHEDULE) {  ?>
    <tr>
      <td valign="top"><a class="mainlevel" href="schedule.php">Schedule</a></td>
      <td>Modify the conference schedule. </td>
    </tr>
<?php } else {?>
<tr>
  <td valign="top"><a href="#" class="mainlevel" style="color:#333;" title="this feature not active">Schedule</a></td>
        <td ><span style="color: #666;"> (this feature has not been activated for this event) </td>
    </tr>
<?php }	if ($VOLUNTEER) {  ?>
    <tr>
      <td valign="top"><a class="mainlevel" href="volunteers.php">Volunteers</a></td>
      <td>View the list of conveners and recorders. </td>
    </tr>

<?php } else {?>
<tr>
      <td valign="top"><a href="#" class="mainlevel" style="color:#333;" title="this feature not active">Volunteer</a></td>
      <td ><span style="color: #666;"> (this feature has not been activated for this event) </td>
    </tr>
<?php } ?>
</table>  
</div>

</div>
<?php include $ACCOUNTS_PATH.'/include/footer.php'; // Include the FOOTER ?>