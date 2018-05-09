<!DOCTYPE html>
<html lang="en">


<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap core CSS (Must be First CSS Link) -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link type="text/css" href="custom_styles.css" rel="stylesheet"/>

<title>Capstone Project</title>
</head>

<body>
	<?php
		session_start();
		include 'header.php';
		if (!isset($_SESSION['logged_in'])) {
			header('Location: ./login_prompt.php');
		}

	?>

	<?php
		switch($_GET['page']) {
			case 'main':
				include 'profile.php';
				break;
			case 'about':
				include 'about.php';
				break;
			case 'login':
				include 'login.php';
				break;
			case 'search':
				header("Location: ./search.php");
				break;
			case 'profile':
				include 'profile.php';
				break;
			default:
				include 'profile.php';
				break;
		}
	?>


	<?php

		include 'footer.php';
		include 'bootstrap_js.php';
	?>


</body>
