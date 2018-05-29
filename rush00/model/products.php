<?php
require_once('mysqli.php');

function product_get_filter($cat, $max, $min, $name)
{
	$db = database_connect();
	$query = "SELECT * FROM products INNER JOIN products_has_categories
			ON products_has_categories.products_id = products.id
			WHERE 1 = 1";
	$name = mysqli_real_escape_string($db, $name);
	$cat = mysqli_real_escape_string($db, $cat);
	$min = mysqli_real_escape_string($db, $db, $min);
	$max = mysqli_real_escape_string($db, $max);
	if ($name)
		$query .= " AND products.name LIKE '$name'";
	if ($cat)
		$query .= " AND products_has_categories.categories_id = '$cat'";
	if ($max)
		$query .= " AND products.price <= '$max'";
	if ($min)
		$query .= " And products.price >= '$min'"; 
	$ret = mysqli_query($db, $query);
	if ($ret)
		return mysqli_fetch_all($ret, MYSQLI_ASSOC);
	return ("product_get_filter: Fail to fetch");
}

function product_get_byid($id)
{
	$db = database_connect();
	$query = "SELECT * FROM products WHERE id = '$id'";
	$ret = mysqli_query($db, $query);
	if ($ret)
		$ret = mysqli_fetch_assoc($ret);
	return ($ret);
}

function products_get()
{
	$db = database_connect();
	$req = "SELECT * FROM products ORDER BY name ASC";
	$req = mysqli_query($db, $req);
	if (!$req)
		return null;
	return mysqli_fetch_all($req, MYSQLI_ASSOC);
}

function stock_get_byid($id)
{
	$db = database_connect();
	$query = "SELECT * FROM products WHERE id = '$id'";
	$ret = mysqli_query($db, $query);
	if ($ret)
		$ret = mysqli_fetch_assoc($ret);
	return $ret['stock'];
}

function product_updatestock_byid(int $id, int $number)
{
	$db = database_connect();
	$query = "UPDATE products set stock = $stock WHERE id = '$id'";
	$req = mysqli_query($db, $query);
	return $req;
}

function clear_basket()
{
	$_SESSION['basketMovie'] = null;
	$_SESSION['basketPrice'] = null;
	$_SESSION['basketCount'] = null;
}
?>
