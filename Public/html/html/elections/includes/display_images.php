<?php

// print the images
echo"<tr><td width=100% valign=top> ";

		while($links=mysql_fetch_array($searchresult))
		{
		
		$add_url="1";
		$id=$links["id"]; 
		$first=$links["First"]; 
		$last=$links["Last"]; 
		$institution=$links["Institution"]; 
		$emailadd=$links["email"];
		$filename=$links["pict"];
		$bio=$links["bio"];
		$platform=$links['platform'];
		//if ($url=='')
		//$add_url="0";
	$pgID='bio' . $id;
	$url='bio_popup.php?id=' . $id;

echo "<div width=100%>";


		imageResize($filename, "120", "");
		
echo "<div id=about><div class=name>"; 
//if ($add_url=='1')
//user provided a personal url - add it behind the globe image link
//echo"<a href=\"$url\" target=\"blank\"><img src=\"../../../images/M_images/weblink.png\" border=0 height=10px width=10px></a>";




echo"<strong>Nominee:</strong><a href=\"javascript:popup('$url','$pgID','400','500');\"><strong>$first $last</strong><a/><br /><br /></div>
<div class=institute><strong>Organization:</strong>  $institution
</div>
<div class=interests><strong>Bio:</strong><br />$bio</div>
<div class=interests><strong>Platform:</strong><br />$platform<br /><br /><br /></div>
</div> 
		
	
	 </div>";  } //frame



echo "</td></tr>";  //box

?>