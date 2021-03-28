<?php
    header('Access-Control-Allow-Origin: *'); 
    header("Content-Type: application/json; charset=UTF-8");

    // Create a connection to the database using credentials from local files
    $uselessfile = "user";
    $uselesslink = fopen($uselessfile, 'r');
    $dbuser = fread($uselesslink, filesize($uselessfile));
    fclose($uselesslink);

    $uselessfile = "useless";
    $uselesslink = fopen($uselessfile, 'r');
    $useless = fread($uselesslink, filesize($uselessfile));
    fclose($uselesslink);

    $conn = new mysqli("sql303.epizy.com", $dbuser, $useless, "epiz_28087239_cinemascope");
    
    $action = htmlspecialchars($_POST["action"]);
    $account_id = htmlspecialchars($_POST["accountid"]);

    $response = array();

    // CUSTOM ERROR HANDLING TO PREVENT WARNINGS FROM MESSING UP JSON REPONSE
   function handler($errno, $errstr, $errfile, $errline) {
        $message ="$errstr in $errfile at Line: $errline <br>";
        echo $message;
    }
    
    set_error_handler('handler');

    function getFavourites($conn, $account_id) {
        // FIND THE FILM ID OF THE USER'S FAVOURITES
        $user_favourites = array();
        $favourites = $conn->query("SELECT filmId FROM favourites WHERE userId=".$account_id);
        while ($row = mysqli_fetch_assoc($favourites)){
            array_push($user_favourites, $row["filmId"]);
        }

        if (! isset($user_favourites)) {
            $user_favourites = "none";
        }
        return $user_favourites;
    }

    function getFilmName($conn, $film_name){
        // GET THE ID OF THE FILM NAME
        if (!($stmt = $conn->prepare("SELECT id FROM films WHERE name=?"))) {
            array_push($response, "Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        if (!$stmt->bind_param("s", $film_name)) {
            array_push($response,  "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        
        if (!$stmt->execute()) {
            array_push($response, "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        $stmt->bind_result($film_id);
        $stmt->fetch();
        $stmt->close();
        return $film_id;
    }

    function addFavourite($conn, $account_id, $film_id) {
        if (!($stmt = $conn->prepare("DELETE FROM favourites WHERE userId=? AND filmId=?"))) {
            array_push($response, "Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
    
        if (!$stmt->bind_param("ss", $account_id, $film_id)) {
            array_push($response, "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        if (!$stmt->execute()) {
            array_push($response, "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            $result = FALSE;
        } else {
            $result = TRUE;
        }
    
        $stmt->fetch();
        $stmt->close();
        return $result;
    }

    function removeFavourite($conn, $account_id, $film_id) {
        if (!($stmt = $conn->prepare("INSERT INTO favourites VALUES (?, ?)"))) {
            array_push($response,   "Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
    
        if (!$stmt->bind_param("ss", $account_id, $film_id)) {
            array_push($response,  "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        if (!$stmt->execute()) {
            array_push($response,   "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            $result = FALSE;
        } else {
            $result = TRUE;
        }
    
        $stmt->fetch();
        $stmt->close();
        return $result;
    }

    echo "ACTION: $action";

    if ($action != "fetch") {
        $film_name = htmlspecialchars($_POST["filmname"]);
        $film_id = getFilmName($conn, $film_name);
    }

    if ($action == "add") {
        array_push($response, "ADD: STATUS".addFavourite($conn, $account_id, $film_id));
    } elseif ($action == "remove") {
        array_push($response, "REMOVE: STATUS ".removeFavourite($conn, $account_id, $film_id));
    } elseif ($action == "fetch") {
        $user_favourites = getFavourites($conn, $account_id);
        // Add return an array of the IDs of the user's favourite films 
        array_push($response, $user_favourites );
    } else {
        array_push($response,  "ERROR: Unkown action specified");
    }
    
    // CHECK IF THE FILM IS ALREADY A FAVOURITE 
    if (!($stmt = $conn->prepare("SELECT * FROM favourites WHERE userId=? AND filmId=?"))) {
        array_push($reponse, "Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    if (!$stmt->bind_param("ss", $account_id, $film_id)) {
     array_push($reponse, "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    if (!$stmt->execute()) {
        array_push($response, "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        removeFavourite($conn, $account_id, $film_id);
    } else {
        addFavourite($conn, $account_id, $film_id);
    }

    $stmt->close();
    
    echo $response;

    $conn->close();

?>
