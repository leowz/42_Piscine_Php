#!/usr/bin/php
<?php
if ($argc == 2)
{
	date_default_timezone_set("UTC");
	setlocale(LC_ALL, 'fr_FR');
	$date = $argv[1];
	if (($date = strptime($date, '%A %d %B %Y %H:%M:%S')))
	{	
		$timestamp = mktime($date["tm_hour"], $date["tm_min"], $date["tm_sec"], $date["tm_mon"] + 1,
			$date["tm_mday"], $date["tm_year"] + 1900);
		printf("%ld\n", $timestamp);
	}
	else
		printf("Wrong Format\n");
}
?>
