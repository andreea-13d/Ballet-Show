<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recenzii</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
<div class="top-bar">
        <div class="tab"><a href="home.php">Home</a></div>
        <div class="tab"><a href="review.php">Recenzii</a></div>
        <div class="tab"><a href="ticket.php">Bilete</a></div>
        <div class="tab"><a href="activity.html">Activitate</a></div>
    </div>
    <?php
    require_once "dbh.inc.php"; // include the code from dbh.inc.php to establish the database connection


    $query = "SELECT P.nume, S.username, R.text_recenzie
      FROM recenzii R
      JOIN spectatori S ON S.id_spectator = R.id_spectator
      JOIN programe P  ON R.id_program = P.id_program
      ORDER BY P.data DESC
      ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch all results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $ok = 0;
    
    // Check if the query returned any results

    if ($results) {
        echo "<div style='display:flex; flex-direction: column; margin-top: 3em'>";

        foreach ($results as $result) {
            if ($ok == 0) {
                $ok = 1;
                echo "<div class='program-box'>";
                echo "<h2>" . $result["nume"] . "</h2>";
                $prev = $result["nume"];
            } else {
                if ($prev != $result["nume"]) {
                    echo "</div>";
                    echo "<div class='program-box'>";
                    echo "<h2>" . $result["nume"] . "</h2>";
                    $prev = $result["nume"];
                }
            }
            echo "<div class='dans-box'>";
            echo "Spectator: " . $result["username"] . "<br>";
            echo "Recenzie: ". $result["text_recenzie"] . "<br>";
            echo "<br>";
            echo "<br>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    } else {
        echo "<div style='padding: 10px; font-size: 2em; margin: 10px; color: white; text-align: center'>";
        echo "<div style='color: white;'>Nu exista recenzii.</div>";
        echo "</div>";
        echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
    }

   

    ?>
    <div style='display:flex; flex-direction: column; margin-top: 3em'>
    <div class='program-box'>
     <br><br>
     <a href="create_review.php"> Scrie o recenzie  </a><br><br>
     <a href="update_review.php">Modifica o recenzie</a><br><br>
     <a href="delete_review.php">Sterge o recenzie</a><br><br>
     <br><br>
    </div>
    </div>

    

    <br><br>
    <br><br>

    <div class='bottom-bar'>
        <?php
            $query2 = "SELECT S.username, count(R.id_recenzie) as nr_recenzii
            FROM recenzii R 
            JOIN spectatori S ON S.id_spectator = R.id_spectator
            GROUP BY S.username
            HAVING COUNT(R.id_recenzie) > 0 ";

            $stmt = $pdo->prepare($query2);
            $stmt->execute();
            $rez = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<div style='display:flex; flex-direction: column; margin-top: 3em'>";
            foreach ($rez as $rezultat) {
                
                
                echo $rezultat["username"] . " -  a postat ".  $rezultat["nr_recenzii"] . "recenzii                . " . "<br>";

                
            }
        ?>
   </div>

</body>
</html>
