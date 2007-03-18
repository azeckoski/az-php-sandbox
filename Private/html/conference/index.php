<?php
/*
 * Created on March 13, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once $ACCOUNTS_PATH.'include/tool_vars.php';

$PAGE_NAME = "Sakai Conference";

$ACTIVE_MENU="HOME";  //for managing active links on multiple menus
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';


$CSS_FILE = $ACCOUNTS_URL.'/include/accounts.css';

// top header links
	$EXTRA_LINKS .="<a class='active' href='$ACCOUNTS_URL/index.php'><strong>Home</strong></a>:" ;


$EXTRA_LINKS = "<span class='extralinks'>" ;
if ((!$User->checkPerm("admin_accounts")) && (!$User->checkPerm("proposals_dec2006")) ) {
$EXTRA_LINKS.="<a  href='$ACCOUNTS_URL/index.php'><strong>Home</strong></a>:";
 }
$EXTRA_LINKS.=	"<a href='$CONFADMIN_URL/registration/index.php'>Register</a>" .
	"<a href='$CONFADMIN_URL/proposals/index.php'>Call for Proposals</a>" .
	"</span>";


?>

<?php require $ACCOUNTS_PATH.'include/top_header.php'; ?>
<?php require $ACCOUNTS_PATH.'include/header.php'; ?>
<div id="maincontent">
<?php include 'registration/include/registration_LeftCol.php'?>

<div style="text-align:left; padding-left: 30px; width:100%;">

<span style="font-size:1.1em;"><a class="mainlevel" href="proposals">Propose a session</a></span> 
	<br/><br/>
<span style="font-size:1.1em;">
<a class="mainlevel" href="registration/">Register</a> </span>
	<br/><br/>
	
<div class="padding50">&nbsp;</div>
	


</div>
</td></tr></table>
</div>
<?php require $ACCOUNTS_PATH.'include/footer.php'; // Include the FOOTER ?>