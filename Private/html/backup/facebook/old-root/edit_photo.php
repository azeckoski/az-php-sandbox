<?php //edit/change the photo for the facebook entry$logged=$_POST['logged'];$update=$_POST['update'];$user_id=$_POST['id'];//echo $user_id;if (isset($_POST['submit'])) {if ($_POST['update']==0) {include('includes/update_photo.php');}}require ('includes/mysqlconnect.php');		$sql="SELECT * FROM facebook_vancouver where id='$user_id'";		$result= mysql_query($sql);				while($links=mysql_fetch_array($result))		{				$add_url="1";		$id=$links["id"]; 		$first=$links["First"]; 		$last=$links["Last"]; 		$institution=$links["Institution"]; 		$emailadd=$links["email"];		$filename=$links["pict"];		$interests=$links["interests"];		$url=$links["url"];			    			}		//remove the html tags before displaying in the textarea of the form//get page headerrequire_once('includes/facebook_headernew.inc');		//echo back the entry to the user require "includes/resize.php";require "includes/mysqlconnect.php";		$sql="SELECT * FROM facebook_vancouver where id='$user_id'";		$result= mysql_query($sql);				while($links=mysql_fetch_array($result))		{				$id=$links["id"]; 		$first=$links["First"]; 		$filename=$links["pict"];		//if ($url=='')		//$add_url="0";?>	<?php				echo "<div>";		imageResize($filename, "120", "");		?>							<?php		echo "<div id=about><div class=name>"; if ($add_url=='1')//user provided a personal url - add it behind the globe image linkecho"<a href=\"$url\" target=\"blank\"><img src=\"../../../images/M_images/weblink.png\" border=0 height=10px width=10px></a>";echo"<a href=\"javascript:popup('bio181.php','$pgID','500','600');\"><img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 height=10px width=10px></a>";echo"<br /></div></div> 				 </div>";  }?>               	<div id="cfp"><form id=form1 enctype="multipart/form-data" action="<?php echo $_SERVER[PHP_SELF]; ?>" method="post"><table width="400px" cellpadding=0 cellspacing=0><div class="contentheading" style="color: #336699;">Change Facebook Photo</div><tr><td class=label><br /><br />* Upload New Photo:<input name="userfile" type="file" accept="image/jpg, image/gif, image/png, image/bmp"/><br /></td></tr><tr><td class=label><input type="submit" name="submit" value="Submit" /><input type="hidden" name="logged" value="1"><input type="hidden" name="update" value="0">    <input type="hidden" name="MAX_FILE_SIZE" value="100000" />   <td> &nbsp;<input type="hidden" name="id" value="<?php echo $user_id;?>" /></td></tr>   </table> <div> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br />   </div></form>  </div>  <?php   //get page footer  require_once('includes/facebook_footernew.inc');?>