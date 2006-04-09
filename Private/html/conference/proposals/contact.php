<?php
/*
 * Created on March 16, 2006 by @author aaronz
 * Modified from code by Susan Hardin (shardin@umich.edu)
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Conference Call for Proposals";
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
$vItems['primaryRole'] = "required";
$vItems['secondaryRole'] = "";
$vItems['institution'] = "required";
$vItems['address1'] = "required:focus";
$vItems['city'] = "required";
$vItems['state'] = "required:namespaces";
//$vItems['zipcode'] = "zipcode";
$vItems['country'] = "required:namespaces";
$vItems['phone'] = "required:phone";
$vItems['fax'] = "phone";


// writing data and other good things happen here
$completed = false;
$thisUser = $User;
if ($_POST['save']) { // saving the form

	// DO SERVER SIDE VALIDATION
	$errors = 0;
	$validationOutput = ServerValidate($vItems, "return");
	if ($validationOutput) {
		$errors++;
		$Message = "<fieldset><legend>Validation Errors</legend>".
			"<span style='color:red;'>Please fix the following errors:</span><br/>".
			$validationOutput."</fieldset>";
	}

	// get the post variables - USER
	$thisUser->primaryRole = $_POST["primaryRole"];
	$thisUser->secondaryRole = $_POST["secondaryRole"];
	$thisUser->address = $_POST["address"];
	$thisUser->city = $_POST["city"];
	$thisUser->state = $_POST["state"];
	$thisUser->zipcode = $_POST["zipcode"];
	$thisUser->country = $_POST["country"];
	$thisUser->phone = $_POST["phone"];
	$thisUser->fax = $_POST["fax"];

	if (!$isPartner && $_POST["institution"]) {
		$thisUser->institution = $_POST["institution"];
		$thisUser->institution_pk = 1;
	}


	
	
	// SAVE THE CURRENT DATA IN THE DATABASE
	if ($errors == 0) {
		// update the user information first
		$thisUser->save();

	// registration complete (not including payment)
		$completed = true;

	
		}
	
	
	header("Location: confirmpage.php");
	}



?>


<!-- // INCLUDE THE HTML HEAD -->
<?php include $ACCOUNTS_PATH.'include/top_header.php';  ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<!-- // INCLUDE THE HEADER -->
<?php include '../include/header.php';  ?>


<table width="100%" class="blog" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><div class="componentheading">Call for Proposals -- Submission Form</div></td>
  </tr>
  <tr>
	  <td height="25" bgcolor="#ffffff" style=" border-top: 5px solid #FFFFFF;">
	  	<span class="pathway">
	  		<img src="../include/images/arrow.png" height="12" width="12" alt="arrow" />
	  		Start &nbsp; &nbsp; &nbsp;
	  		<img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />Proposal Details &nbsp; &nbsp; &nbsp; 
	  		<img src="../include/images/arrow.png" height="8" width="8" alt="arrow" /><span class="activestep">Contact Information&nbsp; &nbsp; &nbsp; </span>
	  		<img src="../include/images/arrow.png" height="8" width="8" alt="arrow" />Confirmation
	  	</span>
	  </td>
  </tr>
</table>


<!-- //show form -->
<div id="cfp">


<?php echo $Mesage; ?>

<!-- start form section -->
 <form name="form1" id="form1" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
<input type="hidden" name="save" value="1" />
<table width="500"  cellpadding="0" cellspacing="0">

<tr>
	<td valign="top" colspan="2" style="padding:0px;">
		<div id="requiredMessage"></div>
	</td>
</tr>

<tr>
	<td colspan=2>
		<strong>Verify personal information:</strong><br />
		<div style="padding-left: 40px;">
<?php
	// get info for verification
	echo "<strong>Name:</strong> $User->firstname $User->lastname <br />";
	echo "<strong>Email:</strong> $User->email <br />";
	echo "<strong>Institution:</strong> $User->institution <br />";
?>
	<div style="margin:10px;"></div>
	If the above information is wrong, use 
	<a href="<?= $ACCOUNTS_URL ?>/<?= $ACCOUNTS_PAGE ?>" >My Account</a>
	to correct it. 
		</div>
	</td>
</tr>

 <tr valign="top">
  <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
  	<div align=right>
		<img id="primaryRoleImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<strong>Your Primary Role:</strong>
		</div>
  </td>
  <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
	<select name="primaryRole">
		<option value="">-- select role --</option>
		<?= generate_roles_dropdown($User->primaryRole) ?>
	</select><br/>
	<input type="hidden" id="primaryRoleValidate" value="<?= $vItems['primaryRole'] ?>" />
	<span id="primaryRoleMsg"></span>
  </td>
</tr>

<tr valign="top">
  <td>
  	<div align=right>
		<img id="primaryRoleImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<strong>Your Secondary Role:</strong>
		</div>
  </td>
  <td>
	<select name="secondaryRole">
		<option value="">-- select role --</option>
		<?= generate_roles_dropdown($User->secondaryRole) ?>
		<option value="" <?php if(!$User->secondaryRole) echo " selected='y' "; ?> >None</option>
	</select><br/>
	<input type="hidden" id="secondaryRoleValidate" value="<?= $vItems['secondaryRole'] ?>" />
	<span id="secondaryRoleMsg"></span>
  </td>
</tr>


<tr>
  <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
  	<div align="right">
  		<img id="addressImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
  		<strong><span class="formLable">Address</span>: </strong>
  	</div>
  </td>
  <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;">(Department, Street address, PO Box, etc.) <br />
    <textarea name="address" cols='40' rows='3'><?= $User->address ?></textarea>
  	<input type="hidden" id="addressValidate" value="<?= $vItems['address'] ?>"/>
    <span id="addressMsg"></span>
  </td>
</tr>


<tr>
  <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;">
      <div align="right">
      	<img id="cityImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
      	<strong><span class="formLable">Town/City:</span></strong>
      </div>
  </td>
  <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;">
  	<input type="text" name="city" size="30" maxlength="30" value="<?= $User->city ?>" />
  	<input type="hidden" id="cityValidate" value="<?= $vItems['city'] ?>"/>
    <span id="cityMsg"></span>
  </td>
</tr>


<tr>
  <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;">
  	<div align="right">
  		<img id="stateImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
  		<strong><span class="formLable">State/Province:</span></strong>
  	</div>
  </td>
  <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;">
    <select name="state">
<?php	$selectItem = $User->state;
		if ($selectItem) { echo "<option value='$selectItem'>$selectItem</option>"; }
		require $ACCOUNTS_PATH.'include/state_select.php';
?>
		<option value="">&nbsp;</option>
		<option value="-other-">Other (Not Listed)</option>
    </select>
    <input style="display:none;" type="text" id="stateOther"  size="25" maxlength="50" value="<?= $User->state ?>" />
  	<input type="hidden" id="stateValidate" value="<?= $vItems['state'] ?>"/>
    <span id="stateMsg"></span>
  </td>
</tr>


<tr>
  <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
  	<div align="right">
        <img id="zipcodeImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
  		<strong><span class="formLable">Zip/Postal Code:</span></strong>
  	</div>
  </td>
  <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
  	<input type="text" name="zipcode" size="10" maxlength="10"  value="<?= $User->zipcode ?>" />
  	<input type="hidden" id="zipcodeValidate" value="<?= $vItems['zipcode'] ?>"/><br />
    <span id="zipcodeMsg"></span>
  </td>
</tr>


<tr>
  <td><div align="right">
    <img id="countryImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
  	<strong><span class="formLable">Country:</span></strong> 
  </div></td>
  <td>
      <select name="country">
<?php	$selectItem = $User->country;
		if ($selectItem) { echo "<option value='$selectItem'>$selectItem</option>"; }
		require $ACCOUNTS_PATH.'include/country_select.php';
?>
		<option value="">&nbsp;</option>
		<option value="-other-">Other (Not Listed)</option>
    </select>
    <input style="display:none;" type="text" id="countryOther"  size="25" maxlength="100" value="<?= $User->country ?>" />
  	<input type="hidden" id="countryValidate" value="<?= $vItems['country'] ?>"/>
    <span id="countryMsg"></span>
  </td>
</tr>

<tr>
  <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
  	<div align="right">
  		<img id="phoneImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
  		<strong><span class="formLable">Phone:</span></strong>
  	</div>
  </td>
  <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
  	<input type="text" name="phone" size="18" maxlength="18"  value="<?= $User->phone ?>" />
  	<input type="hidden" id="phoneValidate" value="<?= $vItems['phone'] ?>"/><br />
    <span id="phoneMsg"></span>
  </td>
</tr>

<tr>
  <td>
  	<div align="right">
  		<img id="faxImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
  		<strong><span class="formLable">Fax:</span></strong>
  	</div>
  </td>
  <td>
  	<input type="text" name="fax" size="18" maxlength="18"  value="<?= $User->fax ?>" />
  	<input type="hidden" id="faxValidate" value="<?= $vItems['fax'] ?>"/><br />
    <span id="faxMsg"></span>
  </td>
</tr>
    
<tr>
        <td>&nbsp;</td>
        <td> Click <strong>Submit</strong> to complete the proposal submission process. <br />
          <br />
           <input id="submitbutton" type="submit" name="submit_MemberReg" value="Submit" />
        <br />
        </td>
      </tr>
        <tr>
      <td colspan=2><div align=center>
         </div></td>
    </tr>
    </table>
  </form>

  
  
</div> <!-- end cfp -->

<div style="margin:16px;"></div> <!-- SPACER -->

</div> <!-- end  content_main  -->
</div> <!-- end container-inner -->
</div> <!--end of outer left -->


<!-- start outerright -->
<div id=outerright>
  <!-- start of rightcol_top -->
  <!-- end of rightcol_top-->
  <!--end rightcol -->
   <div id=rightcol>
    <div class="componentheading">More Info...</div>
    <div class="contentheading">What will you need to provide?</div>
    <div class="contentpaneopen">
     <div><a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=170&amp;Itemid=519" target=blank> PROPOSAL SUBMISSION GUIDELINES </a><br />
      <br />
    </div><p>Preview a <a href="http://sakaiproject.org/vancouver/sakai_vancouverCFP.pdf" title="not available yet...">sample proposal form</a> and instructions for completing this Call for Proposal submission process. </p>
    </div>
    
    <div class="contentheading">Review Previous Conference Sessions</div>
    <div class="contentpaneopen"><a title="" href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=161&amp;Itemid=497" target="blank"> 
    <img style="margin: 0px 10px 0px 0px;" width="100" height="61" border="1" title="" alt="" src="../include/images/agenda.gif" /><br />
      </a> Review the sessions offered at the Sakai Austin Conference (December 2005)<br />
    </div>
  </div>
  <!--end rightcol -->
</div>
<!-- end outerright -->

</div><!-- end containerbg -->


<?php include '../include/footer.php'; // Include the FOOTER ?>
