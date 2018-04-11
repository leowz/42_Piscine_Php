<?php
class Targaryen
{
	public function getBurned()
	{
		if ($this->resistsFire())
			return "emerges naked but unharmed";
		return "burns alive";
	}

	public function resistsFire()
	{
		return False;
	}
}
?>
