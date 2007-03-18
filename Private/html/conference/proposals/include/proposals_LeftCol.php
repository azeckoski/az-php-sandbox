<?php
/*
 * Created on Aug 14, 2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
             
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 
  <tr>
     <td valign="top" class="left">
    <br/><a href="<?=$CONF_URL?>" class="mainlevel">Conference home</a><br/><br/><br/>
                     
                        <?php 
	$sql = "select CP.title, CP.pk from conf_proposals CP " .
		"where CP.users_pk='$User->pk' and CP.confID = '$CONF_ID'";
	//print "SQL=$sql<br/>";
	$result = mysql_query($sql) or die("Query failed ($sql): " . mysql_error());

	if(mysql_num_rows($result) > 0) {
		// print the nice header
?>
	  <div style="padding:10px;"></div><div class="user_proposals">
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
?><div class="padding50"> &nbsp;</div><div class="padding50"> &nbsp;</div>
  
          </td>
        
       <td class="mainbody" width="100%" valign="top">
              <div class="componentheading"><br/><u>Call for Papers or Proposals</u></div><br/>
             
                      

