<?php
require_once('Color.class.php');

class Vertex
{
	private $_x				= 0;
	private $_y				= 0;
	private $_z				= 0;
	private $_w				= 1.0;
	private $_color			;
	static $verbose			= false;
	
	function __construct(array $arr)
	{
		$this->_x = $arr['x'];
		$this->_y = $arr['y'];
		$this->_z = $arr['z'];
		if (array_key_exists('w', $arr))
			$this->_w = $arr['w'];
		if (array_key_exists('color', $arr) && $arr['color'] instanceof Color)
			$this->_color = $arr['color'];
		else
			$this->_color = new Color(array('red' => 255, 'green' => 255, 'blue' => 255));
		if (Self::$verbose)
			printf("Vertex( x: %0.2f, y: %0.2f, z:%0.2f, w:%0.2f, Color( red: %3d, green: %3d, blue: %3d ) ) constructed\n",
				$this->_x, $this->_y, $this->_z, $this->_w, $this->_color->red,
				$this->_color->green, $this->_color->blue);
	}

	function __destruct()
	{
		if (Self::$verbose)
			printf("Vertex( x: %0.2f, y: %0.2f, z:%0.2f, w:%0.2f, Color( red: %3d, green: %3d, blue: %3d ) ) destructed\n",
				$this->_x, $this->_y, $this->_z, $this->_w, $this->_color->red,
				$this->_color->green, $this->_color->blue);
	}

	function __toString()
	{
		if (Self::$verbose)
			return (sprintf("Vertex( x: %0.2f, y: %0.2f, z:%0.2f, w:%0.2f, Color( red: %3d, green: %3d, blue: %3d ) )",
				$this->_x, $this->_y, $this->_z, $this->_w, $this->_color->red,
				$this->_color->green, $this->_color->blue));
		return (sprintf("Vertex( x: %0.2f, y: %0.2f, z:%0.2f, w:%0.2f )", 
				$this->_x, $this->_y, $this->_z, $this->_w));
	}

	public static function doc()
	{
		if (file_exists('Vertex.doc.txt'))
			return file_get_contents('Vertex.doc.txt');
    }

	public function getX()
	{
		return $this->_x;
	}

	public function setX($x)
	{
		$this->_x = $x;
	}

	public function getY()
	{
		return $this->_y;
	}

	public function setY($y)
	{
		$this->_y = $y;
	}

	public function getZ()
	{
		return $this->_z;
	}

	public function setZ($z)
	{
		$this->_z = $z;
	}

	public function getW()
	{
		return $this->_w;
	}

	public function setW($w)
	{
		$this->_w = $w;
	}

	public function getColor()
	{
		return $this->_color;
	}

	public function setColor($color)
	{
		$this->_color = $color;
	}

	public function opposite()
	{
		return new Vector(array(
			'dest' => new Vertex(array(
				'x' => $this->_x * -1,
				'y' => $this->_y * -1,
				'z' => $this->_z * -1))));
	}
}
?>
