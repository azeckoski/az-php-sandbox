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
                          <td><a href="http://sakaiproject.org/index.php?option=com_content&amp;task=view&amp;id=418&amp;Itemid=567" class="mainlevel" >Conference home</a></td>
                        </tr>
                  	<tr align="left">
                          <td><a href="http://sakaiproject.org/index.php?option=com_content&task=view&id=420&Itemid=593" class="mainlevel" >Help</a></td>
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
<li><strong>Showcase/Poster session</strong>- We are not soliciting proposals for Showcase/Poster sessions at this time.  We do, however, encourage you to create a poster  that showcases your campus implementation or toolset. You can use the template we will provide (sometime in October) or use your own design. We will provide more details in October. </li></ul><br />
<p>&nbsp;</p></div>
     <?php }  ?>               
                    </td>
                  <td class="mainbody" width="100%">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="contentpane">
                      <tr>
                        <td width="100%" valign="top" class="contentdescription" colspan="2">
 
<div class="componentheading"><br/> 6th Sakai Conference - 
                        December 5-8, 2006  -
                        Atlanta, Georgia </div>
