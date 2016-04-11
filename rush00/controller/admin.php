<?php
	session_start();
	require_once('../model/people.php');

	$functions = array('adminLogin');

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

	if ($_POST['from'] && in_array($_POST['from'], $functions))
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
