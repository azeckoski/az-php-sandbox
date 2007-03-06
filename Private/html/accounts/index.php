<?php
/*
 * Created on March 8, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * This is the main page for the accounts system
 */
?>
<?php
require_once 'include/tool_vars.php';

// Introduction or main page
$PAGE_NAME = "Main";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';
?>

<?php include 'include/top_header.php'; ?>
<script type="text/javascript">
<!--
// -->
</script>
<?php include 'include/header.php'; ?>

<table border=0 cellpadding=0 cellspacing=3 width="100%">
<tr>
<td valign="top" width="80%">

<div class="info">
<?php if($User->pk) { ?>
You may access the following tools:<br/>
<?php } else { ?>
This page allows you to create an account to access the following tools:<br/>
<?php } ?>
<a href="/conference/registration/">Conference Registration</a><br/>
<!-- <a href="/conference/admin/schedule.php">Conference Schedule</a><br/> -->
<a href="/conference/volunteer.php">Conference Volunteering</a><br/>
<a href="/facebook/">Facebook</a><br/>
<a href="/requirements/">Requirements Polling</a><br/>
<!-- no skin voting this time
<a href="/skin/">Default Skin Submission and Voting</a><br/>
-->
<br/>
<?php if($User->pk) { ?>
You can <a href="<?= $ACCOUNTS_PAGE ?>">manage your account settings</a> and change your password if you would like.<br/>
<br/>
<?php } else { ?>
You should <a href="createaccount.php">create an account</a> first if you do not have one.<br/>
<br/>
You can <a href="<?= $LOGIN_PAGE ?>">login</a> if you already have an account.<br/>
<br/>
You can even <a href="forgot_password.php">reset your password</a> if you forgot it.<br/>
<br/>
<?php } ?>

</div>
</td>
<td valign="top" width="20%">
	<div class="right">
	<div class="rightheader"><?= $TOOL_NAME ?> information</div>
	<div class="padded">

<?php
$user_count = $User->getUsersBySearch("*","","pk",true);
$Inst = new Institution();
$inst_count = $Inst->getInstsBySearch("*","","pk",true);
?>

	<span style="font-weight:bold;text-decoration:underline;">Statistics:</span><br/>
	<b>Accounts:</b> <?= $user_count['db'] ?><br/>
<?php if ($USE_LDAP) { ?>
	&nbsp;&nbsp;- LDAP: <?= $user_count['ldap'] ?><br/>
<?php } ?>
	<b>Institutions:</b> <?= $inst_count['db'] ?><br/>
<?php if ($USE_LDAP) { ?>
	&nbsp;&nbsp;- LDAP: <?= $inst_count['ldap'] ?><br/>
<?php } ?>
	<br/>

	</div>
	</div>
</td>
</tr>
</table>

<div class="help">
	<b>Help:</b>
	<a class="pwhelp" href="createaccount.php">I need to create an account</a> -
	<a class="pwhelp" href="login.php">I need to login</a> -
	<a class="pwhelp" href="forgot_password.php">I forgot my password</a>
</div>

<?php include 'include/footer.php'; // Include the FOOTER ?>
