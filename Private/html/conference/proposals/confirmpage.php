<?php
/*
 * Created on March 16, 2006 by @author aaronz
 * Modified from code by Susan Hardin (shardin@umich.edu)
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Call for Proposals";
$Message = "";

// connect to database
require '../sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
$AUTH_MESSAGE = "You must login to create proposals for the $CONF_NAME conference. If you do not have an account, please create one.";
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';






?>


<!-- // INCLUDE THE HTML HEAD -->
<?php include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<!-- // INCLUDE THE HEADER -->
<?php include '../include/header.php';  ?>


<table width="100%" class="blog" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><div class="componentheading">Call for Proposals -- Submission Form</div></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#ffffff" style=" border-top: 5px solid #FFFFFF;"><span class="pathway"> <img src="http://www.sakaiproject.org/images/M_images/arrow.png" height="12" width="12" alt="arrow" />Start &nbsp; &nbsp; <img src="http://www.sakaiproject.org/images/M_images/arrow.png" height="8" width="8" alt="arrow" />Proposal Details &nbsp; &nbsp; <img src="http://www.sakaiproject.org/images/M_images/arrow.png" height="8" width="8" alt="arrow" />Contact Information &nbsp; &nbsp; <img src="http://www.sakaiproject.org/images/M_images/arrow.png" height="8" width="8" alt="arrow" /><span class="activestep">Confirmation</span></span> </td>
  </tr>
</table>
<div id=cfp>
<?php

	//  include('confirmation.php');
	
	echo"<table width=100%><tr>
<td colspan=2>You have successfully submitted your proposal information.   
You will receive an email confirming
your proposal submission(s) shortly.   We look forward to seeing you in
Vancouver!  <br /><br/><br /><strong>Thanks for being a part of Sakai!</strong><br /><br /></td></tr></table><div style=\"margin:40px;\">&nbsp;</div>";
	
	// include('old-includes/email.php');
	
?>
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
  <div id=rightcol> </div>
  <!--end rightcol -->
</div>
<!-- end outerright -->


<?php include '../include/footer.php'; // Include the FOOTER ?>
