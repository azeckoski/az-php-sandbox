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


require('old-includes/validate_demo.php');

//$validated=TRUE;

if ($validated)  {


$_SESSION['Dspeaker']=$_POST['Dspeaker'];
$_SESSION['demo_url']=$_POST['demo_url'];
$_SESSION['demo_desc']=$_POST['demo_desc'];
$_SESSION['product']=$_POST['product'];

include('old-includes/submit_demo.php');
if($result) {

$num_demo=$_SESSION['num_demo']++;

include ('includes/send_demoEmail.php');




header("Location:next.php");

}
}



}
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
    <td height="25" bgcolor="#ffffff" style=" border-top: 5px solid #FFFFFF;"><span class="pathway"> <img src="../includes/arrow.png" height="12" width="12" alt="arrow" />Start &nbsp; &nbsp; &nbsp; <img src="../includes/arrow.png" height="8" width="8" alt="arrow" /><span class="activestep">Proposal Details &nbsp; &nbsp; &nbsp;</span> <img src="../includes/arrow.png" height="8" width="8" alt="arrow" />Contact Information&nbsp; &nbsp; &nbsp; <img src="../includes/arrow.png" height="8" width="8" alt="arrow" />Confirmation</span> </td>
  </tr>
</table>
<div id=cfp>
  <form id="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table width="100%"  cellpadding="0" cellspacing="0">
      <tr>
        <td colspan=2><div><strong>Proposal for Technology Demo:</strong></div>
          <div>The technology demos will take place on Thursday, June 1st. Demonstration tables will be set up around the perimeter of the reception room, Space will be limited. <br />
            <br />
            <span class="small">* = Required fields</span></div></td>
      </tr>
      <?php 
if ($message) {
	echo "<tr><td colspan=2><div class=\"errors\" align=\"left\"><blockquote><font color=red><strong>Please provide the following information:</strong></font><ul class=small>";	
	foreach ($message as $key => $value) {
		echo $value;	
	}
	echo "</ul></blockquote></div> </td></tr>";
}
?>
      <tr >
        <td valign="top" align="right"><strong>Tool or Product Name <span class="required">*</span></strong></td>
        <td><input type="text" name="product" size="40" maxlength="100" value="<?php echo $_POST['product']; ?>" /></td>
      </tr>
      <tr>
        <td align="right" width="150px"><strong>Demo Description <span class="required">*</span></strong><br />
          ( 50 words max.) </td>
        <td><textarea name="demo_desc" cols="40" rows="4" maxlength="400"><?php echo $_POST['demo_desc']; ?></textarea></td>
      </tr>
      <tr>
        <td align="right"><strong>Demo Presenter(s) <span class="required">*</span></strong></td>
        <td><input type="text" name="Dspeaker" size="40" maxlength="100" value="<?php echo $_POST['Dspeaker']; ?>" /></td>
      </tr>
      <tr>
        <td align="right"><strong>Project URL </strong>&nbsp; &nbsp; </td>
        <td><input type="text" name="demo_url" size="40" maxlength="100" value="<?php echo $_POST['demo_url']; ?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Click on <strong>Add this proposal</strong> to submit this proposal <br />
          item and continue with the submission process.<br />
          <br />
          <div align=center>
            <input type="submit" name="submit" value="Add this proposal" />
            <br />
            <br />
          </div></td>
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
    <div class="contentheading" width="100%">Technical Demos</div>
    <div class="contentpaneopen">As in the past, we plan to provide each demonstrator with table space and, if equipment resources allow, an overhead projector and screen to project your demonstration. This event has become one of the most exciting events of the conference. Space is very limited, so get your demo requests in early. <br />
      <br />
      [<a href="http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=173&Itemid=523" target=blank>more information</a>]</div>
  </div>
  <!--end rightcol -->
</div>
<!-- end outerright -->

<?php include '../include/footer.php'; // Include the FOOTER ?>