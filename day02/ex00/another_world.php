#!/usr/bin/php
<?php
if ($argc > 1)
{
	$str = trim($argv[1]);
	if (($arr = preg_split("/[ \t]+/", $str)))
	{
		for ($i = 0; $i < count($arr); $i++)
		{
			printf("%s", $arr[$i]);
			if ($i + 1 < count($arr))
				printf(" ");
			else
				printf("\n");
		}
	}
}
?>
