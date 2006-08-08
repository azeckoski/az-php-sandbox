</head>
<body id="page_bg" class="w-wide f-default">
<div id="mainbg">
  <div class="wrapper">
    <div id="mainbg-2">
      <div id="mainbg-3">
        <div id="mainbg-4">
          <div id="mainbg-5">
            <div id="header"> <a href="http://sakaiproject.org" title=""><span id="logo">&nbsp;</span></a>
              <div id="top">
                <table class="contentpaneopen">
                  <tr>
                    <td valign="top" colspan="2"><div align="right" style="padding:10px;background:#eee;font-size:12pt;color:#000;">
                        <?php if ($User->pk > 0) { ?>
                        <span style="font-size:.8em;"> Welcome,&nbsp;
                        <?= $User->firstname."&nbsp;".$User->lastname ?>
                        </span><br/>
                        <a style="font-size:.7em;" href="<?= $ACCOUNTS_URL ?>/<?= $ACCOUNTS_PAGE ?>">My Account</a><br/>
                        <?php if ($User->checkPerm("admin_conference")) { ?>
                        <a style="font-size:.7em;" href="<?= $TOOL_URL ?>/admin/index.php">Tool Admin</a> -
                        <?php } ?>
                        <a style="font-size:.7em;" href="<?= $ACCOUNTS_URL ?>/<?= $LOGOUT_PAGE ?>">Logout</a><br/>
                        <?php } else { ?>
                        <a style="font-size:.9em;" href="<?= $ACCOUNTS_URL ?>/<?= $LOGIN_PAGE."?ref=".$_SERVER['PHP_SELF'] ?>">Login</a><br/>
                        <br/>
                        <?php } ?>
                        <?= $EXTRA_MESSAGE ?>
                     
                        <a style="font-size:9pt;" href="http://sakaiproject.org/index.php?option=com_content&amp;task=view&amp;id=418&amp;Itemid=566">Conference Home</a> - <a style="font-size:9pt;" href="<?= $TOOL_URL ?>/registration/">Registration</a> - <a style="font-size:9pt;" href="<?= $TOOL_URL ?>/proposals/">Proposals</a>
                        <?= $EXTRA_LINKS ?>
                      </div></td>
                  </tr>
                </table>
              </div>
            </div>
            <div id="showcase">
              <div class="padding"> </div>
            </div>
            <div id="mainbody-padding">
              <table class="mainbody" cellspacing="0">
                <tr valign="top">
                  <td class="left">
                    <div class="moduletable">
                     <div id=confLogo>
                  	</div>
                      <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr align="left">
                          <td><a href="http://sakaitest.org/index.php?option=com_content&amp;task=view&amp;id=418&amp;Itemid=566" class="mainlevel" >Conference home</a></td>
                        </tr>
                        <tr align="left">
                        
                          <td><a href="http://sakaitest.org/index.php?option=com_content&amp;task=view&amp;id=420&amp;Itemid=572" class="mainlevel" >Help?</a></td>
                        </tr>
                        
                        <tr><td>
                        <?php 
	$sql = "select CP.title, CP.pk from conf_proposals CP " .
		"where CP.users_pk='$User->pk' and CP.confID = '$CONF_ID'";
	//print "SQL=$sql<br/>";
	$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());

	if(mysql_num_rows($result) > 0) {
		// print the nice header
?>
	<div style="padding:15px;"></div><div style="padding:3px; margin:0px;border:1px solid #232833;background:white;">
		<div><strong>Your&nbsp;Proposals:</strong></div>
<?php
	while($item=mysql_fetch_assoc($result)) {
?>
	<p><a href="edit_proposal.php?pk=<?= $item['pk'] ?>" title="Edit this proposal" ><?=  $item['title'] ?></a>
		<!-- [<a style="color:red;" href="edit_proposal.php?pk=<?= $item['pk'] ?>&amp;delete=1" 
			title="Delete this proposal"
			onClick="return confirm('Are you sure you want to delete this proposal?');" >X</a>]  -->
	</p>
<?php
		} // end while
		echo "<hr/><p>[ <a title='Create a new proposal' href='index.php'>add a proposal</a> ]</p>";
		echo "</div>";
	} // end if
?>

                        
                        </td>
                        </tr>
                      </table>
                    </div>
                    <div class="moduletable"> </div></td>
                  <td class="mainbody" width="100%">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="contentpane">
                      <tr>
                        <td width="100%" valign="top" class="contentdescription" colspan="2">
 
<div class="componentheading"><br/> 6th Sakai Conference - 
                        December 5-8, 2006  -
                        Atlanta, Georgia </div>