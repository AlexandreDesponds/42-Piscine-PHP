<?php
	session_start();
	require_once('../model/people.php');
	require_once('../model/hash.php');

	$functions = array('login', 'register', 'update', 'validmail', 'unregister');

	function register(array $datas)
	{
		$err = NULL;

		if (!isset($datas['pseudo']))
			$err[] = 'pseudo';
		if (!isset($datas['email']))
			$err[] = 'email';
		if (!isset($datas['password']))
			$err[] = 'password';
		if (!isset($datas['firstname']))
			$err[] = 'firstname';
		if (!isset($datas['lastname']))
			$err[] = 'lastname';
		if ($err === NULL)
		{
			if (people_exist($datas['pseudo']) === NULL) /* && mail_exist($datas['pseudo']) === NULL) */ // Je me permet de mettre ca de coté pour implémenter les envois de mail. Il y a surement à ameliorer, mais je ne veux pas imposer non plus. Dis moi ce que t'en pense.
			{
				$key = get_valid_key();
				return (people_create($datas['pseudo'], $datas['email'],  $datas['password'], $datas['firstname'], $datas['lastname'], $key, 0));
			}
			else
				return (array('exist'));
		}
		else
			return $err;
	}

	function unregister(array $datas)
	{
		$err = NULL;
		if (!$datas['pseudo'])
			$err[] = 'pseudo';
		if ($err === NULL)
		{
			if (people_delete($datas['pseudo']) === TRUE)
				return NULL;
			else
				return (array('accountnotfound'));
		}
		else
			return ($err);
	}

	function update(array $datas)
	{
		if ($_SESSION['admin']) {
			if (people_exist($datas['pseudo']))
				return (people_update2($datas['pseudo'], $datas['firstname'], $datas['lastname'], $datas['password'], $datas['address']));
			else
				return (array('no exist'));
		} else {
			if (people_exist($_SESSION['pseudo']))
				return (people_update2($_SESSION['pseudo'], $datas['firstname'], $datas['lastname'], $datas['password'], $datas['address']));
			else
				return (array('no exist'));
		}
	}

	function validmail(array $datas)
	{
		if ($datas['$key']) // ... imo, receive on validmail.html?key=...., send here on POST. AND Ajax this later :D
		{
			if ($_SESSION['pseudo']) // Could ask password and change people_exist to people_get. Like in many other functions. I don't think it is necessary
			{
				$pseudo = $_SESSION['pseudo'];
				$people = people_exist($pseudo);
				if ($datas['key'])
				{
					if ($people['key'] == $datas['$key'])
					{
						$tab['key'] = "";
					}
				}
				else
					return array("alreadyvalid");
			}
			else
				return array("notlogin");
		}
	}

	function login_bycookie(array $datas)
	{
		$err = NULL;

		if (!$datas['pseudo'])
			$err[] = 'pseudo';
		if (!$datas['cookie'])
			$err[] = 'cookie';
		if ($err !== NULL)
		{
			$datas = people_get($datas['pseudo'], $datas['pasrd']);
			if ($datas === NULL)
				return (array('notfound'));
			$_SESSION['pseudo'] = $datas['pseudo'];
			return NULL;
		}
		else
			return ($err);
	}

	function login(array $datas)
	{
		$err = NULL;
		if (!isset($datas['pseudo']))
			$err[] = 'pseudo';
		if (!isset($datas['password']))
			$err[] = 'password';
		if ($err === NULL)
		{
			$datas = people_get($datas['pseudo'], $datas['password']);
			if ($datas === NULL)
				return (array('notfound'));
			$_SESSION['pseudo'] = $datas['pseudo'];
			return NULL;
		}
		else
			return ($err);
	}

	if ($_POST['from'] && in_array($_POST['from'], $functions)) {
		$err = $_POST['from']($_POST);
		if (!($err === TRUE || $err === null)) {
			$str_error = implode('&', $err);
			if ($_POST['error']){
				header('Location: ../' . $_POST['error'] . '.php?' . $str_error);
				exit();
			}
			header('Location: ../' . $_POST['from'] . '.php?' . $str_error);
			exit();
		}
		header('Location: ../' . $_POST['success'] . '.php');
		exit();
	}
?>
