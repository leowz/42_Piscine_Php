<?php
function database_connect()
{
	$host = "localhost";
	$user = "root";
	$passwd = "123456";
	$db = "rush";
	
	$mysqli = mysqli_connect($host, $user, $passwd, $db);
	if (mysqli_connect_errno($mysqli))
	{					
		die('Connect Error (' . mysqli_connect_error(). ') ');
	}
	return ($mysqli);
}
?>
