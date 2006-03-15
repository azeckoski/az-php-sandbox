
<tr>
  <td colspan=2>
	<img id="hotelInfoImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>  
  	<strong>Hotel Information:</strong><br />
    <div style="padding-left: 40px;">
    	Will you be staying at the conference hotel, the Sheraton Vancouver Wall Centre, 
    	where the conference is being held?<br />
      <input type="radio" name="hotelInfo" value="Y" <?php if ($CONF['hotelInfo']=="Y") echo "checked" ?>/>
      <strong>Yes </strong>
      <input type="radio" name="hotelInfo" value="N" <?php if ($CONF['hotelInfo']=="N") echo "checked" ?>/>
      <strong>No</strong>
    </div>
	<input type="hidden" name="hotelInfoValidate" value="required"/>
	<span id="hotelInfoMsg"></span>
  </td>
</tr>

<tr>
  <td colspan=2>
	<img id="jasigImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>  
  	<strong>Community Source Week Conferences:</strong><br />
    <div style="padding-left: 40px;"> Will you also be attending the JA-SIG/uPortal conference in Vancouver June 4-6, 2005?<br />
      <input type="radio" name="jasig" value="Y" <?php if ($CONF['jasig']=="Y") echo "checked" ?> />
      <strong>Yes </strong>
      <input type="radio" name="jasig" value="N" <?php if ($CONF['jasig']=="N") echo "checked" ?>/>
      <strong>No </strong> 
    </div>
    <input type="hidden" name="jasigValidate" value="required"/>
	<span id="jasigMsg"></span>
  </td>
</tr>

<tr>
  <td colspan=2>
  	<strong>Special Needs:</strong><br/>
    <div style="padding:0px 20px;">
    	We are committed to making our conference activities 
    	accessible and enjoyable for everyone.&nbsp; If you have any type of special needs 
    	(i.e. dietary or accessibility), please provide that information here.<br />
    </div>
    <div style="padding-left: 40px;">
      <textarea name="special" cols=70 rows=3><?php echo $CONF['special'];?></textarea>
    </div></td>
</tr>

<tr>
  <td colspan=2 valign=top>
  	<img id="shirtImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
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
    <input type="hidden" name="shirtValidate" value="required"/>
	<span id="shirtMsg"></span>    
  </td>
</tr>

<tr>
  <td colspan=2><strong> Attendance Lists:</strong><br />
    <div style="padding-left: 40px;">We may publish a list of conference attendees both on the website and in printed programs (Names/Institutions only, no email addresses will be published). Check the box below to request your name not be published on this lists. <br />
      <div style="padding-left: 40px;">
        <input type="checkbox" name="publish" value="N" <?php if ($CONF['contactInfo']=="N") echo "checked" ?> />
        Do <strong>NOT</strong> publish my name </div>
    </div>
  </td>
</tr>

<tr>
  <td colspan=2><strong>Registration delegate contact email:</strong> (optional)<br />
    <div style="padding-left: 40px;">
      If you are completing this registration for someone else, please enter your email address below
      in case we need to contact you.
      <div style="padding-left: 40px;">
      	<img id="delegateImg" src="/accounts/ajax/images/blank.gif" width="16" height="16"/>
        <input type="text" name="delegate" size="40" maxlength="50" />
      </div>
    </div>
	<input type="hidden" name="delegateValidate" value="email"/>
	<span id="delegateMsg"></span> 
  </td>
</tr>
