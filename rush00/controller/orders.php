<?php
session_start();
	require_once('../model/people.php');
	require_once('../model/orders.php');
	require_once('../model/products.php');
	require_once('../model/ord_has_prod.php');

	$functions = array('get_order', 'del_orders', 'add_order', 'basket');

	function get_order(array $datas)
	{
		if (!$datas['order_id'] || !is_numeric($datas['order_id']))
			return (array('order_id'));
		$order_id = intval('order_id');
		return (prod_get_byord($order_id));
	}

	function del_orders(array $datas)
	{
		if (!$datas['pseudo'])
			return (array('pseudo'));
		$user = people_exist($datas['pseudo']);
		if ($user)
		{
			if (del_order($user['id']) === TRUE)
				return NULL;
			else
				return array("order" => "notexist");
		}
		else
			return array("pseudo" => "notexist");
	}

	function add_order(int $product_id, int $quantity, string $pseudo)
	{
		$people = people_exist($pseudo);
		if ($people)
		{
			$stock = stock_get_byid($product_id);
			if ($stock >= $quantity)
			{
				if (order_get_bypid($people['id']) === NULL)
					order_create($people['id']);
				$order = order_get_bypid($people['id']);
				if ($order)
				{
					$prod = prod_add_toord($product_id, $order['id'], $quantity);
					if ($prod === TRUE)
					{
						product_updatestock_byid($product_id, $stock - $quantity);
						return (NULL);
					}
					else
						return (array("add_order" => "fail")); // For some reason. Theorically there is not enough controls to fail
				}
				return array("commandfound");
			}
				else
					return (array("outofstock" => $stock));
		}
		else
			return array("pseudo" => "notexist");
	}

	function basket()
	{
		$basket = unserialize($_SESSION['basketMovie']);

		if ($_SESSION['pseudo'])
		{
			foreach($basket as $k => $v)
			{
				$ret = add_order($k, $v, $_SESSION['pseudo']);
				if ($ret !== NULL)
					$err[] = $ret;
			}
			return $err;
		}
		return array('notconnected');
	}

	if ($_POST['from'] && in_array($_POST['from'], $functions)) {
		if (($err = $_POST['from']($_POST))) {
			$str_error = http_build_query($err);
			header('Location: ../' . $_POST['from'] . '.php?' . $str_error);
		} else
			header('Location: ../' . $_POST['success'] . '.php');
	}
?>
