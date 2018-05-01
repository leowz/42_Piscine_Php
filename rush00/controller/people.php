<?php
session_start();
include_once('../model/people.php');

function login($data)
{
	error_log("enter login\n");
	$err = [];
	if (!isset($data['email']))
		$err[] = 'email';
	if (!isset($data['passwd']))
		$err[] = 'password';
	if (empty($err))
	{
		$ret = people_get($data['email'], $data['passwd']);
		error_log(var_dump($ret));
		if (empty($ret))
		{
			error_log("user not exits");
			return ('user not exist');
		}
		error_log("user exist");
		$_SESSION['email'] = $data['email'];
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
		$ret = people_create($data['email'], $data['passwd'], $data['fname'],
		$data['lname']);
		if ($ret)
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

if ($_POST['from'])
{
	$err = $_POST['from']($_POST);
	error_log(var_dump($err));
	if ($err)
	{
		error_log("fails to execute");
		header('Location: ../'. $_POST['from'].'.php');
		exit();
	}
	else
	{
		error_log("sucess to execute redirect home");
		header('Location: ../index.php');
		exit();
	}
}
?>
