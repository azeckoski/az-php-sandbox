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

// bring in inst and conf data
require '../registration/include/getInstConf.php';


// get the passed message if there is one
if($_GET['msg']) {
	$Message .= "<br/>" . $_GET['msg'];
}


// bring in the form validation code
require $ACCOUNTS_PATH.'ajax/validators.php';

// Define the array of items to validate and the validation strings
$vItems = array();
$vItems['title'] = "required:focus";
if (!$isPartner) {
	$vItems['otherInst'] = "required";
}
$vItems['address1'] = "required";
$vItems['city'] = "required";
$vItems['state'] = "required:namespaces";
$vItems['zip'] = "zipcode";
$vItems['country'] = "required:namespaces";
$vItems['phone'] = "required:phone";


// writing data and other good things happen here
$completed = false;
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
	$address1 = mysql_real_escape_string($_POST["address1"]);
	$city = mysql_real_escape_string($_POST["city"]);
	$state = mysql_real_escape_string($_POST["state"]);
	$zip = mysql_real_escape_string($_POST["zip"]);
	$country = mysql_real_escape_string($_POST["country"]);
	$phone = mysql_real_escape_string($_POST["phone"]);
	$fax = mysql_real_escape_string($_POST["fax"]);


	// other vars
	$institution = $INST['name'];
	$activated = "";
	
	// SAVE THE CURRENT DATA IN THE DATABASE
	if ($errors == 0) {
		// write the data to the database
		
		// update the user information first
		$usersql = "UPDATE users SET address='$address1', city='$city', state='$state', " .
			"zipcode='$zip', country='$country', phone='$phone', fax='$fax' where pk='$USER_PK'";
		$result = mysql_query($usersql) or die('User update query failed: ('.$usersql.')' . mysql_error());
header("Location: index.php");
}
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
	echo "<strong>Name:</strong> " . $USER['firstname'] . " " . $USER['lastname'] . "<br />";
	echo "<strong>Email:</strong> " . $USER['email'] . "<br />";
	echo "<strong>Institution:</strong> " . $INST['name'] . "<br />";
?>
	<div style="margin:10px;"></div>
	If the above information is wrong, use 
	<a href="<?= $ACCOUNTS_URL ?>/<?= $ACCOUNTS_PAGE ?>" >My Account</a>
	to correct it <strong>before</strong> registering
		</div>
	</td>
</tr>

   <tr valign="top">
  <td><div align=right>
	      <img id="titleImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
	      <strong>Your Role/Title:</strong>
      </div>
  </td>
  <td>
    <select name="title">
<?php if ($CONF['title']) {
	echo "<option value='".$CONF['title']."'>".$CONF['title']."</option>";
	}
?>
      <option value="">-- select --</option>
      <option value="Developer/Programmer">Developer/Programmer</option>
      <option value="UI Developer">UI Developer</option>
      <option value="User Support">User Support</option>
      <option value="Faculty">Faculty</option>
      <option value="Faculty Development">Faculty Development</option>
      <option value="Librarian">Librarian</option>
      <option value="Implementor">Implementor</option>
      <option value="Instructional Designer">Instructional Designer</option>
      <option value="Instructional Technologist">Instructional Technologist</option>
      <option value="Manager">Manager</option>
      <option value="System Administrator">System Administrator</option>
      <option value="University Administration">University Administration</option>
    </select>
	<input type="hidden" id="titleValidate" value="<?= $vItems['title'] ?>"/>
    <span id="titleMsg"></span>
  </td>
</tr>
    
<?php if (!$isPartner) {  // this means the user is NOT in partner inst 
?>
  <tr>
  <td>
      <div align="right">
      	<img id="otherInstImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
      	<strong><span class="formLable">Organization:</span></strong>
      </div>
  </td>
  <td>
  	<input type="text" name="otherInst" size="30" maxlength="30" value="<?php echo $USER['otherInst'];?>" />
  	<input type="hidden" id="otherInstValidate" value="<?= $vItems['otherInst'] ?>"/>
    <span id="otherInstMsg"></span>
  </td>
</tr>
<?php } ?>

<tr>
  <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
  	<div align="right">
  		<img id="address1Img" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
  		<strong><span class="formLable">Address</span>: </strong>
  	</div>
  </td>
  <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;">(Department, Street address, PO Box, etc.) <br />
    <textarea name="address1" cols='40' rows='3'><?php echo $USER['address'];?></textarea>
  	<input type="hidden" id="address1Validate" value="<?= $vItems['address1'] ?>"/>
    <span id="address1Msg"></span>
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
  	<input type="text" name="city" size="30" maxlength="30" value="<?php echo $USER['city'];?>" />
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
<?php if ($USER['state']) {
	echo "<option value='".$USER['state']."'>".$USER['state']."</option>";
	}
?>
      <option value="">State/Province</option>
      <option value="">----United States----</option>
      <option value="AL"> Alabama</option>
      <option value="AK"> Alaska</option>
      <option value="AZ"> Arizona</option>
      <option value="AR"> Arkansas</option>
      <option value="CA"> California</option>
      <option value="CO"> Colorado</option>
      <option value="CT"> Connecticut</option>
      <option value="DE"> Delaware</option>
      <option value="DC"> District of Columbia</option>
      <option value="FL"> Florida</option>
      <option value="GA"> Georgia</option>
      <option value="HI"> Hawaii</option>
      <option value="ID"> Idaho</option>
      <option value="IL"> Illinois</option>
      <option value="IN"> Indiana</option>
      <option value="IA"> Iowa</option>
      <option value="KS"> Kansas</option>
      <option value="KY"> Kentucky</option>
      <option value="LA"> Louisiana</option>
      <option value="ME"> Maine</option>
      <option value="MD"> Maryland</option>
      <option value="MA"> Massachusetts</option>
      <option value="MI"> Michigan</option>
      <option value="MN"> Minnesota</option>
      <option value="MS"> Mississippi</option>
      <option value="MO"> Missouri</option>
      <option value="MT"> Montana</option>
      <option value="NE"> Nebraska</option>
      <option value="NV"> Nevada</option>
      <option value="NH"> New Hampshire</option>
      <option value="NJ"> New Jersey</option>
      <option value="NM"> New Mexico</option>
      <option value="NY"> New York</option>
      <option value="NC"> North Carolina</option>
      <option value="ND"> North Dakota</option>
      <option value="OH"> Ohio</option>
      <option value="OK"> Oklahoma</option>
      <option value="OR"> Oregon</option>
      <option value="PA"> Pennsylvania</option>
      <option value="RI"> Rhode Island</option>
      <option value="SC"> South Carolina</option>
      <option value="SD"> South Dakota</option>
      <option value="TN"> Tennessee</option>
      <option value="TX"> Texas</option>
      <option value="UT"> Utah</option>
      <option value="VT"> Vermont</option>
      <option value="VA"> Virginia</option>
      <option value="WA"> Washington</option>
      <option value="WV"> West Virginia</option>
      <option value="WI"> Wisconsin</option>
      <option value="WY"> Wyoming</option>
      <option value="">&nbsp;</option>
      <option value="">----US Territories----</option>
      <option value="AS"> America Samoa</option>
      <option value="GU"> Guam</option>
      <option value="MH"> Marshall Islands</option>
      <option value="MP"> Northern Mariana Islands</option>
      <option value="PW"> Palau</option>
      <option value="PR"> Puerto Rico</option>
      <option value="VI"> Virgin Islands</option>
      <option value="">&nbsp;</option>
      <option value="">----Canada----</option>
      <option value="AB"> Alberta</option>
      <option value="BC"> British Columbia</option>
      <option value="MB"> Manitoba</option>
      <option value="NB"> New Brunswick</option>
      <option value="NF"> Newfoundland</option>
      <option value="NWT"> Northwest Territories</option>
      <option value="NS"> Nova Scotia</option>
      <option value="NU"> Nunavut</option>
      <option value="ON"> Ontario</option>
      <option value="PE"> Prince Edward Island</option>
      <option value="PQ"> Quebec</option>
      <option value="SK"> Saskatchewan</option>
      <option value="YT"> Yukon Territory</option>
      <option value="">&nbsp;</option>
      <option value="-other-">Other (Not Listed)</option>
    </select>
    <input style="display:none;" type="text" id="stateOther"  size="25" maxlength="50" value="<?= $USER['state'] ?>" />
  	<input type="hidden" id="stateValidate" value="<?= $vItems['state'] ?>"/>
    <span id="stateMsg"></span>
  </td>
</tr>


<tr>
  <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
  	<div align="right">
        <img id="zipImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
  		<strong><span class="formLable">Zip/Postal Code:</span></strong>
  	</div>
  </td>
  <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
  	<input type="text" name="zip" size="10" maxlength="10"  value="<?php echo $USER['zipcode'];?>" />
  	<input type="hidden" id="zipValidate" value="<?= $vItems['zip'] ?>"/><br />
    <span id="zipMsg"></span>
  </td>
</tr>


<tr>
  <td><div align="right">
    <img id="countryImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
  	<strong><span class="formLable">Country:</span></strong> 
  </div></td>
  <td>
      <select name="country">
<?php if ($USER['country']) {
	echo "<option value='".$USER['country']."'>".$USER['country']."</option>";
	}
?>
        <option value="">Country</option>
        <option value="US">United States</option>
        <option value="CA">Canada</option>
        <option value="AL">Albania</option>
        <option value="DZ">Algeria</option>
        <option value="AI">Anguilla</option>
        <option value="AR">Argentina</option>
        <option value="AU">Australia</option>
        <option value="AT">Austria</option>
        <option value="BS">Bahamas</option>
        <option value="BH">Bahrain</option>
        <option value="BD">Bangladesh</option>
        <option value="BE">Belgium</option>
        <option value="BM">Bermuda</option>
        <option value="BR">Brazil</option>
        <option value="BN">Brunei</option>
        <option value="BG">Bulgaria</option>
        <option value="KY">Cayman Islands</option>
        <option value="CL">Chile</option>
        <option value="CN">China</option>
        <option value="CO">Colombia</option>
        <option value="CR">Costa Rica</option>
        <option value="HR">Croatia</option>
        <option value="DK">Denmark</option>
        <option value="DJ">Djibouti</option>
        <option value="EC">Ecuador</option>
        <option value="EG">Egypt</option>
        <option value="ET">Ethiopia</option>
        <option value="FL">Falkland Islands (Malvinas)</option>
        <option value="FJ">Fiji</option>
        <option value="FI">Finland</option>
        <option value="FR">France</option>
        <option value="PF">French Polynesia</option>
        <option value="DE">Germany</option>
        <option value="GE">Georgia</option>
        <option value="GR">Greece</option>
        <option value="GU">Guam</option>
        <option value="GT">Guatemala</option>
        <option value="HK">Hong Kong</option>
        <option value="HU">Hungary</option>
        <option value="IN">India</option>
        <option value="ID">Indonesia</option>
        <option value="IE">Ireland</option>
        <option value="IL">Israel</option>
        <option value="IT">Italy</option>
        <option value="JP">Japan</option>
        <option value="JO">Jordan</option>
        <option value="KR">Korea</option>
        <option value="KW">Kuwait</option>
        <option value="LV">Latvia</option>
        <option value="LB">Lebanon</option>
        <option value="LU">Luxembourg</option>
        <option value="MO">Macau</option>
        <option value="MY">Malaysia</option>
        <option value="MT">Malta</option>
        <option value="MX">Mexico</option>
        <option value="MA">Morocco</option>
        <option value="NL">Netherlands</option>
        <option value="AN">Netherlands Antilles</option>
        <option value="NZ">New Zealand</option>
        <option value="NI">Nicaragua</option>
        <option value="NG">Nigeria</option>
        <option value="NF">Norfolk Island</option>
        <option value="NO">Norway</option>
        <option value="OM">Oman</option>
        <option value="PK">Pakistan</option>
        <option value="PA">Panama</option>
        <option value="PN">Papua New Guinea</option>
        <option value="PY">Paraguay</option>
        <option value="PE">Peru</option>
        <option value="PH">Philippines</option>
        <option value="PL">Poland</option>
        <option value="PT">Portugal</option>
        <option value="QA">Qatar</option>
        <option value="PA">Republic of Panama</option>
        <option value="RO">Romania</option>
        <option value="RU">Russia</option>
        <option value="SC">Seychelles</option>
        <option value="SA">Saudi Arabia</option>
        <option value="SG">Singapore</option>
        <option value="ZA">South Africa</option>
        <option value="ES">Spain</option>
        <option value="SE">Sweden</option>
        <option value="CH">Switzerland</option>
        <option value="SY">Syria</option>
        <option value="TW">Taiwan</option>
        <option value="TZ">Tanzania</option>
        <option value="TH">Thailand</option>
        <option value="TN">Tunisia</option>
        <option value="TR">Turkey</option>
        <option value="TC">Turks and Caicos Islands</option>
        <option value="TM">Turkmenistan</option>
        <option value="UG">Uganda</option>
        <option value="GB">United Kingdom</option>
        <option value="AE">United Arab Emirates</option>
        <option value="US">United States</option>
        <option value="UY">Uruguay</option>
        <option value="UZ">Uzbekistan</option>
        <option value="VE">Venezuela</option>
        <option value="VN">Vietnam</option>
        <option value="YE">Yemen</option>
        <option value="ZW">Zimbabwe</option>
		<option value="">&nbsp;</option>
		<option value="-other-">Other (Not Listed)</option>
    </select>
    <input style="display:none;" type="text" id="countryOther"  size="25" maxlength="100" value="<?= $USER['country'] ?>" />
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
  	<input type="text" name="phone" size="18" maxlength="18"  value="<?php echo $USER['phone']; ?>" />
  	<input type="hidden" id="phoneValidate" value="<?= $vItems['phone'] ?>"/><br />
    <span id="phoneMsg"></span>
  </td>
</tr>
<tr>
        <td>&nbsp;</td>
        <td> Click <strong>Submit</strong> to complete the proposal submission process. <br />
          <br />
          <input type="submit" name="submit" value="Submit" />
          <br />
        </td>
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
