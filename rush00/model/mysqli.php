<?php
function database_connect()
{
	$host = "localhost";
	$user = "root";
	$passwd = "123456";
	$db = "rush";
	
	$mysqli = new mysqli($host, $user, $passwd, $db);
	if ($mysqli->connect_error)
	{					
		error_log("user not exit ".$mysqli->connect_error." \n");
		die('Connect Error (' . $mysqli->connect_errno . ') '
				            . $mysqli->connect_error);
	}
	return ($mysqli);
}
?>
