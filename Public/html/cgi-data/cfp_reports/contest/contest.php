<html>
<head>
<title>Sakai SEPP Conference Theme Ideas</title>

<link href="../../conferenceDec_04/SEPP_NewOrleans/style/seppConf.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
a {  font-family: Arial, Helvetica, sans-serif; color: #003366}
body {background:#fff;  font-family: Arial, Helvetica, sans-serif; font-size: 90%}
p {  font-family: Arial, Helvetica, sans-serif; font-size: 90%}
h1 {  font-family: Arial, Helvetica, sans-serif; font-size: 90%}
a:hover {  font-family: Arial, Helvetica, sans-serif; color: #996633; text-decoration: none}
table {padding:0; margin:0; font-size: 85%; font-family: Arial, Helvetica, sans-serif;}
tr{ border-bottom:0px solid #ccc; }
td{ v-align:top;  border-bottom:1px solid #ccc; padding: 2px 10px 2px 10px;}
.main td{   border-bottom:0px solid #ccc; padding: 2px 10px 2px 10px;}
#evenrow{background: #eee; border-top:1px solid #ccc; }
#oddrow{background: #FAF6EB;  border-top:1px solid #ccc; }
.header {  border:none; font-style: Arial, Helvetica, san serif; color: #330033;}
.number {text-align: left; font-style: Arial, Helvetica, san serif; color:#000}
.center {text-align: center;}
.nowrap {white-space: nowrap;}
.line_no{color:#FFA333;}
.tableheader{ background:#ffcc33; font-weight: bold; border:0px solid #eee; }
.error {color: #330033;  margin: 30px 40px;}
.error {color: #330033; border:none;}
.comments {width: 300px;}
form input, form select{font-size:90%;}
.legend {
font-family: Arial;
 border: 0px solid #ffcc33;
 padding: 0px;
 }
td .cat{background:#FFEFBF;}

td .who {background: #FAF6EB;}
 
.cat {
color: #000;
font-weight: bold;}

#data {font-size: 80%;}
.report {font-size: 12px; color:#666;}
-->
</style>
</head>
<body>

 <table class=main cellspacing="0"  border="0"> 
 <tr><td><img src="http://www.sakaiproject.org/images/stories/conferenceLogos/logoslate160x89.jpg" height=59 width=110  border=0></td><td>Conference Logo/Theme Ideas
</td>
</tr>
</table>
<?php


   
	  
	  	  $dbhost = "bengali.web.itd.umich.edu";

$dbname = "sakai";

$dbuser = "sakai";
$dbpass = "mujoIII"; 


$db = mysql_connect("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname",$db);


	  $sql = 'SELECT * FROM contest ORDER BY id DESC';
	  	  $reportname='All Entries';
 
	  
	 $result= mysql_query($sql);
$resultsnumber=mysql_numrows($result);
$line = "1";
$row="0";


echo"<br />

 <table  id=data cellspacing=2> 
		<tr><td colspan=2 align=right><h3>Current Report:</h3></td>
		<td colspan=1 align=left class=report><h4>$reportname</td></tr>

<tr class=tableheader>
	<td>ID</td>
	<td>name</td>

<td class=labe>emai</td>
	<td>suggestion</td>
	<td>imagefile</td>
	<td>approved</td>


</tr>
";





while($links=mysql_fetch_array($result))
{
$row++; 
$id=$links["id"];
$name=$links["name"];
$email1=$links["email1"];
$idea=$links["idea"];
$file=$links["file"];
$approved=$links["approved"];



if ($line == 1) {   	
	echo "<tr id=oddrow valign=top>";
   $line='2';

} else {
	echo "<tr id=evenrow valign=top>";
	$line='1';
}
	echo"
	<td class=line_no>$row</td>
	<td>$name</td>
	<td>$email1</td>
	<td width=120px>$idea</td>
	<td>";
	if ($file == 'none') {  
	echo "n/a</td>";
	}
	else {
	
	echo "<a href=\"../$file\"><img src=\"../$file\" height=50px width=50px></a></a>";
	}

echo "<td>$approved</td>
</tr>
";

 //end row, so change color   


} //end of while


echo"</table>";


?>

</body>
</html>
