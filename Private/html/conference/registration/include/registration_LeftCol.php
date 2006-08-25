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
                          <td><a href="<?= $CONF_URL ?>" class="mainlevel" >Conference homes</a></td>
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
		<!-- [<a style="color:red;" href="edit_proposal.php?pk=<?= $item['pk'] ?>&amp;delete=1" 
			title="Delete this proposal"
			onClick="return confirm('Are you sure you want to delete this proposal?');" >X</a>]  -->
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
                    <div class="moduletable"> </div></td>
                  <td class="mainbody" width="100%">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="contentpane">
                      <tr>
                        <td width="100%" valign="top" class="contentdescription" colspan="2">
 
<div class="componentheading"><br/> 6th Sakai Conference - 
                        December 5-8, 2006  -
                        Atlanta, Georgia </div>