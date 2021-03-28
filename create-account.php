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

			<span><a href="dashboard.php" class="link" id="times">Times</a></span>

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

                // CHECK IF USERNAME EXISTS
                $uselessfile = "user";
                $uselesslink = fopen($uselessfile, 'r');
                $dbuser = fread($uselesslink, filesize($uselessfile));
                fclose($uselesslink);

                $uselessfile = "useless";
                $uselesslink = fopen($uselessfile, 'r');
                $useless = fread($uselesslink, filesize($uselessfile));
                fclose($uselesslink);


    
                $conn = new mysqli("sql303.epizy.com", $dbuser, $useless, "epiz_28087239_cinemascope");


                $user = htmlspecialchars($_POST['user']);

                $pass = htmlspecialchars($_POST['pass']);

                if ($conn->connect_errno) {
                    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                }


                // Prepare the statement to try to mitigate SQL injection
                if (!($stmt = $conn->prepare("SELECT * FROM accounts WHERE username=?"))) {

                    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;

                }



                    if (!$stmt->bind_param("s", $user)) {

                        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;

                    }

                // Query the database

                if (!$stmt->execute()) {

                    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;

                }

                /* instead of bind_result: */

                $result = $stmt->get_result();



                if (count($result->fetch_assoc()) > 0) {

                    echo "<h3 class='errorMessage'> Username is taken </h3>";

                    echo "<a href='register.html' class='retryButton'>Try again</a>";

                } else {



                    // Prepare to add an account to the database                        

                    if (!($stmt = $conn->prepare("INSERT INTO accounts(username, password) VALUES(?,?)"))) {

                        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;

                    }

                                        $user = htmlspecialchars($_POST['user']);

                $pass = htmlspecialchars($_POST['pass']);

                    if (!$stmt->bind_param("ss", $user, $pass)) {

                        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;

                    }



                    // Execute the prepared query

                    if (!$stmt->execute()) {

                        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;

                    } else {

                        echo "<h3 class='successMessage'> Account created successfully </h3>";

                        echo "<a href='login.html' class='successButton'>Login</a>";

                    }

                    

                }



                // Closing connection
                $conn->close();
            ?>


        </div>

    </main>

	<!-- toggle the navigation bar when clicked -->

	<script type="text/javascript" src="js/navbar.js"></script>

</body>

</html>

