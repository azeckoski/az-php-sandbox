<?php

// print the images
echo"<div id=box><br /> ";

		while($links=mysql_fetch_array($searchresult))
		{
		
		$add_url="1";
		$id=$links["id"]; 
		$first=$links["First"]; 
		$last=$links["Last"]; 
		$institution=$links["Institution"]; 
		$emailadd=$links["email"];
		$filename=$links["pict"];
		$interests=$links["interests"];
		$url=$links["url"];
		if ($url=='')
		$add_url="0";
	

echo "<div id=frame>";

		imageResize($filename, "120", "");
		
echo "<div id=about><div class=name>"; 
if ($add_url=='1')
echo"<a href=\"$url\" target=\"blank\"><img src=\"../images/M_images/weblink.png\" border=0 height=10px width=10px></a>";


echo" $first $last</div><div class=institute>$institution</div><div class=interests>$interests</div></div>
		
	
	 </div>";  }



echo "</div>";  //box

?>