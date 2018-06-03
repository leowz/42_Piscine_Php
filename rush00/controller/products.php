<?php
session_start();
require_once('../model/products.php');
require_once('../model/prod.php');
require_once('../model/orders.php');

function addproduct(array $datas)
{
	$err = NULL;
	if (!$datas['name'])
		$err[] = 'name';
	if (!isset($datas['price']))
		$err[] = 'price';
	if (!isset($datas['isAdult']))
		$err[] = 'isAdult';
	if (!isset($datas['stock']))
		$err[] = 'stock';
	if (!isset($datas['databaseid']))
		$err[] = 'databaseid';
	if ($err !== NULL)
		return ($err);
	$req['databaseid'] = $datas['databaseid'];
	$req['name'] = $datas['name'];
	$req['price'] = $datas['price'];
	$req['isAdult'] = (bool)$datas['isAdult'];
	$req['stock'] = intval($datas['stock']);
	if (product_create($req['name'], $req['picture'], $req['isAdult'], $req['price'], $req['databaseid'], $req['stock']))
		return NULL;
	return ('addproudct error');
}

function updateproduct(array $datas)
{
	$err = NULL;
	if (!$datas['name'])
		$err[] = 'name';
	if (!isset($datas['price']))
		$err[] = 'price';
	if (!isset($datas['stock']))
		$err[] = 'stock';
	if ($err !== NULL)
		return ($err);
	$datas['stock'] = intval($datas['stock']);
	if (isset($datas['picture']))
		$datas['picture'] = $datas['picture'];
	if (product_update($datas['name'], $datas['price'], $datas['stock'], $datas['id']))
		return NULL;
	return ('error');
}

function removeproduct(array $datas)
{
	if ($datas['id'])
	{
		// product->orders_has_products
		// product->products_has_categories
		if (($orders = one_order_exist_bypid($datas['id'])))
		{
			order_delete_bypid($datas['id']);
		}
		if (($cat = product_cat_exist($datas['id'])))
		{
			link_prodcat_delete_byprod($datas['id']);
		}
		if (product_delete($datas['id']) === TRUE)
			return null;
		else
			return ("notexist");
	}
	else
		return ("datanotfound");
}

if ($_POST['from']) {
	if (($err = $_POST['from']($_POST))) {
		$str_error = $err;
		header('Location: ../' . $_POST['success'] . '.php?' . $str_error);
	} else
		header('Location: ../' . $_POST['success'] . '.php');
}
?>
