#!/usr/bin/php
<?php
if ($argc == 2)
{
	$str = $argv[1];
	$arr = array_filter(explode(" ", trim($str)), "strlen");
	$i = 0;
	foreach ($arr as $str)
	{
		printf("$str");
		if ($i + 1 < count($arr))
			printf(" ");
		else
			printf("\n");
		$i++;
	}
}
?>
