<?php

try {if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "dbh.inc.php";
    // Colectează datele din formular
    $username = $_POST["username"];
    $nume= $_POST["nume"];

    $query = "SELECT S.id_spectator, P.id_program 
                 FROM spectatori S, programe  P
                 WHERE S.username = :username and P.nume=:nume ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":nume", $nume);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result){

        $id_spectator = $result['id_spectator'];
        $id_program = $result['id_program'];

        $query = "DELETE FROM  recenzii  where id_spectator = :id_spectator and id_program=:id_program ";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id_spectator", $id_spectator);
        $stmt->bindParam(":id_program", $id_program);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Utilizatorul și parola sunt valide
        //echo "update reusit!";
        echo '<div style="color: green; text-align: center; font-size: 100px;">Recenzie stearsa cu succes!</div>';
        echo '<script>
                setTimeout(function() {
                    window.location.href = "review.php";
                }, 1500); // Redirecteaza catre review.php dupa 1.5 secunde
              </script>';
        exit();
    } else {
        // Utilizator negasit
        echo '<div style="color: red; text-align: center; font-size: 20px;">Datele introduse nu sunt valide!!!</div>';
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
    <title>Sterge o recenzie</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    
    <div class="login">
	<h2>Sterge o recenzie</h2><br>
    <form id="register" method="post" action="delete_review.php">
        <label><b>Username
        </b>
        </label>
        <input type="text" name="username" id="username">
        <br><br>
        <label><b>Nume program artistic
        </b>
        </label>
        <input type="text" name="nume" id="nume">
        <br><br>
        <button type="submit" class="lbutton">Posteaza</button>
        <br><br>
        <a href="review.php"><-Back</a>
        <br><br>
		
    </form>
</div>
</body>
</html>