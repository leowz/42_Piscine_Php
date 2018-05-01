<?php
require_once('mysqli.php');

function category_get_all()
{
	$db = database_connect();
	$query = "SELECT * FROM categories ORDER BY name ASC";
	$ret = $db->query($query);
	if ($ret !== false)
		return ($ret->fetch_all(MYSQLI_ASSOC));
	return (false);
}
?>
