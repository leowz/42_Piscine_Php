<?php
class Tyrion extends Lannister
{
	public function sleepWith($person)
	{
		if ($person instanceof Lannister)
			print("Not event if I'm drunk !" .PHP_EOL);
		else if ($person instanceof Sansa)
			print("Let's do this." .PHP_EOL);
	}	
}
?>
