<?php
class NightsWatch
{
	private $_recruits = [];

	public function recruit($person)
	{
		$this->_recruits[] = $person;	
	}

	public function fight()
	{
		foreach ($this->_recruits as $newbee)
		{
			if (method_exists($newbee, 'fight'))
				$newbee->fight();
		}
	}
}
?>
