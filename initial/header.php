<table class=main border="0" >
<tr>
  <td width=120px style="border: 1px solid #ccc;">
	<a href="http://www.sakaiproject.org"><img src="http://www.sakaiproject.org/images/stories/conferenceLogos/logoslate160x89.jpg" height=59 width=110  border=0></a>
  </td>
  <td width="100%" valign=top style="background:#ECECEC;border: 1px solid #ccc;">

	<table width="100%" border="0">
	<tr>
	<td width="90%" valign="top">
	  	<span style="font-size:1.3em;font-weight:bold;">Sakai&nbsp;Requirements&nbsp;Voting</span>
<?php if (isset($PAGE_NAME)) { ?>
	  	<span style="font-size:1.1em;font-weight:bold;"> - <?= $PAGE_NAME ?></span>
<?php } ?>
	<br/>
	<a style="font-size:.8em;" href="index.php">Intro Page</a> -
	<a style="font-size:.8em;" href="vote.php">Voting Form</a> -
  	<a style="font-size:.8em;" href="results.php">View Results</a>
	</td>
	<td width="10%" align="right" valign="top">
<?php if ($USER_PK > 0) { ?>
	<span style="font-size:.9em;">
  	Welcome,&nbsp;<?= $USER["firstname"] ?>&nbsp;<?= $USER["lastname"] ?>
  	</span><br/>
  	<a style="font-size:.8em;" href="myaccount.php">My Account</a><br/>
  	<a style="font-size:.8em;" href="logout.php">Logout</a><br/>
<?php } else { ?>
  	<a style="font-size:.8em;" href="login.php">Login</a>
<?php } ?>
	</td>
	</tr>
	</table>
  </td>
</tr>
</table>