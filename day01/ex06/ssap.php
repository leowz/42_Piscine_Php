#!/usr/bin/php
<?php
if ($argc > 1)
{
	$arr = [];
	for ($i = 1; $i < $argc; $i++)
	{
		$rawstr = trim($argv[$i]);
		$tmp = array_filter(explode(" ", $rawstr), "strlen");
		$arr = array_merge($arr, $tmp);
	}
	sort($arr);
	foreach ($arr as $str)
		printf("$str\n");
}
?>
