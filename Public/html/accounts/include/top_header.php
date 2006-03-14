<?php
/*
 * Created on March 8, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * This is the basic html header that goes above every page
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?= $TOOL_NAME ?> - <?= $PAGE_NAME ?></title>
<?php if ($CSS_FILE) { ?>
<link href="<?= $CSS_FILE ?>" rel="stylesheet" type="text/css">
<?php } ?>
<?php if ($CSS_FILE2) { ?>
<link href="<?= $CSS_FILE2 ?>" rel="stylesheet" type="text/css">
<?php } ?>
<?php if ($CSS_FILE3) { ?>
<link href="<?= $CSS_FILE3 ?>" rel="stylesheet" type="text/css">
<?php } ?>
<?php if ($CSS_FILE4) { ?>
<link href="<?= $CSS_FILE4 ?>" rel="stylesheet" type="text/css">
<?php } ?>
