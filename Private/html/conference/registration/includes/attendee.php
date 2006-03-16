<?php
//echo "memberType=".$_SESSION['memberType'];
?>

    <tr valign="top">
      <td><div align=right>
		      <img id="titleImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
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
		<input type="hidden" id="titleValidate" value="required:focus"/>
        <span id="titleMsg"></span>
      </td>
    </tr>
    
<?php if (!$isPartner) {  // this means the user is NOT in partner inst ?>
    <tr>
      <td>
      	<div align="right"><span class="formLable">
      		<strong>Organization/Company: </strong>
      	</div>
      </td>
      <td>
      	<input type="text" name="otherInst" size="30" maxlength="40" value="<?php echo $CONF['otherInst']; ?>" />
      </td>
    </tr>
<?php } ?>

    <tr>
      <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
      	<div align="right">
      		<img id="address1Img" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
      		<strong><span class="formLable">Address</span>: </strong>
      	</div>
      </td>
      <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;">(Department, Street address, PO Box, etc.) <br />
        <textarea name="address1" cols='40' rows='3''><?php echo $USER['address'];?></textarea>
      	<input type="hidden" id="address1Validate" value="required"/>
        <span id="address1Msg"></span>
      </td>
    </tr>
    
    
    <tr>
      <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;">
	      <div align="right">
	      	<img id="cityImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
	      	<strong><span class="formLable">Town/City:</span></strong>
	      </div>
      </td>
      <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;">
      	<input type="text" name="city" size="30" maxlength="30" value="<?php echo $USER['city'];?>" />
      	<input type="hidden" id="cityValidate" value="required"/>
        <span id="cityMsg"></span>
      </td>
    </tr>
    
    
    <tr>
      <td  style="border-bottom:0px solid #eee; padding-bottom: 0px;">
      	<div align="right">
      		<img id="stateImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
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
        </select>
      	<input type="hidden" id="stateValidate" value="required"/>
        <span id="stateMsg"></span>
      </td>
    </tr>
    
    
    <tr>
      <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
      	<div align="right">
	        <img id="zipImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
      		<strong><span class="formLable">Zip/Postal Code:</span></strong>
      	</div>
      </td>
      <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
      	<input type="text" name="zip" size="10" maxlength="10"  value="<?php echo $USER['zipcode'];?>" />
      	<input type="hidden" id="zipValidate" value="zipcode"/><br>
        <span id="zipMsg"></span>
      </td>
    </tr>
    
    
    <tr>
      <td><div align="right">
        <img id="countryImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
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
        </select>
      	<input type="hidden" id="countryValidate" value="required"/>
        <span id="countryMsg"></span>
      </td>
    </tr>
    
    <tr>
      <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
      	<div align="right">
      		<img id="phoneImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
      		<strong><span class="formLable">Phone:</span></strong>
      	</div>
      </td>
      <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
      	<input type="text" name="phone" size="18" maxlength="18"  value="<?php echo $USER['phone']; ?>" />
      	<input type="hidden" id="phoneValidate" value="required:phone"/><br/>
        <span id="phoneMsg"></span>
      </td>
    </tr>
    <tr>
      <td>
      	<div align="right">
      		<img id="faxImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
      		<strong><span class="formLable">Fax:</span></strong>
      	</div>
      </td>
      <td>
      	<input type="text" name="fax" size="18" maxlength="18"  value="<?php echo $USER['fax']; ?>" />
      	<input type="hidden" id="faxValidate" value="phone"/><br>
        <span id="faxMsg"></span>
      </td>
    </tr>
