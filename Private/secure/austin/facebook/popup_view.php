<? $id=$_GET['id'];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Sakai Conference - Austin Texas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="http://www.sakaiproject.org/templates/austin05/css/template_css.css" type="text/css"/>

<script language="JavaScript" type="text/javascript">
<!--
function popup(url,name,w,h){
settings="width=" + w + ",height=" + h + ",scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes";
win=window.open(url,name,settings);
}
//-->
</script>
<style type="text/css">
#about, .name, .institute, .interests{
padding: 0px;

margin:0px;
}
.name {
  font-family      : Arial, Helvetica, sans-serif;
font-size: 12px;

font-weight: bold;
padding: 2px 0px 0px 0px;


}
.institute{ font-size: 12px;
font-weight: bold;
color:#666;
padding: 0px 0px;

}
.interests {
font-size: 11px;
padding: 5px  0px 0px 0px;
text-align:left;
  font-family      : Arial, Helvetica, sans-serif;

}

</style>
<head>
<body>
<?php
require('includes/mysqlconnect.php');

require('includes/resize.php');

	$query  = "SELECT * FROM facebook_austin WHERE id ='$id'";
$searchresult = mysql_query($query);

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
		

// print the images
echo"<table  width=100% style=\"font-family: arial; font-size:12px; \">
<tr><td style=\"width: 290px; border:1px solid #ccc; \" valign=middle height=50px>
<img src=\"http://www.sakaiproject.org/conferenceJune_05/regindex_files/logoslate160x89.jfif\" height=45 width=70 align=middle>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Sakai Conference - Austin Texas</strong></td></tr>
<tr><td><div id=box><br /> ";

		

echo "<div id=frame>";

		imageResize($filename, "250", "");
		
echo "<div id=about><div class=name>"; 
if ($add_url=='1')
//user provided a personal url - add it behind the globe image link
echo"<a href=\"$url\" target=\"blank\"><img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 height=10px width=10px></a>";


//echo"<a href=\"javascript:popup('popup_view.php?id=$id','$pgID','300','400');\">
//<img src=\"http://sakaiproject.org/images/M_images/weblink.png\" border=0 height=10px width=10px></a>
//";
//echo"<a href=\"$url\" target=\"blank\"><img src=\"../../../images/M_images/weblink.png\" border=0 height=10px width=10px></a>";


echo" $first $last</div><div class=interests><strong>Organization:</strong></div><div class=institute>$institution</div><div class=interests><strong>interests:</strong><br />$interests</div></div>
		
	
	 </div>";  }



echo "</div>";  //box


?>
</body>
</html>