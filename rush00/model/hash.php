<?php
	function admin_pass($password)
	{
		return hash('ripemd256', hash('whirlpool', '98fsd&(' . $password) . '+fsd!34%');
	}

	function user_pass($password)
	{
		return hash('sha256', hash('snefru', '^&fsd+&' . $password) . 'gfd765-+');
	}

	function get_valid_key()
	{
		return hash("ripemd128", "89fd&^" . $datas['pseudo']); // La sécurité minimale, inutile d'aller plus loin
	}
?>