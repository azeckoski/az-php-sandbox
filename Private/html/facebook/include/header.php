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
 	<table cellpadding="0" cellspacing="0" class="moduletable">
			<tr> <th>View Options</th> </tr>
			<tr><td><br/>&nbsp;&nbsp;&nbsp;<strong>Display by:</strong>
				<ul>
				<li><a href="javascript:orderBy('date_created desc');">Recent Entry</a></li>
				<li><a href="javascript:orderBy('lastname');">Last Name</a></li>
				<li><a href="javascript:orderBy('institution');">Institution</a></li>
				<li><a href="javascript:orderBy('date_modified desc');">Recent Update</a></li>
				</ul>
       		  </td></tr> 
             
             <tr><td>&nbsp;</td>
           </tr>
         </table>
             
             
		<table cellpadding="0" cellspacing="0" class="moduletable">
			<tr><th valign="top" align="left">&nbsp;&nbsp;&nbsp;Contest Entry</th></tr>
			<tr><td>
				<ul>
                 <li> <a href="add_entry.php">Submit New Entry</a> </li>
               	<li> <a href="add_entry.php">Edit Your Entry</a><br/> </li>
               </ul>
               	
              </td>
			</tr>
				
			<tr><td valign=top>
            <br /><div id=help>
			<p><strong>Need help?</strong><br />If you experience problems adding or editing your logo or theme, 
			please contact: 
			 <a style="color: #006699;" href="mailto:<?= $HELP_EMAIL ?>">webmaster</a> .
			<!-- <a style="color: #006699;" href="mailto:<?= $HELP_EMAIL ?>"><?= $HELP_EMAIL ?></a> -->
		   </p></div>
			</td></tr>
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