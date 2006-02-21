<?php defined( "_VALID_MOS" ) or die( "Direct Access to this location is not allowed." );$iso = split( '=', _ISO );echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php mosShowHead(); ?>
<meta http-equiv="Content-Type" content="text/html;><?php echo _ISO; ?>" />
<?php if ( $my->id ) { initEditor(); } ?>
<?php echo "<link rel=\"stylesheet\" href=\"$GLOBALS[mosConfig_live_site]/templates/$GLOBALS[cur_template]/css/template_css.css\" type=\"text/css\"/>" ; ?>
<link rel="alternate" title="<?php echo $mosConfig_sitename; ?>" href="<?php echo $GLOBALS['mosConfig_live_site']; ?>/index2.php?option=com_rss&no_html=1" type="application/rss+xml" />
<script language="JavaScript" type="text/javascript">
    <!--
    function MM_reloadPage(init) {  //reloads the window if Nav4 resized
      if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
        document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
      else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
    }
    MM_reloadPage(true);
    //-->
  </script>
<style type="text/css">
<!--
.Stil1 {font-size: xx-small;
	color: #FFFFFF;
}
-->
</style>
</head>

<body>
<div>
  <a name="up" id="up"></a>
  <table width="100%" height="20" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" class="mt">&nbsp;</td>
    </tr>
  </table>  
  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td><img src="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/space.gif" width="770" height="1" /></td>
  </tr>
	<tr>
      <td><div class="background">
        <table width="100%"  border="0" cellpadding="0" cellspacing="0" background="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/center.jpg">
          <tr>
            <td width="26"><img src="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/left.jpg" width="26" /></td>
            <td class="title">              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="100" colspan="2" class="title" style="padding-top:14px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td style="padding-left:10px;"><a href="<?php echo $mosConfig_live_site;?>" title="<?php echo $mosConfig_sitename; ?>"><?php echo $mosConfig_sitename; ?></a><p><strong>4th Sakai Conference, Austin Texas - 
December 7-9, 2005&nbsp;</strong></p></td>
                      <td width="100%" style="width:250px;"><?php mosLoadModules ( 'banner' ); ?>
</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td width="400" height="29"><div id="search">
                    <?php mosLoadModules ( 'user4', -1 ); ?>
                </div></td>
                <td width="100%" height="29" valign="bottom" class="mainlevel-nav"><?php mosLoadModules ( 'user3' ); ?></td>
              </tr>
            </table></td>
            <td width="26"><img src="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/right.jpg" width="26" /></td>
          </tr>
        </table>
        <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="11" height="25" background="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/shadowl.jpg"><div>
            </div></td>
            <td height="25" bgcolor="#F1F1F1" style="border-bottom: 1px solid #999999; border-top: 5px solid #FFFFFF;"><?php mosPathWay(); ?></td>
            <td height="25" align="right" bgcolor="#F1F1F1" style="border-bottom: 1px solid #999999; border-top: 5px solid #FFFFFF;"><div class="date"><?php echo mosCurrentDate(); ?></div></td>
            <td width="11" height="25" align="right" background="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/shadowr.jpg">&nbsp;</td>
          </tr>
        </table>
        <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top" style="padding-left:8px; background-repeat: repeat-y;" background="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/shadowl.jpg">&nbsp;</td>
            <td valign="top" style="background-repeat: repeat-y;"background="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/lb.gif"><?php if (mosCountModules('left')) { ?>
              <div class="leftrow">
                <?php mosLoadModules ( 'left' ); ?>
              </div>
              <?php } ?></td>
            <td valign="top" bgcolor="#FAFAFA" width="100%"><div class"main">
              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr valign="top" bgcolor="#F1F1F1">
                  <?php if (mosCountModules('top')) { ?><td colspan="3" style="border-top: 3px solid #FFFFFF;">
                      <div>
                        <?php mosLoadModules ( 'top' ); ?>
                      </div>
                      </td><?php } ?>
                </tr>
                <tr>
                  <?php if (mosCountModules('user1')) { ?><td valign="top" bgcolor="#F1F1F1" style="border-top: 3px solid #FFFFFF;"><div>
                      <?php mosLoadModules ( 'user1' ); ?>
                  </div></td>
                  <td width="4" class="mod" valign="top" bgcolor="#FFFFFF" style="border-top: 3px solid #FFFFFF;"><div class="mod"> <?php } ?><?php if (mosCountModules('user2')) { ?> </div></td> 
                  
                  <td valign="top" bgcolor="#F1F1F1" style="border-top: 3px solid #FFFFFF;"><div>
                    <?php mosLoadModules ( 'user2' ); ?>
</div></td><?php } ?>
                </tr>
                <tr align="left" valign="top">
                  <td colspan="3" style=" border-top: 4px solid #FFFFFF; padding: 5px;"><div class="main">
                      <?php mosMainBody(); ?>
                      </div></td>
                </tr>
                <tr bgcolor="#F1F1F1">
                  <td colspan="3" valign="top" style="border-top: 3px solid #FFFFFF;"><?php if (mosCountModules('bottom')) { ?>
                    <div>
                      <?php mosLoadModules ( 'bottom' ); ?>
                  </div>
                    <?php } ?></td>
                  </tr>
              </table>
             </td>
            <td valign="top" style="background-repeat: repeat-y; "background="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/rb.gif"><?php if (mosCountModules('right')) { ?>
                <div class="rightrow">
                  <?php mosLoadModules ( 'right' ); ?>
                </div>                
              <?php } ?></td>
            <td valign="top" style="padding-right: 8px; background-repeat: repeat-y;" background="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/shadowr.jpg">&nbsp;</td>
          </tr>
        </table>
        <table width="100%"  border="0" cellpadding="0" cellspacing="0" background="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/center2.jpg">
          <tr>
            <td width="26"><img src="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/left2.jpg" /></td>
            <td>
              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="30" align="left"><a href="<?php echo sefRelToAbs($_SERVER['REQUEST_URI'])."#up"; ?>"><img src="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/ltop.jpg" alt="Top!" border="0" /></a> </td>
                  <td align="center"><div class="footer"><?php include_once('includes/footer.php'); ?>
                   </div>
                    </td>
                  <td width="30" align="right"><a href="<?php echo sefRelToAbs($_SERVER['REQUEST_URI'])."#up"; ?>"><img src="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/rtop.jpg" alt="Top!" border="0" /></a></td>
                </tr>
            </table></td>
            <td width="26"><img src="<?php echo $mosConfig_live_site;?>/templates/247portal-b-brown2/images/right2.jpg" /></td>
          </tr>
        </table>
      </div></td>
    </tr>
  </table>
</div>
</body>
</html>