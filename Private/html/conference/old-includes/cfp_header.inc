<?php 
//session_destroy();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<link href="../../templates/vancouver/css/template_css.css" rel="stylesheet" type="text/css"/>
<link href="../../templates/vancouver/css/template_CFPform_css.css" rel="stylesheet" type="text/css"/>
</head>
<style type="text/css">


#activity{
color:#000;

}

 #activity td{
padding: 0px 5px;
color:#000;


}


</style>
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
              <div align="left" style="padding: 10px; background: #eee; font-size: 10px; color: #000; margin-top: 20px;"> If you experience any problems during the proposal submission process, please contact <a href="mailto:shardin@umich.edu">shardin@umich.edu</a>
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
<div id="topmenu" align=right> <a href="index.php">sakaiproject.org</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
<!-- end top menu.  -->
<!-- start image header -->
<!-- end image header -->
<div id="container_inner">
<!-- start left column. -->
<div id="leftcol">
  <!-- start left column. -->
  <table cellpadding="0" cellspacing="0" class="moduletable">
    <tr>
      <th valign="top">Vancouver '06</th>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr align="left">
            <td><a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=169&amp;Itemid=518" class="mainlevel" id="active_menu">Conference Home</a></td>
          </tr>
          <tr align="left">
            <td><a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=170&amp;Itemid=519" class="mainlevel" >Call for Proposals</a></td>
          </tr>
          <tr align="left">
            <td><a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=171&amp;Itemid=520" class="mainlevel" >Registration</a></td>
          </tr>
          <tr align="left">
            <td><a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=174&amp;Itemid=521" class="mainlevel" >Program</a></td>
          </tr>
          <tr align="left">
            <td><a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=173&amp;Itemid=523" class="mainlevel" >Technical Demos</a></td>
          </tr>
          <tr align="left">
            <td><a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=178&amp;Itemid=524" class="mainlevel" >BOF Meetings</a></td>
          </tr>
          <tr align="left">
            <td><a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=175&amp;Itemid=525" class="mainlevel" >Hotel Reservations</a></td>
          </tr>
          <tr align="left">
            <td><a href="http://www.sakaiproject.org/index.php?option=com_content&amp;task=blogcategory&amp;id=176&amp;Itemid=526" class="mainlevel" >About Vancouver</a></td>
          </tr>
          <tr align="left">
            <td><span class="mainlevel" ></span></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <div id=activity>
    <!-- start activity div -->
    <table cellpadding="0" cellspacing="0" class="moduletable">
      <tr>
        <th valign="top"> Proposal Activity</th>
      </tr>
      <tr>
        <td align=left><strong>Proposal Activity for:</strong><br />
          <?php $first=$_SESSION['firstname']; $last=$_SESSION['lastname'] ;  $num_pres=$_SESSION['num_pres'];
    	         echo " $first $last<br /><br /><strong>Presentations: </strong>$num_pres"; ?></td>
      </tr>
      <tr>
        <td align=left><?php $num_demo=$_SESSION['num_demo'];                                 
			echo "<br /><strong>Demos: </strong>$num_demo"; ?>
          <br />
          <br /></td>
      </tr>
    </table>
  </div>
  <!-- end activity div -->
</div>
<!-- end left column. -->
<!-- start content top wrapper -->
<!-- end content top wrapper -->
<!-- start main body -->
<div id="content_main">
