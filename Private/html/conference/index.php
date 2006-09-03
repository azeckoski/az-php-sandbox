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
<?php include 'include/conference_LeftCol.php'?>

<div style="text-align:left;">

<span style="font-size:11pt;"><a href="proposals/">Propose a session</a></span>  for the Atlanta conference
	<br/><br/>
<span style="font-size:11pt;">
<a style="font-size:11pt;" href="registration/">Register</a> </span>for the Atlanta conference
	<br/>
<span style="font-size:11pt;"><a href="logos/">Submit a Logo or theme</a></span>  for the Atlanta logo contest
	<br/><br/>
	
	
	<!-- <span style="font-size:11pt;">Volunteer to help at the conference</span> -
	Click here to volunteer to be a convener or recorder for the upcoming Sakai conference<br/>
    -->
<!-- <a style="font-size:12pt;" href="volunteer.php">Volunteer to help at the conference</a> -
	Click here to volunteer to be a convener or recorder for the upcoming Sakai conference<br/>
-->
</div>
<div style="height:60px;"><br/><br/></div>
<?php require 'include/footer.php'; // Include the FOOTER ?>