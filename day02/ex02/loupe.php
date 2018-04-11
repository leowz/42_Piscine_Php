#!/usr/bin/php
<?php
if ($argc == 2 && file_exists($argv[1]))
{
	$fd = fopen($argv[1], 'r');
	$page = "";
	while ($fd && !feof($fd))
		$page .= fgets($fd);
	$page = preg_replace_callback("/(<a )(.*?)(>)(.*)(<\/a>)/s", function ($matches)
	{
		$matches[0] = preg_replace_callback("/( title=\")(.*?)(\")/s", function ($matches) {
			return ($matches[1].strtoupper($matches[2]).$matches[3]);
		}, $matches[0]);
		$matches[0] = preg_replace_callback("/(>)(.*?)(<)/s", function ($matches) {
			return ($matches[1].strtoupper($matches[2]).$matches[3]);
		}, $matches[0]);
		return ($matches[0]);
	}, $page);

	echo $page;
}
?>
