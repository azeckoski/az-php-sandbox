<?php

//*****************************************//

//Sakai Facebook Version 3 Vancouver
//February 2006

//shardin@umich.edu
//
//print_largePhotos.php   for printing out to posters
// width is 400px
//*****************************************//


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sakai Conference Facebook</title>
<style>
body {
background: #fff;
font-family: Arial;
font-size: 18px;
font-weight: normal;
color: #000;

}
#photos {
width: 800px;
padding:5px;
align: center;

}
#photos a, #photos a:link, #photos a:visited{
font-weight: normal;
color: #000;

}
#photos a:hover{
font-weight: normal;
color: #ffcc33;

}
#header {background: #fff;
text-align: center;

}


#header {background: #fff;
text-align: center;

}

#frame{
float: left;
width: 380px;
height: 470px;
background: #fff;
padding: 2px;
text-align: center;


}



#frame img {align: center;
padding: 1px;
border: 1px solid #eee;
vertical-align: bottom;

}
#label {

height: 20px;

}
</style>
</head>

<body>




<?php 

require "includes/mysqlconnect.php";
require "includes/resize.php";

		$sql="SELECT * FROM facebook_vancouver ORDER by id";
		

			$result= mysql_query($sql);
		$resultsnumber=mysql_numrows($result);

echo "<div id=photos><div id=header><h1>Sakai Conference Facebook</h1>
<p>Baltimore, MD - June 8-10, 2005</p></div><br />
<p><strong>Display photos by:</strong> <a href=view_recent.php>by Recent Entry</a>  --  
<a href=view_lastname.php> Last Name</a>  --  
<a href=view_institution.php> Institution</a><br /><br /><a href=print_largePhotos.php>Print Gallery of Large Images</a></p>";



		while($links=mysql_fetch_array($result))
		{
		$id=$links["id"]; 
		$first=$links["First"]; 
		$last=$links["Last"]; 
		$institution=$links["Institution"]; 
		$emailadd=$links["email"];
		$filename=$links["pict"];
		


echo "<div id=frame>";

imageResize($filename, "400", "");
echo "<div id=label> <br />$first $last<br />$institution<br /><br /></div></div>";


		}
		echo "</div>";
		
		




?>

</body>
</html>