<?php 

	
if ($_POST['title']){
	$title = TRUE;
	} else {
			$title = FALSE;
			$message[] = "<li>Title</li>";
	}		 		
	
	
		 		 
  if ((isset($_POST['institution'])) || (isset($_POST['otherInst'])) ) {
    
	$inst = TRUE;
	} else {
	$inst = FALSE;
			$message[] = "<li>Organization</li>";
	
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
    
	$state = TRUE;
	} else {  if ($_POST['otherState']){
	$state=TRUE;
	}
	else { 
	$state = FALSE;
			$message[] = "<li>State</li>";
	}	
	
	}    if ($_POST['zip']){
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
	
	
	if($title AND $inst AND $add AND $city AND $state AND $zip AND $country AND $phone){
$validated=TRUE;
} else {
$validated=False;
}
	
?>