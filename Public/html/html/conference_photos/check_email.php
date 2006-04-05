<?php

require "mysqlconnectReg.php";

$myemail=$_POST['email'];
		
		$sql="SELECT email FROM seppConf where confID='June05'";
		$result= mysql_query($sql);
		$resultsnumber=mysql_numrows($result);

		while($links=mysql_fetch_array($result))
		{
		$id=$links["id"]; 
		$emailadd=$links["email"];
		$first=$links["First"];
		if ($emailadd == $myemail) 
		$found="TRUE";
		}
		
		//no previous entry 
			if (!$found)  {
			
	die("<div id=box style=height:300px;><div class=errors><p><strong>Entry Error:</strong>  <br />
	<br />You must be a registered conference attendee to add photos to our conference album. <br /><br />
	 </p>
		  			
		  			<p>Please use your browser's Back button and verify that your email<br />
		  			address was entered correctly.  If you are registered for the conference<br />
		  but continue to receive this error message, please report the problem<br /> to the webmaster</p></div></div>");
		  }
		  
?>