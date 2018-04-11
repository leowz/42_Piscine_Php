#!/usr/bin/php
<?php
function ft_is_sort($arr)
{
	$arr_sorted = $arr;
	sort($arr_sorted);
	$arr_srev = array_reverse($arr_sorted);
	return ($arr === $arr_sorted || $arr === $arr_srev);
}
?>
