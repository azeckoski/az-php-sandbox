<?php
/*
 * Created on Aug 14, 2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<div class="moduletable">
                     <div id=confLogo>
                  	</div>
                      <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr align="left">
                          <td><a href="http://www.sakaiproject.org/index.php?option=com_content&task=blogcategory&id=190&Itemid=615" class="mainlevel" >Conference home</a></td>
                        </tr>

                        <tr align="left">
                          <td><a href="<?= $TOOL_URL ?>/registration/" class="mainlevel" >Registration</a></td>
                        </tr>
                        <tr align="left">
                          <td><a href="<?= $TOOL_URL ?>/proposals/" class="mainlevel" >Proposals</a></td>
                        </tr>
                      <!--   <tr align="left">
                          <td><a href="<?= $TOOL_URL ?>/logos/" class="mainlevel" >Logo Contest</a></td>
                        </tr>  -->

	                  	<tr align="left">
                          <td><a href="http://www.sakaiproject.org/index.php?option=com_content&task=view&id=499&Itemid=611" class="mainlevel" >Help</a></td>
                        </tr>
                        <tr><td>
                        <?php 
	$sql = "select CP.title, CP.pk from conf_proposals CP " .
		"where CP.users_pk='$User->pk' and CP.confID = '$CONF_ID'";
	//print "SQL=$sql<br/>";
	$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());

	if(mysql_num_rows($result) > 0) {
		// print the nice header
?>
	<div style="padding:15px;"></div><div style="padding:3px; margin:0px;border:1px solid #232833;background:white;">
		<div><strong>Your&nbsp;Proposals:</strong></div>
<?php
	while($item=mysql_fetch_assoc($result)) {
?>
	<p><a href="edit_proposal.php?pk=<?= $item['pk'] ?>" title="Edit this proposal" ><?=  $item['title'] ?></a>
		[<a style="color:red;" href="edit_proposal.php?pk=<?= $item['pk'] ?>&amp;delete=1" 
			title="Delete this proposal"
			onClick="return confirm('Are you sure you want to delete this proposal?');" >X</a>]
	</p>
<?php
		} // end while
		echo "<hr/><p>[ <a title='Create a new proposal' href='index.php'>add a proposal</a> ]</p>";
		echo "</div>";
	} // end if
?>

                        
                        </td>
                        </tr>
                      </table>
                    </div>
  <?php if ($type=="presentation") { 
  	?>
  
                    <div class="moduletable"><div name="format_desc" id="format_desc"></div> <br/><br/><br/><p><strong>PRESENTATION FORMATS:</strong>&nbsp;</p>
<ul>
<li><strong>Panel Session</strong> - This type of session typically brings
together panelists from diverse background to address a topic from
multiple points of view.&nbsp; <br />
<br />
</li>
<li><strong>Workshop</strong> - This type of session is highly interactive, relaying skills as well as information to attendees.<br />
<br />
</li>

<li><strong>Discussion/Roundtable</strong>- This type of session involves a very
brief presentation of a topic and immediately opens for discussion of
the topic by attendees.<br />
<br />
</li>
<li><strong>Lecture/Presentation</strong>- This type of session consists mostly
of presenting information to the attendees. Sufficient time for
follow-up questions is included.<br />
<br />
</li>
<li><strong>Tool Carousel</strong>- This type of session is a highly interactive, in-depth tutorial of a tool or set of tools.<br />
<br />
</li>
<li><strong>Showcase/Poster session</strong>- We encourage you to create a poster that showcases your organization's implementation or toolset. You can use the template we will provide (sometime in March) or use your own design. Your poster will be displayed throughout the conference and a highlight of the Technical Demos and Reception </li></ul><br />
<p>&nbsp;</p></div>
     <?php }  ?>               
                    </td>
                  <td class="mainbody" width="100%">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="contentpane">
                      <tr>
                        <td width="100%" valign="top" class="contentdescription" colspan="2">
 
<div class="componentheading"><br/><?=$CONF_NAME ?> </div>
