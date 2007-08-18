<?php
/*
 * file: admin.php
 * Created on Mar 3, 2006 9:45:03 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Registration Admin";

$ACTIVE_MENU="REGISTER";  //for managing active links on multiple menus
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = 0; // assume user is NOT allowed unless otherwise shown
if ((!$User->checkPerm("admin_conference")) && (!$User->checkPerm("registration_dec2006")) ) {
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
	"<span class='extralinks'>" .
	"<a href='$CONFADMIN_URL/admin/attendees.php'>Attendee List</a>" .
	"<a href='$CONFADMIN_URL/admin/payment_info.php'>Payments</a>" .
	"<a href='$CONFADMIN_URL/admin/check_in.php'>Onsite Check-in</a>" .
	"</span>";

?>

<?php // INCLUDE THE HTML HEAD
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
<?php  // INCLUDE THE HEADER
include $ACCOUNTS_PATH.'include/header.php'; ?>
<div id="maincontent">
<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $ACCOUNTS_PATH.'include/footer.php';
		exit;
	}
?>
<div id="maindata">
<table cellpadding="5" cellspacing="10">


    <tr>
      <td valign="top"><a class="mainlevel" href="attendees.php">Attendee List</a></td>
      <td>View the current list of conference attendees. </td>
    </tr>
 <tr>
      <td valign="top"><a class="mainlevel" href="payment_info.php">Payments</a></td>
      <td>Registration payment processing information. </td>
    </tr>
    <tr>
      <td valign="top"><a class="mainlevel" href="check_in.php">Onsite Check-in</a></td>
      <td >View and vote on the current list of <br/>conference proposals. </td>
    </tr>
  <tr>
      <td valign="top"><a class="mainlevel" href="../registration/index.php">Registration Form</a></td>
      <td>Register someone for the conference. </td>
    </tr>
   


</table>  
</div>
<div class="padding50"> </div>
</div>
<?php include $ACCOUNTS_PATH.'include/footer.php';; // Include the FOOTER ?>