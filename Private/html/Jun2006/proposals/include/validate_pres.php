<?php 


	// Check to make sure they entered a title
	if ($_POST['title']) {
				$title = TRUE;
	} else {
			$title = FALSE;
			$message[] = "<li>presentation title</li>";
	}
	

	// Check to make sure they entered an abstract
	if ($_POST['abstract']) {
				$abstract = TRUE;
	} else {
			$abstract = FALSE;
			$message[] = "<li>presentation abstract</li>";
	}

	
	
		//get audience results
for ($i = 1; $i <= 12; $i++) {
	$audience="audience_" .$i;
	if ($_POST[$audience] > 0){
			$audience_complete[] =TRUE;
			
			}
			else {
		    $audience_empty[] = TRUE;

			
			}
	}
			if ($audience_complete){
			//at least one topic area ranked
			$audience=TRUE;
			}
			else {
			$audience=FALSE;
			$message[]="<li>Select audience</li>";

			}

	
	
	// Check to make sure they entered an description  
	if ($_POST['desc']) {
				$desc = TRUE;
	} else {
			$desc = FALSE;
			$message[] = "<li>presentation description</li>";
	}
	
	
// Check to make sure they entered a speaker 
	if ($_POST['speaker']) {
				$speaker = TRUE;
	} else {
			$speaker = FALSE;
			$message[] = "<li>presentation speaker</li>";
	}
// Check to make sure they entered a brief bio - even if they have a personal URL . 
	if ($_POST['bio']){
				$bio = TRUE;
	} else {
			$bio = FALSE;
			$message[] = "<li>a brief text bio</li>";
	}

	/* Check to make sure they entered a presentation track - used for Austin conference. 
	if (isset($_POST['track'])) {
	
	
			$track = TRUE;
	} else {
			$track = FALSE;
		//	$message[] = "<li>presentation track</li>";
	}
	
	*/
	
	if (isset($_POST['length'])) {
	
	
			$length = TRUE;
	} else {
			$length = FALSE;
			$message[] = "<li>presentation length</li>";
	}
	
	
			if (isset($_POST['layout'])) {
	
	
			$layout = TRUE;
	} else {
			$layout = FALSE;
			$message[] = "<li>presentation layout</li>";
	}

	// Check to make sure they entered a presentation format
	if (isset($_POST['type'])) {
				$type = TRUE;
	} else {
			$type = FALSE;
			$message[] = "<li>presentation format</li>";
	}
	
	
	
	
	//get topic results
for ($i = 1; $i <= 28; $i++) {
	$topic="topic_" .$i;
	if ($_POST[$topic] >=1){
			$topic_complete[] =TRUE;
			
			}
			else {
		    $topic_empty[] = TRUE;

			
			}
	}
			if ($topic_complete){
			//at least one topic area ranked
			$topics=TRUE;
			}
			else {
			$topics=FALSE;
			$message[]="<li>Rank at least one Topic Area item</li>";

			}
			

	
	
	//$track=TRUE;

if ( $topics AND $type AND $audience AND $title AND $abstract AND $desc AND $speaker AND $bio AND $length AND $layout){
$validated=TRUE;  
}
else {
$validated=False;
}



?>