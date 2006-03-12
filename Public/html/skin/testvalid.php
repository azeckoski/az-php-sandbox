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
<title>Ajax Form</title>

<script type="text/javascript" src="ajax/validate.js"></script>

</head>

<body>

<?php
if ($_REQUEST["submit"]) {
	print "Form submitted sucessfully";
	exit();
}
?>

<fieldset>
<legend>Ajax Form</legend>

<div id="requiredMessage"></div>
<form method="post" action="<?= $_SERVER["PHP_SELF"] ?>" style="margin:0px;">
<table>
	<tr>
		<td>Username</td>
		<td>
			<img id="userImg" src="ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" id="user" name="user" tabindex="1"/>
			<input type="hidden" id="userValidate" value="required"/>
			<span id="userMsg"></span>
		</td>
	</tr>
 
	<tr>
		<td>Email</td>
		<td>
			<img id="emailImg" src="ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" id="email" name="email" tabindex="2"/>
			<input type="hidden" id="emailValidate" value="required email"/>
			<span id="emailMsg"></span>
		</td>
	</tr>	

	<tr>
		<td>Other</td>
		<td>
			<img id="otherImg" src="ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" id="other" name="other" tabindex="3"/>
			<input type="hidden" id="otherValidate" value="required"/>
			<span id="otherMsg"></span>
		</td>
	</tr>	

	<tr>
		<td>Auxillary</td>
		<td>
			<img src="ajax/images/blank.gif" width="16" height="16"/>
			<input type="text" id="aux" name="aux" tabindex="3"/>
			<i>No validation</i>
		</td>
	</tr>	

	<tr>
		<td colspan="2">
			<input type="submit" name="submit" value="Save Information" tabindex="4" />
		</td>
	</tr> 
	
</table>

</form>
</fieldset>
</body>


</html>
