
<form name="<?php echo $formID; ?>" id=form1 method="post" action="<?php echo $_SERVER[PHP_SELF] . "?formid=$formID"; ?>">
  <table width="500px"  cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top" colspan="2" style="padding:0px;"><span class="small"> * = Required fields</span> </td>
    </tr>
    <?php 
if ($message) {
	echo "<tr><td colspan=2><div class=\"errors\" align=\"left\"><font color=red><strong>Please provide the following information:</strong></font>
	<ul class=small style=\"padding:0px 10px;\">";	
	foreach ($message as $key => $value) {
		echo $value;	
	}
	echo "</ul></div></td></tr> ";
}


?>
    <?php
//echo $_SESSION['memberType'];

if ($_SESSION['regType']==2)
{
?>
    <tr >
      <td colspan=2 style="border-bottom:0px solid #eee;"><table width="100%" cellpadding=0 cellspacing=0>
          <tr>
            <td><div><strong>Registrant's Name</strong></div>
              <div>* First Name<br />
                <input type="text" name="firstname" size="30" maxlength="100" value="<?php echo $_POST['firstname'];?>" />
              </div></td>
            <td><div>&nbsp;</div>
              <div>* Last Name<br />
                <input type="text" name="lastname" size="30" maxlength="100" value="<?php echo $_POST['lastname'];?>" />
              </div></td>
          </tr>
          <tr>
            <td><div><strong>Registrant's Email Address</strong></div>
              <div>* Enter Email <br />
                <input type="text" name="email1" size="30" maxlength="65" value="<?php echo $_POST['email1'];?>" />
              </div></td>
            <td><div>&nbsp;</div>
              <div>* Confirm email<br />
                <input type="text" name="email2" size="30" maxlength="65" value="<?php echo $_POST['email2'];?>" />
              </div></td>
          </tr>
        </table></td>
    </tr>
    <?php }
      
      else {
      
      ?>
    <tr>
      <td colspan=2 style="border-bottom:0px solid #eee;"><table width="100%" cellpadding=0 cellspacing=0>
          <tr>
            <td><strong>* First Name</strong><br />
              <input type="text" name="firstname" size="30" maxlength="100" value="<?php echo $_POST['firstname'];?>" />
            </td>
            <td><strong> * Last Name</strong><br />
              <input type="text" name="lastname" size="30" maxlength="100" value="<?php echo $_POST['lastname'];?>" />
            </td>
          </tr>
          <tr>
            <td><strong>* Email Address</strong><br />
              <input type="text" name="email1" size="20" maxlength="65" value="<?php echo $_POST['email1'];?>" />
            </td>
            <td><strong>* Confirm email</strong><br />
              <input type="text" name="email2" size="20" maxlength="65" value="<?php echo $_POST['email2'];?>" />
              </div></td>
          </tr>
        </table></td>
    </tr>
    <?php }
      
      if ($_SESSION['regType']==2)
{

      
      ?>
    <tr valign="top">
      <td width=160px><div align=right><strong>* Registrant's Role/Title</strong></div></td>
      <td><?php }
      
     else
{

      
      ?>
    <tr valign="top">
      <td><div align=right><strong>* Your Role/Title</strong></div></td>
      <td><?php
      
      }
      $title=$_POST['title'];
      ?>
        <select name="title">
          <?php if (!$title==""){
echo "
 <option value=\"$title\" SELECTED>$title</option>";
 }  ?>
          <option value="">-- select --</option>
          <option value="Developer">Developer/Programmer</option>
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
      </td>
    </tr>
    <?php



if ($_SESSION['memberType']=="1") {
?>
    <tr>
      <td style="border-bottom:0px solid #ccc;"><div align=right><strong> Organization:</strong> </div></td>
      <td style="border-bottom:0px solid #ccc;"><?php echo $_SESSION['institution'];?>
        <input type=hidden name="institution" value="<?php echo $_SESSION['institution'];?>" /></td>
    </tr>
    <?php
         }   
         
         else { ?>
    <tr>
      <td style="border-bottom:0px solid #ccc;"><div align="right"><span class="formLable"> <strong>Organization/Company </strong></span></div></td>
      <td><input type="text" name="otherInst" size="30" maxlength="40" value="<?php echo $_POST['otherInst'];?>" />
&nbsp; </td>
    </tr>
    <?php
         
         }     ?>
    <tr>
      <td style="border-bottom:0px solid #eee; padding-bottom: 0px;"><div align="right"><strong><span class="formLable"> Address</span>: </strong></div></td>
      <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;">(Department, Street address, PO Box, etc.) <br />
        <textarea name="address1" cols=35 rows=3><?php echo $_POST['address1'];?></textarea></td>
    </tr>
    <tr>
      <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;"><div align="right"><strong><span class="formLable">Town/City:</span> <span class="required">*</span></strong></div></td>
      <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;"><input type="text" name="city" size="30" maxlength="30" value="<?php echo $_POST['city'];?>" /></td>
    </tr>
    <tr>
      <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;"><div align="right"><strong><span class="formLable">State/Province:</span> <span class="required">*</span></strong></div></td>
      <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;"><?php                         
                          
$state = $_POST['state'];
?>
        <select name="state">
          <?php if (!$state==""){
echo "
 <option value=\"$state\" SELECTED>$state</option>";
 }  ?>
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
        </select>
      </td>
    </tr>
    <tr>
      <td style="border-bottom:0px solid #eee; padding-bottom: 0px;"><div align="right"><strong><span class="formLable">Zip/Postal Code:</span></strong> </div></td>
      <td style="border-bottom:0px solid #eee; padding-bottom: 0px;"><input type="text" name="zip" size="10" maxlength="15"  value="<?php echo $_POST['zip'];?>" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong><span class="formLable">* Country:</span></strong> </div></td>
      <td><?php                         
                          
$country = $_POST['country'];
?>
          <select name="country">
            <?php if (!$country==""){
echo "
 <option value=\"$country\" SELECTED>$country</option>";
 }  ?>
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
          </select></td>
    </tr>
    <tr>
      <td style="border-bottom:0px solid #eee; padding-bottom: 0px;"><div align="right"><strong><span class="formLable">* Phone</span></strong> </div></td>
      <td style="border-bottom:0px solid #eee; padding-bottom: 0px;"><input type="text" name="phone" size="25" maxlength="18"  value="<?php echo $_POST['phone'];?>" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong><span class="formLable">Fax:</span></strong> </div></td>
      <td><input type="text" name="fax" size="25" maxlength="18"  value="<?php echo $_POST['fax'];?>" /></td>
    </tr>
    <tr>
      <td></td>
      <td><br />
        <br />
        <input id="submitbutton" type="submit" name="submit_attendee" value="Continue" />
        <br />
      </td>
    </tr>
  </table>
</form>