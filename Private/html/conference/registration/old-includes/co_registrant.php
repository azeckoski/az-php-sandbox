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
