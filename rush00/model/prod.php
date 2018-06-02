<?php
require_once('mysqli.php');

function prod_get_byord(int $orders_id)
{
	$db = database_connect();
	$req = "SELECT * FROM orders_has_products WHERE orders_id = '$orders_id'";
	$req = mysqli_query($db, $req);
	if ($req)
		return mysqli_fetch_all($req, MYSQLI_ASSOC);
	return null;
}

function prod_add_toord(int $products_id, int $orders_id, int $quantity)
{
	$db = database_connect();
	$get_query = "SELECT * FROM products WHERE id = '$products_id'";
	$product = mysqli_fetch_assoc(mysqli_query($db, $get_query));
	if ($product)
	{
		$price = $product['price'];
		$p_query= "INSERT INTO orders_has_products (orders_id, products_id, price, quantity)
			VALUES('$orders_id', '$products_id', '$price', '$quantity')";
		$ret = mysqli_query($db, $p_query);
		error_log("add to ord: ret".$ret." ".mysqli_error($db));
		return ($ret);
	}
	else
	{
		error_log("add to ord: product return null");
		return (null);
	}
}

function category_add_toprod(int $cat, int $prod)
{
	$db = database_connect();
	$req = "INSERT INTO products_has_categories (products_id, categories_id) VALUES ('$prod', '$cat')";
	return mysqli_query($db, $req);
}
?>
