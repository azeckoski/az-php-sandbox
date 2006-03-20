<?php  
session_start();
require_once '../include/tool_vars.php';

$PAGE_NAME = "Payment";
$Message = "";

// connect to database
require '../sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// login if not autheticated
$AUTH_MESSAGE = "You must login to make payment for the $CONF_NAME conference. If you do not have an account, please create one and register first.";
require $ACCOUNTS_PATH.'include/auth_login_redirect.php';

// bring in inst and conf data
require 'include/getInstConf.php';

// kick them off this page if they should not be here
if ( (!$isRegistered) || $isPartner) {
	// if not registered yet then send them packing
	// if they are in a partner institution then also send them packing
	$MSG = "?msg=".urlencode("Not registered or a partner " + $_GET['msg']);
	header('location:'.$TOOL_PATH.'/registration/index.php'.$MSG);
	exit;
}
$Message = $_GET['msg'];

// add in the help link
//$EXTRA_LINKS = " - <a style='font-size:9pt;' href='$HELP_LINK' target='_HELP'>Help</a><br/>";
//$EXTRA_MESSAGE = "<br/><span style='font-size:8pt;'>Technical problems? Please contact <a href='mailto:$HELP_EMAIL'>$HELP_EMAIL</a></span><br/>";
?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<style type="text/css">
#activity{
color:#000;
}
#activity td{
padding: 0px 5px;
color:#000;
}
</style>
<script type="text/javascript" src="/accounts/ajax/validate.js"></script>
<?php include '../include/header.php'; // INCLUDE THE HEADER ?>

<?php
$today = date($DATE_FORMAT,time());

/*******************************/
//billing information
/*******************************/
$amount = '0.00';
if (!$isPartner){
	//non member must pay
	if($CONF['jasig']=='Y'){
		$amount='345.00';
	} else {
		$amount='395.00';
	}
	$_SESSION['fee']=$amount; // TODO - session?
}
?>

<table width="100%" class="blog" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><div class="componentheading">Sakai Conference Registration</div></td>
  </tr>
</table>

<?= $Message ?>

<!-- start of the form td -->
<div id=cfp> <br />

<!-- start form section -->
<form id='form1' method="POST" action="https://payments.verisign.com/payflowlink">
<table width="500px"  cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" colspan="2" style="padding:0px;">
			<span class="small"> * = Required fields</span>
		</td>
    </tr>
	<tr>
		<td valign=top>
			<div align=\"right\">
				<strong>Registrant's Information: </strong>
			</div>
		</td>
		<td>
			name: <?php echo $USER['firstname'] . " " . $USER['firstname']; ?><br /> 
			email: <?php echo $USER['email']; ?><br/>
			<br />
			institution: 
			<?php if ($CONF['otherInst']) {
				echo $CONF['otherInst'];
			} else {
				echo $CONF['institution']; 
			} ?><br/>
			address:<br/>
			<?php echo $USER['address']; ?><br />
			<?php echo $USER['city'] ." ". $USER['state'] .", ". $USER['zipcode']; ?><br/>
			<?php echo $USER['country']; ?><br />
			<br />
			phone: <?php echo $USER['phone']; ?><br />
			fax: <?php echo $USER['fax']; ?><br/>
		</td>
	</tr>

	<tr>
		<td valign=top>
			<div align=\"right\">
				<strong><span>Registration Fee</span>: &nbsp;&nbsp;&nbsp;</strong> 
			</div></strong>
		</td>
	 	<td width='300px'><?= $amount ?></td>
	</tr>

<?php if ($CONF['transID']) { 
	// user has already paid
?>

	<tr>
		<td valign=top>
			<div align=\"right\">
				<strong><span>Registration Fee</span>: &nbsp;&nbsp;&nbsp;</strong> 
			</div></strong>
		</td>
	 	<td width='300px'><?= $amount ?></td>
	</tr>

<?php } else { 
	// user needs to pay for this conference still
?>
	<tr>
	    <td>&nbsp;</td>
	    <td><br />
			<input type="hidden" name="USER1" value="<?php echo $USER_PK ?>">
			<input type="hidden" name="USER2" value="<?php echo $registrant ?>">
			<input type="hidden" name="USER3" value="<?php echo $CONF['delegate'] ?>">
			<!--  
			<input type="hidden" name="ORDERFORM" value="TRUE" >
			<input type="hidden" name="ECHODATA" value="TRUE" >
			<input type="hidden" name="EMAILCUSTOMER" value="FALSE" >
			<input type="hidden" name="SHOWCONFIRM" value="TRUE" >
			-->
          <!-- cardnum for testing -->
       <!--   <input type="hidden" name="CARDNUM" value="4111111111111111" > -->
          <!-- cardnum for testing -->
         <!-- <input type="hidden" name="EXPDATE" value="0806" > -->
          <!--  exp date for testing -->
          <input type="hidden" name="METHOD" value="CC" >
          <input type="hidden" name="TYPE" value="S">
          <input type="hidden" name="LOGIN" value="sakaiproject">
          <input type="hidden" name="PARTNER" value="verisign">
<?php  $amount='1.00';
?>
          <input type="hidden" name="AMOUNT" value="<?php echo $amount; ?>">
          <input type="hidden" name="DESCRIPTION" value="Sakai -Vancover Conference registration">
          <input type="submit" name="submit" value="pay by credit card >>" >
        </td>
      </tr>
    </table>
  </form>
</div>
<!-- end cfp -->
<?php } // end check paid ?>

<?php include '../include/outer_right.php'; // Include right column ?>

<?php require '../include/footer.php'; ?>