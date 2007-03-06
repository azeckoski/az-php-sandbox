<?php
/* inst_form.php
 * Created on Mar 23, 2006 by az - Aaron Zeckoski
 * copyright 2006 Virginia Tech 
 */
?>
<table border="0" cellspacing="1" cellpadding="1">
<tr>
<td width="50%" valign="top">

<!-- Column One -->
<fieldset><legend>Institution</legend>
<table border="0" class="padded">
	<tr>
		<td class="account"><b>Name:</b></td>
		<td>
			<img id="nameImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="name" value="<?= $thisItem['name'] ?>" size="40" maxlength="200"/>
			<input type="hidden" id="nameValidate" value="<?= $vItems['name'] ?>" />
			<span id="nameMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Type:</b></td>
		<td style="font-size:10pt;">
			<img id="typeImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="radio" name="type" tabindex="3" value="educational" <?php
				if (!$thisItem["type"] || $thisItem["type"] == "educational") { echo " checked='y' "; }
			?>/> educational
			&nbsp;
			<input type="radio" name="type" tabindex="3" value="commercial" <?php
				if ($thisItem["type"] == "commercial") { echo " checked='y' "; }
			?>/> commercial
			&nbsp;
			<input type="radio" name="type" tabindex="3" value="" <?php
				if ($thisItem["type"] == "") { echo " checked='y' "; }
			?>/> non-member
			<input type="hidden" id="typeValidate" value="<?= $vItems['type'] ?>" />
			<span id="typeMsg"></span>
		</td>
	</tr>

<?php if (!$_REQUEST["add"]) { ?>
	<tr>
		<td class="account"><b>Inst Rep:</b></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
	if ($thisItem["rep_pk"]) {
		echo $thisItem["firstname"]." ".$thisItem["lastname"]." (<a href='mailto:".$thisItem["email"]."'>".$thisItem["email"]."</a>)";
	} else {
		echo "<i style='color:red;'>none</i>";
	}
?>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Voting Rep:</b></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
	if ($thisItem["repvote_pk"]) {
		echo $thisItem["vfirstname"]." ".$thisItem["vlastname"]." (<a href='mailto:".$thisItem["vemail"]."'>".$thisItem["vemail"]."</a>)";
	} else {
		echo "<i style='color:red;'>none</i>";
	}
?>
		</td>
	</tr>
<?php } // end add check 
?>

</table>
</fieldset>


<div style="margin:6px;"></div>
<?php 
if ($_REQUEST["add"]) {
	echo "<input type='submit' value='Add Institution' />";
} else {
	echo "<input type='submit' value='Save Information' />";
}
?>
</td>

<td width="50%" valign="top">
<!-- Column Two -->
<fieldset><legend>Location</legend>
<table border="0" class="padded">
	<tr>
		<td class="account"><b>City:</b></td>
		<td nowrap="y">
			<img id="cityImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="city" value="<?= $thisUser['city'] ?>" size="30" maxlength="50"/>
			<input type="hidden" id="cityValidate" value="<?= $vItems['city'] ?>"/>
			<span id="cityMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>State:</b></td>
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
		<td class="account"><b>Zipcode:</b></td>
		<td nowrap="y">
			<img id="zipcodeImg" src="/accounts/ajax/images/blank.gif" width="16" height="16" alt="valid indicator"/>
			<input type="text" name="zipcode" value="<?= $thisUser['zipcode'] ?>" size="10" maxlength="10"/>
			<input type="hidden" id="zipcodeValidate" value="<?= $vItems['zipcode'] ?>" />
			<span id="zipcodeMsg"></span>
		</td>
	</tr>

	<tr>
		<td class="account"><b>Country:</b></td>
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
</table>
</fieldset>
</td>
</tr>
</table>
