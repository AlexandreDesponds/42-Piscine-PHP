<?php
session_start();
	require_once('../model/products.php');
	require_once('../model/prod_has_cat.php');
/*
	* Probably to merge in ... 'browse.php ?'
*/
	$functions = array('products', 'removeproduct', 'addproduct', 'updateproduct');

	function products()
	{
		$min = NULL;
		$max = NULL;

		if ($_GET['min'])
			$min = floatval($_GET['min']);

		if ($_GET['max'])
			$max = floatval($_GET['max']);

		return (products_get_byprice($min, $max));
		if ($_GET['category'])
			return (products_get_bycat($_GET['category']));
		else
			return (products_get_byprice($min, $max));
	}

	function addproduct(array $datas)
	{
		$err = NULL;
		if (!$datas['name'])
			$err[] = 'name';
		if (!isset($datas['price']))
			$err[] = 'price';
		if (!isset($datas['isAdult']))
			$err[] = 'isAdult';
		if (!isset($datas['stock']))
			$err[] = 'stock';
		if (!isset($datas['databaseid']))
			$err[] = 'databaseid';
		if ($err !== NULL)
			return ($err);
		$req['databaseid'] = $datas['databaseid'];
		$req['name'] = $datas['name'];
		$req['price'] = $datas['price'];
		$req['isAdult'] = (bool)$datas['isAdult'];
		$req['stock'] = intval($datas['stock']);
		$req['picture'] = null;
		if (product_create($req['name'], $req['picture'], $req['isAdult'], $req['price'], $req['databaseid']))
			return NULL;
		return array('error');
	}

	function updateproduct(array $datas)
	{
		$err = NULL;
		if (!$datas['name'])
			$err[] = 'name';
		if (!isset($datas['price']))
			$err[] = 'price';
		if (!isset($datas['isAdult']))
			$err[] = 'isAdult';
		if (!isset($datas['stock']))
			$err[] = 'stock';
		if ($err !== NULL)
			return ($err);
		$datas['price'] = intval($datas['price']);
		$datas['isADult'] = (bool)$datas['isAdult'];
		$datas['stock'] = intval($datas['stock']);
		if (isset($datas['picture']))
			$datas['picture'] = $datas['picture'];
		if (product_create2($datas['name'], $datas['picture'], $datas['isAdult'], $datas['price'], $datas['databaseid'], $datas['stock'], $datas['id']))
			return NULL;
		return array('error');
	}

	function removeproduct(array $datas)
	{
		if ($datas['name'])
		{
			if (product_delete($datas['name']) === TRUE)
				return null;
			else
				return (array("notexist"));
		}
		else if ($datas['id'])
		{
			if (product_clear_byid($datas['id']) === TRUE)
				return NULL;
			else
				return (array("notexist"));
		}
		else
			return (array("datanotfound"));
	}

	if ($_POST['from'] && in_array($_POST['from'], $functions)) {
		if (($err = $_POST['from']($_POST))) {
			$str_error = http_build_query($err);
			header('Location: ../' . $_POST['success'] . '.php?' . $str_error);
		} else
			header('Location: ../' . $_POST['success'] . '.php');
	}
?>
