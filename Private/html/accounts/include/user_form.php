<?php
/*
 * file: user_form.php
 * Created on Mar 18, 2006 8:16:25 AM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="50%" valign="top">

<!-- Column One -->
<fieldset><legend><strong style="font-size:1.1em;">Personal</strong></legend>
<table border="0" cellpadding="2" cellspacing="0">
	<tr>
		<td class="account"><strong>Username:</strong></td>
		<td nowrap="y">
			<img id="usernameImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
<?php if($disableUsername) { ?>
			<input type="text" name="username" value="<?= $thisUser['username'] ?>" size="40" maxlength="50" disabled="true"/>
<?php } else { ?>
			<input type="text" name="username" value="<?= $thisUser['username'] ?>" size="40" maxlength="50" />
			<input type="hidden" id="usernameValidate" value="<?= $vItems['username'] ?>"/>
			<span id="usernameMsg"></span>
			<br/>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<i style="font-size:.95em; color:red; padding-left: 10px;">Email address required for username</i>
<?php } ?>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>Password:</strong></td>
		<td nowrap="y">
			<img id="password1Img" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="password" name="password1" maxlength="50"/>
			<input type="hidden" id="password1Validate" value="<?= $vItems['password1'] ?>"/>
			<span id="password1Msg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>Confirm&nbsp;pwd:</strong></td>
		<td nowrap="y">
			<img id="password2Img" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="password" name="password2" maxlength="50"/>
			<input type="hidden" id="password2Validate" value="<?= $vItems['password2'] ?>"/>
			<span id="password2Msg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>First&nbsp;name:</strong></td>
		<td nowrap="y">
			<img id="firstnameImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="firstname" value="<?= $thisUser['firstname'] ?>" size="30" maxlength="50"/>
			<input type="hidden" id="firstnameValidate" value="<?= $vItems['firstname'] ?>" />
			<span id="firstnameMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>Last&nbsp;name:</strong></td>
		<td nowrap="y">
			<img id="lastnameImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="lastname" value="<?= $thisUser['lastname'] ?>" size="30" maxlength="50"/>
			<input type="hidden" id="lastnameValidate" value="<?= $vItems['lastname'] ?>" />
			<span id="lastnameMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>Email:</strong></td>
		<td nowrap="y">
			<img id="emailImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="email" value="<?= $thisUser['email'] ?>" size="40" maxlength="50"/>
			<input type="hidden" id="emailValidate" value="<?= $vItems['email'] ?>" />
			<span id="emailMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>Primary&nbsp;Role:</strong></td>
		<td nowrap="y">
			<img id="primaryRoleImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<select name="primaryRole">
				<option value="">-- select role --</option>
				<?= generate_roles_dropdown($thisUser['primaryRole']) ?>
			</select><br/>
			<input type="hidden" id="primaryRoleValidate" value="<?= $vItems['primaryRole'] ?>" />
			<span id="primaryRoleMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>Secondary&nbsp;Role:</strong></td>
		<td nowrap="y">
			&nbsp; &nbsp; &nbsp; <img id="secondaryRoleImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<select name="secondaryRole">
				<option value="">-- select role --</option>
				<?= generate_roles_dropdown($thisUser['secondaryRole']) ?>
				<option value="" <?php if(!$thisUser['secondaryRole']) echo " selected='y' "; ?> >None</option>
			</select> <em style="font-size:.9em;">(if applicable)</em><br/>
			<input type="hidden" id="secondaryRoleValidate" value="<?= $vItems['secondaryRole'] ?>" />
			<span id="secondaryRoleMsg"></span>
		</td>
	</tr>

</table>
</fieldset>

<div style="margin:6px;">
<span>
	<strong>Note:</strong> <i>Your user information is private and will only be used in this system.<br/>
	It will not be given to anyone else. Passwords are not stored as plain text in the database.</span><br/><br/></div>
<?php 
if ($submitButtonName) {
	echo "<input id='submitbutton' type='submit' value='$submitButtonName' />";
} else {
	echo "<input id='submitbutton' type='submit' value='Save Information' />";
}
?>

</td>
<td width="50%" valign="top">

<!-- Column Two -->
<fieldset><legend><strong style="font-size:1.1em;">Location</strong></legend>
<table border="0" cellpadding="2" cellspacing="0">
	<tr><td class="account" colspan=2 style="padding-bottom: 10px;"> <strong>Organization:</strong><br/>Select your organization from the Sakai Partner list below. 
	<br/>(If your Sakai Partner organization is not listed below, please contact <a mailto:mmiles@umich.edu">mmiles@umich.edu).</a><br/> <br/>If your organization is <strong>not</strong> a Sakai Partner, select <strong>Other </strong><br/> then enter the organization name into the box provided. 
	  <span style=" color: #333;"> <br/></span>
	</td>
	</tr>
	<tr>
		<td class="account"> </td>
		<td nowrap="y">
			<img id="institution_pkImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<select name="institution_pk">
<?php	$selectItem = $thisUser['institution'];
		$opInst = new Institution(); // blank inst object to fetch data
		if ($selectItem) { echo "<option value='$selectItem'>$selectItem</option>"; }
?>
				<option value=""> --Select Your Organization-- </option>
				<?= $opInst->generate_partner_dropdown($thisUser['institution_pk'],false,'1') ?>
				<option value="">&nbsp;</option>
				<option value="-other-">Other (Not Listed)</option>
			</select><br/>
			<input style="display:none;" type="text" id="institution_pkOther" value="<?= $thisUser['institution'] ?>" size="40" maxlength="100" />
			<input type="hidden" id="institution_pkValidate" value="<?= $vItems['institution_pk'] ?>" />
			<span id="institution_pkMsg"></span><br/><br/>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>Address:</strong></td>
		<td nowrap="y">
			&nbsp; &nbsp; &nbsp; <img id="addressImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<textarea name="address" cols="30" rows="3"><?php echo $thisUser['address'];?></textarea>
			<input type="hidden" id="addressValidate" value="<?= $vItems['address'] ?>"/>
			<span id="addressMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>City:</strong></td>
		<td nowrap="y">
			<img id="cityImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="city" value="<?= $thisUser['city'] ?>" size="30" maxlength="50"/>
			<input type="hidden" id="cityValidate" value="<?= $vItems['city'] ?>"/>
			<span id="cityMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>State:</strong></td>
		<td nowrap="y">
			<img id="stateImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<select name="state">
<?php	$selectItem = $thisUser['state'];
		if ($selectItem) { echo "<option value='$selectItem'>$selectItem</option>"; }
		require $ACCOUNTS_PATH.'include/state_select.php';
?>
				<option value="">&nbsp;</option>
				<option value="-other-">Other (Not Listed)</option>
			</select>
			<input style="display:none;" type="text" id="stateOther" value="<?= $thisUser['state'] ?>" size="20" maxlength="50" />
			<input type="hidden" id="stateValidate" value="<?= $vItems['state'] ?>" />
			<span id="stateMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>Zipcode:</strong></td>
		<td nowrap="y">
			<img id="zipcodeImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="zipcode" value="<?= $thisUser['zipcode'] ?>" size="10" maxlength="10"/>
			<input type="hidden" id="zipcodeValidate" value="<?= $vItems['zipcode'] ?>" />
			<span id="zipcodeMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>Country:</strong></td>
		<td nowrap="y">
			<img id="countryImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<select name="country">
<?php	$selectItem = $thisUser['country'];
		if ($selectItem) { echo "<option value='$selectItem'>$selectItem</option>"; }
		require $ACCOUNTS_PATH.'include/country_select.php';
?>
				<option value="">&nbsp;</option>
				<option value="-other-">Other (Not Listed)</option>
			</select>
			<input style="display:none;" type="text" id="countryOther" value="<?= $thisUser['country'] ?>" size="20" maxlength="50" />
			<input type="hidden" id="countryValidate" value="<?= $vItems['country'] ?>" />
			<span id="countryMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>Phone:</strong></td>
		<td nowrap="y">
			<img id="phoneImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="phone" value="<?= $thisUser['phone'] ?>" size="15" maxlength="15"/>
			<input type="hidden" id="phoneValidate" value="<?= $vItems['phone'] ?>" />
			<span id="phoneMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><strong>Fax:</strong></td>
		<td nowrap="y">
			<img id="faxImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="fax" value="<?= $thisUser['fax'] ?>" size="15" maxlength="15"/>
			<input type="hidden" id="faxValidate" value="<?= $vItems['fax'] ?>" />
			<span id="faxMsg"></span>
		</td>
	</tr>

</table>
</fieldset>


</td>
</tr>
</table>
