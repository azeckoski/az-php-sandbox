<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
$iso = split( '=', _ISO );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
if ( $my->id ) {
	initEditor();
}
mosShowHead();

// *************************************************
// Change this variable blow to switch color-schemes
//
// If you have any issues, check out the forum at
// http://www.rockettheme.com
//
// *************************************************
$menu_type = "supersucker";				// splitmenu | supersucker | suckerfish  | module
$menu_name = "mainmenu";				// mainmenu by default, can be any Joomla menu name
$menu_sidenav = "left";					// left | right - splitmenu only
$default_width = "fluid";				// wide | thin | fluid

// *************************************************

if ($menu_type != "module") {
	require($mosConfig_absolute_path."/templates/" . $mainframe->getTemplate() . "/rt_" . $menu_type . ".php");
}
require($mosConfig_absolute_path."/templates/" . $mainframe->getTemplate() . "/rt_styleloader.php");

// splitmenu initialization code
if ($menu_type == "splitmenu") {
	$forcehilite = false;
	$topnav = rtShowHorizMenu($menu_name);
	$sidenav = rtShowSubMenu($menu_name);
	$tabcolor = rtGetTabColor();
	$hilightid = rtGetHilightid();
}

// *************************************************
?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/template_css.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/<?php echo $menu_type; ?>.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/footer.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 6]>
<link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/template_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<link rel="shortcut icon" href="favicon.ico" />
</head>
<body id="page_bg" class="w-fluid f-default">


	<div id="mainbg">
		<div class="wrapper">
			<div id="mainbg-2">
  				<div id="mainbg-3">
  					<div id="mainbg-4">
  						<div id="mainbg-5">
            
  
           					<div id="header">
			          			 
			          			<div class=access style="text-align:right;"> <form style="font-size:10px; padding-right:20px; padding-top:3px;" action="http://www.google.com/u/sakaiproject" method="get" target="_blank">
<span style="color:#fff; font-size: 12px;"> Search&nbsp;&nbsp;</span>
<input style="font-size: 10px;" type="text" class="inputbox" name="q" size="15" value="<?php echo _SEARCH_BOX_all; ?>"  onblur="if(this.value=='') this.value='<?php echo _SEARCH_BOX_all; ?>';" onfocus="if(this.value=='<?php echo _SEARCH_BOX_all; ?>') this.value='';" />
<input type="hidden" name="sa" value="sa" /> </form>

        </div>
			          			<a href="<?php echo $mosConfig_live_site;?>" title=""><span id="logo"> &nbsp; </span></a><h2><span id="confTitle">6th Sakai Conference with OSP<br/>Atlanta, Georgia, December 5-8, 2006</span></h2>
			          			<div id="top">
			          				<?php mosLoadModules('top', -1); ?>
			          			</div>
			            	</div>
							
			            	<?php if(mosCountModules('user1') || mosCountModules('user2') || mosCountModules('user3')) { ?>
			            	<div id="showcase">
			          			<div class="padding">
			          				<table class="showcase" cellspacing="0">
			          					<tr valign="top">
			          						<?php if(mosCountModules('user1')) { ?>
			          						<td class="showcase">
			          							<?php mosLoadModules('user1', -2); ?>
			          						</td>
			          						<?php } ?>
			          						<?php if(mosCountModules('user2')) { ?>
			          						<td class="showcase">
			          							<?php mosLoadModules('user2', -2); ?>
			          						</td>
			          						<?php } ?>
			          						<?php if(mosCountModules('user3')) { ?>
			          						<td class="showcase">
			          							<?php mosLoadModules('user3', -2); ?>
			          						</td>
			          						<?php } ?>
			          					</tr>
			          				</table>
			          			</div>
			            	</div>
			            	<?php } ?>
         
         						
			          		<div id="mainbody-padding">
			          			<table class="mainbody" cellspacing="0">
			          				<tr valign="top">
			          					<?php if(mosCountModules('left') || (strlen($sidenav)>0 && $menu_sidenav=="left")) { ?>
			          					<td class="left">
			          					<div class="moduletable">
                    					 <div id=confLogo>
                  						</div>
                  						</div>
                  	<?php if($menu_sidenav=="left" && $menu_type == "splitmenu") { ?>
			          						<?php echo $sidenav; ?>
			          						<?php } ?>
			          						<?php mosLoadModules('left', -2); ?>
			          					</td>
			          					<?php } ?>
			          					<td class="mainbody">
			          						<?php if(mosCountModules('user4') || mosCountModules('user5') || mosCountModules('user6')) { ?>
         
			          						<table class="headlines" cellspacing="10">
			          							<tr valign="top">
			          								<?php if(mosCountModules('user4')) { ?>
			          								<td class="headlines">
			          									<?php mosLoadModules('user4', -2); ?>
			          								</td>
			          								<?php } ?>
			          								<?php if(mosCountModules('user5')) { ?>
			          								<td class="headlines">
			          									<?php mosLoadModules('user5', -2); ?>
			          								</td>
			          								<?php } ?>
			          								<?php if(mosCountModules('user6')) { ?>
			          								<td class="headlines">
			          									<?php mosLoadModules('user6', -2); ?>
			          								</td>
			          								<?php } ?>
			          							</tr>
			          						</table>
         
			          						<?php } ?>
			          						<div class="padding">
			          							<?php mosPathway(); ?>
			          							<?php mosMainbody(); ?>
			          							<div id="inset">
			          								<?php mosLoadModules('inset', -1); ?>
			          							</div>
			          						</div>
			          					</td>
			          					<?php if(mosCountModules('right') || (strlen($sidenav)>0 && $menu_sidenav=="right")) { ?>
			          					<td class="right">
			          						<?php if($menu_sidenav=="right" && $menu_type == "splitmenu") { ?>
			          						<?php echo $sidenav; ?>
			          						<?php } ?>
			          						<?php mosLoadModules('right', -2); ?>
			          					</td>
			          					<?php } ?>
			          				</tr>
			          			</table>
			          		</div>							
         
			            	<?php if(mosCountModules('user7') || mosCountModules('user8') || mosCountModules('user9') || mosCountModules('footer')) { ?>
			            	<div id="footer">
			          			<div class="padding">
			          				<table class="footer" cellspacing="0">
			          					<tr valign="top"> 
			          						<?php if(mosCountModules('user7')) { ?>
			          						<td class="footer">
			          							<?php mosLoadModules('user7', -2); ?>
			          						</td>
			          						<?php } ?>
			          						<?php if(mosCountModules('user8')) { ?>
			          						<td class="footer">
			          							<?php mosLoadModules('user8', -2); ?>
			          						</td>
			          						<?php } ?>
			          						<?php if(mosCountModules('user9')) { ?>
			          						<td class="footer">
			          							<?php mosLoadModules('user9', -2); ?>
			          						</td>
			          						<?php } ?>
			          					</tr>
			          				</table>
         				
			          			</div>
			            	</div>
			            	<?php } ?>


            			</div>
					</div>
        		</div>
      		</div>	
		</div>
	</div>
	
	<div class="wrapper">
		<div id="mainft-2">
			<div id="mainft-3">
				<div id="the-footer">
					<div class="padding"><span class="small">Contact <a href="mailto:sakaiproject_webmaster@umich.edu">--Webmaster</a></span><br />
					
						<!--Creative Commons License--><a rel="license" href="http://creativecommons.org/licenses/by/2.5/"><img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.png"/></a>This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/2.5/">Creative Commons Attribution2.5 License</a>.<!--/Creative Commons License--><!-- <rdf:RDF xmlns="http://web.resource.org/cc/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
		<Work rdf:about="">
			<license rdf:resource="http://creativecommons.org/licenses/by/2.5/" />
	<dc:type rdf:resource="http://purl.org/dc/dcmitype/Text" />
		</Work>
		<License rdf:about="http://creativecommons.org/licenses/by/2.5/"><permits rdf:resource="http://web.resource.org/cc/Reproduction"/><permits rdf:resource="http://web.resource.org/cc/Distribution"/><requires rdf:resource="http://web.resource.org/cc/Notice"/><requires rdf:resource="http://web.resource.org/cc/Attribution"/><permits rdf:resource="http://web.resource.org/cc/DerivativeWorks"/></License></rdf:RDF> --></div>
	      		</div>
			</div>
		</div>
	</div>
  	

<?php mosLoadModules( 'debug', -1 );?>
</body>
</html>

