<?php # Script 3.16 - dateform.php

// This function makes three pull down menus for the months, days, and years.
function make_calendar_pulldown($this_month = NULL, $today = NULL, $year = NULL) {

	// Make the months array.
	$months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	
	// Make the pull down menus.
	echo '<select name="month">';
	foreach ($months as $key => $value) {
		echo "<option value=\"$key\"";
		if ($value == $this_month) {
			echo ' selected="selected"';
		}
		echo ">$value</option>\n";
	}
	echo '</select>
	<select name="day">';
	for ($day = 1; $day <= 31; $day++) {
		echo "<option value=\"$day\"";
		if ($day == $today) {
			echo ' selected="selected"';
		}
		echo ">$day</option>\n";
	}
	echo '</select>
	<select name="year">';
	
	if (!isset($year)) {
		$year = date('Y');	
	}
	$end = $year + 1;
	while ($year <= $end) {
		echo "<option value=\"$year\">$year</option>\n";
		$year++;
	}
	echo '</select>';
} // End of the make_calendar_pulldown() function.


$dates = getdate();
make_calendar_pulldown ($dates['month'], $dates['mday'], $dates['year']); // Make the calendar.
	
?>