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
<table>
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
		<td>Other</td>
		<td>
			<img id="otherImg" src="ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="password" name="other" value="" />
			<input type="hidden" id="otherValidate" value="required:password"/>
			<span id="otherMsg"></span>
		</td>
	</tr>	

	<tr>
		<td>Drop-down List Box Test</td>
		<td>
			<img id="dropDownImg" src="ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<select name="dropDown" tabindex="4"">
			  <option value="" selected>blank value</option>
			  <option value="non-blank">non-blank value</option>
			</select>
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

Tons of test items for testing if the count of items causes problems:<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>
<input type="radio" name="extra" />1
<input type="radio" name="extra" />2
<input type="radio" name="extra" />3
<input type="radio" name="extra" />4
<input type="radio" name="extra" />5
<input type="radio" name="extra" />6
<input type="radio" name="extra" />7
<input type="radio" name="extra" />8
<input type="radio" name="extra" />9
<input type="radio" name="extra" />10<br/>

</form>
</fieldset>
</body>


</html>