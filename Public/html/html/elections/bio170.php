<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Sakai Board Elections: Lois Brooks</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript" type="text/javascript">
<!--
function popup(url,name,w,h){
settings="width=" + w + ",height=" + h + ",scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes";
win=window.open(url,name,settings);
}
//-->
</script>
<style type="text/css">

</style>
<head>
<body>
<?php
require('includes/mysqlconnect.php');

require('includes/resize.php');

	$query  = "SELECT * FROM elections WHERE id ='170'";
$searchresult = mysql_query($query);

// print the images
echo"<table  width=100% style=\"font-family: arial; font-size:12px; \">
<tr><td style=\"width: 290px; border:1px solid #ccc; \" valign=middle height=50px><img src=\"http://www.sakaiproject.org/conferenceJune_05/regindex_files/logoslate160x89.jfif\" height=39 width=70 align=middle>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> Sakai Board Nominee</strong></td></tr>
<tr><td><div id=box><br /> ";

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
		$platform=$links["platform"];
		//if ($url=='')
		//$add_url="0";

echo "<div id=frame><table style=\"font-family: arial; font-size:12px; \" ><tr><td width=124px>";

		imageResize($filename, "120", "");
		
echo "</td><td align=left><div id=about><div class=name>"; 
//if ($add_url=='1')
//user provided a personal url - add it behind the globe image link
//echo"<a href=\"$url\" target=\"blank\"><img src=\"../../../images/M_images/weblink.png\" border=0 height=10px width=10px></a>";

echo"<strong>$first $last</strong><br /></div>
<div class=institute>$institution</div></td></tr>
<tr><td colspan=2>
<div class=interests><br /><br /><strong>Bio:</strong><br />$bio</div><br />
<div class=interests><strong>Platform:</strong><br />$platform<br /><br /><br /></div></div>
		</td></tr></table>
	
	 </div>";  }



echo "</div></td></tr>";  //box

?>
</body>
</html>