<?php 
function time_convert($time,$type){
  $time_hour=substr($time,0,2);
  $time_minute=substr($time,3,2);
  $time_seconds=substr($time,6,2);
  if($type == 1):
  	// 12 Hour Format with uppercase AM-PM
  	$time=date("g:i A", mktime($time_hour,$time_minute,$time_seconds));
  elseif($type == 2):
  	// 12 Hour Format with lowercase am-pm
  	$time=date("g:i a", mktime($time_hour,$time_minute,$time_seconds)); 
  elseif($type == 3):
  	// 24 Hour Format
  	$time=date("H:i", mktime($time_hour,$time_minute,$time_seconds)); 
  elseif($type == 4):
  	// Swatch Internet time 000 through 999
  	$time=date("B", mktime($time_hour,$time_minute,$time_seconds)); 
  elseif($type == 5):
  	// 9:30:23 PM
  	$time=date("g:i:s A", mktime($time_hour,$time_minute,$time_seconds));
  elseif($type == 6):
  	// 9:30 PM with timezone, EX: EST, MDT
  	$time=date("g:i A T", mktime($time_hour,$time_minute,$time_seconds));
  elseif($type == 7):
  	// Different to Greenwich(GMT) time in hours
  	$time=date("O", mktime($time_hour,$time_minute,$time_seconds)); 
  endif;
  return $time;
};

?>

 
