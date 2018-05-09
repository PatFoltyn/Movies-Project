<nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Magical Movie Marks</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample04">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="./index.php?page=main">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./index.php?page=about">About</a>
          </li>
					<li class="nav-item">
            <a class="nav-link" href="./index.php?page=search">Search</a>
          </li>
					<li class="nav-item">
            <a class="nav-link" href="./index.php?page=profile">Profile</a>
          </li>
        </ul>
        <ul class="navbar-nav my-2 my-md-0">
          <li class="nav-item"><img src="<?php echo $_SESSION['sess_profImg']; ?>" width=30 height=30 alt="Profile Pic"></li>
          <li class="nav-item">
						<?php session_start(); if (($_SESSION['logged_in']) == True) { ?>
						<a class="nav-link" href="logout.php">LogOut</a>
						<?php } else { ?>
						<a class="nav-link" href="./index.php?page=login">LogIn</a>
						<?php
						}
						?>
					</li>
				</ul>
      </div>
</nav>
