<?php
if (array_key_exists("action", $_GET))
{
	if ($_GET["action"] === "set")
	{
		setcookie($_GET["name"], $_GET["value"], time() + 3600);
	}
	else if ($_GET["action"] === "get")
	{
		if (($name = $_GET["name"]) && ($_COOKIE[$name]));
		{
			if (strlen($_COOKIE[$name]) > 0)
				echo $_COOKIE[$name] . "\n";
		}
	}
	else if ($_GET["action"] === "del")
	{
		$name = $_GET["name"];
		setcookie($_GET["name"], "", -1);
	}
}
?>
