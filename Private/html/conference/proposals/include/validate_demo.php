<?php 

	// Check to make sure they entered a demo description. 
	if ($_POST['abstract']) {
	
	
			$abstract = TRUE;
	} else {
			$abstract = FALSE;
			$message[] = "<li>Demo Description</li>";
	}
	
	// Check to make sure they entered a demo tool name. 
	if ($_POST['title']) {
	
	
			$title = TRUE;
	} else {
			$title = FALSE;
			$message[] = "<li>Tool or Product Name</li>";
	}
	
	
	// Check to make sure they entered a speaker name
	if ($_POST['speaker']) {
				$speaker = TRUE;
	} else {
			$speaker = FALSE;
			$message[] = "<li>Demo Presenter</li>";
	}
	
	if ($abstract AND $speaker AND $title)  {
$validated=TRUE;
} else {
$validated=FALSE;

}
	
?>