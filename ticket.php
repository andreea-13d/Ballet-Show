<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilete</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
    <div class="top-bar">
        <div class="tab"><a href="home.php">Home</a></div>
        <div class="tab"><a href="review.php">Recenzii</a></div>
        <div class="tab"><a href="ticket.php">Bilete</a></div>
        <div class="tab"><a href="activity.html">Activitate</a></div>
    </div>

    <!-- Adaugă 4 "box-uri" pentru bilet -->
    <div class="program-box2">
        <p>Programe cu bilete disponibile</p>
    <?php
    require_once "dbh.inc.php"; // include the code from dbh.inc.php to establish the database connection

    $query = "SELECT P.nume, P.nr_bilete - (
                SELECT COUNT(id_bilet)
                FROM bilete B
                WHERE B.id_program = P.id_program
            ) AS bilete_disponibile
            FROM programe P";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch all results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $result) {
        echo "<div class='program-box'>"; // Deschide un div pentru fiecare înregistrare
        echo "Spectacol: " . $result["nume"] . "<br>";
        echo "Bilete disponibile: " . $result["bilete_disponibile"] . "<br>";
        echo "<br>";
        echo "<br>";
        echo "</div>"; // Închide div-ul pentru fiecare înregistrare
    }
    ?>
</div>

        
    
<div class="program-box3">
        <p>Programe cu dansuri anagrama</p>
    <?php
    require_once "dbh.inc.php"; // include the code from dbh.inc.php to establish the database connection


    $query = "SELECT D.nume AS nume_dans, P.nume as nume_program
                from dansuri D
                join dans_program DP on DP.id_dans= D.id_dans
                join programe P on DP.id_program= P.id_program 
                where ( D.id_dans, P.id_program) IN (SELECT id_dans, id_program
                                                    FROM dans_program
                                                    WHERE nr_aparitii = (SELECT MAX(nr_aparitii) 
                                                                            FROM dans_program)
                                                                            GROUP BY id_dans, id_program)";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch all results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $result) {
        echo "<div class='program-box'>"; // Deschide un div pentru fiecare înregistrare
        echo "Program: " . $result["nume_program"] . "<br>";
        echo "Dans: " . $result["nume_dans"] . "<br>";
        echo "<br>";
        echo "<br>";
        echo "</div>"; // Închide div-ul pentru fiecare înregistrare
    }
    ?>
</div>
<div class="program-box4">
        <p>Programe cu dansatori extra</p>
    <?php
    require_once "dbh.inc.php"; // include the code from dbh.inc.php to establish the database connection

    $query = "SELECT  Distinct P.nume AS nume_program
                FROM dansuri D
                JOIN dans_program DP ON DP.id_dans = D.id_dans
                JOIN programe P ON DP.id_program = P.id_program
                 WHERE D.id_dans IN (SELECT D2.id_dans
                                        FROM dansuri D2
                                        WHERE D2.nr_dansatori >= ( SELECT AVG(nr_dansatori) FROM dansuri )
                                        GROUP BY D2.id_dans)";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch all results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $result) {
        echo "" . $result["nume_program"] . "<br>";

    }
    ?>
</div>   
    
<div class="program-box4">
        <p>Scolile White din programe</p>
    <?php
    require_once "dbh.inc.php"; // include the code from dbh.inc.php to establish the database connection

    $query = "SELECT DISTINCT D.scoala
                FROM dansuri D
                JOIN dans_program DP ON DP.id_dans = D.id_dans
                JOIN programe P ON DP.id_program = P.id_program
                WHERE P.id_program IN ( SELECT P2.id_program
                                        FROM programe P2
                                         WHERE P2.nume = 'White')";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch all results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $result) {
        echo "" . $result["scoala"] . "<br>";

    }
    ?>
</div>     
<button style="padding: 15px 30px; font-size: 16px; border-radius: 10px;" onclick="redirectToBuyTicketPage()">Cumpără Bilet</button>

<script>
    // Funcția care va redirecționa utilizatorul
    function redirectToBuyTicketPage() {
        // Schimbăți adresa URL conform necesităților dvs.
        window.location.href = "cumpara.php";
    }
</script>

    
</body>
</html>
