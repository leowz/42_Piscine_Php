<?php
session_start();
require_once('../model/people.php');

function user_create_byAdmin($data)
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

function user_delete_byAdmin($data)
{
	if ($data['email'] && people_exist($data['email'])) {	
		if (people_delete($data['email'])) {
			return null;	
		}
		else
			return "delete fails";
	}
	else
		return "people not exist";

}

function adminRegister($data)
{
	$err = [];
	error_log("enter register\n");
	if (!isset($data['email']))
		$err[] = 'email';
	if (!isset($data['passwd']))
		$err[] = 'password';
	if (!isset($data['admin']))
		$err[] = 'admin';
	if (empty($err))
	{
		$err = people_get($data['email'], $data['passwd']);
		if ($err)
		{
			error_log("user already exit\n");
			return ('user already exist');
		}
		error_log("register before people create");
		$err_create = people_create($data['email'], $data['passwd'], $data['fname'], $data['lname'], '', 1);
		if (!$err_create)
		{
			error_log("create success\n");
			$_SESSION['email'] = $data['email'];
			$_SESSION['admin'] = 1;
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
	if (($err = $_POST['from']($_POST)))
	{
		if ($_POST['error'])
		{
			header('Location: ../' . $_POST['error'] . '.php?'.$str_error);
			exit();
		}
		$str_error = http_build_query($err);
		header('Location: ../' . $_POST['from'] . '.php?' . $str_error);
		exit();
	}
	else
	{
		if ($_POST['success'])
		{
			header('Location: ../' . $_POST['success'] . '.php?');
			exit();
		}
		header('Location: ../' . $_POST['from'] . '.php');
		exit();
	}
}
?>
