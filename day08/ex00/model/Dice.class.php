<?php
require_once 'Norm42.class.php';

class Dice implements Norm42
{
	private static $_min = 1;
	private static $_max = 6;

	public static function roll()
	{
		return mt_rand(self::$_min, self::$_max);
	}
	
	public static function doc()
	{
		$doc_name = basename(__FILE__, ".class.php") . ".doc.txt";
		if (file_exists($doc_name))
			return file_get_contents($doc_name);
		else
			echo __FILE__ . " doc file not find!n";
	}
}
?>
