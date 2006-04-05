<?php 

	// Check to make sure they entered a presentation track. 
	if (isset($_POST['p_track'])) {
	
	
			$track = TRUE;
	} else {
			$track = FALSE;
			$message[] = "<li>presentation track</li>";
	}
	
	// Check to make sure they entered a presentation format
	if (isset($_POST['p_format'])) {
				$format = TRUE;
	} else {
			$format = FALSE;
			$message[] = "<li>presentation format</li>";
	}
	
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

	
// Check to make sure they entered an audience
	if ( (isset($_POST['dev'])) || (isset($_POST['faculty'])) || (isset($_POST['mgr'])) || (isset($_POST['sys_admin'])) ||  (isset($_POST['sr_admin'])) ||
	(isset($_POST['ui_dev']))  || (isset($_POST['support'])) ){
				$audience = TRUE;
	} else {
			$audience = FALSE;
			$message[] = "<li>presentation audience</li>";
	}
	
	
	if (isset($_POST['dev'])) {
	$_SESSION['dev']='1'; 

}
	
	if (isset($_POST['faculty'])) {
		$_SESSION['faculty']='1';
}
	if (isset($_POST['mgr'])) {
		$_SESSION['mgr']='1';
}
	if (isset($_POST['sys_admin'])) {
		$_SESSION['sys_admin']='1';
}
 if (isset($_POST['sr_admin'])) {
		$_SESSION['sr_admin']='1';
}
	if (isset($_POST['ui_dev'])) {
		$_SESSION['ui_dev']='1';
}
	if (isset($_POST['support'])) {
		$_SESSION['support']='1';
}
	
	
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
			$message[] = "<li> presentation speaker</li>";
	}
// Check to make sure they entered a brief bio - even if they have a personal URL . 
	if ($_POST['bio']){
				$bio = TRUE;
	} else {
			$bio = FALSE;
			$message[] = "<li>a brief text bio for the program</li>";
	}

?>