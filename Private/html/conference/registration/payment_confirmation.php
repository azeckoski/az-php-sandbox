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
	header('location:'.$TOOL_URL.'/registration/index.php'.$MSG);
	exit;
}
$Message = $_GET['msg'];

// Gather Silent Post data from Verisign for payment for non-member.

$userPK = $_POST['USER1'];
$transID=$_POST['PNREF'];
$transAmount=$_POST['AMOUNT'];
$payee=$_POST['NAME'];
$payeePhone=$_POST['PHONE'];
$payeeEmail=$_POST['EMAIL'];
$payeeInfo=$payee ."\r" .$payeePhone ."\r" .$payeeEmail ;
$ResultCode=$_POST['RESULT'];
$ResponseMsg=$_POST['RESPMSG'];
$trans_type="";
$trans_avs="";

//TODO
//track the Result Code, Reponse Msg, avs street match avs zip match
//international avs indicator
//transaction type 
//comment 1
//comment2 
if ($ResultCode<0) {
	//communications error, no transaction was attempted 
	$msg="A communications error occured when proccessing your request.  No credit card transaction took place.  " .
			"Please submit the form again or contact <a mailto:sakaiproject_webmaster@umich.edu>sakaiproject_webmaster@umich.edu</a>";
}  else if ($ResultCode>0)  {
	//indicates a decline or error, need to get the response msg
	switch ($ResultCode) {
		case 12: $msg="Please check to see that the credit card number has been entered properly, then resubmit.";
				break;
		case 24: $msg="Please check to see that the expiration date has been entered properly, then resubmit.";
			break;
		case 30: $msg="This is a duplicate transaction.  No payment has been processed on this current request." .
				"Please contact <a mailto:sakaiproject_webmaster@umich.edu>sakaiproject_webmaster@umich.edu</a> to verify your registration status. ";
				break;
		case 112:  $msg= "Authorization error - check address and zip code for this card.";
		default: $msg="There was an error processing your request, please contact  <a mailto:sakaiproject_webmaster@umich.edu>sakaiproject_webmaster@umich.edu</a>.   ";
		
	}
}
else if ($ResultCode== '0') { 
	//no fatal errors from Verisign 
	//TODO
	//need to add in the cc type, result code, result msg, avs code
	//do we need another table to track payment information
	
	require_once('../sql/mysqlconnect.php');
	$sql = "UPDATE conferences SET date_modified = NOW(), fee='$transAmount', " .
	 	"transID = '$transID', payeeInfo='$payeeInfo', activated='1' " .
	 	"WHERE users_pk='$userPK' and confID='$CONF_ID'";
	$result = mysql_query($sql) or die('Conf insert query failed: ('.$confsql.')' . mysql_error());
			
	header('Location:index.php');
} 
?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; ?>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<?php include $ACCOUNTS_PATH.'include/header.php';?>
<?php include 'include/registration_LeftCol.php'; // Include left column ?>


<?php 
if ($Message) {
	echo $Message;
	echo  "<br>" . $ResponseMsg;
	include $ACCOUNTS_PATH.'include/footer.php';
	exit;
}
?>

<table width="500"  id=confirm  cellpadding="3" cellspacing="0">

  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td  colspan=2 style=" padding:5px;"><strong>Registration Complete</strong>: <br />
      Thank you for registering for the Sakai Atlanta conference. 
      You will receive a registration confirmation email and a payment confirmation email shortly. 
      See you in Atlanta! <br />
      <br />
      -- Sakai Conference Committee</td>
  </tr>

  <tr>
    <td colspan=2><blockquote style="background:#fff; border: 1px solid #ffcc33; padding: 5px;">
    <strong>Special announcements and reminders:</strong>
        <ul>
      <!--    <li><strong>Visit the Sakai Conference Facebook</strong> to see who else is attending - and add your photo while you're there! (see sidebar for more information)</li>
      -->    <li><strong>Call for Proposals Deadline is September 30, 2006.</strong> [ <a href="http://sakaiproject.org/index.php?option=com_content&task=view&id=420&Itemid=593">more information</a> ]</li>
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

<?php
	// include('confirm_reg_data.php');
	$memberType="2";  //non-member
	include('include/email_confirmation.php');
?>


<?php require '../include/footer.php'; ?>