<?php 

	
if ($_POST['title']){
	$title = TRUE;
	} else {
			$title = FALSE;
			$message[] = "<li>Your Role/Title</li>";
	}		 		 
		 		 
  if ($_POST['institution']){
    
	$inst = TRUE;
	} else {  if ($_POST['otherInst']){
	$inst=TRUE;
	}
	else { 
	$inst = FALSE;
			$message[] = "<li>Organization</li>";
	}		 
	}
     if ($_POST['address1']){
	$add = TRUE;
	} else {
			$add = FALSE;
			$message[] = "<li>Address 1</li>";
	}		 
	
      if ($_POST['city']){
	$city = TRUE;
	} else {
			$city = FALSE;
			$message[] = "<li>Town/City</li>";
	}	
	

  
 
 
  if ($_POST['state']){
  
     	$state=TRUE;

    if ($_POST['state']=='Other'){
   if ($_POST['otherState']){
	$state=TRUE;
	$_POST['state']=$_POST['otherState'];
	}
	else { 
	$state = FALSE;
			$message[] = "<li>State</li>";
	}
	}
	}
	else { 
	$state = FALSE;
			$message[] = "<li>State</li>";
	}	
	
	
	 
	
	if ($_POST['zip']){
	$zip = TRUE;
	} else {
			$zip = FALSE;
			$message[] = "<li>Zip/Postal Code</li>";
	}		 
      if ($_POST['country']){
	$country = TRUE;
	} else {
			$country = FALSE;
			$message[] = "<li>Country</li>";
	}		 
	
      if ($_POST['phone']){
	$phone = TRUE;
	} else {
			$phone = FALSE;
			$message[] = "<li>Phone</li>";
	}
	
	    if ($_POST['shirt']){
	$shirt = TRUE;
	} else {
			$shirt = FALSE;
			$message[] = "<li>T-Shirt size</li>";
	}
	
	    if ($_POST['jasig']){
	$jasig = TRUE;
	} else {
			$jasig = FALSE;
			$message[] = "<li>JA-SIG conference attendance</li>";
	}
    if ($_POST['hotelInfo']){
	$hotelInfo = TRUE;
	} else {
			$hotelInfo = FALSE;
			$message[] = "<li>Hotel Information</li>";
	}
	    if ($_POST['contactInfo']){
	$contactInfo = TRUE;
	} else {
			$contactInfo = FALSE;
			$message[] = "<li>Attendee List </li>";
	}
	
		  

	
?>