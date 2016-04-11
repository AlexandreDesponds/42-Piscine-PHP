<?php
	require_once('mysqli.php');

	function product_get_bycat(string $name, double $min = NULL, double $max = NULL)
	{
		$db = database_connect();
		if ($min != NULL)
			$str = "AND price >= $min";
		else
			$str = "";
		if ($max != NULL)
			$str .= " AND price <= $max";
		$name = mysqli_real_escape_string($db, $name);
		$cat = category_get($name);
		if (!$cat)
			return (NULL);
		$query = "SELECT * FROM products_has_categories WHERE categories_id = " . $cat['id'] . $str;
		$req = mysqli_query($db, $query);
		if ($req)
			return (mysqli_fetch_all($req, MYSQLI_ASSOC));
		return null;
	}

	function link_prodcat_delete_bycat(int $category_id)
	{
		$db = database_connect();
		$req = "DELETE FROM products_has_categories WHERE categories_id = '$category_id'";
		$req = mysqli_query($db, $req);
		return ($req);
	}

	function link_prodcat_delete_byprod(int $category_id)
	{
		$db = database_connect();
		$req = "DELETE FROM products_has_categories WHERE categories_id = '$category_id'";
		$req = mysqli_query($db, $req);
		return ($req);
	}

	function category_add_toprod(int $cat, int $prod)
	{
		$db = database_connect();
		$req = "INSERT INTO products_has_categories (products_id, categories_id) VALUES ('$prod', '$cat')";
		return mysqli_query($db, $req);
	}
?>
