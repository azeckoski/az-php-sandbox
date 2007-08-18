<?php
/*
 * file: admin.php
 * Created on Mar 3, 2006 9:45:03 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Proposals Admin";

$ACTIVE_MENU="PROPOSALS";  //for managing active links on multiple menus
$Message = "";

// connect to database
require $ACCOUNTS_PATH.'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// Make sure user is authorized
$allowed = false; // assume user is NOT allowed unless otherwise shown
if ( (!$User->checkPerm("admin_accounts")) && (!$User->checkPerm("proposals_dec2006")) && (!$User->checkPerm("admin_conference")) ) {
	$allowed = false;
	$Message = "Only admins with and the conference committee  may view this page.<br/>" .
		"Try out this one instead: <a href='$TOOL_PATH/'>$TOOL_NAME</a>";
} else {
	$allowed = true;
}


// custom CSS file
$CSS_FILE = $ACCOUNTS_URL."/include/accounts.css";
$CSS_FILE2 = "../include/proposals.css";


// set header links
$EXTRA_LINKS = "<span class='extralinks'>";
	if ($PROPOSALS) {  
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/proposals.php'>Proposals-Voting</a>";		
		$EXTRA_LINKS .= "<a href='$CONFADMIN_URL/admin/proposals_results.php'>Proposals-Results</a>";  }
	$EXTRA_LINKS .="</span>";


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
<?php include $ACCOUNTS_PATH.'include/header.php'; // INCLUDE THE HEADER ?>
<div id="maincontent">
<?= $Message ?>

<?php
	// Put in footer and stop the rest of the page from loading if not allowed -AZ
	if (!$allowed) {
		include $ACCOUNTS_PATH.'include/footer.php';;
		exit;
	}
?>
<div id="maindata">
<table border="0" cellpadding="5" cellspacing="10">
<?php 	if ($PROPOSALS) {  ?>
  <tr>
      <td valign="top"><a class="mainlevel" href="../proposals/index.php">Add a Proposal</a></td>
      <td>Add a new conference proposal. </td>
    </tr>
<?	}  else  { ?>
	<tr>
      <td valign="top">Add a Proposal</td>
      <td>Add a new conference proposal. <span style="color: #666;">
       (this feature has not been activated for this event)</span> </td>
    </tr>
    <?php } 	if ($PROPOSALS) {  ?>
      <tr>
      <td valign="top"><a class="mainlevel" href="proposals.php">Proposals Voting</a></td>
      <td>View and vote on the current list of <br/>conference proposals. </td>
    </tr>
      <tr>
      <td valign="top"><a class="mainlevel" href="proposals_results.php">Proposals Results</a></td>
      <td>View view voting results and <br/>edit or approve  proposals. </td>
    </tr>
    
    <?	}  else  { ?>
       <tr>
      <td valign="top"><a class="mainlevel" href="proposals_results.php">Proposals Voting </a></td>
      <td>Approve sessions, set tracks, edit content for final program. </td>
    </tr>
 <?php }  ?>
</table>  
</div><div class="padding50"></div>

</div>
<?php include $ACCOUNTS_PATH.'include/footer.php';; // Include the FOOTER ?>