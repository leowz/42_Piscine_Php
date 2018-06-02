<?php
require_once('mysqli.php');

function category_get_all()
{
	$db = database_connect();
	$query = "SELECT * FROM categories ORDER BY name ASC";
	$ret = mysqli_query($db, $query);
	if ($ret !== false)
		return mysqli_fetch_all($ret, MYSQLI_ASSOC);
	return (false);
}

function category_get(string $name)
{
	$db = database_connect();
	$name = mysqli_real_escape_string($db, $name);
	$req = "SELECT * FROM categories WHERE name = '$name'";
	$req = mysqli_query($db, $req);
	if ($req !== FALSE)
		$req = mysqli_fetch_assoc($req);
	return ($req);
}

function category_create(string $name)
{
	$err = NULL;
	$db = database_connect();
	if (strlen($name) < 3 || strlen($name) > 45)
		$err[] = 'name';
	if ($err !== NULL)
		return ($err);
	$name = mysqli_real_escape_string($db, $name);
	$req = "INSERT INTO categories (name) VALUES ('$name')";
	$req = mysqli_query($db, $req);
	return ($req);
}
?>
