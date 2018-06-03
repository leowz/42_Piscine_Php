<?php
session_start();
require_once('../model/products.php');
require_once('../model/prod.php');

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
	if ($datas['name'])
	{
		if (product_delete($datas['name']) === TRUE)
			return null;
		else
			return ("notexist");
	}
	else if ($datas['id'])
	{
		if (product_clear_byid($datas['id']) === TRUE)
			return NULL;
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
