<?php
require_once('mysqli.php');
require_once('hash.php');

function people_get($email, $passwd)
{
	$db = database_connect();
	$passwd = mysqli_real_escape_string($db, hash_passwd($passwd));
	$mail = mysqli_real_escape_string($db, $mail);
	$query = "SELECT * FROM peoples
			WHERE email = '$email' AND password = '$passwd'";
	$ret = mysqli_query($db, $query);
	if (!$ret)
		return ('people_get fails ');
	return mysqli_fetch_assoc($ret);
}

function people_create(string $email, string $passwd, string $fname = null,
		string $lname = null, $address = null, int $isAdmin = 0)
{
	$db = database_connect();

	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
		$err[] = 'email';
	$passwd = mysqli_real_escape_string($db, hash_passwd($passwd));
	$mail = mysqli_real_escape_string($db, $mail);
	$fname = mysqli_real_escape_string($db, $fname);
	$lname = mysqli_real_escape_string($db, $lname);
	$address = mysqli_real_escape_string($db, $address);
	$query = "INSERT INTO peoples (pseudo, email, password, isAdmin, firstname, lastname, address)
	VALUES ('$email', '$email', '$passwd', '$isAdmin', '$fname', '$lname', '$address')";
	$ret = mysqli_query($db, $query);
	if (!$ret)
	{
		error_log("mysqli: create fails");
		return ("create fails");
	}
	error_log("mysqli: create sucess");
	return (null);
}

function people_exist($email)
{
	$db = database_connect();

	$pseudo = mysqli_real_escape_string($db, $email);
	$query = "SELECT * FROM peoples WHERE pseudo = '$pseudo'";
	$req = mysqli_query($db, $query);
	if (!$req)
		return null;
	return mysqli_fetch_assoc($req);
}

function people_get_all()
{
	$db = database_connect();

	$req = mysqli_query($db, "SELECT * FROM peoples WHERE isAdmin = 0");
	if (!$req)
		return null;
	return mysqli_fetch_all($req, MYSQLI_ASSOC);
}

function admin_exist($email)
{
	$db = database_connect();

	$pseudo = mysqli_real_escape_string($db, $email);
	$req = "SELECT * FROM peoples WHERE email = '$pseudo' AND isAdmin = 1";
	$req = mysqli_query($db, $req);
	if (!$req)
		return null;
	return mysqli_fetch_assoc($req);
}

function admin_get($email, $password)
{
	$db = database_connect();

	$password = mysqli_real_escape_string($db, hash_passwd($password));
	$email = mysqli_real_escape_string($db, $email);
	$req = "SELECT * FROM peoples WHERE email = '$email'
		AND password = '$password' AND isAdmin = 1";
	$req = mysqli_query($db, $req);
	return mysqli_fetch_assoc($req);
}
?>
