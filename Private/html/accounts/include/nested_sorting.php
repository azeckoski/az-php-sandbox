<?php
/* file: nested_sorting.php
 * Created on Apr 6, 2006 by @author az
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
/*
 * These functions provide methods for nested array sorting
 */

// alpha sort an array by a value in the nested array and return the sorted version
function nestedArraySort($a1, $key){
	$compare = create_function('$a,$b','return strcasecmp( $a["'.$key.'"], $b["'.$key.'"] );');
	usort($a1, $compare);
	unset($compare);
	return $a1;
}

// reverse sort an array by a value in the nested array and return the sorted version
function nestedArraySortReverse($a1, $key){
	$compare = create_function('$a,$b','return strcasecmp( $b["'.$key.'"], $a["'.$key.'"] );');
	usort($a1, $compare);
	unset($compare);
	return $a1;
}

function nestedArrayNumSort($a1, $key){
	$compare = create_function('$a,$b','return ($a["'.$key.'"] < $b["'.$key.'"]) ? -1 : 1;');
	usort($a1, $compare);
	unset($compare);
	return $a1;
}

// reverse sort an array by a value in the nested array and return the sorted version
function nestedArrayNumSortReverse($a1, $key){
	$compare = create_function('$a,$b','return ($b["'.$key.'"] < $a["'.$key.'"]) ? -1 : 1;');
	usort($a1, $compare);
	unset($compare);
	return $a1;
}

?>