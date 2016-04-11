<?php
	require_once('mysqli.php');

	function order_create(int $id)
	{
		$db = database_connect();
		$req = "INSERT INTO orders (peoples_id) VALUES ('$id')";
		$req = mysqli_query($db, $req);
		return ($req);
	}

	function order_get_bydate(string $date)
	{
		$db = database_connect();
		$date = mysqli_real_escape_string($date);
		$req = "SELECT * FROM orders WHERE date_order = '$date'";
		$req = mysqli_query($db, $req);
		$ret = mysqli_fetch_assoc($req);
		return $ret;
	}

	function order_get_bypid(int $pid)
	{
		$db = database_connect();
		$req = "SELECT * FROM orders WHERE peoples_id = '$pid'";
		$req = mysqli_query($db, $req);
		if ($req)
			return mysqli_fetch_assoc($req);
		return NULL;
	}

	function order_get_bypeopleid(int $people_id)
	{
		$db = database_connect();
		$req = "SELECT * FROM orders INNER JOIN orders_has_products AS op ON op.orders_id = orders.id
									 INNER JOIN products ON products.id = op.products_id WHERE peoples_id = '$people_id'";
		$req = mysqli_query($db, $req);
		if ($req)
			return mysqli_fetch_all($req, MYSQLI_ASSOC);
		return null;
	}

	function order_delete_bypeoepleid(int $people_id)
	{
		$db = database_connect();
		$req = "DELETE FROM orders WHERE peoples_id = '$people_id'";
		$req = mysqli_query($db, $req);
		return $req;
	}

	function order_delete(int $id)
	{
		$db = database_connect();
		$req = "DELETE FROM orders WHERE id = '$id'";
		$req = mysqli_query($db, $req);
		return $req;
	}
?>
