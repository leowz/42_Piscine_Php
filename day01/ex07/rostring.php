#!/usr/bin/php
<?php
if ($argc > 1)
{
	$str = trim($argv[1]);
	$arr = array_filter(explode(" ", $str), "strlen");
	$arr = array_merge($arr);
	if (count($arr) > 1)
	{
		for ($i = 1; $i < count($arr); $i++)
			printf("%s ", $arr[$i]);
	}
	if (count($arr) > 0)
		printf("%s\n", $arr[0]);
}
?>
