<?php
session_start();
require_once('../model/categories.php');
require_once('../model/products.php');
include('../model/prod.php');

function addcategorie(array $data)
{
	$err = NULL;
	if (!$data['name'])
		$err[] = 'name';
	if ($err !== NULL)
		 return $err;
	if (!category_get($data['name']))
	 {
		if (category_create($data['name']) === TRUE)
			return NULL;
		else
			return ('unknown error');
	}
	else
	  	return ('alreadyexist');
}

function updatecategorie(array $data)
{
	$err = NULL;
	if (!$data['oldname'])
		$err[] = 'oldname';
	if (!$data['name'])
		$err[] = 'name';
	if ($err !== NULL)
		return $err;
	if (category_get($data['oldname']))
	{
		if (category_update($data['oldname'], $data['name']) === TRUE)
			return NULL;
		else
			return ('Unknow error');
	}
	else
		return ('alreadyexist');
}

function removecategory(array $data)
{
	if ($data['name']) {
		$cat = category_get($data['name']);
		if ($cat)
		{
			$prods = product_get_bycat($data['name']);
			if ($prods)
			{
				foreach ($prods as $k => $v) {
					product_clear_byid(intval($v['products_id']));
				}
			}
			link_prodcat_delete_bycat($cat['id']);
			category_delete($data['name']);
		}
	}
	else
		return ("notexist");
}

if ($_POST['from']) {
	if (($err = $_POST['from']($_POST))) {
		$str_error = http_build_query($err);
		header('Location: ../' . $_POST['success'] . '.php?' . $str_error);
	}
	else
		header('Location: ../' . $_POST['success'] . '.php');
}
?>
