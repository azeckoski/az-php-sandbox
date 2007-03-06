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
                    <td valign="top" colspan="2"><div align="right" style="padding:4px;background:#eee;font-size:12pt;color:#000;">
                        <?php if ($User->pk > 0) { ?>
                        <span style="font-size:.8em;"> Welcome,&nbsp;
                        <?= $User->firstname."&nbsp;".$User->lastname ?>
                        </span> - 
                        <a style="font-size:.7em;" href="<?= $ACCOUNTS_URL ?>/<?= $ACCOUNTS_PAGE ?>">My Account</a> - 
                        <?php if ($User->checkPerm("admin_conference")) { ?>
                        <a style="font-size:.7em;" href="<?= $TOOL_URL ?>/admin/index.php">Tool Admin</a> -
                        <?php } ?>
                        <a style="font-size:.7em;" href="<?= $ACCOUNTS_URL ?>/<?= $LOGOUT_PAGE ?>">Logout</a>
                        <?php } else { ?>
                        <a style="font-size:.9em;" href="<?= $ACCOUNTS_URL ?>/<?= $LOGIN_PAGE."?ref=".$_SERVER['PHP_SELF'] ?>">Login</a><br/>
                        <?php } ?>
                        <br/>
                        <?= $EXTRA_MESSAGE ?>
                     
                        <a style="font-size:9pt;" href="<?=$CONF_URL ?>">Conference Home</a> - <a style="font-size:9pt;" href="<?= $TOOL_URL ?>/registration/">Registration</a>  - <a style="font-size:9pt;" href="<?= $TOOL_URL ?>/proposals/">Proposals</a>- <a style="font-size:9pt;" href="<?= $TOOL_URL ?>/logos/">Logo Contest</a>
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
