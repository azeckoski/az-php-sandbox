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
//$EXTRA_MESSAGE = "<br/><span style='font-size:8pt;'>Technical problems? Please contact <a href='mailto:$HELP_EMAIL'>$HELP_EMAIL</a></span><br/>";
?>

<?php require $ACCOUNTS_PATH.'include/top_header.php'; ?>
<style type="text/css">

#activity{
color:#000;
}
#activity td{
padding: 0px 5px;
color:#000;
}
</style>
<script type="text/javascript">
<!--
// -->
</script>
<?php require 'include/header.php'; ?>

<div style="text-align:left;">

<a style="font-size:11pt;" href="proposals/">Propose a session for the conference</a> -
	Click here to enter a proposal for the upcoming Sakai conference<br/><br/>
<span style="font-size:11pt;" href="registration/">Register for the conference</span> - 
Registration will open in early September<br/><br/>
<!-- 	<a style="font-size:12pt;" href="registration/">Register for the conference</a> - 
	Click here to register for the upcoming Sakai conference<br/>
	-->
	<span style="font-size:11pt;" href="volunteer.php">Volunteer to help at the conference</span> -
	Click here to volunteer to be a convener or recorder for the upcoming Sakai conference<br/>
<!-- <a style="font-size:12pt;" href="volunteer.php">Volunteer to help at the conference</a> -
	Click here to volunteer to be a convener or recorder for the upcoming Sakai conference<br/>
-->
</div>
<div class="padding"><br/><br/></div>
<?php require 'include/footer.php'; // Include the FOOTER ?>