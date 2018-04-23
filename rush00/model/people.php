<?php
require_once('mysqli.php');
require_once('hash.php');

function people_get($mail, $passwd)
{
	$db = database_connect();
	$passwd = hash_passwd($passwd);
	$mail = $db->escape_string($mail);
	$query = "SELECT * FROM peoples
			WHERE email = '$email' AND password = '$passwd' AND isAdmin = 0";
	$ret = $db->query($query);
	if (!$ret)
	{
		error_log($db->error);
		return ('people_get fails '.$db->error);
	}
	return ($ret->fetch_assoc());
}

function people_create(string $email, string $passwd, string $fname,
		string $lname, $address = null, int $isAdmin = 0)
{
	$db = database_connect();

	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
		$err[] = 'email';
	$passwd = hash_passwd($passwd);
	$mail = $db->escape_string($mail);
	$fname = $db->escape_string($fname);
	$lname = $db->escape_string($lname);
	$address = $db->escape_string($address);
	$query = "INSERT INTO peoples (pseudo, email, password, isAdmin, firstname, lastname, address)
	VALUES ('pseudo', '$email', '$password', '$isAdmin', '$fname', '$lname', '$address')";
	$ret = $db->query($query);
	if (!$ret)
	{
		error_log($db->error);
		error_log("mysqli: create fails");
		return (null);
	}
	error_log("mysqli: create sucess");
	return ($ret);
}
?>
