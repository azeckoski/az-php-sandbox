<?php 

	// Check to make sure they entered a demo description. 
	if ($_POST['demo_desc']) {
	
	
			$desc = TRUE;
	} else {
			$desc = FALSE;
			$message[] = "<li>Demo Description</li>";
	}
	
	// Check to make sure they entered a demo tool name. 
	if ($_POST['product']) {
	
	
			$product = TRUE;
	} else {
			$product = FALSE;
			$message[] = "<li>Tool or Product Name</li>";
	}
	
	
	// Check to make sure they entered a speaker name
	if ($_POST['Dspeaker']) {
				$speaker = TRUE;
	} else {
			$speaker = FALSE;
			$message[] = "<li>Demo Presenter</li>";
	}
	
?>