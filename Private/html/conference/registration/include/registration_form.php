<?php
/*
 * Created on Mar 16, 2006
 * Created by author @aaronz - Aaron Zeckoski
 */
?>
<tr valign="top">
  <td style="border-bottom:0px solid #eee; padding-bottom: px; width: 160px;">
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

<?php if (!$isPartner) {  // this means the user is NOT in partner inst 
?>
  <tr>
  <td>
      <div align="right">
      	<img id="institutionImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
      	<strong><span class="formLable">Organization:</span></strong>
      </div>
  </td>
  <td>
  	<input type="text" name="institution" size="30" maxlength="30" value="<?= $User->institution ?>" />
  	<input type="hidden" id="institutionValidate" value="<?= $vItems['institution'] ?>"/>
    <span id="institutionMsg"></span>
  </td>
</tr>
<?php } ?>

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
  <td colspan=2>
	<img id="confHotelImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />  
  	<strong>Hotel Information:</strong><br />
    <div style="padding-left: 40px;">
    	Will you be staying at the conference hotel, the Amsterdam Movenpick Hotel?<br />
      <input type="radio" name="confHotel" value="Y" <?php if ($CONF['confHotel']=="Y") echo "checked='y'" ?> />
      <strong>Yes </strong>
      <input type="radio" name="confHotel" value="N" <?php if ($CONF['confHotel']=="N") echo "checked='y'" ?> />
      <strong>No</strong>
    </div>
	<input type="hidden" id="confHotelValidate" value="<?= $vItems['confHotel'] ?>" />
	<span id="confHotelMsg"></span>
  </td>
</tr>
<!--
 <tr>
  <td colspan=2>
	<img id="jasigImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />  
  	 <strong>Community Source Week Conferences:</strong><br /> 
  	 <strong>JA-Sig/uPortal Conference:</strong><br /> 
    <div style="padding-left: 40px;"> Will you also be attending the JA-SIG/uPortal conference?<br />
      <input type="radio" name="jasig" value="Y" <?php if ($CONF['jasig']=="Y") echo "checked='y'" ?> />
      <strong>Yes </strong>
      <input type="radio" name="jasig" value="N" <?php if ($CONF['jasig']=="N") echo "checked='y'" ?>/>
      <strong>No </strong> 
    </div>
    <input type="hidden" id="jasigValidate" value="<?= $vItems['jasig'] ?>"/>
	<span id="jasigMsg"></span>
  </td>
</tr> 
-->

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
     <td colspan="2" style="border-bottom:0;"> 	
     <table width="100%" cellpadding="0"  cellspacing="0" border="0" >
     <tr><td>
 <strong>Dates Attending:</strong></td>
     <td><div> Please check the days that you WILL ATTEND the Amsterdam conference. This information helps us save money, by providing a more accurate head count when ordering banquet services.</div>
        <br/> <strong> I WILL ATTEND</strong> on the following days:
        <br/><br/>
         <img id="attending_monImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
  	
      <input type="radio" name="attending_mon" value="MON"  <?php if ($_POST['attending_mon']=="MON") { echo "checked"; } ?> /> Yes<input type="radio" name="attending_tue" value=" " /> No &nbsp;&nbsp;&nbsp;
       <strong>Mon, Jun. 11th </strong>(Pre-Conference sessions)<br><br/>
     <input type="hidden" id="attending_monValidate" value="<?= $vItems['attending_mon'] ?>"/> 
	<span id="attending_monMsg"></span> 
	     <img id="attending_tueImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
  	
      <input type="radio" name="attending_tue" value="TUE"  <?php if ($_POST['attending_tue']=="TUE") { echo "checked"; } ?> /> Yes<input type="radio" name="attending_tue" value=" " /> No &nbsp;&nbsp;&nbsp;
     <strong>Tue, Jun. 12th</strong><br><br/>
     <input type="hidden" id="attending_tueValidate" value="<?= $vItems['attending_tue'] ?>"/>
	<span id="attending_tueMsg"></span> 
	
	<img id="attending_wedImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
 	
      <input type="radio" name="attending_wed" value="WED"  <?php if ($_POST['attending_wed']=="WED") { echo "checked"; } ?> /> Yes<input type="radio" name="attending_wed" value=" " /> No &nbsp;&nbsp;&nbsp;
     <strong>Wed, Jun. 13th</strong><br><br/>
      <input type="hidden" id="attending_wedValidate" value="<?= $vItems['attending_wed'] ?>"/>
	<span id="attending_wedMsg"></span> 
	
	
	<img id="attending_thuImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
      <input type="radio" name="attending_thu" value="THU"  <?php if ($_POST['attending_thu']=="THU") { echo "checked"; } ?> /> Yes<input type="radio" name="attending_thu" value=" " /> No &nbsp;&nbsp;&nbsp;
     	<strong>Thur, Jun. 14th</strong><br><br/>
     	<input type="hidden" id="attending_thuValidate" value="<?= $vItems['attending_thu'] ?>"/>
	<span id="attending_thuMsg"></span> 
	
	<img id="attending_friImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
      <input type="radio" name="attending_fri" value="FRI"  <?php if ($_POST['attending_fri']=="FRI") { echo "checked"; } ?> /> Yes<input type="radio" name="attending_fri" value=" " /> No &nbsp;&nbsp;&nbsp;
     <strong>Fri, Jun. 15th </strong> (Post-Conference meetings)<br><br/>
     <input type="hidden" id="attending_friValidate" value="<?= $vItems['attending_fri'] ?>"/>
	<span id="attending_friMsg"></span> 
	</td></tr></table>
     </td>
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
