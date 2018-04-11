#!/usr/bin/php
<?php
if ($argc != 3 || !file_exists($argv[1]))
	exit();
$fd = fopen($argv[1], 'r');
while ($fd && !feof($fd))
	$array[] = explode(";", fgets($fd));

$format = $array[0];
unset($array[0]);

foreach ($format as $k => $v)
	$format[$k] = trim($v);

$index = array_search($argv[2], $format);
if ($index === false)
	exit();

foreach ($format as $h_k => $h_v)
{
	$tmp = [];
	foreach ($array as $a_v)
	{
		if (isset($a_v[$index]))
			$tmp[trim($a_v[$index])] = trim($a_v[$h_k]);
	}
	$$h_v = $tmp;
}

while (1)
{
	echo "Enter your command: ";
	$order = fgets(STDIN);
	if ($order)
		eval ($order);
	else
		break;
}
echo "\n";
?>
