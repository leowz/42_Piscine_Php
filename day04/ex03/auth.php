<?php
function auth($login, $passwd)
{
	$path = "../private";
	$file_path = $path . "/passwd";
	if (!$login || !$passwd)
		return (false);
	
	$array = unserialize(file_get_contents($file_path));
	if ($array)
	{
		foreach ($array as $k => $v)
		{
			if ($v["login"] === $login && $v["passwd"] === hash("sha256", $passwd))
				return (true);
		}
	}
	return (false);
}
?>
