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
$AUTH_MESSAGE = "You must login to register or submit a proposal for the $CONF_NAME conference. If you do not have an account, please create one.";
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// bring in inst and conf data
require '../registration/include/getInstConf.php';



// get the passed message if there is one
if($_GET['msg']) {
	$Message .= "<br/>" . $_GET['msg'];
}

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['title'] = "required";
$vItems['abstract'] = "required";
$vItems['speaker'] = "required";

if ($_POST['save']) { // saving the form

	// DO SERVER SIDE VALIDATION
	$errors = 0;
	$validationOutput = ServerValidate($vItems, "return");
	if ($validationOutput) {
		$errors++;
		$Message = "<fieldset><legend>Validation Errors</legend>".
			"<b style='color:red;'>Please fix the following errors:</b><br/>".
			$validationOutput."</fieldset>";
	}

	if ($errors == 0) {
		//all required information provided$title=addslashes($_POST['title']);
	$title=addslashes($_POST['title']);
	$abstract=addslashes($_POST['abstract']);
	$speaker=addslashes($_POST['speaker']);
	$url=addslashes($_POST['url']);
	$co_speaker=addslashes($_POST['co_speaker']);

    //add this demo proposal to the conf_proposals table
	$demo_sql="INSERT INTO `conf_proposals` (`date_created` , `confID` , `users_pk` , `type` ,  `title` , `abstract` ,  `speaker` , `URL` , `co_speaker` ,  `approved` )
	VALUES ( NOW() , '$CONF_ID', '$User->pk', 'demo', '$title', '$abstract' , '$speaker', '$url' , '$co_speaker', 'N')";



	$result = mysql_query($demo_sql) or die("Error:<br/>" . mysql_error() . "<br/>There was a problem with the " .
		"proposal form submission. Please try to submit the form again. " .
		"If you continue to have problems, please report the problem to the " .
		"<a href='mailto:$HELP_EMAIL'>sakaiproject.org webmaster</a>." );
		
	$demo_pk=mysql_insert_id(); //get this demo pk from the database

	//get the last entry from database and mail confirmation to user
	$email_sql="Select * from `conf_proposals` WHERE pk='$demo_pk' ";
	$email_result= mysql_query($email_sql);

	while($demo=mysql_fetch_array($email_result)) 
	{	
		$title=$demo["title"];
		$abstract=$demo["abstract"];
		$speaker=$demo["speaker"];
		$url=$demo["URL"];

	//send confirmation email message
	require ('include/send_demoEmail.php');
	}
	
	//go to next page to let user choose next step
	header("Location:next.php");
  }

}
?>
<!-- // INCLUDE THE HTML HEAD -->
<?php include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="../../accounts/ajax/validate.js"></script>
<!-- // INCLUDE THE HEADER -->
<?php include '../include/header.php';  ?>

<table width="100%"  cellpadding="0" cellspacing="0">
 <tr>
    <td><div class="componentheading">Call for Proposals - DEMO Submission Form</div></td>
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
  <input type="hidden" name="save" value="1" />
    <table width="100%"  cellpadding="0" cellspacing="0">
      <tr >
        <td valign="top" align="right">	
        <img id="titleImg" src="../../accounts/ajax/images/required.gif" width="16" height="16" />
        <strong>Tool or Product Name </strong></td>
        <td><input type="text" name="title" size="40" maxlength="100" value="<?php echo $_POST['title']; ?>" />
        <input type="hidden" id="titleValidate" value="<?= $vItems['title'] ?>" />
			<span id="titleMsg"></span></td>
      </tr>
      <tr>
        <td align="right" width="150"> 
         <img id="abstractImg" src="../../accounts/ajax/images/required.gif" width="16" height="16" />
          <strong>Demo Description </strong><br />
          ( 50 words max.) </td>
        <td><textarea name="abstract" cols="40" rows="4"><?php echo $_POST['abstract']; ?></textarea>
         <input type="hidden" id="abstractValidate" value="<?= $vItems['abstract'] ?>" />
			<span id="abstract"></span>
			</td>
      </tr>
      <tr>
        <td align="right">   <img id="abstractImg" src="../../accounts/ajax/images/required.gif" width="16" height="16" />
      <strong>Demo Presenter </strong></td>
        <td><input type="text" name="speaker" size="40" maxlength="100" value="<?php echo $_POST['speaker']; ?>" />
         <input type="hidden" id="speakerValidate" value="<?= $vItems['speaker'] ?>" />
			<span id="speakerMsg"></span>
			</td>
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