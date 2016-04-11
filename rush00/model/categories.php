<?php
	require_once('mysqli.php');

	function category_create(string $name)
	{
		$err = NULL;
		$db = database_connect();
		if (strlen($name) < 3 || strlen($name) > 45)
			$err[] = 'name';
		if ($err !== NULL)
			return ($err);
		$name = mysqli_real_escape_string($db, $name);
		$req = "INSERT INTO categories (name) VALUES ('$name')";
		$req = mysqli_query($db, $req);
		return ($req);
	}

	function category_update(string $oldname, string $newname)
	{
		$err = NULL;
		$db = database_connect();
		if (strlen($newname) < 3 || strlen($newname) > 45)
			$err[] = 'name';
		if ($err !== NULL)
			return ($err);
		$oldname = mysqli_real_escape_string($db, $oldname);
		$newname = mysqli_real_escape_string($db, $newname);
		$req = "UPDATE categories SET name = '$newname' WHERE name = '$oldname'";
		$req = mysqli_query($db, $req);
		if ($req !== FALSE)
			return true;
		return ($req);
	}

	function category_delete(string $name)
	{
		$db = database_connect();
		$name = mysqli_real_escape_string($db, $name);
		$req = "DELETE FROM categories WHERE name = '$name'";
		$req = mysqli_query($db, $req);
		return ($req);
	}

	function category_get(string $name)
	{
		$db = database_connect();
		$name = mysqli_real_escape_string($db, $name);
		$req = "SELECT * FROM categories WHERE name = '$name'";
		$req = mysqli_query($db, $req);
		if ($req !== FALSE)
			$req = mysqli_fetch_assoc($req);
		return ($req);
	}

	function category_get_all()
	{
		$db = database_connect();
		$req = "SELECT * FROM categories ORDER BY name ASC";
		$req = mysqli_query($db, $req);
		if ($req !== FALSE)
			return mysqli_fetch_all($req, MYSQLI_ASSOC);
		return (null);
	}
?>