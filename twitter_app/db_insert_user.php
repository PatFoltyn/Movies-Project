<?php
  require 'db_conn.php';

  //Checks if the user is already registered to DB
  function userInDatabase($dbUserId) {
    require 'db_conn.php';
    $query = "SELECT user_ID FROM `user` WHERE user_ID = $dbUserId";
    $result = mysqli_query($connection, $query);
    $result = mysqli_fetch_assoc($result);
    $chkUserId = $result['user_ID'];
    $connection->close();
    if($dbUserId == $chkUserId){
      return TRUE;
    } else {
      return FALSE;
    }
  }

  function updateDatabase($dbUserId,$dbScreenName,$dbLocation,$dbImg) {
    require 'db_conn.php';
    $query = "SELECT * FROM `user` WHERE user_ID = $dbUserId";
    $result = mysqli_query($connection, $query);
    $result = mysqli_fetch_assoc($result);
    $chkUserScrN = $result['user_scr_name'];
    $chkUserLoc = $result['user_location'];
    $chkUserImg = $result['user_profile_img'];
    if($dbScreenName != $chkUserScrN){
      $insertSQL = "UPDATE `user` SET `user_scr_name` = '$dbScreenName' WHERE `user_ID` = '$dbUserId'";
      if($connection->query($insertSQL) === TRUE){

        echo "Success";
      } else {
        echo "Error";
      }
    }
    if($dbLocation != $chkUserLoc){
      $insertSQL = "UPDATE `user` SET `user_location`= '$dbLocation' WHERE `user_ID` = '$dbUserId'";
      if($connection->query($insertSQL) === TRUE){

        echo "Success";
      } else {
        echo "Error";
      }

    }
    if($dbImg != $chkUserImg){
      $insertSQL = "UPDATE `user` SET `user_profile_img` = '$dbImg' WHERE `user_ID` = '$dbUserId'";
      if($connection->query($insertSQL) === TRUE){

        echo "Success";
      } else {
        echo "Error";
      }
    }
    $connection->close();
  }



  //Set twitter results to variables
  $dbUserId = $user->id;
  $dbScreenName = $user->screen_name;
  $dbLocation = $user->location;
  $dbImg = $user->profile_image_url;


  if(!userInDatabase($dbUserId)){

    //Inserts Data into DB
    $insertSQL = "INSERT INTO user (user_ID,user_scr_name,user_location,user_profile_img) VALUES ('$dbUserId','$dbScreenName','$dbLocation','$dbImg')";

    if($connection->query($insertSQL) === TRUE){

      echo "Success";
    } else {
      echo "Error: ".$insertSQL."<br/>".$connection->error;
    }
  }

  updateDatabase($dbUserId,$dbScreenName,$dbLocation,$dbImg);

  $connection->close();

 ?>
