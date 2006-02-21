<?php 

function imageResize($image, $target, $alt=NULL) {

//Gets the width and height of the image and outputs it as $theimage (width) and $theimage (height)
$theimage = getimagesize($image);
$width = $theimage[0];
$height = $theimage[1];

//takes the larger size of the width and height and applies the formula accordingly...this is so this script will work dynamically with any size image

if ($width > $height) {
$percentage = ($target / $width);
} else {
$percentage = ($target / $height);
}

//gets the new value and applies the percentage, then rounds the value
$width = round($width * $percentage);
$height = round($height * $percentage);

//Returns the new sizes inside an image tag so you can call it with 


echo "<img src=\"$image\" width=\"$width\" height=\"$height\" alt=\"$alt\">";
}?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sakai SEPP Conference Facebook</title>
<style>
body {
background: #000;
color: #fff;
font-family: Arial;
font-size: 10px;
font-weight: normal;
color: #fff;

}
#photos {
width: 100%;
padding:5px;
align: center;

}

#frame{
float: left;
width: 130px;
height: 160px;
background: #000;
padding: 2px;
text-align: center;


}



#frame img {align: center;
padding: 1px;
border: 1px solid #eee;
vertical-align: bottom;

}
#label {

height: 20px;

}
</style>
</head>

<body>




<?php 

 //error reporting
      error_reporting(0);
	  
      // initialize a variable to 
	  
      //hold any errors we encounter
      $errors = "";
      // test to see if the form was actually 
      // check to see if requiired fields were entered
	  
	  

      if (!$_POST['First'])
         $errors .= "<li>First Name<br></li>";
		 
      if (!$_POST['Last'])
         $errors .= "<li>Last Name<br></li>";
		 
      if (!$_POST['email'])
         $errors .= "<li>Email<br></li>";
		 
      if (!$_POST['Institution'])
         $errors .= "<li>Institution<br></li>";
         
 
 // if there are any errors, display them
      if ($errors) {
		  echo "<hr><h3 class=required>Upload Incomplete</h3>
			<p><strong> Please use your browser's Back button to provide the following information: </strong></p>
			<blockquote><ul>";
			
		  echo $errors;
		  echo "</ul></blockquote><br><br>";
		 } 
else {


$dbhost = "bengali.web.itd.umich.edu";

$dbname = "sakai_stage";

$dbuser = "sakai";
$dbpass = "mujoIII"; 


$db = mysql_connect("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname",$db);


$myemail=$_POST['email'];
		
		$sql="SELECT email FROM seppConf where confID='June05'";
		$result= mysql_query($sql);
		$resultsnumber=mysql_numrows($result);

		while($links=mysql_fetch_array($result))
		{
		$id=$links["id"]; 
		$emailadd=$links["email"];
		$first=$links["First"];
		if ($emailadd == $myemail) 
		$found="TRUE";
		}
		
			if (!$found) //no previous entry
	{ echo "I'm sorry, but you do not appear to be registered for the SEPP Conference<br><br>";
	}
	
	else 	if ($found) //they have registered
	{ 
	
	
$uploadDir = '/afs/umich.edu/group/itd/sakaitst/Public/html/images/stories/facebook/';
$uploadFile = $uploadDir . $_FILES['userfile']['name'];
$filename= '../images/stories/facebook/' . $_FILES['userfile']['name'];


// get client side file name 

 if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile))       {
   

$fileNameParts = explode(".", $uploadFile); 

$fileExtension = end($fileNameParts); 
// part behind last dot 


if ($fileExtension != "jpg" && $fileExtension != "JPEG" && $fileExtension != "JPG" && $fileExtension != "gif" && $fileExtension != "GIF" && $fileExtension != "PNG" && $fileExtension != "png") 
{  die ("Error:  Image format must be one of :  jpg, gif, or png"); 
} 


$photoSize = $_FILES['userfile']['size']; 
// size of uploaded file 


if ($photoSize == 0) {
die ("Sorry. The upload of $photoFileName has failed. Search a photo smaller than 100K, using the button."); 

} 


if ($photoSize > 102400) { 
die ("Sorry. The file $photoFileName is larger than 100K. Advice: reduce the photo using a drawing tool."); 
} 
// read photo 

else {

$register="INSERT INTO facebook values ('',
		'$_POST[First]', 
		'$_POST[Last]',
		'$_POST[Institution]',
		'$_POST[email]',
		'$filename')";
		
		$result = mysql_query($register) or die(mysql_error("There was a problem with the registration form submission.
		Please try to submit the registration again. 
		 If you continue to have prolems, please report the problem to the 
		 <a href=\"mailto:shardin@umich.edu\">sakaiproject.org webmaster</a>."));



		$sql="SELECT * FROM facebook ORDER by Last";
		

			$result= mysql_query($sql);
		$resultsnumber=mysql_numrows($result);

echo "<div id=photos><p align=center><strong>SEPP Conference Facebook</strong><br />
Baltimore, MD - June 8-10, 2005</p>";



		while($links=mysql_fetch_array($result))
		{
		$id=$links["id"]; 
		$first=$links["First"]; 
		$last=$links["Last"]; 
		$institution=$links["Institution"]; 
		$emailadd=$links["email"];
		$filename=$links["pict"];
		


echo "<div id=frame>";

imageResize($filename, "120", "");
echo "<div id=label> <br />$first $last<br />$institution<br /><br /></div></div>";


		}
		echo "</div>";
		
		
}
}
}
}

?>

</body>
</html>