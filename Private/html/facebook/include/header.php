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
      <table cellpadding="0" cellspacing="0" class="moduletable" width="90%">
        <tr>
          <td align="right" style="color:white;">
<?php if ($USER_PK > 0) { ?>
	<span style="font-size:10pt;">
  	Welcome,&nbsp;<?= $USER["firstname"] ?>&nbsp;<?= $USER["lastname"] ?>
  	</span><br/>
  	<a style="font-size:9pt;color:white;" href="<?= $ACCOUNTS_URL ?>/<?= $ACCOUNTS_PAGE ?>">My Account</a><br/>
<?php if ($USER["admin_conf"]) { ?>
  	<a style="font-size:9pt;color:white;" href="<?= $TOOL_PATH ?>/admin.php">Tool Admin</a> - 
<?php } ?>
  	<a style="font-size:9pt;color:white;" href="<?= $ACCOUNTS_URL ?>/<?= $LOGOUT_PAGE ?>">Logout</a><br/>
<?php } else { ?>
  	<a style="font-size:11pt;color:white;" href="<?= $ACCOUNTS_URL ?>/<?= $LOGIN_PAGE."?ref=".$_SERVER['PHP_SELF'] ?>">Login</a><br/>		
	<br/>
<?php } ?>
		  <div style="text-align:left;">
			<form class="searchform" method="post" action="search.php" style="margin:0px;">
                    <label style="color:#ffffff;"> Search Facebook</label><br />
                    <input type="text" name="searchword" size="20" maxlength="40" value="<?php echo $_POST['searchword']?>" />
                    <input type="submit" value="go" />
            </form> 
          </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <!-- end logo -->
</div>
<!-- end header -->
<div id="containerbg">
<!-- start containerbg -->
<div id="outerleft">
<!-- start outerleft -->
<!-- start top menu. -->
<div id="topmenu" align=right>
	<a href="http://www.sakaiproject.org/index.php">sakaiproject.org</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
<!-- end top menu.  -->
<!-- start image header -->
<!-- end image header -->
<div id="container_inner">
	<!-- start left column. -->
	<div id="leftcol">
				
	    <table cellpadding="0" cellspacing="0" class="moduletable">
	    <tr><th valign="top">Vancouver Conference</th></tr>
		<tr align="left"><td><a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=319&Itemid=527" class="mainlevel" >Conference Home</a></td></tr>
		<tr align="left"><td><a href="https://www.sakaiproject.org/conference/registration/" class="mainlevel" id="active_menu">Registration</a></td></tr>
		<tr align="left"><td><a href="index.php" class="mainlevel" id="active_menu">Facebook</a></td></tr>
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
			<a style="color: #006699;" href="mailto:<?= $HELP_EMAIL ?>"><?= $HELP_EMAIL ?></a></p>
		   </div>
			</td></tr>
		</table>
	</div>
<!-- end left column. -->
				
<!-- start main body -->
<div id="content_main">

<!-- start  photo section -->
<div id=photos>
