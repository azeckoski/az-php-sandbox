<?php
/*
 * file: testvalid.php
 * Created on Mar 11, 2006 4:30:06 PM by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title>Ajax Testing Form</title>

<script type="text/javascript" src="ajax/validate.js"></script>

</head>

<body>

<?php
if ($_REQUEST["submit"]) {
	print "<b>Form submitted sucessfully</b><br><br>Form Items Received:<br>";
	foreach ($_REQUEST as $key=>$value) {
		print "$key:$value<br>";
	}
	exit();
}
?>

<fieldset>
<legend>AJAX Demo Form</legend>

<div id="requiredMessage"></div>
<form name="testform" method="post" action="<?= $_SERVER["PHP_SELF"] ?>" style="margin:0px;">
<table width="90%">
	<tr>
		<td align="left" width="20%">
			<span id="tipLeftActivate">Left Item Tip</span>
			<input type="hidden" id="tipLeftParams" value="header;Left header" />
			<div id="tipLeft" style="display:none;width:200px;">
				This is my awesome tip
				for items on the left
				This is the 3rd line
			</div>
		</td>
		<td align="right">
			<span id="tipRightActivate">Right Item Tip</span>
			<div id="tipRight" style="display:none;width:200px;">
				<div style="color:white;background:darkblue;padding:2px;font-weight:bold;">Header</div>
				<div style="padding:3px;">
				This is my awesome tip for items on the right
				</div>
			</div>
		</td>
	<tr>
		<td>Username</td>
		<td>
			<img id="usernameImg" src="ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="text" name="username" value="<?php echo "prefillvalid"; ?>" />
			<input type="hidden" id="usernameValidate" value="required:focus:alphanum:uniquesql;username;users"/>
			<span id="usernameMsg"></span>
		</td>
	</tr>
 
	<tr>
		<td>Email</td>
		<td>
			<img id="emailImg" src="ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="text" name="email" value="<?php echo "prefill invalid"; ?>" />
			<input type="hidden" id="emailValidate" value="required:email:uniquesql;email;users"/>
			<span id="emailMsg"></span>
		</td>
	</tr>

	<tr>
		<td>ShowMe</td>
		<td>
			<span id="tip1Activate">Put mouse here<br/>Or anywhere near here</span>
			<div id="tip1" style="display:none;width:200px;">
				<div style="color:white;background:darkblue;padding:2px;font-weight:bold;">Header</div>
				<div style="padding:3px;">
				<img src="ajax/images/required.gif"/>
				<img src="ajax/images/validated.gif"/>
				<img src="ajax/images/invalid.gif"/>
				<img src="ajax/images/exclaim.gif"/>
				<= Images!
				<br/>
				Show this when the user puts their mouse over the activator
				</div>
			</div>
			<br/>
		</td>
	</tr>

	<tr>
		<td>Drop-down List Box Test</td>
		<td>
			<img id="dropDownImg" src="ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<select name="dropDown" tabindex="4"">
				<option value="" selected>blank value</option>
				<option value="non-blank">non-blank value</option>
				<option value="">&nbsp;</option>
				<option value="-other-">Other (Not Listed)</option>
			</select>
			<input style="display:none;" type="text" id="dropDownOther" value="" size="20" maxlength="50" />
			<input type="hidden" id="dropDownValidate" value="required"/>
			<span id="dropDownMsg"></span>
		</td>
	</tr>	

	<tr>
		<td valign="top">Radio Button Test
			<img id="radioImg" src="ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
		</td>
		<td valign="top">
			<div style="vertical-align:top;">
				<input type="radio" name="radio" value="" tabindex="5" checked="yes"> blank<br/>
				<input type="radio" name="radio" value="non-blank" tabindex="6" > non-blank<br/>
				<input type="radio" name="radio" value="also non-blank" tabindex="7"> also non-blank
			</div>
			<input type="hidden" id="radioValidate" value="required"/>
			<span id="radioMsg"></span>
		</td>
	</tr>	

	<tr>
		<td valign="top">Checkbox Test</td>
		<td valign="top">
			<img id="checkboxImg" src="ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="checkbox" name="checkbox" value="non-blank" tabindex="8"/> check this box to continue
			<input type="hidden" id="checkboxValidate" value="required"/>
			<span id="checkboxMsg"></span>
		</td>
	</tr>	


	<tr>
		<td valign="top">Auxillary</td>
		<td valign="top">
			<img src="ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="text" name="aux" tabindex="9"/>
			<i>No validation</i>
		</td>
	</tr>	

	<tr>
		<td colspan="2">
			<input type="submit" name="submit" value="Save Information" tabindex="10" />
			<div id="errorMessage"></div>
		</td>
	</tr> 
	
</table>

<textarea rows="4" cols="100" name="check"></textarea>

</form>
</fieldset>

<div style="background:black;width:20px;zindex:1;text-align:center;background-image:url(include/images/shadow-bg.png);">
<div style="background:white;width:94px;height:86px;zindex:2;float:center;text-align:center;margin:14px;">
Hiya<br/>
This<br/>
is neat<br/>
isn't it
</div>
</div>

</body>
</html>
