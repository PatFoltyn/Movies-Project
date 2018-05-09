

	<?php

	require 'twitter_app/db_conn.php';

	
	$e = mysqli_query($connection, "SELECT COUNT(*) FROM `movSearch`");
	$res = mysqli_fetch_array($e);
	
	
	if($res[0] == 0){
		echo "Enter a search on the search page";
	} else{
		require 'twitter_app/db_conn.php';
		$result = mysqli_query($connection, "SELECT COUNT(*) AS `count` FROM `movSearch`");
		$row = mysqli_fetch_array($result);
		$num = $row['count'];

		$query = mysqli_query($connection, "SELECT * FROM `movSearch` WHERE `count` = $num");
		$data = mysqli_fetch_array($query);
		

		
		
		echo 'Since you searched "' . $data['firstMov'] . '", <br> here are some recommendations.';
		

		

		$recUrl = 'https://api.themoviedb.org/3/movie/' . $data['movID'] . '/recommendations?api_key=2b026bda7ea9b58930161475b7d89a62&language=en-US&page=1';


		$search_json = file_get_contents($recUrl);
		$search_array = json_decode($search_json,true);

		$prefix = "https:/image.tmdb.org/t/p/w500/";
		$count = 0;
			
		
			if(is_array($search_array)){
				foreach($search_array[results] as $movie){
					if($movie[original_language] == "en"){
						$s.="<p><img src= $prefix.$movie[poster_path] height=80 width=60/></p>";
						$s.="<p>Title: $movie[original_title] <br>$movie[release_date] </p> <br>";
						if ($count++ == 2) break;
				}
				}
			}

			echo $s;
		}
		include 'bootstrap_js.php';
?>
