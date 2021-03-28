<?php
   $user_favourites = json_decode($_POST["userfavourites"], true);
    
    $uselessfile = "user";
    $uselesslink = fopen($uselessfile, 'r');
    $dbuser = fread($uselesslink, filesize($uselessfile));
    fclose($uselesslink);

    $uselessfile = "useless";
    $uselesslink = fopen($uselessfile, 'r');
    $useless = fread($uselesslink, filesize($uselessfile));
    fclose($uselesslink);

    $conn = new mysqli("sql303.epizy.com", $dbuser, $useless, "epiz_28087239_cinemascope");
    $result = $conn->query("SELECT * FROM films ORDER BY start ASC");

    // Multi-line echo
    echo <<<EOL
    <tr>
        <th>Film Name</th>
        <th>Release Year</th>
        <th>Critic Rating</th>
        <th>Duration (mins)</th>
        <th>Start Time</th>
    </tr>
    EOL;

    while ($row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        foreach($row as $column => $value) {
            // Check if the current film id is a favourite
            if ($column != "id"){

                // Remove the seconds from the start time
                $seconds = strpos($value, ":00");
                // If the column's last 3 character are :00 
                if ($column === "start" && $seconds == strlen($value)-4) {
                    $newTime = substr($value, 0, strlen($value)-3);
                    echo "<td>$newTime</td>";
                }

                else {
                    echo "<td>".$value."</td>";
                }
            }
        }
        
        // Add a button at the end. The button will change if the film is already a favourite
        if (gettype($user_favourites) == "array") {
            if (array_search($row["id"], $user_favourites) === FALSE) {
                echo '<td><button title="Add to favourites" class="favourite-button"><i class="fa fa-star-o favourite-star" aria-hidden="true"></i></button></td>';
            } else {
                echo '<td><button title="Remove from favourites" class="favourite-button favourite"><i class="fa fa-star favourite-star" aria-hidden="true"></i></button></td>';
            }
            echo "</tr>";
        }
    }
    $conn->close();
?>
