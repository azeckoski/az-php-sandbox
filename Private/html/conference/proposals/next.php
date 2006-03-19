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

session_start();


if (isset($_POST['submit'])) {


if (!isset($_POST['next'])){
$message[]="<li>Select an option below, then click on <strong>continue</strong>. </li>";

}
//add a presentation
if($_POST['next']=="presentation")
header("Location:presentation.php");

//add a demo
if($_POST['next']=="demo")
header("Location:demo.php");

//ready to complete contact information
if($_POST['next']=="done") {
header("Location:contact.php");
}



}

 //show form 

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
    <td height="25" bgcolor="#ffffff" style=" border-top: 5px solid #FFFFFF;"><span class="pathway"> <img src="../includes/arrow.png" height="12" width="12" alt="arrow" />Start &nbsp; &nbsp; &nbsp; <img src="../includes/arrow.png" height="8" width="8" alt="arrow" /><span class="activestep">Proposal Details &nbsp; &nbsp; &nbsp;</span> <img src="../includes/arrow.png" height="8" width="8" alt="arrow" />Contact Information&nbsp; &nbsp; &nbsp; <img src="../includes/arrow.png" height="8" width="8" alt="arrow" /> Confirmation</span> </td>
  </tr>
</table>
<div id=cfp>
  <form name="form1" id ="form1" method="post" action="<?php echo $_SERVER[PHP_SELF]; ?>">
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
        <td colspan="2"  style="padding-left: 20px; border:0px;"><br />
          <span class="required">*</span><strong>Select next step: </strong>
          <div>You may add another proposal or complete the contact information and submit your proposals to the Sakai Conference Program committee. </div></td>
      </tr>
      <tr valign="top">
        <td colspan=2 style="padding-left: 20px; border:0px;"><input name="next" type="radio" value="demo">
&nbsp;&nbsp; <strong>Add a demo proposal</strong> <br />
          <input name="next" type="radio" value="presentation">
&nbsp;&nbsp; <strong>Add a presentation proposal</strong> <br />
          <input name="next" type="radio" value="done">
&nbsp;&nbsp; <strong>Complete required contact information and submit my proposal(s)</strong> </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align=center><br />
          <input type="submit" name="submit" value="continue" />
          <br />
        </td>
      </tr>
    </table>
  </form>
</div>
<!-- end cfp -->
<div id=spacer> </div>
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
    <div class="componentheading">More Info...</div>
    <div class="contentheading" width="100%"> Conference Presentation</div>
    <div class="contentpaneopen">
      <p>Conference Presentation Presentation formats include: panel, workshop, discussion, lecture, and showcase (posters). Presentations will take place at the conference hotel, during the conference's daytime schedule for May 30 through June 2nd. 
    </div>
    <div class="contentheading" width="100%"> Technical Demo</div>
    <div class="contentpaneopen">
      <p>Technology Demos will take place during the Technical Demo Reception on the evening of Thursday, June 1st. </p>
    </div>
  </div>
  <!--end rightcol -->
</div>
<!-- end outerright -->

<?php include '../include/footer.php'; // Include the FOOTER ?>