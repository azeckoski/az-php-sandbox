<?php
function WriteDateSelect($BeginYear = 0, 
                         $EndYear = 0, 
                         $IsPosted = true,
                         $Prefix = '')
{
  if (! $BeginYear)
  {
    $BeginYear = date('Y');
  }
		
  if (! $EndYear)
  {
    $EndYear = $BeginYear;
  }
	
  $Year = $IsPosted 
          ? (int) $_POST[$Prefix . 'Year']
          : (int) $_GET[$Prefix . 'Year'];
  $Month = $IsPosted 
          ? (int) $_POST[$Prefix . 'Month']
          : (int) $_GET[$Prefix . 'Month'];
  $Day = $IsPosted 
          ? (int) $_POST[$Prefix . 'Day']
          : (int) $_GET[$Prefix . 'Day'];
	
  echo '<select name="', $Prefix, 'Year">
         ';
	
  for ($i = $BeginYear; $i <= $EndYear; $i++)
  {
    echo '<option ';
		
    if ($i == $Year)
      echo 'selected="yes"';
			
    echo '>', $i, '</option>
         ';
  }
	
  echo '</select>-
        <select name="', $Prefix, 'Month">
          ';	

  for ($i = 1; $i <= 12; $i++)
  {
    echo '<option ';
		
    if ($i == $Month)
      echo 'selected="yes"';
			
    echo '>', $i, '</option>
         ';
  }

  echo '</select>-
        <select name="', $Prefix, 'Day">
          ';	

  for ($i = 1; $i <= 31; $i++)
  {
    echo '<option ';
		
    if ($i == $Day)
      echo 'selected="yes"';
			
    echo '>', $i, '</option>
         ';
  }

  echo '</select>
       ';
  return;
}


?>