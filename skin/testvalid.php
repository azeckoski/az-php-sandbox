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
<form method="post" action="<?= $_SERVER["PHP_SELF"] ?>" style="margin:0px;">
<table>
	<tr>
		<td>Username</td>
		<td>
			<img id="usernameImg" src="ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="text" name="username" tabindex="1"/>
			<input type="hidden" name="usernameValidate" value="required:focus:alphanum:uniquesql;username;users"/>
			<span id="usernameMsg"></span>
		</td>
	</tr>
 
	<tr>
		<td>Email</td>
		<td>
			<img id="emailImg" src="ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="text" name="email" tabindex="2"/>
			<input type="hidden" name="emailValidate" value="required:email:uniquesql;email;users"/>
			<span id="emailMsg"></span>
		</td>
	</tr>

	<tr>
		<td>Other</td>
		<td>
			<img id="otherImg" src="ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="text" name="other" tabindex="3"/>
			<input type="hidden" name="otherValidate" value="required:nospaces"/>
			<span id="otherMsg"></span>
		</td>
	</tr>	

	<tr>
		<td>Auxillary</td>
		<td>
			<img src="ajax/images/blank.gif" width="16" height="16" alt="validation indicator" />
			<input type="text" name="aux" tabindex="3"/>
			<i>No validation</i>
		</td>
	</tr>	

	<tr>
		<td colspan="2">
			<input type="submit" name="submit" value="Save Information" tabindex="4" />
			<div id="errorMessage"></div>
		</td>
	</tr> 
	
</table>

</form>
</fieldset>
</body>


</html>
