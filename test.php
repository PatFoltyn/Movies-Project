
        <div >
        <h4>  <?php echo $_SESSION['sess_username']; ?></h4>
        <small><cite><?php echo $_SESSION['sess_location']; ?></cite></small>
        </div>
        <div ></div>

    <hr>

        <div >
            <?php
               include 'googleMaps/map.php';
             ?>

        </div>

   
	<div>
		<?php
			include 'rec.php';
			?>
	</div>

 