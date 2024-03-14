<?php

try {if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "dbh.inc.php";
    // Colectează datele din formular
    $username = $_POST["username"];
    $nume= $_POST["nume"];
    $loc= $_POST["loc"];

    $query1 = "SELECT id_spectator FROM spectatori  WHERE username = :username ";
    $stmt = $pdo->prepare($query1);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result1 = $stmt->fetch(PDO::FETCH_ASSOC);

    $query2 = "SELECT id_program FROM programe  WHERE nume = :nume ";
    $stmt = $pdo->prepare($query2);
    $stmt->bindParam(":nume", $nume);
    $stmt->execute();
    $result2 = $stmt->fetch(PDO::FETCH_ASSOC);

    $query3 = "SELECT S.username, P.nume
                FROM  bilete B
                JOIN spectatori S ON S.id_spectator = B.id_spectator
                JOIN programe P ON P.id_program = B.id_program
                WHERE S.username = :username  and P.nume = :nume";

    $stmt = $pdo->prepare($query3);
    
    $stmt->bindParam(":nume", $nume);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result3 = $stmt->fetch(PDO::FETCH_ASSOC);

    $query4 = "SELECT P1.nume, P1.nr_bilete - COUNT(B.id_bilet) AS bil
                FROM programe P1
                LEFT JOIN bilete B ON B.id_program = P1.id_program
                WHERE P1.nume = :nume
                GROUP BY P1.nume, P1.nr_bilete";

$stmt = $pdo->prepare($query4);
$stmt->bindParam(":nume", $nume);
$stmt->execute();
$result4 = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result1){

        if($result2){

            if($result3){
                echo '<div style="color: red; text-align: center; font-size: 20px;">Biletul a fost deja cumparat de catre dumeavoastra!!!</div>';
                echo '<script>
                setTimeout(function() {
                    document.querySelector("div").style.display = "none";
                }, 5000);
                </script>'; }
            else{
                if(!empty($result4['bil']) ){
                    $query = "INSERT INTO bilete (id_program, id_spectator,loc) VALUES (:id_program,:id_spectator, :loc)";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':id_program', $result2['id_program']);
                        $stmt->bindParam(':id_spectator', $result1['id_spectator']); // Folosim hash-ul parolei
                        $stmt->bindParam(':loc', $loc);
                        $stmt->execute();
                    echo '<div style="color: green; text-align: center; font-size: 100px;">Bilet achizitionat cu succes!</div>';
                    echo '<script>
                            setTimeout(function() {
                                window.location.href = "ticket.php";
                            }, 1500); // Redirecteaza catre ticket.php dupa 1.5 secunde
                            </script>';
                    exit();
                }
                else{ echo '<div style="color: red; text-align: center; font-size: 20px;">Program sold-out!!!</div>';
                    echo '<script>
                    setTimeout(function() {
                        document.querySelector("div").style.display = "none";
                    }, 5000);
                </script>'; }


            }
            }
        else{
            echo '<div style="color: red; text-align: center; font-size: 20px;">Program inexistent!!!</div>';
            echo '<script>
            setTimeout(function() {
                document.querySelector("div").style.display = "none";
            }, 5000);
        </script>'; 
        }
    }
     else {
        // Utilizator negasit
        echo '<div style="color: red; text-align: center; font-size: 20px;">Utilizator inexistent!!!</div>';
        echo '<script>
            setTimeout(function() {
                document.querySelector("div").style.display = "none";
            }, 5000);
        </script>';
    }

    
}
    
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Cumpara Bilet</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    
    <div class="login">
	<h2>Cumpara bilet</h2><br>
    <form id="update" method="post" action="cumpara.php">
        <label><b>Username
        </b>
        </label>
        <input type="text" name="username" id="username" >
        <br><br>
        <label><b> Nume Program
        </b>
        </label>
        <input type="nume" name="nume" id="nume">
        <br><br>
        <label><b> Loc in sala
        </b>
        </label>
        <input type="text" name="loc" id="loc">
        <br><br>
        <button type="submit" class="lbutton">Cumpara</button>
        <br><br>
        <a href="ticket.php"><-Back</a>
        <br><br>
		
    </form>
</div>
</body>
</html>