<?phpsession_start();$_SESSION['firstname']= $_POST['firstname'];$_SESSION['lastname']=$_POST['lastname'];$_SESSION['email1']=$_POST['email1'];if (isset($_POST['submit'])) {include ('validate_email.php');if ($valid) {include ('validate_sreg.php');if($valid AND $title AND $inst AND $add AND $city AND $state AND $zip AND $country AND $phone AND $hotelInfo AND $contactInfo AND $jasig){//validate then end session$_SESSION['badge']=$_POST['badge'];$_SESSION['institution']=$_POST['institution'];$_SESSION['otherInst']=$_POST['otherInst'];$_SESSION['dept']=$_POST['dept'];$_SESSION['address1']=$_POST['address1'];$_SESSION['address2']=$_POST['address2'];$_SESSION['city']=$_POST['city'];$_SESSION['state']=$_POST['state'];$_SESSION['otherState']=$_POST['otherState'];$_SESSION['zip']=$_POST['zip'];$_SESSION['country']=$_POST['country'];$_SESSION['phone']=$_POST['phone'];$_SESSION['fax']=$_POST['fax'];$_SESSION['shirt']=$_POST['shirt'];$_SESSION['special']=$_POST['special'];$_SESSION['hotelInfo']=$_POST['hotelInfo'];$_SESSION['contactInfo']=$_POST['contactInfo'];$_SESSION['jasig']=$_POST['jasig'];$_SESSION['ospi']=$_POST['ospi'];$_SESSION['title']=$_POST['title'];include("../includes/submit_reg2.php");}}}?><?php  require_once('../includes/reg_header.inc'); ?>					              </td>            <td valign="top" bgcolor="#FAFAFA" width="100%"><div classmain>              <table width="100%"  border="0" cellspacing="0" cellpadding="0">                <tr valign="top" bgcolor="#F1F1F1">                                  </tr>                <tr>                                  </tr>                <tr align="left" valign="top">                  <td colspan="3"                   style=" border-top: 4px solid #FFFFFF; padding: 5px;"><div class="main">                      <div class="componentheading">SEPP Member Registration Form</div><table class="blog" cellpadding="0" cellspacing="0"><tr><td valign="top"><div>		                   			<div>			            	<div>					     <form name="form1" method="post" action="<?php echo $_SERVER[PHP_SELF]; ?>">                   <table >   <tr>                                                    <td colspan=2>                          <br /><strong>Credit Card Payment</strong><br /> Registration for the public and non-member organizations opens in late September. <br />                              <br /><hr style="color:#eee; width:60%; align:center" />                              </td></tr>            <tr><td colspan=2>                                <?php if ($message) {	echo "<div class=\"errors\" align=\"left\"><blockquote><font color=red><strong>Please provide the following information:</strong></font><ul class=small>";		foreach ($message as $key => $value) {		echo $value;		}	echo "</ul></blockquote></div> ";}?>                          </td>                        </tr><tr>                                <td valign="top" colspan="2"> <div class="ccard"><FORM NAME="webcredit" ACTION="webcreditController" METHOD="POST" onSubmit="return sub_cc(this);">  <INPUT TYPE="HIDDEN" NAME="wc_deptid" VALUE="4321"/>  <INPUT TYPE="HIDDEN" NAME="wc_formid" VALUE="SAK1"/>  <INPUT TYPE="HIDDEN" NAME="wc_sc" VALUE="true"/>     <INPUT TYPE="HIDDEN" NAME="wc_addParm_curl" VALUE="http://www.sakaiproject.org/conferenceJune_05/confirmation.php" />      <INPUT TYPE="HIDDEN" NAME="wcsave_email" VALUE="" />      <INPUT TYPE="HIDDEN" NAME="wc_addItem_SAKreg" VALUE="1" />      <INPUT TYPE="HIDDEN" NAME="wc_deptid" VALUE="4321" />      <INPUT TYPE="HIDDEN" NAME="wc_addParm_eurl" VALUE="<p><b>We are sorry, your registration was not submitted.</b><br><br>Please double-check the form entries and try again. If you continue to have problems, contact the the webmaster at sakaiproject_webmaster@umich.edu.<br /><br /> <strong>Please note</strong>, we WILL hold your registration entry in our registration database while we look into the problems.</p> " />      <INPUT TYPE="HIDDEN" NAME="wc_formid" VALUE="SAK1" />      <INPUT TYPE="HIDDEN" NAME="wc_SAKreg_price" VALUE="395.00" /> <TABLE cellpadding="5" cellspacing="0">  <TR valign="top">    <TD width="8">&nbsp;</TD>    <TH align="right">Card Number:</th>    <TD><INPUT type="text" name="wc_cardnumber" SIZE="15" MAXLENGTH="20"></td>  </TR>  <TR valign="top">    <TD width="8">&nbsp;</TD>    <TH align="right">Expiration Date:</th>    <TD><INPUT type="text" name="wc_expdate" SIZE="5" MAXLENGTH="4">      <font face="Arial, Helvetica, sans-serif" size="1">(MMYY)</font></td>  </TR>  <TR valign=top>    <TD width="8">&nbsp;</TD>    <TH align="right">Cardholder's Name:</th>    <TD><font face="Arial, Helvetica, sans-serif" size="2">Enter name exactly as it appears on the card.</font><BR>      <INPUT type="text" name="wc_cardholder" SIZE="25" MAXLENGTH="30"></td>  </TR></TABLE>       <TABLE>  <TR valign="top">    <TD width="8">&nbsp;</TD>    <Th align="right">Amount:</th>    <TD>$395.00</TD>  </TR>  <TR>    <TD width="8">&nbsp;</TD>    <TD>      <INPUT type="submit" name="action" value="Submit">      <INPUT type="reset" value="Reset">    </TD>    <TD>&nbsp;</TD>  </TR></TABLE></FORM>                        <blockquote>                    <form name="webcredit" method="POST" action="https://chico.nss.udel.edu/webcredit/formview.jsp" onSubmit='return(sub_form(this) && sub_cc(this))'>                      <input type="submit" value="continue" />                      <input type="hidden" name="wc_formid"  value="SAK1" />                      <input type="hidden" name="wc_deptid"  value="4321" />                      <input type="hidden" name="wc_addItem_SAKreg"  value="1" />                      <input type="hidden" name="wc_SAKreg_price"  value="345.00" />                      <input type="hidden" name="wcsave_email"  value="<?php echo $_POST['email'];?>" />                      <input type="hidden" name="wc_addParm_curl" value="http://www.sakaiproject.org/conferenceJune_05/confirmation.php"/>                    <input type="hidden" name="wc_addParm_eurl" value="<p><b>We are sorry, your registration was not submitted.</b><br><br>Please double-check the form entries and try again. If you continue to have problems, contact the the webmaster at sakaiproject_webmaster@umich.edu.<br /><br /> <strong>Please note</strong>, we WILL hold your registration entry in our registration database while we look into the problems.</p> " />                    </form>                  </blockquote>                                      <form name="webcredit" method="POST" action="https://chico.nss.udel.edu/webcredit/formview.jsp" onSubmit='return(sub_form(this) && sub_cc(this))'>                      <input type="submit" value="continue" />                      <input type="hidden" name="wc_formid"  value="SAK1" />                      <input type="hidden" name="wc_deptid"  value="4321" />                      <input type="hidden" name="wc_addItem_SAKreg"  value="1" />                      <input type="hidden" name="wc_SAKreg_price"  value="395.00" />                                            <input type="hidden" name="wcsave_email"  value="<?php echo $_POST['email'];?>" />                      <input type="hidden" name="wc_addParm_curl" value="http://www.sakaiproject.org/conferenceJune_05/confirmation.php"/>                    <input type="hidden" name="wc_addParm_eurl" value="<p><b>We are sorry, your registration was not submitted.</b><br><br>Please double-check the form entries and try again. If you continue to have problems, contact the the webmaster at sakaiproject_webmaster@umich.edu.<br /><br /> <strong>Please note</strong>, we WILL hold your registration entry in our registration database while we look into the problems.</p> " />                    </form>                  </blockquote></div>                                  <?php   require_once('../includes/footer.inc'); ?>