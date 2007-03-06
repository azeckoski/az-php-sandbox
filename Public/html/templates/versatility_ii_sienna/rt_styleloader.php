<?php
$fontstyle = "f-default";
$widthstyle = "w-" . $default_width;

//load font style
if (isset($_SESSION['v-fontstyle'])) {
	$fontstyle = $_SESSION['v-fontstyle'];
} elseif (isset($_COOKIE['v-fontstyle'])) {
	$fontstyle = $_COOKIE['v-fontstyle'];
}

//load width style
if (isset($_SESSION['v-widthstyle'])) {
	$widthstyle = $_SESSION['v-widthstyle'];
} elseif (isset($_COOKIE['v-widthstyle'])) {
	$widthstyle = $_COOKIE['v-widthstyle'];
}


?>
