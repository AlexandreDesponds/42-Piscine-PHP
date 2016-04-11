<?php
	function database_connect()
	{
		$add = "";
		$user = "";
		$pass = "";
		$db = "rush";

		$mysqli = mysqli_connect($add, $user, $pass, $db);
		if (mysqli_connect_errno($mysqli))
		{
			echo "Echec de connexion à la base de données : " . mysqli_connect_error();
			return (NULL);
		}
		return $mysqli;
	}
