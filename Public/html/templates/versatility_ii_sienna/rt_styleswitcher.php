<?php
$domain = $_SERVER['SERVER_NAME'];

if (isset($_GET['widthstyle'])) {
	 $width = $_GET['widthstyle'];
	$_SESSION['v-widthstyle'] = $width;
	setcookie ('v-widthstyle', $width, time()+31536000, '/', false);
}
if (isset($_GET['fontstyle'])) {
	$font = $_GET['fontstyle'];
	$_SESSION['v-fontstyle'] = $font;
	setcookie ('v-fontstyle', $font, time()+31536000, '/', false);
}

header("Location: " . $_SERVER['HTTP_REFERER']);
?>
