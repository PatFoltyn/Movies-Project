<div class="container">
  <div class="row">
        <div class="col-md-6">
        <h4>  <?php echo $_SESSION['sess_username']; ?></h4>
        <small><cite><?php echo $_SESSION['sess_location']; ?></cite></small>
        </div>
        <div class="col-md-6"><?php
			include '/rec.php';
			?></div>

    </div>
    <hr>
    <div class="row" style="height:350px;width:1200px;">
        <div class="col-md-12" style="height:60%;width:100%;">
            <?php include 'googleMaps/map.php'; ?>
        </div>
    </div>
</div>
