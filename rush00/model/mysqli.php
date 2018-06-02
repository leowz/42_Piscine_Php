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


function database_connect2()
{
$add = "localhost";
$user = "root";
$pass = "123456";

$mysqli = mysqli_connect($add, $user, $pass);
if (mysqli_connect_errno($mysqli))
{
	echo "fails to connect to db: " . mysqli_connect_error();
	return (NULL);
}
return $mysqli;
}
?>
