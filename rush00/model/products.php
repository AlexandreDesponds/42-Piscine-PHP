<?php
	require_once('mysqli.php');


	function product_create(string $name, string $picture = NULL, bool $isAdult, float $price, int $databaseid)
	{
		$err = NULL;
		$db = database_connect();
		if (strlen($name) < 3 || strlen($name) > 100)
			$err[] = 'name';
		if ($picture != NULL && (strlen($picture) < 10 || strlen($picture) > 50))
			$err[] = 'picture';
		if ($price < 0)
			$err[] = 'price';
		if ($err !== NULL)
			return ($err);
		$name = mysqli_real_escape_string($db, $name);
		$picture = mysqli_real_escape_string($db, $picture);
		$req = "INSERT INTO products (name, picture, isAdult, price, databaseid) VALUES('$name', '$picture', '$isAdult', '$price', '$databaseid')";
		$req = mysqli_query($db, $req);
		if ($req)
			return true;
		return array('error');
	}

	function product_create2(string $name, string $picture = NULL, bool $isAdult, float $price, int $databaseid, $stock, $id)
	{
		$err = NULL;
		$db = database_connect();
		if (strlen($name) < 3 || strlen($name) > 100)
			$err[] = 'name';
		if ($picture != NULL && (strlen($picture) < 10 || strlen($picture) > 50))
			$err[] = 'picture';
		if ($price < 0)
			$err[] = 'price';
		if ($stock < 0)
			$err[] = 'stock';
		if ($err !== NULL)
			return ($err);
		$name = mysqli_real_escape_string($db, $name);
		$picture = mysqli_real_escape_string($db, $picture);
		$stock = mysqli_real_escape_string($db, $stock);
		$req = "UPDATE products SET name='$name', picture='$picture', isAdult='0', price='$price', databaseid='$databaseid', stock='$stock' WHERE id = '$id'";
		$req = mysqli_query($db, $req);
		if ($req)
			return true;
		return array('error');
	}

	function product_update(array $datas, string $old_name)
	{
		$err = NULL;
		$rep = NULL;
		$db = database_connect();

		if ($datas['price'])
		{
			if (!is_numeric($datas['price']))
				$err[] = 'price';
			else
			{
				$price = floatval($datas['price']);
				if ($price < 0)
					$err[] = 'price';
				$req[] = $price;
			}
		}
		if (isset($datas['adult']))
		{
			if ($datas['adults'])
				$req['adult'] = TRUE;
			else
				$req['adult'] = FALSE;
		}
		if ($datas['picture'])
		{
			if (strlen($datas['picture']) < 10 || strlen($datas['picture']) > 50)
				$err['picture'] = '';
			else
				$req['picture'] = mysqli_real_escape_string($db, $datas['picture']);
		}
		$old_name = mysqli_real_escape_string($db, $old_name);
		if ($err !== NULL)
			return $err;
		$err = NULL;
		var_dump($req);
		foreach($req as $k => $v)
		{
			$req = "UPDATE products set $k as $v WHERE name = '$old_name'";
			echo $req;
			if (mysqli_query($db, $req) === FALSE)
				$err[] = $k;
		}
		return $err;
	}

	function product_get_filtre($cat, $min, $max, $name){
		$db = database_connect();
		$req = "SELECT * FROM products INNER JOIN products_has_categories ON products_has_categories.products_id = products.id WHERE 1 = 1";
		if ($name) {
			$name = mysqli_real_escape_string($db, $name);
			$req .= " AND products.name LIKE '%$name%'";
		}
		if ($min) {
			$min = mysqli_real_escape_string($db, $min);
			$req .= " AND products.price >= '$min'";
		}
		if ($max) {
			$max = mysqli_real_escape_string($db, $max);
			$req .= " AND products.price <= '$max'";
		}
		if ($cat) {
			$cat = mysqli_real_escape_string($db, $cat);
			$req .= " AND products_has_categories.categories_id = '$cat'";
		}
		$req = mysqli_query($db, $req);
		if ($req)
			return mysqli_fetch_all($req, MYSQLI_ASSOC);
		return null;
	}

	function product_delete(string $name)
	{
		$db = database_connect();
		$name = mysqli_real_escape_string($db, $name);
		$req = "DELETE FROM products WHERE name = '$name'";
		$req = mysqli_query($db, $req);
		if ($req)
			return true;
		return $req;
	}

	function product_clear(string $name)
	{
		$db = database_connect();
		$name = mysqli_real_escape_string($db, $name);
		$req = "UPDATE products set (name, price, databaseid, stock, isAdult, picture) VALUES
		('', 0, 0, 0, 0, '') WHERE name = '$name'";
		$req = mysqli_query($db, $req);
		if ($req)
			$req = mysqli_fetch_assoc($req);
		return $req;
	}

	function product_clear_byid(int $id)
	{
		$db = database_connect();
		$req = "UPDATE products set (name, price, databaseid, stock, isAdult, picture) VALUES
		('', 0, 0, 0, 0, '') WHERE id = '$id'";
		$req = mysqli_query($db, $req);
		if ($req)
			$req = mysqli_fetch_assoc($req);
		return $req;
	}

	function products_get()
	{
		$db = database_connect();
		$req = "SELECT * FROM products ORDER BY name ASC";
		$req = mysqli_query($db, $req);
		if (!$req)
			return null;
		return mysqli_fetch_all($req, MYSQLI_ASSOC);
	}

	function product_get_byid(int $id)
	{
		$db = database_connect();
		$req = "SELECT * FROM products WHERE id = '$id'";
		$req = mysqli_query($db, $req);
		if ($req)
			$req = mysqli_fetch_assoc($req);
		return $req;
	}

	function product_get_byname(string $name)
	{
		$db = database_connect();
		$name = mysqli_real_escape_string($db, $name);
		$req = "SELECT * FROM products WHERE name = '$name'";
		$req = mysqli_query($db, $req);
		if ($req)
			$req = mysqli_fetch_assoc($req);
		return $req;
	}

	function product_updatestock_byname(string $name, int $number)
	{
		$db = database_connect();
		$name = mysqli_real_escape_string($db, $name);
		$req = "UPDATE products set stock = $stock WHERE name = '$name'";
		$req = mysqli_query($db, $req);
		return $req;
	}

	function product_updatestock_byid(int $id, int $number)
	{
		$db = database_connect();
		$req = "UPDATE products set stock = $stock WHERE id = '$id'";
		$req = mysqli_query($db, $req);
		return $req;
	}

	function stock_get_byid(int $id)
	{
		$db = database_connect();
		$req = "SELECT * FROM products WHERE id = '$id'";
		$req = mysqli_query($db, $req);
		if ($req)
			$req = mysqli_fetch_assoc($req);
		return $req['stock'];
	}

	function stock_get_byname(string $name)
	{
		$db = database_connect();
		$name = mysqli_real_escape_string($db, $name);
		$req = "SELECT * FROM products WHERE name = '$name'";
		$req = mysqli_query($db, $req);
		if ($req)
			$req = mysqli_fetch_assoc($req);
		return $req['stock'];
	}

	function products_get_byprice(float $min = NULL, double $max = NULL)
	{
		$db = database_connect();
		if ($min != NULL)
			$str = "WHERE price >= '$min'";
		else
			$str = "";
		if ($max != NULL)
		{
			if ($str)
				$str .= " AND price <= '$max'";
			else
				$str = "WHERE price <= '$max'";
		}
		$req = "SELECT * FROM products '$str'";
		$req = mysqli($db, $req);
		if ($req)
			$req = mysqli_fetch_assoc($req);
		return $req;
	}
