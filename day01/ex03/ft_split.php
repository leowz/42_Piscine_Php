#!/usr/bin/php
<?php
function ft_split($str)
{
	$arr = array_filter(explode(" ", $str), "strlen");
	sort($arr);
	return $arr;
}
?>
