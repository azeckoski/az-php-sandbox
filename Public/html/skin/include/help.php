<?php
/*
 * Created on Febrary 18, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?= $TOOL_NAME ?> - Help</title>
<link href="skin.css" rel="stylesheet" type="text/css">
</head>
<body>

<!-- Definition of terms -->
<div class="definitions">
<div class="defheader">General Help</div>
<div class="padded">

<UL>
<LI>Votes can be changed at any time during the voting period (see the top of the voting form for dates).
<LI>Once votes have been saved, they cannot be removed. Please make sure you are happy with your votes before saving them.
<LI>The Save button will save all vote selections.
<LI>The Reset button will only reset the vote for a single item.
</UL>

</div>
</div>
<a class="pwhelp" href="mailto:<?= $HELP_EMAIL ?>">Email contact for assistance</a><br>

<input type="button" value="Close Help Window" onClick="javascript:window.close();">

</body>
</html>