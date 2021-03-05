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
	<link rel="stylesheet" href="css/create-account.css">
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
		<h1><span class="hamburgerLabel">Menu <i class="fa fa-bars"></i></span></h1>
        <div class="messageContainer">

                <?php

                    $file = fopen("creds.txt", "r") or die("Unable to open file!");
                    $dbpass = fread($file,filesize("creds.txt"));
                    fclose($file);

                    $username = htmlspecialchars($_POST['user']);
                    $password = htmlspecialchars($_POST['pass']);

                    // Connecting, selecting database
                    $dbconn = pg_connect("host=localhost dbname=cinemascope user=postgres password=$dbpass")
                        or die('Could not connect: ' . pg_last_error());

                    // CHECK IF USERNAME EXISTS
                    // Prepare the statement to try to mitigate SQL injection
                    $result = pg_prepare($dbconn, "test_username", "SELECT * FROM accounts WHERE username=$1");
                    // Run the statement in the database
                    $result = pg_execute($dbconn, "test_username", array($username));
                    // Finally, convert the response in an array
                    $result = pg_fetch_all($result);

                    if ( count($result) > 0 ) {
                        echo "<h3 class='errorMessage'> Username is taken </h3>";
                        echo "<a href='register.html' class='retryButton'>Try again</a>";
                    }
                    else {

                        // Prepare to add an account to the database
                        $result = pg_prepare($dbconn, "create_account", "INSERT INTO accounts(username, password) VALUES($1, $2)");

                        // Execute the prepared query
                        $query = pg_execute($dbconn, "create_account", array($username, $password));
                        if (pg_result_status($query) == "1") {
							echo "<h3 class='successMessage'> Account created successfully </h3>";
							echo "<a href='login.html' class='successButton'>Login</a>";
                        }
                    }

                    // Closing connection
                    pg_close($dbconn);

                ?>

        </div>
    </main>
	<!-- toggle the navigation bar when clicked -->
	<script type="text/javascript" src="js/navbar.js"></script>
</body>
</html>
