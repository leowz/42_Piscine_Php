#!/usr/bin/php
<?php
if ($argc > 2)
{
	$key = $argv[1];
	unset($argv[0], $argv[1]);
	$av = array_reverse($argv);
	foreach ($av as $item)
	{
		$tmp = explode(":", $item);
		if ($key == $tmp[0])
		{
			printf("%s\n", $tmp[1]);
			exit();
		}
	}
}
?>
