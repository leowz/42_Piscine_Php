<?php
require_once('mysqli.php');

function order_create(int $id)
{
	$db = database_connect();
	$query = "INSERT INTO orders (peoples_id) VALUES ('$id')";
	$ret = mysqli_query($db, $query);
	if ($ret == false)
		error_log("order_create: create false");
	return ($ret);
}

function order_get_bypid(int $pid)
{
	$db = database_connect();
	$query = "SELECT * FROM orders WHERE peoples_id = '$pid'";
	$ret = mysqli_query($db, $query);
	if ($ret)
		return mysqli_fetch_assoc($ret);
	return NULL;
}

function order_get_all()
{
	$db = database_connect();
	$query = "SELECT * FROM orders_has_products";
	$ret = mysqli_query($db, $query);
	if ($ret)
		return mysqli_fetch_all($ret, MYSQLI_ASSOC);
	return NULL;
}

function order_get_bypeopleid(int $people_id)
{
	$db = database_connect();
	$query = "SELECT * FROM orders
			INNER JOIN orders_has_products AS op ON op.orders_id = orders.id
			INNER JOIN products ON products.id = op.products_id 
			WHERE peoples_id = '$people_id'";
	$ret = mysqli_query($db, $query);
	if ($ret)
		return mysqli_fetch_all($ret, MYSQLI_ASSOC);
	return null;
}

function one_order_delete(int $orders_id, int $products_id)
{
	$db = database_connect();
	$req = "DELETE FROM orders_has_products WHERE orders_id = '$orders_id' AND products_id = '$products_id'";
	$req = mysqli_query($db, $req);
	return $req;
}

function one_order_update(int $orders_id, int $products_id, int $quantity)
{
	$db = database_connect();
	$req = "DELETE FROM orders_has_products WHERE orders_id = '$orders_id' AND products_id = '$products_id'";
	$req = "UPDATE orders_has_products SET quantity='$quantity' WHERE orders_id = '$orders_id' AND products_id = '$products_id'";
	$req = mysqli_query($db, $req);
	return $req;
}
?>
