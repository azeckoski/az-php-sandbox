<?php
/*
 * Created on Mar 15, 2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
// get institution information
$inst_sql = "select * from institution where pk='".$USER['institution_pk']."'";
$result = mysql_query($inst_sql) or die('Institution fetch query failed: ' . mysql_error());
$INST = mysql_fetch_assoc($result); // first result is all we care about
$isPartner = false;  // this means the user is in a partner inst
if ($INST['pk'] != 1 && $INST['type'] != "non-member") { $isPartner = true; }

// get the current info out if it exists for this user
$conf_sql = "select * from conferences where users_pk='$USER_PK' and confID='$CONF_ID'";
$result = mysql_query($conf_sql) or die('Conf fetch query failed: ' . mysql_error());
$CONF = mysql_fetch_assoc($result); // first result is all we care about
$isRegistered = false;  // this means the user is already registered for the current conference
if ($CONF) {
	$isRegistered = true;
	$transID = $CONF['transID'];
	$Message = "<span style='color:red;'>You have already filled out a registration for this conference.</span>";
	if (!$isPartner) {
	    if ($transID) { //non-member payment transaction received from Verisign
    		$Message  .="<span style='color:red;'><br />Your payment confirmation number is: $transID </span>";
   	} else {
    		$Message  .="<span style='color:red;'><br />You have not paid yet. Please go to the <a href='payment.php'>Payment page</a></span>";
    	}
}
}
?>