<?php
function check_pw($pw1, $pw2)
{
	return ($pw1 === hash("sha256", $pw2));
}

$path = "../private";
$file_path = $path . "/passwd";
if ($_POST["login"] && $_POST["oldpw"] && $_POST["newpw"] && $_POST["submit"] === "OK")
{
	if (!file_exists($path) || !file_exists($file_path))
	{
		echo "ERROR\n";	
		exit();
	}
	$array = unserialize(file_get_contents($file_path));
	if ($array)
	{
		foreach ($array as $k => $v)
		{
			if ($v["login"] === $_POST["login"] && check_pw($v["passwd"], $_POST["oldpw"]))
			{
				$array[$k]["passwd"] = hash("sha256", $_POST["newpw"]); 
				file_put_contents($file_path, serialize($array));
				echo "OK\n";
				exit();
			}
		}
	}
}
echo "ERROR\n";
?>
