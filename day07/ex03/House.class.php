<?php
abstract class House
{
	public function introduce()
	{
		Print("House " . $this->getHouseName() . " of " . $this->getHouseSeat() . " : \"" .
	   	 $this->getHouseMotto() . "\"" . PHP_EOL);
	}

	abstract function getHouseName();
	abstract function getHouseMotto();
	abstract function getHouseSeat();
}
?>
