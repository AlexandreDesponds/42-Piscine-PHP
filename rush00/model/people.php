<?php
	require_once('mysqli.php');
	require_once('hash.php');

	$deleted_account = 'deleted_account';

	/*function people_create(string $pseudo, string $email, string $password, string $firstname, string $lastname, string $key, bool $isAdmin)
	{
		$db = database_connect(); /* Could control if connection worked or not (NULL or NOT) */
		/*$err = NULL;
		if (strlen($pseudo) > 45 || strlen($pseudo) < 5)
			$err[] = 'pseudo';
		if (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE)
			$err[] = 'email';
		if (strlen($password) < 7)
			$err[] = 'password';
		else
		{
			if ($isAdmin)
				$password = admin_pass($password);
			else
				$password = user_pass($password);
		}
		if (strlen($firstname) < 3 || strlen($firstname) > 45)
			$err[] = 'firstname';
		if (strlen($lastname) < 3 || strlen($lastname) > 45)
			$err[] = 'lastname';
		if (strlen($address) < 12 || strlen($address) > 100)
			$err[] = 'address';
		if ($err !== FALSE)
			return FALSE;
		$pseudo = mysqli_real_escape_string($db, $pseudo);
		$email = mysqli_real_escape_string($db, $email);
		$password = mysqli_real_escape_string($db, $password);
		$firstname = mysqli_real_escape_string($db, $firstname);
		$lastname = mysqli_real_escape_string($db, $lastname);
		$address = mysqli_real_escape_string($db, $pseudo);
		/* No sanitizing for $key, generated on server's side */
		/*$req = "INSERT INTO peoples (pseudo, email, password, isAdmin, firstname, lastname, address, valid)
			VALUES ('$pseudo', '$email', '$password', '$isAdmin', '$firstname', '$lastname', '$address', '$key')";
		if (mysqli_query($db, $req) === TRUE)
			return TRUE;
		else
			return FALSE;
	}*/

	function people_update2($pseudo, string $firstname, string $lastname, string $password, string $address)
	{
		$err = null;
		$db = database_connect();

		if (strlen($firstname) < 3 || strlen($firstname) > 45)
			$err[] = 'firstname';
		if (strlen($lastname) < 3 || strlen($lastname) > 45)
			$err[] = 'lastname';
		if (strlen($address) < 12 || strlen($address) > 100)
			$err[] = 'address';
		if (strlen($password) < 7)
			$err[] = 'password';
		else
			$password = user_pass($password);

		if (!empty($err))
			return ($err);

		$pseudo = mysqli_real_escape_string($db, $pseudo);
		$firstname = mysqli_real_escape_string($db, $firstname);
		$lastname = mysqli_real_escape_string($db, $lastname);
		$password = mysqli_real_escape_string($db, $password);
		$address = mysqli_real_escape_string($db, $address);
		$req = "UPDATE peoples SET firstname='$firstname', lastname='$lastname', password='$password', address='$address' WHERE pseudo = '$pseudo'";
		$req = mysqli_query($db, $req);
		if ($req)
			return true;
		return array('error');
	}

	function people_create(string $pseudo, string $email, string $password, string $firstname, string $lastname, string $address, bool $isAdmin = false)
	{
		$db = database_connect(); /* Could control if connection worked or not (NULL or NOT) */
		$err = array();
		if (strlen($pseudo) > 45 || strlen($pseudo) < 5)
			$err[] = 'pseudo';
		if (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE)
			$err[] = 'email';
		if (strlen($password) < 7)
			$err[] = 'password';
		else
		{
			if ($isAdmin)
				$password = admin_pass($password);
			else
				$password = user_pass($password);
		}
		if (strlen($firstname) < 3 || strlen($firstname) > 45)
			$err[] = 'firstname';
		if (strlen($lastname) < 3 || strlen($lastname) > 45)
			$err[] = 'lastname';
		if (strlen($address) < 12 || strlen($address) > 100)
			$err[] = 'address';
		if (!empty($err))
			return ($err);
		$pseudo = mysqli_real_escape_string($db, $pseudo);
		$email = mysqli_real_escape_string($db, $email);
		$password = mysqli_real_escape_string($db, $password);
		$firstname = mysqli_real_escape_string($db, $firstname);
		$lastname = mysqli_real_escape_string($db, $lastname);
		$address = mysqli_real_escape_string($db, $pseudo);
		$req = "INSERT INTO peoples (pseudo, email, password, isAdmin, firstname, lastname, address)
			VALUES ('$pseudo', '$email', '$password', '$isAdmin', '$firstname', '$lastname', '$address')";
		if (mysqli_query($db, $req) === TRUE)
			return TRUE;
		return (array('general'));
	}


/*
  * peoples_update takes an array supposed to contain same datas than peoples_create params
  * and a boolean, if setted as 1 (default == 0) giving possibilities to update every 'good'
  * datas even if there is others that are wrong
*/
	function people_update(array $datas, string $old_pseudo, bool $noError = false)
	{
		$db = database_connect(); /* Could control if connection worked or not (NULL or NOT) */
		$err = NULL;

		if ($datas['password'])
		{
			if (strlen($datas['password']) < 7)
				$err[] = 'password';
			else
			{
				if ($datas['isAdmin'])
					$password = admin_pass($datas['password']);
				else
					$password = user_pass($datas['password']);
				$req['password'] = $password;
			}
		}
		if ($datas['firstname'])
		{
			if (strlen($datas['firstname']) < 3 || strlen($datas['firstname']) > 45)
				$err[] = 'firstname';
			else
				$req['firstname'] = mysqli_real_escape_string($db, $datas['firstname']);
		}
		if ($datas['lastname'])
		{
			if (strlen($datas['lastname']) < 3 || strlen($datas['lastname']) > 45)
				$err[] = 'lastname';
			else
				$req['lastname'] = mysqli_real_escape_string($db, $datas['lastname']);
		}
		if ($datas['address'])
		{
			if (strlen($datas['address']) < 3 || strlen($datas['address']) > 45)
				$err[] = 'address';
			else
				$req['address'] = mysqli_real_escape_string($db, $datas['address']);
		}
		if ($datas['isAdmin'])
			$req['isAdmin'] = $datas['isAdmin'];
		if ($datas['pseudo'])
		{
			if (strlen($datas['pseudo']) > 45 || strlen($datas['pseudo']) < 5)
				$err[] = 'pseudo';
			else
				$req['pseudo'] = mysqli_real_escape_string($db, $datas['pseudo']);
		}
		if ($datas['cookie'])
			$req['cookie'] = generate_cookie($old_pseudo);
		else if ($datas['cookie'] === 0)
			$req['cookie'] = '';
		if ($err == NULL || $noError == 1)
		{
			$old_pseudo = mysqli_real_escape_string($db, $old_pseudo);
			$err = NULL;
			foreach($req as $k => $v)
			{
				$req = "UPDATE peoples set '$k' as '$v' WHERE pseudo = '$old_pseudo'";
				if (mysqli_query($db, $req) === FALSE)
					$err[] = $k;
			}
			return $err;
		}
		else
			return $err;
	}

	function people_clear($pseudo, $password)
	{
		global $deleted_account;
		$pseudo = mysqli_real_escape_string($db, $pseudo);
		$password = user_pass($password);
		$req = "UPDATE peoples set (pseudo, email, password, isAdmin, firstname, lastname, address, cookie, valid) VALUES
			('$deteted_account', '', '', 0, '', '', '', '', '') WHERE pseudo = '$pseudo' AND password = '$password'";
	}

	function admin_clear($pseudo, $password)
	{
		global $deleted_account;
		$pseudo = mysqli_real_escape_string($db, $pseudo);
		$password = admin_pass($password);
		$req = "UPDATE peoples set (pseudo, email, password, isAdmin, firstname, lastname, address, cookie, valid) VALUES
			('$deteted_account', '', '', 0, '', '', '', '', '') WHERE pseudo = '$pseudo' AND password = '$password'";
	}

	function people_delete($pseudo)
	{
		$db = database_connect();
		
		$pseudo = mysqli_real_escape_string($db, $pseudo);
		$req = "DELETE FROM peoples WHERE pseudo = '$pseudo'";
		$req = mysqli_query($db, $req);
		return ($req);
	}

	function admin_delete($pseudo, $password)
	{
		$pseudo = mysqli_real_escape_string($db, $pseudo);
		$password = admin_pass($password);
		$req = "DELETE FROM peoples WHERE pseudo = '$pseudo' AND password = '$password' AND isAdmin = 0";
		$req = mysqli_query($db, $req);
		return ($req);
	}

	function people_get($pseudo, $password)
	{
		$db = database_connect();

		$password = user_pass($password);
		$pseudo = mysqli_real_escape_string($db, $pseudo);
		$req = mysqli_query($db, "SELECT * FROM peoples WHERE pseudo = '$pseudo' AND password = '$password' AND isAdmin = 0");
		if (!$req)
			return null;
		return mysqli_fetch_assoc($req);
	}

	function people_exist($pseudo)
	{
		$db = database_connect();

		$pseudo = mysqli_real_escape_string($db, $pseudo);
		$req = "SELECT * FROM peoples WHERE pseudo = '$pseudo'";
		$req = mysqli_query($db, $req);
		if (!$req)
			return null;
		return mysqli_fetch_assoc($req);
	}

	function admin_exist($pseudo)
	{
		$db = database_connect();

		$pseudo = mysqli_real_escape_string($db, $pseudo);
		$req = "SELECT * FROM peoples WHERE pseudo = '$pseudo' AND isAdmin = 1";
		$req = mysqli_query($db, $req);
		if (!$req)
			return null;
		return mysqli_fetch_assoc($req);
	}

	function people_get_all()
	{
		$db = database_connect();

		$req = mysqli_query($db, "SELECT * FROM peoples WHERE isAdmin = 0");
		if (!$req)
			return null;
		return mysqli_fetch_all($req, MYSQLI_ASSOC);
	}

	function mail_exist($pseudo)
	{
		$db = database_connect();

		$mail = mysqli_real_escape_string($db, $mail);
		$req = "SELECT * FROM peoples WHERE mail = '$mail'";
		$req = mysqli_query($db, $req);
		return mysqli_fetch_assoc($req);
	}


	function admin_get($pseudo, $password)
	{
		$db = database_connect();

		$password = admin_pass($password);
		$pseudo = mysqli_real_escape_string($db, $pseudo);
		$req = "SELECT * FROM peoples WHERE pseudo = '$pseudo' AND password = '$password' AND isAdmin = 1";
		$req = mysqli_query($db, $req);
		return mysqli_fetch_assoc($req);
	}
