<?php/* * Created on March 13, 2006 by @author aaronz * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/) */?><?phprequire_once '../include/tool_vars.php';$PAGE_NAME = "Registration";$Message = "";// connect to databaserequire '../sql/mysqlconnect.php';// check authenticationrequire $ACCOUNTS_PATH.'include/check_authentic.php';// login if not autheticatedrequire $ACCOUNTS_PATH.'include/auth_login_redirect.php';// bring in the form validation coderequire $ACCOUNTS_PATH.'ajax/validators.php';// TODO - GET RID OF THIS JUNK//require_once('./includes/processForms.php');// add in the help link//$EXTRA_LINKS = " - <a style='font-size:9pt;' href='$HELP_LINK' target='_HELP'>Help</a><br/>";//$EXTRA_MESSAGE = "<br/><span style='font-size:8pt;'>Technical problems? Please contact <a href='mailto:$HELP_EMAIL'>$HELP_EMAIL</a></span><br/>";?><?php include $ACCOUNTS_PATH.'include/top_header.php'; // INCLUDE THE HTML HEAD ?><script type="text/javascript" src="/accounts/ajax/validate.js"></script><?php include '../include/header.php'; // INCLUDE THE HEADER ?><table width="100%" class="blog" cellpadding="0" cellspacing="0">  <tr>    <td valign="top"><div class="componentheading">Sakai Conference Registration</div></td>  </tr></table><?php	// this should never happen but just in case	if (!$USER['institution_pk']) {		print "<b style='color:red;'>Fatal Error: You must use the My Account link to set " .			"your institution before you can fill out your conference registration.";	} else {		// allow registration?><?php if ($message) {	echo "<tr><td colspan=2><div class=\"errors\" align=\"left\"><font color=red><strong>Please provide the following information:</strong></font>	<ul class=small style=\"padding:0px 10px;\">";		foreach ($message as $key => $value) {		echo $value;		}	echo "</ul></div></td></tr> ";}?><!-- start of the form td --><div id=cfp><br /> <!-- start form section --><form name="<?= $formID ?>" id=form1 method="post" action="<?= $_SERVER['PHP_SELF']."?formid=$formID" ?>">  <table width="500px"  cellpadding="0" cellspacing="0">    <tr>      <td valign="top" colspan="2" style="padding:0px;"><span class="small"> * = Required fields</span> </td>    </tr>    <tr>      <td colspan=2><?php	$inst_sql = "select * from institution where pk='".$USER['institution_pk']."'";	$result = mysql_query($inst_sql) or die('Institution fetch query failed: ' . mysql_error());	$INST = mysql_fetch_assoc($result); // first result is all we care about	if ($INST['type']) {  // this means the user is in a partner inst ?>	<strong><?= $INST['name'] ?> is a Sakai Partner Organization</strong> (registration is waived)	<input type="hidden" name="memberType" value="1" />	<input type="hidden" name="institution" value="<?= $INST['name'] ?>" /><?php } else { // this is a member institution ?>	&nbsp;<strong><?= $INST['name'] ?> is not a Sakai Partner Organization</strong>&nbsp;	<input type="hidden" name="memberType" value="2" />        <div style="padding-left: 40px;"><br />          <strong>Registration Fee:</strong> $395 per person. <br />          If you are also attending the uPortal conference, your fee will be discounted to $345<br /><br />          Visa, Mastercard and American express accepted<br />          <img src="../../templates/vancouver/images/ccards.jpg" width="121px" height="30px">        </div><?php } ?>		</td>    </tr><?php/*******************************///print forms/*******************************///combined forms to get user informationinclude("includes/attendee.php");include("includes/otherInfo.php");?><?php if ($INST['type']) { // this means the user is in a partner inst ?>    <tr>      <td colspan=2><div align=center>          <input id="submitbutton" type="submit" name="submit_MemberReg" value="Save my registration" />        </div></td>    </tr><?php  } else { ?>    <tr>      <td colspan=2><div align=center>          <input id="submitbutton" type="submit" name="submit_NonMemberReg" value="Save and continue" />        </div></td>    </tr><?php  } ?>  </table></form><!--end of unique form info for form1 --></div> <!-- end cfp --><?php } ?><?php include '../include/footer.php'; // Include the FOOTER ?>