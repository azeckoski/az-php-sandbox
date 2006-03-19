</head>
<body class="waterbody">
<div align="center">
<!-- start centering -->
<div id="container">
<!-- start container -->
<div id=header>
  <!-- start header -->
  <div id="logo">
    <!-- start logo -->
    <div id="logoimg">&nbsp;</div>
    <div id=confbanner><a href="index.php"></a></div>
    <div id=topSearch>
      <table cellpadding="0" cellspacing="0" class="moduletable">
        <tr>
          <td> 
<form class=searchform method="post" action="search.php">
                    <label style="color:#ffffff;"> Search Facebook</label><br />
                    <input type="text" name="searchword" size="20" maxlength="40" value="<?php echo $_POST['searchword']?>" />
                    <input type="submit" value="go" />
                  </form>              </div>
            </td>
        </tr>
      </table>
    </div>     
    <div id="ospBanner"><br /><br />5th Sakai Conference <span style="font-size:14px;">with</span> <a href="http://www.osportfolio.org/" target=blank>OSP</a></div>

  </div>
  <!-- end logo -->
</div>
<!-- end header -->
<div id="containerbg">
<!-- start containerbg -->
<div id="outerleft">
<!-- start outerleft -->
<!-- start top menu. -->
<div id="topmenu" align=right> <a href="http://www.sakaiproject.org/index.php">sakaiproject.org</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
<!-- end top menu.  -->
<!-- start image header -->
<!-- end image header -->
<div id="container_inner">
	<!-- start left column. -->
	<div id="leftcol">
				
	    <table cellpadding="0" cellspacing="0" class="moduletable">
	    <tr><th valign="top">Austin Conference</th></tr>
		<tr align="left"><td><a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=319&Itemid=527" class="mainlevel" >Conference Home</a></td></tr>
		<tr align="left"><td><a href="index.php" class="mainlevel" id="active_menu">Vancouver Facebook</a></td></tr>
		<tr align="left"><td>&nbsp;<br /></td></tr>
		</table>
		
		<table cellpadding="0" cellspacing="0" class="moduletable">
			<tr> <th>View Options</th> </tr>
			<tr><td>
				<ul><strong>Display by:</strong>
				<li><a href=view_lastname.php>Last Name</a></li>
            	 <li> <a href=view_recent.php>Recent Entry</a></li>
            	 <li><a href=view_institution.php>Institution</a></li>
            	 </ul><br />
       		  </td></tr> 
             
             <tr><td>&nbsp;</td>
           </tr>
         </table>
             
             
		<table cellpadding="0" cellspacing="0" class="moduletable">
			<tr><th valign="top">Submit Photo </th></tr>
			<tr><td>
				<div><ul>
                 <li> <a href=add_photo.php> Submit New Entry</a> </li>
               	<li>Edit Your Entry <br />
               	<span class=small> (coming soon)</span></li>
               </ul>
               </div>	
              </td>
			</tr>
				
			<tr><td valign=top align=left>
            <div id=help><br />
			<p><strong>Need help?</strong><br />If you experience problems adding your information to our facebook, 
			or if you need to make changes after your information is published, please email 
			<a style="color: #006699;" href="mailto:<?= $HELP_MAIL ?>"><?= $HELP_MAIL ?></a></p>
		   </div>
			</td></tr>
		</table>
	</div>
<!-- end left column. -->
				
<!-- start main body -->
<div id="content_main">

<!-- start  photo section -->
<div id=photos>
