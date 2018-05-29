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
?>
