<?php //add a new facebook entryif (isset($_POST['submit'])) {//check for required fields and make sure they are registered for the conferenceinclude ('includes/validateEmail.php');if ($valid) {//upload image and add information to databaseinclude('includes/update.php');if ($success) {header("Location:view_entry.php?id=$user_id");}}}//get page header require_once('includes/facebook_headernew.inc');?>                                  <?php                if ($message) {//form errors 	echo " <div class=\"errors\" align=\"left\"><blockquote><ul>";		foreach ($message as $key => $value) {		echo $value;		}	echo "</ul></blockquote></div> ";	}if (!$success){//new entry- or an error occurred so let user change form input and try again?>			 <div id="cfp"><form id=form1 enctype="multipart/form-data" action="<?php echo $_SERVER[PHP_SELF]; ?>" method="post"><table width="100%" cellpaddng=0 cellspacing=0><tr><td colspan=2>    <input type="hidden" name="MAX_FILE_SIZE" value="100000" /> <div> You must be registered for the Sakai Vancouver Conference in order to add your photo here. <br /><strong>Not registered?</strong>  <a href="https://sakaiproject.org/secure/vancouver/registration/index.php">Register Now. </a> <br /><br />* = Required<br /></div></td></tr><tr><td class=label>* First name: </td><td><span class=data><input type="text" name="firstname" size="30" maxlength="40" value="<? echo $_POST['firstname']?>" /></span></div></td></tr><tr><td class=label>* Last name: </td><td><span class=data><input type="text" name="lastname" size="30" maxlength="40" value="<? echo $_POST['lastname']?>" /></span></div></td></tr> <tr><td class=label>* Organization: </td><td><span class=data><input type="text" name="Institution" size="30" maxlength="40" value="<? echo $_POST['Institution']?>" /></span></div></td></tr><tr><td class=label>Interests: </td><td><span class=data><textarea name="interests" cols="35" rows="3" id="interests"><? echo $_POST['interests']?></textarea></span></div></td></tr><tr><td class=label>* Email: </td><td><span class=data><input type="text" name="email1" size="30" maxlength="70" value="<? echo $_POST['email1']?>" /></span></div> </td></tr><!-- <tr><td class=label>* Confirm email: </td><td><span class=data><input type="text" name="email2" size="30" maxlength="70" value="<? echo $_POST['email2']?>" /></span></div></td></tr>--><tr><td  class=label>Home page url: </td><td><span class=data><input type="text" name="url" size="40" maxlength="250" value="<? echo $_POST['url']?>" /></span></div></td></tr> <tr><td  class=label>  Upload image: </td><td><span class=data>recommended size: 400x400 pixels (jpg, gif, png, bmp)</span></div></td></tr><tr><td class=label>&nbsp;</td><td><span class=data>* &nbsp;<input name="userfile" type="file" accept="image/jpg, image/gif, image/png, image/bmp"/></span></div><br /></td></tr><tr><td class=label>&nbsp;</td><td><span class=data><input type="submit" name="submit" value="Add to Facebook" /></span></div></td></tr> </table></form></div><?php }?>       <?php   //get page footer  require_once('includes/facebook_footernew.inc');?>