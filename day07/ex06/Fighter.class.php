<?php

class Fighter
{
	private $_name 			= "";

	function __construct($name)
	{
		$this->_name = $name;
	}

	public function getName()
	{
		return ($this->_name);
	}
}

?>
