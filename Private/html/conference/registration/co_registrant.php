<form name="<?php echo $formID; ?>" id=form1 method="post" action="<?php echo $_SERVER[PHP_SELF] . "?formid=$formID"; ?>">
  <table width="500px"  cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top" colspan="2" style="padding:0px;"><span class="small"> * = Required fields</span> </td>
    </tr>
    <?php 
if ($message) {
	echo "<tr><td colspan=2><div class=\"errors\" align=\"left\"><font color=red><strong>Please provide the following information:</strong></font>
	<ul class=small style=\"padding:0px 10px;\">";	
	foreach ($message as $key => $value) {
		echo $value;	
	}
	echo "</ul></div></td></tr> ";
}


?>
    <tr>
      <td colspan=2 class=noline"><strong>You are registering for someone other than yourself:</strong> <br />
        Please enter your information so that we may contact you with any questions regarding this registration. Then click on <strong>Continue</strong> to complete the registration information for the conference attendee. </td>
    </tr>
    <tr>
      <td colspan=2 style="border-bottom:0px solid #eee; padding:0px;"><br />
        <strong>* Your Contact Information</strong> (not the conference attendee's)<br />
        <table width="100%" cellpadding=0 cellspacing=0>
          <tr>
            <td valign=top style="border-bottom:0px solid #eee; padding-bottom: 0px;"><div>* Your first name<br />
                <input type="text" name="co_firstname" size="30" maxlength="100" value="<?php echo $_POST['co_firstname'];?>" />
              </div></td>
            <td valign=top style="border-bottom:0px solid #eee; padding:0px;"><div>&nbsp;</div>
              <div>* Your last name<br />
                <input type="text" name="co_lastname" size="30" maxlength="100" value="<?php echo $_POST['co_lastname'];?>" />
              </div></td>
          </tr>
          <tr>
            <td><div>* Your Email <br />
                <input type="text" name="co_email1" size="30" maxlength="65" value="<?php echo $_POST['co_email1'];?>" />
              </div></td>
            <td><div>* Confirm email<br />
                <input type="text" name="co_email2" size="30" maxlength="65" value="<?php echo $_POST['co_email2'];?>" />
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td colspan=2><strong>Enter Your Phone #: *</strong><br />
       ( use: xxx-xxx-xxxx )
        <input type="text" name="co_phone" size="30" maxlength="18" value="<?php echo $_POST['co_phone'];?>"/></td>
    </tr>
    <tr>
      <td></td>
      <td><input id="submitbutton" type="submit" name="submit_coReg" value="Continue" />
        <br />
      </td>
    </tr>
  </table>
</form>