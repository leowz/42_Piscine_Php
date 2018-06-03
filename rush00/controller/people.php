<?php
session_start();
include_once('../model/people.php');
include_once('../model/orders.php');
include_once('../model/prod.php');

function login($data)
{
	$err = [];
	if (!isset($data['email']))
		$err[] = 'email';
	if (!isset($data['passwd']))
		$err[] = 'password';
	if (empty($err))
	{
		$ret = people_get($data['email'], $data['passwd']);
		error_log($ret['email']);
		error_log($ret['isAdmin']);
		if (empty($ret))
		{
			error_log("user not exits");
			return ('user not exist');
		}
		error_log("user exist");
		$_SESSION['email'] = $data['email'];
		if ($ret['isAdmin'] && $ret['isAdmin'] == 1)
			$_SESSION['admin'] = $ret['isAdmin'];
		return (null);
	}
	else
	{
		return ($err);
	}
}

function register($data)
{
	$err = [];
	error_log("enter register\n");
	if (!isset($data['email']))
		$err[] = 'email';
	if (!isset($data['passwd']))
		$err[] = 'password';
	if (empty($err))
	{
		$err = people_get($data['email'], $data['passwd']);
		if ($err)
		{
			error_log("user already exit\n");
			return ('user already exist');
		}
		error_log("register before people create");
		$err_create = people_create($data['email'], $data['passwd'], $data['fname'], $data['lname']);
		if (!$err_create)
		{
			error_log("create success\n");
			$_SESSION['email'] = $data['email'];
			return (null);
		}
		error_log("create fail");
		return ("create fails");
	}
	else
	{
		error_log("register input data error");
		return ($err);
	}
}

function delete_self()
{
	if ($_SESSION['email'] && ($p = people_exist($_SESSION['email'])) && $p['id']) {	
		//people -> order -> orders_has_products;
		if (($oid = order_get_bypid($p['id'])))
		{
			if (($orders = one_order_exist($oid['id'])))	
			{
				order_delete_byid($oid['id']);
			}
			orderId_delete($oid['id']);
		}
		if (people_delete($_SESSION['email'])) {
			session_start();
			session_destroy();
			return null;	
		}
		else
			return "delete fails";
	}
	else
		return "people not exist";
}

function update(array $datas)
{
	if ($_SESSION['admin']) {
		if (people_exist($datas['email']))
			return (people_update($datas['email'], $datas['firstname'], $datas['lastname'], $datas['password'], $datas['address']));
		else
			return ('Not exist');
	} else {
		if (people_exist($_SESSION['email']))
			return (people_update($_SESSION['email'], $datas['firstname'], $datas['lastname'], $datas['password'], $datas['address']));
		else
			return ("Not exist");
	}
}

if ($_POST['from'])
{
	$err = $_POST['from']($_POST);
	error_log(var_dump($err));
	if ($err)
	{
		error_log("fails to execute");
		if ($_POST['error']) {
			header('Location: ../'. $_POST['error'].'.php?err='.$err);
			exit();
		}
		header('Location: ../'. $_POST['from'].'.php?err='.$err);
		exit();
	}
	else
	{
		if ($_POST['success']) {
			header('Location: ../'. $_POST['success']);
			exit();
		}
		error_log("sucess to execute redirect home");
		header('Location: ../index.php');
		exit();
	}
}
?>
