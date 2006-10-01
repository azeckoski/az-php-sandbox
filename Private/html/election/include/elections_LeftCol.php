<?php
/*
 * Created on Aug 14, 2006
 * Modified by Susan Hardin shardin@umich.edu
 * from the Facebook code for use on Sakai Board Elections
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 
// main SQL to fetch all elections items
$from_sql = " from elections_entries E1 left join users U1 on U1.pk=E1.users_pk";

// the main user fetching query
$users_sql = "select E1.*, U1.username, U1.email, U1.firstname, " .
	"U1.lastname, U1.institution " .
	$from_sql . $sqlsearch . $sqlsorting ;
//print "SQL=$users_sql<br/>";
$list_result = mysql_query($users_sql) or die('User query failed: ' . mysql_error());

?>

<div class="moduletable">
    <div id=electionsIcon><img src="include/images/newBlackHat_white.jpg" alt="sakai hat image" />
     	</div>
      
   <table cellpadding="0" cellspacing="0" class="moduletable">
     <tr><td><br/><strong>Display:</strong><br/>
     
  
	      <a href="index.php">View Thumbnails</a>
	    </td></tr>
	<?php if (($PAGE_NAME=="Candidate Info") || ($PAGE_NAME=="Elections Intro"))  {   ?>
	 <tr><td><br/><strong>2006 Candidates</strong>
			
<?php 
$line = 0;
while($item=mysql_fetch_array($list_result)) {
	$line++;
	$fullname = $item['firstname']." ".$item['lastname'];

	// shorten the long items
	$short_inst_name = $item['institution'];
	if (strlen($short_inst_name) > 45) {
		$short_inst_name = substr($short_inst_name,0,40) . "...";
	}
	
?> 
     <br/><a href="view.php?id=<?=$item['users_pk'] ?>"><?= $fullname ?></a>
	
	<?php 
		} 
	}   ?>		
      </td></tr> 
        <tr><td>&nbsp;</td>   </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="moduletable">
		<tr><td>&nbsp;</td></tr>
	
		<tr><td valign="top" style="text-align:left"><strong>Nominee Entry</strong></td></tr>
			<tr><td>
				<ul>
                 <li> <a href="add_entry.php">Submit/Edit Entry</a> </li>
               </ul>
               	
              </td>
			</tr>
			<?php   
			if (($allowed) && ($PAGE_NAME=='Candidate Entry')) {	 ?>
				
		<tr><td valign=top>
            <br /><div id=help>
			<p><strong>Need help?</strong><br />If you experience problems adding your information for the Sakai Board Elections, 
			please email 
			 <a style="color: #006699;" href="mailto:<?= $HELP_EMAIL ?>">webmaster</a> .
			<!-- <a style="color: #006699;" href="mailto:<?= $HELP_EMAIL ?>"><?= $HELP_EMAIL ?></a> -->
		   </p></div>
		   
		   
		</td></tr>
			
		<?php }	?>
		<tr><td><div style="padding:40px 0px;">&nbsp;</div>
		
		</td></tr>
		
		</table>
   </div>
   <div class="moduletable"> </div>
   </td>
   <td class="mainbody" width="100%">
      <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="contentpane">
           <tr> <td width="100%" valign="top" class="contentdescription" colspan="2">
 
			<div class="componentheading"><br/> Sakai Board Candidates for the November 2006 Election </div>
