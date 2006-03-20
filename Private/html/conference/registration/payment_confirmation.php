<?php
/*
 * Created on March 15, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once '../include/tool_vars.php';

$PAGE_NAME = "Payment Confirmation";
$Message = "";

// connect to database
require '../sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
$AUTH_MESSAGE = "You must login to make payment for the $CONF_NAME conference. " .
		"If you do not have an account, please create one and register first.";
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// bring in inst and conf data
require 'include/getInstConf.php';

// kick them off this page if they should not be here
if ( (!$isRegistered) || $isPartner || !$_POST) {
	// if not registered yet then send them packing
	// if they are in a partner institution then also send them packing
	$MSG = "?msg=".urlencode("Not registered or a partner " + $_GET['msg']);
	header('location:'.$TOOL_PATH.'/registration/index.php'.$MSG);
	exit;
}
$Message = $_GET['msg'];

// Gather Silent Post data from Verisign for payment for non-member.

$USER_PK=$_POST['USER1'];
$transID=$_POST['PNREF'];
$transAmount=$_POST['AMOUNT'];
$payee=$_POST['NAME'];
$payeePhone=$_POST['PHONE'];
$payeeEmail=$_POST['EMAIL'];
$payeeInfo=$payee ."\r" .$payeePhone ."\r" .$payeeEmail ;
$ResultCode=$_POST['RESULT'];
$ResponseMsg=$_POST['RESPMSG'];


if ($ResultCode== '0') { 
	//no fatal errors from Verisign 
	require_once('../sql/mysqlconnect.php');
	$sql = "UPDATE conferences SET date_modified = NOW(), fee='$transAmount', " .
	 	"transID = '$transID', payeeInfo='$payeeInfo', activated='1' " .
	 	"WHERE users_pk='$USER_PK' and confID='$CONF_ID'";
	$result = mysql_query($sql);
} else {
	$Message = "Failure: An error occurred with the credit card processing";
}
?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<?php include '../include/header.php'; ?>

<?php 
if ($Message) {
	print $Message;
	print "<br>" . $ResponseMsg;
	exit;
}
?>

<table width="500"  id=confirm  cellpadding="3" cellspacing="0">

  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td  colspan=2 style=" padding:5px;"><strong>Registration Complete</strong>: <br />
      Thank you for registering for the Sakai Vancouver conference. 
      You will receive a registration confirmation email and a payment confirmation email shortly. 
      See you in Vancouver! <br />
      <br />
      -- Sakai Conference Committee</td>
  </tr>

  <tr>
    <td colspan=2><blockquote style="background:#fff; border: 1px solid #ffcc33; padding: 5px;">
    <strong>Special announcements and reminders:</strong>
        <ul>
          <li><strong>Visit the Sakai Conference Facebook</strong> to see who else is attending -- and add your photo while you're there! (see sidebar for more information)</li>
          <li><strong>Call for Proposals Deadline is March 31st.</strong> [ <a href=" http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=170&amp;Itemid=519">more information</a> ]</li>
        </ul>
      </blockquote><div><br />
  <br />
  <br />
  <br />
</div>
<div><br />
  <br />
  <br />
  <br />
</div></td>
  </tr>
</table>
<!-- start  spacer  -->
<div><br />
  <br />
  <br />
  <br />
</div>

<!-- end  spacer  -->
</div>
<!-- end  content_main  -->
</div>
<!-- end container-inner -->
</div>
<!--end of outer left -->

<?php
	// include('confirm_reg_data.php');
	$memberType="2";  //non-member
	include('include/email_confirmation.php');
?>

<?php include '../include/outer_right.php'; // Include right column ?>

<?php require '../include/footer.php'; ?>