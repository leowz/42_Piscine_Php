<?php
session_start();
require_once('../model/people.php');
require_once('../model/orders.php');
require_once('../model/products.php');
require_once('../model/prod.php');

function add_order(int $product_id, int $quantity, string $email)
{
	$people = people_exist($email);
	if ($people)
	{
		$stock = stock_get_byid($product_id);
		if ($stock >= $quantity)
		{
			if (order_get_bypid($people['id']) === NULL)
				order_create($people['id']);
			$order = order_get_bypid($people['id']);
			if ($order)
			{
				$prod = prod_add_toord($product_id, $order['id'], $quantity);
				if ($prod === TRUE)
				{
					product_updatestock_byid($product_id, $stock - $quantity);
					return (NULL);
				}
				else
					return ("add order fails");
			}
			return ("commandfound");
		}
		else
			return ("outofstock");
	}
	else
		return ("email notexist");
}

function basket()
{
	$basket = unserialize($_SESSION['basketMovie']);

	if ($_SESSION['email'])
	{
		foreach ($basket as $k => $v)
		{
			$ret = add_order($k, $v, $_SESSION['email']);
			if ($ret !== NULL)
				$err[] = $ret;
		}
		return $err;
	}
	else
		return ("Not login");
}

if ($_POST['from'])
{
	if (($err = $_POST['from']($_POST)))
	{
		error_log("orders: errer".$err);
		header('Location: ../' . $_POST['from'] . '.php?'.$err);
	}
	else
	{
		error_log("orders: Success");
		clear_basket();
		header('Location: ../' . $_POST['success'] . '.php');	
	}
	
}
?>
