<?php 


	// Check to make sure they entered a title
	if ($_POST['p_title']) {
				$title = TRUE;
	} else {
			$title = FALSE;
			$message[] = "<li>presentation title</li>";
	}
	

	// Check to make sure they entered an abstract
	if ($_POST['p_abstract']) {
				$abstract = TRUE;
	} else {
			$abstract = FALSE;
			$message[] = "<li>presentation abstract</li>";
	}

	
	
		//get topic results
for ($i = 0; $i <= 11; $i++) {
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
/*Check to make sure they entered an audience
	if ( (isset($_POST['audience_0'])) || (isset($_POST['audience_1'])) || (isset($_POST['audience_3'])) 
	|| (isset($_POST['audience_4'])) || (isset($_POST['audience_5'])) ||  (isset($_POST['audience_6']))
	|| (isset($_POST['audience_7'])) ||
	(isset($_POST['audience_8']))  || (isset($_POST['audience_9'])) || (isset($_POST['audience_10'])) ){
				$audience = TRUE;
	} else {
			$audience = FALSE;
			$message[] = "<li>presentation audience</li>";
	}
	
	*/

	
	
	// Check to make sure they entered an description  
	if ($_POST['p_desc']) {
				$desc = TRUE;
	} else {
			$desc = FALSE;
			$message[] = "<li>presentation description</li>";
	}
	
	
// Check to make sure they entered a speaker 
	if ($_POST['p_speaker']) {
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
	if (isset($_POST['p_track'])) {
	
	
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
	if (isset($_POST['p_format'])) {
				$format = TRUE;
	} else {
			$format = FALSE;
			$message[] = "<li>presentation format</li>";
	}
	
	
	
	
	//get topic results
for ($i = 0; $i <= 27; $i++) {
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

if ( $topics AND $format AND $audience AND $title AND $abstract AND $desc AND $speaker AND $bio AND $length AND $layout){
$validated=TRUE;  
}
else {
$validated=False;
}



?>