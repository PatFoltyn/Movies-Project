<?php
  include 'db_conn.php';
  $twitUserId = $user->id;
  $SQLchecker = "SELECT * FROM `user` WHERE user_ID = '$twitUserId'";
	$result = mysqli_query($connection, $SQLchecker);
	$result = mysqli_fetch_assoc($result);
	$_SESSION['sess_username'] = $result['user_scr_name'];
  $_SESSION['sess_profImg'] = $result['user_profile_img'];
	$_SESSION['sess_location'] = $result['user_location'];
  $connection->close();
 ?>
