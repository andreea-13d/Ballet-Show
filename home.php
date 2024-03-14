<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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


    $query = "SELECT D.nume as nume_dans, D.descriere as descriere_dans, P.nume as nume_program, P.descriere as descriere_program, P.ora, P.data
      FROM programe P
      JOIN dans_program DP ON P.id_program = DP.id_program
      JOIN dansuri D on D.id_dans = DP.id_dans
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
                echo "<h2>" . $result["nume_program"] . "</h2>";
                echo "Descriere: " . $result["descriere_program"] . "<br>";
                echo "Data: " . $result["data"] . "<br>";
                echo "Ora: " . $result["ora"] . "<br>";
                echo "<br>";
                echo "Dansuri: ". "<br>";
                $prev = $result["nume_program"];
            } else {
                if ($prev != $result["nume_program"]) {
                    echo "</div>";
                    echo "<div class='program-box'>";
                    echo "<h2>" . $result["nume_program"] . "</h2>";
                    echo "Descriere: " . $result["descriere_program"] . "<br>";
                    echo "Data: " . $result["data"] . "<br>";
                    echo "Ora: " . $result["ora"] . "<br>";
                    echo "<br>";
                    echo "Dansuri: ". "<br>";
                    $prev = $result["nume_program"];
                }
            }
            echo "<div class='dans-box'>";
            echo " " . $result["nume_dans"].": ". $result["descriere_dans"];
            echo "<br>";
            echo "<br>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    } else {
        echo "<div style='padding: 10px; font-size: 2em; margin: 10px; color: white; text-align: center'>";
        echo "<div style='color: white;'>Nu exista programe artistice.</div>";
        echo "</div>";
    }
    ?>
    
    <br><br>
    <br><br>
    

</body>
</html>
