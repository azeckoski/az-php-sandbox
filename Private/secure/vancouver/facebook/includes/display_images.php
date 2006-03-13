<?php

// print the images

		while($links=mysql_fetch_array($searchresult))
		{
		
		$add_url="1";
		$id=$links["id"]; 
		$first=$links["First"]; 
		$last=$links["Last"]; 
		$institution=$links["Institution"]; 
		$emailadd=$links["email"];
		$filename=$links["pict"];
		
		$filename=ereg_replace(' ', '%20', $filename);
		$interests=$links["interests"];
		$url=$links["url"];
		if ($url=='')
		$add_url="0";
	
$pdID=$id;

echo "<div id=frame>";
echo"<a href=\"javascript:popup('popup_view.php?id=$id','$pgID','350','500');\" >";
		imageResize($filename, "90", "");
	echo "</a>";	
echo "<div id=about><div class=name>"; 
if ($add_url=='1') {
//user provided a personal url - add it behind the globe image link
echo"<a href=\"$url\" target=\"blank\"><img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=\"0\" height=10px width=10px></a>";
}


echo" $first $last</div>
<div class=institute>$institution</div>";

//echo"<div class=interests>$interests</div>";
echo"</div>
		
	
	 </div>";  }




?>