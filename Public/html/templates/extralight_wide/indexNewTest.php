<?php
/*
 * Created on Aug 7, 2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php echo "<?xml version=1.0?>"; defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); ?>
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
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
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

		$mymenu_content .= "<font color= '#8C8C8C'>: </font><a href=" .sefRelToAbs($mymenulink). " class='bar'>$mymenu_row->name</a><font color='#8C8C8C'> :</font>";

	}

}

$mymenu_content = substr($mymenu_content,0,strlen($mymenu_content)-2);

?>
<?PHP if(file_exists($mosConfig_absolute_path."/components/com_tfsformambo/tfsformambo.php")) 
			{
			require_once($mosConfig_absolute_path."/components/com_tfsformambo/tfsformambo.php");
			}?>
</head>
<body><div id="container">
<table width="850px" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="mainHeader" width="100%" ><table  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width=780px><a href="<?php echo $mosConfig_live_site;?>">
          <img src="<?php echo $mosConfig_live_site;?>/images/stories/conferenceLogos/logoslate160x89.jpg" border="0" alt="Sakai Logo" /></a></td>
          <td  id="searchbox"><div style="padding: 3px; background:#fff; color:#000;"><span style="color:#660000;">NEW 
          <a href="http://www.proyectosakai.org/" title="Spanish mirror of sakaiproject.org"><img src="images/stories/external_icon.gif" /> Espa&ntilde;ol &nbsp; </a></span></div><br/><br/><strong>SEARCH</strong>
          <div> <form action="http://www.google.com/u/sakaiproject" method="get" target="_blank">

<input type="text" class="inputbox" name="q" size="15" value="<?php echo _SEARCH_BOX_all; ?>"  onblur="if(this.value=='') this.value='<?php echo _SEARCH_BOX_all; ?>';" onfocus="if(this.value=='<?php echo _SEARCH_BOX_all; ?>') this.value='';" >
<input type="hidden" name="sa" value="sa"> </form>

        </div></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#eee"><table class="searchBar1"  width="100%"  border="0" cellspacing="0" cellpadding="0" bgcolor="#f3f3f3">
        <tr>
          <td class="searchBar"><span class="pathway"> <img src="<?php echo $mosConfig_live_site;?>/images/M_images/arrow.png" width="9" height="9" />
            <?php include "pathway.php"; ?>
            </span></td>
          
        
        </tr>
      </table></td>
  </tr>
  <tr width="100%" class="mainPageContent">
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr align="center" valign="top">
          <?php if (mosCountModules( "left" )) { ?>
          <td class="leftSide" width="160px">
          <table width="100%"  border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td><?php mosLoadModules ( 'left' ); ?></td>
              </tr>
            </table>
            <?php } ?>
          </td>
          <td class="centerContent" border="0" align="center" style="padding: 0px 0px;">


              <?php if (mosCountModules( "user7" )) { ?>
               <table width="100%" class="topBoxes"  cellspacing="5" cellpadding="0">

             
              <tr>
                <td width="28%" class="topBoxes"><?php mosLoadModules ('user7'); ?>
                  </td>
              <?php } ?>
                <?php if (mosCountModules( "user6" )) { ?>
                <td width="28%" class="topBoxes"><?php mosLoadModules ('user6'); ?>
                  </td>
              <?php } ?>
               <?php if (mosCountModules( "user5" )) { ?>
                <td width="28%" class="topBoxes"><?php mosLoadModules ('user5'); ?>
                  </td>
              </tr></table>
              <?php } ?> 
         
                    
                 
              
              
              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr><td style="padding: 3px 10px;" colspan=2>
                  <?php include ("mainbody.php"); ?></td>
                   <td valign=top> <?php if (mosCountModules( "inset" )) { ?>
          					<?php mosLoadModules ('inset'); ?>
                  <?php }  ?>
              <?php mosLoadModules ('user3'); ?>
              
                   <?php if (mosCountModules( "user1" )) { ?>
                  <?php mosLoadModules ('user1');   }  ?>
                  </td>
                  </tr></table>
             </td></tr>
  
              <tr>
                <td><?php mosLoadModules ( 'bottom', '1' ); ?></td>
              </tr>
            </table>
            </td>
          <?php if (mosCountModules( "right" )) { ?>
          <td class="rightSide" width="150"  style="border-left:1px solid #E3E3E3;"><table width="100%"  border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td><?php mosLoadModules ( 'right' ); ?></td>
              </tr>
            </table></td>
          <?php } ?>
        </tr>
      </table></td>
  </tr>
   <tr class="creditsHere">
    <td align="center" valign="top" border="0" ><p><br /><br /></p> </td>
  </tr>
  <tr class="myFooter">
    <td align="center" valign="middle" bgcolor="#FAFAFA" style="border-bottom:1px solid #E3E3E3; border-top:1px dashed #E3E3E3 "><span class="bar"><?php echo $mymenu_content ?></span></td>
  </tr>
  <tr class="creditsHere">
    <td align="center" valign="top" border="0" ><!--Creative Commons License--><a rel="license" href="http://creativecommons.org/licenses/by/2.5/"><img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.png"/></a><br/>This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/2.5/">Creative Commons Attribution2.5 License</a>.<!--/Creative Commons License--><!-- <rdf:RDF xmlns="http://web.resource.org/cc/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
		<Work rdf:about="">
			<license rdf:resource="http://creativecommons.org/licenses/by/2.5/" />
	<dc:type rdf:resource="http://purl.org/dc/dcmitype/Text" />
		</Work>
		<License rdf:about="http://creativecommons.org/licenses/by/2.5/"><permits rdf:resource="http://web.resource.org/cc/Reproduction"/><permits rdf:resource="http://web.resource.org/cc/Distribution"/><requires rdf:resource="http://web.resource.org/cc/Notice"/><requires rdf:resource="http://web.resource.org/cc/Attribution"/><permits rdf:resource="http://web.resource.org/cc/DerivativeWorks"/></License></rdf:RDF> -->
		<br /><br /><span class="small">Contact <a href="mailto:sakaiproject_webmaster@umich.edu">--Webmaster</a></span><br />
    </td>
  </tr>

</table></div>
</body>
</html>