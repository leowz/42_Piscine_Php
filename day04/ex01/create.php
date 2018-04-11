<?php
$path = "../private";
$file_path = $path . "/passwd";
if ($_POST["login"] && $_POST["passwd"] && $_POST["submit"] === "OK")
{
	if (!file_exists($path) && !mkdir($path))
		exit();
	if (!file_exists($file_path))
		file_put_contents($file_path, null);
	$array = unserialize(file_get_contents($file_path));
	if ($array)
	{
		foreach ($array as $k => $v)
		{
			if ($v["login"] === $_POST["login"])
			{
				echo "ERROR\n";	
				exit();
			}
		}
	}
	$dict["login"] = $_POST["login"];
	$dict["passwd"] = hash("sha256", $_POST["passwd"]);
	$array[] = $dict;
	file_put_contents($file_path, serialize($array));
	echo "OK\n";
}
else
	echo "ERROR\n";
?>
