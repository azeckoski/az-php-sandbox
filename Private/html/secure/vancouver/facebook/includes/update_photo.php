<?php // check file extension$fileNameParts = explode(".", $_FILES['userfile']['name']); $fileExtension = end($fileNameParts); // part behind last dot  if (($fileExtension == 'jpg') ||  ($fileExtension == 'JPEG')  ||($fileExtension == 'jpeg')  || ($fileExtension == 'JPG') || ($fileExtension == 'gif')   || ($fileExtension == 'GIF') ||  ($fileExtension == 'PNG') || ($fileExtension == 'png')) { $validExtension=TRUE;}If ($validExtension) {$validImage=TRUE;} else {$validImage=FALSE;$message[]="<li><strong>Upload Incomplete</strong><br />Error -  Image format must be jpg, gif, png, or bmp</li>"; }if ($validImage) {//complete upload and add to database$unique = date('Hms');//set location of file upload$uploadDir = '/afs/umich.edu/group/acadaff/sakai/Public/html/images/stories/facebook_vancouver/';$uploadFile = $uploadDir . $unique . ($_FILES['userfile']['name']);// get client side file name $filename= 'http://sakaiproject.org/images/stories/facebook_vancouver/' . $unique . $_FILES['userfile']['name'];// userfile_error was introduced at PHP 4.2.0// use this code with newer versions$userfile_error = $_FILES['userfile']['error'];if ($userfile_error > 0) {$message[]= "<p><strong>Upload Incomplete</strong></p>";switch ($userfile_error) { case 1:$message[]= "<li>File exceeded upload_max_filesize</li>";break;case 2:$message[]=  "<li>File exceeded max_file_size</li>";break;case 3:$message[]=  "<li>File only partially uploaded</li>";break;case 4:$message[]=  "<li>No file uploaded</li>";break;case 6:$message[]=  "<li>Missing a temporary folder</li>";break;case 7:$message[]=  "<li>Failed to write file to disk.</li>";break;}}if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {      if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile))       {   require "includes/mysqlconnect.php";$newPhoto=$filename;   //new entry  $register=" UPDATE `facebook_vancouver` SET   `pict` = '$newPhoto'          WHERE `id` = $user_id LIMIT 1" ;		    	$result = mysql_query($register);		  		 if ($result==1) {//successful database entry$success=TRUE;}else { $success=FALSE;}	//echo $user_id;header("Location:view_entry.php?id=$user_id&logged=1");}}else {$message[]="<li>There was a problem uploading the image, please try again</li>";}}            				?>  