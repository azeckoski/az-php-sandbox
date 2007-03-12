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
	header('location:'.$TOOL_URL.'/registration/index.php'.$MSG);
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
<?php include 'include/registration_LeftCol.php'; //Include the registration left col  ?>
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
<div id=cfp> 

<!-- start form section -->
<form id="form1" method="post" action="https://payments.verisign.com/payflowlink">
<table width="500"  cellpadding="0" cellspacing="0" class="noline">
	<tr>
		<td valign=top colspan=3><span style="font-weight:bold; font-size:1.2em">Your Registration Details: </span></td>
	</tr>
	<tr>
		<td >&nbsp;</td><td width=120px><strong>name:</strong></td><td> <?= $User->firstname."&nbsp;".$User->lastname ?><br/> </td>
	</tr>
	<tr>
		<td >&nbsp;</td><td><strong>email: </strong></td><td> <?= $User->email ?><br/></td>
	</tr>
	<tr>
		<td >&nbsp;</td><td><strong>institution: </strong></td><td> <?= $User->institution ?><br/></td>
	</tr>
	<tr>
		<td >&nbsp;</td><td><strong>address:</strong><br/></td><td>
			<?= nl2br($User->address) ?><br/>
			<?= $User->city ." ". $User->state .", ". $User->zipcode ?><br/>
			<?= $User->country ?><br/>
			<br />
		</td>
	</tr>
	<tr>
		<td >&nbsp;</td><td><strong>phone:</strong></td><td> <?= $User->phone ?><br/></td>
	</tr>	
	<?php if ($User->fax) { ?>
	<tr>
		<td >&nbsp;</td><td><strong>fax:</strong></td><td>  <?= $User->fax ?><br/><br/></td>
	</tr>
	<?php } ?>
	<tr>
		<td >&nbsp;</td><td><strong>shirt size:</strong></td><td>  <?= $CONF['shirt'] ?><br/></td>
	</tr>
	<?php if ($CONF['jasig']) { ?><tr>
		<td >&nbsp;</td><td><strong>attending jasig:</strong></td><td>  <?= $CONF['jasig'] ?><br/></td>
	</tr>
	<?php }?>
	<tr>
		<td >&nbsp;</td><td><strong>staying at <br/>conference hotel:</strong></td><td>  <?= $CONF['confHotel'] ?><br/></td>
	</tr> 
	<tr>
		<td >&nbsp;</td><td><strong>publish name on <br/>attendee list:</strong> </td><td> <?= $CONF['publishInfo'] ?><br/></td>
	</tr>
	<?php if ($CONF['special']) { ?>
	<tr><td >&nbsp;</td><td><strong>Special needs: </strong></td><td><?=$CONF['special']?><br/></td></tr>
	<?php } ?>
		<?php if ($CONF['expectations']) { ?>
		<tr><td >&nbsp;</td><td><strong>Expectations:</strong></td><td><?=$CONF['expectations']?><br/></td></tr>
	<?php } ?>	<?php if ($CONF['attending']) { ?>
	<tr><td >&nbsp;</td><td><strong>Dates Attending: </strong></td><td> <?=$CONF['attending']?><br/></td></tr>
	<?php } ?>		
	<tr>
		<td >&nbsp;</td><td valign=top><strong>Registration Fee</strong>: </td><td> <?= $amount ?></td>
	</tr>

<?php if ($CONF['transID']) { 
	// user has already paid
?>
	<tr>
		<td >&nbsp;</td>
		<td valign=top><div align="right"><strong><span>Registration Fee</span>: &nbsp;&nbsp;&nbsp;</strong> </div>
		</td>
	 	<td width='300'><?= $amount ?></td>
	</tr>

<?php } else { 
	// user needs to pay for this conference still
?>
	<tr>
	    <td>&nbsp;</td>
	    <td><br />
			<input type="hidden" name="USER1" value="<?php echo $User->pk ?>"/>
			<input type="hidden" name="USER2" value="<?php echo $registrant ?>"/>
			<input type="hidden" name="USER3" value="<?php echo $CONF['delegate'] ?>"/>
			<input type="hidden" name="COMMENT1" value="Registrant: <?= $User->firstname." ".$User->lastname ?>, <?= $User->institution ?>, <?= $User->email ?>"/>
			<input type="hidden" name="COMMENT2" value="<?=$CONF_ID?>" />
			<!--  
			<input type="hidden" name="ORDERFORM" value="TRUE" >
			<input type="hidden" name="ECHODATA" value="TRUE" >
			<input type="hidden" name="EMAILCUSTOMER" value="FALSE" >
			<input type="hidden" name="SHOWCONFIRM" value="TRUE" >
			-->
          <!-- cardnum for testing -->
         <!-- <input type="hidden" name="CARDNUM" value="4111111111111111" > -->
          <!-- cardnum for testing -->
     <!--     <input type="hidden" name="EXPDATE" value="1008" > -->
          <!--  exp date for testing -->
          <input type="hidden" name="METHOD" value="CC" />
          <input type="hidden" name="TYPE" value="S"/>
          <input type="hidden" name="LOGIN" value="sakaiproject"/>
          <input type="hidden" name="PARTNER" value="verisign"/>
<?php //use amount below when testing live transactions
 //$amount='1.00';
?>
          <input type="hidden" name="AMOUNT" value="<?php echo $amount; ?>"/>
          <input type="hidden" name="DESCRIPTION" value="Sakai -Amsterdam Conference registration"/>
          <input type="submit" name="submit" value="pay by credit card >>" />
        </td>
      </tr>
    </table>
  </form>
</div>
<!-- end cfp -->
<?php } // end check paid ?>

<?php require '../include/footer.php'; ?>