<?php  
session_start();
require_once '../include/tool_vars.php';

$PAGE_NAME = "Conference";
$Message = "";

// connect to database
require '../sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

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
<script>
<!--
// -->
</script>
<?php include '../include/header.php'; // INCLUDE THE HEADER ?>

<?php

$today = date("F j, Y"); 


/*******************************/
//billing information
/*******************************/
if ($_SESSION['memberType']=="2"){
//non member must pay

if($_SESSION['jasig']=='Y'){

   $amount='345.00';
    }
    else {
    
    $amount='395.00';
    }
    
   
  $_SESSION['fee']=$amount;
  
  }
//echo $_SESSION['user_id']; 

$user_id=$_SESSION['user_id'];
?>
<table width="100%" class="blog" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><div class="componentheading">Sakai Conference Registration</div></td>
  </tr>
</table>
<!-- start of the form td -->
<div id=cfp> <br />
  <!-- start form section -->
  <form id=form1 method="POST" action="https://payments.verisign.com/payflowlink">
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

 
  
			echo"<tr><td valign=top><div align=\"right\"><strong>Registrant's Information: </strong></div></td>
			<td>$_SESSION[firstname] $_SESSION[lastname]<br /> $_SESSION[email1]
			<br /><br />$_SESSION[otherInst]<br />$_SESSION[address1]<br />";
		
			
			echo"$_SESSION[city], $_SESSION[state], $_SESSION[zip]<br/>
					$_SESSION[country] <br /><br />phone: $_SESSION[phone]<br />fax: $_SESSION[fax]</td>
					</tr>";
		
		 echo"<tr><td valign=top><div align=\"right\"><strong><span>Registration Fee</span>: &nbsp;&nbsp;&nbsp;</strong> </div></strong> </div></td>
			 <td width=300p>$ $_SESSION[fee]</td></tr>";
		
            $registrant=$_SESSION['firstname'] ." " . $_SESSION['lastname'];    
            $co_registrant=$_SESSION['co_firstname'] ." " . $_SESSION['co_lastname'];
        ?>
      <tr>
        <td>&nbsp;</td>
        <td><br />
          <input type="hidden" name="USER1" value="<?php echo $user_id ?>">
          <input type="hidden" name="USER2" value="<?php echo $registrant ?>">
          <input type="hidden" name="USER3" value="<?php echo $co_registrant ?>">
          <!--  <input type="hidden" name="ORDERFORM" value="TRUE" >
<input type="hidden" name="ECHODATA" value="TRUE" >
<input type="hidden" name="EMAILCUSTOMER" value="FALSE" >
<input type="hidden" name="SHOWCONFIRM" value="TRUE" >
-->
          <!-- cardnum for testing -->
          <input type="hidden" name="CARDNUM" value="4111111111111111" >
          <!--  exp date for testing -->
          <!-- cardnum for testing -->
          <input type="hidden" name="EXPDATE" value="0806" >
          <!--  exp date for testing -->
          <input type="hidden" name="METHOD" value="CC" >
          <input type="hidden" name="TYPE" value="S">
          <input type="hidden" name="LOGIN" value="sakaiproject">
          <input type="hidden" name="PARTNER" value="verisign">
          <?php  // $amount='1.00';
?>
          <input type="hidden" name="AMOUNT" value="<?php echo $amount;?>">
          <input type="hidden" name="DESCRIPTION" value="Sakai -Vancover Conference registration">
          <input type="submit" name="submit" value="pay by credit card >>" >
        </td>
      </tr>
    </table>
  </form>
</div>
<!-- end cfp -->

<?php  require_once('../include/footer.php'); 
?>