<?php
require_once('mysqli.php');

function product_get_filter($cat, $max, $min, $name)
{
	$db = database_connect();
	$query = "SELECT * FROM products INNER JOIN products_has_categories
			ON products_has_categories.products_id = products.id
			WHERE 1 = 1";
	$name = $db->escape_string($name);
	$cat = $db->escape_string($cat);
	$min = $db->escape_string($min);
	$max = $db->escape_string($max);
	if ($name)
		$query .= " AND products.name LIKE '$name'";
	if ($cat)
		$query .= " AND products_has_categories.categories_id = '$cat'";
	if ($max)
		$query .= " AND products.price <= '$max'";
	if ($min)
		$query .= " And products.price >= '$min'"; 
	$ret = $db->query($query);
	if ($ret)
		return ($ret->fetch_all(MYSQLI_ASSOC));
	return ("product_get_filter: Fail to fetch");
}

function product_get_byid($id)
{
	$db = database_connect();
	$query = "SELECT * FROM products WHERE id = '$id'";
	$ret = $db->query($query);
	if ($ret)
		$ret = $ret->fetch_assoc();
	return ($ret);
}
?>
