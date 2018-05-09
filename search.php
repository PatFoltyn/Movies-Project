<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap core CSS (Must be First CSS Link) -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link type="text/css" href="custom_styles.css" rel="stylesheet"/>

<title>Capstone Project</title>
</head>


<?php session_start(); include 'header.php'; ?>
<div class = "container-fluid card">
	<div class = "row ">
	<div class = "col-md-6">

<form action = "./search.php">
<input type = "text" name = "search" placeholder = "Search by Title"/>
<br>
<select name="gens">
 <option value="" selected>Select a genre:</option>
 <option value="action">Action</option>
 <option value="adventure">Adventure</option>
 <option value="animation">Animation</option>
 <option value="comedy">Comedy</option>
 <option value="crime">Crime</option>
 <option value="documentary">Documentary</option>
 <option value="drama">Drama</option>
 <option value="family">Family</option>
 <option value="fantasy">Fantasy</option>
 <option value="history">History</option>
 <option value="horror">Horror</option>
 <option value="music">Music</option>
 <option value="mystery">Mystery</option>
 <option value="romance">Romance</option>
 <option value="science">Science Fiction</option>
 <option value="tv">TV Movie</option>
 <option value="thriller">Thriller</option>
 <option value="war">War</option>
 <option value="western">Western</option>
</select>
<button type = "submit">Submit</button>
</form>




<?php
require 'twitter_app/db_conn.php';

if(isset($_GET['gens'])){
 if($_GET['gens'] == ''){
   $genCode = "Select valid genre!";
 } elseif ($_GET['gens'] == 'action'){
   $genCode = 28;
 } elseif ($_GET['gens'] == 'adventure') {
   $genCode = 12;
 } elseif ($_GET['gens'] == 'animation') {
   $genCode = 16;
 } elseif ($_GET['gens'] == 'comedy') {
   $genCode = 35;
 } elseif ($_GET['gens'] == 'crime') {
   $genCode = 80;
 } elseif ($_GET['gens'] == 'documentary') {
   $genCode = 99;
 } elseif ($_GET['gens'] == 'drama') {
   $genCode = 18;
 } elseif ($_GET['gens'] == 'family') {
   $genCode = 10751;
 } elseif ($_GET['gens'] == 'fantasy') {
   $genCode = 14;
 } elseif ($_GET['gens'] == 'history') {
   $genCode = 36;
 } elseif ($_GET['gens'] == 'horror') {
   $genCode = 27;
 } elseif ($_GET['gens'] == 'music') {
   $genCode = 10402;
 } elseif ($_GET['gens'] == 'mystery') {
   $genCode = 9648;
 } elseif ($_GET['gens'] == 'romance') {
   $genCode = 10749;
 } elseif ($_GET['gens'] == 'science') {
   $genCode = 878;
 } elseif ($_GET['gens'] == 'tv') {
   $genCode = 10770;
 } elseif ($_GET['gens'] == 'thriller') {
   $genCode = 53;
 } elseif ($_GET['gens'] == 'war') {
   $genCode = 10752;
 } elseif ($_GET['gens'] == 'western') {
   $genCode = 37;
 }
}






if(!empty($_GET['search'])){
$search_url = 'https://api.themoviedb.org/3/search/movie?api_key=2b026bda7ea9b58930161475b7d89a62&language=en-US&query=' . urlencode($_GET['search']) . '&page=1&include_adult=false&region=US%7CCA';

$search_json = file_get_contents($search_url);
$search_array = json_decode($search_json,true);
}


$prefix = "https://image.tmdb.org/t/p/w500/";

if(!empty($_GET['search']) and !($_GET['gens'] == '')){
echo "You are searching for movies with keyword \"" . ucfirst($_GET['search']) . " \" in the " . ucfirst($_GET['gens']) . " category." ;
}
else{
 echo "Enter a valid search and genre!";
}

$rec = array(); //array to get movie ids
$title = array(); //array to get movie titles
$i = 0;

echo "<br>";

if(is_array($search_array)){
foreach($search_array[results] as $movie){

   if(in_array($genCode, $movie[genre_ids])){
     if($movie[original_language] == "en"){
     $s.="<p><img src= $prefix.$movie[poster_path] height=80 width=60/></p>";
     $s.="<p>Title: $movie[original_title]<br>Release Date: $movie[release_date]<hr></p>";
     array_push($rec, $movie[id]); //push ids into array
     array_push($title, $movie[original_title]); //push titles into array
     $record = array_pop(array_reverse($rec)); //return first movie id
     $titles = array_pop(array_reverse($title)); //return first movie title
	 $i++;
	 if($i == 3){
		 break;
	 }
   }
   }
 }
}
echo "<br>". $s;

if(empty($rec)){
 $record = 0;
}

if(empty($title)){
 $titles = " ";
}




$search = ucfirst($_GET['search']);

function removeZero(){
$query = "DELETE FROM `movSearch` WHERE `movID` = 0";
$result = mysqli_query($connection, $query);
}

function idInDatabase($dbMov){

$query = "SELECT 'movID' from `movSearch` WHERE 'movID' = $dbMov";
$result = mysqli_query($connection, $query);
$result = mysqli_fetch_assoc($result);
$chkID = $result['movID'];

if($dbMov == $chkID){
 return TRUE;
} else {
 return FALSE;
}
}

function updateDatabase($dbMov,$dbSearch,$dbFirst,$dbGen) {

$query = "SELECT movID FROM `movSearch` where movID = $dbMov";
$result = mysqli_query($connection, $query);
$result = mysqli_fetch_assoc($result);
 $chkSearch = $result['search'];
 $chkFirst = $result['firstMov'];
 $chkGen = $result['genCode'];

 if($dbSearch != $chkSearch){
   $insertSQL = "INSERT INTO `movSearch` (search) VALUES ('$dbSearch')";
 }
 if($dbFirst != $chkFirst){
   $insertSQL = "INSERT INTO `movSearch` (firstMov) VALUES ('$dbFirst')";
 }
 if($dbGen != $chkGen){
   $insertSQL = "INSERT INTO `movSearch` (genCode) VALUES ('$dbGen')";
 }
}

$dbMov = $record;
$dbSearch = $search;
$dbFirst = $titles;
$dbGen = $genCode;

if(!idInDatabase($dbMov)){
    
    $insertSQL = "INSERT INTO `movSearch` (search, movID, firstMov, genCode) VALUES ('$dbSearch', '$dbMov', '$dbFirst', '$dbGen')";

    if($connection->query($insertSQL) === TRUE){

    
    } else {
      
    }
	
  }

updateDatabase($dbMov,$dbSearch,$dbFirst,$dbGen); 


  


//--------------------------------------------------------------------------------------------------
?>




	</div>


	<div class = "col-md-6" >
		<h1> New York Times Reviews </h1>
<?php

//--------------------------------------------------------------------------------------------------
	if(!empty($_GET['search'])){
 		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$query = array(
  			"api-key" => "b4addf38cdea4f18a3b09d82d0cbcd2d",
  			"query" => $_GET['search']
		);


		curl_setopt($curl, CURLOPT_URL,
  			"https://api.nytimes.com/svc/movies/v2/reviews/search.json" . "?" . http_build_query($query)
		);


		$result = json_decode(curl_exec($curl), true);

	

		$item = $result[results];


		/* Sets all variables which will be put into the database */

		$displayTitle    = mysqli_real_escape_string($connection,
													 $item[0]{'display_title'});
		$headline        = mysqli_real_escape_string($connection,
													 $item[0]{'headline'});
		$linkText        = mysqli_real_escape_string($connection,
													 $item[0][link]{'suggested_link_text'});
		$linkType        = $item[0][link]{'type'};
		$linkUrl         = $item[0][link]{'url'};
		$rating          = $item[0]{'mpaa_rating'};
		$openingDate     = $item[0]{'opening_date'};
		$publicationDate = $item[0]{'publication_date'};
		$summaryShort    = mysqli_real_escape_string($connection,
													 $item[0]{'summary_short'});



		/* Prints out all results to screen*/
		for ($i = 0; $i < 3; $i++){

			echo "<br>";
			echo "Title: "        . $item[$i]{'display_title'} . "<br>";
			echo "Opening Date: " . $item[$i]{'opening_date'} . "<br>";
			echo "Rated: "        . $item[$i]{'mpaa_rating'} . "<br>";
			echo "Summary: "      . $item[$i]{'summary_short'} . "<br>";
			echo "Read the full review " . '<a target="_blank" href="' . $item[$i][link]{'url'} . '">here</a>';

			echo "<hr>";
		}

		$insertSQL = 	"INSERT INTO `reviewValues`
								 (displayTitle,openingDate, headline,
								 linkUrl, rating, summaryShort)

					 	VALUES ('$displayTitle','$openingDate', '$headline',
					  		  '$linkUrl', '$rating', '$summaryShort')";


		if ($connection->query($insertSQL) === TRUE){

		} else {
			echo "Error"."<br>".$insertSQL."<br>".$connection->error;
		}

		$connection->close();
	}

?>

<?php include 'bootstrap_js.php'; ?>

	</div>
	</div>
</div>


