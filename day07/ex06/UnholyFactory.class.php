<?php
class UnholyFactory
{
	private $_servant = [];

	public function absorb($object)
	{
		if ($object instanceof Fighter)
		{
			if (array_key_exists($object->getName(), $this->_servant))
				print("(Factory already absorbed a fighter of type ".
					$object->getName() . ")" . PHP_EOL);	
			else
			{
				$this->_servant[$object->getName()] = $object;
				print("(Factory absorbed a fighter of type ".
					$object->getName() . ")" . PHP_EOL);		
			}
		}
		else
		{
			print("(Factory can't absorb this, it's not a fighter)".
				PHP_EOL);	
		}
	}

	public function fabricate($rf)
	{
		if (array_key_exists($rf, $this->_servant))
		{
			print("(Factory fabricates a fighter of type " . $rf . ")".
				PHP_EOL);
			return (clone ($this->_servant[$rf]));
		}
		print("(Factory hasn't absorbed any fighter of type " . $rf . ")".
			PHP_EOL);
		return (null);
	}
}
?>
