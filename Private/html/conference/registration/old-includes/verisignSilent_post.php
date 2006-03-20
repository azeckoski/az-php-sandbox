<?php
// Gather Silent Post data with this PHP script.
if ($_POST) {
	echo "completed post";
	// Print out post contents
	// $last4cc=$_POST['USER2'];
    $user_id=$_POST['USER1'];
	$registrant=$_POST['USER2'];
	$co_registrant=$_POST['USER3'];
	$transID=$_POST['PNREF'];
	$transAmount=$_POST['AMOUNT'];
	$ResultCode=$_POST['RESULT'];
	$ResponseMsg=$_POST['RESPMSG'];
	$CSCMATCH=$_POST['CSCMATCH'];
	$AVSDATA=$_POST['AVSDATA'];
    
	// Loop through post array
	//  foreach ($_POST as $key => $value) {
	//echo "Variable: $key; Value: $value\n\r\r<br />";
//  }
  
//set variables for updating the registration data

	// TODO - What was this supposed to do?
	if ($ResultCode > 0 || !$USER_PK){
		//include('index.php');  //error received so 
		// kick them back to the payment if this fails, probably not a good way to handle it
		$PAYMENT_MSG = "?msg=".urlencode("Failure during payment processing");
		header('location:'.$TOOL_PATH.'/registration'.$PAYMENT_MSG);
		exit;
	}

	//if ($ResponseMsg='CSCDECLINED'){
	//include('index.php');
	//}
	//if ($ResponseMsg='AVSDECLINED'){
	//include('index.php');
	//}

	if ($ResultCode== 0) {
		// sql should be loaded already
		
		//no errors so update the conf table and activate this registration
		$sql = "UPDATE conferences SET date_modified = NOW(), " .
			"fee='$transAmount', transID = '$transID', activated='1' " .
			"WHERE users_pk='$USER_PK' and confID='$CONF_ID'"; 
		$result = mysql_query($sql); 
	}
}
?>