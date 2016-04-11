<?php
	require_once('mysqli.php');
	require_once('people.php');
	/*
	* Pour une raison ou une autre je n'ai pas réussi a update la base de données ... Si tu peux le faire, j'avais en idée :

	table 'validmail' (id, int)(author, varchar255)(subject, varchar100)(heders, text500)(message, text1500)
	AND
	table 'sentmail' (id, int)(author, varchar255)(to, varchar255)(subject, varchar100)(headers, text500)(message, text1500)(when, datetime (AUTO)))(sent, BOOL)(people_id, lien vers people_id (facultatif)))

	* Would have love to use "from" instead of "author", but mysql uses this keyword. Bastard
	*/

	// While reading my own comments (cause i have swag) I realised that i used french AND english. Hmm. Sorry.

	/* P.S : Merci */

	function mail_create(string $pseudo, string $to, string $subject, string $message)
	{
		$err = NULL;

		if (strlen($pseudo) > 45 || strlen($pseudo) < 5)
			$err[] = 'pseudo';
		if (filter_var($to, FILTER_VALIDATE_EMAIL) === FALSE)
			$err[] = 'to';
		if (strlen($subject) > 255)
			$err[] = 'subject';
		if (strlen($message) > 1500)
			$err[] = 'message';
		if ($err !== NULL)
			return $err;
		$people = $people_exist($pseudo);
		if ($people)
		{
			$db = database_conect();
			$message = str_replace("/n", "<br />/n", $message);
			$message = str_replace("<script>", "&lt;script&gt;", $message); /* So mutch sanityzing ... */
			$message = str_replace("</script>", "&lt;/script&gt;", $message); /* Script is disabled */
			$message = htmlentities($message, ENT_QUOTES);
			$subject = str_replace("<script>", "&lt;script&gt;", $subject); /* But we still let html open for send beautifull emails */
			$subject = str_replace("</script>", "&lt;/script&gt;", $subject); /* Or even uglier */
			$subject = htmlentities($subject, ENT_QUOTES);
			$sent = FALSE;
			$author = $people['mail'];
			$id = $people['id'];
			$to = mysqli_real_escape_string($db, $to);
			$subject = mysqli_real_escape_string($db, $subject);
			$message = ($db, $message);
			$headers = "From: " . $author . "\r\n" .
				'Reply-to: ' . $author . "\r\n";
			if (mail($to, $subject, $message, $headers) === TRUE)
				$sent = TRUE;
			$req = "INSERT INTO sentmail (author, to, subject, headers, message, sent, $id)
				VALUES sentmail ('$author', '$to', '$subject', '$headers', '$message', '$sent', '$id')";
			$req = mysqli_query($db, $req);
			return ($req);
		}
	}

	function mail_delete(int $id)
	{
		$db = database_conect();
		$req = "DELETE FROM sentmail WHERE id = '$id'";
		$req = mysqli_query($db, $req);
		return $req;
	}

	function mail_delete_bypseudoid(int $pseudo_id)
	{
		$db = database_conect();
		$req = "DELETE FROM sentmail WHERE pseudo_id = '$pseudo_id'";
		$req = mysqli_query($db, $req);
		return $req;
	}

	function mail_get()
	{
		$db = database_connect();
		$req = "SELECT * FROM sentmail";
		$req = mysqli_query($db, $req);
		$ret = mysqli_fetch_assoc($req);
		return $ret;
	}

	function mail_get_bypseudoid(int $pseudo_id)
	{
		$db = database_connect();
		$req = "SELECT * FROM sentmail WHERE pseudo_id = '$pseudo_id'";
		$req = mysqli_query($db, $req);
		$ret = mysqli_fetch_assoc($req);
		return $ret;	
	}

	function mail_get_byid(int $id)
	{
		$db = database_connect();
		$req = "SELECT * FROM sentmail WHERE id = '$id'";
		$req = mysqli_query($db, $req);
		$ret = mysqli_fetch_assoc($req);
		return $ret;	
	}

