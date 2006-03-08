<?php
/*
 * Created on March 8, 2006 by @author aaronz
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 * This is the main page for the accounts system
 */
?>
<?php
	require_once ("tool_vars.php");

	// Introduction or main page
	$PAGE_NAME = "Main";

	// connect to database
	require "mysqlconnect.php";

	// check authentication
	require "check_authentic.php";
?>

<? include 'top_header.php'; // INCLUDE THE HTML HEAD ?>
<script>
<!--
// -->
</script>
<? include 'header.php'; // INCLUDE THE HEADER ?>

<table border=0 cellpadding=0 cellspacing=3 width="100%">
<tr>
<td valign="top" width="80%">

<div class="info">
<?php if($USER_PK) { ?>
You may access the following tools:<br/>
<?php } else { ?>
This page allows you to create an account to access the following tools:<br/>
<?php } ?>
<a href="/requirements/">Requirements Voting</a><br/>
<br/>
<?php if($USER_PK) { ?>
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

	<span style="font-weight:bold;text-decoration:underline;">Statistics:</span><br/>
	<b>Accounts:</b> <?= get_table_rows("users") ?><br/>
	<b>Partners:</b> <?= get_table_rows("institution")-2 ?><br/>
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

<? include 'footer.php'; // Include the FOOTER ?>
