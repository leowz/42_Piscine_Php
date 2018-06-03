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
				$err .= $k.':'.$ret;
		}
		return $err;
	}
	else
		return ("Not login");
}

function addAnOrder($data)
{
	if (empty($data['product_id']))
		return 'no proudct_id';
	if (empty($data['quantity']))
		return 'no quantity';
	if (empty($data['email']))
		return 'no email';
	$product = product_get_byid($data['product_id']);
	error_log($data['product_id']);
	error_log($product);
	if ($product)
		return add_order($data['product_id'], $data['quantity'], $data['email']);
	else
		return "product not existe";
}

function get_order_product($str)
{
	if ($str)
	{
		return explode(';', $str);
	}
	else
		return null;
}

function removeAnOrder($data)
{
	if (empty($data['order+product']))
		return 'remove order: prarms error';
	$val = get_order_product($data['order+product']);
	if ($val && $val[0] && $val[1])
	{
		if (one_order_delete($val[0], $val[1]))
			return null;
		else
			return "remove order: delete fails";
	}
	return "remove order: get order product fails";
}

function updateAnOrder($data)
{
	if (empty($data['quantity']))
		return 'update order: prarms quantity error';
	if (empty($data['order+product']))
		return 'update order: prarms error';
	if (empty($data['quantity']) || $data['quantity'] <= 0)
		return 'update quantity not ok';
	$val = get_order_product($data['order+product']);
	if ($val && $val[0] && $val[1])
	{
		if (stock_get_byid($val[1]) < $data['quantity'])
			return "update quantity: out of stack";
		if (one_order_update($val[0], $val[1], $data['quantity']))
			return null;
		else
			return "remove order: delete fails";
	}
	return "remove order: get order product fails";

}

if ($_POST['from'])
{
	if (($err = $_POST['from']($_POST)))
	{
		if ($_POST['error'])
		{
			header('Location: ../' . $_POST['error'] . '.php?'.$err);
			exit();
		}
		error_log("orders: errer".$err);
		header('Location: ../' . $_POST['from'] . '.php?'.$err);
		exit();
	}
	else
	{
		error_log("orders: Success");
		clear_basket();
		header('Location: ../' . $_POST['success'] . '.php');	
		exit();
	}
	
}
?>
