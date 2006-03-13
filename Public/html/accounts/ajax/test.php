<?php
/*
 * file: test.php
 * Created on Mar 11, 2006 12:51:59 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title>Ajax Form</title>

<script type="text/javascript" src="testajax.js"></script>

<style type="text/css">
#userfield, #emailfield{
    color: #000000;
    float:left;
}
#user_container, #email_container{
    float:left;
}
.error{
    border: 2px solid #FF0000;
    background-color:#FEDADB;
}
.skipped{
    border: 2px solid #FF0000;
    background-color:#00CCFF;
}
.noclass{    
    color: #000000;
}
#submitholder{    
    color: #000000;
}
</style>

</head>

<body>
<form action="" method="get">
<table width="776" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td width="258">Username: *req* </td>
    <td width="497">
    <input type="text" name="user" id="userfield" onblur="validateForm('userfield');" onfocus="hiliteRequired('userfield')" />
    <div id="userfield_container"></div></td>
  </tr>
  <tr>
    <td>Email: *req* </td>
    <td><input type="text" name="email" id="emailfield" onblur=" validateForm('emailfield');" onfocus="hiliteRequired('emailfield')" /><div id="emailfield_container"></div></td>
  </tr>
  <tr>
    <td>What color is your shirt?: </td>
    <td><input type="text" name="textfield" onfocus="hiliteRequired('color',2)"  />    </td>
  </tr>
  <tr>
    <td>required (but not defined): </td>
    <td><input type="text" name="test" id="testfield" onfocus="hiliteRequired('testfield')" /></td>
  </tr>
  <tr>
    <td>required drop down: </td>
    <td>
    <select name="testoption" id="testoption" onfocus="hiliteRequired('testoption')">
      <option value=""></option>
      <option value="test">test</option>    
    </select>    </td>
  </tr>
  <tr>
    <td>not required: </td>
    <td><input type="text" name="test" id=Ótestfield2Ó onfocus="hiliteRequired('testfield2',5)" /></td>
  </tr>
  <tr>
    <td> </td>
    <td><div id="submitholder"></div></td>
  </tr>
</table>
</form>
</body>


</html>
