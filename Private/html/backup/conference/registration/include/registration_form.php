<?php
/*
 * Created on Mar 16, 2006
 * Created by author @aaronz - Aaron Zeckoski
 */
?>
<tr valign="top">
  <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
  	<div align=right>
		<img id="primaryRoleImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<strong>Your Primary Role:</strong>
		</div>
  </td>
  <td style="border-bottom:0px solid #eee; padding-bottom: 0px;">
	<select name="primaryRole">
<?php	$selectItem = $USER['primaryRole'];
		if ($selectItem) { echo "<option value='$selectItem'>$selectItem</option>"; }
		require $ACCOUNTS_PATH.'include/role_select.php';
?>
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
<?php	$selectItem = $USER['secondaryRole'];
		if ($selectItem) { echo "<option value='$selectItem'>$selectItem</option>"; }
		require $ACCOUNTS_PATH.'include/role_select.php';
?>
		<option value="" <?php if(!$USER['secondaryRole']) echo " selected='y' "; ?> >None</option>
	</select><br/>
	<input type="hidden" id="secondaryRoleValidate" value="<?= $vItems['secondaryRole'] ?>" />
	<span id="secondaryRoleMsg"></span>
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
<?php	$selectItem = $USER['state'];
		if ($selectItem) { echo "<option value='$selectItem'>$selectItem</option>"; }
		require $ACCOUNTS_PATH.'include/state_select.php';
?>
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
<?php	$selectItem = $USER['country'];
		if ($selectItem) { echo "<option value='$selectItem'>$selectItem</option>"; }
		require $ACCOUNTS_PATH.'include/country_select.php';
?>
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
  <td>
  	<div align="right">
  		<img id="faxImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
  		<strong><span class="formLable">Fax:</span></strong>
  	</div>
  </td>
  <td>
  	<input type="text" name="fax" size="18" maxlength="18"  value="<?php echo $USER['fax']; ?>" />
  	<input type="hidden" id="faxValidate" value="<?= $vItems['fax'] ?>"/><br />
    <span id="faxMsg"></span>
  </td>
</tr>
    
<tr>
  <td colspan=2>
	<img id="confHotelImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />  
  	<strong>Hotel Information:</strong><br />
    <div style="padding-left: 40px;">
    	Will you be staying at the conference hotel, the Sheraton Vancouver Wall Centre, 
    	where the conference is being held?<br />
      <input type="radio" name="confHotel" value="Y" <?php if ($CONF['confHotel']=="Y") echo "checked='y'" ?> />
      <strong>Yes </strong>
      <input type="radio" name="confHotel" value="N" <?php if ($CONF['confHotel']=="N") echo "checked='y'" ?> />
      <strong>No</strong>
    </div>
	<input type="hidden" id="confHotelValidate" value="<?= $vItems['confHotel'] ?>" />
	<span id="confHotelMsg"></span>
  </td>
</tr>

<tr>
  <td colspan=2>
	<img id="jasigImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />  
  	<strong>Community Source Week Conferences:</strong><br />
    <div style="padding-left: 40px;"> Will you also be attending the JA-SIG/uPortal conference in Vancouver June 4-6, 2005?<br />
      <input type="radio" name="jasig" value="Y" <?php if ($CONF['jasig']=="Y") echo "checked='y'" ?> />
      <strong>Yes </strong>
      <input type="radio" name="jasig" value="N" <?php if ($CONF['jasig']=="N") echo "checked='y'" ?>/>
      <strong>No </strong> 
    </div>
    <input type="hidden" id="jasigValidate" value="<?= $vItems['jasig'] ?>"/>
	<span id="jasigMsg"></span>
  </td>
</tr>

<tr>
  <td colspan=2>
  	<strong>Special Needs:</strong><br />
    <div style="padding:0px 20px;">
    	We are committed to making our conference activities 
    	accessible and enjoyable for everyone.&nbsp; If you have any type of special needs 
    	(i.e. dietary or accessibility), please provide that information here.<br />
    </div>
    <div style="padding-left: 40px;">
      <textarea name="special" cols=60 rows=3><?php echo $CONF['special'];?></textarea>
    </div></td>
</tr>

<tr>
  <td colspan=2 valign=top>
  	<img id="shirtImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
  	<strong>Conference T-Shirt:</strong><br />
    <div style="padding-left: 40px;">Please select your t-shirt size: 
      <select name="shirt">
<?php if ($CONF['shirt']) {
		echo "<option value='".$CONF['shirt']."'>".$CONF['shirt']."</option>";
	}
?>
        <option value="">-- Select Size --</option>
        <option value="Small">Small</option>
        <option value="Medium">Medium</option>
        <option value="Large">Large</option>
        <option value="X-Large">X-Large</option>
        <option value="XX-Large">XX-Large</option>
        <option value="XXX-Large">XXX-Large</option>
      </select>
    </div>
    <input type="hidden" id="shirtValidate" value="<?= $vItems['shirt'] ?>"/>
	<span id="shirtMsg"></span>    
  </td>
</tr>

<tr>
  <td colspan=2><strong> Attendance Lists:</strong><br />
    <div style="padding-left: 40px;">We may publish a list of conference attendees both on the website and in printed programs (Names/Institutions only, no email addresses will be published). Check the box below to request your name not be published on this lists. <br />
      <div style="padding-left: 40px;">
        <input type="checkbox" name="publish" value="N" <?php if ($CONF['publishInfo']=="N") echo "checked" ?> />
        Do <strong>NOT</strong> publish my name </div>
    </div>
  </td>
</tr>

<tr>
  <td colspan=2><strong>Conference expectations:</strong> (optional)<br />
    <div style="padding-left: 40px;">
		What do you expect to learn from this conference?</div>
	    <div style="padding-left: 40px;">
	      <textarea name="expectations" cols=60 rows=2><?php echo $CONF['expectations'];?></textarea>
	    </div></td>
    
</tr>

<tr>
  <td colspan=2><strong>Registration delegate contact email:</strong> (optional)<br />
    <div style="padding-left: 40px;">
      If you are completing this registration for someone else, please enter your email address below
      in case we need to contact you.
      <div style="padding-left: 40px;">
      	<img id="delegateImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
        <input type="text" name="delegate" value="<?php echo $CONF['delegate'];?>" size="40" maxlength="50" />
      </div>
    </div>
	<input type="hidden" id="delegateValidate" value="<?= $vItems['delegate'] ?>"/>
	<span id="delegateMsg"></span> 
  </td>
</tr>
