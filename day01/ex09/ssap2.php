#!/usr/bin/php
<?php
function cmp($a, $b)
{
	for ($i = 0; ($i < strlen($a) && $i < strlen($b)); $i++)
	{
		$c1 = $a[$i];
		$c2 = $b[$i];
		if ($c1 == $c2)
			continue ;
		if (ctype_alpha($c1))
		{
			if (ctype_alpha($c2))
			{
				if (strcmp(strtolower($c1), strtolower($c2)) == 0)
					continue ;
				return (strcmp(strtolower($c1), strtolower($c2)));
			}
			return (-1);
		}
		else if (is_numeric($c1))
		{
			if (ctype_alpha($c2))
				return (1);
			else if (is_numeric($c2))
				return (strcmp($c1, $c2));
			return (-1);
		}
		else
		{
			if (!ctype_alpha($c2) && !is_numeric($c2))
				return (strcmp($c1, $c2));
			return (1);
		}
	}
	return (strlen($a) - strlen($b));
}

if ($argc > 1)
{
	$arr = [];
	for ($i = 1; $i < $argc; $i++)
	{
		$str = trim($argv[$i]);
		$tmp = array_filter(explode(" ", $str), "strlen");
		$arr = array_merge($arr, $tmp);
	}
	usort($arr, "cmp");
	foreach ($arr as $str)
		printf("%s\n", $str);
}
?>
