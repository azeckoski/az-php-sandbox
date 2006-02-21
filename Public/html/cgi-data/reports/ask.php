<html>
<head>
<title>Ask Sakai:  Contact Us requests</title>

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
 border: 1px solid #ffcc33;
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
 <tr><td><img src="http://www.sakaiproject.org/images/stories/conferenceLogos/logoslate160x89.jpg" height=59 width=110  border=0><br />Information Requests
</td>
<td>
  <table class=legend cellpadding=0 cellspacing=0>
  
  <tr><td  class=tableheader><strong>Category</strong></td><td  class=tableheader><strong>Assigned to:</strong></td></tr>
  <tr><td class=cat>Sakai, SEPP, SCA, Other</td><td class=who>Mary Miles</td></tr>
  <tr><td class=cat>Tech</td><td class=who>Anthony Whyte</td></tr>
  <tr><td class=cat>Web</td><td class=who>Susan Hardin</td></tr> 
  <tr><td colspan=2><form name="ask_sakai"  method="post"  action="<?php echo $_SERVER['PHP_SELF'];?>">

            <select name="report" id="report">
                <option value="">-- Select Report--</option>
                <option value="1"> by Entry Date</option>
                <option value="2">by General</option>
                <option value="3">by Tech</option>
		       <option value="4">by Sakai Education Partners</option>
                <option value="5">by Conference</option>
                <option value="6">by Web</option>

             
        </select>
			  <input type="submit" name="submit" value="go">
			  
	  </form></td></tr>
  </table>
  </td></tr>
</table>
<?php


   
	  
	  	  $dbhost = "bengali.web.itd.umich.edu";

$dbname = "sakai";

$dbuser = "sakai";
$dbpass = "mujoIII"; 


$db = mysql_connect("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname",$db);


	if(!$_POST['report'])
	$_POST['report']='1';
	


	  
switch ($_POST['report'])
{ 
case 1: 
	  $sql = 'SELECT * FROM ask_sakai ORDER BY date DESC';
	  
	  $reportname='All Requests by Date';

break;
case 2:
	  $sql = 'SELECT * FROM ask_sakai where category like "Sakai" ORDER BY date DESC';
	  	  $reportname='General Sakai Requests';
break;
case 3:
	  $sql = 'SELECT * FROM ask_sakai where category like "SEPP" ORDER BY date DESC';
	  	  $reportname='Sakai Partner Education Partners Requests';
break;
case 4:
	  $sql = 'SELECT * FROM ask_sakai where category like "SCA" ORDER BY date DESC';
	  	  $reportname='SCA Requests';
break;
case 5:
	  $sql = 'SELECT * FROM ask_sakai where category like "Conf" ORDER BY date DESC';
	  	  $reportname='Conference Requests';
break;
case 6:
	  $sql = 'SELECT * FROM ask_sakai where category like "Tech" ORDER BY date DESC';
break;
	  	  $reportname='Technical Requests';
case 7:
	  $sql = 'SELECT * FROM ask_sakai where category like "Other" ORDER BY date DESC';
break;
	  	  $reportname='Other Requests';
case 8:
	  $sql = 'SELECT * FROM ask_sakai where category like "Web" ORDER BY date DESC';
	  	  $reportname='Web Requests';
break;

}

	 
	  
	 $result= mysql_query($sql);
$resultsnumber=mysql_numrows($result);
$line = "1";
$row="0";


echo"<br />

 <table width=900px id=data cellspacing=2> 
		<tr><td colspan=3 align=right><h3>Current Report:</h3></td><td colspan=4 align=left class=report><h4>$reportname</td></tr>

<tr class=tableheader>
	<td>ID</td>
	<td>Timestamp</td>

<td class=labe>Contact Info</td>
	<td>Institution</td>
	<td>Category</td>

<td>Subject</td>
<td>Description</td>
</tr>
";





while($links=mysql_fetch_array($result))
{
$row++; 
$id=$links["id"];
$date=$links["date"];
$name=$links["Name"];
$inst=$links["Institute"];
$phone=$links["Phone"];
$emailadd=$links["email"];
$subject=$links["subject"];
$category=$links["category"];
$desc=$links["descr"];


if ($line == 1) {   	
	echo "<tr id=oddrow valign=top>";
   $line='2';

} else {
	echo "<tr id=evenrow valign=top>";
	$line='1';
}
	echo"
	<td class=line_no>$row</td>
	<td width=60px>$date</td>
	<td><strong>$name</strong><br />$emailadd<br />$phone</td>
	<td width=90px>$inst</td>
	<td>$category</td>

<td width=100px><strong>$subject</strong></td>
<td width=250px>$desc</td>
</tr>
";

 //end row, so change color   


} //end of while


echo"</table>";


?>

</body>
</html>
