<?php

// mutli dimmension array sort by selected column
function arrayMultiSort( $array, $column, $reverse = false ){
	// if array empty
	if( !is_array($array) ) return false;

	// multisort
	foreach ($array as $row)  $result[] = $row[$column];
	@array_multisort($result, $array);

	// raw result is reversed, if $reverse is true, do nothing, else reverse result array
	if( !$reverse ) $array = @array_reverse ($array);

	// return result
	return $array;
}

?>