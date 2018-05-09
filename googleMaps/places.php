<?php
session_start();
include 'moviesproject.com/twitter_app/grab_info.php';

$place = $_SESSION['sess_location'];
$place = str_replace(" ","+",$place);
$place = str_replace(",","+",$place);

$url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=movie+theater+in+".$place."&key=AIzaSyCJ_3FZnNCLe_GUTe-QWHW93uegjeRfzzU";


function get_json( $url )
{
    //found some options on stack overflow
    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING       => "",
        CURLOPT_AUTOREFERER    => true,
        CURLOPT_CONNECTTIMEOUT => 120,
        CURLOPT_TIMEOUT        => 120,
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_SSL_VERIFYPEER => false
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);

    return ($result);
}


$urlX = get_json($url);


$jsonD = json_decode($urlX,true);

$var = $jsonD['results'];

$name = "";
$address = "";
$arrayName = [];
$arrayAddress = [];
$arrayLat = [];
$arrayLng = [];


for ($i=0; $i <= 5; $i++) {
  $arrayName[$i] = '"'.$var[$i]{'name'}.'"';
  $arrayAddress[$i] = '"'.$var[$i]{'formatted_address'}.'"';
  $arrayLat[$i] = $var[$i]['geometry']['location']{'lat'};
  $arrayLng[$i] = $var[$i]['geometry']['location']{'lng'};
 }

 $nameOne = $arrayName[0];
 $nameTwo = $arrayName[1];
 $nameThree = $arrayName[2];
 $nameFour = $arrayName[3];
 $nameFive = $arrayName[4];

 $addressOne = $arrayAddress[0];
 $addressTwo = $arrayAddress[1];
 $addressThree = $arrayAddress[2];
 $addressFour = $arrayAddress[3];
 $addressFive = $arrayAddress[4];

 $latOne = $arrayLat[0];
 $lngOne = $arrayLng[0];
 
 $sub = [];
 
 if($nameOne != ""){
 $eOne = "(".$nameOne.",".$addressOne.",1)";
 array_push($sub, $eOne);
}

 if($nameTwo != ""){
 $eTwo = "(".$nameTwo.",".$addressTwo.",1)";
 array_push($sub, $eTwo);
}

 if($nameThree != ''){
 $eThree = "(".$nameThree.",".$addressThree.",1)";
 array_push($sub, $eThree);
}

 if($nameFour != ''){
 $eFour = "(".$nameFour.",".$addressFour.",1)";
 array_push($sub, $eFour);
}

 if($nameFive != ''){
 $eFive = "(".$nameFive.",".$addressFive.",1)";
 array_push($sub, $eFive);
}

 $fSub = implode(",", $sub);
 

 
$server = "localhost";
$username = "teamCapstone";
$password = "Robinson1!";
$databaseName = "capstone2018";

$connection = new mysqli($server,$username,$password,$databaseName);

$insertSQL = "INSERT INTO test (name,address,searched) VALUES $fSub ON DUPLICATE KEY UPDATE searched = searched + 1; ";
$top = "SELECT * FROM test LIMIT 1;";
$query = "SELECT * from `test`ORDER BY `searched` DESC LIMIT 1";
$result = mysqli_query($connection, $query);
$result = mysqli_fetch_assoc($result);
$chkName = $result['name'];
echo "<strong>Most Searched Theater:</strong>"?><br><?php
print_r( $chkName);
?><br><br><br><?php
if($connection->query($insertSQL) === TRUE){
       }else{
   echo "Error: ".$insertSQL."<br>".$connection->error;
       }

$connection->close();


 ?>
