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

function people_get_name($email)
{
	$db = database_connect();
	$mail = mysqli_real_escape_string($db, $mail);
	$query = "SELECT * FROM peoples
			WHERE email = '$email'";
	$ret = mysqli_query($db, $query);
	if (!$ret)
		return ('people_get fails ');
	$arr = mysqli_fetch_assoc($ret); 
	$name = $arr['firstname'] ." " .$arr['lastname'];
	if ($name)
		return $name;
	return null; 
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

	$email = mysqli_real_escape_string($db, $email);
	$query = "SELECT * FROM peoples WHERE email = '$email'";
	$req = mysqli_query($db, $query);
	if (!$req)
		return null;
	return mysqli_fetch_assoc($req);
}

function people_update($email, string $firstname, string $lastname, string $password, string $address)
{
	$err = null;
	$db = database_connect();

	if (strlen($firstname) < 3 || strlen($firstname) > 45)
		$err[] = 'firstname';
	if (strlen($lastname) < 3 || strlen($lastname) > 45)
		$err[] = 'lastname';
	if (strlen($address) < 3 || strlen($address) > 100)
		$err[] = 'address';
	if ($password && strlen($password) > 0)
		$password = hash_passwd($password);

	if (!empty($err))
		return ($err);

	$email = mysqli_real_escape_string($db, $email);
	$firstname = mysqli_real_escape_string($db, $firstname);
	$lastname = mysqli_real_escape_string($db, $lastname);
	$password = mysqli_real_escape_string($db, $password);
	$address = mysqli_real_escape_string($db, $address);
	$req = "UPDATE peoples SET firstname='$firstname', lastname='$lastname'";
	if ($password)
		$req .= ", password='$password'";
	$req .= ", address='$address' WHERE email = '$email'";
	error_log($req."\n");
	$req = mysqli_query($db, $req);
	if ($req)
		return null;
	return ('error');
}

function people_get_all()
{
	$db = database_connect();

	$req = mysqli_query($db, "SELECT * FROM peoples WHERE isAdmin = 0");
	if (!$req)
		return null;
	return mysqli_fetch_all($req, MYSQLI_ASSOC);
}

function people_delete($email)
{
	$db = database_connect();
			
	$email = mysqli_real_escape_string($db, $email);
	$req = "DELETE FROM peoples WHERE email = '$email'";
	$req = mysqli_query($db, $req);
	error_log($req);
	error_log(mysqli_error($db));
	return ($req);
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
