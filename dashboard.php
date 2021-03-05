<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>CinemaScope</title>
	<!-- Using icons from font awesome -->
	<link href="fontawesome4/css/font-awesome.min.css" rel="stylesheet">
	<!-- Google fonts -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<!-- Ubuntu Condensed font from google -->
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
	<!-- DotGothic16 font from google -->
	<link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
	<nav>
		<span class="hamburgerClose"><i class="fa fa-times" aria-hidden="true"></i></span>
		<div class="linkContainer">
			<span><a href="index.html" class="link" id="home">Home</a></span>
			<span><a href="about.html" class="link" id="about">About</a></span>
			<span><a href="times.html" class="link" id="times">Times</a></span>
			<span><a href="faq.html" class="link" id="faq">FAQ</a></span>
			<span><a href="festivals.html" class="link" id="festivals">Festivals</a></span>
			<span><a href="login.html" class="link" id="login">Login</a></span>
			<span><a href="register.html" class="link" id="register">Register</a></span>
		</div>
	</nav>
	<main>
		<h1 class="logoText">Account Status</h1>
		<h1 class="account">Logged in as <?php echo htmlspecialchars($_POST['user']); ?></h1>
		<h1><span class="hamburgerLabel">Menu <i class="fa fa-bars"></i></span></h1>
        <div class="messageContainer">
			<table class="films">
				<tr>
					<th>Film Name</th>
					<th>Release Year</th>
					<th>Critic Rating</th>
					<th>Duration (mins)</th>
					<th>Start Time</th>
				</tr>

				<!-- FETCH FILMS FROM film database. A table is created -->
				<?php
					// Connecting, selecting database
					$dbconn = pg_connect("host=localhost dbname=cinemascope user=postgres password=$dbpass")
						or die('Could not connect: ' . pg_last_error());

					// Fetch films
					$query = 'SELECT * FROM films ORDER BY start ASC';
					$result = pg_query($query) or die('<h3 class="errorMessage">Cannot fetch films: ' . pg_last_error() . '</h3>');

					while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
					    echo "\t<tr>\n";
					    foreach ($line as $col_value) {
							// Remove the seconds from the start time
							$seconds = strpos($col_value, ":00:00");
							if ($seconds != false) {
								$newTime = substr($col_value, 0, strlen($col_value)-3);
								echo "\t\t<td>$newTime</td>\n";
							}

							else {
								echo "\t\t<td>$col_value</td>\n";
							}

					    }
					    echo "\t</tr>\n";
					}

					// Free resultset
					pg_free_result($result);

					// Closing connection
                    pg_close($dbconn);
                ?>
			</table>

			<table class="films">
				<tr>
					<th>Film Name</th>
					<th>Release Year</th>
					<th>Critic Rating</th>
					<th>Duration (mins)</th>
					<th>Start Time</th>
				</tr>

				<!-- FETCH FAVOURITES FROM credentials database. A table is created -->
				<?php
					// Connecting, selecting database
					$dbconn = pg_connect("host=localhost dbname=cinemascope user=postgres password=$dbpass")
						or die('Could not connect: ' . pg_last_error());

					// Fetch films
					$query = 'SELECT * FROM films ORDER BY start ASC';
					$result = pg_query($query) or die('<h3 class="errorMessage">Cannot fetch favourites: ' . pg_last_error() . '</h3>');

					while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
					    echo "\t<tr>\n";
					    foreach ($line as $col_value) {
							echo "\t\t<td>$col_value</td>\n";
						}
						echo "\t</tr>\n";
					}

					// Free resultset
					pg_free_result($result);

					// Closing connection
                    pg_close($dbconn);
                ?>
			</table>
        </div>
    </main>
	<!-- toggle the navigation bar when clicked -->
	<script type="text/javascript" src="js/navbar.js"></script>
</body>
</html>
