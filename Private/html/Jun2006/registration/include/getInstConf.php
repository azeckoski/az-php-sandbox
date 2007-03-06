<?php
/*
 * Created on Mar 15, 2006 by Aaron Zeckoski (aaronz@vt.edu)
 */
?>
<?php
// get institution information
$Inst = new Institution($User->institution_pk);
$isPartner = $Inst->isPartner();  // this means the user is in a partner inst
$INST = $Inst->toArray();

// get the current info out if it exists for this user
$conf_sql = "select * from conferences where users_pk='$User->pk' and confID='$CONF_ID'";
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