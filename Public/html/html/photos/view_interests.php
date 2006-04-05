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
<link rel="stylesheet" href="facebook.css"/>

</head>

<body>




<?php 

require "facebook_db.php";


		$sql="SELECT * FROM facebook ORDER  by interests";
		

			$result= mysql_query($sql);
		$resultsnumber=mysql_numrows($result);



echo "<div id=photos><div id=header><h1>SEPP Conference Facebook</h1>
<p>Baltimore, MD - June 8-10, 2005</p></div><br />
<p><strong>Display photos by:</strong> <a href=view_recent.php>by Recent Entry</a>  --  
<a href=view_lastname.php> Last Name</a>  --  
<a href=view_institution.php> Institution</a>  --  <br /><br /><a href=printPhotos.php>Print Gallery of Large Images</a></p>
<a href=facebook.php>SUBMIT Photo</a><br /><br /></p>";

while($links=mysql_fetch_array($result))
		{
		$id=$links["id"]; 
		$first=$links["First"]; 
		$last=$links["Last"]; 
		$institution=$links["Institution"]; 
		$emailadd=$links["email"];
		$filename=$links["pict"];
		$interests=$links["interests"];
		


echo "<div id=frame>";

imageResize($filename, "120", "");
echo "<div id=label> <br />$first $last<br />$institution<br /><br />$interests<br /></div></div>";


		}
		echo "</div>";
		
		




?>

</body>
</html>