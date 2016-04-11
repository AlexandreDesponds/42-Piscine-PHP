<?php
	require_once('mysqli.php');

	function prod_get_byord(int $orders_id)
	{
		$db = database_connect();
		$req = "SELECT * FROM orders_has_products WHERE orders_id = '$orders_id'";
		$req = mysqli_query($db, $req);
		if ($req)
			return mysqli_fetch_all($req, MYSQLI_ASSOC);
		return null;
	}

	function prod_add_toord(int $products_id, int $orders_id, int $quantity)
	{
		$db = database_connect();
		$get = "SELECT * FROM products WHERE id = '$products_id'";
		$get = mysqli_query($db, $get);
		$get = mysqli_fetch_assoc($get);
		if ($get)
		{
			$price = $get['price'];
			$req = "INSERT INTO orders_has_products (orders_id, products_id, price, quantity)
				VALUES('$orders_id', '$products_id', '$price', '$quantity')"; /* Supposed to work, failed with an error cause of false link. Probably will work once database filled */
			$req = mysqli_query($db, $req);
			return ($req);
		}
		else
		{
			return FALSE;
		}
	}

	function order_del(int $orders_id)
	{
		$db = database_connect();
		$req = "DELETE FROM orders_has_products WHERE orders_id = '$orders_id'";
		$req = mysqli_query($db, $req);
		return ($req);
	}

	function product_dell_inorder(int $product_id, int $order_id)
	{
		$db = database_connect();
		$req = "DELETE FROM orders_has_products WHERE orders_id = '$order_id' AND products_id = '$product_id";
		$req = mysqli_query($db, $req);
		return ($req);
	}
?>
