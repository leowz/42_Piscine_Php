<?php
session_start();
require_once('../model/people.php');

	function adminLogin(array $datas)
	{
		$err = NULL;
		if (!isset($datas['pseudo']))
			$err[] = 'pseudo';
		if (!isset($datas['password']))
			$err[] = 'password';
		if ($err === NULL)
		{
			$datas = admin_get($datas['pseudo'], $datas['password']);
			if ($datas === NULL)
				return (array('notfound'));
			$_SESSION['pseudo'] = $datas['pseudo'];
			$_SESSION['admin'] = $datas['pseudo'];
			return NULL;
		}
		else
			return ($err);
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
		$ret = people_create($data['email'], $data['passwd'], $data['fname'], $data['lname'], '', 1);
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
	if (($err = $_POST['from']($_POST)))
	{
		$str_error = http_build_query($err);
		header('Location: ../' . $_POST['from'] . '.php?' . $str_error);
		exit();
	}
	else
	{
		header('Location: ../' . $_POST['from'] . '.php');
		exit();
	}
}
?>
