<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// needed to seperate the ISO number from the language file constant _ISO
$iso = explode( '=', _ISO );
// xml prolog
echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php mosShowHead(); ?>
<?php
if ( $my->id ) {
	initEditor();
}
?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<link href="<?php echo $mosConfig_live_site;?>/templates/vancouver/css/template_css.css" rel="stylesheet" type="text/css"/>
</head>
<body class="waterbody">

<div align="center">
<div id="container">
 <div id=header>

			<!-- start logo -->
			<div id="logo"><div id="logoimg">&nbsp;</div>
			<div id=confbanner>
			</div>
					<div id=topSearch>
					
					
        <div style="float:right; " ><div style="color:#fff;"><strong>SEARCH</strong>&nbsp; &nbsp;</div> <form  action="http://www.google.com/u/sakaiproject" method="get" target="_blank">

<input type="text" class="inputbox" name="q" size="20" value="<?php echo _SEARCH_BOX_all; ?>"  onblur="if(this.value=='') this.value='<?php echo _SEARCH_BOX_all; ?>';" onfocus="if(this.value=='<?php echo _SEARCH_BOX_all; ?>') this.value='';" >
<input type="hidden" name="sa" value="sa"> </form>
        </div>
          
            
            </div>	
            <div id="ospBanner"><br /><br />5th Sakai Conference <span style="font-size:14px;">with</span> <a href="http://www.osportfolio.org/" target=blank>OSP</a></div>

        

			</div><!-- end logo -->
	</div> <!-- end header -->
	
	<div id="containerbg">
		<div id="outerleft">
		
		  
			
			<!-- start top menu. -->
			<div id="topmenu" align=left>
			<!-- <?php mosLoadModules('top',-1); ?> --><a href="index.php">sakaiproject.org</a>
			</div>	
			<!-- end top menu.  -->
			<!-- start image header -->
			
			<!-- end image header -->
			<div id="container_inner">
				<!-- start left column. -->
				<div id="leftcol">
				<?php mosLoadModules('left'); ?>
				</div>
				<!-- end left column. -->
				
				<!-- start content top wrapper -->
				<?php
				if (mosCountModules('user2') >= 1 OR mosCountModules('user3') >= 1 ) {
				?>
				<div id="content_top_wrapper">
					<!-- start content top 1.  -->
					<div id="content_top1">
					<?php mosLoadModules('user2', '1'); ?>
					</div>
					<!-- end content top 1 -->
					<!-- start content top 2.  -->
					<div id="content_top2">
					<?php mosLoadModules('user3'); ?>
					</div>
					<!-- end content top 2 -->
				</div>
				<?php
				}
				?>
				<!-- end content top wrapper -->
				
				
				<!-- start main body -->
				<div id="content_main">
				<?php mosPathWay(); ?>
				<table width="500" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td>
					<?php mosMainBody(); ?>
					</td>
				  </tr>
				</table>
				</div>
				<!-- end main body -->
				
				
			</div><!-- end container inner  -->
		</div><!-- end outerleft  -->
		
		
		<?php if (mosCountModules('right') >='2');
		{
		
		?>
		<div id="outerright">
			<!-- start right top header.  -->
	<!--	<div id="rightcol_top">
			</div>  -->
			<!-- end right top header.-->
			<!-- start right column. -->
			<div id="rightcol">
			<?php mosLoadModules('right'); ?>
			</div>
			<!-- end right column. -->
		</div>			<!-- end outerright column. -->

		<?php
		}
		?>
		</div><!-- end containerbg -->
		
		
		<!-- begin footer -->
		<div class="clear">
		</div>
		<div id="blackline">
		</div>
		<div class="clear">
		</div>
		<div id="bottompadding"></div>
	
	<!-- copyright notice -->
	<div id="copyright"><div>
		copyright 2006 Sakai Project
		<br /><span class=small>contact <a href="mailto:sakaiproject_webmaster@umich.edu">
		--Webmaster</a></span></div>
	</div>
	<!--end  copyright notice -->

	<div class="clear"><br /><br /><br />	</div>
	<!--end  footer -->

</div><!-- end outerleft -->
</div><!-- end container -->
</div><!-- end center -->

<?php mosLoadModules('debug', -1);?>
</body>
</html>