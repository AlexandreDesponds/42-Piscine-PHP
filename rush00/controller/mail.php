<?php
session_start();
	require_once('../model/mail.php');

	$functions = array("send_validmail");
	/*
		C'est un essaie à la base, jamais fait. Mais je suis trop crevé pour y reflechir en fait :D
	*/

	function send_validmail(string $pseudo)
	{
		$people = people_exist($pseudo);

	}

	if ($_POST['from'] && in_array($_POST['from'], $functions))
	{
		if (($err = $_POST['from']($_POST))) // get_order returns NULL || FALSE on error, not on success
		{
			$str_error = http_build_query($err);
			header('Location: ' . $_POST['from'] . '.php?' . $str_error);
		}
		else
			header('Location:' . $_POST['from'] . '.php');
	}
?>
