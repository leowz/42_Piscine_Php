<?php

class Color
{
	public $red		 	= 0;
	public $green		= 0;
	public $blue		= 0;
	static $verbose		= false;

	function __construct(array $color)
	{
		if (array_key_exists('rgb', $color))
		{
			$rgb = intval($color['rgb']);
			$this->red = ($rgb >> 16) & 255;
			$this->green = ($rgb >> 8) & 255;
			$this->blue = $rgb & 255;
		}
		else if (array_key_exists('red', $color) && array_key_exists('green', $color) &&
			array_key_exists('blue', $color))
		{
			$this->red = intval($color['red'], 10);
			$this->green = intval($color['green'], 10);
			$this->blue = intval($color['blue'], 10);
		}
		if (Self::$verbose)
			printf("Color( red: %3d, green: %3d, blue: %3d ) constructed.\n",
				$this->red, $this->green, $this->blue);
	}

	function __destruct()
	{
		if (Self::$verbose)
			printf("Color( red: %3d, green: %3d, blue: %3d ) destructed.\n",
				$this->red, $this->green, $this->blue);
	}

	function __toString()
	{
		return (sprintf("Color( red: %3d, green: %3d, blue: %3d )",
			$this->red, $this->green, $this->blue));	
	}

	public static function doc()
	{
		if (file_exists('Color.doc.txt'))
			return file_get_contents('Color.doc.txt');
    }

	public function add(Color $color)
	{
		return (new Color(array('red' => $this->red + $color->red,
						'blue' => $this->blue + $color->blue,
						'green' => $this->green + $color->green)));
	}

	public function sub(Color $color)
	{
		return (new Color(array('red' => $this->red - $color->red,
						'blue' => $this->blue - $color->blue,
						'green' => $this->green - $color->green)));
	}
	
	public function mult($amount)
	{
		return (new Color(array('red' => $this->red * $amount,
						'blue' => $this->blue * $amount,
						'green' => $this->green * $amount)));
	}
}
?>
