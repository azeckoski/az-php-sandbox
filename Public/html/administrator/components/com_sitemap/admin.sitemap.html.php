<?php
// Site map component for Mambo Open Server version 4.5
// Copyright (C) 2003 Think Network GmbH
// All rights reserved
//
// This source file is part of the SiteMap component written as a
// component for Mambo Open Server. For further details please
// visit www.mamboserver.com
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
// --------------------------------------------------------------------------------
// $Id: admin.sitemap.html.php,v 1.2 2003/11/22 19:41:03 akede Exp $
//
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_sitemap {

	function showWelcome( $option, &$sitemapManager ) {
		global $act, $task;
    ?>
  <form action="index2.php" method="post" name="adminForm">
	<table width="90%" border="0" cellpadding="2" cellspacing="2" class="adminForm">
	<tr>
		<td class="sectionname" align="center"><h1>SiteMap - Information & Notes</h1></td>
		<td class="sectionname" align="left" valign="top"><div align="center">
		<img src="<?php echo $mosConfig_live_site;?>/components/com_sitemap/images/sitemap.png" alt="SiteMap logo" width="200" height="58" border="0"></td>
	</tr>
  <tr align="center" valign="top">
    <td align="left" valign="top">
	   <p>Welcome to the SiteMap component,<br>
	   the idea of this component is to be as simple as possible and just show the structure
	   of your site.<br>
	   &nbsp;<br>
	   But here the first problems start's. What is your structure?<br>
	   <ul>
	   	<li>Your main menu's?</li>
		<li>Main and sub menu's?</li>
		<li>All your categories?</li>
		<li>All categories within the menu's?</li>
	   </ul>
		</td>
		<td><div align="center"><h2>Special thank's to:</h2></div></p>
			<script language="JavaScript1.2">
			
			/*
			Fading Scroller- By DynamicDrive.com
			For full source code, and usage terms, visit http://www.dynamicdrive.com
			This notice MUST stay intact for use
			*/
			
			var delay=1200 //set delay between message change (in miliseconds)
			var fcontent=new Array()
			begintag='' //set opening tag, such as font declarations
			fcontent[0]="<h3>written by<br /></h3>Alex Kempkens, Munich - Germany"
			fcontent[1]="<h3>Dutch translation<br /></h3>by Joris van den Wittenboer"
			fcontent[2]="<h3>Frensh translation<br /></h3>by Pascal "
			fcontent[3]="<h3>Italian translation<br /></h3>by Giovanni Rezzoli"
			fcontent[4]="<h3>Thank's to all for the great support and ideas!<br /></h3>"
			fcontent[5]="<h3>a big THANK YOU <br /> to my loved onces ;-)</h3>"
			fcontent[6]="<h3></h3>"
			closetag=''
			
			var fwidth='200px' //set scroller width
			var fheight='80px' //set scroller height
			
			var fadescheme=0 //set 0 to fade text color from (white to black), 1 for (black to white)
			var fadelinks=1 //should links inside scroller content also fade like text? 0 for no, 1 for yes.
			
			///No need to edit below this line/////////////////
			
			var hex=(fadescheme==0)? 255 : 0
			var startcolor=(fadescheme==0)? "rgb(255,255,255)" : "rgb(0,0,0)"
			var endcolor=(fadescheme==0)? "rgb(0,0,0)" : "rgb(255,255,255)"
			
			var ie4=document.all&&!document.getElementById
			var ns4=document.layers
			var DOM2=document.getElementById
			var faderdelay=0
			var index=0
			
			if (DOM2)
			faderdelay=2000
			
			//function to change content
			function changecontent(){
			if (index>=fcontent.length)
			index=0
			if (DOM2){
			document.getElementById("fscroller").style.color=startcolor
			document.getElementById("fscroller").innerHTML=begintag+fcontent[index]+closetag
			linksobj=document.getElementById("fscroller").getElementsByTagName("A")
			if (fadelinks)
			linkcolorchange(linksobj)
			colorfade()
			}
			else if (ie4)
			document.all.fscroller.innerHTML=begintag+fcontent[index]+closetag
			else if (ns4){
			document.fscrollerns.document.fscrollerns_sub.document.write(begintag+fcontent[index]+closetag)
			document.fscrollerns.document.fscrollerns_sub.document.close()
			}
			
			index++
			setTimeout("changecontent()",delay+faderdelay)
			}
			
			// colorfade() partially by Marcio Galli for Netscape Communications.  ////////////
			// Modified by Dynamicdrive.com
			
			frame=20;
			
			function linkcolorchange(obj){
			if (obj.length>0){
			for (i=0;i<obj.length;i++)
			obj[i].style.color="rgb("+hex+","+hex+","+hex+")"
			}
			}
			
			function colorfade() {
			// 20 frames fading process
			if(frame>0) {
			hex=(fadescheme==0)? hex-12 : hex+12 // increase or decrease color value depd on fadescheme
			document.getElementById("fscroller").style.color="rgb("+hex+","+hex+","+hex+")"; // Set color value.
			if (fadelinks)
			linkcolorchange(linksobj)
			frame--;
			setTimeout("colorfade()",20);
			}
			
			else{
			document.getElementById("fscroller").style.color=endcolor;
			frame=20;
			hex=(fadescheme==0)? 255 : 0
			}
			}
			
			if (ie4||DOM2)
			document.write('<div id="fscroller" style="border:0px solid black;width:'+fwidth+';height:'+fheight+';padding:2px"></div>')
			
			window.onload=changecontent
			</script>
			<ilayer id="fscrollerns" width=&{fwidth}; height=&{fheight};><layer id="fscrollerns_sub" width=&{fwidth}; height=&{fheight}; left=0 top=0></layer></ilayer>
		</td>
	</tr>
	<tr>
		<td>
		 So you see it is not so easy as it look likes. So what I developed is a
	   small SiteMap that can be <a href="index2.php?option=com_sitemap&act=config">configured</a> a bit with some certain flags.
	   These flags help yout to at least change a bit of the look and feel of your SiteMap.</p>
	   
	   <p>If you want to know how I create the map and what your configuration will affect
	   then have a look at the <a href="index2.php?option=com_sitemap&act=help">small help page</a>.</p>
	   
	   <p>So there are some plans for future features and new ideas, but all of them
	   are not well thought throu yet. So please let me know what additional features 
	   <strong>you</strong> want to have in the SiteMap so that this component will become
	   something much people like and not just me ;-).<br>
	   &nbsp;<br>
	   Thank's for using the SiteMap<br>
	   &nbsp;<br>
	   Alex
	</td>
		<td align="left" valign="bottom">
		<span class="smallgrey"><strong>Contact:</strong></span><br>
		<a href="mailto:Alex.Kempkens@ThinkNetwork.com" class="smallgrey"><span class="smallgrey">Alex.Kempkens@ThinkNetwork.com</span></a><br>
		&nbsp;<br>
		<span class="smallgrey"><strong>Version:</strong></span><br>
		<span class="smallgrey"><?php echo $sitemapManager->getVersion();?></span><br>
		&nbsp;<br>
		<span class="smallgrey"><strong>Copyright:</strong></span><br>
		<span class="smallgrey">&copy; 2003 </span><a href="http://www.ThinkNetwork.com" target="_blank" class="smallgrey"><span class="smallgrey">Think Network</span></a><br>
		<a href="index2.php?option=com_admisc&task=license" class="smallgrey"><span class="smallgrey">GPL Open Source License.</span></a>
		</td>
	</tr>
  </table>

	  <input type="hidden" name="task" value="" />
	  <input type="hidden" name="act" value="<?php echo $act; ?>" />
	  <input type="hidden" name="option" value="<?php echo $option; ?>" />
    </form>
<?php
  }

	function showConfiguration( $option, &$sitemapManager ) {
		global $act, $task;
	?>
	    <script language="javascript" type="text/javascript">
	    function submitbutton(pressbutton) {
	      var form = document.adminForm;
	      if (pressbutton == 'cancel') {
	        submitform( pressbutton );
	        return;
	      } else {
	        submitform( pressbutton );
	      }
	    }
	    </script>
	
	  <form action="index2.php?task=save" method="post" name="adminForm" id="adminForm">
	  <table cellpadding="4" cellspacing="0" border="0" width="100%">
	  <tr>
	    <td width="100%" class="sectionname">
        <img src="<?php echo $mosConfig_absolute_path;?>/components/com_sitemap/images/sitemap.png" alt="" width="200" height="58" border="0">
	    </td>
	  </tr>
	  </table>
	<script language="javascript" src="js/dhtml.js"></script>
	<table cellpadding="3" cellspacing="0" border="0" width="100%">
	  <tr>
	    <td width="" class="tabpadding">&nbsp;</td>
	    <td id="tab1" class="offtab" onclick="dhtml.cycleTab(this.id)">Frontend</td>
	    <td width="90%" class="tabpadding">&nbsp;</td>
	  </tr>
	</table>
	
	  <div id="page1" class="pagetext">
	  <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm">
	    <TR>
	      <td class="sectionname" colspan="3"><h3><?php echo _SITEMAP_ADMIN_BASEDON;?></h3><h3></td>
	    </TR>
	    <tr align="center" valign="middle">
	      <td width="30%" align="left" valign="top"><strong><?php echo _SITEMAP_ADMIN_MAINMENU;?></strong></td>
	      <td width="20%" align="left" valign="top"><?php echo _SITEMAP_YES;?>
		  </td>
		  <td align="left"><?php echo _SITEMAP_ADMIN_MAINMENU_HELP;?></td></td>
	    </tr>
	    <tr align="center" valign="middle">
	      <td width="30%" align="left" valign="top"><strong><?php echo _SITEMAP_ADMIN_SUBMENU;?></strong></td>
	      <td width="20%" align="left" valign="top">
	      <?php
	        $yesno[] = mosHTML::makeOption( '1', _SITEMAP_YES );
	        $yesno[] = mosHTML::makeOption( '0', _SITEMAP_NO );
	        $frmField = mosHTML::selectList( $yesno, 'sitemap_showSubmenus', 'class="inputbox" size="1"', 'value', 'text', $sitemapManager->getCfg( 'showSubmenus' ) );
	        echo $frmField;
	      ?>
		  </td>
		  <td align="left"><?php echo _SITEMAP_ADMIN_SUBMENU_HELP;?></td>
	    </tr>
	    <tr align="center" valign="middle">
	      <td width="30%" align="left" valign="top"><strong><?php echo _SITEMAP_ADMIN_PUBLISHED;?></strong></td>
	      <td width="20%" align="left" valign="top">
	      <?php
	        $frmField = mosHTML::selectList( $yesno, 'sitemap_showPublishedContent', 'class="inputbox" size="1"', 'value', 'text', $sitemapManager->getCfg( 'showPublishedContent' ) );
	        echo $frmField;
	      ?>
		  </td>
		  <td align="left"><?php echo _SITEMAP_ADMIN_PUBLISHED_HELP;?></td>
	    </tr>
	    <TR>
	      <td class="sectionname" colspan="3"><h3><?php echo _SITEMAP_ADMIN_LAYOUT;?></h3></td>
	    </TR>
	    <tr align="center" valign="middle">
	      <td width="30%" align="left" valign="top"><strong><?php echo _SITEMAP_ADMIN_NUMCOLS;?></strong></td>
	      <td width="20%" align="left" valign="top">
	      <?php
	        $cols[] = mosHTML::makeOption( '1', '1' );
	        $cols[] = mosHTML::makeOption( '2', '2' );
	        $frmField = mosHTML::selectList( $cols, 'sitemap_numColumns', 'class="inputbox" size="1"', 'value', 'text', $sitemapManager->getCfg( 'numColumns' ) );
	        echo $frmField;
	      ?>
		  </td>
		  <td align="left"><?php echo _SITEMAP_ADMIN_NUMCOLS_HELP;?></td>
	    </tr>
	    <tr align="center" valign="middle">
	      <td width="30%" align="left" valign="top"><strong><?php echo _SITEMAP_ADMIN_STYLE_MAINMENU;?></strong></td>
	      <td width="20%" align="left" valign="top">
	      <?php
	        $frmField = '<input type="text" name="sitemap_styleMainmenu" size="30" maxlength="255" value="' .$sitemapManager->getCfg( 'styleMainmenu' ). '">' ;
	        echo $frmField;
	      ?>
		  </td>
		  <td align="left"><?php echo _SITEMAP_ADMIN_STYLE_MAINMENU_HELP;?></td>
	    </tr>
	    <tr align="center" valign="middle">
	      <td width="30%" align="left" valign="top"><strong><?php echo _SITEMAP_ADMIN_STYLE_SUBMENU;?></strong></td>
	      <td width="20%" align="left" valign="top">
	      <?php
	        $frmField = '<input type="text" name="sitemap_styleSubmenu" size="30" maxlength="255" value="' .$sitemapManager->getCfg( 'styleSubmenu' ). '">' ;
	        echo $frmField;
	      ?>
		  </td>
		  <td align="left"><?php echo _SITEMAP_ADMIN_STYLE_SUBMENU_HELP;?></td>
	    </tr>
	    <tr align="center" valign="middle">
	      <td width="30%" align="left" valign="top"><strong><?php echo _SITEMAP_ADMIN_STYLE_ANCHOR;?></strong></td>
	      <td width="20%" align="left" valign="top">
	      <?php
	        $frmField = '<input type="text" name="sitemap_styleAnchorTag" size="30" maxlength="255" value="' .$sitemapManager->getCfg( 'styleAnchorTag' ). '">' ;
	        echo $frmField;
	      ?>
		  </td>
		  <td align="left"><?php echo _SITEMAP_ADMIN_STYLE_ANCHOR_HELP;?></td>
	    </tr>
	    <TR>
	      <td class="sectionname" colspan="3"><h3><?php echo _SITEMAP_ADMIN_ICONS;?></h3></td>
	    </TR>
	    <tr align="center" valign="middle">
	      <td width="30%" align="left" valign="top"><strong><?php echo _SITEMAP_ADMIN_ICON_REGISTERED;?></strong></td>
	      <td width="20%" align="left" valign="top">
	      <?php
	        $frmField = mosHTML::selectList( $yesno, 'sitemap_showRestrictedIcon', 'class="inputbox" size="1"', 'value', 'text', $sitemapManager->getCfg( 'showRestrictedIcon' ) );
	        echo $frmField;
	      ?>
		  </td>
		  <td align="left"><?php echo _SITEMAP_ADMIN_ICON_REGISTERED_HELP;?></td>
	    </tr>
	    <tr align="center" valign="middle">
	      <td width="30%" align="left" valign="top"><strong><?php echo _SITEMAP_ADMIN_ICON_URL;?></strong></td>
	      <td width="20%" align="left" valign="top">
	      <?php
	        $frmField = mosHTML::selectList( $yesno, 'sitemap_showURLIcon', 'class="inputbox" size="1"', 'value', 'text', $sitemapManager->getCfg( 'showURLIcon' ) );
	        echo $frmField;
	      ?>
		  </td>
		  <td align="left"><?php echo _SITEMAP_ADMIN_ICON_URL_HELP;?></td>
	    </tr>
	  </table>
	  </div>
	  <script language="javascript" type="text/javascript">dhtml.cycleTab('tab1');</script>  
	  
	  <input type="hidden" name="sitemap_showSections" value="0" />
	  <input type="hidden" name="sitemap_showCategories" value="0" />
	  <input type="hidden" name="sitemap_showContent" value="0" />
	  <input type="hidden" name="sitemap_publishedContent" value="0" />
	  <input type="hidden" name="task" value="" />
	  <input type="hidden" name="act" value="<?php echo $act; ?>" />
	  <input type="hidden" name="option" value="<?php echo $option; ?>" />
	</form>
	<?php
		HTML_sitemap::_footer($sitemapManager);
	}

	function showHelp( $option, &$sitemapManager ) {
		global $act, $task;
    ?>
    <form action="index2.php" method="post" name="adminForm">
    <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname">
        <img src="<?php echo $mosConfig_absolute_path;?>/components/com_sitemap/images/sitemap.png" alt="" width="200" height="58" border="0">
      </td>
    </tr>
    </table>

	<table width="90%" border="0" cellpadding="2" cellspacing="2" class="adminForm">
	<tr><td width="100%" class="sectionname" align="center" colspan="2"><h1>SiteMap - Help</h1></td></tr>
    <tr align="center" valign="middle">
      <td align="left" valign="top" width="50%">
		<h3>What is going on?</h3>
		The SiteMap component creates a dynamic map of your content. The basic element is your
		main menu structure. So these meuns which are building your central navigation.</p>
		
		The SiteMap is build on a table skelleton which helps to show the hirachie of your
		navigation if you switch on the <i>sub menu</i> option.<br>
		&nbsp;<br>
		It is also possible to define that the SiteMap should be displayed in one or two (like in the example)
		columns. Bigger site might prefer the second option not to wast to much space.<br>
		&nbsp;<br>
		You can choose any of the existing styles to relate them to the main or sub menus. So your template
		will controle a bit more the layout of the map.<br>
		&nbsp;<br>
		The last feature is to display additional icons for the entries. These icons just show some
		special information about the link.
		</td>
		<td align="center" valign="top">
	    <table align="center" cellpadding="1" cellspacing="0" border="1" width="90%" class="contentpane">
	      <tr>
          <td width="50%" colspan="6"><img src="/images/M_images/blank.png" height="0" width="5"></td>
	       <td width="50%" colspan="6"><img src="/images/M_images/blank.png" height="0" width="5"></td>
	      </tr>
			<tr>
	  		 <td width="1%"><img src="/images/M_images/blank.png" height="0" width="5"></td>
			 <td width="1%"><img src="/images/M_images/blank.png" height="0" width="5"></td>
			 <td width="1%"><img src="/images/M_images/blank.png" height="0" width="5"></td>
			 <td width="1%"><img src="/images/M_images/blank.png" height="0" width="5"></td>
		    <td>&nbsp;</td>
			 <td width="1%">&nbsp;</td>
			<td width="1%"><img src="/images/M_images/blank.png" height="0" width="5"></td>
			<td width="1%"><img src="/images/M_images/blank.png" height="0" width="5"></td>
			<td width="1%"><img src="/images/M_images/blank.png" height="0" width="5"></td>
			<td width="1%"><img src="/images/M_images/blank.png" height="0" width="5"></td>
		   <td>&nbsp;</td>
			<td width="1%">&nbsp;</td>
		</tr>
		<tr>
		<td colspan="5" width="100%" nowrap class="componentheading"><a href="index.php?option=com_frontpage&amp;Itemid=1" class="componentheading">Home</a>
	</td><td align="right">&nbsp;</td><td colspan="5" width="100%" nowrap class="componentheading"><a href="index.php?option=content&amp;task=section&amp;id=6&amp;Itemid=76" class="componentheading">Interaktiv</a>
	</td><td align="right">&nbsp;</td>	</tr>
			<tr>
		<td colspan="5" width="100%" nowrap class="componentheading"><a href="index.php?option=content&amp;task=section&amp;id=3&amp;Itemid=59" class="componentheading">Netzwerk</a>
	</td><td align="right">&nbsp;</td><td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=content&amp;task=blogsection&amp;id=6&amp;Itemid=77" class="">Gerade aktuell</a>
	</td><td align="right">&nbsp;</td>	</tr>
			<tr>
		<td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=content&amp;task=section&amp;id=8&amp;Itemid=60" class="">Das Team</a>
	</td><td align="right">&nbsp;</td><td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=com_remository&amp;Itemid=85" class="">ReMOSitory</a>
	</td><td align="right">&nbsp;</td>	</tr>
			<tr>
		<td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=content&amp;task=section&amp;id=9&amp;Itemid=61" class="">Eigene Projekte</a>
	</td><td align="right">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td colspan="3" width="100%" nowrap class="contentpane"><a href="index.php?option=com_remository&amp;Itemid=85&amp;func=addfile" class="">hinzufühgen</a>
	</td><td align="right"><img src="/components/com_sitemap/images/lock.png" alt="Content only for registered users" border="0"></td>	</tr>
			<tr>
		<td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=content&amp;task=section&amp;id=10&amp;Itemid=62" class="">Think Group</a>
	</td><td align="right">&nbsp;</td><td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=com_weblinks&amp;Itemid=79" class="">Web Links</a>
	</td><td align="right">&nbsp;</td>	</tr>
			<tr>
		<td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=content&amp;task=section&amp;id=13&amp;Itemid=63" class="">Partner</a>
	</td><td align="right">&nbsp;</td><td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=com_poll&amp;Itemid=81" class="">Umfragen</a>
	</td><td align="right">&nbsp;</td>	</tr>
			<tr>
		<td colspan="5" width="100%" nowrap class="componentheading"><a href="index.php?option=content&amp;task=section&amp;id=4&amp;Itemid=64" class="componentheading">Kooperationen</a>
	</td><td align="right">&nbsp;</td><td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="https://www.thinknetwork.com/interactive/phproject" class="">PHProject</a>
	</td><td align="right"><img src="/components/com_sitemap/images/lock.png" alt="Content only for registered users" border="0"><img src="/images/M_images/weblink.png" alt="Externer WebLink" border="0"></td>	</tr>
			<tr>
		<td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=content&amp;task=section&amp;id=11&amp;Itemid=65" class="">Das Konzept</a>
	</td><td align="right">&nbsp;</td><td colspan="5" width="100%" nowrap class="componentheading"><a href="index.php?option=content&amp;task=section&amp;id=7&amp;Itemid=78" class="componentheading">Chill out</a>
	</td><td align="right">&nbsp;</td>	</tr>
			<tr>
		<td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=content&amp;task=section&amp;id=12&amp;Itemid=66" class="">Die Projekte</a>
	</td><td align="right">&nbsp;</td><td colspan="5" width="100%" nowrap class="componentheading"><a href="index.php?option=content&amp;task=view&amp;id=1&amp;Itemid=36" class="componentheading">Kontakt</a>
	</td><td align="right">&nbsp;</td>	</tr>
			<tr>
		<td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=content&amp;task=section&amp;id=13&amp;Itemid=67" class="">Partner</a>
	</td><td align="right">&nbsp;</td><td colspan="5" width="100%" nowrap class="componentheading"><a href="index.php?option=content&amp;task=section&amp;id=2&amp;Itemid=55" class="componentheading">News</a>
	</td><td align="right">&nbsp;</td>	</tr>
			<tr>
		<td colspan="5" width="100%" nowrap class="componentheading"><a href="index.php?option=content&amp;task=section&amp;id=5&amp;Itemid=69" class="componentheading">Beratung / Coaching</a>
	</td><td align="right">&nbsp;</td><td colspan="5" width="100%" nowrap class="componentheading"><a href="index.php?option=content&amp;task=view&amp;id=2&amp;Itemid=37" class="componentheading">Impressum</a>
	</td><td align="right">&nbsp;</td>	</tr>
			<tr>
		<td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=content&amp;task=section&amp;id=14&amp;Itemid=71" class="">Technologie-<br>beratung</a>
	</td><td align="right">&nbsp;</td><td colspan="5" width="100%" nowrap class="componentheading"><a href="index.php?option=com_sitemap&amp;Itemid=84" class="componentheading">Site map</a>
	</td><td align="right">&nbsp;</td>	</tr>
			<tr>
		<td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=content&amp;task=section&amp;id=15&amp;Itemid=73" class="">Team coaching</a>
	</td><td align="right">&nbsp;</td><td colspan="6">&nbsp;</td>	</tr>
			<tr>
		<td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=content&amp;task=blogsection&amp;id=16&amp;Itemid=72" class="">Die Projekte</a>
	</td><td align="right">&nbsp;</td><td colspan="6">&nbsp;</td>	</tr>
			<tr>
		<td>&nbsp;</td><td colspan="4" width="100%" nowrap class="contentpane"><a href="index.php?option=content&amp;task=section&amp;id=13&amp;Itemid=74" class="">Partner</a>
	</td><td align="right">&nbsp;</td><td colspan="6">&nbsp;</td>	</tr>
		    </table>
		</td>
    </tr>
	 <tr><td colspan="2">
	 	<h3>How to use the map?</h3>
		 To use the SiteMap you just only need to relate the component to one of your menu's. After
		 that the map will be generated each time and will so stay up to date.<br>
		 &nbsp;<br>
		 There are some requests which want to have a static version of the map. At the moment
		 I only can say - show source and copy it. May be in future will have some better alternative
		 (e.g. to download it somewhere.)</p>
	 </td></tr>
	 <tr><td colspan="2">
	 	<h3>And now?</h3>
		 <strong>Have fun!</strong><br>
		 And if you have any comments - please write an eMail. This is <strong>your</strong> SiteMap not only mine.
		 So if I don't get any feedback I can't make it better ;-).<br>
		 &nbsp;<br>
		 Thank's for using<br>
		 &nbsp;<br>
		 Alex (<a href="mailto:Alex.Kempkens@ThinkNetwork.com">Alex.Kempkens@ThinkNetwork.com</a>)
	 </td></tr>
  </table>

	  <input type="hidden" name="task" value="" />
	  <input type="hidden" name="act" value="<?php echo $act; ?>" />
	  <input type="hidden" name="option" value="<?php echo $option; ?>" />
    </form>
<?php
		HTML_sitemap::_footer($sitemapManager);
  }
	
	function _footer($sitemapManager) {
	?>
  	<p><font class="smalldark">SiteMap <?php echo $sitemapManager->getVersion();?><br>
    &copy; 2003 <a href="http://www.ThinkNetwork.com" target="_blank" class="smalldark">Think Network</a>, released under the GPL.</font></p>
	<?php
	}
}
?>