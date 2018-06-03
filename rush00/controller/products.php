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
	$req['picture'] = null;
	if (product_create($req['name'], $req['picture'], $req['isAdult'], $req['price'], $req['databaseid']))
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
	if (!isset($datas['isAdult']))
		$err[] = 'isAdult';
	if (!isset($datas['stock']))
		$err[] = 'stock';
	if ($err !== NULL)
		return ($err);
	$datas['price'] = intval($datas['price']);
	$datas['isADult'] = (bool)$datas['isAdult'];
	$datas['stock'] = intval($datas['stock']);
	if (isset($datas['picture']))
		$datas['picture'] = $datas['picture'];
	if (product_update($datas['name'], $datas['picture'], $datas['isAdult'], $datas['price'], $datas['databaseid'], $datas['stock'], $datas['id']))
		return NULL;
	return array('error');
}

function removeproduct(array $datas)
{
	if ($datas['name'])
	{
		if (product_delete($datas['name']) === TRUE)
			return null;
		else
			return (array("notexist"));
	}
	else if ($datas['id'])
	{
		if (product_clear_byid($datas['id']) === TRUE)
			return NULL;
		else
			return (array("notexist"));
	}
	else
		return (array("datanotfound"));
}

if ($_POST['from']) {
	if (($err = $_POST['from']($_POST))) {
		$str_error = http_build_query($err);
		header('Location: ../' . $_POST['success'] . '.php?' . $str_error);
	} else
		header('Location: ../' . $_POST['success'] . '.php');
}
?>
