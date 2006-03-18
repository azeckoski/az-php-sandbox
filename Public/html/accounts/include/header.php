</head>
<body>
<table class="main" border="0">
<tr>
	<td width="120" style="border: 1px solid #ccc;">
		<a href="http://www.sakaiproject.org"><img src="<?= $ACCOUNTS_URL ?>/include/images/logoslate160x89.jpg" height="59" width="110" border="0" alt="Sakai Logo" /></a>
	</td>
	<td width="100%" valign=top style="background:#ECECEC;border: 1px solid #ccc;">
	<table width="100%" border="0">
	<tr>
	<td width="90%" valign="top">
	  	<span style="font-size:1.3em;font-weight:bold;"><?= $SYSTEM_NAME ?> <?= $TOOL_NAME ?></span>
<?php if (isset($PAGE_NAME)) { ?>
	  	<span style="font-size:1.1em;font-weight:bold;"> - <?= $PAGE_NAME ?></span>
<?php } ?>
	<br/>
	<a style="font-size:.8em;" href="<?= $ACCOUNTS_URL ?>/index.php">Main Page</a> -
	<a style="font-size:.8em;" href="<?= $ACCOUNTS_URL ?>/createaccount.php">Create Account</a> -
	<a style="font-size:.8em;" href="<?= $ACCOUNTS_URL ?>/<?= $LOGIN_PAGE ?>">Login</a> -
  	<a style="font-size:.8em;" href="<?= $ACCOUNTS_URL ?>/<?= $ACCOUNTS_PAGE ?>">My Account</a> -
	<a style="font-size:.8em;" href="<?= $ACCOUNTS_URL ?>/forgot_password.php">Forgot Password</a>
  	<?= $EXTRA_LINKS ?>
	</td>
	<td width="10%" align="right" valign="top">
<?php if ($USER_PK > 0) { ?>
	<span style="font-size:.9em;">
  	Welcome,&nbsp;<?= $USER["firstname"] ?>&nbsp;<?= $USER["lastname"] ?>
  	</span><br/>
  	<a style="font-size:.8em;" href="<?= $ACCOUNTS_URL ?>/<?= $ACCOUNTS_PAGE ?>">My Account</a><br/>
 <?php if ($USER["admin_accounts"] || $USER["admin_insts"]) { ?>
  	<a style="font-size:.8em;" href="<?= $ACCOUNTS_URL ?>/admin/admin.php">Tool Admin</a> - 
<?php } ?>
  	<a style="font-size:.8em;" href="<?= $ACCOUNTS_URL ?>/<?= $LOGOUT_PAGE ?>">Logout</a><br/>
<?php } else { ?>
  	<a style="font-size:.8em;" href="<?= $ACCOUNTS_URL ?>/<?= $LOGIN_PAGE."?ref=".$_SERVER['PHP_SELF'] ?>">Login</a>
<?php } ?>
	</td>
	</tr>
	</table>
  </td>
</tr>
</table>