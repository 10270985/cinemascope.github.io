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
			<span><a href="dashboard.php" class="link" id="times">Times</a></span>
			<span><a href="faq.html" class="link" id="faq">FAQ</a></span>
			<span><a href="festivals.html" class="link" id="festivals">Festivals</a></span>
			<span><a href="login.html" class="link" id="login">Login</a></span>
			<span><a href="register.html" class="link" id="register">Register</a></span>
		</div>
	</nav>
	<main>
		<p id="serverResponse"></p>
		<h1 class="logoText">Account Status</h1>
        <?php

            // Credentials are stored in files, users do not have access to these files but the server does

            // Read username from a file
            $uselessfile = "user";
            $uselesslink = fopen($uselessfile, 'r');
            $dbuser = fread($uselesslink, filesize($uselessfile));
            fclose($uselesslink);

            // Read password from a file
            $uselessfile = "useless";
            $uselesslink = fopen($uselessfile, 'r');
            $useless = fread($uselesslink, filesize($uselessfile));
            fclose($uselesslink);

            $conn = new mysqli("sql303.epizy.com", $dbuser, $useless, "epiz_28087239_cinemascope");
            if ($conn->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }

            // Check if the "user" and "pass" variables were given the the website (through POST requests)
            // An error would occur if the variable was set to something that didn't exist
			if ( isset($_POST['user']) && isset($_POST['pass']) ) {
                // htmlspecial chars is used to remove harmful characters that could be used for attacks (escape sequences)
				$username = htmlspecialchars($_POST['user']);
				$password = htmlspecialchars($_POST['pass']);
			
                // Check that something was given for the username
				if(!$username == "") {

						if (!($stmt = $conn->prepare("SELECT username FROM accounts WHERE username=? AND password=?"))) {
							echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
						}

                        // Insert the variables into the sql statement
                        // The variables are checked for bad characters that could be used to attack the database (sql injection)
						if (!$stmt->bind_param("ss", $username, $password)) {
						    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
						}

                        // Execute the sql statement in the database
						if (!$stmt->execute()) {
							echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
						}

						// Assign the all records to a variable (result)
						$stmt->bind_result($result);
						$stmt->fetch();

						/* close statement */
						$stmt->close();

                        // If an account exists with that username/password
						if (strlen($result) > 0 ) {
							echo '<h1 class="account">Logged in as  '.$result.'</h1>';
							$authenticated = TRUE;
                        // If no accounts are found with that username/password
						} else {
							echo "<h1 class='account' style='color:red;'>INCORRECT CREDENTIALS</h1>";
							$authenticated = FALSE;
						}
                // If the username is blank
				} else {
					echo "<h1 style='color:red;' class='account'>NO USERNAME GIVEN</h1>";
					$authenticated = FALSE;
				}
				
				// SAVE THE USER ID TO A VARIABLE FOR LATER USE
				if (!($stmt = $conn->prepare("SELECT id FROM accounts WHERE username=?"))) {
					echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
				}

				if (!$stmt->bind_param("s", $username)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				}
				if (!$stmt->execute()) {
					echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				}

				$stmt->bind_result($user_id);
				$stmt->fetch();

				/* close statement */
				$stmt->close();
		} else {
			echo "<h1 style='color:red;' class='account'>NO USERNAME GIVEN</h1>";
			$authenticated = FALSE;
		}

		if (! $authenticated) {
			$user_id = "null";
			$password = "null";
		}
		?>

		<!-- Transfer PHP variables to javascript -->
		<script type="text/javascript">
			const userId = `<?php echo "$user_id;" ?>`;
			const pass = `<?php echo $password ?>`
		</script>

        <h1><span class="hamburgerLabel">Menu <i class="fa fa-bars"></i></span></h1>
		<div class="messageContainer">
			<table id="film-table">

				<!-- PUT SHIT HERE -->

			</table>
		</div>
    </main>
	<!-- import jQuery -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="></script>

	<!-- toggle the navigation bar when clicked -->
	<script type="text/javascript" src="js/navbar.js"></script>

	<!-- For the favourite film functionality -->
	<script type="text/javascript" src="js/favourites.js"></script>

	</script>
</body>
</html>
