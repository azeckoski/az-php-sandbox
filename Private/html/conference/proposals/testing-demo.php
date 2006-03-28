<?php
/*
 * Created on March 16, 2006 by @author aaronz
 * Modified from code by Susan Hardin (shardin@umich.edu)
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Testing-Demo";
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

		// get updated user information
		$user_sql = "select * from users where pk='$USER_PK'";
		$result = mysql_query($user_sql) or die('User fetch query failed: ' . mysql_error());
		$USER = mysql_fetch_assoc($result); // first result is all we care about
		

$firstname=$USER["firstname"];
$lastname=$USER["lastname"];
$email=$USER["email"];


// get the passed message if there is one
if($_GET['msg']) {
	$Message .= "<br/>" . $_GET['msg'];
}

// using session variables
session_start();


session_start();
if (isset($_POST['submit'])) {


require('include/validate_demo.php');

//$validated=TRUE;

if ($validated)  {


$speaker=$_POST['speaker'];
$url=$_POST['url'];
$abstract=$_POST['abstract'];
$title=$_POST['title'];

include('include/submit_demo.php');
if($result) {


require ('include/send_demoEmail.php');




header("Location:testing-next.php");

}
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


?>      <tr >
        <td valign="top" align="right"><strong>Tool or Product Name <span class="required">*</span></strong></td>
        <td><input type="text" name="title" size="40" maxlength="100" value="<?php echo $_POST['title']; ?>" /></td>
      </tr>
      <tr>
        <td align="right" width="150"><strong>Demo Description <span class="required">*</span></strong><br />
          ( 50 words max.) </td>
        <td><textarea name="abstract" cols="40" rows="4"><?php echo $_POST['abstract']; ?></textarea></td>
      </tr>
      <tr>
        <td align="right"><strong>Demo Presenter(s) <span class="required">*</span></strong></td>
        <td><input type="text" name="speaker" size="40" maxlength="100" value="<?php echo $_POST['speaker']; ?>" /></td>
      </tr>
        <tr>
        <td><strong><br/>Co-Presenters</strong><br/>(if any)</td><td>
          
      <div id="co_presenters">  List the names of your co-presenters, one name per line. 
       <textarea name="co_speaker" cols="60" rows="4"><?php echo $_POST['co_speaker']; ?></textarea><br/>
          </div></td>
      </tr>
    
      <tr>
        <td align="right"><strong>Project URL </strong>&nbsp; &nbsp; </td>
        <td><input type="text" name="url" size="40" maxlength="100" value="<?php echo $_POST['url']; ?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Click on <strong>Add this proposal</strong> to submit this proposal <br />
          item and continue with the submission process.<br />
          <br />
          <div align=center>
            <input type="submit" name="submit" value="Add this proposal" />
             <input type="hidden" name="type" value="demo" />
            <br />
            <br />
          </div></td>
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
    <div class="componentheading">More Info...</div>
    <div class="contentheading">Technical Demos</div>
    <div class="contentpaneopen">As in the past, we plan to provide each demonstrator with table space and, if equipment resources allow, an overhead projector and screen to project your demonstration. This event has become one of the most exciting events of the conference. Space is very limited, so get your demo requests in early. <br />
      <br />
      [<a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=173&amp;Itemid=523" target=blank>more information</a>]</div>
  </div>
<!--end rightcol -->
</div>
<!-- end outerright -->

</div><!-- end containerbg -->

<?php include '../include/footer.php'; // Include the FOOTER ?>