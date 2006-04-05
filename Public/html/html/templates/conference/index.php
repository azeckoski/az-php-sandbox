<?php echo "<?xml version=\"1.0\"?>"; defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $mosConfig_sitename; ?></title>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<?php

if ($my->id) {

	include ("editor/editor.php");

	initEditor();

}

?>
<?php include ("includes/metadata.php"); ?>
<link href="templates/<?php echo $cur_template; ?>/css/template_css.css" rel="stylesheet" type="text/css" />

<?php // Custom MainMenu extension...

$database->setQuery("SELECT * FROM #__menu WHERE menutype = 'mainmenu' AND published ='1' AND parent = '0' ORDER BY ordering");

$mymenu_rows = $database->loadObjectList();

$mymenu_content = "";

foreach($mymenu_rows as $mymenu_row) {

	// print_r($mymenu_rows);

	$mymenulink = $mymenu_row->link;

	if ($mymenu_row->type != "url") {

		$mymenulink .= "&Itemid=$mymenu_row->id";

	}

	if ($mymenu_row->type != "separator") {

		$mymenu_content .= "<font color=\"#8C8C8C\">: </font><a href=\"".sefRelToAbs($mymenulink)."\" class=\"bar\">$mymenu_row->name</a><font color=\"#8C8C8C\"> :</font>";

	}

}

$mymenu_content = substr($mymenu_content,0,strlen($mymenu_content)-2);

?>
<?PHP if(file_exists($mosConfig_absolute_path."/components/com_tfsformambo/tfsformambo.php")) 
			{
			require_once($mosConfig_absolute_path."/components/com_tfsformambo/tfsformambo.php");
			}?>
</head>
<body>
<table width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="mainHeader" width="100%" ><table  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><a href="<?php echo $mosConfig_live_site;?>"><img src="<?php echo $mosConfig_live_site;?>/images/stories/conferenceLogos/logoslate160x89.jpg" border="0" alt="Sakai Logo" /></a></td>
          <td class="topNav" width="100%" valign="top" align="right"><?php mosLoadModules ( 'top' ); ?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#eee"><table class="searchBar1"  width="100%"  border="0" cellspacing="0" cellpadding="0" bgcolor="#f3f3f3">
        <tr>
          <td class="searchBar"><span class="pathway"> <img src="<?php echo $mosConfig_live_site;?>/images/M_images/arrow.png" width="9" height="9" />
            <?php include "pathway.php"; ?>
            </span></td>
          <td  align="right">search &nbsp; &nbsp;</td>
          <td  align="left" width="120"><form action='<?php echo sefRelToAbs("index.php"); ?>' method='post'>
              <input class="inputbox" type="text" name="searchword" size="15" value="<?php echo _SEARCH_BOX; ?>"  onblur="if(this.value=='') this.value='<?php echo _SEARCH_BOX; ?>';" onfocus="if(this.value=='<?php echo _SEARCH_BOX; ?>') this.value='';" />
              <input type="hidden" name="option" value="search" />
            </form></td>
        </tr>
      </table></td>
  </tr>
  <tr width="100%" class="mainPageContent">
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr align="center" valign="top">
          <?php if (mosCountModules( "left" )) { ?>
          <td class="leftSide" width="160" background="<?php echo $mosConfig_live_site;?>/templates/extralight/images/mainbackground.gif" style=" border-right:1px solid #E3E3E3; background-repeat:repeat-x; background-position:bottom "><table width="100%"  border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td><?php mosLoadModules ( 'left' ); ?></td>
              </tr>
            </table>
            <?php } ?>
          </td>
          <td class="centerContent" align="center" style="background-repeat:repeat-x; background-position:bottom " background="<?php echo $mosConfig_live_site;?>/templates/extralight/images/mainbackground.gif"><table width="95%"  border="0" cellspacing="0" cellpadding="0">
              <?php if (mosCountModules( "inset" )) { ?>
              <tr>
                <td style="border:0px solid #eee;"><?php mosLoadModules ('inset'); ?>
                  <br /></td>
              </tr>
              <?php } ?>
              <tr>
                <td><br />
                  <?php include ("mainbody.php"); ?></td>
              </tr>
              <tr>
                <td><?php mosLoadModules ( 'bottom', '1' ); ?></td>
              </tr>
            </table></td>
          <?php if (mosCountModules( "right" )) { ?>
          <td class="rightSide" width="150" background="<?php echo $mosConfig_live_site;?>/templates/extralight/images/mainbackground.gif" style="border-left:1px solid #E3E3E3; background-repeat:repeat-x; background-position:bottom "><table width="100%"  border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td><?php mosLoadModules ( 'right' ); ?></td>
              </tr>
            </table></td>
          <?php } ?>
        </tr>
      </table></td>
  </tr>
  <tr class="myFooter">
    <td align="center" valign="middle" bgcolor="#FAFAFA" style="border-bottom:1px solid #E3E3E3; border-top:1px dashed #E3E3E3 "><span class="bar"><?php echo $mymenu_content ?></span></td>
  </tr>
  <tr class="creditsHere">
    <td align="center" valign="top" border="0" ><span class="small">Contact <a href="mailto:sakaiproject_webmaster@umich.edu">--Webmaster</a></span><br />
    </td>
  </tr>
</table>
</body>
</html>