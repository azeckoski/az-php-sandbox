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
<fieldset>
<legend>Ajax Form</legend>


<form method="post" action="<?= $_SERVER["PHP_SELF"] ?>">
<table>
	<tr>
		<td>Username</td>
		<td>
			<img id="userImg" src="ajax/images/blank.gif" width="16" height="16"/>
			<input id="user" type="text" name="user" tabindex="1"/>
			<input id="userValidate" type="hidden" value="validate required none"/>
			<span id="userMsg"></span>
		</td>
	</tr>
 
	<tr>
		<td>Email</td>
		<td>
			<img id="userImg" src="ajax/images/blank.gif" width="16" height="16"/>
			<input id="email" type="text" name="email" tabindex="2" class="validate required email"/>
			<span id="emailMsg"></span>
		</td>
	</tr>	

	<tr>
		<td>Other</td>
		<td>
			<img id="userImg" src="ajax/images/blank.gif" width="16" height="16"/>
			<input id="other" type="text" name="other" tabindex="3" class="validate required none"/>
			<span id="otherMsg"></span>
		</td>
	</tr>	

	<tr>
		<td><input type="submit" name="Submit" value="Submit" tabindex="4" /></td>
	</tr> 
	
</table>

</form>
</fieldset>
</body>


</html>
