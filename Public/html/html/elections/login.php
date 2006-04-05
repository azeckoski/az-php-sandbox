<?php

//*****************************************//

//Sakai Facebook Version 3 Elections
//October 2005

//shardin@umich.edu
//

//*****************************************//


//get page header



if (isset($_POST['submit'])) {

	//	include ('includes/authorize.php');
	
if ((!$_POST["username"]) OR (!$_POST["password"])){

$message[]="<li> enter your username and password</li>";
}
//if (!$_POST["password"]) {

//$message[]="<li> enter your password</li>";
//}

else{




require_once('includes/mysqlconnect.php');

$user=$_POST["username"];
$password=$_POST["password"];


	//query database for all austin images and data
 $sql = "SELECT * FROM elections_auth where email='$user'";
	$result= mysql_query($sql);
	
	$links=mysql_fetch_array($result);
	$emailadd=$links['email'];
	$user_id=$links['id'];
	$pass=$links['password'];

	
	


if ($password==$pass)  {

session_id('$name');
session_start();
$_SESSION['mysession']=$name;

header("Location:add_entry.php?logged=1&id=$user_id");
}

else {
$message[]="<li>invalid username or password</li>";

}

}
}

 require_once('includes/election_submitHeader.inc');
?>
        
          <!--  image content begins -->

           <td valign=top><table  class="centerContent" valign=top width="100%">
           <tr><td><table><tr><td align=center><strong>Login </strong></td></tr>
           
       <?php 
       
       if ($message) {

//form errors 


	echo "<tr><td colspan=2> <div class=\"errors\" align=\"left\"><ul>";	
	foreach ($message as $key => $value) {
		echo $value;	
	}
	echo "</ul></div></td></tr> ";
	}








?>
		 

        <tr><td valign=top>      <form enctype="multipart/form-data" method=post action="<?php echo $_SERVER[PHP_SELF]; ?>" name="login" >



		Username
		<input name="username" type="text" class="inputbox" alt="username" size="25" />
		<br /><br />
		Password		

		<input type="password" name="password" class="inputbox" size="25" alt="password" />
		
		<br />
		<input type="submit" name="submit" class="button" value="submit" />
			</form>

		</td>
		
	</tr>
		

	
	
	<?php
        
        
	


// display content 
?>
  </table></div></td></tr></table>
	      </td>
    </tr>          <!--  image content ends -->

  </table>
  </td>
   </tr>  <!-- Menus and Main Content - Row Ends and Footer begins -->


  <?php 
  //get page footer
  require_once('includes/footer.inc');
?>