<?php
		session_start();
		$_SESSION['logged_in'] = False;
		session_destroy();
		header('Location: index.php?page=main');
		exit();

?>
