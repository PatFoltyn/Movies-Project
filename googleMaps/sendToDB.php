<div style="height:0;">
<?php
include 'places.php';

$server = "localhost";
$username = "root";
$password = "mysql";
$databaseName = "cap";

$connection = new mysqli($server,$username,$password,$databaseName);

$insertSQL = "INSERT INTO test (name,address,searched) VALUES ($nameOne,$addressOne,1), ($nameTwo,$addressTwo,1), ($nameThree,$addressThree,1), ($nameFour,$addressFour,1), ($nameFive,$addressFive,1) ON DUPLICATE KEY UPDATE searched = searched + 1; ";

if($connection->query($insertSQL) === TRUE){
       }else{
   echo "Error: ".$insertSQL."<br>".$connection->error;
       }

$connection->close();

?>
</div>
