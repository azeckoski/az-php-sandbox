<?php
/*
 * Created on March 13, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Conference";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// add in the help link
//$EXTRA_LINKS = " - <a style='font-size:9pt;' href='$HELP_LINK' target='_HELP'>Help</a><br/>";
$EXTRA_MESSAGE = "Technical problems? Please contact <a href='mailto:$HELP_EMAIL'>$HELP_EMAIL</a>";
?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<style type="text/css">
#activity{
color:#000;
}
#activity td{
padding: 0px 5px;
color:#000;
}
</style>
<script>
<!--
// -->
</script>
<?php include 'include/header.php'; // INCLUDE THE HEADER ?>

<div style="text-align:left;">
From here you can:<br/>
<a style="font-size:12pt;" href="registration/">Register for the conference</a> - 
	Click here to register for the upcoming Sakai conference<br/>
<a style="font-size:12pt;" href="proposals/">Propose a session for the conference</a> -
	Click here to enter a proposal for the upcoming Sakai conference<br/>
</div>

<?php include 'include/footer.php'; // Include the FOOTER ?>