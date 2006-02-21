<?php


if (isset($_POST['update'])) {



$user_id=$_POST['id'];

if (isset($_POST['day'])) {
$day=$_POST['day'];
}
else {
$day=$_POST['current_day'];
}

$start=$_POST['start'];
$end=$_POST['end'];
$room=$_POST['room'];




require ("mysqlconnect2.php");





$sql="UPDATE `cfp_vancouver_present_approved` SET `date` = NOW( ) ,
`talk_day` = '$day',
`talk_start` = '$start',
`talk_room` = '$room',
`talk_end` = '$end' WHERE `id` ='$user_id' ";

$result= mysql_query($sql);


echo "done";}

else {

echo "<br /><br />If this were working fully as it should, you would see the page refresh <br />with your changes.  For now you must go back to the<br /> previous page and refresh that page before these changes will appear.";

}
?>