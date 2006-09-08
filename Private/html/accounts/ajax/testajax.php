<?php
/*
 * file: testvalid.php
 * Created on Mar 11, 2006 4:30:06 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Ajax Testing Form</title>
<script type="text/javascript" src="validate.js"></script>
</head>

<body>
<?php
if ($_REQUEST["submit"]) {
	print "<b>Form submitted sucessfully</b><br><br>Form Items Received:<br>";
	foreach ($_REQUEST as $key => $value) {
		print "$key:$value<br>";
	}
	exit ();
}
?>

<fieldset>
<legend>AJAX Demo Form</legend>

<div id="requiredMessage"></div>
<form name="yousuck" method="post" action="<?= $_SERVER["PHP_SELF"] ?>" style="margin:0px;">
<table>
	<tr>
		<td>Username</td>
		<td>
			<img id="usernameImg" src="images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="text" name="username" />
			<input type="hidden" id="usernameValidate" value="required:focus:alphanum:uniquesql;username;users"/>
			<span id="usernameMsg"></span>
		</td>
	</tr>
 
	<tr>
		<td>Email</td>
		<td>
			<img id="emailImg" src="images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="text" name="email" />
			<input type="hidden" id="emailValidate" value="required:email:uniquesql;email;users"/>
			<span id="emailMsg"></span>
		</td>
	</tr>

	<tr>
		<td>Other</td>
		<td>
			<img id="otherImg" src="images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="text" name="other" />
			<input type="hidden" id="otherValidate" value="required:nospaces"/>
			<span id="otherMsg"></span>
		</td>
	</tr>	

	<tr>
		<td>Textarea Test</td>
		<td>
			<img id="areaImg" src="images/blank.gif" width="16" height="16" alt="validation indicator" />
			<textarea name="area" cols="60" rows="4"></textarea><br/>
			<input type="hidden" id="areaValidate" value="required:nospaces"/>
			<span id="areaMsg"></span>
		</td>
	</tr>	


	<tr>
		<td>Drop-down List Box Test</td>
		<td>
			<img id="dropDownImg" src="images/blank.gif" width="16" height="16" alt="validation indicator" />
			<select name="dropDown">
			  <option value="" selected>blank value</option>
			  <option value="non-blank">non-blank value</option>
			</select>
			<input type="hidden" id="dropDownValidate" value="required"/>
			<span id="dropDownMsg"></span>
		</td>
	</tr>	

	<tr>
		<td valign="top">Radio Button Test</td>
		<td valign="top">
			<img id="radioImg" src="images/blank.gif" width="16" height="16" alt="validation indicator" />
			<div style="vertical-align:top;">
				<input type="radio" name="radio" value="" /> blank<br/>
				<input type="radio" name="radio" value="non-blank" /> non-blank<br/>
				<input type="radio" name="radio" value="also non-blank" /> also non-blank
				<input type="hidden" id="radioValidate" value="required:nospaces"/>
			</div>
			<div style="vertical-align:top;" id="radioMsg"></div>
		</td>
	</tr>	

	<tr>
		<td valign="top">Checkbox Test</td>
		<td valign="top">
			<img id="checkboxImg" src="images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="checkbox" name="checkbox" value="non-blank" /> check this box to continue
			<input type="hidden" id="checkboxValidate" value="required"/>
			<span id="checkboxMsg"></span>
		</td>
	</tr>	


	<tr>
		<td valign="top">Auxillary</td>
		<td valign="top">
			<img src="images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="text" name="aux" />
			<i>No validation</i>
		</td>
	</tr>	

	<tr>
		<td valign="top">Multiple checkboxes Test</td>
		<td valign="top">
			<img id="multiCheckImg" src="images/blank.gif" width="16" height="16" alt="validation indicator" />
			<br/>
			<input type="checkbox" name="multiCheck" value="1" /> checkbox 1 <br/>
			<input type="checkbox" name="multiCheck" value="2" /> checkbox 2 <br/>
			<input type="checkbox" name="multiCheck" value="3" /> checkbox 3 <br/>
			<input type="checkbox" name="multiCheck" value="4" /> checkbox 4 <br/>
			<input type="hidden" id="multiCheckValidate" value="required:multiple;2"/>
			<span id="multiCheckMsg"></span>
		</td>
	</tr>

	<tr>
		<td colspan="2">
			<input type="submit" name="submit" value="Save Information" />
			<div id="errorMessage"></div>
		</td>
	</tr> 
	
</table>

</form>
</fieldset>
</body>


</html>
