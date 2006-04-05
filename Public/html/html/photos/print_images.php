<?php

// print the images

		while($links=mysql_fetch_array($searchresult))
		{
		
		$add_url="1";
		$id=$links["id"]; 
		$name=$links["name"]; 
		$email=$links["email"]; 
		$event=$links["event"]; 
		$date=$links["date"];
		$who=$links["who"];
		$filename=$links["pict"];
		$other=$links["other"];
		$url=$links["url"];
		if ($url=='')
		$add_url="0";
	

echo "<div id=frame>";



		imageResize($filename, "150", "");


echo "<div id=about><div id=info>"; 

echo" 
<div id=fullrow><div id=photo_info><strong>Event: </strong>&nbsp;&nbsp;</div><div id=pinfo> $event</div></div>
<div id=fullrow><div id=photo_info><strong>Date:</strong> &nbsp;&nbsp;</div> <div id=pinfo>$date</div></div>
	<div id=fullrow><div id=photo_info><strong>Who:</strong> &nbsp;&nbsp;</div><div id=pinfo> $who</div></div>
	<div id=fullrow><div id=photo_info><strong>More Info:</strong> &nbsp;&nbsp;</div><div id=pinfo> $other</div></div>
	<div id=fullrow><div id=photo_info><strong>Photo by: </strong>&nbsp;&nbsp;</div><div id=pinfo> $name</div></div>";

 
	
	 if ($add_url=='1')
echo"<div id=fullrow><div id=photo_info><strong>My Photos:</strong></div><div id=pinfo><a href=\"$url\" target=\"blank\"><img src=\"../images/M_images/weblink.png\" border=0 height=10px width=10px></a></div></div>";
 
 echo "</div></div></div>";
 
 }

	 


?> 