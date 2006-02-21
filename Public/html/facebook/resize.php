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


echo "<a href=\"$image\"><img src=\"$image\" width=\"$width\" height=\"$height\" alt=\"$alt\"></a>";
}

?>